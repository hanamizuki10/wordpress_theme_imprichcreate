<?php


/**
 * アクションフック名 : custom_theme_setup
 * RSS用フィードリンクを追加（追加することでブログの更新通知を受け取れる…RSS用環境を作るためのパーツ）
 * タイトルタグを動的に出力
 * アイキャッチ画像を有効化
 * カスタムメニューを有効化
 * カスタムヘッダーを有効化
 */
function custom_theme_setup() {
    //-------------------------------------
	//head内にフィードリンクを出力
	// 背景
	// ブログの更新通知を受け取るためにRSS登録を利用している人も多いと思う。
	// デフォルトではこの機能がついていないので add_theme_support( ‘automatic-feed-links’ ); でフィードを自動作成することができる。
	add_theme_support( 'automatic-feed-links' );

    //-------------------------------------
	// タイトルタグを動的に出力
	// header.php上にて、<title>タグを記入する必要が無くなる。
	// 自動的に以下の奴でタイトルが設定される。
	add_theme_support( 'title-tag' );


    //-------------------------------------
    //アイキャッチ画像を有効化
    // 投稿作成画面にアイキャッチ画像の設定欄を表示する。
	add_theme_support( 'post-thumbnails' );
	// 生成するアイキャッチ画像のサイズを指定する。
    // 第1引数 : 画像の幅
    // 第2引数 : 画像の高さ
    // 第3引数 : TRUE=画像を切り抜く, FALSE=縦横比を保って縮小する。
    //          TRUEの補足：設定→メディタ設定→サムネイルのサイズで、サムネイルを実寸法にトリミングするにチェックを入れた場合と同じ挙動
    // アイキャッチ画像のサイズパターンも複数必要になる場合は、add_image_sizeを使う。
    // 横760px：縦428pxが16:9
    // 720x405
	set_post_thumbnail_size( 720, 405, false );




	// テーマの位置を定義
	register_nav_menus(
		array(
			'header' => 'グローバルナビゲーション',
			'footer' => 'フッターナビゲーション',
		)
	);


}
// after_setup_themeアクション実行時にcustom_theme_setupを呼び出す。
// 一般的リクエスト中に実行されるアクション
// 管理画面リクエスト中に実行されるアクション
add_action( 'after_setup_theme', 'custom_theme_setup' );

/**
 * アクションフック名 : add_my_scripts
 *  スタイルシート読み込み
 *  C06-18
 *  CSSファイルをfunctions.phpから読み込む
 */
function add_my_scripts() {
	wp_enqueue_style(
		'base-style', //CSSの識別ID
		esc_url( get_stylesheet_uri() ), //CSSファイルへのpath ←追記
		array(), //先に読み込むCSS
		'1.5', //CSSファイルのバージョン指定
		'all' //CSSのmedia属性
	);
    wp_enqueue_style( 'fontawesome-style', get_template_directory_uri() . '/fontawesome/css/all.css', array( ), '5.8.1', 'all' );

    wp_enqueue_script( 'imprichcreate-main-navigation', get_theme_file_uri( '/js/main-navigation.js' ), array('jquery'), '1.0.0', true );


	if ( is_post_type_archive( 'gallery' ) || is_tax( 'gallerycat') ){
		// ギャラリーもしくは、ギャラリーカテゴリー情報の表示ページの場合
		wp_enqueue_style( 'lightbox2-style', get_template_directory_uri() . '/jquery-plugins/lightbox2/css/lightbox.min.css', array( ), '2.11.0', 'all' );
		wp_enqueue_script( 'lightbox2-script', get_theme_file_uri( '/jquery-plugins/lightbox2/js/lightbox.min.js' ), array('jquery'), '2.11.0', true );
	}

}
// wp_enqueue_scriptsアクション実行時にadd_my_scriptsを呼び出す。
// （'wp_enqueue_scripts'のアクションはwp_head()またはwp_footer()により実行されます。header.php/footer.phpにこれらの関数が正しく配置されていないと、スクリプトおよびスタイルの読み込みは実行されません。）
// 一般的リクエスト中に実行されるアクション
add_action( 'wp_enqueue_scripts', 'add_my_scripts' );



