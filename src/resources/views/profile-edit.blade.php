@extends('layouts.app')

@section('title', 'プロフィール編集画面')


@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
@endsection



@section('content')
        <h2>プロフィール設定</h2>

        <form class="form-profile" action="/mypage/profile" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-image">
                    <div class="image-preview">
                        <img src="#" id="profile_image_preview" alt="">
                    </div>
                    <label for="profile_image" class="custom-file-label">画像を選択する</label>
                    <input type="file" name="profile_image" id="profile_image" class="custom-file-input">
                </div>
                <div class="form__error">
                    @error('profile_image')
                    {{ $message }}
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">ユーザー名</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
                </div>

                <div class="form-group">
                    <label for="postal_code">郵便番号</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $profile->postal_code ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="address">住所</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $profile->address ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="building">建物名</label>
                    <input type="text" name="building" id="building" value="{{ old('building', $profile->building ?? '') }}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-submit">更新する</button>
                </div>
            </form>
@endsection

@section('scripts')
    <script>
    document.getElementById('profile_image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const img = document.getElementById('profile_image_preview');
            img.style.display = 'block';
            img.src = e.target.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });
    </script>

@endsection