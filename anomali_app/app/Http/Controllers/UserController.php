<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::all();
        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:Asisten Afdeling,Kepala Kebun,Manajemen'
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:Asisten Afdeling,Kepala Kebun,Manajemen'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        // Prevent deleting yourself
        if (auth()->id() == $user->id) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa menghapus akun sendiri'], 403);
        }
        $user->delete();
        return response()->json(['success' => true]);
    }
}
