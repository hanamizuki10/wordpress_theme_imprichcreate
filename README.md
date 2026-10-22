
# wordpress_theme_imprichcreate
個人で運営しているブログサイト [IMPRICH CREATE | 徒然なるままに… ハナミズキによるIT忘備録](https://www.imprich-create.site/) のオリジナルテーマです。
テーマ名は「imprichcreate」です。

内部で利用しているライブラリは次のとおりです。
テーマに同梱しています。

- [Font Awesome Free](https://fontawesome.com/free) 5.8.1
- [lightbox2](https://lokeshdhakar.com/projects/lightbox2) 2.11.0（ギャラリーの拡大表示に使用）
- jQuery（WordPress に標準で入っているものを使用）

# Dependency
2026年10月に、次の環境で表示を確認しています。

- PHP 8.4
- WordPress 7.1.3

作成当初（2019年）は PHP 7.1 と WordPress 5.2 で動かしていました。
PHP 8.4 で警告が出ていた箇所と、WordPress 5.5 以降の仕様変更で表示が変わっていた箇所は修正済みです。

# Setup
`wp-content/themes/imprichcreate` を WordPress の `themes` フォルダに置き、管理画面でテーマ「IMPRICH CREATE」を有効化すると使えます。

初めて WordPress で作ったオリジナルテーマで、今後も構成を随時見直していくため、WordPress 公式ディレクトリに登録する予定はありません。

# 動作確認の方法
[WordPress Playground](https://wordpress.org/playground/) を使うと、PHP や MySQL を用意しなくても、Node.js だけでこのテーマを最新の WordPress 上で確認できます。
PHP のバージョン指定、デバッグ表示の有効化、確認用のサンプルデータの投入まで自動で済みます。

Node.js 20.10 以上を入れた状態で、リポジトリの直下で次のコマンドを実行し、http://127.0.0.1:9400 を開きます。

```bash
npm install
npm run playground
```

手元で編集中のテーマがそのまま読み込まれます。
仕組みと詳しい使い方は [playground/README.md](playground/README.md) にまとめています。

Windows で HTTPS 通信を検査するウイルス対策ソフト（Avast など）を使っている場合は、最初に一度だけ追加の設定が必要です。
設定しないと、`npm install` や `npm run playground` が `Error: fetch failed` で止まることがあります。
手順は [Windows でウイルス対策ソフトを使っている場合](playground/README.md#windows-でウイルス対策ソフトを使っている場合) を参照してください。

# License
GPL v2

WordPress のライセンス規約に沿っています。

# Authors
hanamizuki10

# References
- WordPress 標準デザイン講座【Version 4.x対応】
- エンジニアのためのWordPress開発入門
