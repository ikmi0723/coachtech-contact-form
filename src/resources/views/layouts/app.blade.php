<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
@yield('css')
<title>@yield('title', 'FashionablyLate')</title>
</head>
<body>

<header class="header">
  <div class="header__inner">
    <div class="header__left"></div>

    <div class="header__center">
      <a class="header__logo" href="/">FashionablyLate</a>
    </div>

    <div class="header__right">
      @auth
        <form method="POST" action="/logout">
          @csrf
          <button type="submit" class="btn btn--outline">logout</button>
        </form>
      @endauth
    </div>
  </div>
</header>

<main class="main">
  @yield('content')
</main>

</body>
</html>