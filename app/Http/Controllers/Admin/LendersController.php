<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lenders;
use Illuminate\Http\Request;

class LendersController extends Controller
{
    public function index() {
        return view('pages.admin.lenders');
    }
}
