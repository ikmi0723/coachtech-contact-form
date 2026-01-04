<h1>Login</h1>

<form method="POST" action="/login">
  @csrf

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

  <button type="submit">ログイン</button>
</form>

<a href="/register">register</a>