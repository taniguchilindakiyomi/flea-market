@extends('layouts.app')

@section('title', 'プロフィール画面')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection



@section('content')
        <section class="profile-section">

                <div class="form-image">
                    <div class="image-preview">
                        <img id="profile_image" src="{{ $user->profile ? asset('storage/' . $user->profile->profile_image) : asset('images/default-avatar.jpg') }}" alt="">
                    </div>
                    <h2 class="user-name">{{ $user->name }}</h2>
                    <div class="profile-edit">
                    <a class="profile-edit-link" href="/mypage/profile">プロフィールを編集する</a>
                    </div>
                </div>

                <div class="history-list">
                        <a href="/mypage?page=sell" class="history-list_sell @if(!request()->has('page') || request()->get('page') === 'sell') active @endif">
                            出品した商品
                        </a>
                    </div>

                    <div class="history-list">
                        <a href="/mypage?page=buy" class="history-list_purchase @if(request()->get('page') === 'buy') active @endif">購入した商品
                        </a>
                    </div>
                    @if(!request()->has('page') || request()->get('page') === 'sell')
    @foreach ($sellItems as $item)
        <div class="item-card">
            <a href="{{ url('/item/' . $item->id) }}">
                <img src="{{ asset('storage/items/' . $item->image) }}" alt="{{ $item->name }}">
            </a>
            <h3>{{ $item->name }}</h3>
            @if ($item->sold)
                <span class="sold-label">Sold</span>
            @endif
        </div>
    @endforeach
    @if ($sellItems->isEmpty())
        <p>出品した商品はありません。</p>
    @endif
@endif

{{-- 購入した商品リスト --}}
@if(request()->get('page') === 'buy')
    @foreach ($purchasedItems as $item)
        <div class="item-card">
            <a href="{{ url('/item/' . $item->id) }}">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
            </a>
            <h3>{{ $item->name }}</h3>
            @if ($item->sold)
                <span class="sold-label">Sold</span>
            @endif
        </div>
    @endforeach
    @if ($purchasedItems->isEmpty())
        <p>購入した商品はありません。</p>
    @endif
@endif
        </section>
@endsection