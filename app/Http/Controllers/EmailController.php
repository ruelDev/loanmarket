<?php

namespace App\Http\Controllers;

use App\Mail\BecomePartnerEmail;
use App\Mail\FeedbackEmail;
use App\Mail\RequestCallEmail;
use App\Models\ClientLenders;
use App\Models\ClientRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class EmailController extends Controller
{
    public function requestEmail(Request $request)
    {
        $topLenders = Session::get('top_lenders');

        ClientRecord::insert([
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'broker_id' => null
            ]
        ]);

        $client = ClientRecord::where('name', $request->name)
            ->where('email', $request->email)
            ->where('phone', $request->phone)
            ->first();

        foreach($topLenders as $lender) {
            ClientLenders::insert([
                [
                    'client_id' => $client->id,
                    'property_address' => $lender['propertyAddress'],
                    'property_value' => $lender['propertyValue'],
                    'lender' => $lender['lender'],
                    'loan_type' => $lender['type'],
                    'loan_rate' => $lender['rate'],
                    'loan_term' => $lender['term'],
                    'monthly' => $lender['monthly'],
                    'savings' => $lender['savings'],
                    'created_at' => now()
                ]
            ]);
        }

        $messageContent = "Hi, we have received your request and will call you within 2 business days. In the meantime, please find below a summary of Your Home Loan Review.";

        Mail::to($request->email)->send(new RequestCallEmail([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'broker_id' => null,
            'top_lenders' => $topLenders,
        ], $messageContent));

        return response()->json(['success' => 'Email sent successfully!']);
    }

    public function becomePartnerEmail(Request $request) {

        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new BecomePartnerEmail([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ], $request->message));

        return response()->json(['success' => 'Email sent successfully!']);
    }

    public function feedbackEmail(Request $request) {

        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new FeedbackEmail([
            'name' => $request->name,
            'email' => $request->email,
            'feedback' => $request->message,
        ]));

        return response()->json(['success' => 'Feedback sent successfully!']);
    }
}
