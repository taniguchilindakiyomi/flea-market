<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>
<body>
    <header>
        <div class="header__inner">
            <div class="header-img">
                <img src="{{ asset('images/logo.svg') }}" alt="ロゴ">
            </div>
        </div>
    </header>

    <main class="main">
            <form class="form" action="{{ route('login') }}" method="post">
                @csrf
                <div class="login-form__content">
                    <div class="login-form__heading">
                        <h2>ログイン</h2>
                    </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <label class="form__label--item" for="email">ユーザー名/メールアドレス</label>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="email" id="email">
                        </div>
                        <div class="form__error">
                            @error('email')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <label class="form__label--item" for="password">パスワード</label>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="password" name="password" id="password">
                        </div>
                        <div class="form__error">
                            @error('password')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form__group">
                    <button class="form__submit-button" type="submit">ログインする</button>
                </div>

                <div class="form__group">
                        <a class="form__register-link" href="/register">会員登録はこちら</a>
                </div>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
