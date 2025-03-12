<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RBAC\UserStoreRequest;
use App\Http\Requests\RBAC\UserUpdateRequest;
use Yajra\DataTables\Facades\DataTables;

use App\Enums\State;
use App\Models\Master\Position;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::query()->with('roles')
                ->whereNotIn(
                    'username',
                    ['rahasia']
                );
            return DataTables::eloquent($users)
                ->addColumn('is_local_user', function ($user) {
                    return is_null($user->password);
                })
                ->addColumn('action', function ($user) {
                    $actions = [
                        ['id' => $user->id, 'route' => route('rbac.users.edit', $user->id), 'type' => 'link', 'text' => 'edit', 'permission' => 'rbac.user.edit'],
                        ['id' => $user->id, 'route' => route('rbac.users.destroy', $user->id), 'type' => 'delete', 'text' => 'hapus', 'permission' => 'rbac.user.destroy'],
                    ];

                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('RBAC.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Pengguna';

        return view('RBAC.users.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $request->merge([
                'password' => bcrypt($request->password),
            ]);

            $position = Position::whereSubUnitCode($request->sub_unit_code)->first();
            DB::beginTransaction();
            $roles =
                array_merge(
                    $position->assigned_roles ? explode(',', $position->assigned_roles) : ['risk admin'],
                    $request->role
                );

            $user = User::create(
                $request->only(
                    'email',
                    'username',
                    'password',
                    'employee_id',
                    'employee_name',
                    'position_name',
                    'sub_unit_code',
                ) +
                    [
                        'unit_code' => $position->unit_code,
                        'unit_name' => $position->unit_name,
                        'sub_unit_name' => $position->sub_unit_name,
                        'organization_code' => $position->sub_unit_code,
                        'organization_name' => $position->sub_unit_name,
                        'personnel_area_code' => $position->branch_code,
                        'personnel_area_name' => '',
                        'employee_grade_code' => '-',
                        'employee_grade' => '-',
                        'image_url' => '',
                        'is_active' => true,
                    ]
            );
            $user->syncRoles($roles);

            DB::commit();
            flash_message('flash_message', 'Pengguna berhasil disimpan', State::SUCCESS);
            return redirect()->route('rbac.users.index');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Access > User] failed to create user. ' . $e->getMessage(), [$e]);
            flash_message('flash_message', 'Gagal menambahkan pengguna baru', State::ERROR);
            return redirect()->route('rbac.users.index');
        }
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
        $user->load('roles');

        $roles = [];
        foreach ($user->roles as $role) {
            $roles[] = $role->name;
        }

        $user->role = $roles;
        return view('RBAC.users.edit', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $data = $request->only(
                'email',
                'username',
                'employee_id',
                'employee_name',
                'position_name',
                'sub_unit_code',
            );

            if ($request->get('password')) {
                $request->merge([
                    'password' => bcrypt($request->password),
                ]);
                $data = $request->only(
                    'email',
                    'username',
                    'password',
                    'employee_id',
                    'employee_name',
                    'position_name',
                    'sub_unit_code',
                );
            }

            $position = Position::whereSubUnitCode($request->sub_unit_code)->first();

            DB::beginTransaction();
            $roles =
                array_merge(
                    $position->assigned_roles ? explode(',', $position->assigned_roles) : ['risk admin'],
                    $request->role
                );

            $user->update(
                $data +
                    [
                        'unit_code' => $position->unit_code,
                        'unit_name' => $position->unit_name,
                        'sub_unit_name' => $position->sub_unit_name,
                        'organization_code' => $position->sub_unit_code,
                        'organization_name' => $position->sub_unit_name,
                        'personnel_area_code' => $position->branch_code,
                        'personnel_area_name' => '',
                        'employee_grade_code' => '-',
                        'employee_grade' => '-',
                        'image_url' => $user->image_url,
                    ]
            );
            $user->syncRoles($roles);

            DB::commit();
            flash_message('flash_message', 'Pengguna berhasil disimpan', State::SUCCESS);
            return redirect()->route('rbac.users.index');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Access > User] failed to create user. ' . $e->getMessage(), [$e]);
            flash_message('flash_message', 'Gagal menambahkan pengguna baru', State::ERROR);
            return redirect()->route('rbac.users.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            flash_message('flash_message', 'Pengguna berhasil dihapus', State::SUCCESS);
        } else {
            flash_message('flash_message', 'Gagal menghapus pengguna', State::ERROR);
        }

        return redirect()->route('rbac.users.index');
    }
}
