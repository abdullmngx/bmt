@extends('users.layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container mt-3 mb-4 text-center">
    <h2 class="text-white">$ {{ number_format(auth()->user()->total_balance, 2) }}</h2>
    <p class="text-white mb-4">Total Earnings</p>
</div>

<div class="main-container">
    <!-- page content start -->

    <div class="container mb-4 text-center">
        <div class="card bg-default-secondary shadow-default">
            <div class="card-body">
                <!-- Swiper -->
                <div class="swiper-container addsendcarousel text-center">
                    <div class="swiper-wrapper mb-4">
                        <a href="/users/deposits" class="swiper-slide text-white">
                            <div class="icon icon-50 rounded-circle mb-2 bg-white-light"><span class="material-icons">smart_toy</span></div>
                            <p><small>My Bots</small></p>
                        </a>
                        <a href="/users/withdraw" class="swiper-slide text-white">
                            <div class="icon icon-50 rounded-circle mb-2 bg-white-light"><span class="material-icons">credit_card</span></div>
                            <p><small>Withdraw</small></p>
                        </a>
                        <a href="/users/invoices" class="swiper-slide text-white">
                            <div class="icon icon-50 rounded-circle mb-2 bg-white-light"><span class="material-icons">class</span></div>
                            <p><small>Transactions</small></p>
                        </a>
                        <a href="/users/earnings" class="swiper-slide text-white">
                            <div class="icon icon-50 rounded-circle mb-2 bg-white-light"><span class="material-icons">account_balance_wallet</span></div>
                            <p><small>Earnings</small></p>
                        </a>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Swiper -->
    <div class="container mb-4">
        <div class="swiper-container swiper-users text-center ">
            <div class="swiper-wrapper">

                @foreach ($data['plans'] as $plan)
                <div class="swiper-slide">
                    <div class="card">
                        <a href="/users/generate-invoice/{{ $plan['id'] }}">
                        <div class="card-body p-2">
                            <div class="avatar avatar-50 border-0 bg-default-light rounded-circle text-default">
                                <i class="material-icons vm text-template">smart_toy</i>
                            </div>
                            <p class="text-secondary"><small>{{ $plan['name'] }}</small> <br> {{ $plan['period'] }} days</p>
                            <p>${{ number_format($plan['amount']) }}</p>
                            <p> <small>Earn ${{ $plan['daily_earning'] }} daily</small></p>
                        </div>
                        </a>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="container mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title">My invitation link</h4>
                <div class="form-group position-relative">
                    <div class="bottom-right mb-1 mr-1">
                        <button class="btn btn-sm btn-success rounded copy">Copy</button>
                    </div>
                    <input type="text" class="form-control" placeholder="wallet address" id="wallet" value="https://{{ request()->getHost() }}/users/register/{{ base64_encode(auth()->id()) }}">
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-4">
        <div class="row">
            <div class="col">
                <h6 class="subtitle mb-3">My Bots </h6>
            </div>
        </div>
        <div class="row">
            @foreach (auth()->user()->deposits as $deposit)                
            <div class="col-12 col-md-6">
                <div class="card border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-50 border-0 bg-default-light rounded-circle text-default">
                                    <i class="material-icons vm text-template">smart_toy</i>
                                </div>
                            </div>
                            <div class="col-4 align-self-center">
                                <h6 class="mb-1">{{ $deposit['plan_name'] }}</h6>
                                <p class="small text-secondary">{{ $deposit['created_at']->format('y-m-d h:ia') }}</p>
                            </div>
                            <div class="col-auto align-self-center border-left">
                                <h6 class="mb-1">$ {{ number_format($deposit['amount'], 2) }}</h6>
                                <p class="small text-secondary">Exp: {{ date_format(date_create($deposit['expiry']), 'y-m-d h:ia') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</main>
@endsection

@section('modal')
<div class="modal fade" id="my-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Referral Incentives</h4>
                <a href="#" class="close" data-dismiss="modal">&times;</a>
            </div>
            <div class="modal-body">
                <p>Refer 5 active members and get 10$ income bot reward Extra. Contact <a href="https://t.me/theVipManager">@TheVipManager</a> for rewards, only qualified users </p>

                <h4>Deposit Update</h4>
                
                <p>Users can now activate their VIP bots using bank transfer method!!</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('#my-modal').modal('show')
</script>
@endsection