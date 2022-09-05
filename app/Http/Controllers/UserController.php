<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user === null) {
            $newuser = new User();
            $newuser->name = $request->name;
            $newuser->email = $request->email;
            $newuser->password = bcrypt($request->password);
            $newuser->save();

            return response()->json($newuser, 201);
        } else {
            return response()->json([
                "message" => "E-mail already exists!"
            ], 400);
        }
    }
}