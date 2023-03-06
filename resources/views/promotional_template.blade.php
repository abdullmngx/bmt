@extends('layouts.mail')
@section('title', 'Welcome')
@section('content')
<p class="text-bold">Dear VIP</p>

<div>
    {!! $data['mail'] !!}
</div>
@endsection