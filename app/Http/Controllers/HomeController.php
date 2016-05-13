<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Container\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends BaseController
{
    public function index()
    {
        return view('home.home');    
    }
    
}
