@extends('users.layouts.app')
@section('title', 'Earnings')
@section('content')
<div class="container mt-3 mb-4 text-center">
    <h2 class="text-white">$ {{ number_format(auth()->user()->total_balance, 2) }}</h2>
    <p class="text-white mb-4">Total Earnings</p>
</div>

<div class="main-container">
    <!-- page content start -->

    <div class="container mb-4 text-center">
        <div class="card bg-default-secondary shadow-default">
            <div class="card-body">
                <!-- Swiper -->
                <div class="swiper-container addsendcarousel text-center">
                   <div class="row">
                        <div class="col-4">
                            <h4>{{ number_format(auth()->user()->deposit_earnings_balance, 2) }}</h4>
                            <p>Bots Earnings</p>
                        </div>
                        <div class="col-4">
                            <h4>{{ number_format(auth()->user()->referral_earnings_balance, 2) }}</h4>
                            <p>Referral Earnings</p>
                        </div>
                        <div class="col-4">
                            <h4>{{ number_format((auth()->user()->ref_count - auth()->user()->count_active_ref), 2) }}</h4>
                            Locked Earnings
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-4">
        <div class="row">
            <div class="col">
                <h6 class="subtitle mb-3">Earnings</h6>
            </div>
        </div>
        <div class="row">
            @foreach ($earnings as $earning)                
            <div class="col-12 col-md-6">
                <div class="card border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-50 border-0 bg-default-light rounded-circle text-default">
                                    <i class="material-icons vm text-template">monetization_on</i>
                                </div>
                            </div>
                            <div class="col-auto align-self-center">
                                <h6 class="mb-1">$ {{ number_format($earning['amount'], 2) }}</h6>
                                <p class="small text-secondary">{{ $earning['type'] == "deposit" ? 'From ' . $earning['deposit']['plan_name'].' bot' : 'From '. $earning['type']  }}</p>
                                <p class="small text-secondary">{{ $earning['created_at']->format('Y-m-d h:ia') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-12">
                @if ($earnings->hasPages())
                    {{ $earnings->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
</main>
@endsection