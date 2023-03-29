@extends('auth.layouts.auth')
@section('title', 'Forgot')
@section('content')
<form action="/users/forgot" method="POST">
    @csrf
<div class="container h-100 text-white">
    <div class="row h-100">
        <div class="col-12 align-self-center mb-4">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                    <h2 class="font-weight-normal mb-5">{{ env('APP_NAME') }}</h2>
                    <h5 class="font-weight-normal mb-3">Forgot<br>your password?</h5>
                    <p class="mb-5">Provide your registered email address to change password.</p>
                    <div class="form-group float-label">
                        <input type="email" class="form-control text-white" name="email" >
                        <label class="form-control-label text-white">Email Address</label>
                    </div>

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