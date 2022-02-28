<?php

namespace App\Actions;

use App\Models\VisitorFileSetting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateVisitorFileSettingAction
{
    /**
     * @var string
     */
    protected $type;

    protected $isActive;

    public function execute($data, VisitorFileSetting $visitorFileSetting)
    {
        $this->type = Arr::get($data, 'type');
        $this->isActive = Arr::get($data, 'is_active');
        $oldVisitorFileSetting = VisitorFileSetting::query()->where('type', $this->type);

        DB::beginTransaction();
        try {

            if ($oldVisitorFileSetting->count() !== 0) {
                $oldVisitorFileSetting->update(['is_active' => false]);
            }

            $visitorFileSetting->update($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }
}
