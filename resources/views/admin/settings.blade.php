@extends('admin.layouts.app')
@section('title', 'Settings')
@section('content')
    <div class="row clearfix row-deck">
        <div class="col-12">
            <div class="card">
                <div class="body">
                    <h4 class="card-title">@yield('title')</h4>
                    <div class="mb-4 mt-4">
                        <form action="" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_channel">Payment Channel</label>
                                        <select name="payment_channel" id="payment_channel" class="form-control">
                                            <option value="1">Channel 1</option>
                                            <option value="2" {{ $settings['payment_channel']=="2" ? "selected" : '' }}>Channel 2</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="withdrawal">Withdrawal</label>
                                        <select name="withdrawal" id="withdrawal" class="form-control">
                                            <option value="open">Open</option>
                                            <option value="close" {{ $settings['withdrawal']=="close" ? "selected" : '' }}>Close</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="crypto_withdrawal">Crypto Withdrawal</label>
                                        <select name="crypto_withdrawal" id="crypto_withdrawal" class="form-control">
                                            <option value="open">Open</option>
                                            <option value="close" {{ $settings['crypto_withdrawal']=="close" ? "selected" : '' }}>Close</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="dollar_rate">Dollar Rate</label>
                                        <input type="number" name="dollar_rate" id="dollar_rate" class="form-control" value="{{ $settings['dollar_rate'] ?? "" }}">
                                    </div>
                                    <div class="form-group">
                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger">{{ $error}}</div>
                                            @endforeach
                                        @endif
                                        @if (session()->has('message'))
                                            <div class="alert alert-success">{{ session('message') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save Settings</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection