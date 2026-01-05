@extends('layouts.app')

@section('title', 'Contact')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact">
  <div class="contact__inner">
    <h2 class="contact__title">Contact</h2>

    <form class="contact-form" action="/confirm" method="post">
      @csrf

      <div class="form__row">
        <p class="form__label">お名前<span class="form__required">※</span></p>
        <div class="form__field form__field--name">
          <div>
            <input class="input" type="text" name="last_name"
              placeholder="例：山田"
              value="{{ old('last_name', request('last_name')) }}">
            @error('last_name')
              <p class="form__error">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <input class="input" type="text" name="first_name"
              placeholder="例：太郎"
              value="{{ old('first_name', request('first_name')) }}">
            @error('first_name')
              <p class="form__error">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      <div class="form__row">
        <p class="form__label">性別<span class="form__required">※</span></p>
        <div class="form__field">
          <div class="radio">
            <label class="radio__item">
              <input type="radio" name="gender" value="1"
                {{ old('gender', request('gender')) == '1' ? 'checked' : '' }}> 男性
            </label>
            <label class="radio__item">
              <input type="radio" name="gender" value="2"
                {{ old('gender', request('gender')) == '2' ? 'checked' : '' }}> 女性
            </label>
            <label class="radio__item">
              <input type="radio" name="gender" value="3"
                {{ old('gender', request('gender')) == '3' ? 'checked' : '' }}> その他
            </label>
          </div>
          @error('gender')
            <p class="form__error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="form__row">
        <p class="form__label">メールアドレス<span class="form__required">※</span></p>
        <div class="form__field">
          <input class="input" type="text" name="email"
            placeholder="例：test@example.com"
            value="{{ old('email', request('email')) }}">
          @error('email')
            <p class="form__error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="form__row">
        <p class="form__label">電話番号<span class="form__required">※</span></p>
        <div class="form__field form__field--tel">
          <input class="input" type="text" name="tel1" value="{{ old('tel1', request('tel1')) }}">
          <span class="hyphen">-</span>
          <input class="input" type="text" name="tel2" value="{{ old('tel2', request('tel2')) }}">
          <span class="hyphen">-</span>
          <input class="input" type="text" name="tel3" value="{{ old('tel3', request('tel3')) }}">

          <div style="width:100%;">
            @error('tel1') <p class="form__error">{{ $message }}</p> @enderror
            @error('tel2') <p class="form__error">{{ $message }}</p> @enderror
            @error('tel3') <p class="form__error">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      <div class="form__row">
        <p class="form__label">住所<span class="form__required">※</span></p>
        <div class="form__field">
          <input class="input" type="text" name="address"
            placeholder="例：東京都渋谷区千駄ヶ谷1-2-3"
            value="{{ old('address', request('address')) }}">
          @error('address')
            <p class="form__error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="form__row">
        <p class="form__label">建物名</p>
        <div class="form__field">
          <input class="input" type="text" name="building"
            placeholder="例：千駄ヶ谷マンション101"
            value="{{ old('building', request('building')) }}">
          @error('building')
            <p class="form__error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="form__row">
        <p class="form__label">お問い合わせの種類<span class="form__required">※</span></p>
        <div class="form__field">
          <select class="select" name="category_id">
            <option value="">選択してください</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}"
                {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>
                {{ $category->content }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <p class="form__error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="form__row">
        <p class="form__label">お問い合わせ内容<span class="form__required">※</span></p>
        <div class="form__field">
          <textarea class="textarea" name="detail"
            placeholder="お問い合わせ内容をご記載ください">{{ old('detail', request('detail')) }}</textarea>
          @error('detail')
            <p class="form__error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="form__actions">
        <button class="btn btn--primary" type="submit">確認画面</button>
      </div>

    </form>
  </div>
</div>
@endsection