<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | mogitate</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('style')
</head>

<body>
    <header class="header">
        <div class="header-inner">
            <a href="/products" class="logo">mogitate</a>

            {{-- ログイン中のみ表示されるプロフィールエリア --}}
            @auth
            <div class="header-profile">
                {{-- 1. 左側：アイコン --}}
                <div class="user-icon">
                    @if(Auth::user()->profile && Auth::user()->profile->image)
                    <img src="{{ asset('storage/' . Auth::user()->profile->image) }}" alt="プロフィール">
                    @else
                    <div class="default-icon">👤</div>
                    @endif
                </div>

                {{-- 2. 右側：名前と誕生日の2行テキスト --}}
                <div class="user-text-info">
                    <span class="user-name">{{ Auth::user()->name }} さん</span>
                    @if(Auth::user()->profile)
                    <span class="user-birthday">
                        🎂 {{ \Carbon\Carbon::parse(Auth::user()->profile->birthday)->format('Y年m月d日') }}
                    </span>
                    @endif
                </div>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn-logout">ログアウト</button>
                </form>
            </div>
            @endauth
            {{-- ここまで追加 --}}

        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>
</body>

</html>