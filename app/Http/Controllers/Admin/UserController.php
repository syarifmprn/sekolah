<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = User::query()->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
        }
        
        $data = $query->paginate(10)->withQueryString();
        $modules = User::availablePermissions();
        return view('admin.user.index', compact('data', 'modules'));
    }

    public function create()
    {
        $modules = User::availablePermissions();
        return view('admin.user.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|in:superadmin,admin',
            'password' => 'required|string|min:6',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        $data = $request->only(['name', 'email', 'role', 'password']);
        $data['password'] = bcrypt($data['password']);

        if ($data['role'] === 'admin') {
            $data['permissions'] = $request->input('permissions', []);
        } else {
            $data['permissions'] = null;
        }

        User::create($data);
        return redirect()->route('admin.user.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $modules = User::availablePermissions();
        return view('admin.user.edit', compact('user', 'modules'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:superadmin,admin',
            'password' => 'nullable|string|min:6',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        $data = $request->only(['name', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($data['role'] === 'admin') {
            $data['permissions'] = $request->input('permissions', []);
        } else {
            $data['permissions'] = null;
        }

        $user->update($data);
        return redirect()->route('admin.user.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
