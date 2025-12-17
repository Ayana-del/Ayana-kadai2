<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; //Productモデルをインポート
use App\Models\Season;  //Seasonモデルをインポート

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   //紐付け対象の季節を全て取得する
        $seasons = Season::all()->keyBy('name');
        //サンプル商品の作成
        $product1 = Product::create([
            'name' => 'キウイ',
            'price' => 800,
            'image' => 'kiwi.png',
            'description' => '甘味と酸味のバランスが絶妙なキウイです。',
        ]);
        //秋と冬を紐付け
        $product1->seasons()->attach([$seasons['秋']->id, $seasons['冬']->id]);

        $seasons = Season::all()->keyBy('name');
        $product2 = Product::create([
            'name' => 'ストロベリー',
            'price' => 1200,
            'image' => 'strawberry.png',
            'description' => '鮮やかな赤色と豊かな香りが特徴のイチゴです。',
        ]);
        //春と冬を紐付け
        $product2->seasons()->attach([$seasons['春']->id, $seasons['冬']->id]);
    }
}
