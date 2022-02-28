<?php

namespace App\Rules;

use App\Enums\VisitorStatusEnum;
use App\Models\Visitor;
use Illuminate\Contracts\Validation\Rule;

class VisitorStatusRule implements Rule
{
    protected $parameters;

    /**
     * Create a new rule instance.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->parameters = $request->all();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $visitors = $this->getVisitors($this->parameters['visitor_ids']);

        $isAllowStatus = $this->isAllowStatus($visitors, $value);

        $isSameStatus = $this->validateSameStatus($visitors);

        if (! $isAllowStatus || ! $isSameStatus) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Status is not allowed!';
    }

    /**
     * @param $visitorIds
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getVisitors($visitorIds)
    {
        return Visitor::query()
                      ->select('status')
                      ->whereIn('id', $visitorIds)
                      ->get();
    }

    /**
     * @param $visitors
     * @return mixed
     */
    private function validateSameStatus($visitors)
    {
        $firstStatus = optional($visitors->first())->status;

        return $visitors->every(function ($item) use ($firstStatus) {
            return $item->status === $firstStatus;
        });
    }

    /**
     * @param $visitors
     * @param $value
     * @return mixed
     */
    private function isAllowStatus($visitors, $value)
    {
        $selectedCode = VisitorStatusEnum::getCodeStatus($value);

        return $visitors->reduce(function ($items, $item) use ($selectedCode, $value) {
            if (VisitorStatusEnum::getCodeStatus($item->status) > $selectedCode) {
                return false;
            }

            return true;
        }, false);
    }
}
