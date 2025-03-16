<?php

namespace App\Http\Controllers\Admin;

use App\Models\ROS;
use App\Models\Brokers;
use App\Models\Lenders;
use App\Models\ClientRecord;
use Illuminate\Http\Request;
use App\Models\ClientLenders;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $ros = ROS::count();
        $lenders = Lenders::count();
        $brokers = Brokers::count();
        $clients = ClientRecord::count();

        $lenderCounts = ClientLenders::select('lender', DB::raw('COUNT(*) as count'))
            ->groupBy('lender')
            ->orderByDesc('count')
            ->pluck('lender');

        if ($request->ajax()) {
            $page = $request->get('start') / $request->get('length') + 1;
            $pageSize = $request->get('length');
            $days = $request->has('days') ? $request->get('days') : null;

            $query = ClientRecord::select('property_management', DB::raw('COUNT(*) as count'))
                ->with('rso')
                ->whereNotNull('property_management');

            if ($days) {
                $query->whereBetween('created_at', [
                    now()->startOfDay(),
                    now()->addDays($days)->endOfDay()
                ]);
            }

            $count = $query->count();

            $query->groupBy('property_management')
                ->orderByDesc('count');

            $paginated = $query->paginate($pageSize, ['*'], 'page', $page);

            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => ROS::count(),
                'recordsFiltered' => $count,
                'data' => $paginated->items(),
            ]);
        }

        return view('pages.admin.dashboard', compact('ros', 'lenders', 'brokers', 'clients', 'lenderCounts'));
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
