<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // プロフィール登録画面を表示
    public function create()
    {
        return view('profile.create');
    }

    //　プロフィール情報を保存
    public function store(Request $request)
    {
        // 1. バリデーション
        $request->validate([
            'gender' => 'required|string',
            'birthday' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 最大2MB
        ], [
            'gender.required' => '性別を選択してください',
            'birthday.required' => '誕生日を入力してください',
            'image.image' => '画像ファイルを選択してください',
        ]);

        // 2. 画像のアップロード処理
        $imagePath = null;
        if ($request->hasFile('image')) {
            // storage/app/public/profiles フォルダに保存
            $imagePath = $request->file('image')->store('profiles', 'public');
        }

        // 3. データベースへ保存
        Profile::create([
            'user_id' => Auth::id(), // ログイン中のユーザーID
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'image' => $imagePath,
        ]);

        // 4. 商品一覧画面へリダイレクト
        return redirect()->route('products.index')->with('success', 'プロフィールを登録しました。');
    }
}
