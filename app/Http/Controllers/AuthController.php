<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request) 
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
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

        // Check user
        $user = User::where('username', $request->username)->orWhere('email', $request->username)->first();

        // Check username password
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => "error",
                'errors' => ['Invalid credentials']
            ], 422);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response([
            'status' => "success",
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function register(Request $request) {
        $rules = [
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[0-9])(?=.*[^A-Za-z0-9])/',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'username' => [
                'required',
                'string',
                'min:5',
                Rule::unique('users', 'username'),
            ],
            'phone' => [
                'required',
                'regex:/^\+[0-9]{1,3}[0-9]{6,14}$/',
            ],
        ];

        $messages = [
            'password.regex' => 'The password should have at least 1 number and 1 special character.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

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

        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->save();

        return response([
            'status' => "success",
            'message' => "User $user->username has been registered",
        ], 200);
    }

    public function logout(Request $request) {

        // return response([
        //     'status' => "success",
        //     'user' => $request->user(),
        // ], 200);

        $request->user()->currentAccessToken()->delete();

        return response([
            'status' => "success",
            'message' => "Logged out!",
        ], 200);

    }

}
