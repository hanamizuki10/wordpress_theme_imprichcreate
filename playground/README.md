# WordPress Playground によるテーマの動作確認

PHP や WordPress のバージョンを上げたときに、テーマが壊れないかを確かめたいことがあります。
ただ、本番のレンタルサーバー（ロリポップ）で直接試すわけにはいきません。
手元に PHP と MySQL と WordPress を揃えれば確認できますが、このテーマのためだけにその環境を維持するのは手間に見合いません。

このフォルダは、その確認を Node.js だけで済ませるための設定一式です。
コマンドを一つ実行すると、PHP 8.4 と最新の WordPress にこのテーマを入れ、デバッグ表示を有効にし、確認用の記事や画像まで投入したサイトが手元で立ち上がります。
本番サイトには一切触れません。

## 使い方

### 必要なもの

Node.js 20.10 以上が必要です。
初回だけ、リポジトリの直下で次のコマンドを実行し、Playground のコマンドライン版を取得します。

```bash
npm install
```

### Windows でウイルス対策ソフトを使っている場合

HTTPS 通信を検査するウイルス対策ソフト（Avast、AVG、ESET など）が入っていると、`npm install` や `npm run playground` が `Error: fetch failed` や証明書のエラー（`UNABLE_TO_VERIFY_LEAF_SIGNATURE` など）で止まることがあります。
こうしたソフトは通信の中身を検査するために、サイトの証明書を自分の証明書に差し替えています。
ブラウザは Windows の証明書ストアに登録されたそのソフトの証明書を信頼するので問題なく通信できますが、Node.js は既定では自前の証明書リストしか使わないため、接続を拒否します。

環境変数 `NODE_USE_SYSTEM_CA` を `1` にすると、Node.js も Windows の証明書ストアを使うようになり、ブラウザと同じように通信できます。
ウイルス対策ソフトの HTTPS 検査を止めたり、除外を設定したりする必要はありません。

一度だけ、PowerShell で次のコマンドを実行して、ユーザーの環境変数に登録します。

```powershell
[Environment]::SetEnvironmentVariable('NODE_USE_SYSTEM_CA', '1', 'User')
```

設定は、このあと新しく開いたターミナルから有効になります。
新しいターミナルで次のコマンドを実行し、`1` と表示されれば設定できています。

```powershell
$env:NODE_USE_SYSTEM_CA
```

環境変数を登録せずに、その場だけ試したいときは、コマンドの前に設定を付けて実行します。

```powershell
$env:NODE_USE_SYSTEM_CA = '1'; npm run playground
```

### 起動と終了

リポジトリの直下で次のコマンドを実行します。

```bash
npm run playground
```

「Ready! WordPress is running on http://127.0.0.1:9400」と表示されたら、ブラウザで http://127.0.0.1:9400 を開きます。
起動には1分ほどかかります。
終了するときは、コマンドを実行したターミナルで Ctrl+C を押します。

サイトは起動するたびに新しく作り直されます。
管理画面や投稿の画面で行った変更は、終了すると消えます。

管理画面に入るときは、http://127.0.0.1:9400/wp-login.php から、Playground が最初に作る管理者アカウント（ユーザー名 `admin`、パスワード `password`）でログインします。
このアカウントは手元の検証用サイトにしか存在しません。

### テーマを編集したとき

テーマのフォルダは、Playground の中にコピーするのではなく、そのまま読み込ませています。
そのため、テーマのファイルを保存すれば、サーバーを起動し直さなくても、ブラウザを再読み込みするだけで反映されます。

### 確認に使える仕掛け

サンプルデータは、テーマの表示が分岐する箇所を一通り通るように作っています。

| 種類 | 内容 | 確かめられること |
|---|---|---|
| 記事 | 12件（親子カテゴリ、タグ、アイキャッチ、more タグ、コメント付き） | 一覧のページ送り、パンくずリスト、抜粋 |
| 固定ページ | トップ、ブログ、親子ページ | フロントページ、投稿一覧ページ、親子のパンくず |
| ポートフォリオ | 3件（URL とアイキャッチの有無を組み合わせ） | サムネイルとリンクの出し分け |
| ギャラリー | 3件（うち1件は画像を削除した状態） | lightbox、画像が欠けた投稿の扱い |
| メニュー | ヘッダーとフッター | ナビゲーション、スマホ幅のメニュー開閉 |

PHP の警告は画面にも表示されますが、HTML の属性値の中に出力された警告は画面では見えません。
警告はすべて `playground/logs/debug.log` にも書き出されるので、取りこぼしがないかはこのファイルで確かめます。
このファイルは Git の管理対象から外しています。

## Playground が動く仕組み

WordPress は本来、PHP が動く Web サーバーとデータベースがないと動きません。
Playground は、そのサーバー側の部品を Node.js の中に持ち込んでいます。

