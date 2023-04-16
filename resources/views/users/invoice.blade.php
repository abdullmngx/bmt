@extends('users.layouts.app')
@section('title', 'Invoice')
@section('content')
<div class="main-container">
    <form method="POST" action="/users/charge">
        @csrf
    <div class="container mb-4">
        <p class="text-center text-secondary mb-1">{{ $invoice['plan_name'] }}</p>
        <div class="form-group mb-1">
            <input type="text" class="form-control large-gift-card" value="{{ $invoice['amount'] }} USDT" placeholder="00.00" readonly>
            <input type="hidden" name="amount" value="{{ $invoice['amount'] }}">
            <input type="hidden" name="user" value="{{ $invoice['user']['name'] }}">
            <input type="hidden" name="plan_id" value="{{ $invoice['plan_id'] }}">
            <input type="hidden" name="invoice_id" value="{{ $invoice['id'] }}">
        </div>
        <div class="alert alert-success">
            <div class="media">
                <div class="icon icon-40 bg-white text-success mr-2 rounded-circle"><i class="material-icons">local_offer</i></div>
                <div class="media-inner">
                    <h6 class="mb-0 font-weight-normal">
                        <b>Earn ${{ $invoice['plan']['daily_earning'] }}</b> Daily<br>
                        <small class="text-mute">for <b>{{ $invoice['plan']['period'] }}</b> days</small>
                    </h6>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center">
        <button type="submit" class="btn btn-default mb-2 mx-auto rounded">Pay With Crypto</button>
        {{-- <button type="button" class="btn btn-warning mb-2 mx-auto rounded" onclick="makePayment()">Bank Transfer</button>--}}
    </div>
    </form>
</div>
</main>

@endsection

@section('scripts')
<script src="https://checkout.flutterwave.com/v3.js"></script>
{{--
<script>
    function makePayment() 
    {
        FlutterwaveCheckout({
            public_key: "{{ $public }}",
            tx_ref: "{{ $invoice['reference'] }}",
            amount: {{ $invoice['amount'] * 750 }},
            currency: "NGN",
            payment_options: "banktransfer",
            redirect_url: "https://viplounge.pro/users/payments/pay/accept",
            customer: {
            email: "{{ auth()->user()->email }}",
            phone_number: "{{ auth()->user()->phone_number }}",
            name: "{{ auth()->user()->name }}",
            },
            customizations: {
            title: "Mortgage FLW",
            description: "Payment for an awesome cruise",
            logo: "{{ asset('logo.png') }}",
            }
        });
    }
</script> --}}
@endsection