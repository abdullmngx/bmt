<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WithdrawalService;

class WithdrawalController extends Controller
{
    protected $withdrawalService;

    public function __construct(WithdrawalService $withdrawalService)
    {
        $this->withdrawalService = $withdrawalService;
    }

    public function withdraw(Request $request)
    {
        $withdrawal = $this->withdrawalService->withdraw($request);
        if (!$withdrawal['error'])
        {
            return back()->with('message', 'Withdrawal Submitted');
        }
        else 
        {
            return back()->withErrors(["error" => $withdrawal['data']]);
        }
    }
}
