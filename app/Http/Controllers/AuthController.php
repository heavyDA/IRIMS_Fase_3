<?php

namespace App\Http\Controllers;

use App\Enums\State;
use App\Enums\UnitSourceType;
use App\Exceptions\Services\AuthServiceException;
use App\Http\Requests\LoginRequest;
use App\Models\Master\Official;
use App\Models\Master\Position;
use App\Models\Master\RiskMetric;
use App\Models\RBAC\Role;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\EOffice\OfficialService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(
        protected OfficialService $officialService,
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
            $position = Position::whereSubUnitCode(session()->get('current_unit')->sub_unit_code)->first();
            $data = [
                'pic_name' => "[{$position->sub_unit_code_doc}] {$position->sub_unit_name}",
                'pic_position_name' => $position->position_name,
                'pic_personnel_area_code' => $position->sub_unit_code_doc,
                'pic_personnel_area_name' => session()->get('current_unit')->personnel_area_name,
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
        $risk_metric = RiskMetric::where('organization_code', '=', session()->get('current_unit')->sub_unit_code == 'ap' ? 'ap.50' : session()->get('current_unit')->sub_unit_code)->first();
        return response()->json(['data' => $risk_metric])->header('Cache-Control', 'no-store');
    }
}
