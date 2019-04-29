<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'imprich_create_db');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'imprich_create_db_user');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', '5hpMBFMo');

/** MySQL のホスト名 */
define('DB_HOST', 'localhost');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8mb4');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '/v(Hcjvd2]}8o!>I:N%BNEnTdL^W>_(cxoaxR%vBQdo>J?[`TwlA0hQdS[40<Lz<');
define('SECURE_AUTH_KEY', '${7XjD&V*!a@^e*}+}MUv3mkX)h2t)8liL/x4+8p<m@g`Tt<$_{npany`%G4!z5%');
define('LOGGED_IN_KEY', 'Tw31DsEf~N:EUd0W[H3Uz!xGU]J^*D]%P?F>eoTnv;+8{MQwD0O$f,[H1a-7hbkW');
define('NONCE_KEY', 'IV>Ya%;fG6[Diubk{^,pzvxcvz)aT2:[%c]dmSB*T:#?3XJ)Ws|nUBHTqXXM1&Ow');
define('AUTH_SALT', 'XV@5BBR]D%!OntZdl*$xBSQZfCqZ8[lo0.=9Bi:QYwe+/k1LJsesB6M}1Y#2@>6n');
define('SECURE_AUTH_SALT', ';+suZ3{|.QE]@fSR`^B-Z($U5g_QH&A.JnGR@nB<;Ij,8voez29B=8O;0uZXeN|I');
define('LOGGED_IN_SALT', ']|AjM7as8J@M/2<ddBvU!m1Ge!ckL>I;XT$N,_7i=p.)uyx#lN;#kg*kobgrRk^(');
define('NONCE_SALT', '<N#=w_2k}vOd"Q|H;Qb{DQ:,3W#jQ<OJi{d.e-Z?Qdq*i!v0E$)uL@=Bw2L]3@.P');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp3_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', true);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
  define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
