<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Season;

class ProductController extends Controller
{
    public function index(Request $request) //商品一覧

    {
        $query = Product::query();

        //商品検索機能(部分一致)
        if($request->filled('keyword')){
            $query->where('name','like','%' . $request->keyword . '%');
        }
        //季節の絞り込み機能
        if ($request->filled('season')) {
            $query->whereHas('seasons', function ($q) use ($request) {
                $q->where('seasons.id', $request->season);
            });
        }
        //商品並べ替え機能
        if ($request->sort === 'high'){
            $query->orderBy('price','desc');
        }
        elseif($request->sort === 'low'){
            $query->orderBy('price','asc');
        }
        //画面表示(６件ごとに表示)
        $products = $query->paginate(6)->appends($request->all());
        return view('index', compact('products'));
    }

    public function create() //登録フォームと季節の選択肢をビューに渡す(GET/products/register)
    {   //登録フォームと季節の選択肢（seasonテーブルから取得）をビューに渡す。
        return view('products.create');
    }

    public function store(Request $request) //商品をデータベースに保存(POST/products/register)
    {   //バリデーション、画像のアップロード、productsテーブルとproduct_seasonテーブルへの保存完了
        return redirect()->route('products.index')->with('success', '商品を登録しました。');
    }

    public function show($productId) //特定の商品詳細（と変更フォーム）を表示￥(GET/products/{productId})
    {
        $product = Product::with('seasons')->findOrFail($productId);
        //すべての季節を取得(チェックボックス表示用)
        $seasons = Season::all();
        return view('show', compact('product','seasons'));
    }

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

    public function destroy($productId) //特定の商品を削除（DELETE/products/{productId}/delete)
    {
        $product = Product::findOrFail($productId);
        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index')->with('success','商品を削除しました。');
    }

    public function search(Request $request) //商品を検索
    {   //リクエストから検索条件を取得し、データベースを検索して結果をビューに渡す
        return view('products.index');  //検索結果は一覧画面と同じビューを利用
    }
}
