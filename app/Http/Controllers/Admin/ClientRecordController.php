<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ClientRecord;
use Illuminate\Http\Request;

class ClientRecordController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $page = $request->get('start') / $request->get('length') + 1;
            $pageSize = $request->get('length');
            $searchValue = $request->get('search')['value'];

            $orderColumnIndex = $request->get('order') !== null ? $request->get('order')[0]['column'] : null;
            $orderDirection = $orderColumnIndex !== null ? $request->get('order')[0]['dir'] : 'asc';
            $columns = ['name', 'email', 'phone', 'address'];

            if ($orderColumnIndex !== null) $orderColumn = $columns[$orderColumnIndex];

            $query = ClientRecord::select([
                'id',
                'name',
                'email',
                'phone',
                'broker_id',
            ]);

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
            if ($orderColumnIndex !== null) $query->orderBy($orderColumn, $orderDirection);
            $count = $query->count();
            $paginated = $query->paginate($pageSize, ['*'], 'page', $page);
            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => ClientRecord::count(),
                'recordsFiltered' => $count,
                'data' => $paginated->items(),
            ]);
        }

        return view('pages.admin.visitors');
    }
}
