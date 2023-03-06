@extends('users.layouts.app')
@section('title', 'Withdraw')
@section('content')
<div class="main-container">
    <form action="" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    <div class="container mb-4">
        <div class="form-group mb-1">
            <input type="number" class="form-control large-gift-card" name="amount" placeholder="00.00" required autofocus>
        </div>
        <p>Payment options</p>
        <div class="form-group mb-4">
            <select name="pay_type" id="" class="form-control" required>
                <option value="fiat">Fiat</option>
                <option value="crypto">Crypto</option>
            </select>
        </div>
        <div class="alert alert-info">
            <div class="media">
                <div class="icon icon-40 bg-white text-success mr-2 rounded-circle"><i class="material-icons">local_offer</i></div>
                <div class="media-inner">
                    <p>The fiat option sends funds to your local bank account</p>
                    <p>Crypto payments sends funds to your receiving wallet</p>
                    <p>Both account and wallet should be set from your profile.</p>
                    <p><span class="text-danger"><b>Note</b> both payment options draws a service charge of 10% of withdrawal amount.</span></p>
                </div>
            </div>
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
    <div class="container text-center">
        <button type="submit" class="btn btn-default mb-2 mx-auto rounded">Withdraw</button>
    </div>
    </form>
</div>
</main>

@endsection