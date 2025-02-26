<?php

namespace App\Http\Controllers;

use App\Enums\State;
use App\Http\Requests\LoginRequest;
use App\Models\Master\Official;
use App\Models\Master\Position;
use App\Models\Master\RiskMetric;
use App\Models\RBAC\Role;
use App\Models\User;
use App\Services\EOffice\AuthService;
use App\Services\EOffice\OfficialService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct(
        protected OfficialService $officialService,
        protected AuthService $authService,
    ) {
        $this->officialService = new OfficialService(env('EOFFICE_URL'), env('EOFFICE_TOKEN'));
        $this->authService = new AuthService(env('EOFFICE_URL'), env('EOFFICE_TOKEN'));
    }

    public function index()
    {
        return view('auth.index');
    }

    public function authenticate(LoginRequest $request)
    {
        try {
            $user = $this->authService->login($request->only('username', 'password'));

            $data = ['is_active' => true];
            foreach ($user as $key => $value) {
                $data[strtolower($key)] = $value;
            }

            DB::beginTransaction();
            $user = User::firstOrCreate([
                'email' => $data['email'],
            ], $data);

            if (!$user->wasRecentlyCreated) {
                $user->update($data);
            }

            $assigned_roles = Position::whereSubUnitCode($user->sub_unit_code)
                ->wherePositionName($user->position_name)
                ->first();

            $assigned_roles = $assigned_roles?->assigned_roles ? explode(',', $assigned_roles->assigned_roles) : ['risk admin'];
            $user->syncRoles($assigned_roles);

            if (auth()->loginUsingId($user->id)) {
                DB::commit();

                session()->put('current_unit', (object) [
                    'position_name' => $user->position_name,
                    'organization_code' => $user->organization_code,
                    'organization_name' => $user->organization_name,
                    'unit_code' => $user->unit_code,
                    'unit_name' => $user->unit_name,
                    'sub_unit_code' => $user->sub_unit_code,
                    'sub_unit_name' => $user->sub_unit_name,
                    'personnel_area_code' => $user->personnel_area_code,
                    'personnel_area_name' => $user->personnel_area_name,
                ]);
                session()->put('current_role', $user->roles()->first());
                return redirect()->route('dashboard.index');
            }
        } catch (Exception $e) {
            logger()->error('[Authentication] ' . $e->getMessage());
        }

        if (auth()->attempt($request->only('username', 'password'))) {
            $user = auth()->user();

            if (!str_contains($user->employee_id, 'x9999')) {
                $assigned_roles = Position::whereSubUnitCode($user->sub_unit_code)
                    ->wherePositionName($user->position_name)
                    ->first();
                $assigned_roles = $assigned_roles?->assigned_roles ? explode(',', $assigned_roles->assigned_roles) : ['risk admin'];
                $user->syncRoles($assigned_roles);
            }

            session()->put('current_unit', (object) [
                'position_name' => $user->position_name,
                'organization_code' => $user->organization_code,
                'organization_name' => $user->organization_name,
                'unit_code' => $user->unit_code,
                'unit_name' => $user->unit_name,
                'sub_unit_code' => $user->sub_unit_code,
                'sub_unit_name' => $user->sub_unit_name,
                'personnel_area_code' => $user->personnel_area_code,
                'personnel_area_name' => $user->personnel_area_name,
            ]);

            session()->put('current_role', $user->roles()->first());
            return redirect()->route('dashboard.index');
        }

        flash_message('validation', __('auth.failed'), State::ERROR);
        return redirect()->back();
    }

    public function unauthenticate()
    {
        cache()->delete('current_unit_hierarchy.' . auth()->user()->employee_id . '.' . session()->get('current_unit', auth()->user())->sub_unit_code);

        auth()->logout();
        session()->flush();


        return redirect()->route('auth.login');
    }

    public function change_role(Request $request)
    {
        if (auth()->user()->hasRole($request->role)) {
            session()->put('current_role', Role::where('name', $request->role)->first());
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function change_unit(Request $request)
    {
        if (Role::hasLookUpUnitHierarchy()) {
            $unit = Position::getSubUnitOnly()
                ->whereSubUnitCode($request->unit)
                ->first();
            if ($unit) {
                session()->put('current_unit', $unit);
                flash_message('flash_message',  'Berhasil mengganti unit kerja', State::SUCCESS->color());
                return redirect()->route('dashboard.index');
            }
        }

        flash_message('flash_message',  'Gagal mengganti unit kerja', State::ERROR->color());
        return redirect()->route('dashboard.index');
    }

    public function get_unit_head()
    {
        $data = [
            'pic_name' => '',
            'pic_position_name' => '',
            'pic_personnel_area_code' => '',
            'pic_personnel_area_name' => '',
            'pic_organization_code' => '',
            'pic_organization_name' => '',
            'pic_unit_code' => '',
            'pic_unit_name' => '',
            'pic_sub_unit_code' => '',
            'pic_sub_unit_name' => '',
        ];

        try {
            $position = Position::whereSubUnitCode(auth()->user()->sub_unit_code)->first();
            $data = [
                'pic_name' => "[{$position->sub_unit_code_doc}] {$position->sub_unit_name}",
                'pic_position_name' => $position->position_name,
                'pic_personnel_area_code' => $position->sub_unit_code_doc,
                'pic_personnel_area_name' => auth()->user()->personnel_area_name,
                'pic_organization_code' => $position->sub_unit_code,
                'pic_organization_name' => $position->sub_unit_name,
                'pic_unit_code' => $position->unit_code,
                'pic_unit_name' => $position->unit_name,
                'pic_sub_unit_code' => $position->sub_unit_code,
                'pic_sub_unit_name' => $position->sub_unit_name,
            ];
        } catch (Exception $e) {
            logger()->error('[Profile] Failed to get unit head.', [$e->getMessage()]);
        }

        return response()->json(['data' => $data])->header('Cache-Control', 'no-store');
    }

    public function get_risk_metric()
    {
        $risk_metric = RiskMetric::where('organization_code', '=', substr(auth()->user()->sub_unit_code, 0, 5))->first();
        return response()->json(['data' => $risk_metric])->header('Cache-Control', 'no-store');
    }
}
