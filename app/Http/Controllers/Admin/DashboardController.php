<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brokers;
use App\Models\ClientRecord;
use App\Models\Lenders;
use App\Models\ROS;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {

        $ros = ROS::count();
        $lenders = Lenders::count();
        $brokers = Brokers::count();
        $clients = ClientRecord::count();

        $card = [
            'Real Estate Offices' => $ros,
            'Lenders' => $lenders,
            'Brokers' => $brokers,
            'Clients' => $clients,
        ];

        return view('pages.admin.dashboard', compact('card'));
    }
}
