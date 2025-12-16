## 　mogitate(基礎学習ターム確認テスト_もぎたて)  
  
## 環境構築  
このプロジェクトはDocker Compose を利用したコンテナ環境で動作します。  
  
## 前提条件  
*Docker / Docker Compose がインストールされていること。  
*Git がインストールされていること。  
  
## セットアップ手順  
  
リポジトリのクローン  
```bash
git clone git@github.com:Ayana-del/Ayana-kadai2.git
```  
```bash  
cd Ayana-kadai2
```  
コンテナの起動
```bash
docker-compose up -d --build
```  
PHPコンテナのログインと初期設定  
```bash
docker-compose exec php bash
```  
依存パッケージのインストール
```bash
composer install
```  
環境ファイルのコピー  
```bash
cp .env.example .env
```
アプリケーションキーの生成  
```bash
php artisan key:generate
```  
## ER図  
テーブル使用に基づいて作成したER図を以下に示します。  
![ER図](ER図.drawio.png)  
## ルーティング仕様  
| 画面 | HTTPメソッド | URL | 目的 | コントローラーメソッド |  
| ---- | ---- | ---- | ---- | ---- |
| 商品一覧 | GET | /products | 商品一覧を表示 | index |  
| ---- | ---- | ---- | ---- | ---- |  
| 検索 | GET | /products/search | 検索結果を表示 | search |  
| ---- | ---- | ---- | ---- | ---- |  
| 商品登録画面 | GET | /products/register | 登録フォーム | create |  
| ---- | ---- | ---- | ---- | ---- |  
| 商品登録処理 | POST | /products/register | フォームをデータベースに保存 | store |  
| ---- | ---- | ---- | ---- | ---- |
| 商品詳細・変更フォーム | GET | /products/{productId} | 特定の商品を表示・編集フォームを表示 | show |  
| ---- | ---- | ---- | ---- | ---- |  
| 商品更新処理 | PATCH | /products/{productId}/update | 編集データをデータベースに反映 | update |  
| ---- | ---- | ---- | ---- | ---- |  
| 削除処理 | DELETE | /priducts/{productId}/delete | 特定の商品を削除 | destroy |  
| ---- | ---- | ---- | ---- | ----|  
