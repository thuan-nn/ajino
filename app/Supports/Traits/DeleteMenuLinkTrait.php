<?php

namespace App\Supports\Traits;

trait DeleteMenuLinkTrait
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    private function deleteMenuLinks()
    {
        $this->getMenuLinks()->each->delete();
    }

    /**
     * @return mixed
     */
    private function getMenuLinks()
    {
        return $this->model->menuLinks()->translatedIn($this->locale)->get();
    }
}
