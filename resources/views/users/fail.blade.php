@extends('users.layouts.app')
@section('title', 'Failed')
@section('content')
<div class="main-container">
    <div class="container mb-4">
        <div class="text-center">
            <div class=""><i class="material-icons text-danger" style="font-size: 98px">highlight_off</i></div>
            <h4>Payment is not completed, click the button below to re-try verification</h4>
            <p><a href="/users/payment/verify/{{ $code }}" class="btn btn-info rounded-pill">Try again</a></p>
        </div>
    </div>
    <div class="container text-center">
    </div>
</div>
</main>
@endsection