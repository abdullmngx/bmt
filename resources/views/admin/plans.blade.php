@include('admin.partials.datatable')
@extends('admin.layouts.app')
@section('title', 'Plans')
@section('content')
    <div class="row clearfix row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@yield('title')</h4>
                    <div class="mt-4">
                        <div class="mb-4">
                            <a href="#" class="btn btn-primary" data-target="#add-modal" data-toggle="modal">+Add Plan</a>
                        </div>
                        <div class="mb-4">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{ $error}}</div>
                                @endforeach
                            @endif
                            @if (session()->has('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="tb">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Deposit Amount</th>
                                        <th>Daily Earnings</th>
                                        <th>Period</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $x = 1;
                                    @endphp
                                    @foreach ($plans as $plan)
                                        <tr>
                                            <td>{{ $x++ }}</td>
                                            <td>{{ $plan['name'] }}</td>
                                            <td>{{ $plan['amount'] }}</td>
                                            <td>{{ $plan['daily_earning'] }}</td>
                                            <td>{{ $plan['period'] }}</td>
                                            <td>{{ $plan['status'] }}</td>
                                            <td>
                                                <a href="/admin/plans/delete/{{ $plan['id'] }}" class="btn btn-danger" onclick="return confirm('are you sure you want to delete this plan')"><i class="fa fa-trash"></i> Delete</a>
                                                <a href="/admin/plans/activate/{{ $plan['id'] }}" class="btn btn-success" onclick="return confirm('are you sure you want to activate this plan')">Activate</a>
                                                <a href="/admin/plans/block/{{ $plan['id'] }}" class="btn btn-danger" onclick="return confirm('are you sure you want to block this plan')">Block</a>
                                                <a href="/admin/plans/reserve/{{ $plan['id'] }}" class="btn btn-warning" onclick="return confirm('are you sure you want to reserve this plan')">Reserve</a>
                                            </td>
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

@section('modals')
    <div class="modal fade" id="add-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Plan</h4>
                    <a href="#" data-dismiss="modal" class="close">&times;</a>
                </div>
                <div class="modal-body">
                    <form action="/admin/plans/add" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Plan Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Plan Name">
                        </div>
                        <div class="form-group">
                            <label for="amount">Deposit Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="Deposit Amount">
                        </div>
                        <div class="form-group">
                            <label for="daily_interest">Daily Interest</label>
                            <input type="text" name="daily_earning" id="daily_earning" class="form-control" placeholder="Daily Earnings">
                        </div>
                        <div class="form-group">
                            <label for="period">Period</label>
                            <input type="number" name="period" id="period" class="form-control" placeholder="No. of days">
                        </div>
                        <div class="form-group">
                            <label for="img">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="blocked">Blocked</option>
                                <option value="reserved">Reserved</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <input type="submit" class="btn btn-primary btn-block" name="submit" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $("#tb").DataTable()
</script>
@endsection