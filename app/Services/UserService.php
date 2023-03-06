<?php 

namespace App\Services;

use App\Repositories\DepositRepository;
use App\Repositories\EarningRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\PlanRepository;
use App\Repositories\UserRepository;
use App\Repositories\WithdrawalRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository, $invoiceRepository, $depositRepository, $earningRepository, $withdrawalRepository, $planRepository;

    public function __construct(UserRepository $userRepository, InvoiceRepository $invoiceRepository, DepositRepository $depositRepository, EarningRepository $earningRepository, WithdrawalRepository $withdrawalRepository, PlanRepository $planRepository)
    {
        $this->userRepository = $userRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->depositRepository = $depositRepository;
        $this->earningRepository = $earningRepository;
        $this->withdrawalRepository = $withdrawalRepository;
        $this->planRepository = $planRepository;
    }

    public function register($request)
    {
        $details = $request->only('name', 'email', 'phone', 'password', 'ref');
        $details['password'] = Hash::make($request->password);
        $user = $this->userRepository->create($details);
        $free_plan = $this->planRepository->getFreePlan();
        if ($free_plan)
        {
            $this->depositRepository->create([
                'user_id' => $user->id,
                'plan_id' => $free_plan->id,
                'amount' => $free_plan->amount,
                'expiry' => now()->addDays($free_plan->period)
            ]);
        }
        return $user;
    }

    public function login($request)
    {
        return Auth::attempt($request->only('email', 'password'), $request->remember);
    }

    public function dashboardContent()
    {
        return [
            "plans" => $this->planRepository->getPurchaseble()
        ];
    }

    public function setPayment($user_id, $request)
    {
        $details = $request->only('account_name', 'account_number', 'wallet_address');
        $details['bank_name'] = explode('-', $request->bank)[0];
        $details['bank_code'] = explode('-', $request->bank)[1];
        $details['bank_status'] = 'set';
        return $this->userRepository->update($user_id, $details);
    }

    public function downlines($user_id)
    {
        return $this->userRepository->getRefs($user_id);
    }

    public function inactiveDownlines($user_id)
    {
        $downlines = $this->userRepository->getRefs($user_id);
        $inactive = [];
        foreach($downlines as $downline)
        {
            if (!$downline['active_status'])
            {
                $inactive[] = $downline;
            }
        }
        return $inactive;
    }

    public function userInvoices($user_id)
    {
        return $this->invoiceRepository->getByUserId($user_id);
    }

    public function getUser($id)
    {
        return $this->userRepository->show($id);
    }
}