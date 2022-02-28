<?php

namespace App\Actions;

use App\Enums\VisitorStatusEnum;
use App\Mail\VisitorMail;
use App\Models\CompanyTour;
use App\Models\Location;
use App\Models\MailHistory;
use Illuminate\Support\Facades\DB;

class DeleteCompanyTourAction
{
    /**
     * @var
     */
    private $mailContent;

    /**
     * @param \App\Models\CompanyTour $companyTour
     * @param string $locale
     * @throws \Exception
     */
    public function execute(CompanyTour $companyTour, string $locale)
    {
        DB::beginTransaction();

        try {
            $visitorInTour = $companyTour->visitors()->where('status', '<>', VisitorStatusEnum::REGISTERED)->get();

            $location = $companyTour->location;

            if (count($visitorInTour) !== 0) {
                foreach ($visitorInTour as $visitor) {
                    $mailHistoryData = $this->getMailHistoryData($companyTour, $visitor);
                    $visitor->sendEmail(VisitorStatusEnum::CANCEL, [], $locale, $mailHistoryData, $location);
                }
            }
            $companyTour->visitors()->delete();
            $companyTour->delete();
            DB::commit();
        } catch (\HttpException $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }

    /**
     * @param \App\Models\CompanyTour $companyTour
     * @param $visitor
     * @return mixed
     */
    private function getMailHistoryData(CompanyTour $companyTour, $visitor)
    {
        return [
            'email'           => $visitor->email,
            'status'          => VisitorStatusEnum::CANCEL,
            'company_tour_id' => $companyTour->id,
        ];
    }
}
