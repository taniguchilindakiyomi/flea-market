@extends('layouts.app')

@section('title', '送付先住所変更画面')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address-change.css') }}">
@endsection



@section('content')

        <h2>住所の変更</h2>

        <form class="form-address" action="{{ url('/purchase/address/'.$item->id) }}" method="POST">
            @csrf
            <div class="form-group">
                    <label for="postal_code">郵便番号</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $profile->postal_code ?? '') }}">
            </div>
            <div class="form-error">
                @error('postal_code')
                {{ $message }}
                @enderror
            </div>

            <div class="form-group">
                    <label for="address">住所</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}">
            </div>
            <div class="form-error">
                @error('address')
                {{ $message }}
                @enderror
            </div>

            <div class="form-group">
                    <label for="building">建物名</label>
                    <input type="text" name="building" id="building" value="{{ old('building') }}">
            </div>
            <div class="form-error">
                @error('building')
                {{ $message }}
                @enderror
            </div>

            <div class="form-group">
                    <button type="submit" class="btn-submit">更新する</button>
            </div>
        </form>
@endsection