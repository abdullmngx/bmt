@extends('users.layouts.app')
@section('title', 'Deposits')
@section('content')
<div class="main-container">
    <div class="container mb-4">
        <div class="row">
            <div class="col">
                <h6 class="subtitle mb-3">My Bots </h6>
            </div>
        </div>
        <div class="row">
            @if (auth()->user()->deposits())
            @foreach (auth()->user()->deposits as $deposit)                
            <div class="col-12 col-md-6">
                <div class="card border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-50 border-0 bg-default-light rounded-circle text-default">
                                    <i class="material-icons vm text-template">smart_toy</i>
                                </div>
                            </div>
                            <div class="col-4 align-self-center">
                                <h6 class="mb-1">{{ $deposit['plan_name'] }}</h6>
                                <p class="small text-secondary">{{ $deposit['created_at']->format('y-m-d h:ia') }}</p>
                            </div>
                            <div class="col-auto align-self-center border-left">
                                <h6 class="mb-1">$ {{ number_format($deposit['amount'], 2) }}</h6>
                                <p class="small text-secondary">Exp: {{ date_format(date_create($deposit['expiry']), 'y-m-d h:ia') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="alert alert-danger">You have no active bot</div>
            @endif
        </div>
    </div>
</div>
</main>
@endsection