@extends('layouts.common')

@section('style')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
{{-- 1. 画面全体を中央寄せにするコンテナ --}}
<div class="auth-container">

    {{-- 2. 横幅を制限するカード部分 --}}
    <div class="auth-card">
        <h2 class="auth-title">新規会員登録</h2>

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">お名前</label>
                <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" required autofocus>
                @error('name')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required>
                @error('email')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" id="password" class="form-input" required>
                @error('password')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">パスワード（確認用）</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="auth-button">
                    登録する
                </button>
            </div>
        </form>

        <div class="auth-footer">
            <a href="{{ route('login') }}" class="auth-link">
                既にアカウントをお持ちの方はこちら
            </a>
        </div>
    </div>
</div>
@endsection