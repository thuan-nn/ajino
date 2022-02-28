<?php

namespace App\Actions;

use App\Enums\LanguageEnum;
use App\Enums\VisitorFileType;
use App\Enums\VisitorStatusEnum;
use App\Models\Location;
use App\Models\Visitor;
use App\Models\VisitorFileSetting;
use App\Supports\Traits\HandleMailHistoryData;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateVisitorAction
{
    use HandleMailHistoryData;

    /**
     * @var
     */
    protected $companyTourRegisTry;

    /**
     * @var
     */
    protected $status;

    /**
     * @param $data
     * @param \App\Models\Visitor $visitor
     * @param string $locale
     * @throws \Exception
     */
    public function execute($data, Visitor $visitor, $locale = LanguageEnum::VI)
    {
        $this->status = Arr::get($data, 'status');
        $oldStatus = $visitor->status;
        $isSendEmail = Arr::get($data, 'is_send_mail');

        DB::beginTransaction();
        try {
            $visitor->update($data);

            $this->companyTourRegisTry = $this->getTotalAmountRegistry($visitor);

            $this->updateCompanyTour($visitor);

            $mailHistoryData = $this->mailHistoryData($visitor, $this->status);

            $location = Location::find($visitor->companyTour->location_id);

            if ($oldStatus !== $this->status && $isSendEmail) {
                $PDFFile = $this->getPDFFilePath($visitor->companyTour->type);
                $excelFile = $this->getExcelFilePath();
                $visitor->sendEmail($this->status, [$PDFFile, $excelFile], $locale, $mailHistoryData, $location);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }

    /**
     * @param $visitor
     * @return mixed
     */
    private function getTotalAmountRegistry($visitor)
    {
        $companyTourId = $visitor->companyTour->id;

        $amountVisitors = Visitor::query()->select('amount_visitor')
                                 ->where('company_tour_id', $companyTourId)
                                 ->whereIn('status', [VisitorStatusEnum::WAITING, VisitorStatusEnum::APPROVED, VisitorStatusEnum::VISITED])
                                 ->get();

        return $amountVisitors->sum('amount_visitor');
    }

    /**
     * @param \App\Models\Visitor $visitor
     */
    private function updateCompanyTour(Visitor $visitor)
    {
        $visitor->companyTour()->update(['registry_amount' => $this->companyTourRegisTry]);
    }

    /**
     * @param $tourType
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed|null
     */
    private function getPDFFilePath($tourType)
    {
        $visitorFilSetting = VisitorFileSetting::query()
                                               ->where('type', $tourType)
                                               ->where('is_active', true)
                                               ->first();

        return ! is_null($visitorFilSetting) ? $visitorFilSetting->files->first()->path : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed|null
     */
    private function getExcelFilePath()
    {
        $visitorFilSetting = VisitorFileSetting::query()
                                               ->where('type', VisitorFileType::INFO_VISITORS)
                                               ->where('is_active', true)
                                               ->first();

        return ! is_null($visitorFilSetting) ? $visitorFilSetting->files->first()->path : null;
    }
}
