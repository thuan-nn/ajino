<?php

namespace Database\Seeders;

use App\Enums\CompanyVisitLocation;
use App\Enums\LocationEnum;
use App\Models\Location;
use Flugg\Responder\Exceptions\Http\HttpException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        //Seeding Location Job
        $jobLocations = array_merge($this->handleDataJobLocation(), $this->handleDataCarrerLocation());

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::beginTransaction();

        try {
            Location::query()->truncate();
            DB::table('locations')->insert($jobLocations);
            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } catch (HttpException $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }

    /**
     * @return array|array[]
     */
    private function handleDataJobLocation()
    {
        $locations = file_get_contents('app/Supports/location.json');

        $data = json_decode($locations, true);

        return array_map(function ($item) {
            $item = Arr::only($item, ['name', 'code']);
            $item['type'] = LocationEnum::JOB;
            $item['id'] = Str::uuid();
            $item['facebook_url'] = null;
            $item['address'] = null;
            $item['phone'] = null;
            $item['email'] = null;

            return $item;
        }, $data);
    }

    /**
     * @return array
     */
    private function handleDataCarrerLocation()
    {
        $data = [];
        $locations = CompanyVisitLocation::asArray();
        foreach ($locations as $name) {
            array_push($data, [
                'id'           => Str::uuid(),
                'name'         => CompanyVisitLocation::getDescription($name),
                'type'         => LocationEnum::VISIT,
                'code'         => null,
                'facebook_url' => 'https://facebook.com',
                'address'      => 'facebook',
                'phone'        => '0986343944',
                'email'        => 'facebook@facebook.com',
            ]);
        }

        return $data;
    }
}
