<?php


namespace App\Actions;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class MigrateContentAction {
    public function execute() {
        try {
            $stagingUrl = config('app.APP_STAGING_URL');
            $url = config('app.url');
            $stagingSubUrl = config('app.APP_STAGING_SUBURL');

            DB::beginTransaction();

            DB::statement("UPDATE post_translations set content = REPLACE(content, '${stagingUrl}', '${url}')");
            DB::statement("UPDATE banner_translations set additional = REPLACE(additional, '${stagingUrl}', '${url}')");
            DB::statement("UPDATE menulink_translations set url = REPLACE(url, '${stagingUrl}', '${url}')");
            DB::statement("UPDATE setting set value = REPLACE(value, '${stagingUrl}', '${url}')");
            DB::statement("UPDATE job_translations set description = REPLACE(description, '${stagingUrl}', '${url}')");
            DB::statement("UPDATE locations set content = REPLACE(content, '${stagingUrl}', '${url}')");
            DB::statement("UPDATE locations set additional = REPLACE(additional, '${stagingUrl}', '${url}')");
            DB::statement("UPDATE banner_item_translations set description = REPLACE(description, '${stagingUrl}', '${url}')");
            DB::statement("UPDATE taxonomy_translations set additional = REPLACE(additional, '${stagingUrl}', '${url}')");

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}