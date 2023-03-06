<?php 

namespace App\Services;

use App\Http\Requests\UserLoginRequest;
use App\Mail\PromotionalNotification;
use App\Repositories\AdminRepository;
use App\Repositories\DepositRepository;
use App\Repositories\PlanRepository;
use App\Repositories\UserRepository;
use App\Repositories\WithdrawalRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminService
{
    protected $adminRepository, $userRepository, $planRepository, $depositRepository, $withdrawalRepository;

    public function __construct(AdminRepository $adminRepository, UserRepository $userRepository, PlanRepository $planRepository, DepositRepository $depositRepository, WithdrawalRepository $withdrawalRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
        $this->planRepository  = $planRepository;
        $this->depositRepository = $depositRepository;
        $this->withdrawalRepository = $withdrawalRepository;
    }

    public function login($request)
    {
        return Auth::guard('admin')->attempt($request->only('email', 'password'), $request->remember);
    }

    public function getUsers()
    {
        return $this->userRepository->all();
    }

    public function getTeam()
    {
        return $this->adminRepository->all();
    }

    public function getUserById($id)
    {
        return $this->userRepository->show($id);
    }

    public function dashboardData()
    {
        $counts = [];
        $counts['users'] = $this->userRepository->all()->count();
        $counts['team'] = $this->adminRepository->all()->count();
        $counts['plans'] = $this->planRepository->all()->count();
        $counts['activeDeposits'] = $this->depositRepository->getActive()->count();
        $plans = $this->planRepository->all();
        $dashboard = [
            "counts" => $counts,
            "plans" => $plans
        ];
        return $dashboard;
    }

    public function getAllDeposits()
    {
        return $this->depositRepository->all();
    }

    public function getAllWithdrawals()
    {
        return $this->withdrawalRepository->all();
    }

    public function depositUser($request)
    {
        $plan = $this->planRepository->show($request['plan_id']);
        $details = [
            'user_id' => $request->user_id,
            'plan_id' => $plan->id,
            'amount' => $plan->amount,
            'expiry' => now()->addDays($plan->period)
        ];
        return $this->depositRepository->create($details);
    }

    public function sendPromotional($request)
    {
        $file = $request->file('file')->getRealPath();
        $fileOpen = fopen($file, 'r');
        $users = fgetcsv($fileOpen);
        foreach ($users as $user) 
        {
            if ($user!= "")
            {
                $data = ['mail' => $request->mail_content];
                Mail::to($user)->send(new PromotionalNotification($data));
            }
        }
        return true;
    }
}