
<?php
$url_encode=urlencode(get_permalink());
$title_encode=urlencode(get_the_title()).'｜'.get_bloginfo('name');
?>
<div class="share">
<ul>
<!--Facebookボタン-->
<li class="facebook">
  <a href="//www.facebook.com/sharer.php?src=bm&u=<?php echo $url_encode;?>&t=<?php echo $title_encode;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
    <i class="fab fa-facebook"></i><span> facebook</span>
  </a>
</li>
<!--Xポストボタン-->
<li class="x-post">
  <a href="https://x.com/intent/post?url=<?php echo $url_encode ?>&text=<?php echo $title_encode ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
    <?php // 同梱の Font Awesome 5 には X のアイコンが無いため、ロゴを SVG で埋め込む（パスは Simple Icons より、CC0） ?>
    <svg class="icon-x" viewBox="0 0 24 24" aria-hidden="true"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg><span> post</span>
  </a>
</li>
</ul>
</div>
