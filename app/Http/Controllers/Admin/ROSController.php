<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ROS;
use Illuminate\Http\Request;

class ROSController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $page = $request->get('start') / $request->get('length') + 1;
            $pageSize = $request->get('length');
            $searchValue = $request->get('search')['value'];

            $orderColumnIndex = $request->get('order') !== null ? $request->get('order')[0]['column'] : null;
            $orderDirection = $orderColumnIndex !== null ? $request->get('order')[0]['dir'] : 'asc';
            $columns = ['name', 'email', 'tagline'];

            if ($orderColumnIndex !== null) $orderColumn = $columns[$orderColumnIndex];

            $query = ROS::select([
                'id',
                'name',
                'email',
                'tagline',
            ]);

            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', "%{$searchValue}%")
                        ->orWhere('email', 'like', "%{$searchValue}%")
                        ->orWhere('tagline', 'like', "%{$searchValue}%");
                });
            }

            if ($orderColumnIndex !== null) $query->orderBy($orderColumn, $orderDirection);

            $count = $query->count();
            $paginated = $query->paginate($pageSize, ['*'], 'page', $page);

            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => ROS::count(),
                'recordsFiltered' => $count,
                'data' => $paginated->items(),
            ]);
        }

        return view('pages.admin.ros');
    }
}
