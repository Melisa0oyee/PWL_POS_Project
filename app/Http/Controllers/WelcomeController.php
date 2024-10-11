<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $braedcrumb = (object) [
            'title' => 'Selamat Datang',
            'list'  => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        return view('welcome', ['breadcrumb' => $braedcrumb, 'activeMenu' => $activeMenu]);
    }

    public function level() 
    {
        return view('level', ['activeMenu' => 'level']);
    }
}
