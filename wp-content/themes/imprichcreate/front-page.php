<?php

get_header(); ?>
<!-- front-page.php -->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑ ここまで header.php ↑↑↑↑↑↑ */?>-->




<!--▼メインコンテンツ 開始-->
<main id="primary" class="l-one-column">

<section id="post-145" class="dan-panel post-145 page type-page status-publish hentry">
	<div class="dan-panel-inner">
		<!--▼フロントページ用コンテンツ 開始-->
		<?php if ( have_posts() ) : //もし、記事が1件以上あったら ?>
			<?php while ( have_posts() ) : //記事がある間は繰り返す?>
				<?php the_post(); //次の記事のデータをセットする ?>

				<article <?php post_class();?>>
					<div class="entry-content">
						<?php the_content();?>
					</div><!--/.entry-content-->
				</article>

			<?php endwhile; //投稿ループ終了 ?>
		<?php endif; //条件分岐終了 ?>
		<!--▼フロントページ用コンテンツ 終了-->

	</div><!-- .dan-panel-inner -->
</section><!-- #post-## -->





</main><!-- #main -->

<?php
// footer.php
get_footer();
?>
