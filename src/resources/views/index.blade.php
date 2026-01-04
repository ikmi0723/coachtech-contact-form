<h1>お問い合わせフォーム</h1>

<form action="/confirm" method="post">
  @csrf

  <div>
    <label>姓</label>
    <input type="text" name="last_name" value="{{ old('last_name', request('last_name')) }}">
    @error('last_name')
      <p style="color:red;">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label>名</label>
    <input type="text" name="first_name" value="{{ old('first_name', request('first_name')) }}">
    @error('first_name')
      <p style="color:red;">{{ $message }}</p>
    @enderror
  </div>

  <div>
  <label>性別</label>

  <label>
    <input type="radio" name="gender" value="1" {{ old('gender', request('gender')) == '1' ? 'checked' : '' }}>
    男性
  </label>

  <label>
    <input type="radio" name="gender" value="2" {{ old('gender', request('gender')) == '2' ? 'checked' : '' }}>
    女性
  </label>

  <label>
    <input type="radio" name="gender" value="3" {{ old('gender', request('gender')) == '3' ? 'checked' : '' }}>
    その他
  </label>

  @error('gender')
    <p style="color:red;">{{ $message }}</p>
  @enderror
</div>

<div>
  <label>メールアドレス</label>
  <input type="text" name="email" value="{{ old('email', request('email')) }}">

  @error('email')
    <p style="color:red;">{{ $message }}</p>
  @enderror
</div>

<div>
  <label>電話番号</label>
  <div>
    <input type="text" name="tel1" value="{{ old('tel1', request('tel1')) }}" size="5"> -
    <input type="text" name="tel2" value="{{ old('tel2', request('tel2')) }}" size="5"> -
    <input type="text" name="tel3" value="{{ old('tel3', request('tel3')) }}" size="5">
  </div>

  @error('tel1')
    <p style="color:red;">{{ $message }}</p>
  @enderror
  @error('tel2')
    <p style="color:red;">{{ $message }}</p>
  @enderror
  @error('tel3')
    <p style="color:red;">{{ $message }}</p>
  @enderror
</div>

<div>
  <label>住所</label>
  <input type="text" name="address" value="{{ old('address', request('address')) }}">

  @error('address')
    <p style="color:red;">{{ $message }}</p>
  @enderror
</div>

<div>
  <label>建物名</label>
  <input type="text" name="building" value="{{ old('building', request('building')) }}">

  @error('building')
    <p style="color:red;">{{ $message }}</p>
  @enderror
</div>

<div>
  <label>お問い合わせの種類</label>

  <select name="category_id">
    <option value="">選択してください</option>

    @foreach ($categories as $category)
      <option value="{{ $category->id }}" {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>
        {{ $category->content }}
      </option>
    @endforeach
  </select>

  @error('category_id')
    <p style="color:red;">{{ $message }}</p>
  @enderror
</div>

<div>
  <label>お問い合わせ内容</label>
  <textarea name="detail" rows="5">{{ old('detail', request('detail')) }}</textarea>

  @error('detail')
    <p style="color:red;">{{ $message }}</p>
  @enderror
</div>

  <button type="submit">確認画面</button>
</form>