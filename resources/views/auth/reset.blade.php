@extends('auth.layouts.auth')
@section('title', 'Login')
@section('content')
<form action="/users/reset" method="POST">
    @csrf
<div class="container h-100 text-white">
    <div class="row h-100">
        <div class="col-12 align-self-center mb-4">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                    <h2 class="font-weight-normal mb-5">VIP Lounge</h2>
                    <p>Reset Password</p>
                    <input type="hidden" name="email" value="{{ request()->email }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group float-label">
                        <input type="password" name="password" class="form-control text-white">
                        <label class="form-control-label text-white">New Password</label>
                    </div>
                    <div class="form-group float-label position-relative">
                        <input type="password" name="password_confirmation" class="form-control text-white ">
                        <label class="form-control-label text-white">Confirm Password</label>
                    </div>
                    <p class="text-right"><a href="/users/login" class="text-white">Know your Password? Login</a></p>

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
</main>

<!-- footer-->
<div class="footer no-bg-shadow py-3">
<div class="row justify-content-center">
    <div class="col">
        <button type="submit" class="btn btn-default rounded btn-block">Reset Password</button>
    </div>
</div>
</div>
</form>
@endsection