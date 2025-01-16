<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nrp' => 'nullable|string|unique:users',
            'pangkat' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'sub_bidang' => 'nullable|string',
            'role' => 'required|in:KEPALA BIDANG,KEPALA SUB BIDANG,ANGGOTA',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('foto_profile')) {
            $path = $request->file('foto_profile')->store('public/profile-photos');
            $validated['foto_profile'] = Storage::url($path);
        }

        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'nrp' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'pangkat' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'sub_bidang' => 'nullable|string',
            'role' => 'required|in:KEPALA BIDANG,KEPALA SUB BIDANG,ANGGOTA',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama jika ada
            if ($user->foto_profile) {
                Storage::delete(str_replace('/storage', 'public', $user->foto_profile));
            }
            
            $path = $request->file('foto_profile')->store('public/profile-photos');
            $validated['foto_profile'] = Storage::url($path);
        }

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->foto_profile) {
            Storage::delete(str_replace('/storage', 'public', $user->foto_profile));
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}