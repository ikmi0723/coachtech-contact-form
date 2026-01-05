<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;500&display=swap" rel="stylesheet">

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
          <button type="submit" class="header__link">logout</button>
        </form>
        @else
          @if (request()->is('register'))
            <a class="header__link" href="/login">login</a>
          @elseif (request()->is('login'))
            <a class="header__link" href="/register">register</a>
          @endif
        @endauth
      </div>
    </div>
  </header>

  <main class="main">
    @yield('content')
  </main>
</body>
</html>