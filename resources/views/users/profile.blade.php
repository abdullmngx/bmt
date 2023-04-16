@extends('users.layouts.app')
@section('title', 'Profile')
@section('content')
<div class="main-container">
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="subtitle mb-0">
                    <div class="avatar avatar-40 bg-default-light text-default rounded mr-2"><span class="material-icons vm">lock</span></div>
                    Set Bank Account
                </h6>
            </div>
            <form method="POST" action="/users/set-bank">
                @csrf
                <div class="card-body">
                    <div class="alert alert-danger">
                        <b>Please Note that only USDTTRC20 is supported for crypto transactions</b>
                    </div>
                    {{-- <div class="form-group float-label {{ !is_null(auth()->user()->account_name) ? 'active' : '' }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="text" class="form-control" name="account_name" value="{{ auth()->user()->account_name }}">
                        <label class="form-control-label">Account Name <span class="text-danger">*</span></label>
                    </div>
                    <div class="form-group float-label {{ !is_null(auth()->user()->account_number) ? 'active' : '' }}">
                        <input type="text" name="account_number" class="form-control" value="{{ auth()->user()->account_number }}">
                        <label class="form-control-label">Account Number <span class="text-danger">*</span></label>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Bank <span class="text-danger">*</span></label>
                        <select class="form-control" name="bank"> 
                            <option value="">Select Bank</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank['name'] }}-{{ $bank['code'] }}" {{ $bank['code'] === auth()->user()->bank_code ? 'selected' : '' }}>{{ $bank['name'] }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group float-label {{ !is_null(auth()->user()->wallet_address) ? 'active' : '' }}">
                        <input type="text" class="form-control" name="wallet_address" value="{{ auth()->user()->wallet_address }}">
                        <label class="form-control-label">USDT Wallet Address</label>
                    </div>
                    @if(session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-block btn-default rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>
@endsection