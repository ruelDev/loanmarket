<?php

namespace App\Http\Controllers;

use App\Mail\RequestCallEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function requestEmail()
    {
        $clientName = "Ruel Lobo";
        $messageContent = "Hi, we received your request and will call you back soon.";

        Mail::to('ruellobo.04@gmail.com')->send(new RequestCallEmail($clientName, $messageContent));

        return response()->json(['success' => 'Email sent successfully!']);
    }
}
