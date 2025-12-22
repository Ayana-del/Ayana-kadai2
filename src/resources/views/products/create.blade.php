@extends('layouts.common')

@section('content')
{{-- CSSの読み込み確認 --}}
<link rel="stylesheet" href="{{ asset('css/register.css') }}">

<div class="register-container">
    <h2 class="page-title">商品登録</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="register-form" novalidate>
        @csrf

        {{-- 商品名 --}}
        <div class="form-group">
            <label class="label-flex">商品名 <span class="tag-required">必須</span></label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
            @error('name') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        {{-- 値段 --}}
        <div class="form-group">
            <label class="label-flex">値段 <span class="tag-required">必須</span></label>
            <input type="number" name="price" value="{{ old('price') }}" placeholder="値段を入力">
            @error('price') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        {{-- 商品画像 --}}
        <div class="form-group">
            <label class="label-flex">商品画像 <span class="tag-required">必須</span></label>

            {{-- プレビュー表示エリア --}}
            <div id="image-preview-container" class="image-preview-container" style="display: none;">
                <img id="image-preview" src="" alt="プレビュー">
            </div>
            {{-- id="image-input" を追加 --}}
            <input type="file" name="image" id="image-input" accept="image/png, image/jpeg">

            @error('image') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        {{-- JavaScriptの追加 --}}
        <script>
            document.getElementById('image-input').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewContainer = document.getElementById('image-preview-container');
                const previewImage = document.getElementById('image-preview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block'; // 画像があれば表示
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.style.display = 'none'; // キャンセルされたら隠す
                }
            });
        </script>
        {{-- 季節 --}}
        <div class="form-group">
            <label class="label-flex">季節 <span class="tag-required">必須</span> <span class="tag-info">複数選択可</span></label>
            <div class="checkbox-group">
                @foreach($seasons as $season)
                <label class="checkbox-label">
                    <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                        {{ (is_array(old('seasons')) && in_array($season->id, old('seasons'))) ? 'checked' : '' }}>
                    <span class="checkbox-text">{{ $season->name }}</span>
                </label>
                @endforeach
            </div>
            @error('seasons')
            <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        {{-- 商品説明 --}}
        <div class="form-group">
            <label class="label-flex">商品説明 <span class="tag-required">必須</span></label>
            <textarea name="description" rows="5" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        {{-- ボタン --}}
        <div class="form-actions">
            <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
            <button type="submit" class="btn-submit">登録</button>
        </div>
    </form>
</div>
@endsection