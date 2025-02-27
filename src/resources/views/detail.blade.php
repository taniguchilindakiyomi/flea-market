@extends('layouts.app')

@section('title', '商品詳細画面')


@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection


@section('content')
            <div class="left-content">
                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}">
            </div>

            <div class="right-content">
                <div class="right-content_top">
                    <div class="product-name">{{ $item->name }}</div>
                    <div class="brand-name">ブランド名</div>
                    <div class="product-price">￥{{ number_format($item->price) }}(税込)</div>


                    <div class="product-action">
                        <form class="favorite-form" action="{{ url('/item/' . $item->id . '/favorite') }}" method="POST" id="favorite-form-{{ $item->id }}" onsubmit="return false;">
                            @csrf
                        <div class="product-action_favorite">
                            <img src="{{ $item->isFavoritedBy(Auth::user()) ? asset('images/1fc8ae66e54e525cb4afafb0a04b1deb.png') : asset('images/favorite_inactive.png') }}" alt="Favorite Icon" id="favorite-icon-{{ $item->id }}" class="favorite-button" data-item-id="{{ $item->id }}" style="cursor: pointer;">
                            <span class="favorite-count" id="favorite-count-{{ $item->id }}">{{ $item->favorites->count() }}</span>
                        </div>
                    </form>
                    </div>
                    <div class="product-action_comment">
                        <img src="{{ asset('images/9403a7440cf0d1765014bcdbe8540f70.png') }}" alt="Comment Icon">
                        <span class="comment-count">{{ $item->comments->count() }}</span>
                    </div>
                </div>
                <div class="purchase-area">
                    <a href="{{ url('/purchase/' . $item->id) }}" class="purchase-area_link">購入手続きへ</a>
                </div>

                <div class="product-description">
                    <h2>商品説明</h2>
                    <p>{{ $item->description }}</p>
                </div>
                <div class="product-info">
                    <h2>商品の情報</h2>
                    <div class="product-info_category">カテゴリー</div>
                    @foreach ($item->categories as $category)
                    <p>{{ $category->name }}</p>
                    @endforeach
                    <div class="product-info_condition">商品の状態</div>
                    <p>{{ $item->condition }}</p>
                </div>

                <div class="product-comment">
                    <div class="comment-number">
                        コメント({{ $item->comments->count() }})
                    </div>

                    <div class="comment-list">
                        @foreach ($comments as $comment)
                        <div class="comments-text">{{ $comment->comment }}</div>
                        @endforeach
                    </div>

                    <div class="comment-input">
                        <form action="{{ url('/item/' . $item->id . '/comment') }}" method="POST">
                            @csrf
                            <h3>商品へのコメント</h3>
                            <textarea class="textarea" name="comment" cols="30" rows="10"></textarea>
                            <div class="error-message">
                                @error('comment')
                                {{ $message }}
                                @enderror
                                </div>
                            <div class="comments-button">
                                <button type="submit" class="comments-button_submit">コメントを送信する</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
@endsection



@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.favorite-button').forEach(button => {
        button.addEventListener('click', function () {
            let itemId = this.dataset.itemId;
            let icon = this;

            fetch(`/item/${itemId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'liked') {
                    icon.classList.add('liked');
                } else {
                    icon.classList.remove('liked');
                }


                document.getElementById(`favorite-count-${itemId}`).textContent = data.favorite_count;
            });
        });
    });
});
    </script>

@endsection