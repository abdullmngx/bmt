@extends('users.layouts.app')
@section('title', 'Withdrawals')
@section('content')
<div class="container mt-3 mb-4 text-center">
    <h2 class="text-white">$ {{ number_format(auth()->user()->withdrawal_balance, 2) }}</h2>
    <p class="text-white mb-4">Total Amount Withdrawn</p>
</div>

<div class="main-container">
    <!-- page content start -->

    <div class="container mb-4">
        <div class="row">
            <div class="col">
                <h6 class="subtitle mb-3">Withdrawals</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-4">
                <a href="/users/withdraw" class="">Click here to withdraw</a>
            </div>
            @if (auth()->user()->withdrawals)
            @foreach (auth()->user()->withdrawals as $withdrawal)                
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
                                <h6 class="mb-1">$ {{ number_format($withdrawal['amount'], 2) }}</h6>
                                <p class="small text-secondary">{{ $withdrawal['status'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-12">
                <div class="alert alert-danger">You have no withdrawal record</div>
            </div>
            @endif
        </div>
    </div>
</div>
</main>
@endsection