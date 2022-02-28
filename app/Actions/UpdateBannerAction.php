<?php

namespace App\Actions;

use App\Models\Banner;
use App\Models\BannerItem;
use App\Supports\Traits\HandleBannerData;
use App\Supports\Traits\HandleTranslations;
use App\Supports\Traits\HandleUrlVideo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateBannerAction
{
    use HandleTranslations, HandleUrlVideo, HandleBannerData;

    /**
     * @param $data
     *
     * @param Banner $banner
     * @param $locale
     * @return mixed
     * @throws \HttpException
     */
    public function execute($data, Banner $banner, $locale)
    {
        DB::beginTransaction();
        try {
            $dataBanner = $this->handleData($data, (string) $locale, $banner);
            $banner->update($dataBanner);

            DB::commit();
        } catch (\HttpException $httpException) {
            DB::rollBack();
            throw new $httpException;
        }
    }
}
