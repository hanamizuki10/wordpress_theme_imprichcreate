<div class="comments-area">
    <h3 id="comments">この記事へのコメント</h3>
    <?php if( have_comments() ) : // もし、コメントが1件以上あったら ?>
    <ol class="commentlist">
        <?php wp_list_comments();?>
    </ol>
    <?php else : // もし、表示すべきコメントが無かったら ?>
        <p>コメントはまだありません。</p>
    <?php endif;  // 条件分岐終了 ?>

    <?php if( comments_open() ) :   // もし、コメントが許可されていたら ?>
        <?php comment_form();?>
    <?php else : // もし、コメントが許可されて無かったら ?>
        <p>現在、コメントは受け付けていません。</p>
    <?php endif;  // 条件分岐終了 ?>

</div>