- **PHP**：PHP の処理系そのものを WebAssembly にコンパイルしたものを、Node.js が実行しています。PHP のバージョンを選べるのは、バージョンごとにビルドされた処理系を切り替えているためです。
- **データベース**：MySQL の代わりに SQLite を使っています。WordPress が発行する MySQL 向けの SQL を、プラグイン（SQLite Database Integration）が SQLite 向けに変換します。
- **Web サーバー**：コマンドライン版自身が 9400 番ポートでリクエストを受け、PHP に渡して、返ってきた HTML をブラウザに返します。
- **ファイル**：WordPress のファイルは、PHP から見える仮想のファイルシステムに置かれています。手元のフォルダをその中の決まった場所に対応づける（マウントする）と、PHP からは手元のファイルがそのまま見えます。テーマの編集がすぐ反映されるのも、debug.log が手元に書き出されるのも、このマウントのおかげです。

同じ仕組みはブラウザでも動き、https://playground.wordpress.net/ ではブラウザの中だけで WordPress を動かせます。
このフォルダでコマンドライン版を使っているのは、マウントの指定まで含めた起動手順を、コマンド一つとして `package.json` に書いておけるからです。

## 起動コマンドの中身

`npm run playground` は、`package.json` に書いた次のコマンドを実行します。

```bash
wp-playground-cli server --php=8.4 --wp=latest --mount=./wp-content/themes/imprichcreate:/wordpress/wp-content/themes/imprichcreate --mount=./playground:/playground --blueprint=./playground/blueprint.json
```

| 指定 | 意味 |
|---|---|
| `--php=8.4` | PHP 8.4 で動かす |
| `--wp=latest` | WordPress の最新版を取得して使う |
| `--mount=./wp-content/themes/imprichcreate:...` | 手元のテーマを、WordPress のテーマフォルダとして読み込ませる |
| `--mount=./playground:/playground` | このフォルダを `/playground` として読み込ませる（サンプルデータの PHP と debug.log の置き場） |
| `--blueprint=./playground/blueprint.json` | 起動時の手順を書いたファイルを指定する |

コマンドライン版の版は 3.1.54 に固定しています。
これより新しい版（3.1.55 以降）は Node.js 24.18 以上が必要になります。
Node.js を 24 に上げたら、`package.json` の `@wp-playground/cli` の版を上げて構いません。

## ブループリントで環境を組み立てる

Playground には、起動時に実行する手順を JSON で渡せます。
この JSON を**ブループリント**と呼びます。
`blueprint.json` は、WordPress のインストールが終わったあとに次の手順を順に実行します。

| 手順（step） | 設定 | 役割 |
|---|---|---|
| `defineWpConfigConsts` | `WP_DEBUG` と `WP_DEBUG_DISPLAY` を有効にし、`WP_DEBUG_LOG` に `/playground/logs/debug.log` を指定 | 警告を画面と手元の debug.log の両方に出す |
| `activateTheme` | `imprichcreate` | マウントしたテーマを有効にする |
| `runPHP` | `/playground/seed.php` を読み込む | サンプルデータとメニューを作り、パーマリンクを本番と同じ `/archives/%post_id%` にする |

サンプル画像は外部から取ってくるのではなく、`seed.php` の中で PHP の GD 拡張を使い、単色の PNG として生成しています。
WordPress にアップロードした扱いにして縮小版も作らせているので、`medium` や `large` といった画像サイズの指定も本番と同じように確かめられます。

## 注意点

- WordPress は latest を指定しているので、起動する時期によってバージョンが変わります。2026年10月の確認時点では 7.1.3 でした。
- 検証用のサイトは英語設定です。そのため、WordPress 本体が出力する見出しなどは英語で表示されます（日本語のサイトなら「カテゴリー: 技術」と表示されるところが「Category: 技術」になる、など）。
- Windows でコマンドライン版を直接実行するとき、`--mount` に `C:/...` のような絶対パスを渡すとエラーになります。ドライブ名のコロンが、手元のパスと Playground 側のパスを区切るコロンと区別できないためです。絶対パスを使うときは `--mount-dir 手元のパス /wordpress/...` の形で指定します。
- さらに Git Bash から実行すると、`/wordpress/...` のような引数が Windows のパス（`C:/Program Files/Git/wordpress/...`）に書き換えられてしまいます。コマンドの前に `MSYS_NO_PATHCONV=1` を付けると、この書き換えを止められます。
- `npm run playground` は相対パスで指定していて、Git Bash も経由しないので、どちらの問題も起きません。
- 起動時に `Error: fetch failed` と出て止まる場合は、[Windows でウイルス対策ソフトを使っている場合](#windows-でウイルス対策ソフトを使っている場合) の設定を確認してください。

## ファイル一覧

| ファイル | 役割 |
|---|---|
| `blueprint.json` | 起動時の手順（デバッグ設定、テーマの有効化、サンプルデータの投入） |
| `seed.php` | サンプルデータを作る PHP（ブループリントの `runPHP` から読み込む） |
| `logs/` | debug.log の書き出し先（中身は Git の管理対象外） |
| `../package.json` | 起動コマンドと、コマンドライン版の版の指定 |
