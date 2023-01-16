<?php
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

<?php do_action('tutor_course/single/before/wrap');
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
	if(is_array($course_type) && count($course_type)){

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
	
	/** Quiz count **/
	$topicIDS = $wpdb->get_col("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'topics' AND post_parent = {$course_id} ");

	$quiz_count = 0;
	if (count($topicIDS)){
		$inIDS = implode(",", $topicIDS);
		$quiz_count = $wpdb->get_var("SELECT COUNT(ID)  FROM {$wpdb->posts} WHERE post_parent IN({$inIDS}) AND post_type = 'tutor_quiz' ");
	}
	
	$liveclass = get_post_meta(get_the_ID(),'_insert_meeting_zoom_meeting_id',true);
	$count_total = count($liveclass);
		$class = "";	
		if($liveclass != ""){
			$i = 1;
			$i = 1;
			$j = 1;
			$count_main = 0;
			foreach($liveclass as $results){
				
					$post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $results ."')");
					$start_date = get_post_meta($post_id,'_meeting_date',true);
					$class_date = date('Y-m-d',strtotime($start_date));
					$class_datee = date('d-M-Y h:i a',strtotime($start_date));
					$class_details = get_post_meta($post_id,'_meeting_zoom_details',true);
					$blogtime = date("Y-m-d");
					date_default_timezone_set("America/New_York");
					$checkttime = date('Y-m-d h:i:sa',strtotime($start_date));
					$currenttime = date("Y-m-d h:i:sa");
					$checkttime = strtotime($checkttime);
					$currenttime = strtotime($currenttime);	
					
					if($i == 1){
						
						if($checkttime >= $currenttime ){
							$class .= '<div class="elementor-widget-container">
									<h4 class="elementor-heading-title elementor-size-default">Next Live Class starts: '.$class_datee.' (Eastern Daylight Time)</h4>	
								</div>';
							$i++;
						}
						else{
							
							if($course_students == 0){
									if($checkttime >= $currenttime ){
										$class .= '<div class="elementor-widget-container">
												<h4 class="elementor-heading-title elementor-size-default">Next Live Class starts: '.$class_datee.' (Eastern Daylight Time)</h4>	
											</div>';
										$i++;
									}
									else{
										$hideclass = "hide";
										$class .= '<div class="elementor-widget-container">
												<h4 class="elementor-heading-title elementor-size-default">Class closed for Enrollment!</h4>	
											</div>';
										$i++;
									}
									
								}
								else{
									$hideclass = "hide";
									$class .= '<div class="elementor-widget-container">
												<h4 class="elementor-heading-title elementor-size-default">Class closed for Enrollment!</h4>	
											</div>';
										$i++;
									
								}
							 
							
						}
					}
					if($j >= 1){
						if($class_date == $blogtime){
							//echo do_shortcode('[zoom_api_link meeting_id="'.$results.'" link_only="no"]');
						}
						if($class_date > $blogtime){
							$datee = $start_date;
							$nameOfDay = date('l', strtotime($datee));
							$class1 .= '<li>'.$nameOfDay.', '.$class_datee.' (Eastern Daylight Time)</li>';
								$j++;
								
						}
						
					}
					if($checkttime > $currenttime)
					{
						$countmain = $countmain+1;
					}
			}
		
		}
		else{
			$class .= '<div class="elementor-widget-container">
							<h4 class="elementor-heading-title elementor-size-default">No Live Class Scheduled for this course! </h4>	
				</div>';
			
		}
	$product_id = tutor_utils()->get_course_product_id();
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
$user = wp_get_current_user();
$coming = get_post_meta(get_the_ID(),"comingsoon",true);
if($coming == "coming"){
	$hideclass = "hide";
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
if($count_total == $countmain){
	
}
else{
	$finalcount = $count_total - $countmain;
}
$late_enroll_data = get_post_meta(get_the_ID(),"lateenrollnumber",true);
$late_enroll = get_post_meta(get_the_ID(),"lateenroll",true);
?>


<div <?php tutor_post_class('tutor-full-width-course-top tutor-course-top-info tutor-page-wrap'); ?>>
    <div class="wrapper-main">
        <section  class="section-wrap pd-details-wrap">
            <div class="container-wrap">
               <div class="row-wrap">
                  <div class="pd-img-wrap">
					<?php
						if(tutor_utils()->has_video_in_single()){
							tutor_course_video();
						} else{
							get_tutor_course_thumbnail();
						}
					?>
                  </div>
				  <div class="pd-details-wrap">
					<h4 class="pd-heading-title"><?php the_title(); ?></h4>
					<strong><?php echo $bibical; ?></strong>
					<?php 
					$excerpt = wp_trim_words( get_the_content(), 25, '<a id="clickcontent" href="javascript:void(0)">..Read More</a>'); ?>
					<p><?php echo $excerpt; ?></p>
					<p><?php if($coming == "coming"){echo '<div class="elementor-widget-container">
									<h4 class="elementor-heading-title elementor-size-default"><p style="color:#25A9E0;">Coming Soon!</p></h4>	
						</div>';} else { echo $class; } ?></p>
					<?php if($hideclass != "hide"){ ?><p> <a class="elementor-button-link elementor-button elementor-size-xs" href="#liveclass">View all classes</a></p><?php } ?>
					<p class="grade-wrap">Grade: <?php echo $grade; ?>  | Instructor Name: <?php echo $full_name; ?>	</p>
				   <p class="category-wrap">Category: <?php echo $category; ?> | Type: <?php echo $type; ?>&nbsp;</p>
				   <?php if($finalcount > 0 && $late_enroll == "yes"){ ?><div class="required"><?php echo $finalcount." Class(es) passed!"; ?></div> <?php } ?>
				   <div class="price-wrap courseprice">Price: <?php echo $finalprice; ?></div>
				   <?php if($hideclass != "hide"){ if (current_user_can(tutor()->instructor_role)){ } elseif(in_array( 'customer', (array) $user->roles )){ echo do_shortcode('[elementor-template id="11436"]'); ?> <div class="btn-wrap"><button class="tutor-btn-enroll user-enroll-popup tutor-btn tutor-course-purchase-btn buy-btn"> Enroll Now </button></div> <?php } else{ ?><div class="btn-wrap"><?php tutor_single_course_add_to_cart(); ?></div><?php } }elseif($finalcount <= $late_enroll_data && $late_enroll == "yes" && $countmain > 0){if (current_user_can(tutor()->instructor_role)){ } elseif(in_array( 'customer', (array) $user->roles )){ echo do_shortcode('[elementor-template id="11436"]'); ?> <div class="btn-wrap"><button class="tutor-btn-enroll user-enroll-popup tutor-btn tutor-course-purchase-btn buy-btn"> Late Enroll Now </button></div> <?php } else{ ?><div class="btn-wrap"><?php tutor_single_course_add_to_cart(); ?></div><?php }
				   } ?>
				   
                  </div>
               </div>			 	   			   
            </div>
         </section>
		 <section  class="section-wrap pd-spec-wrap"  id="liveclass">
            <div class="container-wrap">
               <div class="row-wrap">
                  <div class="col-wrap">
					 <h4 class="heading-title">Class Lessons</h4>
					  <ul class="listing">
						
						<li><?php echo $tutor_lesson_count; ?> lessons</li>
						<li><?php echo $quiz_count; ?> Quizzes</li>
						
					  </ul>
					
                  </div>
                  <div class="col-wrap">
					  <h4 class="heading-title">Material</h4>
					  <?php tutor_course_material_includes_html(); ?>
                  </div>
                  <div class="col-wrap">
					  <h4 class="heading-title">Requirements</h4>
					  <?php tutor_course_requirements_html(); ?>
                  </div>
                  <div class="col-wrap" id="contentmain">
					  <div class="course-desc-wrap">
						<h4 class="heading-title">Course description</h4>
						<?php tutor_course_content(); ?>
						<?php tutor_course_benefits_html(); ?>
						<?php if($hideclass != "hide"){ if (current_user_can(tutor()->instructor_role)){ } elseif(in_array( 'customer', (array) $user->roles )){ echo do_shortcode('[elementor-template id="11436"]'); ?> <div class="btn-wrap"><button class="tutor-btn-enroll user-enroll-popup tutor-btn tutor-course-purchase-btn buy-btn"> Enroll Now </button></div> <?php } else{ ?><div class="btn-wrap"><?php tutor_single_course_add_to_cart(); ?></div><?php } } ?>
					  </div>				  
                  </div>

				  <div class="col-wrap changefont">
				  <h4 class="heading-title">Course information</h4>
				  <ul class="listing">
					<li><strong>Course Length:</strong> <?php echo $tutor_course_duration; ?></li>
					<li><strong>Teacher Assisted:</strong><br><?php echo $full_name; ?></li>
					<li><strong>All Live Classes: </strong> <?php if($late_enroll == "yes"){ echo $finalcount." Class(es) passed!";} ?><br><?php echo $class1; ?></li>
					
					
				  </ul>
                  </div>
				 <?php if($refund != ""){ ?>
				  <div class="col-wrap-full">
					<h4 class="heading-title">Refund Policy</h4>
					<div class="text">
					<?php echo $refundtext;  ?>
					</div>
				  </div>
				  <?php } ?>
				  <!-- Start Q&A -->
				 <?php if(is_user_logged_in()){ ?>
				<div class="col-wrap-full">
					<h4 class="heading-title">Have any Questions? Please ask here!</h4>
				  <div class="tutor-queston-and-answer-wrap">
					
					<div class="tutor-question-top">
						<div class="tutor-ask-question-btn-wrap">
							<a href="javascript:;" class="tutor-ask-question-btn tutor-btn"> <?php _e('Ask a new question', 'tutor'); ?> </a>
						</div>
					</div>

					<div class="tutor-add-question-wrap" style="display: none;">
						<form method="post" id="tutor-ask-question-form">
							<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
							<input type="hidden" value="add_question" name="tutor_action"/>
							<input type="hidden" value="<?php echo get_the_ID(); ?>" name="tutor_course_id"/>

							<div class="tutor-form-group">
								<input type="text" name="question_title" value="" placeholder="<?php _e('Question Title', 'tutor'); ?>">
							</div>

							<div class="tutor-form-group">
								<?php
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
								<a style="border: var(--tutor-primary-color);background: var(--tutor-primary-color);padding: 13px;" href=" javascript:;" class="tutor_question_cancel tutor-button tutor-danger"><?php _e('Cancel', 'tutor'); ?></a>
								<button style="border: var(--tutor-primary-color);background: var(--tutor-primary-color);padding: 13px;" type="submit" class="tutor-button tutor-success tutor_ask_question_btn" name="tutor_question_search_btn"><?php _e('Post Question', 'tutor'); ?> </button>
							</div>
						</form>
					</div>

						<div class="tutor_question_answer_wrap">
							<?php
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
													<a href="<?php echo $profile_url; ?>"> <?php echo tutor_utils()->get_tutor_avatar($question->user_id); ?></a>
												</div>
												<p class="review-meta">
													<a href="<?php echo $profile_url; ?>"><?php echo $question->display_name; ?></a>
													<span class="tutor-text-mute"><?php echo sprintf(__('%s ago', 'tutor'), human_time_diff(strtotime
														($question->comment_date))) ; ?></span>
												</p>
											</div>

											<div class="tutor_question_area">
												<p><strong><?php echo $question->question_title; ?> </strong></p>
												<?php echo wpautop(stripslashes($question->comment_content)); ?>
											</div>
										</div>
									</div>


									<?php
										if (is_array($answers) && count($answers)){ ?>
											<div class="tutor_admin_answers_list_wrap">
												<?php
													foreach ($answers as $answer){
														$answer_profile = tutor_utils()->profile_url($answer->user_id);
														?>
														<div class="tutor_individual_answer <?php echo ($question->user_id == $answer->user_id) ? 'tutor-bg-white' : 'tutor-bg-light'
														?> ">
															<div class="tutor-question-wrap">
																<div class="question-top-meta">
																	<div class="tutor-question-avater">
																		<a href="<?php echo $answer_profile; ?>"> <?php echo tutor_utils()->get_tutor_avatar($answer->user_id); ?></a>
																	</div>
																	<p class="review-meta">
																		<a href="<?php echo $answer_profile; ?>"><?php echo $answer->display_name; ?></a>
																		<span class="tutor-text-mute">
																			<?php echo sprintf(__('%s ago', 'tutor'), human_time_diff(strtotime($answer->comment_date)) ) ; ?>
																		</span>
																	</p>
																</div>

																<div class="tutor_question_area">
																	<?php echo wpautop(stripslashes($answer->comment_content)); ?>
																</div>
															</div>
														</div>
														<?php
													}
												?>
											</div>
										<?php
										} ?>
										<div class="tutor_add_answer_row">
											<div class="tutor_add_answer_wrap " data-question-id="<?php echo $question->comment_ID; ?>">
												<div class="tutor_wp_editor_show_btn_wrap">
													<a style="border: var(--tutor-primary-color);background: var(--tutor-primary-color);padding: 13px;" href="javascript:;" class="tutor_wp_editor_show_btn tutor-button tutor-success"><?php _e('Add an answer', 'tutor'); ?></a>
												</div>
												<div class="tutor_wp_editor_wrap" style="display: none;">
													<form method="post" class="tutor-add-answer-form">
														<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
														<input type="hidden" value="tutor_add_answer" name="tutor_action"/>
														<input type="hidden" value="<?php echo $question->comment_ID; ?>" name="question_id"/>

														<div class="tutor-form-group">
															<textarea id="tutor_answer_<?php echo $question->comment_ID; ?>" name="answer" class="tutor_add_answer_textarea" placeholder="<?php _e('Write your answer here...', 'tutor'); ?>"></textarea>
														</div>

														<div class="tutor-form-group">
															<a style="border: var(--tutor-primary-color);background: var(--tutor-primary-color);padding: 13px;" href="javascript:;" class="tutor_cancel_wp_editor tutor-button tutor-danger"><?php _e('Cancel', 'tutor'); ?></a>
															<button style="border: var(--tutor-primary-color);background: var(--tutor-primary-color);padding: 13px;" type="submit" class="tutor-button tutor_add_answer_btn tutor-success" name="tutor_answer_search_btn">
																<?php _e('Add Answer', 'tutor'); ?>
															</button>
														</div>
													</form>
												</div>
											</div>
										</div>

									<?php
								}
							}
							?>
						</div>

					</div>
                  </div>
				 <?php } ?>
				  <!-- end Q&A -->
				  <div class="col-wrap-full">
				  <?php tutor_course_instructors_html(); ?>
				  <?php tutor_course_target_reviews_html(); ?>
                  </div>
				  
               </div>			 	   			   
            </div>
         </section>	
	           
         
    </div>
</div>

<?php do_action('tutor_course/single/after/wrap'); ?>

<?php
get_footer();
