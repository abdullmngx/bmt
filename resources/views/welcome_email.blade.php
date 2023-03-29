@extends('layouts.mail')
@section('title', 'Welcome')
@section('content')
<p class="text-bold">Dear {{ $data['name'] }}</p>

<h5>Welcome to BitmaTraders</h5>

<p>Activate any of our trading bots and earn from the fastest and most secure forex, stocks and crypto trading platform in the industry. Make your first deposit now:</p>

<h5>DEPOSIT NOW</h5>
<p>Get access to exclusive events, rewards, and VIP treatment when you activate a trading bot on the BitmaTraders platform . Take advantage of these great offers.</p> 

<h5>THE VIP Programme</h5>
<p>Activate a trading bot from VIP 1 -10, each bot can generate specific income from our profits reserve. </p>

<h5>Start Earning Today</h5>
<p>If you have any questions, please reach out to us on Telegram <a href="https://t.me/Theviplounge2">@TheVIPLOUNGE</a>. We’re here to help.</p>

<p>Best regards,<br>
The BitmaTraders Team</p>

<div class="row mb-4">
    <div class="col-12">
        <div class="text-center">
            <a href="https://{{ request()->getHost() }}/users/register" class="btn btn-primary rounded rounded-pill w-100">Get Started</a>
        </div>
    </div>
</div>
@endsection