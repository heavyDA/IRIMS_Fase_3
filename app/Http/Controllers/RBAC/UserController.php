<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RBAC\UserStoreRequest;
use App\Http\Requests\RBAC\UserUpdateRequest;
use Yajra\DataTables\Facades\DataTables;

use App\Enums\State;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::query();
            return DataTables::eloquent($users)
                ->addColumn('action', function ($user) {
                    $actions = [
                        ['id' => $user->id, 'route' => route('rbac.user.show', $user->id), 'type' => 'link', 'text' => 'detail', 'permission' => 'rbac.user.detail'],
                        ['id' => $user->id, 'route' => route('rbac.user.edit', $user->id), 'type' => 'link', 'text' => 'edit', 'permission' => 'rbac.user.edit'],
                        ['id' => $user->id, 'route' => route('rbac.user.destroy', $user->id), 'type' => 'delete', 'text' => 'hapus', 'permission' => 'rbac.user.destroy'],
                    ];

                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->make(true);
        }

        $title = "Daftar Pengguna";

        return view('RBAC.users.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Pengguna';

        return view('RBAC.users.form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $request->merge([
            'password' => bcrypt($request->password),
        ]);

        if (User::create($request->only('first_name', 'last_name', 'email', 'password'))) {
            flash_message('success', 'Pengguna berhasil ditambahkan', State::SUCCESS);
            return redirect()->route('rbac.user.index');
        }

        flash_message('danger', 'Pengguna gagal ditambahkan', State::ERROR);
        return redirect()->route('rbac.user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $title = 'Edit Pengguna';

        return view('RBAC.users.form', compact('title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
