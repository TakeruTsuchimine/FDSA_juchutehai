<?php

namespace App\Http\Controllers;

class MainViewController extends Controller
{
    public function index()
    {
        return view('index', [
            "loginName" => "システム管理者",
            "pageTitle" => "メニュー"
        ]);
    }
}