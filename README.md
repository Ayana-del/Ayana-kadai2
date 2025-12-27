## 　 mogitate(基礎学習ターム確認テスト\_もぎたて)

## 環境構築

このプロジェクトは Docker Compose を利用したコンテナ環境で動作します。

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

PHP コンテナのログインと初期設定

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

## 使用技術  
・Language: PHP 7.4 / 8.x  
・Framework: Laravel 8.x  
・Database: MySQL  
・Environment: Docker / docker-compose  
  
## ER 図  

テーブル使用に基づいて作成した ER 図を以下に示します。  
![ER図](ER図.drawio.png)

## ルーティング仕様  
商品管理（Products）
| 画面                   | HTTP メソッド | URL                          | 目的                                 | コントローラーメソッド |
| :--------------------- | :------------ | :--------------------------- | :----------------------------------- | :--------------------- |
| 商品一覧               | GET           | /products                    | 商品一覧を表示                       | index                  |
| 検索                   | GET           | /products/search             | 検索結果を表示                       | search                 |
| 商品登録画面           | GET           | /products/register           | 登録フォーム                         | create                 |
| 商品登録処理           | POST          | /products/register           | フォームをデータベースに保存         | store                  |
| 商品詳細・変更フォーム | GET           | /products/{productId}        | 特定の商品を表示・編集フォームを表示 | show                   |
| 商品更新処理           | PATCH         | /products/{productId}/update | 編集データをデータベースに反映       | update                 |
| 削除処理               | DELETE        | /products/{productId}/delete | 特定の商品を削除                     | destroy                |
  
プロフィール管理  
| 画面 | HTTPメソッド | URL | 目的 |  
| :---- | :---- | :---- | :---- |
| プロフィール登録画面 | GET | /profile/create | 名前・誕生日・画像の登録フォーム |  
| プロフィール保存処理 | POST | /profile/store | ユーザー情報をDBに保存 |  
  
認証関連（Fortify）  
FortifyServiceProvider にて挙動をカスタマイズ  
・新規会員登録：GET /register / POST /register  
・ログイン：GET ・login /POST /login  
・ログアウト：POST /logout (処理後はログイン画面へリダイレクト)  
  
## 認証とプロフィールの連動仕様  
| 機能 | 内容 |  
| :---- | :---- |  
| ミドルウェア制限 | プロフィール（名前・誕生日・画像）が未登録のユーザーが/productsにアクセスした場合、自動的に/profile/createへリダイレクトします。  
| 動的表示 | 商品一覧や詳細画面において、ログイン中であれば常に「自分の名前」と「設定した画像」をビュー側に共有して表示します。  


## コントローラー仕様  

商品管理機能の中核を担う ProductController に実装したメソッドと、その役割は以下の通りです。  
| メソッド名 | HTTPメソッド | URL | 役割 |  
| :---- | :---- | :---- | :---- |  
| index() | GET | /products |商品一覧表示。データベースから商品を取得し、ビューに渡す。 |  
| search(Request $request) | GET | /products/search | 商品検索処理。リクエストの検索条件に基づき、商品を絞り込んでindexビューへ渡す。 |  
| create() | GET | /products/register | 商品登録フォーム表示。フォームと共に、seasonsテーブルから季節の選択肢を取得しビューへ渡す。 |  
| store(Request $request) | POST | /products/register | 商品登録処理。バリデーション、画像バリデーション、画像アップロード、productsおよび、product_seasonテーブルへのデータ保存を行う。 |  
| show($productId) | GET | /products/{productId} | 商品詳細・変更フォーム表示。特定の商品詳細を取得。ID が存在しない場合は 404 エラーを表示。|  
| update(Request $request,$productId) | PATCH | /products/{productId}/update | 商品更新処理。更新データのバリデーション、画像更新、データベースの更新を行う。 |  
| destroy($productId) | DELETE | /products/{productId}/delete | 商品削除処理。指定された ID と、関連する中間テーブルのレコードを削除する。 |  
  

ユーザーのアイデンティティ管理と、認証後の初期設定を担うProfileControllerに実装したメソッドと、その役割は以下の通りです。  
| メソッド名 | HTTPメソッド | URL | 役割 |  
| :---- | :---- | :---- | :---- |  
| create() | GET | /profile/create | プロフィール登録フォームを表示。新規登録ユーザーに、名前・誕生日・ユーザー画像の入力を促す。  
| store(Request $request) | POST | /profile/store | プロフィール登録処理。入力データのバリデーション、画像アップロード、profilesテーブルへのデータ保存を行う。 |
  
## データベース仕様  

商品管理機能のために定義し、マイグレーションを実行したテーブル構造は以下の通りです。  
  
