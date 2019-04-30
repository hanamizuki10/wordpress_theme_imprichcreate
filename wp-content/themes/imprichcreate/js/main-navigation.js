(function($) {
$(function() {
	/* ボタンクリック*/
	$('button.menu-toggle').click(function(e) {
		$('nav#site-navigation').toggleClass('toggled-on');
		if ( $('nav#site-navigation').hasClass('toggled-on') ){
			//　	<button class="menu-toggle"><span class="fas fa-bars" aria-hidden="true"></span>Menu</button>
			//$('button.menu-toggle>span').attr('aria-hidden' , true);
			$('button.menu-toggle').attr('aria-expanded' , true);
		} else {
			//$('button.menu-toggle>span').attr('aria-hidden' , false);
			$('button.menu-toggle').attr('aria-expanded' , false);
		}

	});
});
})(jQuery);