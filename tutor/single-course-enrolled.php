<?
/**
 * Template for displaying single course
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

get_header();

?>

<? do_action('tutor_course/single/enrolled/before/wrap');
	global $post, $wpdb;

	$course_tag = wp_get_post_terms( get_the_ID(), 'course-tag' , array( 'fields' => 'all' ) );
	$course_tag =  wp_list_sort( $course_tag, 'slug', 'ASC' );
	$grade = "";
	$gradee = "";
	$grade1 = "";
	$grade2 = "";
	if(is_array($course_tag) && count($course_tag)){

			foreach ($course_tag as $course_category){
				$category_name = $course_category->name;
				$category_link = get_term_link($course_category->term_id);
				if($category_name == "K")
				{
					$grade1 = $category_name.",";
				}
				elseif($category_name == "Pre-K")
				{
					$grade2 = " ".$category_name.",";
				} 
				else{
					$gradee .= " ".$category_name.",";
				}
			}
	$grade = $grade1.$grade2.$gradee;
	$grade = rtrim($grade,",");
	}
	$course_categories = get_tutor_course_categories();
	$category = "";
	if(is_array($course_categories) && count($course_categories)){

			foreach ($course_categories as $course_category){
				$category_name = $course_category->name;
				$category_link = get_term_link($course_category->term_id);
				$category .= " ".$category_name.",";
			}
	$category = rtrim($category,",");
	}
	$course_type = wp_get_post_terms( get_the_ID(), 'coursetype' , array( 'fields' => 'all' ) );
	$type = "";
	if(is_array($course_type) && count(course_type)){

			foreach ($course_type as $course_category){
				$category_name = $course_category->name;
				$category_link = get_term_link($course_category->term_id);
				$type .= " ".$category_name.",";
			}
	$type = rtrim($type,",");
	}
	$is_purchasable = tutor_utils()->is_course_purchasable();
	$price = apply_filters('get_tutor_course_price', null, get_the_ID());
	if ($is_purchasable && $price){
		$finalprice = $price;
	}else{
		$finalprice = "Free";
	}
	$topics = tutor_utils()->get_topics();
	$course_id = get_the_ID();
	$tutor_lesson_count = tutor_utils()->get_lesson_count_by_course($course_id);
	$tutor_course_duration = get_tutor_course_duration_context($course_id);
	
	
	$durationn = maybe_unserialize(get_post_meta(get_the_ID(), '_course_duration', true));
	$durationHours = tutor_utils()->avalue_dot('hours', $durationn);
	$durationMinutes = tutor_utils()->avalue_dot('minutes', $durationn);

	$duration = $durationHours."h";
	if($durationMinutes != ""){
		$duration = $duration." ".$durationMinutes."m";
	}
	
	$liveclass = get_post_meta(get_the_ID(),'_insert_meeting_zoom_meeting_id',true);
		$class = "";	
		$class1 = "";	
		if($liveclass != ""){
			$i = 1;
			$class1 .= '<table class="tutor-dashboard-info-table">
								<thead>
								<tr>
									
									<td><h5>Class Date</h5></td>
									<td><h5>Class Timezone</h5></td>
									<td><h5>Class Duration</h5></td>
									<td><h5>Class Join Link</h5></td>
									<td><h5>Class Recordings</h5></td>
								</tr>
								</thead>
								<tbody>';
			foreach($liveclass as $results){
				$post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $results ."')");
				$meeting_id = $results;
				$meeting_info = json_decode( zoom_conference()->getMeetingInfocall( $meeting_id, $host_id) );

				$links_recording = $meeting_info->recording_files;
				$start_date = get_post_meta($post_id,'_meeting_date',true);

				$class_date = date('Y-m-d',strtotime($start_date));
				$class_datee = date('d-M-Y h:i a',strtotime($start_date));
			
				$blogtime = date("Y-m-d"); 
				$class_details = get_post_meta($post_id,'_meeting_zoom_details',true);
				
				if($i == 1){
					if($class_date >= $blogtime){
						
						$class .= '<div class="elementor-widget-container">
								<h4 class="elementor-heading-title elementor-size-default">Next Live Class starts: '.$class_datee.' (Eastern Daylight Time)</h4>	
							</div>';
						$i++;
					}
			
				}
				
				$link = "";
				$cssclass="";
				if($class_date){
				if($class_date == $blogtime){
					$link = $class_details->join_url;
					$cssclass="";
				}
				elseif($class_date > $blogtime || $class_date < $blogtime){
					
					$link = $class_details->join_url;
					$cssclass="isDisabled";
				}
					$class1 .='
										<tr>
											
											<td>'.$class_datee.'</td>
											<td>'.$class_details->timezone.'</td>
											<td>'.$duration.'</td>
											<td><a class="tutor-btn '.$cssclass.'" target="_blank" href="'.$link.'">Join Class</td><td>';
											if($meeting_info->code == 3301){
													$class1 .= "There is no recording for this meeting";
												}
												else{
													
														$class1 .= '<a class="tutor-btn" target="_blank" href="'.$links_recording[0]->play_url.'">View</a>';
													
												}
											
										$class1 .= '</td></tr>';
							
				}
			}
			$class1 .= 	'</tbody>
							</table>';
		}
		else{
			$class .= '<div class="elementor-widget-container">
							<h4 class="elementor-heading-title elementor-size-default">No Live Class Scheduled for this course! </h4>	
				</div>';
			
		}
	$product_id = tutor_utils()->get_course_product_id();
	
	$attachments = tutor_utils()->get_attachments();
	
	
	$fname = get_the_author_meta('first_name');
	$lname = get_the_author_meta('last_name');
	$full_name = '';

	if( empty($fname)){
		$full_name = $lname;
	} elseif( empty( $lname )){
		$full_name = $fname;
	} else {
		//both first name and last name are present
		$full_name = "{$fname} {$lname}";
	}
$bibical = get_post_meta(get_the_ID(),"_bibical_data",true);
if($bibical == "bibical"){
	$bibical = "This Class is specifically taught with a biblical worldview."; 
}
$refund = get_post_meta(get_the_ID(),"refund",true);
if($refund != ""){
	if($refund == "class pack 14"){
		$refundtext = "Class Pack (14 and fewer classes) – 7 days prior to the start of a live class. There are no refunds if you withdraw from a class less than 7 days prior to the start of the class, or if you fail to attend. A processing fee of 20% will be retained on all cancelled classes unless extenuating circumstances arise and a request is made.";
	}
	if($refund == "class pack 15"){
		$refundtext = "Semester/Year (15 or more classes) – 30 days prior to the start of a live class. There are no refunds if you withdraw from a class less than 30 days prior to the start of the class, or if you fail to attend. A processing fee of 20% will be retained on all cancelled classes unless extenuating circumstances arise and a request is made.";
	}
}
?>

<? if(get_post_meta(get_the_ID(),'relationclass',true) != "child"){ ?>
<div <? tutor_post_class('tutor-full-width-course-top tutor-course-top-info tutor-page-wrap'); ?>>
    <div class="wrapper-main">
		
        <section  class="section-wrap pd-details-wrap">
            <div class="container-wrap">
               <div class="row-wrap">
                  <div class="pd-img-wrap">
					<?
						if(tutor_utils()->has_video_in_single()){
							tutor_course_video();
						} else{
							get_tutor_course_thumbnail();
						}
					?>
                  </div>
				  <div class="pd-details-wrap">
					<h4 class="pd-heading-title"><? the_title(); ?></h4>
					<strong><? echo $bibical; ?></strong>
					<p><? the_excerpt(); ?></p>
					<? if(trim($type) != "On Demand Classes"){ ?><p><? echo $class ; ?></p><? } ?>
					<p>Grade: <? echo $grade; ?></p>  
					<p class="grade-wrap">Instructor Name: <? echo $full_name; ?>	</p>
				   <p class="category-wrap">Category: <? echo $category; ?> | Type: <? echo $type; ?>&nbsp;</p>
				  <? if(trim($type) != "On Demand Classes"){ ?>  <p class="category-wrap">Total Enrolled: <? echo (int) tutor_utils()->count_enrolled_users_by_course(); ?></p><? } ?>
				   <!--p><? tutor_course_mark_complete_html(); ?></p-->
				   
                  </div>
               </div>			 	   			   
            </div>
         </section>
		 <section  class="section-wrap pd-spec-wrap">
            <div class="container-wrap">
               <div class="row-wrap">
			    <? if(trim($type) == "On Demand Classes"){ ?>
				
				<div class="col-wrap-full enrolledvideo">
					<h4 class="heading-title">Class Video</h4>
					<? if(get_post_meta(get_the_ID(),'relationclass',true) == "parent"){ ?>
					<div class="colwrapthird">
					<h4 class="heading-title">Lesson Videos</h4>
					<ul>
						<? $relatedid = get_post_meta(get_the_ID(),'relative_class_id',true);
							
							if(!empty($relatedid)){
								foreach($relatedid as $finalid){
									$courseid =  $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_tutor_course_product_id' AND meta_value = '". $finalid ."')"); ?>
									<li><a href="<? echo get_the_permalink($courseid); ?>"><? echo get_the_title($courseid); ?></a></li>
							<?	}
							} ?>
					</ul>
					</div>
					<? } if(get_post_meta(get_the_ID(),'relationclass',true) == "child"){ ?>
					<div class="colwraphalf">
					<!--h4 class="heading-title">Class Details Video</h4-->
						<? $video = explode('/',get_post_meta(get_the_ID(),"_on_demand_video",true)); 
						$vide = array_reverse($video);
						$vide = "https://myhomeschoolfamily.com/uploads/".$vide[1]."/".$vide[0];
						if($video != ""){
						?>
						<video width="100%" height="400" controls>
							<source src="<? echo $vide; ?>" type="video/mp4">
						</video>
						<? } else{ echo "No video session uploaded";} ?>
					</div>
					<? } ?>
				</div>
			   <? } else{ ?>
			   <div class="col-wrap-full">
					<h4 class="heading-title">Live Classes</h4>
					<? if($class_details == ""){
						
					}
					else{ echo $class1; } ?>
				</div>
			   <? } ?>
				<div class="col-wrap-full">
					<h4 class="heading-title">Lessons</h4>
					  <? tutor_course_topics(); ?>
				</div>
               </div>			 	   			   
            </div>
         </section>
		
		 <section  class="section-wrap pd-spec-wrap">
            <div class="container-wrap">
				<div class="row-wrap">
				<? if(trim($type) != "On Demand Classes"){ ?>
					<div class="col-wrap">
						<h4 class="heading-title">Enrolled Class Status</h4>
						<div class="tutor-course-enrolled-info">
							<p>
								<i class="tutor-icon-purchase"></i>
								<?
									$enrolled = tutor_utils()->is_enrolled();

									echo sprintf(__('You have been enrolled on %s.', 'tutor'),  "<span>". date_i18n(get_option('date_format'), strtotime($enrolled->post_date)
										)."</span>"  );
									?>
							</p>   
							<? $count_completed_lesson = tutor_course_completing_progress_bar(); ?>
							
						</div>
					</div>
					<div class="col-wrap">
						<h4 class="heading-title">Announcements</h4>
						<div class="tutor-course-enrolled-info">
							 <? tutor_course_announcements(); ?>
							
						</div>
					</div>
                  <div class="col-wrap">
					  <h4 class="heading-title">Resources for Class</h4>
					  <? if (is_array($attachments) && count($attachments)){ ?>
						<div class="tutor-page-segment tutor-attachments-wrap">
							
							<?
							foreach ($attachments as $attachment){
								?>
								<a href="<? echo $attachment->url; ?>" class="tutor-lesson-attachment clearfix">
									<div class="tutor-attachment-icon">
										<i class="tutor-icon-<? echo $attachment->icon; ?>"></i>
									</div>
									<div class="tutor-attachment-info">
										<span><? echo $attachment->name; ?></span>
										<span><? echo $attachment->size; ?></span>
									</div>
								</a>
								<?
							}
							?>
						</div>
					<? } ?>
                  </div>
                  <? } ?>
                  <div class="col-wrap">
					  <div class="course-desc-wrap">
						<h4 class="heading-title">Course description</h4>
						<? tutor_course_content(); ?>
						<? tutor_course_benefits_html(); ?>
						
					  </div>				  
                  </div>
				  <? if(trim($type) != "On Demand Classes"){ ?>
				  <div class="col-wrap">
					  <h4 class="heading-title">Material</h4>
					  <? tutor_course_material_includes_html(); ?>
                  </div>
				  <div class="col-wrap changefont">
				  <h4 class="heading-title">Course information</h4>
				  <ul class="listing">
					<li><strong>Course Length:</strong> <? echo $tutor_course_duration; ?></li>
					<li><strong>Teacher Assisted:</strong><br><? echo $full_name; ?></li>
				  </ul>
                  </div>
				  <? if($refund != ""){ ?>
				  <div class="col-wrap-full">
					<h4 class="heading-title">Refund Policy</h4>
					<div class="text">
					<? echo $refundtext;  ?>
					</div>
				  </div>
				  <? } } ?>

				<div class="col-wrap-full">
					<h4 class="heading-title">Have any Questions? Please ask here!</h4>
				  <div class="tutor-queston-and-answer-wrap">
					
					<div class="tutor-question-top">
						<div class="tutor-ask-question-btn-wrap">
							<a href="javascript:;" class="tutor-ask-question-btn tutor-btn"> <? _e('Ask a new question', 'tutor'); ?> </a>
						</div>
					</div>

					<div class="tutor-add-question-wrap" style="display: none;">
						<form method="post" id="tutor-ask-question-form">
							<? wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
							<input type="hidden" value="add_question" name="tutor_action"/>
							<input type="hidden" value="<? echo get_the_ID(); ?>" name="tutor_course_id"/>

							<div class="tutor-form-group">
								<input type="text" name="question_title" value="" placeholder="<? _e('Question Title', 'tutor'); ?>">
							</div>

							<div class="tutor-form-group">
								<?
								$editor_settings = array(
									'teeny' => true,
									'media_buttons' => false,
									'quicktags' => false,
									'editor_height' => 100,
								);
								wp_editor(null, 'question', $editor_settings);
								?>
							</div>

							<div class="tutor-form-group">
								<a style="border: var(--tutor-primary-color);background: var(--tutor-primary-color);padding: 13px;" href=" javascript:;" class="tutor_question_cancel tutor-button tutor-danger"><? _e('Cancel', 'tutor'); ?></a>
								<button style="border: var(--tutor-primary-color);background: var(--tutor-primary-color);padding: 13px;" type="submit" class="tutor-button tutor-success tutor_ask_question_btn" name="tutor_question_search_btn"><? _e('Post Question', 'tutor'); ?> </button>
							</div>
						</form>
					</div>

						<div class="tutor_question_answer_wrap">
							<?
							$questions = tutor_utils()->get_top_question();

							if (is_array($questions) && count($questions)){
								foreach ($questions as $question){
									$answers = tutor_utils()->get_qa_answer_by_question($question->comment_ID);
									$profile_url = tutor_utils()->profile_url($question->user_id);
									?>
									<div class="tutor_original_question">
										<div class="tutor-question-wrap">
											<div class="question-top-meta">
												<div class="tutor-question-avater">
													<a href="<? echo $profile_url; ?>"> <? echo tutor_utils()->get_tutor_avatar($question->user_id); ?></a>
												</div>
												<p class="review-meta">
													<a href="<? echo $profile_url; ?>"><? echo $question->display_name; ?></a>
													<span class="tutor-text-mute"><? echo sprintf(__('%s ago', 'tutor'), human_time_diff(strtotime
														($question->comment_date))) ; ?></span>
												</p>
											</div>

											<div class="tutor_question_area">
												<p><strong><? echo $question->question_title; ?> </strong></p>
												<? echo wpautop(stripslashes($question->comment_content)); ?>
											</div>
										</div>
									</div>


									<?
										if (is_array($answers) && count($answers)){ ?>
											<div class="tutor_admin_answers_list_wrap">
												<?
													foreach ($answers as $answer){
														$answer_profile = tutor_utils()->profile_url($answer->user_id);
														?>
														<div class="tutor_individual_answer <? echo ($question->user_id == $answer->user_id) ? 'tutor-bg-white' : 'tutor-bg-light'
														?> ">
															<div class="tutor-question-wrap">
																<div class="question-top-meta">
																	<div class="tutor-question-avater">
																		<a href="<? echo $answer_profile; ?>"> <? echo tutor_utils()->get_tutor_avatar($answer->user_id); ?></a>
																	</div>
																	<p class="review-meta">
																		<a href="<? echo $answer_profile; ?>"><? echo $answer->display_name; ?></a>
																		<span class="tutor-text-mute">
																			<? echo sprintf(__('%s ago', 'tutor'), human_time_diff(strtotime($answer->comment_date)) ) ; ?>
																		</span>
																	</p>
																</div>

																<div class="tutor_question_area">
																	<? echo wpautop(stripslashes($answer->comment_content)); ?>
																</div>
															</div>
														</div>
														<?
													}
												?>
											</div>
										<?
										} ?>
										<div class="tutor_add_answer_row">
											<div class="tutor_add_answer_wrap " data-question-id="<? echo $question->comment_ID; ?>">
												<div class="tutor_wp_editor_show_btn_wrap">
													<a style="border: var(--tutor-primary-color);background: var(--tutor-primary-color);padding: 13px;" href="javascript:;" class="tutor_wp_editor_show_btn tutor-button tutor-success"><? _e('Add an answer', 'tutor'); ?></a>
												</div>
												<div class="tutor_wp_editor_wrap" style="display: none;">
													<form method="post" class="tutor-add-answer-form">
														<? wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
														<input type="hidden" value="tutor_add_answer" name="tutor_action"/>
														<input type="hidden" value="<? echo $question->comment_ID; ?>" name="question_id"/>

														<div class="tutor-form-group">
															<textarea id="tutor_answer_<? echo $question->comment_ID; ?>" name="answer" class="tutor_add_answer_textarea" placeholder="<? _e('Write your answer here...', 'tutor'); ?>"></textarea>
														</div>

														<div class="tutor-form-group">
															<a style="border: var(--tutor-primary-color);background: var(--tutor-primary-color);padding: 13px;" href="javascript:;" class="tutor_cancel_wp_editor tutor-button tutor-danger"><? _e('Cancel', 'tutor'); ?></a>
															<button style="border: var(--tutor-primary-color);background: var(--tutor-primary-color);padding: 13px;" type="submit" class="tutor-button tutor_add_answer_btn tutor-success" name="tutor_answer_search_btn">
																<? _e('Add Answer', 'tutor'); ?>
															</button>
														</div>
													</form>
												</div>
											</div>
										</div>

									<?
								}
							}
							?>
						</div>

					</div>
                  </div>
				  <div class="col-wrap-full">
				  <? tutor_course_instructors_html(); ?>
				  <? tutor_course_target_reviews_html(); ?>
				  <? tutor_course_target_review_form_html(); ?>
                  </div>
				  
               </div>			 	   			   
            </div>
         </section>	
	           
         
    </div>
</div>
<? } else{ ?>
	<div <? tutor_post_class('tutor-full-width-course-top tutor-course-top-info tutor-page-wrap'); ?>>
		<div class="wrapper-main">
			<section  class="section-wrap pd-details-wrap">
				<div class="container-wrap">
					<div class="row-wrap">
						<div class="pd-details-wrap">
							<h4 class="pd-heading-title"><? the_title(); ?></h4>
							<div class="colwraphalf">
					
								<? $video = explode('/',get_post_meta(get_the_ID(),"_on_demand_video",true)); 
								$vide = array_reverse($video);
								$vide = "https://myhomeschoolfamily.com/uploads/".$vide[1]."/".$vide[0];
								if($video != ""){
								?>
								<video width="100%" height="400" controls>
									<source src="<? echo $vide; ?>" type="video/mp4">
								</video>
								<? } else{ echo "No video session uploaded";} ?>
							</div>
						</div>
					</div>
				</div>
				
			</section>
		</div>
	</div>
<? } ?>
<? do_action('tutor_course/single/enrolled/after/wrap'); ?>

<?
get_footer();
