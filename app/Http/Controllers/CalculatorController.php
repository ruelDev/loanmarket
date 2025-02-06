<?php

namespace App\Http\Controllers;

use App\Models\ROS;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index() {
        $data = config('data');
        $ros = ROS::get();

        return view('pages.user.calculator', compact(['ros', 'data']));
    }

    public function calculateSavings(Request $request){
        dd($request);
    }
}
