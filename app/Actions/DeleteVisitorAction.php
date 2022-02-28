<?php

namespace App\Actions;

use App\Enums\VisitorStatusEnum;
use App\Mail\VisitorMail;
use App\Models\MailHistory;
use App\Models\Visitor;
use App\Supports\Traits\HandleMailHistoryData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DeleteVisitorAction
{
    use HandleMailHistoryData;

    /**
     * @param \App\Models\Visitor $visitor
     */
    public function execute(Visitor $visitor)
    {
        DB::beginTransaction();

        try {
            $location = optional($visitor->companyTour)->location;
            $visitor->companyTour()
                    ->update([
                        'registry_amount' => ($visitor->companyTour->registry_amount - $visitor->amount_visitor),
                    ]);
            $visitor->delete();
            $history = $this->mailHistoryData($visitor, VisitorStatusEnum::DENY);
            $visitor->sendEmail(VisitorStatusEnum::DENY, [], null, $history, $location);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception->getMessage();
        }
    }
}
