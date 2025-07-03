<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UsersAcountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('admin.registered_acounts.adduser');
    }

    public function store(Request $request)
    {
        // Validate the incoming registration data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'usertype' => 'required|in:passenger,driver,admin',
            'status' => 'required|in:active,inactive'
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'usertype' => $validated['usertype'],
            'status' => $validated['status']
        ]);

        if ($user) {
            // Redirect to the dashboard or any other page
            return Redirect::to('/dashboard/users')->with('success', 'User registered successfully!');
        } else {
            return Redirect::back()->withErrors(['error' => 'Failed to register user.']);
        }
    }

    public function showUsers()
    {
        $users = User::paginate(5);  // Fetch all users from the database
        $userCount = $users->count(); // Get the total count of users
        return view('admin.registered_acounts.userstable', compact('users', 'userCount'));
    }

    public function destroy(Request $request)
    {
        $users = User::findOrFail($request->input('user_id'));
        $users->delete();

        // Log out the user if they are currently logged in
        // Auth::logout();

        if ($users) {
            return Redirect::to('/Dashboard/users')->with('success', 'User deleted successfully!');
        } else {
            return Redirect::back()->withErrors(['error' => 'Failed to delete users account.']);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id); // Fetch the user by ID
        return view('admin.registered_acounts.updateuser_account', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
       
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'usertype' => 'required|in:passenger,driver,admin',
            'status' => 'required|in:active,inactive',
        ]);

        // Update user details
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->status = $validatedData['status'];

        // Update password only if it's provided
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->usertype = $validatedData['usertype'];
        $user->save();
        return Redirect()->back()->with('success', 'User  updated successfully!');

    }

}
