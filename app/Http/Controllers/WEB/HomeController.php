<?php

namespace App\Http\Controllers\WEB;

use App\ViewModels\HomeViewModel;

class HomeController extends BaseWebController
{
    public function index()
    {
        return (new HomeViewModel($this->globalData))->view('web.page.home');
    }
}
