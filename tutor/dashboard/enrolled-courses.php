<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>

<h3><?php _e('Enrolled Courses', 'tutor'); ?></h3>

<div class="tutor-dashboard-content-inner">
    <div class="tutor-dashboard-inline-links">
        <ul>
            <li class="active"><a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses'); ?>"> <?php _e('All Courses', 'tutor'); ?></a> </li>
            <li><a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses/active-courses'); ?>"> <?php _e('Active Courses', 'tutor'); ?> </a> </li>
            <li><a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses/completed-courses'); ?>">
					<?php _e('Completed Courses', 'tutor'); ?> </a> </li>
        </ul>
    </div>
	<?php
	$alert_message = "";
	$my_courses = tutor_utils()->get_enrolled_courses_by_user();

	if ($my_courses && $my_courses->have_posts()):
		while ($my_courses->have_posts()):
			$my_courses->the_post();
			$avg_rating = tutor_utils()->get_course_rating()->rating_avg;
			$tutor_course_img = get_tutor_course_thumbnail_src();
			$author_id = get_post_field ('post_author', get_the_ID());
			if(get_post_meta(get_the_ID(),"alertmessage",true) != ""){
				$alert_message .= "<p><strong  class='required'>Alert Message for ".get_the_title().": </strong>".get_post_meta(get_the_ID(),"alertmessage",true)."</p>";
			}
			?>
			<?php
			$tutor_course_img = get_tutor_course_thumbnail_src();
			$liveclass = get_post_meta(get_the_ID(),'_insert_meeting_zoom_meeting_id',true);
				$i = 1;
				$class = "";
				global $wpdb;
				if($liveclass != ""){
				
					foreach($liveclass as $results){
						if($i == 1){
							$post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $results ."')");
							$start_date = get_post_meta($post_id,'_meeting_date',true);
							$start_url = get_post_meta($post_id,'_meeting_zoom_start_url',true);
							$class_date = date('Y-m-d',strtotime($start_date));
							$class_datee = date('d-M-Y h:i a',strtotime($start_date));
							$blogtime = date("Y-m-d"); 

							if($class_date == $blogtime){
								//echo do_shortcode('[zoom_api_link meeting_id="'.$results.'" link_only="no"]');
							}
							if($class_date >= $blogtime){
								$class .= '<div class="elementor-widget-container">
										<h6 class="elementor-heading-title elementor-size-default">Next Live Class starts: '.$class_datee.' (Eastern Daylight Time)</h6>	
									</div>';
								$i++;
							}
						
						}
					}
				}
				else{
					$class .= '<div class="elementor-widget-container">
									<h6 class="elementor-heading-title elementor-size-default">No Live Class Scheduled for this course! </h6>	
						</div>';
					
				} 
			?>
            <div class="tutor-mycourse-wrap tutor-mycourse-<?php the_ID(); ?>">
                <div class="tutor-mycourse-thumbnail" style="background-image: url(<?php echo esc_url($tutor_course_img); ?>)"></div>
                <div class="tutor-mycourse-content">
                    <div class="tutor-mycourse-rating">
		                <?php tutor_utils()->star_rating_generator($avg_rating); ?>
                        <a href="<?php echo get_the_permalink().'#single-course-ratings'; ?>"><?php _e('Leave a rating', 'tutor') ?></a>
						<?php do_action('tutor_enrolled_box_after') ?>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3>
					<p><?php echo $class; ?></p>
                    <div class="tutor-meta tutor-course-metadata">
		                <?php
                            $total_lessons = tutor_utils()->get_lesson_count_by_course();
                            $completed_lessons = tutor_utils()->get_completed_lesson_count_by_course();
		                ?>
                        <ul>
                            <li>
				                <?php
				                _e('Total Lessons:', 'tutor');
				                echo "<span>$total_lessons</span>";
				                ?>
                            </li>
                            <li>
				                <?php
				                _e('Completed Lessons:', 'tutor');
				                echo "<span>$completed_lessons / $total_lessons</span>";
				                ?>
                            </li>
							<li>
				                <a href="/my-account/my-assignments/?assignments=<?php echo $author_id; ?>&prod_id=<?php echo get_the_ID(); ?>">Submit Assignments</a>
                            </li>
							<li class="deletepopup">
							<?php 
							$check = get_user_meta(get_current_user_id(),"learner_cancel_request_".get_the_ID(),true); 
							$check1 = get_user_meta(get_current_user_id(),"refund_approved_".get_the_ID(),true);
							 $refund = get_post_meta(get_the_ID(),"refund",true);
							$refundtext = "";
							if($refund != ""){
								if($refund == "class pack 14"){
									
									$refundtext = "Class Pack (14 and fewer classes) – 7 days prior to the start of a live class. There are no refunds if you withdraw from a class less than 7 days prior to the start of the class, or if you fail to attend. A processing fee of 20% will be retained on all cancelled classes unless extenuating circumstances arise and a request is made.";
								}
								if($refund == "class pack 15"){
									
									$refundtext = "Semester/Year (15 or more classes) – 30 days prior to the start of a live class. There are no refunds if you withdraw from a class less than 30 days prior to the start of the class, or if you fail to attend. A processing fee of 20% will be retained on all cancelled classes unless extenuating circumstances arise and a request is made.";
								}
							}
							?>
							<div class='delete-request'>
								<div class='delete-request-inner'>
									<div class="popclose"><i class="eicon-close"></i></div>
									<div class="popimage"><img width="274" height="70" src="https://myhomeschoolfamily.com/wp-content/uploads/2020/05/Logo-MyHomeSchoolFamily.png" class="attachment-large size-large" alt="MyHomeSchoolFamily" loading="lazy"></div>
									<h3 class="elementor-heading-title elementor-size-default">Class Cancellation</h3>
									<h5>If you would like to cancel and be removed from a specific class, please read and fill out the required areas.</h5>
									
									<p class='required'><?php echo $refundtext; ?></h6>
									<form class='cancelform' id='deleteform' method='post'>
									
										<div class='tutor-form-group'>
											<label class='tutor-builder-item-heading'>Does your cancellation request fall within the guidelines stated above?</label>
											<input checked type='radio' name='cancelrequest' value='yes'> Yes
											<input  type='radio' name='cancelrequest' value='no'> No
										</div>
										<div class='tutor-form-group tutor-form-group-textarea' style="display:none;">
											<label class='tutor-builder-item-heading'>If you are canceling outside of the refund policy and are requesting a refund due to extenuating circumstances, please give a brief description in the box below.  The educator will review your request and make their decision accordingly.</label>
											<textarea  rows="5" name='description'></textarea>
											
										</div>
										<input type='hidden' name='cid' value='<?php echo get_the_ID(); ?>'>
										<button type='submit' class='tutor-danger tutorcancel'>Yes, request for cancel Class</button><span class="loader" style="display:none;color:red;">Please wait your request is in progress!</span>
										
										<h6 class='successmsg' style='display:none;color:green;'>Thank you for your request.  Upon submitting of this form, please allow 24-48 hours for the educator to remove you from this class. If there are any questions or concerns, your educator will be in touch.</h6>  
									</form>
								</div>
							</div>
								<a class="<?php if($check == ''){echo 'cancel';}?>" href="javascript:void(0);"><?php if($check != ""&& $check1 == ""){echo 'Cancel Request Sent';}elseif($check != "" && $check1 != ''){echo "Cancelled";}else{echo 'Cancel class';}?></a>
                            </li>
                        </ul> 
                    </div>
	                <?php tutor_course_completing_progress_bar(); ?>
                </div>

            </div>

			<?php
		endwhile;

		wp_reset_postdata();
    else:
        echo "<div class='tutor-mycourse-wrap'><div class='tutor-mycourse-content'>".__('No Records Found!', 'tutor')."</div></div>";
	endif;
