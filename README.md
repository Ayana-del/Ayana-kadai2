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