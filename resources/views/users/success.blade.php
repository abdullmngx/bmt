@extends('users.layouts.app')
@section('title', 'Success')
@section('content')
<div class="main-container">
    <div class="container mb-4">
        <div class="text-center">
            <div class=""><i class="material-icons text-success" style="font-size: 98px">check_circle</i></div>
            <h4>Payment successful, your bot has been activated.</h4>
            <p><a href="/users/dashboard" class="btn btn-info rounded-pill">Back to Dashboard</a></p>
        </div>
    </div>
    <div class="container text-center">
    </div>
</div>
</main>
@endsection