@include('admin.partials.chartjs')
@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="row clearfix row-deck">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card top_widget">
            <div class="body">
                <div class="icon"><i class="fa fa-users"></i> </div>
                <div class="content">
                    <div class="text mb-2 text-uppercase">Users</div>
                    <h4 class="number mb-0">{{ $data['counts']['users'] }} </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card top_widget">
            <div class="body">
                <div class="icon"><i class="fa fa-users"></i> </div>
                <div class="content">
                    <div class="text mb-2 text-uppercase">Team</div>
                    <h4 class="number mb-0">{{ $data['counts']['team'] }} </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card top_widget">
            <div class="body">
                <div class="icon"><i class="fa fa-diamond"></i> </div>
                <div class="content">
                    <div class="text mb-2 text-uppercase">Plans</div>
                    <h4 class="number mb-0">{{ $data['counts']['plans'] }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card top_widget">
            <div class="body">
                <div class="icon"><i class="fa fa-money"></i> </div>
                <div class="content">
                    <div class="text mb-2 text-uppercase">Active Deposits</div>
                    <h4 class="number mb-0">{{ $data['counts']['activeDeposits'] }}</h4>
                </div>
            </div>
        </div>
    </div>
    @foreach ($data['plans'] as $plan)
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card top_widget">
            <div class="body">
                <div class="content">
                    <div class="text mb-2 text-uppercase">{{ $plan['name'] }}</div>
                    <h4 class="number mb-0">{{ $plan['deposit_count'] }}</h4>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@section('scripts')
    <script>

    </script>
@endsection