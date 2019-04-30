<?php

get_header(); ?>
<!-- archive-portfolios.php -->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑ ここまで header.php ↑↑↑↑↑↑ */?>-->


<!--▼メインコンテンツ 開始-->

<main id="primary" class="l-one-column">

<section class="portfolio-page">
	<header class="entry-header">
		<h2 class="entry-title"><?php the_archive_title(); ?></h2>
	</header><!-- .entry-header -->




	<nav class="portfolio-navs">
		<ul>
			<li><a href="<?php echo esc_url( home_url( '/portfolios/' ) );?>">ALL</a></li>
			<?php
				// メニューカテゴリーのリストを出力
				$args = array(
					'taxonomy' => 'portfoliocat', //menucatタクソノミーを指定
					'title_li' => '', //リストの見出しは出力しない
				);
				wp_list_categories( $args );
			?>
		</ul>
	</nav><!--/.portfolio-navs-->

	<div class="portfolio-blocks">

        <?php if ( have_posts() ) : //もし、記事が1件以上あったら ?>
			<!-- ▼ブログ記事一覧 : 開始 -->
            <?php while ( have_posts() ) : //記事がある間は繰り返す?>
                <?php the_post(); //次の記事のデータをセットする ?>

				<!--▼ポートフォリオ : 開始-->
				<div class="portfolio-block">


					<header class="portfolio-header">
						<div class="portfolio-meta">
							<span class="categories-links info">
							<?php
							$terms = get_the_terms($post->ID,'portfoliocat');
							if($terms){
								$categoryhtml = "";
								foreach( $terms as $term ) {
									if( $categoryhtml !== ""){
										$categoryhtml = $categoryhtml  . '・';
									}
									$categoryhtml = $categoryhtml  . '<a href="'.esc_url( home_url( '/portfoliocat/'.$term->slug ) ) . '" rel="home">'. $term->name . '</a>';
								}
								echo $categoryhtml;
							}?></span>
						</div>
					</header><!--/.entry-header-->



					<!--▼ ポートフォリオ用 画像を表示 : 開始 -->
					<div class="portfolio-thumbnail">
						<?php if( has_post_thumbnail() ): ?>
							<?php if( get_post_meta( $post->ID, 'portfolio_url', true ) ) :?>
							<a href="<?php echo esc_url( get_post_meta( $post->ID, 'portfolio_url', true ) ); ?>" target="_blank">
							<?php the_post_thumbnail(); ?>
							</a>
							<?php endif;?>
						<?php else: // アイキャッチ画像がないとき ?>
							<?php if( get_post_meta( $post->ID, 'portfolio_url', true ) ) :?>
							<a href="<?php echo esc_url( get_post_meta( $post->ID, 'portfolio_url', true ) ); ?>" target="_blank">
							<img src="<?php echo esc_url( get_template_directory_uri()); ?>/img/content/portfolio-noimage.png" alt="" class="img-responsive">
							</a>
							<?php endif;?>
						<?php endif; ?>
					</div>
					<!--▲ ポートフォリオ用 画像を表示 : 終了 -->


					<header class="portfolio-header">
						<h3 class="portfolio-title"><?php the_title();?></h3>
					</header><!--/.entry-header-->


					<div class="portfolio-desc">
						<?php if( get_post_meta( $post->ID, 'portfolio_description', true ) ) :?>
						<p><?php echo esc_html( get_post_meta( $post->ID, 'portfolio_description', true ) ); ?></p>
						<?php endif;?>
					</div>
					<a href="<?php the_permalink(); ?>" class="portfolio-more">詳細を見る</a>
				</div>
				<!--▲ポートフォリオ : 終了-->


			<?php endwhile; //投稿ループ終了 ?>

		<!--▼ ページネーション : 開始-->
        <?php the_posts_pagination(); ?>
		<!--▲ ページネーション : 終了-->

        <?php else: //もし、表示すべき記事がなかったら ?>
            <p>まだ記事はありません。</p>
        <?php endif; //条件分岐終了 ?>
		<!-- ▲ブログ記事一覧 : 終了 -->



	</div><!-- .dan-panel-inner -->
</section><!-- #post-## -->

</main><!-- #main -->




<?php
// footer.php
get_footer();
?>
