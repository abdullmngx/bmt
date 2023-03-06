@include('admin.partials.datatable')
@extends('admin.layouts.app')
@section('title', 'Withdrawals')
@section('content')
    <div class="row clearfix row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@yield('title')</h4>
                    <div class="mt-4">
                        <div class="mb-4">
                            <h4>Total Requested Amount: {{ number_format($requested) }}</h4>
                            <h4>Total Paid Amount: {{ number_format($paid) }}</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover tb">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $x = 1;
                                    @endphp
                                    @foreach ($withdrawals as $withdrawal)
                                        <tr>
                                            <td>{{ $x++ }}</td>
                                            <td><a href="/admin/users/{{ $withdrawal['user_id'] }}">{{ $withdrawal['user_name'] }}</a></td>
                                            <td>{{ $withdrawal['amount'] }}</td>
                                            <td>{{ $withdrawal['status'] }}</td>
                                            <td><a href="/admin/withdrawals/{{ $withdrawal['id'] }}">View</a></td>
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
        $('.tb').DataTable()
    </script>
@endsection