if($alert_message != ""){
				echo "<div class='alertt'>".$alert_message."</div>";
			}
	?>

</div>
<script>
jQuery(document).ready(function(){
	jQuery(document).on("click",".cancel",function(){
			
			jQuery(this).closest('li').children('.delete-request').show();

			
	})
	jQuery(document).on("click",".popclose",function(){		
			jQuery(this).closest('li').children('.delete-request').hide();
			jQuery(".successmsg").hide();

	})
	jQuery(document).on("click",".cancelform input:radio",function() {
		if (jQuery(this).val() === 'yes') {
		jQuery(this).closest('.cancelform').find('.tutor-form-group-textarea').hide();
    } else if (jQuery(this).val() === 'no') {
      jQuery(this).closest('.cancelform').find('.tutor-form-group-textarea').show();
    } 
		
	});
	jQuery(document).on("click",".tutorcancel",function(e){
			e.preventDefault();
			var a = jQuery(this);
			var radiocheck = jQuery(this).parent('.cancelform').find("input[name='cancelrequest']:checked").val();
			var textareacheck = jQuery(this).parent('.cancelform').find("textarea").val();
			var success = "suceess";
			 var $btn = jQuery('.tutorcancel');
			if(radiocheck == "no" && textareacheck == ""){
				
				success = "";
			}
			if(success == "suceess"){
		    var data = jQuery(this).parent('.cancelform').serialize();
				jQuery.ajax({
					url: '/cancel_class.php/',
					type: 'POST',
					data: data,
					beforeSend: function() {
						jQuery(".loader").show();
						$btn.addClass('updating-icon');
					},
					success: function(response) {
						if(response == "success"){
							a.html("Cancel Request Sent").removeClass("cancel");
							jQuery(".loader").hide();
							jQuery(".successmsg").show();
							$btn.removeClass('updating-icon');
							window.location.reload(true);
						}
					}
				});
			}
			else{
				var textareacheck = jQuery(this).parent('.cancelform').find(".tutor-form-group-textarea label").append("<div class='required'>This field is required!</div>");
			}
			
    });
		
})
jQuery(".alertt p").each(function(){
	
	if(jQuery(this).text() != ""){
		console.log(jQuery(this).text());
		jQuery(this).appendTo(".tutor-dashboard-student .tutor-row:first-child .tutor-col-12");
	}
})
</script>
