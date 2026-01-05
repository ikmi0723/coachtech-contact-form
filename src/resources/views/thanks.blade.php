@extends('layouts.app')

@section('title', 'Thanks')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks">
    <div class="thanks__bg">Thank you</div>

    <div class="thanks__inner">
        <p class="thanks__message">お問い合わせありがとうございました</p>
        <a class="thanks__btn" href="/">HOME</a>
    </div>
</div>
@endsection