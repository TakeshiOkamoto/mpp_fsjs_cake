# 青色申告決算書＆仕訳帳システム 

個人事業主用の「青色申告決算書の作成支援」と「仕訳帳を管理」するシステムです。  
初心者でも扱いやすいように基本的な「仕訳の記入例」を付属しています。　
  
DEMO    
[https://www.petitmonte.com/cake/mpp_fsjs_cake/](https://www.petitmonte.com/cake/mpp_fsjs_cake/)  
  
主な対象は「広告収入」や「業務請負」など仕訳が単純な方用です。  
※小売業や製造原価には対応していません。   
  
これはライトバージョンです。フルバージョンの開発は検討中です。  
フルバージョンになると勘定科目が一気に増えるので、初心者の方の仕訳や操作が難しくなります。  

## 1. 基本情報

### 前提条件 
・事業で使用する「通帳」は1つとします。  
・事業で利用する「クレジットカード」はその通帳で引き落とされるものとします。  
※通帳、クレジットカードは事業主による私的利用があっても構いません。  

### 青色申告決算書 
システムが出力できるのは次の3つの表です。  
  
・損益計算書  
・貸借対照表   
・月別売上(収入)金額及び仕入金額 ※売上のみ   
  
税務署に提出する際には上記の表を元に  
[国税庁のWebサイト(確定申告書等作成コーナー)](https://www.keisan.nta.go.jp/kyoutu/ky/sm/top#bsctrl)で「正式な書式」の青色申告決算書を作成します。  
```rb
<平成30年度税制改正について>
令和2年度以後は青色申告特別控除は55万円、基礎控除は48万円となりました。
青色申告特別控除を65万円にするには「e-Taxによる申告(電子申告)」または「電子帳簿保存」(申請必須)をする必要があります。
  
※なお、システムでは便宜上65万円にしてあります。 適宜読み替えて下さい。
```  
※詳しくは[国税庁](https://www.nta.go.jp/publication/pamph/shotoku/h32_kojogaku_change.pdf)をご覧ください。
  
### 勘定科目 

損益計算書で対応している科目  ※経費科目に全て対応。
```rb
租税公課、荷造運賃、水道光熱費、旅費交通費、通信費、広告宣伝費、接待交際費、損害保険料、修繕費 
消耗品費、減価償却費、福利厚生費、給料賃金、外注工賃、利子割引料、地代家賃、貸倒金、雑費

```   
貸借対照表で対応している科目  
```rb
現金、その他の預金、前払金、未払金、事業主貸、事業主借、元入金
```   
以下の科目が必要な場合は各自でプログラムを変更する必要があります。  
```rb
当座預金、定期預金、受取手形、売掛金、有価証券、棚卸資産、貸付金、建物、建物附属設備、機械装置、
車両運搬具、工具・器具・備品、土地、支払手形、買掛金、借入金、前受金、預り金、貸倒引当金
```   

## 2. 環境
・CakePHP 3.9系  
・MariaDB 10.2.2以上 (MySQL5.5以上でも可)  
  
## 3. インストール方法
  
### プロジェクトの生成  
```rb
cd 任意のディレクトリ
composer create-project --prefer-dist cakephp/app:3.9.* 任意のプロジェクト名
```
次にココにあるファイルをダウンロードして、プロジェクトに上書きします。

### config/app_local.php
本番モード  
```rb
'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),
```
データベース
```rb
'Datasources' => [
        'username' => 'ユーザー名',
        'password' => 'パスワード',
        'database' => 'データベース名', 
        'log' => false, 
],
```
logは任意です。SQLログ(logs/queries.log)の出力設定です。

### config/app.php
ロケール/タイムゾーンの設定(アプリ側)
```rb
'App' => [
    'encoding' => env('APP_ENCODING', 'UTF-8'),
    'defaultLocale' => env('APP_DEFAULT_LOCALE', 'ja_JP'),
    'defaultTimezone' => env('APP_DEFAULT_TIMEZONE', 'Asia/Tokyo'),
],
```
タイムゾーンの設定(MySQL/MariaDB側)
```rb
'Datasources' => [
    'default' => [
        'timezone' => 'Asia/Tokyo',
        'quoteIdentifiers' => true,
    ],
],
```
ついでにquoteIdentifiersをtrueにして下さい。  
CakePHPで発行されるSQLのテーブル名、カラム名の前後にバッククォートが付加されます。  
```rb
(例) select `カラム名` from `users`
```  
ここのタイムゾーンの設定がエラーになる場合は[ココ](https://www.petitmonte.com/php/cakephp_project.html#SQLSTATE[HY000])を参照。  

### bin/cake
bin/cakeファイルのパーミッションは実行権限を付与して下さい。(例)700 or 744 or 764など
    
### マイグレーション
```rb
bin/cake migrations migrate
```

### シーディング
次のコマンドを実行して勘定科目のデータを自動登録します。  
```rb
bin/cake migrations seed
```

### 管理者アカウントの作成
コンソールコマンド(src/Command/HelloCommand.php)を作成していますので、
```rb
bin/cake hello ユーザー名 メールアドレス パスワード
```
で登録可能です。※スペースは半角スペースにして下さい。
```rb
(例)
bin/cake hello admin admin@example.com 12345678
```

### 実行する
```rb
bin/cake server
```
メイン    
[http://localhost:8765/](http://localhost:8765/)   
ログイン   
[http://localhost:8765/admin/login](http://localhost:8765/admin/login) 
  
## CakePHPプロジェクトの各種初期設定
その他は次の記事を参照してください。  
  
[CakePHPプロジェクトの各種初期設定](https://www.petitmonte.com/php/cakephp_project.html)  

## 同梱ファイルのライセンス
Bootstrap v4.3.1 (https://getbootstrap.com/)  
```rb
Copyright 2011-2019 The Bootstrap Authors  
Copyright 2011-2019 Twitter, Inc.
```

