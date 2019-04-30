<?php

get_header(); ?>
<!-- index.php -->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑  */?>-->
<!-- <?php /*↑↑↑↑↑↑ ここまで header.php ↑↑↑↑↑↑ */?>-->


<!--▼メインコンテンツ 開始-->

<main id="primary" class="l-two-column">

<section >
	<div class="dan-panel-inner">
		<header class="entry-header">
			<h2 class="entry-title"><?php the_archive_title(); ?></h2>
		</header><!-- .entry-header -->



        <?php if ( have_posts() ) : //もし、記事が1件以上あったら ?>
			<!-- ▼ブログ記事一覧 : 開始 -->
            <?php while ( have_posts() ) : //記事がある間は繰り返す?>
                <?php the_post(); //次の記事のデータをセットする ?>



				<!--▼記事 : 開始-->
				<article id="post-<?php the_ID();?>" <?php post_class();?>>
					<header class="entry-header">
						<h3 class="entry-post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
						<div class="entry-meta">
							<span class="date"><time class="entry-date"><?php the_time( 'Y年n月j日' );?></time></span>
							<span class="categories-links info"><?php the_category('・');?></span>
						</div>
					</header><!--/.entry-header-->

					<div class="entry-content bloglist">
                        <?php if(has_post_thumbnail()): ?>
						<div class="thumbnail">
                            <?php the_post_thumbnail(); ?>
						</div>
                        <?php endif; ?>
						<div class="entry-summary">
							<?php echo get_the_custom_excerpt( get_the_content(), 150 );?>
						</div>
						<a href="<?php the_permalink(); ?>" class="more-link">続きを読む</a>
					</div><!--/.entry-content-->

					<footer class="entry-footer">
                        <span class="comments-link"><a href="<?php comments_link();?>"><?php comments_number();?></a></span>
                        <?php the_tags('<span class="tag-links">','・','</span>');?>
					</footer><!--/.entry-footer-->

				</article>
				<!--▲記事 : 終了-->




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
// <!-- ▼サイドカラム : 開始-->
// sidebar.php
get_sidebar();
// <!-- ▲サイドカラム : 終了-->
?>

<?php
// footer.php
get_footer();
?>