1.userテーブル  
| カラム名 | 型 | PRIMARY KEY | NOT NULL | 補足 |  
| :---- | :---- | :---- | :---- | :---- |  
| id | bigint unsigned | ◯ | ◯ | 主キー |  
| email | varchar(255) | | ◯ | ログイン用メールアドレス（ユニーク制約） |  
| password | varchar(255) | | ◯ | パスワード（ハッシュ化） |  
created_at | timestamp | | | | |  
| updated_at | timestamp | | | | |
  
2.profileテーブル
ユーザーごとの詳細情報を管理します。  
| カラム名 | 型 | PRIMARY KEY | NOT NULL | FOREIGN KEY | 補足 |  
| :--- | :--- | :--- | :--- | :--- | :--- |  
| id | bigint unsigned | ◯ | ◯ | | 主キー |  
| user_id | bigint unsigned | | ◯ | users(id) | ユーザーID |  
| name | varchar(255) | | ◯ | | プロフィール名 |  
| birthday | date | | ◯ | | 誕生日 |  
| image | varchar(255) | | | | ユーザーアイコンパス |
| created_at | timestamp | | | | |  
| updated_at | timestamp | | | | |
  
3.products テーブル（商品情報）  
| カラム名 | 型 | PRIMARY KEY | NOT NULL | 補足 |  
| :---- | :---- | :---- | :---- | :---- |  
| id | bigint unsigned | ◯ | ◯ | 主キー |  
| name | varchar(255) | | ◯ | 商品名 |  
| price | int | | ◯ | 商品料金 |  
| image | varchar(255) | | ◯ | 商品画像パス |  
| description | text | | ◯ | 商品説明 |  
| created_at | timestamp | | | |  
| updated_at | timestamp | | | |
  
4.seasons テーブル（季節情報）  
| カラム名 | 型 | PRIMARY KEY | NOT NULL | 補足 |  
| :---- | :---- | :---- | :---- | :---- |  
| id | bigint unsigned | ◯ | ◯ | 主キー |  
| name | varchar(255) | | ◯ | 季節名 |  
| created_at | timestamp | | | |  
| updated_at | timestamp | | | |
  
5.product_season テーブル（中間テーブル）  
| カラム名 | 型 | PRIMARY KEY | NOT NULL | FOREIGN KEY |  
| :---- | :---- | :---- | :---- | :---- |  
| id | bigint unsigned | ◯ | ◯ | |  
| product_id | bigint unsigned | | ◯ | products(id) |  
| season_id | bigint unsigned | | ◯ | seasons(id) |  
| create_at | timestamp | | | |  
| updated_at | timestamp | | | |
  
## モデル・リレーション仕様  

Eloquent ORM を使用し、以下の通りテーブル間の関連付けを定義しています。  
  
### User　モデル(App\Models\User)  
１対１リレーション:profile()  
・profileモデルと関連づけられています。ユーザーは１つの詳細プロフィールを持ちます。  
・一括割り当て制限($fillable):name,email,password (Fortifyによる認証基盤として機能します。)  
  
### profile モデル(App\Models\Profile)  
1対１リレーション（逆方向）:user()  
・Userモデルに属しています。user_idを介して親ユーザーを特定します。  
・一括割り当て制限($fillable):user_id,name,birthday,image (ユーザー名、誕生日、画像パスを管理)

### Product モデル(APP\Models\Product)
多対多リレーション：seasons()  
・product_season 中間テーブルを介して Season モデルと関連づけられています。  
・withTimestamps()を有効にしており、中間テーブルの created_at/updated_at を自動更新します。  
・一括割り当て制限($fillable):name,price,image,description  
  
### Season モデル(App\Models\Season)  
多対多リレーション：products()  
・product_season 中間テーブルを介して Product モデルと関連づけられています。  
・一括割り当て制限($fillable):name  
  
## 初期データ仕様  

### SeasonSeeder  

システムで利用する基本の季節データを登録します。  
登録内容 : 春、夏、秋、冬

### ProductSeeder  

商品テーブルへのデータ登録と同時に、中間テーブルを介した季節データとの紐付けを行います。  
（例）
| 商品名 | 価格 | 画像名 | 紐付けられる季節 |  
| :---- | :---- | :---- | :---- |  
| キウイ | 800 | kiwi.png | 秋、冬 |  
| ストロベリー | 1200 | strawberry.png | 春、冬 |

### リレーションの実装コード概要  

Eloquent の attach()メソッドを使用し、中間テーブル(product_season)にレコードを自動投入しています。  

## 商品一覧画面  

登録されているすべての商品を閲覧・検索できるメイン画面です。  
商品を探しやすいよう、検索機能とソート機能を備えています。  

### 主な機能

1.商品リスト表示  
 ・商品画像、名前、価格をタイル（カード）形式で一覧表示します。  
 ・各商品をクリックすることで、詳細画面に遷移します。  
 ・「+商品を追加」をクリックすると商品登録画面に遷移します。  
  
２.検索・絞り込み  
・キーワードの検索：商品名完全一致検索と、一部を入力して部分一致検索が可能です。  
 ・商品検索機能と並べ替え機能を同時に適用することができます。  
  
