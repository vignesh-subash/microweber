<? only_admin_access() ;
 $data = array(
        'content_id' => $params['content_id']
    );

    $comments = get_comments($data);

	$item = get_content_by_id($params['content_id']);

    $content_id =  $params['content_id'];


    $moderation_is_required =  get_option('require_moderation', 'comments')=='y';

?>

<div class="comment-post">
  <div class="comment-info-holder" content-id="<? print $item['id']; ?>" onclick="mw.adminComments.toggleMaster(this, event)"> <span class="img"> <img src="<?php print thumbnail(get_picture($content_id),67,67); ?>" alt="" />
    <?php // $new = get_comments('count=1&is_moderated=n&to_table=table_content&to_table_id='.$content_id);

	 $new = get_comments('count=1&is_new=y&to_table=table_content&to_table_id='.$content_id);
	 ?>
    <?php if($new > 0){ ?>
    <span class="comments_number"><?php print $new; ?></span>
    <?php } ?>
    </span>
    <div class="comment-post-content-side">
      <h3><a href="javascript:;" class="mw-ui-link"><? print $item['title'] ?></a></h3>
      <a class="comment-post-url" href="<? print content_link($item['id']) ?>"> <? print content_link($item['id']) ?></a> <br>
    <!--  <a class="mw-ui-link" href="<? print $item['url'] ?>/editmode:y">Live edit</a>--> </div>
  </div>
  <div class="comments-holder">

  <? include($config["path_to_module"].'admin_items.php'); ?>
  </div>

<? if(!empty($comments)): ?>
  <div class="comments-show-btns"> <span class="mw-ui-btn comments-show-all" onclick="mw.adminComments.display(event,this, 'all');"><?php print ($count_old+$count_new); ?> All</span> <span class="mw-ui-btn mw-ui-btn-green comments-show-new" onclick="mw.adminComments.display(event,this, 'new');"><?php print $count_new; ?> New</span> </div>

<? endif; ?>

</div>
