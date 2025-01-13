<?php

namespace App\Http\Controllers;

use App\Enums\State;
use App\Http\Requests\LoginRequest;
use App\Models\Master\Position;
use App\Models\Master\RiskMetric;
use App\Models\RBAC\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function authenticate(LoginRequest $request)
    {
        try {
            $response = Http::withHeader('Authorization', env('EOFFICE_TOKEN'))
                ->timeout(10)
                ->asForm()
                ->post(env('EOFFICE_URL') . '/login_user', $request->only('username', 'password'));

            if ($response->failed() || $response->serverError() || $response->clientError()) {
                throw new Exception('Failed to login through E Office Service. ', $response->status(), $response->toException());
            }

            $data = ['is_active' => true];
            foreach ($response->json()['data'][0] as $key => $value) {
                $data[strtolower($key)] = $value;
            }
            DB::beginTransaction();

            $user = User::firstOrCreate([
                'email' => $data['email'],
            ], $data);

            if (!$user->wasRecentlyCreated) {
                $user->update($data);
            }

            $assigned_roles = Position::userAssignedRoles($user->personnel_area_code, $user->position_name)->first();
            $assigned_roles = $assigned_roles?->assigned_roles ? explode(',', $assigned_roles->assigned_roles) : ['risk admin'];
            $user->syncRoles($assigned_roles);

            if (Auth::loginUsingId($user->id)) {
                DB::commit();

                session()->put('current_role', $user->roles()->first());
                return redirect()->route('dashboard.index');
            }
        } catch (Exception $e) {
            logger()->error('[Authentication] ' . $e->getMessage());
        }

        if (Auth::attempt($request->only('username', 'password'))) {
            session()->put('current_role', auth()->user()->roles()->first());
            return redirect()->route('dashboard.index');
        }

        flash_message('validation', __('auth.failed'), State::ERROR);
        return redirect()->back();
    }

    public function unauthenticate()
    {
        Auth::logout();
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

    public function get_unit_head()
    {
        $data = ['pic_name' => ''];
        try {
            $subUnit = auth()->user()->sub_unit_code;
            $response = Http::withHeader('Authorization', env('EOFFICE_TOKEN'))
                ->timeout(10)
                ->asForm()
                ->post(env('EOFFICE_URL') . '/pejabat_get', [
                    'effective_date' => '2025-01-06',
                    'organization_code' => $subUnit
                ]);

            if ($response->failed() || $response->serverError() || $response->clientError()) {
                throw new Exception("Failed to get unit head data with organization code {$subUnit} from E Office Service. ", $response->status(), $response->toException());
            }

            $json = $response->json();

            if ($json['totalData'] > 0) {
                $subUnitHead = $json['data'][0];

                $data = [
                    'pic_name' => $subUnitHead['POSITION_NAME']
                ];
            }
        } catch (Exception $e) {
            logger()->error($e);
        }

        return response()->json(['data' => $data]);
    }

    public function get_risk_metric()
    {
        $risk_metric = RiskMetric::where('organization_code', '=', substr(auth()->user()->sub_unit_code, 0, 5))->first();
        return response()->json(['data' => $risk_metric]);
    }
}
