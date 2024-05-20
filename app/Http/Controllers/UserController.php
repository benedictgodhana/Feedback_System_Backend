<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserCount()
    {
        $userCount = user::count();

        return response()->json(['count' => $userCount]);
    }

    public function getAdminCount()
{
    // Get the count of users with the role name "admin"
    $adminRole = Role::where('name', 'admin')->first();
    $userCount = $adminRole->users()->count();

    return response()->json(['count' => $userCount]);
}
public function getSuperAdminCount()
{
    // Get the count of users with the role name "admin"
    $adminRole = Role::where('name', 'superadmin')->first();
    $userCount = $adminRole->users()->count();

    return response()->json(['count' => $userCount]);
}

    public function getAllUsers()
    {
        $users = User::with('roles')->get();

        return response()->json(['users' => $users]);
    }

    public function updateUser(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string|exists:roles,name', // Check if the role exists
            'password' => 'nullable|string|min:6', // Allow password to be nullable and minimum length 6
            // Add more validation rules as needed for other fields
        ]);

        // Find the user by id
        $user = User::findOrFail($id);

        // Update the user data
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            // Update other fields as needed
        ]);

        // Update password if provided
        if (isset($validatedData['password'])) {
            $user->update([
                'password' => bcrypt($validatedData['password']), // Hash the password
            ]);
        }

        // Find the role by name
        $role = Role::where('name', $validatedData['role'])->first();

        // Sync the user's roles
        $user->syncRoles([$role]);

        return response()->json(['message' => 'User updated successfully']);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|exists:roles,name',
            'password' => 'required|string|min:8',
            // Add more validation rules for other fields if needed
        ]);

        // Check if the role exists
        if (!Role::where('name', $validatedData['role'])->exists()) {
            return response()->json(['error' => 'Invalid role'], 422);
        }

        // Create the new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Assign the role to the user
        $user->assignRole($validatedData['role']);

        // Return a success response with the created user
        return response()->json(['user' => $user], 201);
    }

    public function getEmployees()
    {
        // Fetch users with the role name "employee"
        $employees = User::role('admin')->get(['id', 'name', 'email']);

        // Return the response
        return response()->json(['employees' => $employees]);
    }

    public function assignService(Request $request)
    {
        // Validate the request

        $employee = User::find($request->input('employee_id'));

        // Assign service to the employee
        // Your logic to assign service here...

        return response()->json(['message' => 'Service assigned successfully']);
    }


    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'role' => 'required', // Ensure role field is required
            // Add more fields as needed
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Assign the role to the user
        $user->assignRole($request->role);

        return response()->json(['message' => 'Profile updated successfully'], 200);
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|different:old_password',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'The provided old password does not match our records'], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }


    public function getUserData(Request $request)
    {
        // Fetch the authenticated user using Sanctum's Auth facade
        $user = Auth::user();

        // Retrieve additional details from the UserDetails model if available

        // Merge user details into the user object
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            // Add more user fields as needed
        ];

        // Return the user data in the response
        return response()->json($userData);
    }


}
