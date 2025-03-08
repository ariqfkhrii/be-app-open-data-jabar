<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'image_path' => $imagePath,
        ]);

        return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
        ]);

        $username = $request->input('username');
        $email = $request->input('email');

        $user = User::where('username', $username)
                    ->where('email', $email)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid username or email'], 401);
        }

        return response()->json(['message' => 'Login successful', 'data' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'username' => 'nullable|string|unique:users,username,' . $id,
            'email' => 'nullable|email|unique:users,email,' . $id,
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->filled('username')) {
            $user->username = $validated['username'];
        }

        if ($request->filled('email')) {
            $user->email = $validated['email'];
        }

        if ($request->hasFile('image')) {
            if ($user->image_path) {
                Storage::disk('public')->delete($user->image_path);
            }
            $user->image_path = $request->file('image')->store('images', 'public');
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully', 'data' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->image_path) {
            Storage::disk('public')->delete($user->image_path);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