3.並び替え（ソート）機能  
 ・「価格（高い順/低い順）」での並び替えに対応しています。  
 ・結果の表示の際に、並び替え条件をタグ表示することができ、タグ表示右側の「×」ボタンをクリックすると並び替え機能をリセットすることができます。  
  
４.ページネーション  
 ・商品が多い場合でも、ページを分割して表示し（１ページあたり６件）、パフォーマンスを維持します。  

## 商品詳細画面  

登録されている商品の詳細情報を確認し、編集および削除を行うための画面です。  

### 主な機能  

1.情報の編集と更新  
 ・商品名、価格、季節、商品説明を現在の登録内容に基づいて表示します。  
 ・編集後、「変更を保存」ボタンでデータベースに保存。（商品一覧画面にリダイレクト）  
  
2.画像の管理  
 ・プレビュー機能：現在設定されている商品画像を画面左側に表示します。  
 ・既存ファイル名の表示：ファイル選択ボタンの横に、現在サーバーに保存されているファイル名を薄いグレーで表示しています。  
 ・画像更新：新しいファイルを選択することで、既存画像を上書き保存できます。  
  
3.季節の紐付け（多対多）  
 ・春・夏・秋・冬の選択肢をラジオボタン/チェックボックス形式設置。(複数選択可)  
 ・登録されている季節が初期状態で選択せれるようにしています。  
  
4.削除機能と安全策  
 ・画面右下のゴミ箱のアイコンから商品の削除が可能です。  
 ・確認ダイアログ:JavaScript (confirm) を活用し、削除実行前に「本当に削除しますか？」という警告を出すことで、誤削除を防止します。  
  
5.ログインしているユーザーの情報を画面上に反映し、「ログイン中であること」を明示します。  
 ●ヘッダー/ナビゲーション：  
　・ユーザー画像：登録した画像が丸型のアイコンで表示されます。(画像登録ない場合は👤を表示)  
　・名前：「◯◯さん」といった形式で表示されます。  

## 商品登録画面  
### 1. バリデーション仕様  

全ての項目を必須入力とし、カスタムエラーメッセージを日本語で表示します。  
  
### 2. UI/UX の工夫  

- **リアルタイム・プレビュー**: JavaScript（FileReader API）を活用し、画像を選択した瞬間に画面上にプレビューを表示します。これにより、アップロード間違いを未然に防ぎます。

### 3. 画像管理  

- アップロードされた画像は `storage/app/public/images` に一意のファイル名で保存されます。  
- `php artisan storage:link` コマンドにより公開ディレクトリと同期し、高速な画像表示を実現しています。  
  
## 新規登録画面  
ユーザーが本サービスを利用するためのアカウントを作成する画面。  
### 項目定義  
| 項目名 | フォーム種別 | バリデーションルール |  
| :---- | :---- | :---- |  
| 名前 | text | 必須入力 |  
| メールアドレス | email | 必須入力、有効なメール形式、重複不可 |  
| パスワード | password | 必須入力、確認用パスワードと一致 |  
| パスワード（確認） | password | 必須入力 |
  
### 遷移・ロジック  
1.登録画面をクリックしたとき：CreateNewUserアクションを実行し、usersテーブルにレコードを保存。  
2.登録成功後の挙動：  
 ・そのまま自動ログイン。  
 ・商品一覧表を開くにはプロフィールが必須のため、プロフィール登録画面へ強制リダイレクトを行う。  
  
### ログイン画面  
登録済みのユーザーが、メールアドレスとパスワードを用いて認証を行う画面。  
### 項目定義  
| 項目名 | フォーム種別 | バリデーションルール |  
| :---- | :---- | :---- |  
| メールアドレス | email | 必須入力、有効なメール形式 |  
| パスワード | password | 必須入力 |
  
### 遷移・ロジック  
1.認証処理：FortifyServiceProviderのauthenticateUsingメソッドにて、usersテーブルとの照合を行う。  
2.ログイン後の挙動：  
 ・原則として「商品一覧画面」へ遷移。  
 ・ただし、ミドルウェアによりプロフィール未登録と判定された場合は、プロフィール登録画面へ誘導する。  
  
## ログアウト処理  
セッションを終了し、認証状態を解除しログイン画面にリダイレクトする。  
  
## プロフィール登録画面  
ユーザーの情報を登録する画面  
### 項目定義  
| 項目名 | フォーム種別 | バリデーションルール |  
| :---- | :---- | :---- |
| ユーザー画像 | file(image) | 任意。（画像登録ない場合はアイコンを表示） |  
| 名前 | text | 必須入力 | 必須入力（ニックネームを想定） |  
| 誕生日 | date | 必須。生年月日を選択。 |  
  
### 遷移・ロジック  
1.データ保存：profilesテーブルにuser_idと紐づけて保存。  
2.初期登録フロー：新規会員登録後、必須項目を入力しない限り商品一覧の全機能を利用できないよう制限。  

