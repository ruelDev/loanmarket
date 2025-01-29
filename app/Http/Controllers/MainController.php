<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
   public function index() {
        $data = config('data');
        return view('pages.user.main', compact('data'));
    }
}
