<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brokers;
use App\Models\ClientRecord;
use App\Models\Lenders;
use App\Models\ROS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {

        $ros = ROS::count();
        $lenders = Lenders::count();
        $brokers = Brokers::count();
        $clients = ClientRecord::count();

        return view('pages.admin.dashboard', compact('ros', 'lenders', 'brokers', 'clients'));
    }

    public function logout(Request $request) {
        // auth()->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('home'));
        return redirect(url('/'));
    }
}
