<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeNotification;
use App\Services\UserService;
use App\Services\EarningService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $userService, $earningService;

    public function __construct(UserService $userService, EarningService $earningService)
    {
        $this->userService = $userService;
        $this->earningService = $earningService;
    }

    public function  showRegister($ref_id = null)
    {
        return view('auth.register')->with('ref_id', $ref_id);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function sendReset(Request $request)
    {
        $request->validate(['email' => 'required|email']);
     
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['message' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
    
    public function showReset($token)
    {
        return view('auth.reset', ['token' => $token]);
    }
    
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('user.login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($this->userService->login($request))
        {
            return redirect('users/dashboard');
        } 
        else 
        {
            return back()->withErrors(['error' => "Incorrect Credentials"]);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha_num|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed|min:5'
        ]);
        $user = $this->userService->register($request);
        if ($user)
        {
            Auth::login($user, true);
            Mail::to($user)->send(new WelcomeNotification($user));
            return redirect('/users/dashboard');
        }else
        {
            return back()->withErrors(['error' => 'Failed try again']);
        }
    }

    public function dashboard()
    {
        $data = $this->userService->dashboardContent();
        return view('users.dashboard', ['data' => $data]);
    }

    public function profile()
    {
        $banks = Http::withHeaders([
            'Authorization' => 'Bearer '. env('FLW_SECRET_KEY')
        ])->get('https://api.flutterwave.com/v3/banks/ng')->json();
        return view('users.profile', ['banks' => $banks['data']]);
    }

    public function setPayment(Request $request)
    {
        $setPayment = $this->userService->setPayment(auth()->id(),$request);
        return back()->with('message', 'Info Saved');
    }

    public function withdraw()
    {
        return view('users.withdraw');
    }

    public function deposits()
    {
        return view('users.deposits');
    }

    public function earnings()
    {
        $locked = count($this->userService->inactiveDownlines(auth()->id()));
        $earnings = $this->earningService->getUserEarnings(auth()->id());
        return view('users.earnings', ['locked' => $locked, 'earnings' => $earnings]);
    }

    public function referrals()
    {
        $downlines = $this->userService->downlines(auth()->id());
        return view('users.referrals', ['downlines' => $downlines]);
    }

    public  function withdrawals()
    {
        return view('users.withdrawals');
    }

    public function transactions()
    {
        $invoices = $this->userService->userInvoices(auth()->id());
        return view('users.transactions', ['invoices' => $invoices]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/users/login');
    }
}
