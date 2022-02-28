<?php


namespace App\Actions;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ConvertUrlFileAction {
    public function execute() {
        try {
            $contentUrl = '/Content/upload/images';

            $fileFolderUrl = '/files/uploads/images';

            DB::beginTransaction();

            DB::statement("UPDATE post_translations set content = REPLACE(content, '${contentUrl}', '${fileFolderUrl}')");
            DB::statement("UPDATE setting set value = REPLACE(value, '${contentUrl}', '${fileFolderUrl}')");
            DB::statement("UPDATE job_translations set description = REPLACE(description, '${contentUrl}', '${fileFolderUrl}')");
            DB::statement("UPDATE locations set content = REPLACE(content, '${contentUrl}', '${fileFolderUrl}')");
            DB::statement("UPDATE locations set additional = REPLACE(additional, '${contentUrl}', '${fileFolderUrl}')");
            DB::statement("UPDATE taxonomy_translations set additional = REPLACE(additional, '${contentUrl}', '${fileFolderUrl}')");

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}