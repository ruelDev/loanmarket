<?php

namespace App\Http\Controllers;

use App\Models\ROS;
use Illuminate\Http\Request;

class ROSController extends Controller
{
    public function index($name) {
        $data = ROS::where('name', $name)->first();
        return view('pages.user.ros', compact('data'));
    }
}
