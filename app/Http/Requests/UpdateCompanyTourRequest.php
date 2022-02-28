<?php

namespace App\Http\Requests;

use App\Enums\LocationEnum;
use App\Enums\TourType;
use App\Rules\FactoryTourPage;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateCompanyTourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location_id'                => [
                'filled',
                new FactoryTourPage()
            ],
            'date'                       => [
                'required',
                'string',
                'date',
                'date_format:Y-m-d',
            ],
            'tours'                      => 'filled|array',
            'tours.*.id'                 => 'nullable|string|exists:company_tours,id',
            'tours.*.type'               => [
                'filled',
                Rule::in(TourType::asArray()),
            ],
            'tours.*.description'        => 'nullable|string',
            'tours.*.people_amount'      => 'filled|integer',
            'tours.*.registry_amount'    => 'nullable|integer',
            'tours.*.participant_amount' => 'nullable|integer',
            'tours.*.is_cancel'          => 'boolean',
        ];
    }

    /**
     * @param $validator
     */
    public function withValidator($validator)
    {

        $date = $this->get('date');

        $validator->after(function ($validator) use ($date) {
            $tours = $this->get('tours');

            if (Carbon::parse($date)->lessThanOrEqualTo(now()->endOfDay())) {
                foreach ($tours as $key => $tour) {
                    $tourId = Arr::get($tour, 'id');
                    $participant = Arr::get($tour, 'participant_amount');
                    if (! is_null($tourId)) {
                        if (is_null($participant)) {
                            $validator->errors()->add('message', 'The participant amount '.$key.' is required');
                        }
                    }
                }
            }
        });
    }
}
