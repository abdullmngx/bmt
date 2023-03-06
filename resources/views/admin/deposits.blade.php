@include('admin.partials.datatable')
@extends('admin.layouts.app')
@section('title', 'Deposits')
@section('content')
    <div class="row clearfix row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@yield('title')</h4>
                    <div class="mt-4">
                        <div class="mb-4">
                            <h4>Total Deposited Amount: {{ number_format($total_deposit) }}</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover tb">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Plan</th>
                                        <th>Amount</th>
                                        <th>Expiry</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $x = 1;
                                    @endphp
                                    @foreach ($deposits as $deposit)
                                        <tr>
                                            <td>{{ $x++ }}</td>
                                            <td><a href="/admin/users/{{ $deposit['user_id'] }}">{{ $deposit['user_name'] }}</a></td>
                                            <td>{{ $deposit['plan_name'] }}</td>
                                            <td>{{ $deposit['amount'] }}</td>
                                            <td>{{ $deposit['expiry'] }}</td>
                                            <td>{{ $deposit['status'] }}</td>
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
