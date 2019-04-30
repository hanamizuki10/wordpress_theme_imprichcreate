<?php

get_header(); ?>
<!-- page.php -->
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
				<!-- ▼ブログ記事 : 開始 -->
				<article <?php post_class();?>>
					<header class="page-header">
						<h1 class="entry-title"><?php the_title();?></h1>
					</header><!--/.entry-header-->
					<div class="entry-meta">
					</div><!--/.entry-meta -->
					<div class="entry-content">
						<!-- ▼アイキャッチ画像 : 開始 -->
						<?php if( has_post_thumbnail() ): ?>
						<div class="thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>
						<!-- ▲アイキャッチ画像 : 終了 -->

						<!-- ▼投稿コンテンツ : 開始 -->
						<?php the_content();?>
						<!-- ▲投稿コンテンツ : 終了 -->
					</div><!--/.entry-content-->
					<footer class="entry-footer">
					</footer>
				</article>
				<!--▲ブログ記事 : 終了-->
			<?php endwhile; //投稿ループ終了 ?>
		<?php endif; //条件分岐終了 ?>


		<!--▼投稿ページ用コンテンツ 終了-->

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
