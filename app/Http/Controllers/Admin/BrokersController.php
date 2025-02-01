<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brokers;
use Illuminate\Http\Request;

class BrokersController extends Controller
{
    public function index(Request $request) {

        if ($request->ajax()) {
            $page = $request->get('start') / $request->get('length') + 1;
            $pageSize = $request->get('length');
            $searchValue = $request->get('search')['value'];

            // $orderColumnIndex = $request->get('order') !== null ? $request->get('order')[0]['column']: null;
            // $orderDirection = $orderColumnIndex !== null ? $request->get('order')[0]['dir'] : 'asc';
            // $columns = ['name', 'email', 'phone', 'rso'];

            // if($orderColumnIndex !== null) $orderColumn = $columns[$orderColumnIndex];

            $query = Brokers::select([
                'id',
                'name',
                'email',
                'phone',
                'rso',
            ]);

            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', "%{$searchValue}%")
                      ->orWhere('email', 'like', "%{$searchValue}%")
                      ->orWhere('phone', 'like', "%{$searchValue}%");
                });
            }

            // if($orderColumnIndex !== null) $query->orderBy($orderColumn, $orderDirection);
            $count = $query->count();
            $paginated = $query->paginate($pageSize, ['*'], 'page', $page);

            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => Brokers::count(),
                'recordsFiltered' => $count,
                'data' => $paginated->items(),
            ]);
        }

        return view('pages.admin.brokers');
    }

    public function store(Request $request) {

        Brokers::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'rso' => json_encode($request->ros_select)
        ]);

        return response()->json(['success' => 'Broker added successfully.']);
    }

    public function delete(Request $request) {

        $broker = Brokers::findOrFail($request->id);
        $broker->delete();

        return response()->json(['success' => 'Broker deleted successfully.']);
    }
}
