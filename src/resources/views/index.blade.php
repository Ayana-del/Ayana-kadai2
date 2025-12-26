@extends('layouts.common')

@section('title', '商品一覧')

@section('content')
<div class="product-container">
    <aside class="sidebar">
        <form action="{{ route('products.search')}}" method="GET">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索" class="search-input">
            <button type="submit" class="btn-search">検索</button>

            <div class="sort-section">
                <h3>価格順で表示</h3>
                <select name="sort" class="sort-select" onchange="this.form.submit()">
                    <option value="" disabled {{ !request('sort') ? 'selected' : '' }}>価格で並び替え</option>
                    <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>高い順に表示</option>
                    <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>低い順に表示</option>
                </select>
            </div>
        </form>

        @if(request('sort'))
        <div class="filter-tag">
            {{ request('sort') == 'high' ? '高い順に表示' : '低い順に表示' }}
            <a href="{{ request()->fullUrlWithQuery(['sort' => null]) }}" class="reset-icon">×</a>
        </div>
        @endif
    </aside>

    <main class="product-main">
        <div class="header-actions">
            <h1>{{ request('keyword') ? "“" . request('keyword') . "”の商品一覧" : "商品一覧" }}</h1>
            <a href="{{ route('products.create')}}" class="btn-add-product">+ 商品を追加</a>
        </div>

        <div class=" product-grid">
            @foreach ($products as $product)
            <a href="/products/{{ $product->id }}" class="product-card">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <div class="card-info">
                    <span class="name">{{ $product->name }}</span>
                    <span class="price">¥{{ number_format($product->price) }}</span>
                </div>
            </a>
            @endforeach
        </div>

        <div class="pagination-container">
            {{ $products->links() }}
        </div>
    </main>
</div>
@endsection