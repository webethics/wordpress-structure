<?php
/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	get_template_part( 'template-parts/footer' );
}
?>
<?php 
if ( is_user_logged_in() ) {
		$user = wp_get_current_user();
		$user_name = $user->user_firstname;
		$user_name = ucfirst($user_name);
		$user_name = "Hi ". ucfirst($user_name);
		
?>
<style>
.hidelogin{display:none;}
.elementor_library .hidelogin{display:block;}

</style>
<script>
	jQuery(".myaccount > a").text("<?php echo $user_name; ?>").prepend("&nbsp;");
</script>
<?php

	if ( in_array( 'tutor_instructor', (array) $user->roles ) && in_array( 'customer', (array) $user->roles )) {
		
?>
	<style>
		.elementor-nav-menu .changelink{display:block;}
	</style>
<?php		
	}		
}

?>
								
<script>								
jQuery(document).ready( function($){
	var mediaUploader,mediaUploader1, mediaUploader2 ,buttonIDs;
	var counter=0;
	var counter1=0;
	var img_array = [];	
	var files_array = [];
		
	var imglist = $('#ns-image-from-list').val();
	if(imglist){
	var string = imglist.split(",");
	if(string.length > 0){
		var counter=string.length;
	}
	for (var i = 0; i < string.length; i++) {
		img_array.push(string[i]);
	}
	}
		$('.upload-files').on('click',function(e) {
			e.preventDefault();
			buttonID = $(this).data('group');
			console.log(buttonID);
			if( mediaUploader2 ){
				mediaUploader2.open();
				return;
			}

		   mediaUploader2 = wp.media.frames.file_frame =wp.media({
			title: 'Select Files',
			button: {
				text: 'Select File'
			},
			multiple:true,
		  });


		  mediaUploader2.on('select', function(){
			var selection = mediaUploader2.state().get('selection'); 
				  selection.map( function( attachment ) {
						counter1++;
						attachment = attachment.toJSON();
						files_array.push(attachment.id);
						
						$('#ns-file-from-list').val(files_array.toString());
						$('.ns-file-container').append('<div class="img-container-block" id="file'+attachment.id+'"><div id='+attachment.id+'>'+'<a href='+attachment.url+'><img src="/wp-content/themes/hello-theme-yoyovisio/images/file-icon.png" width="100" /></a><span style="color:red;font-size:20px;font-weight:bold;vertical-align:top;cursor:pointer;" class="remove-file" id='+attachment.id+' >x</span></div></div>');
						if(counter1 > 0){
							$('.uploadfilebtn').show();
							$('.msg-field1').html(counter1+' file(s) uploaded successfully');
						}else{
							$('.uploadfilebtn').hide();
							$('.msg-field1').html('');
						}
					});		
		  });

		mediaUploader2.open();
		
		}); 
		$('.upload-button').on('click',function(e) {
			e.preventDefault();
			buttonID = $(this).data('group');
			console.log(buttonID);
			if( mediaUploader ){
				mediaUploader.open();
				return;
			}

		   mediaUploader = wp.media.frames.file_frame =wp.media({
			title: 'Choose a Picture',
			button: {
				text: 'Choose Picture'
			},
			multiple:true,
			 library: {
			  type: 'image'
			},
		  });


		  mediaUploader.on('select', function(){
			var selection = mediaUploader.state().get('selection'); 
				  selection.map( function( attachment ) {
						counter++;
						attachment = attachment.toJSON();
						img_array.push(attachment.id);
						$('#ns-image-from-list').val(img_array.toString());
						$('.current-gallery').hide();
             			//jQuery('#ns-image-from-list').val( jQuery(this).attr("src") );
             			$(this).css('border','5px solid #bdcfed');
						$('.ns-image-containers').append('<div class="img-container-block" id="img'+attachment.id+'"><img id='+attachment.id+' style="height:150px;padding:10px;border:1px solid #dedede;width:auto;" src=' +attachment.url+'><span style="color:red;font-size:20px;font-weight:bold;vertical-align:top;cursor:pointer;" class="remove-item" id='+attachment.id+' >x</span></div>');
						
						if(counter > 0){
							$('.uploadbtn').show();
							$('.msg-field').html(counter+' images uploaded successfully');
						}else{
							$('.uploadbtn').hide();
							$('.msg-field').html('');
						}
						
					});		
		  });

		mediaUploader.open();
		
		}); 
		
		$('.upload-thumbnail').on('click',function(e) {
			e.preventDefault();
			buttonID = $(this).data('group');
			console.log(buttonID);
			if( mediaUploader1 ){
				mediaUploader1.open();
				return;
			}

		   mediaUploader1 = wp.media.frames.file_frame =wp.media({
			title: 'Choose a Picture',
			button: {
				text: 'Choose Picture'
			},
			multiple:false,
			 library: {
			  type: 'image'
			},
		  });


		  mediaUploader1.on('select', function(){
			var selection = mediaUploader1.state().get('selection'); 
				  selection.map( function( attachment ) {
						attachment = attachment.toJSON();
						$('#ns-image-thumbnail').val(attachment.id);
						$('.ns-image-containers1').html('<img id='+attachment.id+' style="height:150px;padding:10px;border:1px solid #dedede;width:auto;" src=' +attachment.url+'>');
					});		
		  });

		mediaUploader1.open();
		
		}); 
		 $(document).on("click",".remove-item",function() {
				counter--;
             		//Image clicked for the first time
             	/* 	if(img_array.indexOf(jQuery(this).attr("id")) < 0){
             			img_array.push(jQuery(this).attr("id"));
             			//setting the value of the input with the urls of images separated by comma
             			$('#ns-image-from-list').val(img_array.toString());
             			//jQuery('#ns-image-from-list').val( jQuery(this).attr("src") );
             			$(this).css('border','5px solid #bdcfed');
             		}
             		else{ */
             			//Image already being clicked. Removing border and delete element from img_array
             		
             			var elementToRemove = jQuery(this).attr("id");
							//$('#img'+elementToRemove).css('display', 'none');
							$('#img'+elementToRemove).remove();
             			img_array = jQuery.grep(img_array, function(value) {
             			  return value != elementToRemove;
             			});
             			$('#ns-image-from-list').val(img_array.toString());
						if(counter > 0){
							$('.uploadbtn').show();
							$('.msg-field').html(counter+' images uploaded successfully');
						}else{
							$('.uploadbtn').hide();
							$('.msg-field').html('');
						}
             		//}

             	});
				
				$(document).on("click",".remove-file",function() {
					counter1--;
					var elementToRemove = jQuery(this).attr("id");
						$('#file'+elementToRemove).css('display', 'none');
					files_array = jQuery.grep(files_array, function(value) {
					  return value != elementToRemove;
					});
					$('#ns-file-from-list').val(files_array.toString());
					if(counter1 > 0){
						$('.uploadfilebtn').show();
						$('.msg-field1').html(counter1+' file(s) uploaded successfully');
					}else{
						$('.uploadfilebtn').hide();
						$('.msg-field1').html('');
					}
				//}

             	});
				
				
});
</script>
<?php 
$course_id = tutor_utils()->get_assigned_courses_ids_by_instructors();
$quiz_attempts_count = tutor_utils()->get_total_quiz_attempts_by_course_ids($course_id); 
$total_items = tutils()->get_total_qa_question();
global $wpdb, $current_user;
$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}usermeta WHERE meta_key LIKE 'learner_cancel_request_id_%'  AND user_id=".get_current_user_id());
$j = 0;
foreach($results as $result){
			$stu_id = $result->meta_value;
			$stu_key = $result->meta_key;
			$res = explode("_",$stu_key);
			$cancel_meta = end($res);
			$user_info = get_userdata($stu_id);
			$approve_status = get_usermeta($stu_id,"refund_approved_".$cancel_meta,true);
			if($approve_status){
			}
			else{
				$j = $j+1;
			}
}
$countres = count($results);

