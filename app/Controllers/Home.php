<?php

namespace App\Controllers;

class Home extends BaseController
{
    function __construct()
    {
        // helper('functions');
        // if (!session('id')) {
        //     gagal(base_url('login'), 'Please Login!.');
        // }
        // check_role();
    }
    public function index(): string
    {
        dd(url());
        return view('home', ['judul' => 'Home']);
    }
}
