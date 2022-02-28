<?php

namespace App\Actions;

use App\Models\Contact;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateContactUsAction
{
    /**
     * @param $data
     * @param \App\Models\Contact $contact
     */
    public function execute($data, Contact $contact)
    {
        $fileId = Arr::get($data, 'fileId');
        DB::beginTransaction();
        try {
            $contact->update($data);

            $contact->files()->sync($fileId);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }
}
