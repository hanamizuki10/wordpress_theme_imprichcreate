<?php
require '/wordpress/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

function ic_img( $name, $w, $h, $rgb ) {
	$im = imagecreatetruecolor( $w, $h );
	imagefill( $im, 0, 0, imagecolorallocate( $im, $rgb[0], $rgb[1], $rgb[2] ) );
	$up   = wp_upload_dir();
	$path = $up['path'] . "/$name.png";
	imagepng( $im, $path );
	$id = wp_insert_attachment( array( 'post_mime_type' => 'image/png', 'post_title' => $name, 'post_status' => 'inherit' ), $path );
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $path ) );
	return $id;
}

// 固定ページ（フロント / ブログ / 親子）
$front = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'トップ', 'post_name' => 'top', 'post_content' => '<!-- wp:paragraph --><p>フロントページの本文です。</p><!-- /wp:paragraph -->' ) );
$blog  = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'ブログ', 'post_name' => 'blog' ) );
$about = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'このサイトについて', 'post_name' => 'about', 'post_content' => '<p>親ページです。</p>' ) );
wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'プロフィール', 'post_name' => 'profile', 'post_parent' => $about, 'post_content' => '<p>子ページです。</p>' ) );
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $front );
update_option( 'page_for_posts', $blog );
update_option( 'blogname', 'IMPRICH CREATE' );
update_option( 'blogdescription', 'テーマ検証用サイト' );

// 投稿（親子カテゴリ・タグ・アイキャッチ・more・コメント）
$tech = wp_insert_term( '技術', 'category', array( 'slug' => 'tech' ) );
$php  = wp_insert_term( 'PHP', 'category', array( 'slug' => 'php', 'parent' => $tech['term_id'] ) );
$img1 = ic_img( 'post-eyecatch', 1200, 675, array( 70, 130, 180 ) );
for ( $i = 1; $i <= 12; $i++ ) {
	$pid = wp_insert_post( array(
		'post_status'   => 'publish',
		'post_title'    => "検証用の記事 その$i",
		'post_content'  => "<p>記事{$i}の冒頭です。抜粋の文字数を確認するため、少し長めの文章を入れています。WordPressテーマの表示確認用のテキストです。</p><!--more--><p>moreタグ以降の本文です。</p>",
		'post_date'     => date( 'Y-m-d H:i:s', strtotime( "-$i days" ) ),
		'post_category' => array( $i % 2 ? $php['term_id'] : $tech['term_id'] ),
		'tags_input'    => array( 'テスト', 'WordPress' ),
	) );
	if ( $i <= 3 ) {
		set_post_thumbnail( $pid, $img1 );
	}
	if ( 1 === $i ) {
		wp_insert_comment( array( 'comment_post_ID' => $pid, 'comment_author' => '読者', 'comment_content' => 'コメントのテストです。', 'comment_approved' => 1 ) );
	}
}

// ポートフォリオ
$web = wp_insert_term( 'Web', 'portfoliocat', array( 'slug' => 'web' ) );
$wpc = wp_insert_term( 'WordPress', 'portfoliocat', array( 'slug' => 'wordpress', 'parent' => $web['term_id'] ) );
$img2 = ic_img( 'portfolio-thumb', 800, 600, array( 200, 120, 60 ) );
$pf = array(
	array( 'URLとアイキャッチあり', 'https://example.com/', $img2 ),
	array( 'URLあり・アイキャッチなし', 'https://example.org/', 0 ),
	array( 'URLなし・アイキャッチあり', '', $img2 ),
);
foreach ( $pf as $p ) {
	$id = wp_insert_post( array( 'post_type' => 'portfolios', 'post_status' => 'publish', 'post_title' => $p[0], 'post_content' => '<p>ポートフォリオの詳細です。</p>' ) );
	wp_set_object_terms( $id, array( $wpc['term_id'] ), 'portfoliocat' );
	update_post_meta( $id, 'portfolio_description', 'ポートフォリオの説明文です。' );
	if ( $p[1] ) {
		update_post_meta( $id, 'portfolio_url', $p[1] );
	}
	if ( $p[2] ) {
		set_post_thumbnail( $id, $p[2] );
	}
}

// ギャラリー（最後の1件はメディアを削除した状態を再現）
$illust = wp_insert_term( 'イラスト', 'gallerycat', array( 'slug' => 'illust' ) );
$colors = array( array( 230, 90, 120 ), array( 90, 180, 120 ), array( 120, 100, 220 ) );
foreach ( $colors as $n => $rgb ) {
	$id = wp_insert_post( array( 'post_type' => 'gallery', 'post_status' => 'publish', 'post_title' => 'ギャラリー画像' . ( $n + 1 ) ) );
	wp_set_object_terms( $id, array( $illust['term_id'] ), 'gallerycat' );
	$att = ic_img( "gallery-$n", 1600, 1200, $rgb );
	set_post_thumbnail( $id, $att );
	if ( 2 === $n ) {
		update_post_meta( $id, '_thumbnail_id', 999999 );
	}
}

// メニュー
foreach ( array( 'header' => 'グローバル', 'footer' => 'フッター' ) as $loc => $name ) {
	$menu = wp_create_nav_menu( $name );
	foreach ( array( 'ブログ' => '/blog/', 'ポートフォリオ' => '/portfolios/', 'ギャラリー' => '/gallery/', 'このサイトについて' => '/about/' ) as $t => $u ) {
		wp_update_nav_menu_item( $menu, 0, array( 'menu-item-title' => $t, 'menu-item-url' => home_url( $u ), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom' ) );
	}
	$locs         = get_theme_mod( 'nav_menu_locations', array() );
	$locs[ $loc ] = $menu;
	set_theme_mod( 'nav_menu_locations', $locs );
}

global $wp_rewrite;
$wp_rewrite->set_permalink_structure( '/archives/%post_id%' );
// カテゴリとタグの URL 規則は init の時点のパーマリンク設定で作られているので、作り直してから反映する
create_initial_taxonomies();
flush_rewrite_rules();
echo 'seeded';
