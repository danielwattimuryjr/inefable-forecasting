<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'ASC')
            ->where('role', '<>', 'direktur_operasional')
            ->get();

        return view('pages.dashboard.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());

        return to_route('users.index')->with([
            'response' => [
                'success' => true,
                'message' => 'User berhasil ditambahkan'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.dashboard.users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Get validated data from the request
        $data = $request->validated();

        // Check if the password field is present and not empty
        if (isset($data['password']) && !empty($data['password'])) {
            $user->update([
                'username' => $data['username'],
                'nama' => $data['nama'],
                'email' => $data['email'],
                'role' => $data['role'],
                'jabatan' => $data['jabatan'],
                'password' => $data['password'],
            ]);
        } else {
            $user->update([
                'username' => $data['username'],
                'nama' => $data['nama'],
                'email' => $data['email'],
                'role' => $data['role'],
                'jabatan' => $data['jabatan'],
            ]);
        }

        return to_route('users.index')->with([
            'response' => [
                'success' => true,
                'message' => 'User berhasil diperbaharui'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        return response()->json([
            'success' => $user->delete()
        ]);
    }
}
