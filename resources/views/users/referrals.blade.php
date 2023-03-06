@extends('users.layouts.app')
@section('title', 'Referrals')
@section('content')
<div class="main-container">
    <div class="container mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title">My invitation link</h4>
                <div class="form-group position-relative">
                    <div class="bottom-right mb-1 mr-1">
                        <button class="btn btn-sm btn-success rounded copy">Copy</button>
                    </div>
                    <input type="text" class="form-control" placeholder="wallet address" id="wallet" value="{{ request()->getHost() }}/users/register/{{ base64_encode(auth()->id()) }}">
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-4">
        <div class="row">
            <div class="col">
                <h6 class="subtitle mb-3">My Referrals </h6>
            </div>
        </div>
        <div class="row">
            @if ($downlines)
            @foreach ($downlines as $downline)                
            <div class="col-12 col-md-6">
                <div class="card border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-50 border-0 bg-default-light rounded-circle text-default">
                                    <i class="material-icons vm text-template">account_circle</i>
                                </div>
                            </div>
                            <div class="col-auto align-self-center">
                                <h6 class="mb-1">{{ $downline['name'] }}</h6>
                                <p class="small text-secondary">{{ $downline['active_status']  ? 'Active'  : 'Inactive' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if ($downlines->hasPages())
                <div class="col-12">
                    {{ $downlines->links() }}
                </div>
            @endif
            @else
            <div class="alert alert-danger">You have no referrals</div>
            @endif
        </div>
    </div>
</div>
</main>
@endsection