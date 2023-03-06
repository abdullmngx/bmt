<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\Setting;
use App\Models\Deposit;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Services\PlanService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    protected $adminService, $userService, $planService;

    public function __construct(AdminService $adminService,UserService $userService, PlanService $planService)
    {
        $this->adminService = $adminService;
        $this->userService =  $userService;
        $this->planService = $planService;
    }

    public function showLogin()
    {
        return view('auth.admin.login');
    }
    public function showForgot()
    {
        return view('auth.admin.forgot');
    }

    public function dashboard()
    {
        $data = $this->adminService->dashboardData();
        return view('admin.dashboard', ['data' => $data]);
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($this->adminService->login($request))
        {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.login'));
    }

    public function users()
    {
        $users = $this->adminService->getUsers();
        return view('admin.users')->with('users', $users);
    }

    public function team()
    {
        $team = $this->adminService->getTeam();
        return view('admin.team')->with('team', $team);
    }

    public function singleUser($id)
    {
        $user = $this->adminService->getUserById($id);
        $plans = $this->planService->showAll();
        return view('admin.user', ['user' => $user, 'plans' => $plans]);
    }

    public function deposits()
    {
        $deposits = $this->adminService->getAllDeposits();
        $total_deposit = Deposit::select(DB::raw('SUM(amount) as total'))->first();
        return view('admin.deposits', ['deposits' => $deposits, 'total_deposit' => $total_deposit['total']]);
    }

    public function withdrawals()
    {
        $withdrawals = Withdrawal::where('status', 'pending')->get();
        $requested = Withdrawal::select(DB::raw('SUM(amount) as total'))->where('status', 'pending')->first();
        $paid = Withdrawal::select(DB::raw('SUM(amount) as total'))->where('status', 'approved')->first();
        return view('admin.withdrawals', ['withdrawals' => $withdrawals, 'requested' => $requested->total, 'paid' => $paid->total]);
    }

    public function viewWithdrawal($id)
    {
        $withdrawal =  Withdrawal::where('id', $id)->with('user')->first();
        $user = $this->userService->getUser($withdrawal->user_id);
        $accountBalance = $user->total_balance;
        return view('admin.withdrawal', ['withdrawal' => $withdrawal, 'balance' => $accountBalance]);
    }

    public function approveWithdrawal($id, Request $request)
    {
        if ($request->pay) {
            $settings = Setting::first();
            $amt = $request->amount * $settings->dollar_rate;
            $secret = env('FLW_SECRET_KEY');
            $headers = [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer ". $secret
            ];
            $details = [
                "account_bank" => $request->bank_code,
                "account_number" => $request->account_number,
                "amount" =>  $amt,
                "narration" => "Trf",
                "currency" => "NGN",
                "reference" => rand(10,99).date('ymdhis'),
            ];
            $response = Http::withHeaders($headers)->post('https://api.flutterwave.com/v3/transfers', $details)->body();
            $resp = json_decode($response, true);

            if ($resp['status'] == "success")
            {
                Withdrawal::where('id', $id)->update(['status' => 'approved']);
                return back()->with('message', "Withdrawal Approved! Money Transferred");
            }else
            {
                return back()->withErrors(["message" => "Transfer failed, Please make transfer manually, uncheck pay option and approve"]);
            }
        }else
        {
            Withdrawal::where('id', $id)->update(['status' => 'approved']);
            return back()->with('message', "Withdrawal Approved!");
        }
    }

    public function declineWithdrawal($id, Request $request)
    {
        Withdrawal::where('id', $id)->update(['status' => 'declined']);
        return back()->withErrors(['message' => 'Withdrawal declined']);
    }

    public function showSettings()
    {
        $settings = Setting::first() ?? ["payment_channel" => null, "withdrawal" => null];
        return view('admin.settings', ['settings' => $settings]);
    }

    public function saveSettings(Request $request)
    {
        $setting = Setting::first();
        if ($setting)
        {
            Setting::where('id', $setting->id)->update($request->only('payment_channel', 'withdrawal', 'crypto_withdrawal', 'dollar_rate'));
        }else {
            Setting::create($request->only('payment_channel', 'withdrawal'));
        }
        return back()->with('message', 'Settings Saved');
    }

    public function depositUser(Request $request)
    {
        $request->validate([
            'plan_id' => 'required'
        ]);
        $this->adminService->depositUser($request);
        return back()->with('message', $request->amount." Lamps posted to user");
    }

    public function promotions()
    {
        return view('admin.promotions');
    }

    public function sendPromotional(Request $request)
    {
        if ($this->adminService->sendPromotional($request))
        {
            return back()->with('message', 'Mails sent');
        }
    }
}
