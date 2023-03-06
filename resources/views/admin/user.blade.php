@include('admin.partials.datatable')
@extends('admin.layouts.app')
@section('title', 'User Details')
@section('content')
    <div class="row clear-fix">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        User Profile
                    </h4>
                    <div class="mb-4">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ $user['name'] }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ $user['email'] }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ref">Referer</label>
                            <input type="text" name="ref" id="ref" value="{{ $user['ref_name'] }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="bal">Account Balance</label>
                            <input type="text" name="bal" id="bal" value="{{ number_format($user['total_balance'], 2) }}" class="form-control">
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4>Activate Plan for User</h4>
                        <form action="/admin/plans/activate" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="amount">Plan</label>
                                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                                <select name="plan_id" class="form-control" id="amount">
                                    <option value="">Select Plan</option>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                    @endforeach
                                </select>
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
                                <button type="submit" class="btn btn-primary">
                                    Activate Plan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Deposits
                    </h4>
                    <div class="mb-4">
                        <h2>Total Downlines: {{ $user['ref_count'] }}</h2>
                        <h2>Active Downlines: {{ $user['count_active_ref'] }}</h2>
                        <div class="table-responsive">
                            <table class="tb table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Plan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $x=1;
                                    @endphp
                                    @foreach ($user['deposits'] as $deposit)
                                        <tr>
                                            <td>{{ $x++ }}</td>
                                            <td>{{ $deposit['amount'] }}</td>
                                            <td>{{ $deposit['plan_name'] }}</td>
                                            <td>{{ $deposit['status'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="mb-4">
                            <h4 class="card-title">Withdrawals</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="tb table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $x=1;
                                    @endphp
                                    @foreach ($user['withdrawals'] as $withdrawal)
                                        <tr>
                                            <td>{{ $x++ }}</td>
                                            <td>{{ $withdrawal['amount'] }}</td>
                                            <td>{{ $withdrawal['status'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(".tb").DataTable()
    </script>
@endsection