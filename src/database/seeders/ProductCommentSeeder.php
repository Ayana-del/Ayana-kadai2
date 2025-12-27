<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;

class ProductCommentSeeder extends Seeder
{
    public function run()
    {
        // 重複エラー防止：既存のテストユーザーを削除
        User::whereIn('email', ['tony@example.com', 'sara@example.com'])->delete();

        // 1. tonyの作成
        $tony = User::create([
            'name' => 'tony',
            'email' => 'tony@example.com',
            'password' => bcrypt('password'),
        ]);
        // profileテーブルに必要な情報を入れる
        $tony->profile()->create([
            'name' => 'tony',
            'gender' => 'male',
            'birthday' => '1990-01-01',
        ]);

        // 2. saraの作成
        $sara = User::create([
            'name' => 'sara',
            'email' => 'sara@example.com',
            'password' => bcrypt('password'),
        ]);
        // profileテーブルに必要な情報を入れる
        $sara->profile()->create([
            'name' => 'sara',
            'gender' => 'female',
            'birthday' => '1995-12-31',
        ]);

        // 3. 商品の作成（既存データと被らないように name でチェックして作成）
        $kiwi = Product::firstOrCreate(
            ['name' => 'キウイ'],
            ['price' => 800, 'image' => 'images/kiwi.png', 'description' => 'ビタミンたっぷり']
        );

        $apple = Product::firstOrCreate(
            ['name' => 'アップル'],
            ['price' => 500, 'image' => 'images/apple.png', 'description' => '甘いリンゴ']
        );

        $banana = Product::firstOrCreate(
            ['name' => 'バナナ'],
            ['price' => 300, 'image' => 'images/banana.png', 'description' => '朝食に最適']
        );

        // 4. コメントの作成
        Comment::create([
            'user_id' => $tony->id,
            'product_id' => $kiwi->id,
            'content' => 'がんばれ',
        ]);

        Comment::create([
            'user_id' => $tony->id,
            'product_id' => $kiwi->id,
            'content' => 'いいね',
        ]);

        Comment::create([
            'user_id' => $sara->id,
            'product_id' => $apple->id,
            'content' => 'うーん',
        ]);
    }
}
