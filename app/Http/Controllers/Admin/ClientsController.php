<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClientRecord;
use Illuminate\Http\Request;
use App\Models\ClientLenders;
use App\Http\Controllers\Controller;
use App\Models\ROS;

class ClientsController extends Controller
{
    public function index(Request $request) {

        if ($request->ajax()) {
            // dd($request->all());
            $page = $request->get('start') / $request->get('length') + 1;
            $pageSize = $request->get('length');
            $searchValue = $request->has('search') ? $request->get('search') : null;
            $filter = $request->has('lender') ? $request->get('lender') : null;
            // $orderColumnIndex = $request->get('order') !== null ? $request->get('order')[0]['column']: null;
            // $orderDirection = $orderColumnIndex !== null ? $request->get('order')[0]['dir'] : 'asc';
            // $columns = ['name', 'email', 'phone'];

            // if($orderColumnIndex !== null) $orderColumn = $columns[$orderColumnIndex];

            $query = ClientRecord::with([
                'broker',
                'rso' => function ($query) {
                    $query->select('id', 'name as rso_name');
                }
            ]);

            // Apply search filter
            if ($searchValue) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', "%{$searchValue}%")
                      ->orWhere('email', 'like', "%{$searchValue}%")
                      ->orWhere('phone', 'like', "%{$searchValue}%");
                });
            }

            if($filter == 'yhlr') {
                $query->whereNull('property_management');
            }
            if ($filter && $filter !== 'yhlr') {
                $query->where('property_management', $filter);
            }

            // Apply additional filters (if any, e.g., specific fields)
            // if ($request->has('filter_field') && $request->get('filter_field')) {
            //     $filterField = $request->get('filter_field'); // Example field
            //     $query->where('some_column', $filterField); // Modify to fit your filter logic
            // }
            // if($orderColumnIndex !== null) $query->orderBy($orderColumn, $orderDirection);

            $count = $query->count();
            $query->orderBy('created_at', 'desc');
            $paginated = $query->paginate($pageSize, ['*'], 'page', $page);

            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => ClientRecord::count(),
                'recordsFiltered' => $count,
                'data' => $paginated->items(),
            ]);
        }

        $rso = ROS::get();

        return view('pages.admin.clients', compact('rso'));
    }

    public function show($id) {

        $client = ClientRecord::with([
            'rso' => function ($query) {
                $query->select('id', 'name');
            },
            'client_lenders'
        ])->findOrFail($id);

        return view('pages.admin.clientsMoreInfo', compact('client'));
    }

    public function lenders(Request $request) {

        if ($request->ajax()) {
            $page = $request->get('start') / $request->get('length') + 1;
            $pageSize = $request->get('length');
            $searchValue = $request->get('search')['value'];

            // $orderColumnIndex = $request->get('order') !== null ? $request->get('order')[0]['column']: null;
            // $orderDirection = $orderColumnIndex !== null ? $request->get('order')[0]['dir'] : 'asc';
            // $columns = [
            //     'lender',
            //     'loan_type',
            //     'loan_rate',
            //     'loan_term',
            //     'monthly',
            // ];

            // if($orderColumnIndex !== null) $orderColumn = $columns[$orderColumnIndex];

            $query = ClientLenders::with('client');

            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', "%{$searchValue}%")
                      ->orWhere('email', 'like', "%{$searchValue}%")
                      ->orWhere('phone', 'like', "%{$searchValue}%");
                });
            }

            // Apply additional filters (if any, e.g., specific fields)
            // if ($request->has('filter_field') && $request->get('filter_field')) {
            //     $filterField = $request->get('filter_field'); // Example field
            //     $query->where('some_column', $filterField); // Modify to fit your filter logic
            // }
            // if($orderColumnIndex !== null) $query->orderBy($orderColumn, $orderDirection);

            $count = $query->count();
            $paginated = $query->paginate($pageSize, ['*'], 'page', $page);
            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => ClientLenders::count(),
                'recordsFiltered' => $count,
                'data' => $paginated->items(),
            ]);
        }

        return view('pages.admin.clientsLender');
    }
}
