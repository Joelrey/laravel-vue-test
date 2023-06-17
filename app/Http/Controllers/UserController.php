<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request) {

        if($request->user()->is_admin) {
            return response([
                'status' => "success",
                'data' => User::all(),
            ], 200);
        } else {
            return response([
                'status' => "error",
                'message' => 'User is not an admin!',
            ], 422);
        }

    }
}
