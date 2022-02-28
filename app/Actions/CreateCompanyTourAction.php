<?php

namespace App\Actions;

use App\Models\CompanyTour;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateCompanyTourAction
{
    public function execute($data)
    {
        $companyTourData = $this->handledCompanyTourData($data);

        DB::beginTransaction();
        try {
            //$companyTour = CompanyTour::query()->insert($companyTourData);
            $companyTour = DB::table('company_tours')->insert($companyTourData);
            DB::commit();
        } catch (\HttpException $httpException) {
            DB::rollBack();
            throw new $httpException->getMessage();
        }
    }

    /**
     * @param $data
     * @return array|array[]
     */
    private function handledCompanyTourData($data)
    {
        $dates = Arr::get($data, 'dates');

        $tours = Arr::get($data, 'tours');

        $locationId = Arr::get($data, 'location_id');

        $result = [];

        foreach ($dates as $date) {
            foreach ($tours as $tour) {
                $tour['date'] = $date;
                $tour['location_id'] = $locationId;
                $tour['id'] = Str::uuid();
                $result[] = $tour;
            }
        }

        return $result;
    }
}