$user_comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE user_id =".get_current_user_id()." AND comment_type='tutor_q_and_a'");
foreach($user_comments as $comment){  
			$answer = $wpdb->get_var("SELECT comment_content FROM $wpdb->comments WHERE comment_parent =$comment->comment_ID AND comment_type='tutor_q_and_a'");
			$count_answer = $count_answer + count($answer);
}
$results_assignment = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_type='assignments' AND comment_parent=".$current_user->ID);
$results_assignment = count($results_assignment);
?>
<script>
jQuery(".tutor-dashboard-menu-quiz-attempts a").append("(<?php echo $quiz_attempts_count; ?>)");
jQuery(".tutor-dashboard-menu-question-answer a").append("(<?php echo $total_items; ?>)");
jQuery(".tutor-dashboard-menu-cancel_students a").append("(<?php echo $j; ?>)");
jQuery(".tutor-dashboard-menu-my-questions a").append("(<?php echo $count_answer; ?>)");
jQuery(".tutor-dashboard-menu-submit-assignment a").append("(<?php echo $results_assignment; ?>)");
jQuery(document).ready(function(){
	jQuery('#refer_name_field,#additional_class_name_field').hide();
	jQuery('#refer_name_field .optional,#additional_class_name_field .optional').hide();
	jQuery('#additional_check_field input').on('click',function() {
		console.log(jQuery(this).val());
         if (jQuery(this).val() == 'yes') {
            jQuery('#refer_name_field,#additional_class_name_field').show();
            
         } else {
			 jQuery('#refer_name_field,#additional_class_name_field').hide();
			 
         }
      });
	
})
jQuery('#ns-regular-price').keypress(function(event) {
    if (event.which != 46 && (event.which < 47 || event.which > 59))
    {
        event.preventDefault();
        if ((event.which == 46) && ($(this).indexOf('.') != -1)) {
            event.preventDefault();
        }
    }
});
</script>
<style>
#additional_check_field label{
    display: inherit;
    padding-left: 10px;
	vertical-align: top;
}
</style>
<?php wp_footer(); ?>

</body>
</html>
