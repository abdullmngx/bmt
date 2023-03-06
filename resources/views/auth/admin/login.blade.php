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
                    <h2 class="font-weight-normal mb-5">VIP Lounge</h2>
                    <p>Login to your account</p>
                    <div class="form-group float-label">
                        <input type="text" name="email" class="form-control text-white">
                        <label class="form-control-label text-white">Email</label>
                    </div>
                    <div class="form-group float-label position-relative">
                        <input type="password" name="password" class="form-control text-white ">
                        <label class="form-control-label text-white">Password</label>
                    </div>
                    <div class="form-group float-label position-relative">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="remember" class="custom-control-input" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1">Keep me logged in</label>
                        </div>
                    </div>

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
        <button type="submit" class="btn btn-default rounded btn-block">Login</a>
    </div>
</div>
</div>
</form>
@endsection