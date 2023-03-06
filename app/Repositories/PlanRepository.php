<?php 

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository
{
    protected $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function create(array $details)
    {
        return $this->plan->create($details);
    }

    public function all()
    {
        return $this->plan->all();
    }

    public function getPurchaseble()
    {
        return $this->plan->where('status', 'active')->where('amount', '>', 0.00)->get();
    }

    public function show($id)
    {
        return $this->plan->where('id', $id)->with(['deposits' => function ($q) {
            $q->where('status', 'active');
        }])->first();
    }

    public function update($id, array $details)
    {
        return $this->plan->where('id', $id)->update($details);
    }

    public function delete($id)
    {
        return $this->plan->where('id', $id)->delete();
    }

    public function count()
    {
        return $this->plan->count();
    }

    public function countActiveDeposits($id)
    {
        return $this->show($id)->deposits()->count();
    }

    public function getFreePlan()
    {
        return $this->plan->where('amount', 0.00)->where('status', 'active')->first();
    }
}