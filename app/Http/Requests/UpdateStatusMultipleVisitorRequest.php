<?php

namespace App\Http\Requests;

use App\Enums\VisitorStatusEnum;
use App\Models\CompanyTour;
use App\Models\Visitor;
use App\Rules\VisitorStatusRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateStatusMultipleVisitorRequest extends FormRequest
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
            'visitor_ids'   => 'required|array',
            'visitor_ids.*' => 'required|exists:visitors,id',
            'is_send_mail'  => 'boolean',
            'status'        => [
                'string',
                Rule::in(VisitorStatusEnum::asArray()),
                new VisitorStatusRule($this->request),
            ],
        ];
    }

    /**
     * @param $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $checkAllow = $this->checkAllowAmountVisitor();

            if (! $checkAllow) {
                $validator->errors()->add('message', 'Amount visitor not allow!');
            }
        });
    }

    /**
     * @return int
     */
    private function checkAllowAmountVisitor()
    {
        $groupCompanyTours = $this->groupVisitorByCompanyTour();

        $isAllow = false;

        foreach ($groupCompanyTours as $companyTourId => $visitorArray) {
            $mountVisitor = collect($visitorArray)->sum('amount_visitor');

            // get visitor Id
            $visitorIds = array_map(function ($item) {
                return Arr::get($item, 'id');
            }, $visitorArray);

            // get Current Amount not include selected Visitors
            $currentAmountFromDB = Visitor::query()
                                          ->where('company_tour_id', $companyTourId)
                                          ->whereNotIn('id', $visitorIds)
                                          ->whereIn('status', [
                                              VisitorStatusEnum::WAITING,
                                              VisitorStatusEnum::APPROVED,
                                              VisitorStatusEnum::VISITED,
                                          ])
                                          ->sum('amount_visitor');

            $companyTour = CompanyTour::query()->find($companyTourId);
            $limitAmmout = $companyTour->people_amount;

            // set New Amount Visitor
            $newAmount_vistors = $this->calculateAmountVisitor($this->status, $currentAmountFromDB, $mountVisitor);

            if ($newAmount_vistors > $limitAmmout) {
                $isAllow = false;

                break;
            }

            $isAllow = true;
        }

        return $isAllow;
    }

    /**
     * @return array
     */
    private function groupVisitorByCompanyTour()
    {
        $visitors = Visitor::query()
                           ->whereIn('visitors.id', $this->visitor_ids)
                           ->get();

        return $visitors->groupBy('company_tour_id')->toArray();
    }

    /**
     * @param $status
     * @param $currentAmountFromDB
     * @param $mountVisitor
     * @return mixed
     */
    private function calculateAmountVisitor($status, $currentAmountFromDB, $mountVisitor)
    {
        switch ($status) {
            case VisitorStatusEnum::WAITING:
            case VisitorStatusEnum::APPROVED:
                return $currentAmountFromDB + $mountVisitor;
            default:
                return $currentAmountFromDB;
        }
    }
}
