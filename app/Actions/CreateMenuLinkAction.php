<?php

namespace App\Actions;

use App\Models\MenuLink;
use App\Supports\Traits\HandleMenuLinksTranslations;
use Illuminate\Support\Facades\DB;

class CreateMenuLinkAction
{
    use HandleMenuLinksTranslations;

    /**
     * @param $data
     *
     * @param string $locale
     * @return mixed
     * @throws \Throwable
     */
    public function execute($data, string $locale)
    {
        $menuLinkData = $this->handleData($data, $locale, new MenuLink());

        DB::beginTransaction();
        try {
            $insertedData = [];

            foreach ($menuLinkData as $item) {
                $menuLink = new MenuLink();
                $menuLink->fill($item);
                $menuLink->save();
                array_push($insertedData, $menuLink);
            }

            MenuLink::fixTree();

            DB::commit();
        } catch (\HttpException $httpException) {
            DB::rollBack();
            throw new $httpException->getMessage();
        }

        return $insertedData;
    }
}
