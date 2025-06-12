<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function foodFundraising(){

    }

    public function aboutUs(){
        return view('about-us');
    }

    public function blog(){

    }
}
