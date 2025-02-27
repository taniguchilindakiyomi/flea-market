@extends('layouts.app')

@section('title', '商品一覧画面')


@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection



@section('content')

        <div class="top-list">
            <section class="recommended-items">
            <h2 onclick="showItems('recommended')">おすすめ</h2>
            <div class="item-list" id="recommended-items">
                @foreach ($items as $item)
                    <div class="item-card">
                        <a href="{{ url('/item/' . $item->id) }}">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                        </a>
                        @if ($item->sold)
                            <span class="sold-label">Sold</span>
                        @endif
                        <h3>{{ $item->name }}</h3>
                    </div>
                @endforeach
            </div>
            </section>

            <section class="my-list">
            <h2 onclick="showItems('mylist')">マイリスト</h2>
            <div class="favorite-list" id="mylist-items">
                @foreach ($favorites ?? [] as $product)
                    <div class="product-card">
                        <a href="{{ url('/item/' . $product->id) }}">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                        </a>
                        @if ($product->sold)
                            <span class="sold-label">Sold</span>
                        @endif
                        <h3>{{ $product->name }}</h3>
                    </div>
                @endforeach
            </div>
            </section>
        </div>
@endsection


@section('scripts')
    <script>
    function showItems(section) {
        let headings = document.querySelectorAll('h2');
        headings.forEach(function(heading) {
            heading.classList.remove('active');
        });

        let clickedHeading = document.querySelector('h2[onclick="showItems(\'' + section + '\')"]');
        clickedHeading.classList.add('active');

        let recommendedItems = document.getElementById('recommended-items');
        let mylistItems = document.getElementById('mylist-items');

        if (section === 'recommended') {
            recommendedItems.style.display = 'block';
            mylistItems.style.display = 'none';
        } else if (section === 'mylist') {
            mylistItems.style.display = 'block';
            recommendedItems.style.display = 'none';
        }
    }


        document.addEventListener('DOMContentLoaded', function() {
            let urlParams = new URLSearchParams(window.location.search);
            let page = urlParams.get('page') || 'recommended';


        let initialHeading = document.querySelector('h2[onclick="showItems(\'' + page + '\')"]');
        if (initialHeading) {
            initialHeading.classList.add('active');
        }

        showItems(page);

    });
</script>

@endsection


