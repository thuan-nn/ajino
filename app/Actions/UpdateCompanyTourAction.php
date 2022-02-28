<?php

namespace App\Actions;

use App\Models\CompanyTour;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateCompanyTourAction
{
    /**
     * @var
     */
    private $date;

    public function execute($data)
    {
        $this->date = Arr::get($data, 'date');

        $companyTourData = $this->handledCompanyTourData($data);

        DB::beginTransaction();
        try {
            foreach ($companyTourData as $companyTourDatum) {
                CompanyTour::query()->updateOrCreate([
                    'id'   => $companyTourDatum['id'],
                    'date' => $this->date,
                ], $companyTourDatum);
            }

            DB::commit();
        } catch (\HttpException $httpException) {
            DB::rollBack();
            throw new $httpException;
        }
    }

    /**
     * @param $data
     * @return array|array[]
     */
    private function handledCompanyTourData($data)
    {
        $tours = Arr::get($data, 'tours');

        $locationId = Arr::get($data, 'location_id');

        $result = [];

        foreach ($tours as $tour) {
            $companyTourId = Arr::get($tour, 'id');

            $tour['id'] = $companyTourId ?: Str::uuid();
            $tour['date'] = $this->date;
            $tour['location_id'] = $locationId;

            if (Carbon::parse($this->date)->lessThanOrEqualTo(now()->startOfDay())) {
                $tour = [
                    'id'                 => $companyTourId,
                    'date'               => $this->date,
                    'participant_amount' => $tour['participant_amount'],
                ];
            }

            $result[] = $tour;
        }

        return $result;
    }
}
