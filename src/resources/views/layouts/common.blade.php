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
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>
</body>
</html>