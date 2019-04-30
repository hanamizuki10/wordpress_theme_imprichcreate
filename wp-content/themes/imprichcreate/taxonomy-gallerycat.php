<?php

get_header(); ?>
<!-- taxonomy-gallerycat.php -->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑ ここまで header.php ↑↑↑↑↑↑ */?>-->


<!--▼メインコンテンツ 開始-->

<main id="primary" class="l-two-column">

<section class="gallery-page">
	<header class="entry-header">
		<h2 class="entry-title"><?php the_archive_title(); ?></h2>
	</header><!-- .entry-header -->




	<div class="gallery-blocks">

        <?php if ( have_posts() ) : //もし、記事が1件以上あったら ?>
			<!-- ▼ブログ記事一覧 : 開始 -->
            <?php while ( have_posts() ) : //記事がある間は繰り返す?>
                <?php the_post(); //次の記事のデータをセットする
					$thumbnail_id = get_post_thumbnail_id();
					//$eye_img=wp_get_attachment_image_src($thumbnail_id,'thumbnail');
					$eye_img = wp_get_attachment_image_src($thumbnail_id,'medium');
					//$eye_img=wp_get_attachment_image_src($thumbnail_id,'large');
					//$eye_img=wp_get_attachment_image_src($thumbnail_id,'full');
					//[0]が画像のURLで、[1]と[2]が、画像の縦横サイズ

				?>

				<!--▼ギャラリー : 開始-->
				<div class="gallery-block">

					<header class="gallery-header">
						<div class="gallery-meta">
							<span class="date"><time class="entry-date"><?php the_time( 'Y年n月j日' );?></time></span>
							<span class="categories-links info">
							<?php
							$terms = get_the_terms($post->ID,'gallerycat');
							if($terms){
								$categoryhtml = "";
								foreach( $terms as $term ) {
									if( $categoryhtml !== ""){
										$categoryhtml = $categoryhtml  . '・';
									}
									$categoryhtml = $categoryhtml  . '<a href="'.esc_url( home_url( '/gallerycat/'.$term->slug ) ) . '" rel="home">'. $term->name . '</a>';
								}
								echo $categoryhtml;
							}?></span>
						</div>
					</header><!--/.entry-header-->

					<!--▼ ポートフォリオ用 画像(アイキャッチ画像)を表示 : 開始 -->
					<?php if( has_post_thumbnail() ): ?>
					<div class="gallery-thumbnail">
						<a href="<?php echo $eye_img[0];?>" data-lightbox="group" data-title="<?php the_title();?>">
						<?php the_post_thumbnail(); ?>
						</a>
					</div>
					<?php endif; ?>
					<!--▲ ポートフォリオ用 画像(アイキャッチ画像)を表示 : 終了 -->

					<header class="gallery-header">
						<h3 class="gallery-title"><?php the_title();?></h3>
					</header><!--/.entry-header-->
				</div>
				<!--▲ギャラリー : 終了-->


			<?php endwhile; //投稿ループ終了 ?>

		<!--▼ ページネーション : 開始-->
        <?php the_posts_pagination(); ?>
		<!--▲ ページネーション : 終了-->

        <?php else: //もし、表示すべき記事がなかったら ?>
            <p>まだ画像はありません。</p>
        <?php endif; //条件分岐終了 ?>
		<!-- ▲ブログ記事一覧 : 終了 -->



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
