<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request) 
    {
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

    public function update(Request $request, User $user) 
    {
        if($request->user()->is_admin) {
            $rules = [
                'email' => [
                    'required',
                    'email',
                ],
                'phone' => [
                    'required',
                    'regex:/^\+[0-9]{1,3}[0-9]{6,14}$/',
                ],
            ];
            
            $validator = Validator::make($request->all(), $rules);
    
            $errors = [];
    
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $key => $error) {
                    array_push($errors, $error);
                }            
                return response()->json([
                    'status' => "error",
                    'errors' => $errors
                ],422); 
            }
    
            $user->email = $request->email;
            $user->phone = $request->phone;
            
            if($user->isClean()) {
                return response([
                    'status' => "error",
                    'errors' => ['No changes to save'],
                ], 422);
            }

            $user->save();
    
            return response([
                'status' => "success",
                'message' => "User $user->username has been updated",
            ], 200);

        } else {
            return response([
                'status' => "error",
                'errors' => ['User is not an admin!'],
            ], 422);
        }

    }

    public function delete(Request $request, User $user) 
    {
        if($request->user()->is_admin) {

            if($user->id===1) {
                return response([
                    'status' => "error",
                    'errors' => ['You cannot delete an admin user!'],
                ], 422);
            }
           
            $username = $user->username;

            $user->delete();
    
            return response([
                'status' => "success",
                'message' => "User $username has been deleted",
            ], 200);

        } else {
            return response([
                'status' => "error",
                'errors' => ['User is not an admin!'],
            ], 422);
        }

    }
}
