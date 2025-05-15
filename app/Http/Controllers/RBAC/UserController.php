<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RBAC\UserStoreRequest;
use App\Http\Requests\RBAC\UserUpdateRequest;
use Yajra\DataTables\Facades\DataTables;

use App\Enums\State;
use App\Enums\UnitSourceType;
use App\Models\Master\Position;
use App\Models\UserUnit;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = UserUnit::query()
                ->select(['user_units.*'])
                ->with('user', 'roles')
                ->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'root');
                });

            return DataTables::eloquent($users)
                ->editColumn('source_type', function (UserUnit $user) {
                    if ($user->source_type == UnitSourceType::SYSTEM->value) {
                        return "<span class='text-capitalize badge badge-sm bg-info-transparent'>{$user->source_type}</span>";
                    }
                    return "<span class='text-capitalize badge badge-sm bg-secondary-transparent'>{$user->source_type}</span>";
                })
                ->addColumn('action', function (UserUnit $user) {
                    if ($user->source_type == UnitSourceType::SYSTEM->value) {
                        $actions = [];
                        if (role()->checkPermission('rbac.user.update')) {
                            $actions[] = ['id' => $user->getEncryptedId(), 'route' => route('rbac.users.edit', $user->getEncryptedId()), 'type' => 'link', 'text' => 'edit', 'permission' => true];
                        }
                        if (role()->checkPermission('rbac.user.destroy')) {
                            $actions[] = ['id' => $user->getEncryptedId(), 'route' => route('rbac.users.destroy', $user->getEncryptedId()), 'type' => 'delete', 'text' => 'hapus', 'permission' => true];
                        }

                        if (empty($actions)) {
                            return '';
                        }
                        return view('layouts.partials._table_action', compact('actions'));
                    }

                    return '';
                })
                ->rawColumns(['action', 'source_type'])
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
            $user = User::where('employee_id', $request->employee_id)
                ->orWhere('username', $request->username)
                ->first();

            if (!$user) {
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
                            'sub_unit_code' => $position->sub_unit_code,
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
            }

            $unit = $user->units()
                ->updateOrCreate(
                    [
                        'sub_unit_code' => $position->sub_unit_code,
                        'position_name' => $request->position_name,
                    ],
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
                        'source_type' => UnitSourceType::SYSTEM->value,
                        'expired_at' => $request->expired_at,
                        'is_active' => true,
                    ]
                );
            $unit->syncRoles($request->role);

            DB::commit();
            flash_message('flash_message', 'Pengguna berhasil disimpan', State::SUCCESS);
            return redirect()->route('rbac.users.index');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Access > User] failed to create user. ' . $e->getMessage(), [$e]);
            flash_message('flash_message', 'Gagal menambahkan pengguna', State::ERROR);
            return redirect()->route('rbac.users.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $user)
    {
        $user = UserUnit::findByEncryptedIdOrFail($user);
        if ($user->source_type == UnitSourceType::EOFFICE->value) {
            flash_message('flash_message', 'Pengguna E-Office tidak dapat diperbarui', State::ERROR);
            return redirect()->route('rbac.users.index');
        }

        $user->load('user', 'roles');

        $roles = [];
        foreach ($user->roles as $role) {
            $roles[] = $role->name;
        }

        $user->role = $roles;
        $title = 'Edit Pengguna';
        return view('RBAC.users.edit', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $user)
    {
        $user = UserUnit::findByEncryptedIdOrFail($user);
        if ($user->source_type == UnitSourceType::EOFFICE->value) {
            flash_message('flash_message', 'Pengguna E-Office tidak dapat diperbarui', State::ERROR);
            return redirect()->route('rbac.users.index');
        }

        $user->load('user');
        $validator = Validator::make($request->only('username', 'employee_id'), [
            'username' => 'unique:users,username,' . $user->user->id,
            'employee_id' => 'unique:users,employee_id,' . $user->user->id,
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

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

            $position = Position::whereSubUnitCode($request->sub_unit_code)->firstOrFail();

            DB::beginTransaction();

            $user->update([
                'unit_code' => $position->unit_code,
                'unit_name' => $position->unit_name,
                'sub_unit_code' => $position->sub_unit_code,
                'sub_unit_name' => $position->sub_unit_name,
                'organization_code' => $position->sub_unit_code,
                'organization_name' => $position->sub_unit_name,
                'personnel_area_code' => $position->branch_code,
                'personnel_area_name' => '',
                'employee_grade_code' => '-',
                'employee_grade' => '-',
                'image_url' => '',
                'is_active' => true,
            ] + ($user->source_type == UnitSourceType::EOFFICE->value ? [] : $request->only('expired_at')));
            $user->syncRoles($request->role);

            $user->user->update(
                $data + [
                    'unit_code' => $position->unit_code,
                    'unit_name' => $position->unit_name,
                    'sub_unit_code' => $position->sub_unit_code,
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

            DB::commit();

            DB::table('sessions')->where('user_id', $user->user->id)->delete();
            flash_message('flash_message', 'Pengguna berhasil disimpan', State::SUCCESS);
            return redirect()->route('rbac.users.index');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Access > User] failed to create user. ' . $e->getMessage(), [$e]);
            flash_message('flash_message', 'Gagal memperbarui pengguna', State::ERROR);
            return redirect()->route('rbac.users.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserUnit $user)
    {
        if ($user->source_type == UnitSourceType::EOFFICE->value) {
            flash_message('flash_message', 'Pengguna E-Office tidak dapat dihapus', State::ERROR);
            return redirect()->route('rbac.users.index');
        }

        if ($user->delete()) {
            flash_message('flash_message', 'Pengguna berhasil dihapus', State::SUCCESS);
        } else {
            flash_message('flash_message', 'Gagal menghapus pengguna', State::ERROR);
        }

        return redirect()->route('rbac.users.index');
    }
}
