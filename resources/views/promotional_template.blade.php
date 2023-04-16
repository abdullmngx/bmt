@extends('layouts.mail')
@section('title', 'Welcome')
@section('content')
<p class="text-bold">Dear Trader</p>

<div>
    {!! $data['mail'] !!}
</div>
@endsection