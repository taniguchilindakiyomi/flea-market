<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    @yield('css')
</head>

<body>
    <header>
        <div class="header__inner">
            <div class="header-img">
                <img src="{{ asset('images/logo.svg') }}" alt="ロゴ">
            </div>
            <form class="form" action="{{ url()->current() }}" method="get">
                <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="何をお探しですか?">
                <button type="submit">検索</button>
            </form>
            <div class="header-nav">
                @guest
                <a href="/login">ログイン</a>
                @endguest

                @auth
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
                @endauth
                <a href="/mypage" class="nav-link">マイページ</a>
                <a href="/sell" class="nav-sell">出品</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @yield('scripts')

</body>
</html>


