<h1>確認</h1>

@php
  $genderText = '';
  if (($contact['gender'] ?? '') == '1') $genderText = '男性';
  if (($contact['gender'] ?? '') == '2') $genderText = '女性';
  if (($contact['gender'] ?? '') == '3') $genderText = 'その他';

  $tel = ($contact['tel1'] ?? '') . ($contact['tel2'] ?? '') . ($contact['tel3'] ?? '');
@endphp

<table>
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
    <td>
      @foreach ($categories as $category)
        @if ($category->id == ($contact['category_id'] ?? null))
          {{ $category->content }}
        @endif
      @endforeach
    </td>
  </tr>
  <tr>
    <th>お問い合わせ内容</th>
    <td>{{ $contact['detail'] ?? '' }}</td>
  </tr>
</table>

<form action="/thanks" method="post">
  @csrf

  @foreach ($contact as $key => $value)
    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
  @endforeach

  <button type="submit">送信</button>
</form>

<form action="/" method="get">
  @foreach ($contact as $key => $value)
    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
  @endforeach

  <button type="submit">修正</button>
</form>