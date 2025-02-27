<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
            <form class="form" action="{{ route('register') }}" method="post">
                @csrf
                <div class="register-form___content">
                    <div class="register-form__heading">
                        <h2>会員登録</h2>
                    </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <label class="form__label--item" for="name">ユーザー名</label>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="name" id="name" autocomplete="name" value="{{ old('name') }}">
                        </div>
                        <div class="form__error">
                            @error('name')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <label class="form__label--item" for="email">メールアドレス</label>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="email" name="email" id="email" autocomplete="email" value="{{ old('email') }}">
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
                            <input type="password" name="password" id="password" autocomplete="new-password">
                        </div>
                        <div class="form__error">
                            @error('password')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <label class="form__label--item" for="password_confirmation">確認用パスワード</label>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
                        </div>
                        <div class="form__error">
                            @error('password_confirmation')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form__group">
                    <button class="form__submit-button" type="submit">登録する</button>
                </div>

                <div class="form__group">
                        <a class="form__login-link" href="/login">ログインはこちら</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>