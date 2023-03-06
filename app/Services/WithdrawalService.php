<?php 

namespace App\Services;

use App\Models\Setting;
use App\Repositories\WithdrawalRepository;
use Error;
use Illuminate\Support\Facades\Http;

class WithdrawalService 
{
    protected $withdrawalRepository;

    public function __construct(WithdrawalRepository $withdrawalRepository)
    {
        $this->withdrawalRepository = $withdrawalRepository;
    }

    public function withdraw($request)
    {
        $user = auth()->user();
        $details = $request->only('user_id', 'amount');
        $details['type'] = $request->pay_type;
        $details['status'] = 'pending';
        $pending = $this->withdrawalRepository->getUserPending($request->user_id);
        $settings = Setting::first();
        if ($settings->withdrawal == "close")
        {
            return ["error" => true, "data" => "Withdrawal is closed at the moment"];
        }
        if ($request->amount >= 5)
        {
            if ($request->amount > auth()->user()->total_balance) 
            {
                return ["error" => true, "data" => "Insufficient funds"];
            }

            if ($pending)
            {
                return ["error" => true, "data" => "You already have a pending request"];
            }

            if ($request->pay_type == "fiat")
            {
                if ($user->bank_status == 'unset')
                {
                    return ["error" => true, "data" => "Please set your bank account"];
                }
                $secret = env('FLW_SECRET_KEY');
                $headers = [
                    "Content-Type" => "application/json",
                    "Authorization" => "Bearer ". $secret
                ];
                $amt = $request->amount - $this->tenPer($request->amount);
                $converted_amt = $amt * $settings->dollar_rate;
                $trfdetails = [
                    "account_bank" => auth()->user()->bank_code,
                    "account_number" => auth()->user()->account_number,
                    "amount" => $converted_amt,
                    "narration" => "Trf",
                    "currency" => "NGN",
                    "reference" => rand(10,99).date('ymdhis'),
                ];
                $response = Http::withHeaders($headers)->post('https://api.flutterwave.com/v3/transfers', $trfdetails)->body();
                $resp = json_decode($response, true);
                if ($resp['status'] == "success")
                {
                    $details['status'] = "approved";
                }
            }else {
                if ($settings->crypto_withdrawal == "close")
                {
                    return ["error" => true, "data" => "Crypto Withdrawal is not available at the moment, Please  try other option"];
                }
                if (is_null(auth()->user()->wallet_address))
                {
                    return ["error" => true, "data" => 'Please set your wallet address'];
                }
            }
            return ["error" => false, "data" => $this->withdrawalRepository->create($details)];
        }else 
        {
            return ["error" => true, "data" => "Amount cannot be less than 10"];
        }
    }

    private function tenPer($amount)
    {
        return (10/100 * $amount);
    }
}