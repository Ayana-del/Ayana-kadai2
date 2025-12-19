<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) //商品一覧

    {
        $query = Product::query();

        //商品検索機能(部分一致)
        if($request->filled('keyword')){
            $query->where('name','like','%' . $request->keyword . '%');
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
        return view('show', compact('product'));
    }

    public function update(Request $request, $productId) //特定の商品を更新（PATCH/products/{productId}/update)
    {   //バリデーション、画像の更新、productsテーブルとproduct_seasonテーブルの更新処理
        return redirect()->route('products.show', $productId)->with('success', '商品を更新しました。');
    }

    public function destroy($productId) //特定の商品を削除（DELETE/products/{productId}/delete)
    {   //データベースから商品を削除（リレーションテーブルも含む）
        return redirect()->route('procucts.index')->with('successs', '商品を削除しました。');
    }

    public function search(Request $request) //商品を検索
    {   //リクエストから検索条件を取得し、データベースを検索して結果をビューに渡す
        return view('products.index');  //検索結果は一覧画面と同じビューを利用
    }
}
