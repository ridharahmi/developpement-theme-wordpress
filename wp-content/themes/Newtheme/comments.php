<?php

   if ( comments_open()  ) {
   	?>

   	 <h5><?php comments_number('0 Comments', '1 Comment', '% Comments'); ?></h5>

   	<?php
   	echo '<ul class="list-unstyled list-comment">';

   	$arg  = array(
   		'max_depth'           => 2, 
   		'type'                => 'comment',
   		'avatar_size'         => 30,
   		'reverse_top_level'   => true,
   		'per_page'            => 5,
   	);
 	 wp_list_comments($arg);

 	 echo '</ul>';
     
     $arr = array(
     	'class_submit'           => 'btn btn-info',
     	'label_submit'           => 'Add Comment',
     	'comment_notes_before'   => '',
     	'title_reply'            => ''
     	
     );
 	 comment_form($arr);
   }
   else
   {
      //echo 'sorry comments disabled';
   }
  
    
