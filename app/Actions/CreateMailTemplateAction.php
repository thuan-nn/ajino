<?php

namespace App\Actions;

use App\Models\MailTemplate;
use Illuminate\Support\Facades\DB;

class CreateMailTemplateAction
{
    /**
     * @param $data
     *
     * @return mixed
     */
    public function execute($data)
    {
        $mailTemplate = new MailTemplate();

        DB::beginTransaction();
        try {
            $mailTemplate = $mailTemplate->create($data);

            DB::commit();
        } catch (\HttpException $httpException) {
            DB::rollBack();
            throw new $httpException->getMessage();
        }

        return $mailTemplate;
    }
}
