<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function welcome() 
    {
        return view('welcome');
    }
}
