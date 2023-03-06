<?php 

namespace App\Services;

use App\Repositories\PlanRepository;

class PlanService
{
    protected $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function showAll()
    {
        return $this->planRepository->all();
    }

    public function createPlan($request)
    {
        $details = $request->only('name', 'amount', 'daily_earning', 'period', 'status');
        $details['created_by'] = auth('admin')->id();
        return $this->planRepository->create($details);
    }

    public function deletePlan($id)
    {
        return $this->planRepository->delete($id);
    }

    public function update($id, $details)
    {
        return $this->planRepository->update($id, $details);
    }
}