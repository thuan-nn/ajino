<?php

namespace App\Supports\Traits;

trait HandleUrlVideo
{
    /**
     * @param $videoUrl
     * @return string
     */
    private function handleUrlVideo($videoUrl)
    {
        parse_str(parse_url($videoUrl, PHP_URL_QUERY), $params);

        return (string) 'https://www.youtube.com/embed/'.$params['v'].'?enablejsapi=1&controls=0&fs=0&iv_load_policy=3&rel=0&showinfo=0&loop=1&start=1&vq=hd720&playlist='.$params['v'];
    }
}
