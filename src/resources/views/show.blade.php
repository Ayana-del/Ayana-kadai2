@extends('layouts.common')

@section('title', '商品詳細')

@section('style')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="product-detail-container">
    <nav class="breadcrumb">
        <a href="{{ route('products.index') }}">商品一覧</a> ＞ {{ $product->name }}
    </nav>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="update-form" novalidate>
        @csrf
        @method('PATCH')

        <div class="main-flex-row">
            {{-- 左側：画像セクション --}}
            <div class="left-column">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
                <div class="file-input-group">
                    <input type="file" name="image" id="image">
                    <span class="current-file-name">
                        {{ $product->image }}
                    </span>
                    @error('image') <p class="error-msg">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- 右側：基本情報セクション --}}
            <div class="right-column">
                <div class="form-item">
                    <label>商品名</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="input-text">
                    @error('name') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="form-item">
                    <label>値段</label>
                    <input type="text" name="price" value="{{ old('price', $product->price) }}" class="input-text">
                    @error('price') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="form-item">
                    <label>季節</label>
                    <div class="checkbox-row">
                        @foreach($seasons as $season)
                        <label class="checkbox-label">
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                {{ in_array($season->id, old('seasons', $product->seasons->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span>{{ $season->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('seasons') <p class="error-msg">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- 商品説明（全幅） --}}
        <div class="description-group">
            <label>商品説明</label>
            <textarea name="description" rows="6" class="input-textarea">{{ old('description', $product->description) }}</textarea>
            @error('description') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        {{-- ボタン：中央配置 --}}
        <div class="form-footer">
            <div class="footer-buttons">
                <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
                <button type="submit" class="btn-submit">変更を保存</button>
            </div>
        </div>
    </form>

    {{-- ゴミ箱：右下に配置 --}}
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-fixed-form" novalidate>
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-trash" onclick="return confirm('本当に削除しますか？')">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="#e53935">
                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
            </svg>
        </button>
    </form>
</div>
@endsection