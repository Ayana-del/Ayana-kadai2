<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    // 1. 商品一覧 (全件表示)
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(6);
        return view('index', compact('products'));
    }

    // 2. 検索・ソート処理
    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->sort === 'high') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'low') {
            $query->orderBy('price', 'asc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(6)->appends($request->all());
        return view('index', compact('products'));
    }

    // 3. 商品登録画面の表示
    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    // 4. 商品保存処理 (エラーが出ていた箇所)
    public function store(ProductRequest $request)
    {
        // 画像の保存
        $file = $request->file('image');
        $fileName = $file->store('images', 'public');

        // 商品の作成
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $fileName,
            'description' => $request->description,
        ]);

        // 季節の紐付け
        if ($request->has('seasons')) {
            $product->seasons()->attach($request->seasons);
        }

        return redirect()->route('products.index')->with('success', '商品を登録しました。');
    }
    // コメント追加機能
    public function storeComment(Request $request, $productId)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:400',
        ]);

        // ログイン中のユーザーID、商品のID、入力内容を保存
        \App\Models\Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $productId,
            'content' => $request->content,
        ]);

        return back()->with('success', 'コメントを投稿しました。');
    }

    // 5. 商品詳細・変更フォーム
    public function show($productId)
    {
        // コメント、投稿者、投稿者のプロフィールをセットで取得
        $product = Product::with('comments.user.profile')->findOrFail($productId);
        $seasons = Season::all();
        return view('show', compact('product', 'seasons'));
    }

    // 6. 商品更新処理
    public function update(ProductRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $data = $request->only(['name', 'price', 'description']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->storeAs('public/images', $filename);
            $data['image'] = $filename;
        }

        $product->update($data);
        $product->seasons()->sync($request->input('seasons', []));

        return redirect()->route('products.index')->with('success', '商品を更新しました。');
    }

    // 7. 削除処理
    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);
        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}
