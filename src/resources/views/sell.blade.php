@extends('layouts.app')

@section('title', '商品出品画像')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection



@section('content')
        <h2>商品の出品</h2>
        <form class="form-sell" action="/sell" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="sell-group">
            <div class="image-content">商品画像</div>
            <div class="file-container">
                @if(isset($item) && $item->image)
                <img id="image-preview" src="{{ asset($item->image) }}" alt="">
                @endif
            <label for="image" class="custom-file-label">画像を選択する</label>
            <input type="file" name="image" id="image" class="hidden-input">
        </div>
        </div>
        <div class="form-error">
            @error('image')
            {{ $message}}
            @enderror
        </div>

        <div class="checkbox-group">
            <div class="sell-content">商品の詳細</div>

            <label for="category_id" class="category">カテゴリー</label>
            <label>
                <input type="checkbox" name="category_id[]"  value="1" class="checkbox-label" id="category_id">
                <span>ファッション</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="2" class="checkbox-label">
                <span>家電</span>
            </label>

            <label>
                <input type="checkbox"name="category_id[]" value="3" class="checkbox-label">
                <span>インテリア</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="4" class="checkbox-label">
                <span>レディース</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="5" class="checkbox-label">
                <span>メンズ</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="6" class="checkbox-label">
                <span>コスメ</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="7" class="checkbox-label">
                <span>本</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="8" class="checkbox-label">
                <span>ゲーム</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="9" class="checkbox-label">
                <span>スポーツ</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="10" class="checkbox-label">
                <span>キッチン</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="11" class="checkbox-label">
                <span>ハンドメイド</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="12" class="checkbox-label">
                <span>アクセサリー</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="13" class="checkbox-label">
                <span>おもちゃ</span>
            </label>

            <label>
                <input type="checkbox" name="category_id[]" value="14" class="checkbox-label">
                <span>ベビー・キッズ</span>
            </label>
            <div class="form-error">
                @error('category_id')
                {{ $message }}
                @enderror
            </div>

            <label for="condition" class="condition">商品の状態</label>

            <select name="condition" id="condition" class="condition-select">
                <option value="" disabled selected>選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
            </div>
        </div>
        <div class="form-error">
            @error('condition')
            {{ $message }}
            @enderror
        </div>

        <div class="checkbox-group">
            <div class="sell-content">商品名と説明</div>
            <label for="name" class="product-name">商品名</label>
            <input type="text" name="name" class="product-name_input" id="name">
            <div class="form-error">
                @error('name')
                {{ $message }}
                @enderror
            </div>

            <label for="description" class="product-description">商品の説明</label>
            <input type="text" name="description" class="product-description_input" id="description">
            <div class="form-error">
                @error('description')
                {{ $message }}
                @enderror
            </div>


            <label for="price" class="product-price">販売価格</label>
            <input type="text" name="price" class="product-price_input" placeholder="￥" id="price">
        </div>
        <div class="form-error">
            @error('price')
            {{ $message }}
            @enderror
        </div>

        <div class="sell-button">
            <button type="submit" class="sell-button_submit">出品する</button>
        </div>
        </div>

        </form>
@endsection


@section('scripts')
    <script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const imagePreview = document.getElementById('image-preview');
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection