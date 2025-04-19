<?php

namespace App\Http\Controllers;

use App\Enums\State;
use App\Exceptions\Services\AuthServiceException;
use App\Http\Requests\LoginRequest;
use App\Models\Master\Position;
use App\Models\Master\RiskMetric;
use App\Models\RBAC\Role;
use App\Services\Auth\AuthService;
use App\Services\EOffice\OfficialService;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(
        protected OfficialService $officialService,
        protected RoleService $roleService
    ) {
        $this->authService = new AuthService();
        $this->officialService = new OfficialService(env('EOFFICE_URL'), env('EOFFICE_TOKEN'));
    }

    public function index()
    {
        return view('auth.index');
    }

    public function authenticate(LoginRequest $request)
    {
        try {
            $authenticate = $this->authService->login($request->only('username', 'password'));
            if ($authenticate) {
                session()->put('current_timezone', is_timezone_available($request->timezone) ? $request->timezone : 'Asia/Jakarta');
                return redirect()->route('dashboard.index');
            }

            throw new AuthServiceException(__('auth.failed'), Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            auth()->logout();
            session()->flush();

            if ($e instanceof AuthServiceException) {
                logger()->error("[Authentication] Error when authenticating user: " . $e->getMessage());
            } else {
                logger()->error("[Authentication] {$e->getMessage()}", [$e]);
            }
        }

        flash_message('validation', __('auth.failed'), State::ERROR);
        return redirect()->route('auth.login');
    }

    public function unauthenticate()
    {
        $this->authService->logout();
        return redirect()->route('auth.login');
    }

    public function change_role(Request $request)
    {
        $role = session()->get('current_roles')->where('id', $request->role)->first();
        if ($role) {
            session()->put('current_role', $role);
            session()->put('current_menu', null);
            return redirect()->intended();
        }
        return redirect()->intended();
    }

    public function change_unit(Request $request)
    {
        $user = auth()->user();
        $unit = $user->units()->find($request->get('unit_target'));

        if (!$unit) {
            flash_message('flash_message',  'Gagal mengganti unit kerja.', State::ERROR);
            logger()->error("[Authentication] Failed to change user {$user->employee_id} unit, user doesn't have unit with ID {$request->get('unit_target')}");
            return redirect()->intended();
        }

        $roles = $unit->roles()->get();
        $role = $roles->first();
        if (!$role) {
            flash_message('flash_message',  'Gagal mengganti unit kerja.', State::ERROR);
            logger()->error("[Authentication] Failed to change user {$user->employee_id} unit, unit with ID {$request->get('unit_target')} doesn't have assigned roles");
            return redirect()->intended();
        }

        session()->put('current_unit', $unit);
        session()->put('current_role', $role);
        session()->put('current_roles', $roles);
        session()->put('current_menu', null);
        flash_message('flash_message',  'Berhasil mengganti unit kerja', State::SUCCESS);
        return redirect()->intended();
    }

    public function get_unit_head()
    {
        $data = [
            'name' => '',
            'position_name' => '',
            'personnel_area_code' => '',
            'personnel_area_name' => '',
            'organization_code' => '',
            'organization_name' => '',
            'unit_code' => '',
            'unit_name' => '',
            'sub_unit_code' => '',
            'sub_unit_name' => '',
        ];

        try {
            $position = Position::whereSubUnitCode(session()->get('current_unit')->sub_unit_code)->first();
            $data = [
                'name' => "[{$position->sub_unit_code_doc}] {$position->position_name}",
                'position_name' => $position->position_name,
                'personnel_area_code' => $position->sub_unit_code_doc ?: '-',
                'personnel_area_name' => $position?->unit_name ?: $position?->sub_unit_name ?: '-',
                'organization_code' => $position->sub_unit_code,
                'organization_name' => $position->sub_unit_name,
                'unit_code' => $position->unit_code,
                'unit_name' => $position->unit_name,
                'sub_unit_code' => $position->sub_unit_code,
                'sub_unit_name' => $position->sub_unit_name,
            ];
        } catch (Exception $e) {
            logger()->error('[Profile] Failed to get unit head.', [$e->getMessage()]);
        }

        return response()->json(['data' => $data])->header('Cache-Control', 'no-store');
    }

    public function get_unit_heads()
    {
        $currentUnit = $this->roleService->getCurrentUnit();
        cache()->delete('current_unit_hierarchy.' . auth()->user()->employee_id . '.' . $currentUnit->sub_unit_code);
        $positions = cache()->remember(
            'current_unit_hierarchy.' . auth()->user()->employee_id . '.' . $currentUnit->sub_unit_code,
            now()->addMinutes(5),
            fn() =>
            Position::hierarchyQuery($currentUnit->sub_unit_code)
                ->whereBetween('level', $this->roleService->getTraverseUnitLevel())
                ->oldest('level', 'sub_unit_code')
                ->get()
        );

        $positionHeads = [];
        foreach ($positions as $position) {
            $positionHeads[] = [
                'name' => "[{$position->sub_unit_code_doc}] {$position->position_name}",
                'position_name' => $position->position_name,
                'personnel_area_code' => session()->get('current_unit')?->personnel_area_code ?: $position?->sub_unit_code_doc ?: '-',
                'personnel_area_name' => session()->get('current_unit')?->personnel_area_name ?: '-',
                'organization_code' => $position->sub_unit_code,
                'organization_name' => $position->sub_unit_name,
                'unit_code' => $position->unit_code,
                'unit_name' => $position->unit_name,
                'sub_unit_code' => $position->sub_unit_code,
                'sub_unit_name' => $position->sub_unit_name,
            ];
        }

        return response()->json(['data' => $positionHeads])->header('Cache-Control', 'no-store');
    }

    public function get_risk_metric()
    {
        try {
            $unit = $this->roleService->getCurrentUnit();
            $unitLevel = get_unit_level($unit->sub_unit_code);

            if ($unitLevel > 2) {
                $unit = Position::ancestorHierarchyQuery($unit->sub_unit_code)
                    ->where('level', 2)
                    ->first();
            } else if ($unit->sub_unit_code == 'ap') {
                $unit = Position::where('sub_unit_code', 'ap.50')
                    ->first();
            }
            return response()->json(['data' => $this->getRiskMetric($unit)])->header('Cache-Control', 'no-store');
        } catch (Exception $e) {
            logger()->error('[Risk Metrics] User ID ' . auth()->user()->employee_id . ' Looking for Risk Metric for Unit ' . $this->roleService->getCurrentUnit()->sub_unit_code . ' ' . $e->getMessage());
            return response()->json(['data' => null])->header('Cache-Control', 'no-store');
        }
    }

    protected function getRiskMetric($unit): RiskMetric
    {
        $riskMetric = RiskMetric::where('organization_code', $unit->sub_unit_code)->first();
        if ($riskMetric) {
            return $riskMetric;
        }

        $level = get_unit_level($unit->sub_unit_code) - 1;

        if ($level == 0) {
            throw new Exception('Strategi Matriks Risiko tidak ditemukan');
        }

        $unit = Position::ancestorHierarchyQuery($unit->sub_unit_code)
            ->where('level', $level)
            ->first();

        return $this->getRiskMetric($unit);
    }
}
