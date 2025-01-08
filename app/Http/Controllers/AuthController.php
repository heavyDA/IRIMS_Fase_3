<?php

namespace App\Http\Controllers;

use App\Enums\State;
use App\Http\Requests\LoginRequest;
use App\Models\RBAC\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            $user = ['is_active' => true];
            foreach ($response->json()['data'][0] as $key => $value) {
                $user[strtolower($key)] = $value;
            }

            $user = User::firstOrCreate([
                'email' => $user['email'],
            ], $user);

            if ($user->wasRecentlyCreated) {
                $user->assignRole('risk admin');
            }

            if (Auth::loginUsingId($user->id)) {
                session()->put('current_role', auth()->user()->roles()->first());
                return redirect()->route('dashboard');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        if (Auth::attempt($request->only('username', 'password'))) {
            session()->put('current_role', auth()->user()->roles()->first());
            return redirect()->route('dashboard');
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
        $data = null;
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
}
