<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LenderRates;
use App\Models\Lenders;
use Illuminate\Http\Request;

class LendersController extends Controller
{
    public function index(Request $request) {

        if ($request->ajax()) {
            $page = $request->get('start') / $request->get('length') + 1;
            $pageSize = $request->get('length');
            $searchValue = $request->get('search')['value'];

            // $orderColumnIndex = $request->get('order') !== null ? $request->get('order')[0]['column']: null;
            // $orderDirection = $orderColumnIndex !== null ? $request->get('order')[0]['dir'] : 'asc';
            // $columns = ['name'];

            // if($orderColumnIndex !== null) $orderColumn = $columns[$orderColumnIndex];

            $query = Lenders::select([
                'id',
                'name'
            ]);

            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', "%{$searchValue}%");
                });
            }

            // if($orderColumnIndex !== null) $query->orderBy($orderColumn, $orderDirection);
            $count = $query->count();
            $paginated = $query->paginate($pageSize, ['*'], 'page', $page);
            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => Lenders::count(),
                'recordsFiltered' => $count,
                'data' => $paginated->items(),
            ]);
        }
        return view('pages.admin.lenders');
    }

    public function rates(Request $request) {

        if ($request->ajax()) {
            $page = $request->get('start') / $request->get('length') + 1;
            $pageSize = $request->get('length');
            $searchValue = $request->get('search')['value'];

            // $orderColumnIndex = $request->get('order') !== null ? $request->get('order')[0]['column']: null;
            // $orderDirection = $orderColumnIndex !== null ? $request->get('order')[0]['dir'] : 'asc';
            // $columns = [
            //     'lvr',
            //     'loan_type',
            //     'loan_rate',
            //     'loan_term',
            // ];

            // if($orderColumnIndex !== null) $orderColumn = $columns[$orderColumnIndex];

            // $query = LenderRates::with('lender')->get();
            $query = LenderRates::with('lender');

            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('lvr', 'like', "%{$searchValue}%")
                        ->where('loan_type', 'like', "%{$searchValue}%")
                        ->where('loan_rate', 'like', "%{$searchValue}%")
                        ->where('loan_term', 'like', "%{$searchValue}%");
                });
            }

            // if($orderColumnIndex !== null) $query->orderBy($orderColumn, $orderDirection);
            $count = $query->count();
            $paginated = $query->paginate($pageSize, ['*'], 'page', $page);
            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => LenderRates::count(),
                'recordsFiltered' => $count,
                'data' => $paginated->items(),
            ]);
        }

        return view('pages.admin.lenderRates');
    }

    public function store(Request $request) {

        Lenders::create([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => 'Lender created successfully.']);
    }

    public function delete(Request $request) {

        $lender = Lenders::findOrFail($request->id);
        $lender->delete();

        return response()->json(['success' => 'Lender deleted successfully.']);
    }
}
