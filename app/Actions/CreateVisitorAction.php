<?php

namespace App\Actions;

use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class CreateVisitorAction
{
    /**
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function execute($data)
    {
        DB::beginTransaction();
        try {
            $visitor = Visitor::query()->create($data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }

        return $visitor;
    }
}
