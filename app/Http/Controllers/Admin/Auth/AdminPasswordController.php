<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminPasswordController extends Controller
{
    public function reset(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) return redirect()->back()->with('error', 'User not found');

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'Old password is incorrect', 'message' => 'Old password is incorrect'], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => 'Password updated successfully']);
    }
}
