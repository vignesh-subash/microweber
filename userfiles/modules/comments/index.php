<?php

if(get_option('enable_comments', 'comments')=='y'){

  $login_required = get_option('user_must_be_logged', 'comments')=='y';


?>
<?
$paging_param = $params['id'].'_page';
 $curent_page_from_url = url_param($paging_param);
if(isset($params['content-id'])){
	 $data['to_table'] = 'table_content';
	 $data['to_table_id'] = $params['content-id'];
}


$data = $params;
if (!isset($params['to_table'])) {

    $data['to_table'] = 'table_content';
}


    $display_comments_from_which_post =  get_option('display_comments_from_which_post', $params['id']); 
if($display_comments_from_which_post == 'current_post' and isset($data['to_table_id'])){
	
unset($data['to_table_id']);

}
if (!isset($data['to_table_id']) or $data['to_table_id'] == false) {

 

    if (defined('POST_ID') == true and intval(POST_ID) != 0) {
       $data['to_table_id'] = POST_ID;
    }
}
if (!isset($data['to_table_id'])) {
    if (defined('PAGE_ID') == true) {
      $data['to_table_id'] = PAGE_ID;
    }
}
if (!isset($data['to_table_id'])) {

 $data['to_table_id'] = $params['id'];
 
}
?>
<? 
 
 $display_comments_from =  get_option('display_comments_from', $params['id']); 
      $enable_comments_paging = get_option('enable_comments_paging',  $params['id'])=='y';  
	  
	  
	  

$hide_comment_form = false;
$comments_data = array();
$comments_data['to_table_id'] = $data['to_table_id'];
$comments_data['to_table'] = $data['to_table'];

if($display_comments_from  != false and $display_comments_from   == 'current' and $display_comments_from_which_post != false and $display_comments_from_which_post != 'current_post'){
	
$comments_data['to_table_id'] = $data['to_table_id'] =  $display_comments_from_which_post;
$comments_data['to_table'] =  $data['to_table'] = 'table_content';
}





 
$form_title = false;
$display_form_title_from_module_id =  get_option('form_title', $params['id']); 
 if($display_form_title_from_module_id != false and trim($display_form_title_from_module_id) != ''){
	$form_title = $display_form_title_from_module_id;	 
  }



if($display_comments_from  != false and $display_comments_from   == 'recent'){
$hide_comment_form = true;
$comments_data = array();
$comments_data['order_by'] = "created_on desc";
 	
}


if($display_comments_from  != false and $display_comments_from   == 'module'){
 
$comments_data['to_table_id'] =   $data['to_table_id'] =  $params['id'];
$comments_data['to_table'] =  $data['to_table'] = 'table_modules';
 $display_comments_from_module_id =  get_option('module_id', $params['id']); 
 if($display_comments_from_module_id != false and trim($display_comments_from_module_id) != ''){
		$comments_data['to_table_id'] =   $data['to_table_id'] =  $display_comments_from_module_id;
		$display_form_title_from_module_id =  get_option('form_title', $display_comments_from_module_id); 
 if($display_form_title_from_module_id != false and trim($display_form_title_from_module_id) != ''){
	$form_title = $display_form_title_from_module_id;	 
  }
  }
 

}
 



 $paging  = false;
if( $enable_comments_paging != false){
	 $comments_per_page = get_option('comments_per_page',  $params['id']);  
	 if(intval( $comments_per_page) != 0) {
		 
 		 $comments_data['limit'] =   $comments_per_page; 
		 
		 $paging_data  = $comments_data;
		 $paging_data['page_count']  = true;
		// d($paging_data);
		 $paging = get_comments( $paging_data);
		// d( $paging);
	 }
	  
}
if( $curent_page_from_url != false){
	if( intval( $curent_page_from_url) > 0){
	$comments_data['curent_page'] = intval( $curent_page_from_url);

	}
}
 
 
 
 $comments = get_comments($comments_data);



 
$template = get_option('data-template', $params['id']);
$template_file = false;
if ($template != false and strtolower($template) != 'none') {
//
    $template_file = module_templates($params['type'], $template);

//d();
} else {
  $template_file = module_templates($params['type'], 'default');	
}
?>
<script type="text/javascript">
    mw.require("url.js", true);
    mw.require("tools.js", true);
    mw.require("forms.js", true);
</script>
<script  type="text/javascript">
    $(document).ready(function(){
        mw.$('form#comments-form-<? print $data['id'] ?>').submit(function() {
            mw.form.post('form#comments-form-<? print $data['id'] ?>', '<? print site_url('api/post_comment'); ?>',
			function(msg) {
				
				var resp = this;
			 
				if(typeof(resp.error) != 'undefined'){
					var err_hold = "error-comments-form-<? print $data['id'] ?>";
					
					if($('#'+err_hold).length == 0){
						$('#comments-form-<? print $data['id'] ?>').append("<div class=\"alert alert-error\" id='"+err_hold+"'></div>");
						
					}
					 
						$('#'+err_hold).html(resp.error);
					 
					
					
				} else {
					mw.reload_module('#<? print $params['id'] ?>');
				}
				
				
				
			});
            return false;
        });
    });
</script>
<?php  switch ($template_file):  case true:  ?>
<? include($template_file); ?>
<?
          if ($template_file != false) {
              break;
          }
        ?>
<?php
    case false:
        ?>
<?php break; ?>
<?php endswitch; ?>
<?php  }   ?>
