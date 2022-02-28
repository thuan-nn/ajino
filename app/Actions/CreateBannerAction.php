<?php

namespace App\Actions;

use App\Models\Banner;
use App\Models\BannerItem;
use App\Supports\Traits\HandleBannerData;
use App\Supports\Traits\HandleTranslations;
use App\Supports\Traits\HandleUrlVideo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CreateBannerAction
{
    use HandleTranslations, HandleUrlVideo, HandleBannerData;

    /**
     * @param $data
     *
     * @param string $locale
     * @return mixed
     * @throws \Throwable
     */
    public function execute($data, $locale)
    {
        DB::beginTransaction();
        try {
            $banner = new Banner();

            $dataBanner = $this->handleData($data, $locale, $banner);

            $banner->create($dataBanner);

            DB::commit();
        } catch (\HttpException $httpException) {
            DB::rollBack();
            throw new $httpException;
        }
    }
}