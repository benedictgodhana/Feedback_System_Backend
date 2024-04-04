<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Notifications\PasswordResetNotification;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication was successful
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            $role = $user->roles->first()->name;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'role' => $role,
            ], 200);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function logout(Request $request)
    {
        // Revoke the token used for authentication
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(Request $request)
    {
        // Validate the incoming request data for user registration
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8',],
        ]);

        // Create a new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Assign the role 'customer' to the newly created user
        $user->assignRole('customer');

        // Return a success response with the newly created user
        return response()->json(['user' => $user, 'message' => 'User registered successfully'], 201);
    }


    public function forgotPassword(Request $request)
    {
        // Validate request data
        $request->validate([
            'email' => 'required|email',
        ]);

        // Send password reset link
        $response = Password::sendResetLink(
            $request->only('email')
        );

        // Check if the password reset link was sent successfully
        if ($response == Password::RESET_LINK_SENT) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function resetPassword(Request $request)
    {
        // Validate request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Reset the user's password
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Update user's password
        $user->password = bcrypt($request->password);
        $user->save();

        // Send email notification to user
        $user->notify(new PasswordResetNotification());

        return response()->json(['message' => 'Password reset successfully.']);
    }
}
