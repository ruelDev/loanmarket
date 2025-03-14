<?php

namespace App\Http\Controllers;

use App\Models\ClientRecord;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function store(Request $request) {

        try {
            ClientRecord::insert([
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'broker_id' => null,
                    'created_at' => now('Asia/Manila'),
                ]
            ]);

            return response()->json(['success' => 'Client details saved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }
}
