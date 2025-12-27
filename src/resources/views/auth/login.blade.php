@extends('layouts.common')

@section('style')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2 class="auth-title">ログイン</h2>

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required autofocus>
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

            <div class="form-actions">
                <button type="submit" class="auth-button">
                    ログイン
                </button>
            </div>
        </form>

        <div class="auth-footer">
            <a href="{{ route('register') }}" class="auth-link">
                新規会員登録はこちら
            </a>
        </div>
    </div>
</div>
@endsection