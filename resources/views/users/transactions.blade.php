@extends('users.layouts.app')
@section('title', 'Transactions')
@section('content')
<div class="main-container">
    <div class="container mb-4">
        <div class="row">
            <div class="col">
                <h6 class="subtitle mb-3">My Transactions </h6>
            </div>
        </div>
        <div class="row">
            @if ($invoices)
            @foreach ($invoices as $invoice)                
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
                                <h6 class="mb-1">{{ $invoice['plan_name'] }}</h6>
                                <p class="small text-secondary">{{ $invoice['created_at']->format('y-m-d h:ia') }}</p>
                            </div>
                            <div class="col-auto align-self-center border-left">
                                <h6 class="mb-1">$ {{ number_format($invoice['amount'], 2) }}</h6>
                                <p class="small text-secondary">{{ $invoice['status'] }}</p>
                                <a href="/users/invoice/{{ $invoice['id'] }}">view</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if ($invoices->hasPages())
                <div class="col-12">
                    {{ $invoices->links() }}
                </div>
            @endif
            @else
            <div class="alert alert-danger">You have no transaction record</div>
            @endif
        </div>
    </div>
</div>
</main>
@endsection