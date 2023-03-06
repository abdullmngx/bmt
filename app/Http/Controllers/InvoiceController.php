<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use App\Model\Setting;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function generate($plan_id)
    {
        $invoice = $this->invoiceService->generate($plan_id, auth()->id());
        return redirect('/users/invoice/'.$invoice->id);
    }

    public function showInvoice($invoice_id)
    {
        $invoice = $this->invoiceService->getById($invoice_id);
        $public_key = env('FLW_PUBLIC_KEY');
        return view('users.invoice', ['invoice' => $invoice, 'public' => $public_key]);
    }

    public function createCharge(Request $request)
    {
        $resp = $this->invoiceService->charge($request);
        return view('users.pay')->with('response', $resp);
    }

    public function showPayment()
    {
        return view('users.pay');
    }

    public function verify($code)
    {
        if ($this->invoiceService->verify($code))
        {
            return redirect('/users/payment/success');
        }
        return redirect('/users/payment/failed/'. $code);
    } 

    public function success()
    {
        return view('users.success');
    }

    public function failed($code)
    {
        return view('users.fail', ['code' => $code]);
    }

    public function webhook(Request $request)
    {
        if ($this->invoiceService->webhookVerify($request))
        {
            return response("ok", 200);
        }
    }
    
    public function process(Request $request)
    {
        $status = $request->status;
        $ref = $request->tx_ref;
        $tx_id = $request->transaction_id;

        if ($this->invoiceService->processPay($status, $ref, $tx_id))
        {
            return redirect('/users/payment/success');
        }
    }
    
    public function flwWebhook(Request $request)
    {
        return $this->invoiceService->flwWebhook($request);
    }
}
