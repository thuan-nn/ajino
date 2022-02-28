<?php

namespace App\Actions;

use App\Enums\LanguageEnum;
use App\Enums\VisitorStatusEnum;
use App\Models\CompanyTour;
use App\Models\Visitor;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateMultipleStatusVisitorAction
{
    public function execute($data, $locale = LanguageEnum::VI)
    {
        $visitorIds = Arr::get($data, 'visitor_ids');

        $status = Arr::get($data, 'status');

        $isSendEmail = Arr::get($data, 'is_send_mail');

        $visitors = Visitor::query()->whereIn('id', $visitorIds);

        $this->saveData($isSendEmail, $visitors, $status, $locale, $visitorIds);
    }

    /**
     * @param $visitorIds
     * @return array
     */
    public function groupSelectedVisitorByCompanyTour($visitorIds)
    {
        $visitors = Visitor::query()
                           ->whereIn('visitors.id', $visitorIds)
                           ->get();

        return $visitors->groupBy('company_tour_id')->toArray();
    }

    /**
     * @param $visitors
     * @param $status
     * @param $locale
     * @param $location
     */
    private function sendMail($visitors, $status, $locale, $location)
    {
        $visitors->get()->each(function ($visitor) use ($status, $locale, $location) {
            $visitor->sendEmail($status, [], $locale, null, $location);
        });
    }

    /**
     * @param $isSendEmail
     * @param $visitors
     * @param $status
     * @param $locale
     * @param $visitorIds
     */
    private function saveData($isSendEmail, $visitors, $status, $locale, $visitorIds)
    {
        DB::beginTransaction();

        try {
            // find visitor by company tour id
            $groupCompanyTours = $this->groupSelectedVisitorByCompanyTour($visitorIds);

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

                // set New Amount Visitor
                $newAmountVistors = $this->calculateAmountVisitor($status, $currentAmountFromDB, $mountVisitor);

                // update new Amount
                $companyTour = CompanyTour::query()
                                          ->find($companyTourId);

                $companyTour->update(['registry_amount' => $newAmountVistors]);

                if ($isSendEmail) {
                    $location = $companyTour->location;
                    $this->sendMail($visitors, $status, $locale, $location);
                }
            }

            // update status for Visitors
            $visitors->update(['status' => $status]);

            DB::commit();
        } catch (\HttpException $exception) {
            DB::rollBack();

            throw new $exception->getMessage();
        }
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
            case VisitorStatusEnum::VISITED:
                return $currentAmountFromDB + $mountVisitor;
            default:
                return $currentAmountFromDB;
        }
    }
}
