<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompareLendersController extends Controller
{
    public function index() {
        $data = config('data');
        return view('pages.user.topLenders', compact('data'));
    }
}
