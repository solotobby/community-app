<?php

namespace App\Http\Controllers;

use App\Mail\GenericMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail($to, $subject, $message)
    {
        Mail::to($to)->send(new GenericMail($subject, $message));

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Mail sent successfully'
        // ]);
        return true;
    }
}
