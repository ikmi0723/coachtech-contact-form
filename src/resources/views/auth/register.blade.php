<h1>Register</h1>

<form method="POST" action="/register">
  @csrf

  <div>
    <label>お名前</label>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name') <p style="color:red;">{{ $message }}</p> @enderror
  </div>

  <div>
    <label>メールアドレス</label>
    <input type="text" name="email" value="{{ old('email') }}">
    @error('email') <p style="color:red;">{{ $message }}</p> @enderror
  </div>

  <div>
    <label>パスワード</label>
    <input type="password" name="password">
    @error('password') <p style="color:red;">{{ $message }}</p> @enderror
  </div>

  <div>
    <label>パスワード確認</label>
    <input type="password" name="password_confirmation">
  </div>

  <button type="submit">登録</button>
</form>

<a href="/login">login</a>