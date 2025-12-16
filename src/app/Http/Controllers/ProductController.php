<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() //商品一覧を表示 (GET/products)
    {   //データベースから商品一覧を取得し、ビューに渡す
        return view('products.index');
    }

    public function create() //登録フォームと季節の選択肢をビューに渡す(GET/products/register)
    {   //登録フォームと季節の選択肢（seasonテーブルから取得）をビューに渡す。
        return view('products.create');
    }

    public function store(Request $request) //商品をデータベースに保存(POST/products/register)
    {   //バリデーション、画像のアップロード、productsテーブルとproduct_seasonテーブルへの保存完了
        return redirect()->route('products.index')->with('success','商品を登録しました。');
    }

    public function show($productId) //特定の商品詳細（と変更フォーム）を表示￥(GET/products/{productId})
    {   //データベースから特定の商品情報を取得し、ビューに渡す
        return view('products.show',compact('productId'));
    }

    public function update(Request $request, $productId) //特定の商品を更新（PATCH/products/{productId}/update)
    {   //バリデーション、画像の更新、productsテーブルとproduct_seasonテーブルの更新処理
        return redirect()->route('products.show', $productId)->with('success', '商品を更新しました。');
    }

    public function destroy($productId) //特定の商品を削除（DELETE/products/{productId}/delete)
    {   //データベースから商品を削除（リレーションテーブルも含む）
        return redirect()->route('procucts.index')->with('successs','商品を削除しました。');
    }

    public function search(Request $request) //商品を検索
    {   //リクエストから検索条件を取得し、データベースを検索して結果をビューに渡す
        return view('products.index');  //検索結果は一覧画面と同じビューを利用
    }
}
