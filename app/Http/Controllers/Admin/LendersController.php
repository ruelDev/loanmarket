<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FixedRate;
use App\Models\LenderRates;
use App\Models\Lenders;
use App\Models\VariableRate;
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

            $query = FixedRate::with('lender');

            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('loan_type', 'like', "%{$searchValue}%")
                        ->orwhere('loan_purpose', 'like', "%{$searchValue}%")
                        ->orwhere('repayment_type', 'like', "%{$searchValue}%")
                        ->orwhereRaw("CAST(loan_rate AS CHAR) LIKE ?", ["%$searchValue%"])
                        ->orwhereRaw("CAST(loan_term AS CHAR) LIKE ?", ["%$searchValue%"])
                        ->orwhereRaw("CAST(comparison_rate AS CHAR) LIKE ?", ["%$searchValue%"])
                        ->orwhereRaw("CAST(tier_min AS CHAR) LIKE ?", ["%$searchValue%"])
                        ->orwhereRaw("CAST(tier_max AS CHAR) LIKE ?", ["%$searchValue%"]);

                    $q->orWhereHas('lender', function ($lenderQuery) use ($searchValue) {
                        $lenderQuery->where('name', 'like', "%{$searchValue}%");
                    });
                });

            }

            $count = $query->count();
            $paginated = $query->paginate($pageSize, ['*'], 'page', $page);
            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => FixedRate::count(),
                'recordsFiltered' => $count,
                'data' => $paginated->items(),
            ]);
        }

        return view('pages.admin.lenderRates');
    }

    public function ratesVariable(Request $request) {

        if ($request->ajax()) {
            $page = $request->get('start') / $request->get('length') + 1;
            $pageSize = $request->get('length');
            $searchValue = $request->get('search')['value'];

            $query = VariableRate::with('lender');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('loan_type', 'like', "%{$searchValue}%")
                        ->orwhere('loan_purpose', 'like', "%{$searchValue}%")
                        ->orwhere('repayment_type', 'like', "%{$searchValue}%")
                        ->orwhereRaw("CAST(loan_rate AS CHAR) LIKE ?", ["%$searchValue%"])
                        ->orwhereRaw("CAST(comparison_rate AS CHAR) LIKE ?", ["%$searchValue%"])
                        ->orwhereRaw("CAST(tier_min AS CHAR) LIKE ?", ["%$searchValue%"])
                        ->orwhereRaw("CAST(tier_max AS CHAR) LIKE ?", ["%$searchValue%"]);

                    $q->orWhereHas('lender', function ($lenderQuery) use ($searchValue) {
                        $lenderQuery->where('name', 'like', "%{$searchValue}%");
                    });
                });
            }

            $count = $query->count();
            $paginated = $query->paginate($pageSize, ['*'], 'page', $page);
            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => VariableRate::count(),
                'recordsFiltered' => $count,
                'data' => $paginated->items(),
            ]);
        }

        return view('pages.admin.lenderRatesVariable');
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
