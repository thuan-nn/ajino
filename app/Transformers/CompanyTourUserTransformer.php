<?php

namespace App\Transformers;

use App\Enums\LanguageEnum;
use App\Models\CompanyTour;
use Carbon\Carbon;
use Flugg\Responder\Transformers\Transformer;
use Illuminate\Support\Str;

class CompanyTourUserTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'visitors' => VisitorTransformer::class,
        'location' => LocationTransformer::class,
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param \App\Models\CompanyTour $companyTour
     * @return array
     */
    public function transform(CompanyTour $companyTour)
    {
        return [
            'id'                 => (string) $companyTour->id,
            'type'               => (string) $companyTour->type,
            'name'               => (string) trans('languages.'.Str::upper($companyTour->type), [], request('locale')),
            'date'               => (string) $companyTour->date,
            'day_of_week'        => (string) $this->getDayOfWeek($companyTour->date),
            'people_amount'      => (int) $companyTour->people_amount,
            'registry_amount'    => (int) $companyTour->registry_amount,
            'participant_amount' => (int) $companyTour->participant_amount,
            'is_published'       => (boolean) $companyTour->is_published,
            'is_cancel'          => (boolean) $companyTour->is_cancel,
            'additional'         => $companyTour->additional,
            'created_at'         => $companyTour->created_at,
            'updated_at'         => $companyTour->updated_at,
        ];
    }

    private function getDayOfWeek($day)
    {
        $weekMap = $this->getWeekMap();
        $dayOfTheWeek = Carbon::parse($day)->dayOfWeek;

        return $weekMap[$dayOfTheWeek];
    }

    private function getWeekMap()
    {
        $locale = request('locale');

        switch ($locale) {
            case LanguageEnum::EN:
                return [
                    0 => 'Sunday',
                    1 => 'Monday',
                    2 => 'Tuesday',
                    3 => 'Wednesday',
                    4 => 'Thursday',
                    5 => 'Firday',
                    6 => 'Saturday',
                ];
                break;
            case LanguageEnum::VI:
                return [
                    0 => 'Chủ Nhật',
                    1 => 'Thứ 2',
                    2 => 'Thứ 3',
                    3 => 'Thứ 4',
                    4 => 'Thứ 5',
                    5 => 'Thứ 6',
                    6 => 'Thứ 7',
                ];
                break;
        }
    }
}
