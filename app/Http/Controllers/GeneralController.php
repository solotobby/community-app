<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function foodFundraising() {}

    public function aboutUs()
    {
        return view('about-us');
    }

    public function terms()
    {
        return view('terms');
    }

    public function contactUs()
    {
        return view('contact-us');
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function blog() {}
}
