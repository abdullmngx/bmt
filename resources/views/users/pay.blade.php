@extends('users.layouts.app')
@section('title', 'Payment')
@section('content')
<div class="main-container">
    <div class="container mb-4">
        <div class="form-group mb-1">
            <input type="text" class="form-control large-gift-card" value="{{ $response['pay_amount']+1 }} {{ strtoupper($response['pay_currency']) }}" placeholder="00.00" readonly>
        </div>
        <p>Payment Wallet Address</p>
        <div class="form-group position-relative">
            <div class="bottom-right mb-1 mr-1">
                <button class="btn btn-sm btn-success rounded copy">Copy</button>
            </div>
            <input type="text" class="form-control" placeholder="wallet address" id="wallet" value="{{ $response['pay_address'] }}">
        </div>
        <div class="alert alert-success">
            <div class="media">
                <div class="icon icon-40 bg-white text-success mr-2 rounded-circle"><i class="material-icons">local_offer</i></div>
                <div class="media-inner">
                    <p>Copy the above wallet address and send the specified amount to activate your bot</p>
                    <p>Once payment is made, click on the button below to confirm and activate your bot.</p>
                    <p>The provided wallet address is on Tron (USDTTRC20) network.</p>
                    <p>1 USDT processing fee is included in your payment.</p>
                    <p>Once your payment is confirmed on the blockchain the system will automatically activate your bot</p>
                    <p>However you can click on "I have made payment" button below to verify payment yourself.</p>
                    <p>please wait atleast 5-10 mins to verify payment, as your payment does not reflect immediately on the blockchain.</p>
                    <p><span class="text-danger"><b>Note</b> any amount lesser than the amount specified will result in loss of funds and VIP Lounge holds not account for such loss.</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center">
        <a href="/users/payment/verify/{{ $response['payment_id'] }}" class="btn btn-default mb-2 mx-auto rounded">I have made payment.</a>
    </div>
</div>
</main>

@endsection