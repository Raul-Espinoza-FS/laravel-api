<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    /**
     * Login api
     *
     * @param string email
     * @param string password
     * @param string app_name - name to identify the token
     *  
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'app_name' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json(['success'=> true, 
                                'name' => $user->name,
                                'roles' => $user->getAllPermissions(),
                                'token' => $user->createToken($request->app_name)->plainTextToken
                                ]);
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->validate([
            'app_name' => 'required',
        ]);

        optional($request->user()->currentAccessToken())->delete();

        return response()->json(['success'=> true]);
    }
}
