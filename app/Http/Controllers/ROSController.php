<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ROSController extends Controller
{
    public function index($id) {
        $data = config('data')['ros'][$id];
        // dd($data);
        return view('pages.user.ros', compact('data'));
    }
}
