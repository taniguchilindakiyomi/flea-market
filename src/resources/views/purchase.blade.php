@extends('layouts.app')

@section('title', '商品購入画像')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection


@section('content')

    <form class="form-purchase" action="{{ url('/purchase/' . $item->id) }}" method="POST">
        @csrf
    <div class="purchase-container">
    <div class="left-container">
        <img class="product-image" src="{{ asset($item->image) }}" alt="{{ $item->name }}">
        <div class="product-info">
        <div class="product-name">{{ $item->name }}</div>
        <div class="product-price"><span class="span">￥</span>{{ number_format($item->price) }}</div>
        </div>
    </div>

    <div class="line"></div>

    <div class="payment-method">
        <label for="payment_method">支払い方法</label>
        <select name="payment_method" id="payment_method"
        class="payment-method_select">
            <option value="" disabled selected>選択してください</option>
            <option value="コンビニ払い">コンビニ払い</option>
            <option value="カード払い">カード払い</option>
        </select>
    </div>
    <div class="form-error">
        @error('payment_method')
        {{ $message }}
        @enderror
    </div>

    <div class="line"></div>

    <div class="shipping-address">
        <input type="hidden" name="shipping_address" value="{{ $profile->postal_code }} {{ $profile->address }} {{ $profile->building }}">
        <label for="shipping_address">配送先</label>
        <p class="postal-code">〒{{ $profile->postal_code }}</p>
        <p class="address">{{ $profile->address }}</p>
        <p class="building">{{ $profile->building }}</p>
    </div>
    <div class="address-edit_link">
        <a href="{{ url('/purchase/address/' . $item->id) }}">変更する</a>
    </div>
    <div class="form-error">
        @error('shipping_address')
        {{ $message }}
        @enderror
    </div>

    <div class="line"></div>
    </div>

    <div class="right-container">
    <div class="confirm-surface">
        <p class="payment-amount">
            <strong class="payment-amount_text">支払い代金:</strong>￥{{ number_format($item->price) }}</p>
        <p class="payment-method"><strong class="payment-method_text">支払い方法:<span class="span-display" id="payment-method-display"></span></strong>
        </p>
    </div>

    <div class="purchase-button">
        <button class="purchase-button_submit" type="submit">購入する</button>
    </div>
    </div>
    </form>

@endsection


@section('scripts')
<script>
    const paymentMethodSelect = document.getElementById('payment_method');
    const paymentMethodDisplay = document.getElementById('payment-method-display');

    paymentMethodSelect.addEventListener('change', function() {
        paymentMethodDisplay.textContent = paymentMethodSelect.value;
    });
</script>
@endsection