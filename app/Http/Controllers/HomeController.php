<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(){

        $user = Auth::user();
        if($user->hasRole('admin')){
            return redirect()->route('admin');
         }else{
             return redirect()->route('user.dashboard');
         }

    }
}
