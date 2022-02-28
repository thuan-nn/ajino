<?php

namespace App\Actions;

use App\Models\Contact;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CreateContactUsAction
{
    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function execute($data)
    {
        $fileId = Arr::get($data, 'fileId');

        DB::beginTransaction();
        try {
            $contact = Contact::query()->create($data);

            $contact->files()->sync($fileId);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }

        return $contact;
    }
}
