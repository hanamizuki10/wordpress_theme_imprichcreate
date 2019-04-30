<!--▼フッター : 開始-->

<!-- <?php /*↓↓↓↓↓↓ ここから footer.php ↓↓↓↓↓↓ */?>-->
<!-- <?php /*↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓  */?>-->
<!-- <?php /*↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓  */?>-->
<!-- <?php /*↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓  */?>-->
<!-- <?php /*↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓  */?>-->
<!--▼フッター : 開始-->
<footer class="site-footer">
	<div class="site-info">
		<div class="footer-logo text-center">
            <a href="<?php echo esc_url( home_url( '/' ) ) ?>">
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/img/imprichcreate-logo-footer.svg" alt="<?php bloginfo( 'name' ); ?>">
			</a>
			<p><?php bloginfo('description'); ?></p>
		</div><!--/.footer-logo-->

		<div class="footer-navigation text-center">
			<?php
			/**
			* グローバルナビゲーション
			*/
			wp_nav_menu( array(
				'theme_location' => 'footer',
			) );
			?>

		</div><!--/.footer-navigation-->

		<div class="footer-copyright text-center">
			<p>Copyright &copy; 2015 <?php bloginfo( 'name' ); ?> All Right Reserved.</p>
		</div><!--/.footer-copyright-->

	</div>
</footer>
<!--▲フッター : 終了-->
<?php wp_footer(); ?>
</body>
</html>
