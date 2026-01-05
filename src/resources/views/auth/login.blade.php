@extends('layouts.app')

@section('title', 'Login')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth">

  <h2 class="auth__title">Login</h2>

  <div class="auth__card">
    <form method="POST" action="/login">
      @csrf

      <div class="auth-form__group">
        <label class="auth-form__label">メールアドレス</label>
        <input
          class="auth-form__input"
          type="email"
          name="email"
          placeholder="例：test@example.com"
          value="{{ old('email') }}"
        >
        @error('email')
          <p class="auth-form__error">{{ $message }}</p>
        @enderror
      </div>

      <div class="auth-form__group">
        <label class="auth-form__label">パスワード</label>
        <input
          class="auth-form__input"
          type="password"
          name="password"
          placeholder="例：coachtech1106"
        >
        @error('password')
          <p class="auth-form__error">{{ $message }}</p>
        @enderror
      </div>

      <div class="auth-form__actions">
        <button class="auth-form__btn" type="submit">ログイン</button>
      </div>
    </form>
  </div>

</div>
@endsection