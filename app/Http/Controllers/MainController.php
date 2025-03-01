<?php

namespace App\Http\Controllers;

use App\Models\ROS;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        $data = config('data');
        $ros = ROS::whereNull('deleted_at')->get();

        return view('pages.user.main', compact(['ros', 'data']));
    }
}
