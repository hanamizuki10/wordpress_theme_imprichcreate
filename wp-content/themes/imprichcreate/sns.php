
<?php
$url_encode=urlencode(get_permalink());
$title_encode=urlencode(get_the_title()).'｜'.get_bloginfo('name');
?>
<div class="share">
<ul>
<!--Facebookボタン-->
<li class="facebook">
  <a href="//www.facebook.com/sharer.php?src=bm&u=<?php echo $url_encode;?>&t=<?php echo $title_encode;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
    <i class="fa fa-facebook"></i><span> facebook</span>
  </a>
</li>
<!--ツイートボタン-->
<li class="tweet">
  <a href="//twitter.com/intent/tweet?url=<?php echo $url_encode ?>&text=<?php echo $title_encode ?>&tw_p=tweetbutton" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
    <i class="fa fa-twitter"></i><span> tweet</span>
  </a>
</li>
</ul>
</div>
