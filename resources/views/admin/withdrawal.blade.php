@extends('admin.layouts.app')
@section('title', 'Withdrawal Request')
@section('content')
    <div class="row clearfix row-deck">
        <div class="col-12">
            <div class="card">
                <div class="body">
                    <h4 class="card-title">@yield('title')</h4>
                    <div class="mt-4 mb-4">
                        <a href="/admin/withdrawals" class="btn btn-primary">Back</a>
                        <h1>Withdrawal Type: {{ $withdrawal['type'] }}</h1>
                        <h5>Request from: {{ $withdrawal['user']['name'] }}</h5>
                        <p>Amount Requested: {{ $withdrawal['amount'] }}</p>
                        <p>Amount Payable: {{ ($withdrawal['amount'] - (10/100 * $withdrawal['amount'])) }}</p>
                        <p>User Balance: {{ $balance }}</p>
                        <p>Status of this withdrawal: <span class="text-{{ $withdrawal['status']=="pending" ? 'warning' : '' }}{{ $withdrawal['status'] == "approved" ? 'success': '' }}{{ $withdrawal['status'] == "declined" ? 'danger': '' }}">{{ $withdrawal['status'] }}</span></p>
                    </div>
                    <div class="mb-4">
                        <h4>Account Details</h4>
                        <p>Account Name: {{ $withdrawal['user']['account_name'] ?? "" }}</p>
                        <p>Account Number: <input type="text" class="text-primary copy" id="copy" style="cursor: pointer; content:editable" value="{{ $withdrawal['user']['account_number'] ?? ""}}"></p>
                        <p>Bank: {{ $withdrawal['user']['bank_name'] ?? "" }}</p>
                    </div>
                    <div class="mb-4">
                        <h4>Wallet Address</h4>
                        <p>Wallet Address: <input type="text" class="text-primary copy" id="copy1" style="cursor: pointer; content:editable" value="{{ $withdrawal['user']['wallet_address'] ?? ""}}"></p>
                    </div>
                    <div class="mb-4">
                        <form action="/admin/approve/{{ $withdrawal['id'] }}" class="inline" method="post">
                            @csrf
                            <input type="hidden" name="account_name" value="{{ $withdrawal['user']['account_name'] ?? "" }}">
                            <input type="hidden" name="account_number" value="{{ $withdrawal['user']['account_number'] ?? "" }}">
                            <input type="hidden" name="bank_code" value="{{ $withdrawal['user']['bank_code'] ?? "" }}">
                            <input type="hidden" name="amount" value="{{ $withdrawal['amount'] - 100 }}">
                            <div class="form-group">
                                <label for="pay"><input type="checkbox" name="pay" id="pay" checked> Pay on approval</label>
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
                                <button type="submit" class="btn btn-success">Approve</button>
                            </div>
                        </form>
                        <form action="/admin/decline/{{ $withdrawal['id'] }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $withdrawal['user']['id'] }}">
                            <button type="submit" class="btn btn-danger">Decline</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelector("#copy").onclick = function () {
            document.querySelector("#copy").select();
            if (document.execCommand("copy"))
            {
                toastr.options.closeButton = true;
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.showDuration = 1000;
                toastr['success']('copied');
            }
        };

        document.querySelector("#copy1").onclick = function () {
            document.querySelector("#copy1").select();
            if (document.execCommand("copy"))
            {
                toastr.options.closeButton = true;
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.showDuration = 1000;
                toastr['success']('copied');
            }
        };
    </script>
@endsection