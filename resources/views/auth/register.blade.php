@extends('auth.layouts.auth')
@section('title', 'Login')
@section('content')
<form method="POST">
    @csrf
<div class="container h-100 text-white">
    <div class="row h-100">
        <div class="col-12 align-self-center mb-4">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                    <h2 class="font-weight-normal mb-5">{{ env('APP_NAME') }}</h2>
                    <p>Create your account now</p>
                    <div class="form-group float-label">
                        <input type="text" name="name" class="form-control text-white">
                        <label class="form-control-label text-white">Username</label>
                    </div>
                    <div class="form-group float-label">
                        <input type="email" name="email" class="form-control text-white">
                        <label class="form-control-label text-white">Email</label>
                    </div>
                    <div class="form-group float-label">
                        <input type="number" name="phone" class="form-control text-white">
                        <label class="form-control-label text-white">Phone Number</label>
                    </div>
                    <div class="form-group float-label position-relative">
                        <input type="password" name="password" class="form-control text-white ">
                        <label class="form-control-label text-white">Password</label>
                    </div>
                    <div class="form-group float-label position-relative">
                        <input type="password" name="password_confirmation" class="form-control text-white ">
                        <label class="form-control-label text-white">Confirm Password</label>
                    </div>
                    <div class="form-group float-label position-relative">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="terms" class="custom-control-input" id="customSwitch1" required>
                            <label class="custom-control-label" for="customSwitch1">I agree to <a href="/users/tc">Terms and conditions</a></label>
                        </div>
                    </div>
                    <input type="hidden" name="ref" value="{{ $ref_id ? base64_decode($ref_id) : '' }}">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
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
        <button type="submit" class="btn btn-default rounded btn-block">Register</button>
    </div>
</div>
</div>
</form>
@endsection