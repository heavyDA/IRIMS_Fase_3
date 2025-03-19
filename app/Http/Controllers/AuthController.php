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
        if (session()->get('current_unit')->hasRole($request->role)) {
            session()->put('current_role', Role::where('name', $request->role)->first());
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function change_unit(Request $request)
    {
        $user = auth()->user();
        $unit = $user->units()->find($request->get('unit_target'));

        if (!$unit) {
            flash_message('flash_message',  'Gagal mengganti unit kerja.', State::ERROR);
            logger()->error("[Authentication] Failed to change user {$user->employee_id} unit, user doesn't have unit with ID {$request->get('unit_target')}");
            return redirect()->back();
        }

        $role = $unit->roles()->first();
        if (!$role) {
            flash_message('flash_message',  'Gagal mengganti unit kerja.', State::ERROR);
            logger()->error("[Authentication] Failed to change user {$user->employee_id} unit, unit with ID {$request->get('unit_target')} doesn't have assigned roles");
            return redirect()->back();
        }

        cache()->delete('current_roles.' . $user->employee_id);
        session()->put('current_unit', $unit);
        session()->put('current_role', $role);
        flash_message('flash_message',  'Berhasil mengganti unit kerja', State::SUCCESS);
        return redirect()->back();
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
                'name' => "[{$position->sub_unit_code_doc}] {$position->sub_unit_name}",
                'position_name' => $position->position_name,
                'personnel_area_code' => $position->sub_unit_code_doc,
                'personnel_area_name' => session()->get('current_unit')->personnel_area_name,
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
                'name' => "[{$position->sub_unit_code_doc}] {$position->sub_unit_name}",
                'position_name' => $position->position_name,
                'personnel_area_code' => $position->sub_unit_code_doc,
                'personnel_area_name' => session()->get('current_unit')->personnel_area_name,
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
        $riskMetric = RiskMetric::withExpression(
            'ancestor_hierarchy',
            Position::ancestorHierarchyQuery(session()->get('current_unit')->sub_unit_code == 'ap' ? 'ap.50' : session()->get('current_unit')->sub_unit_code)
                ->where('level', 1)
        )
            ->join('ancestor_hierarchy as ah', 'm_risk_metrics.organization_code', '=', 'ah.sub_unit_code')
            ->first();
        return response()->json(['data' => $riskMetric])->header('Cache-Control', 'no-store');
    }
}
