<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlanRequest;
use Illuminate\Http\Request;
use App\Services\PlanService;
use Exception;

class PlanController extends Controller
{
    protected $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }

    public function managePlans()
    {
        $plans = $this->planService->showAll();
        return view('admin.plans')->with('plans', $plans);
    }

    public function create(Request $request)
    {   
        if ($this->planService->createPlan($request))
        {
            return back()->with("message", $request->name. " plan created.");
        }
    }

    public function destroy($id)
    {
        $this->planService->deletePlan($id);
        return back()->with("message", "Plan Deleted!");
    }

    public function activate($id)
    {
        $details = ['status' => 'active'];
        $this->planService->update($id, $details);
        return back()->with("message", "Plan Activated!");
    }

    public function block($id)
    {
        $details = ['status' => 'blocked'];
        $this->planService->update($id, $details);
        return back()->with("message", "Plan blocked!");
    }

    public function reserve($id)
    {
        $details = ['status' => 'reserved'];
        $this->planService->update($id, $details);
        return back()->with("message", "Plan reserved!");
    }
}
