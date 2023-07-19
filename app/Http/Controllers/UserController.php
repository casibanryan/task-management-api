<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        
        if(Auth::attempt($credentials)) {
            $token = $request->user()->createToken('token')->plainTextToken;
            return response()->json(['token' => $token]);
        }
    }
}