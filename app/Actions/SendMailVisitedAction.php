<?php

namespace App\Actions;

use App\Builders\CompanyTourBuilder;
use App\Enums\VisitorStatusEnum;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class SendMailVisitedAction
{
    /**
     * @var \App\Builders\VisitorBuilder
     */
    protected $visitors;

    public function execute()
    {
        $this->visitors = $this->visitorInApprovedStatus();

        DB::beginTransaction();

        try {

            $this->sendMail();

            $this->updateVisitorStatus();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            throw new $exception->getMessage();
        }
    }

    private function updateVisitorStatus()
    {
        $this->visitors->update([
            'status'     => VisitorStatusEnum::VISITED,
            'additional' => [
                'send_mail_visited' => true,
            ],
        ]);
    }

    private function sendMail()
    {
        foreach ($this->visitors->get() as $visitor) {
            $visitor->sendEmail(VisitorStatusEnum::VISITED);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function visitorInApprovedStatus()
    {
        return Visitor::query()
                      ->where('status', VisitorStatusEnum::APPROVED)
                      ->where('additional->send_mail_visited', false)
                      ->whereHas('companyTour', function (CompanyTourBuilder $query) {
                          $query->whereDate('date', '<', now()->toDateString());
                      });
    }
}
