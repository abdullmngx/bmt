<?php 

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\DepositRepository;
use App\Repositories\EarningRepository;
use App\Repositories\PlanRepository;
use Carbon\Carbon;

class EarningService
{
    protected $userRepository, $depositRepository, $earningRepository, $planRepository;

    public function __construct(UserRepository $userRepository, DepositRepository $depositRepository, EarningRepository $earningRepository, PlanRepository $planRepository)
    {
        $this->userRepository = $userRepository;
        $this->depositRepository = $depositRepository;
        $this->earningRepository = $earningRepository;
        $this->planRepository = $planRepository;
    }

    public function postUserEarnings()
    {
        $this->depositRepository->updateExpiring();
        $deposits = $this->depositRepository->getActive();
        foreach ($deposits as  $deposit)
        {
            $depositDate = Carbon::parse($deposit['created_at']);
            $deposit_time = $depositDate->format('H:i:s');
            $time_now = now()->format('H:i:s');
            $day = now()->format('Y-m-d');
            $days = now()->diffInDays($depositDate);
            if ($days > 0)
            {
                if ($time_now >= $deposit_time)
                {
                    if (!$this->earningRepository->todayExists($deposit['user_id'], $day, $deposit['id']))
                    {
                        $plan = $this->planRepository->show($deposit['plan_id']);
                        $this->earningRepository->create([
                            'user_id' => $deposit['user_id'],
                            'deposit_id' => $deposit['id'],
                            'amount' => $plan['daily_earning'],
                            'day_posted' => $day,
                            'type' => 'deposit'
                        ]);
                    }
                }
            }
        }
    }

    public function getUserEarnings($user_id)
    {
        return $this->earningRepository->getByUserId($user_id);
    }
}