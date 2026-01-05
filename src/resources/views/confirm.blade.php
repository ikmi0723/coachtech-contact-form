@extends('layouts.app')

@section('title', 'Confirm')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
@php
  $genderText = '';
  if (($contact['gender'] ?? '') == '1') $genderText = '男性';
  if (($contact['gender'] ?? '') == '2') $genderText = '女性';
  if (($contact['gender'] ?? '') == '3') $genderText = 'その他';

  $tel = ($contact['tel1'] ?? '') . ($contact['tel2'] ?? '') . ($contact['tel3'] ?? '');

  $categoryText = '';
  foreach ($categories as $category) {
    if ($category->id == ($contact['category_id'] ?? null)) {
      $categoryText = $category->content;
      break;
    }
  }
@endphp

<div class="confirm">
  <div class="confirm__inner">
    <h2 class="confirm__title">Confirm</h2>

    <table class="confirm-table">
      <tr>
        <th>お名前</th>
        <td>{{ ($contact['last_name'] ?? '') . ' ' . ($contact['first_name'] ?? '') }}</td>
      </tr>
      <tr>
        <th>性別</th>
        <td>{{ $genderText }}</td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td>{{ $contact['email'] ?? '' }}</td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td>{{ $tel }}</td>
      </tr>
      <tr>
        <th>住所</th>
        <td>{{ $contact['address'] ?? '' }}</td>
      </tr>
      <tr>
        <th>建物名</th>
        <td>{{ $contact['building'] ?? '' }}</td>
      </tr>
      <tr>
        <th>お問い合わせの種類</th>
        <td>{{ $categoryText }}</td>
      </tr>
      <tr>
        <th>お問い合わせ内容</th>
        <td class="confirm-table__detail">{{ $contact['detail'] ?? '' }}</td>
      </tr>
    </table>

    <div class="confirm__actions">
      <form action="/thanks" method="post">
        @csrf
        @foreach ($contact as $key => $value)
          <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit" class="btn btn--primary">送信</button>
      </form>

      <form action="/" method="get">
        @foreach ($contact as $key => $value)
          <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit" class="confirm__edit">修正</button>
      </form>
    </div>

  </div>
</div>
@endsection