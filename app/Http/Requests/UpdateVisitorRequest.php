<?php

namespace App\Http\Requests;

use App\Enums\LocationEnum;
use App\Enums\MajorEnum;
use App\Enums\VisitorStatusEnum;
use App\Models\CompanyTour;
use App\Models\Visitor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVisitorRequest extends FormRequest
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
        $visitor = $this->route('visitor');
        $validation = [
            'company_tour_id' => ['required', 'exists:company_tours,id'],
            'name'            => 'required|string',
            'address'         => 'required|string',
            'email'           => 'required|string|email',
            'phone_number'    => 'required|string|max:11',
            'majors'          => ['required', Rule::in(MajorEnum::asArray())],
            'job_location'    => 'required|string',
            'city'            => ['required', Rule::exists('locations', 'id')->where('type', LocationEnum::JOB)],
            'status'          => ['required', Rule::in(VisitorStatusEnum::asArray())],
            'additional'      => 'nullable|array',
            'note'            => 'nullable|string',
            'is_send_mail'    => 'boolean',
        ];
        if (in_array($this->status, [
                VisitorStatusEnum::WAITING,
                VisitorStatusEnum::APPROVED,
            ])) {
            $validation['amount_visitor'] = 'required|integer|max:'.$this->amountPeople().'|min:1';
        }

        if ($this->status === VisitorStatusEnum::REGISTERED) {
            $validation['amount_visitor'] = 'required|integer|min:1';
        }

        return $validation;
    }

    /**
     * @return int
     */
    private function amountPeople(): int
    {
        $visitor = $this->route('visitor');

        $companyTour = CompanyTour::query()->find($this->company_tour_id);

        $visitors = Visitor::query()
                           ->select('amount_visitor')
                           ->where('company_tour_id', $this->company_tour_id)
                           ->where('id', '<>', $visitor->id)
                           ->whereIn('status', [
                               VisitorStatusEnum::WAITING,
                               VisitorStatusEnum::APPROVED,
                               VisitorStatusEnum::VISITED,
                           ])
                           ->get();

        $amountVisitor = $visitors->sum('amount_visitor');

        return $companyTour->people_amount - $amountVisitor;
    }
}