function custom_widget_register() {
	// ウィジェットエリアの登録
	register_sidebar( array(
		'name' => 'サイドバー',
		'id' => 'sidebar-primary',
		'before_widget' => '<div class="widget widget-sidebar">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
}
// widgets_initアクション実行時にcustom_widget_registerを呼び出す。
// 一般的リクエスト中に実行されるアクション
// 管理画面リクエスト中に実行されるアクション
add_action( 'widgets_init', 'custom_widget_register' );

//本文抜粋を取得する関数
function get_the_custom_excerpt($content, $length) {
	$length = ($length ? $length : 70);//デフォルトの長さを指定する
	$content =  preg_replace('/<!--more-->.+/is',"",$content); //moreタグ以降削除
	$content =  strip_shortcodes($content);//ショートコード削除
	$content =  strip_tags($content);//タグの除去
	$content =  str_replace("&nbsp;","",$content);//特殊文字の削除（今回はスペースのみ）
	$content =  mb_substr($content,0,$length);//文字列を指定した長さで切り取る
	return $content;
}


function custom_register_post_type(){

    /*
    label
    （文字列） （オプション） 投稿タイプを翻訳するための複数形の名前。
    初期値： $post_type
    --
    hierarchical
    （真偽値） （オプション） この投稿タイプが階層を持つ（例：固定ページ）かどうか。true の場合、親を指定できるようになる。編集ページに親を選択するボックスを表示するために、'supports' パラメータに 'page-attributes' を含めなければならない。
    初期値： false
    --
    public
    （真偽値） （オプション） 投稿タイプをパブリックにするかどうか。true の場合、管理画面とフロントエンド（ユーザー）の両方から利用可能。
    初期値： false
    'false' - 投稿タイプをパブリックにしない。他のところで明示的に用意しない限り、管理画面とフロントエンドのどちらからも使えない。
    'true' - 投稿タイプをパブリックにする。フロントエンドと管理画面の両方から使えるように。
    --
    has_archive
    （真偽値|文字列） （オプション） この投稿タイプのアーカイブを有効にする。デフォルトでは、アーカイブのスラッグとして $post_type が使われる。
    初期値： false
    --
    supports
    （配列|真偽値） （オプション） add_post_type_support()/en を直接呼び出すエイリアス。バージョン 3.5 以降では、配列の代わりに真偽値 false を指定することによりデフォルトの動作（title と editor）を止めることができる。
    初期値： title と editor
    'title' （タイトル）
    'editor' （内容の編集）
    'author' （作成者）
    'thumbnail' （アイキャッチ画像。現在のテーマが post-thumbnails をサポートしていること）
    'excerpt' （抜粋）
    'trackbacks' （トラックバック送信）
    'custom-fields' （カスタムフィールド）
    'comments' （コメントの他、編集画面にコメント数のバルーンを表示する）
    'revisions' （リビジョンを保存する）
    'page-attributes' （メニューの順序。「親〜」オプションを表示するために hierarchical が true であること）
    'post-formats' （投稿のフォーマットを追加。投稿フォーマットを参照）
    --
    rewrite
    （真偽値|配列） （オプション） この投稿タイプのパーマリンクのリライト方法を変更する。リライトを避けるには false を指定する。
    初期値： true - $post_type をスラッグに使う
    $args 配列
    'slug' => 文字列 パーマリンク構造のスラッグを変更。デフォルトは $post_type の値。翻訳可能であること。
    'with_front' => 真偽値 Should the permalink structure be prepended with the front base. （例：パーマリンク構造が /blog/ である場合、false ならリンクは /news/、true なら /blog/news/ になる。）デフォルトは true
    'feeds' => 真偽値 この投稿タイプについてフィードのパーマリンク構造を作成する。デフォルトは has_archive 引数の値
    'pages' => 真偽値 パーマリンク構造をページ送りに対応させる。デフォルトは true
    'ep_mask' => 定数 バージョン 3.4 以降 この投稿タイプに endpoint マスクを割り当てる。詳しくは Trac チケット 19275 および Make WordPress Plugins ブログの endpoint を要約した投稿を参照。
    これを指定せず permalink_epmask がセットされていると、permalink_epmask の値が使われる。
    これを指定せず permalink_epmask もセットされていなければ、デフォルトの EP_PERMALINK になる。

     */

    $args = [
        'label' => 'ポートフォリオ',
        'hierarchical' => false,    // 投稿と同じように
        'public' => true,   		// 公開する
        'has_archive' => true,  	// アーカイブページを持たせる
        'supports' => [
            'title','editor','thumbnail', 'custom-fields'    // 投稿作成時に表示するフィールド
        ],
        'rewrite' => [
            'with_front' => false   // http://localhost/appdir/portfolios/  というパーマリンクにする
        ]
    ];

    // 投稿タイプ「 portfolios 」を作成。
    //  この register_post_type() は必ず 'init' アクションの中から呼び出してください。
    //  'init' より前に呼び出すと動作しないため、新規作成または変更した投稿タイプも正常に動作しません。
    register_post_type('portfolios', $args);


	$galleryargs = [
        'label' => 'ギャラリー',
        'hierarchical' => false,    // 投稿と同じように
        'public' => true,   		// 公開する
        'has_archive' => true,  	// アーカイブページを持たせる
        'supports' => [
            'title','thumbnail',     // 投稿作成時に表示するフィールド
        ],
        'rewrite' => [
            'with_front' => false   // http://localhost/appdir/gallery/  というパーマリンクにする
        ]
    ];

    // 投稿タイプ「 gallery 」を作成。
    //  この register_post_type() は必ず 'init' アクションの中から呼び出してください。
    //  'init' より前に呼び出すと動作しないため、新規作成または変更した投稿タイプも正常に動作しません。
    register_post_type('gallery', $galleryargs);


}
add_action( 'init', 'custom_register_post_type' );

/*
カスタム投稿タイプ「 portfolios 」「 gallery 」専用のカテゴリーを生成する。
 */
function custom_register_taxonomy() {
	/**
	* 階層のあるカスタムタクソノミーを新たに追加
	**/
	$args = array(
		'hierarchical' => true, // 階層を利用する
		'label' => 'ポートフォリオカテゴリー', // ラベルを指定
		'rewrite' => array(
			'with_front' => false, // パーマリンクの形式を指定
		),
	);
	// portfolios 投稿タイプに portfoliocat というスラッグ名でタクソノミーを登録
	register_taxonomy( 'portfoliocat', 'portfolios', $args );
	// これで管理者用画面に ポートフォリオカテゴリーという項目が表示される。

	$args = array(
		'hierarchical' => true, // 階層を利用する
		'label' => 'ギャラリーカテゴリー', // ラベルを指定
		'rewrite' => array(
			'with_front' => false, // パーマリンクの形式を指定
		),
	);
	// gallery 投稿タイプに gallerycat というスラッグ名でタクソノミーを登録
	register_taxonomy( 'gallerycat', 'gallery', $args );
	// これで管理者用画面にギャラリーカテゴリーという項目が表示される。
}
add_action( 'init', 'custom_register_taxonomy' );










/*
カスタム投稿タイプ「 portfolios 」が表示されているときはCSS　current-menu-itemを追加する。
 */
function add_parent_url_menu_class( $classes = array(), $item = false ) {
	// リクエストURLを取得する。
	$request_uri = $_SERVER['REQUEST_URI'];

	$is_add_current_menu_item = false;	// メニューにクラスcurrent-menu-itemを追加する条件:初期値false

	if( strpos($request_uri,'archives') !== false ){
		// URLの中に archives が含まれている場合、「ブログ」に対するリクエストである。
		if(strpos($item->url,'blog') !== false){
			// 今回のアイテムが、blog 関連の子ページならば、メニューにクラスcurrent-menu-itemを追加する条件が整う。
			$is_add_current_menu_item = true;
		}
	} else if(strpos($request_uri,'portfoliocat') !== false || strpos($request_uri,'portfolios') !== false){
		// URLの中に portfoliocat が含まれている場合、「ポートフォリオカテゴリ」に対するリクエストである。
		// もしくは
		// portfoliosのスペルがある場合は、子ページが親ページに対するリクエストである。
		if(strpos($item->url,'portfolios') !== false){
			// 今回のアイテムが、 portfolios 関連の子ページならば、メニューにクラスcurrent-menu-itemを追加する条件が整う。
			$is_add_current_menu_item = true;
		}
	} else if(strpos($request_uri,'gallerycat') !== false ){
		// URLの中に gallerycat が含まれている場合、「ギャラリーカテゴリ」に対するリクエストである。
		if(strpos($item->url,'gallery') !== false){
			// 今回のアイテムが、 gallery 関連の子ページならば、メニューにクラスcurrent-menu-itemを追加する条件が整う。
			$is_add_current_menu_item = true;
		}
	}
	if($is_add_current_menu_item){
		// メニューにクラスcurrent-menu-itemを追加する条件が整っている。
		if(in_array('current-menu-item',$classes)==false){
			// 'current-menu-item'が付与される予定でなければ、追加する。
			$classes[] = 'current-menu-item';
		}
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'add_parent_url_menu_class', 10, 3 );





/***
 * パンくずリストを生成する
*/
if ( ! function_exists( 'custom_breadcrumb' ) ) {
	function custom_breadcrumb( $wp_obj = null ) {

		// トップページでは何も出力しない
		if ( is_front_page() ) return false;

		//そのページのWPオブジェクトを取得
		$wp_obj = $wp_obj ?: get_queried_object();

		// サブリンク情報を保持する変数
		$bread_crumb_sub_links = [];
		// 現在のページタイトル情報を保持する変数
		$bread_crumb_current_page_title= '';

		if ( is_attachment() ) {
			/**
			 * 添付ファイルページ ( $wp_obj : WP_Post )
			 * ※ 添付ファイルページでは is_single() も true になるので先に分岐
			 */
			$bread_crumb_current_page_title = $wp_obj->post_title;
		} elseif ( is_home() ) {
			/**
			 * 投稿一覧ページ
			 */
			$bread_crumb_current_page_title = 'ブログ';

		} elseif ( is_single() ) {
			/**
			 * 投稿ページ ( $wp_obj : WP_Post )
			 */
			$post_id    = $wp_obj->ID;
			$post_type  = $wp_obj->post_type;
			$post_title = $wp_obj->post_title;

			// カスタム投稿タイプかどうか
			if ( $post_type !== 'post' ) {
				$the_tax = "";  //そのサイトに合わせ、投稿タイプごとに分岐させて明示的に指定してもよい
				// 投稿タイプに紐づいたタクソノミーを取得 (投稿フォーマットは除く)
				$tax_array = get_object_taxonomies( $post_type, 'names');
				foreach ($tax_array as $tax_name) {
					if ( $tax_name !== 'post_format' ) {
						$the_tax = $tax_name;
						break;
					}
				}

				//カスタム投稿タイプ名の表示
				$bread_crumb_sub_links[] = ['title' => get_post_type_object( $post_type )->label, 'link' => get_post_type_archive_link( $post_type )];

			} else {
				$the_tax = 'category';  //通常の投稿の場合、カテゴリーを表示

				// [ブログ]一覧の追加
				$bread_crumb_sub_links[] = ['title' => 'ブログ', 'link' => home_url('/blog')];

			}

			// タクソノミーが紐づいていれば表示
			if ( $the_tax !== "" ) {

				$child_terms = array();   // 子を持たないタームだけを集める配列
				$parents_list = array();  // 子を持つタームだけを集める配列

				// 投稿に紐づくタームを全て取得
				$terms = get_the_terms( $post_id, $the_tax );

				if ( !empty( $terms ) ) {

					//全タームの親IDを取得
					foreach ( $terms as $term ) {
						if ( $term->parent !== 0 ) $parents_list[] = $term->parent;
					}

					//親リストに含まれないタームのみ取得
					foreach ( $terms as $term ) {
						if ( ! in_array( $term->term_id, $parents_list ) ) $child_terms[] = $term;
					}

					// 最下層のターム配列から一つだけ取得
					$term = $child_terms[0];

					if ( $term->parent !== 0 ) {

						// 親タームのIDリストを取得
						$parent_array = array_reverse( get_ancestors( $term->term_id, $the_tax ) );

						foreach ( $parent_array as $parent_id ) {
							$parent_term = get_term( $parent_id, $the_tax );
							$bread_crumb_sub_links[] = ['title' => $parent_term->name, 'link' => get_term_link( $parent_id, $the_tax )];

						}
					}

					// 最下層のタームを表示
					$bread_crumb_sub_links[] = ['title' => $term->name, 'link' => get_term_link( $term->term_id, $the_tax )];

				}
			}

			// 投稿自身の表示
			$bread_crumb_current_page_title = $post_title;

		} elseif ( is_page() ) {

			/**
			 * 固定ページ ( $wp_obj : WP_Post )
			 */
			$page_id    = $wp_obj->ID;
			$page_title = $wp_obj->post_title;

			// 親ページがあれば順番に表示
			if ( $wp_obj->post_parent !== 0 ) {
				$parent_array = array_reverse( get_post_ancestors( $page_id ) );
				foreach( $parent_array as $parent_id ) {
					$bread_crumb_sub_links[] = ['title' => get_the_title( $parent_id ), 'link' => get_permalink( $parent_id )];
				}
			}
			// 投稿自身の表示
			$bread_crumb_current_page_title = $page_title;

		} elseif ( is_post_type_archive() ) {

			/**
			 * 投稿タイプアーカイブページ ( $wp_obj : WP_Post_Type )
			 */
			$bread_crumb_current_page_title = $wp_obj->label;

		} elseif ( is_date() ) {
			/**
			 * 日付アーカイブ ( $wp_obj : null )
			 */
			$year  = get_query_var('year');
			$month = get_query_var('monthnum');
			$day   = get_query_var('day');

			if ( $day !== 0 ) {
				//日別アーカイブ
				$bread_crumb_sub_links[] = ['title' => $year .'年', 'link' => get_year_link( $year )];
				$bread_crumb_sub_links[] = ['title' => $month .'月', 'link' => get_month_link( $year, $month )];
				$bread_crumb_current_page_title = $day.'日';

			} elseif ( $month !== 0 ) {
				//月別アーカイブ
				$bread_crumb_sub_links[] = ['title' => $year .'年', 'link' => get_year_link( $year )];
				$bread_crumb_current_page_title = $month.'月';
			} else {
				//年別アーカイブ
				$bread_crumb_current_page_title = $year.'年';

			}

		} elseif ( is_author() ) {

			/**
			 * 投稿者アーカイブ ( $wp_obj : WP_User )
			 */
			$bread_crumb_current_page_title =  $wp_obj->display_name .' の執筆記事';

		} elseif ( is_archive() ) {

			/**
			 * タームアーカイブ ( $wp_obj : WP_Term )
			 */
			$term_id   = $wp_obj->term_id;
			$term_name = $wp_obj->name;
			$tax_name  = $wp_obj->taxonomy;

			//  ここでタクソノミーに紐づくカスタム投稿タイプを出力
			$taxonomy = get_taxonomy( $wp_obj->taxonomy);
			if($tax_name == 'category') { // 通常の投稿の場合、カテゴリーを表示
				// [ブログ]一覧の追加
				$bread_crumb_sub_links[] = ['title' => 'ブログ', 'link' => home_url('/blog')];

			} else if($tax_name == 'portfoliocat') { // ポートフォリオ系
				$bread_crumb_sub_links[] = ['title' => 'ポートフォリオ', 'link' => home_url('/portfolios')];

			} else if($tax_name == 'gallerycat') { // ギャラリー系
				$bread_crumb_sub_links[] = ['title' => 'ギャラリー', 'link' => home_url('/gallery')];

			}

			// 親ページがあれば順番に表示
			if ( $wp_obj->parent !== 0 ) {

				$parent_array = array_reverse( get_ancestors( $term_id, $tax_name ) );
				foreach( $parent_array as $parent_id ) {
					$parent_term = get_term( $parent_id, $tax_name );
					$bread_crumb_sub_links[] = ['title' => $parent_term->name, 'link' => get_term_link( $parent_id, $tax_name )];
				}
			}

			// ターム自身の表示
			$bread_crumb_current_page_title =  $term_name;

		} elseif ( is_search() ) {
			/**
			 * 検索結果ページ
			 */
			$bread_crumb_current_page_title =  '「'. get_search_query() .'」で検索した結果';


		} elseif ( is_404() ) {
			/**
			 * 404ページ
			 */
			$bread_crumb_current_page_title =  'お探しの記事は見つかりませんでした。';
		} else {
			/**
			 * その他のページ（無いと思うが一応）
			 */
			$bread_crumb_current_page_title = get_the_title();
		}

		// パンくずリストリンクを出力
		$levelcount=1;	// 階層レベル
		$tab = "\t";
		$LF = "\n";

		echo '<ul class="bread_crumb">' . $LF ;
		// topページのリンク追加
		echo $tab . '<li class="level-'.($levelcount++).' top"><a href="'. home_url() .'">トップページ</a></li>' . $LF;
		foreach( $bread_crumb_sub_links as $sub_link ) {
			// subページのリンク追加
			echo $tab . '<li class="level-'.($levelcount++).' sub"><a href="'. $sub_link['link'] .'">' . $sub_link['title'] . '</a></li>';
		}
		// 現在のページを追加
		echo ' <li class="level-'.($levelcount++).' sub tail current">'. $bread_crumb_current_page_title .'</li>';

		echo '</ul>';  // 冒頭に合わせて閉じタグ

	}
}















/*********************
OGPタグ/Twitterカード設定を出力
*********************/
function my_meta_ogp() {
  if( is_front_page() || is_home() || is_singular() ){
    global $post;
    $ogp_title = '';
    $ogp_descr = '';
    $ogp_url = '';
    $ogp_img = '';
    $insert = '';

    if ( is_front_page() || is_home() ) { //トップページ
       $ogp_title = get_bloginfo('name');
       $ogp_descr = get_bloginfo('description');
       $ogp_url = home_url();
    } elseif( is_singular() ) { //記事＆固定ページ
       setup_postdata($post);
       $ogp_title = $post->post_title;
       $ogp_descr = mb_substr(get_the_excerpt(), 0, 100);
       $ogp_url = get_permalink();
       wp_reset_postdata();
    }

    //og:type
    $ogp_type = ( is_front_page() || is_home() ) ? 'website' : 'article';

    //og:image
    if ( is_singular() && has_post_thumbnail() ) {
       $ps_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
       $ogp_img = $ps_thumb[0];
    } else {
       // アイキャッチ画像が存在しないとき画像（ロゴ）
       $ogp_img = 'https://www.imprich-create.site/wp-content/uploads/2019/03/featured_image2_760x428.png';
    }

    //出力するOGPタグをまとめる
    $insert .= '<meta property="og:title" content="'.esc_attr($ogp_title).'" />' . "\n";
    $insert .= '<meta property="og:description" content="'.esc_attr($ogp_descr).'" />' . "\n";
    $insert .= '<meta property="og:type" content="'.$ogp_type.'" />' . "\n";
    $insert .= '<meta property="og:url" content="'.esc_url($ogp_url).'" />' . "\n";
    $insert .= '<meta property="og:image" content="'.esc_url($ogp_img).'" />' . "\n";
    $insert .= '<meta property="og:site_name" content="'.esc_attr(get_bloginfo('name')).'" />' . "\n";
    $insert .= '<meta name="twitter:card" content="summary" />' . "\n";
    $insert .= '<meta name="twitter:site" content="@imprich_create" />' . "\n";
    $insert .= '<meta property="og:locale" content="ja_JP" />' . "\n";

    //facebookのapp_id（設定する場合）
    $insert .= '<meta property="fb:app_id" content="1871163936336417">' . "\n";
    //app_idを設定しない場合ここまで消す

    echo $insert;
  }
} //END my_meta_ogp
add_action('wp_head','my_meta_ogp');//headにOGPを出力






















////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// サイトマップ用 [sitemap] ショートコード(未完成)
add_shortcode('sitemap', 'sitemap_shortcode');
if ( !function_exists( 'sitemap_shortcode' ) ):
function sitemap_shortcode( $atts, $content = null ) {
	// shortcode_atts
	// ------ユーザーがショートコードに指定した属性を、予め定義した属性と結合し、必要に応じてデフォルト値をセットします。結果は配列で、キーが予め定義された属性、値が指定された属性値を結合したものになります。
	// shortcode_atts( $pairs , $atts, $shortcode );
	// $pairs（配列） （必須） サポートするすべての属性の名前とデフォルト値--初期値： なし
	// $atts（配列） （必須） ユーザーがショートコードタグに指定した属性--初期値： なし
	// $shortcode（文字列） （オプション） shortcode_atts_{$shortcode} フィルターに使われるショートコード名。これを指定すると、他のコードが属性をフィルターするために shortcode_atts_{$shortcode} フィルターを使用できます。このパラメータはオプションですが、互換性を最大にするため常に含めるべきです。--初期値： なし

	// 表示設定の変数を宣言する。
	// $page
	// $single
	// $category
	// $archive
  extract( shortcode_atts( array(
    'page' => 1,
    'single' => 1,
    'category' => 1,
    'archive' => 1,
  ), $atts ) );
	// ob_start:出力のバッファリングを有効にする。
  ob_start();?>
  <div class="sitemap">
    <?php if ($page): ?>
    <h2>固定ページ</h2>
    <ul>
      <?php wp_list_pages('title_li='); ?>
    </ul>
    <?php endif; ?>
    <?php if ($single): ?>
    <h2>記事一覧</h2>
    <ul>
      <?php wp_get_archives( 'type=alpha' ); ?>
    </ul>
    <?php endif; ?>
    <?php if ($category): ?>
    <h2>カテゴリー</h2>
    <ul>
      <?php wp_list_categories('title_li='); ?>
    </ul>
    <?php endif; ?>
    <?php if ($archive): ?>
    <h2>月別アーカイブ</h2>
    <ul>
      <?php wp_get_archives('type=monthly'); ?>
    </ul>
    <?php endif; ?>
  </div>
  <?php
  // wp_get_archives
  // [type]
  // yearly
  // monthly （初期値）
  // daily
  // weekly
  // postbypost （投稿を公開日時の順に）
  // alpha （投稿をタイトルのアルファベット順に）
  // 現在のバッファの内容を取得し、出力バッファを削除する
  return ob_get_clean();
}
endif;
