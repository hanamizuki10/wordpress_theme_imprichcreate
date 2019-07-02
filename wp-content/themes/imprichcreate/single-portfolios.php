<?php

get_header(); ?>
<!-- single-portfolios.php -->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑ ここまで header.php ↑↑↑↑↑↑ */?>-->




<!--▼メインコンテンツ 開始-->
<main id="primary" class="l-two-column">

<section >
	<div >



		<!--▼投稿ページ用コンテンツ 開始-->
		<?php if ( have_posts() ) : //もし、記事が1件以上あったら ?>
			<?php while ( have_posts() ) : //記事がある間は繰り返す?>
				<?php the_post(); //次の記事のデータをセットする ?>











				<!-- ▼ポートフォリオコンテンツ : 開始 -->
				<div class="portfolio-detail">
					<header class="page-header">
						<h1 class="entry-title"><?php the_title();?></h1>
					</header><!--/.entry-header-->
					<div class="entry-meta">
						<span class="date"><time class="entry-date"><?php the_time( 'Y年n月j日' );?></time></span>
						<span class="categories-links info"><?php
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
					</div><!--/.entry-meta -->
					<!-- ▼アイキャッチ画像 : 開始 -->
					<div class="portfolio-thumbnail">
						<?php if( has_post_thumbnail() ): ?>
							<?php the_post_thumbnail('medium'); ?>
						<?php else: // アイキャッチ画像がないとき ?>
							<img src="<?php echo esc_url( get_template_directory_uri()); ?>/img/content/portfolio-noimage.png" alt="" class="img-responsive">
						<?php endif; ?>
					</div>
					<!-- ▲アイキャッチ画像 : 終了 -->
					<div class="entry-content">
						<!-- ▼投稿コンテンツ : 開始 -->
						<?php the_content();?>
						<!-- ▲投稿コンテンツ : 終了 -->
                        <?php if( get_post_meta( $post->ID, 'portfolio_url', true ) ) :?>
                        <h4>URL</h4>
                        <p><a href="<?php echo esc_html( get_post_meta( $post->ID, 'portfolio_url', true ) ); ?>" ref="noopener noreferrer" target="_blank"><?php echo esc_html( get_post_meta( $post->ID, 'portfolio_url', true ) ); ?></a></p>
                        <?php endif;?>

					</div><!--/.entry-content-->
					<footer class="entry-footer">
					</footer>
				</div>
				<!--▲ポートフォリオコンテンツ : 終了-->



			<?php endwhile; //投稿ループ終了 ?>
		<?php endif; //条件分岐終了 ?>
		<!--▼投稿ページ用コンテンツ 終了-->
		<p class="text-left">
			<a href="<?php echo esc_url( home_url( '/portfolios/' ) ); ?>">← ポートフォリオ一覧へ戻る</a>
		</p>
	</div><!-- .dan-panel-inner -->
</section><!-- #post-## -->
</main><!-- #main -->

<?php
// <!-- ▼サイドカラム : 開始-->
// sidebar.php
get_sidebar();
// <!-- ▲サイドカラム : 終了-->
?>

<?php
// footer.php
get_footer();
?>
