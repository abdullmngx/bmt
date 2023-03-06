<?php 

namespace App\Services;

use App\Repositories\DepositRepository;
use App\Repositories\EarningRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\PlanRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    protected $invoiceRepository, $planRepository, $depositRepository, $earningRepository, $userRepository;

    public function __construct(InvoiceRepository $invoiceRepository, PlanRepository $planRepository, DepositRepository $depositRepository, EarningRepository $earningRepository, UserRepository $userRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->planRepository = $planRepository;
        $this->depositRepository = $depositRepository;
        $this->earningRepository = $earningRepository;
        $this->userRepository = $userRepository;
    }

    public function generate($plan_id, $user_id)
    {
        $plan = $this->planRepository->show($plan_id);
        return $this->invoiceRepository->create([
            'user_id' => $user_id,
            'plan_id' => $plan_id,
            'amount' => $plan['amount'],
            'reference' => $this->genReference()
        ]);
    }

    public function getById($invoice_id)
    {
        return $this->invoiceRepository->show($invoice_id);
    }

    protected function genReference()
    {
        return rand(100, 999).date('ymdhis');
    }

    public function charge($request)
    {
        $plan = $this->planRepository->show($request->plan_id);
        $data = [
            "price_amount" => $plan['amount'],
            "price_currency" => "usdttrc20",
            "pay_currency" => "usdttrc20",
            "ipn_callback_url" => "https://".request()->getHost()."/api/users/pay-callback",
            "order_id" => $request->invoice_id,
            //"case" => "success"
        ];
        $headers = [
            "Content-Type" => "application/json",
            "x-api-key" => env('NOWPAYMENTS_API_KEY'),
        ];

        $response = Http::withHeaders($headers)->post(env('LIVE_PAYMENT_API'), $data)->json();
        //$this->invoiceRepository->update($request->invoice_id, ['trx_id' =>$response['payment_id']]);
        return $response;
    }

    public function verify($code)
    {
        $headers = [
            "Content-Type" => "application/json",
            "x-api-key" => env('NOWPAYMENTS_API_KEY'),
        ];
        $resp = Http::withHeaders($headers)->get(env('LIVE_CHECKSTATUS_API').$code)->json();
        //return $resp;
        $statuses = ['confirmed', 'sending', 'finished'];
        if (in_array($resp['payment_status'], $statuses))
        {
            $this->invoiceRepository->update($resp['order_id'], ['status' => 'successful', 'payment_channel' => $resp['pay_address']]);
            $invoice = $this->invoiceRepository->show($resp['order_id']);
            $depositExists = $this->depositRepository->checkRef($invoice->reference);
            if (!$depositExists)
            {
                if ($resp['actually_paid'] >= $invoice['amount'])
                {
                    $hasAPaidPlan = $this->depositRepository->getUserPaid(auth()->id());
                    if (!$hasAPaidPlan){
                        $ref_bonus = $this->percentage(5, $invoice->plan['amount']);
                        $oneUsd = 1;
                        $ref = auth()->user()->ref;
                        $this->earningRepository->create([
                            'user_id' => $ref,
                            'amount' => $ref_bonus,
                            'day_posted' => date('Y-m-d'),
                            'type' => 'referral'
                        ]);
                        $this->earningRepository->create([
                            'user_id' => $ref,
                            'amount' => $oneUsd,
                            'day_posted' => date('Y-m-d'),
                            'type' => 'referral'
                        ]);
                    }
                    $this->depositRepository->create([
                        'user_id' => $invoice->user_id,
                        'plan_id' => $invoice->plan_id,
                        'amount' => $invoice->plan['amount'],
                        'expiry' => now()->addDays($invoice->plan['period']),
                        'reference' => $invoice->reference,
                        'status' => 'active'
                    ]);
                }
            }
            return true;
        }
        return false;
    }

    protected function percentage(int $num, $amount)
    {
        return ($num/100 * $amount);
    }

    public function webhookVerify($request)
    {
        $resp = $request->all();
        //return $resp;
        $statuses = ['confirmed', 'sending', 'finished'];
        if (in_array($resp['payment_status'], $statuses))
        {
            $this->invoiceRepository->update($resp['order_id'], ['status' => 'successful', 'payment_channel' => $resp['pay_address']]);
            $invoice = $this->invoiceRepository->show($resp['order_id']);
            $user = $this->userRepository->show($invoice['user_id']);
            $depositExists = $this->depositRepository->checkRef($invoice->reference);
            if (!$depositExists)
            {
                if ($resp['actually_paid'] >= $invoice['amount'])
                {
                    $hasAPaidPlan = $this->depositRepository->getUserPaid($user->id);
                    if (!$hasAPaidPlan && !is_null($user->ref)){
                        $ref_bonus = $this->percentage(5, $invoice->plan['amount']);
                        $oneUsd = 1;
                        $ref = $user->ref;
                        $this->earningRepository->create([
                            'user_id' => $ref,
                            'amount' => $ref_bonus,
                            'day_posted' => date('Y-m-d'),
                            'type' => 'referral'
                        ]);
                        $this->earningRepository->create([
                            'user_id' => $ref,
                            'amount' => $oneUsd,
                            'day_posted' => date('Y-m-d'),
                            'type' => 'referral'
                        ]);
                    }
                    $this->depositRepository->create([
                        'user_id' => $invoice->user_id,
                        'plan_id' => $invoice->plan_id,
                        'amount' => $invoice->plan['amount'],
                        'expiry' => now()->addDays($invoice->plan['period']),
                        'reference' => $invoice->reference,
                        'status' => 'active'
                    ]);
                }
            }
            return true;
        }
        return false;
    }
    
    public function processPay($status, $ref, $tx_id)
    {
        $user = auth()->user();
        $validation = $this->validateTrx($tx_id);
        if ($validation->status == "success")
        {
            if ($validation->data->status == "successful")
            {
                $reference = $validation->data->tx_ref;
                $invoice = $this->invoiceRepository->getByRef($reference);
                try{
                    DB::beginTransaction();
                    $this->invoiceRepository->updateByRef($reference, ['trx_id' => $tx_id,'status' => 'successful', 'payment_channel' => $validation->data->payment_type]);
                    $depositExists = $this->depositRepository->checkRef($invoice->reference);
                    if (!$depositExists)
                    {
                        
                        $hasAPaidPlan = $this->depositRepository->getUserPaid($user->id);
                        if (!$hasAPaidPlan && !is_null($user->ref)){
                            $ref_bonus = $this->percentage(5, $invoice->plan['amount']);
                            $oneUsd = 1;
                            $ref = $user->ref;
                            $this->earningRepository->create([
                                'user_id' => $ref,
                                'amount' => $ref_bonus,
                                'day_posted' => date('Y-m-d'),
                                'type' => 'referral'
                            ]);
                            $this->earningRepository->create([
                                'user_id' => $ref,
                                'amount' => $oneUsd,
                                'day_posted' => date('Y-m-d'),
                                'type' => 'referral'
                            ]);
                        }
                        $this->depositRepository->create([
                            'user_id' => $invoice->user_id,
                            'plan_id' => $invoice->plan_id,
                            'amount' => $invoice->plan['amount'],
                            'expiry' => now()->addDays($invoice->plan['period']),
                            'reference' => $invoice->reference,
                            'status' => 'active'
                        ]);
                        return true;
                    }
                    DB::commit();
                    return true;
                }catch(Exception $e)
                {
                    DB::rollBack();
                    throw new Exception($e->getMessage());
                }
            }
            return false;
        }
        return false;
    }
    
    protected function validateTrx($tx_id)
    {
        $secret = env('FLW_SECRET_KEY');
        $headers = [
            "Content-Type" => "application/json",
            "Authorization" => "Bearer ". $secret
        ];
        $response = Http::withHeaders($headers)->get('https://api.flutterwave.com/v3/transactions/'.$tx_id.'/verify')->body();
        return json_decode($response);
    }
    
    public function flwWebhook($request)
    {
        if ($request->event == "charge.completed" && $request->data['status'] == "successful")
        {
            $sec_hash = env('FLW_SECRET_HASH');
            $hash = $request->header('verif-hash');
            if ($hash == $sec_hash){
                $ref = $request->data['tx_ref'];
                $payment = $this->invoiceRepository->getByRef($ref);
                $amount = $payment->amount;
                $user_id = $payment->user_id;
                $this->invoiceRepository->updateByRef($ref,['trx_id' => $request->data['id'],'status' => 'successful', 'payment_channel' => $request->data['payment_type']]);
                $user = $this->userRepository->show($user_id);
                $depositExists = $this->depositRepository->checkRef($ref);
                    if (!$depositExists)
                    {
                        
                        $hasAPaidPlan = $this->depositRepository->getUserPaid($user->id);
                        if (!$hasAPaidPlan && !is_null($user->ref)){
                            $ref_bonus = $this->percentage(5, $invoice->plan['amount']);
                            $oneUsd = 1;
                            $ref = $user->ref;
                            $this->earningRepository->create([
                                'user_id' => $ref,
                                'amount' => $ref_bonus,
                                'day_posted' => date('Y-m-d'),
                                'type' => 'referral'
                            ]);
                            $this->earningRepository->create([
                                'user_id' => $ref,
                                'amount' => $oneUsd,
                                'day_posted' => date('Y-m-d'),
                                'type' => 'referral'
                            ]);
                        }
                        $this->depositRepository->create([
                            'user_id' => $payment->user_id,
                            'plan_id' => $payment->plan_id,
                            'amount' => $payment->plan['amount'],
                            'expiry' => now()->addDays($payment->plan['period']),
                            'reference' => $payment->reference,
                            'status' => 'active'
                        ]);
                    }
                return response(200);
            }
        }
        return "bad";
    }
}