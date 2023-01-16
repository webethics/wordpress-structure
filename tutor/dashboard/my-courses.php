<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>

<h3><?php _e('My Classes', 'tutor'); ?></h3>
<div class="tutor-dashboard-inline-links">
		<ul>
			<li  class=" <?php if($_GET['class']==''){echo "active";}?>">
                <a href="/my-account/my-courses/?class=">Live Classes</a>
			</li>
			<li class="<?php if($_GET['class']=='on-demand-classes' && $_GET['classes'] == ""){echo "active";}?>">
                <a href="/my-account/my-courses/?class=on-demand-classes"> OnDemand Classes</a>
			</li>
			<li class="<?php if($_GET['classes']=='child'){echo "active";}?>">
                <a href="/my-account/my-courses/?class=on-demand-classes&classes=child">Video Library Classes</a>
			</li>
			<li class="<?php if($_GET['class']=='complete-class'){echo "active";}?>">
                <a href="/my-account/my-courses/?class=complete-class">Completed Classes</a>
			</li>
			
		</ul>
	</div>

<div class="tutor-dashboard-content-inner">

	<?php
	$my_courses = tutor_utils()->get_courses_by_instructor(null, array('publish', 'draft', 'pending'));

	if (is_array($my_courses) && count($my_courses)):
		global $post, $wpdb;
		foreach ($my_courses as $post):
			setup_postdata($post);
			$courseid = $post->ID;
			 $type_list =  wp_get_post_terms(get_the_ID(), 'coursetype' , array( 'fields' => 'all' ) );	
			 $is_completed_course = tutor_utils()->is_completed_course();
			if($_GET['class'] == "" && ($type_list[0]->slug == "class-course" || $type_list[0]->slug == "private-tutor") && $is_completed_course == ""){
			
			$avg_rating = tutor_utils()->get_course_rating()->rating_avg;
            $tutor_course_img = get_tutor_course_thumbnail_src();
			$liveclass = get_post_meta(get_the_ID(),'_insert_meeting_zoom_meeting_id',true);
			$coming = get_post_meta(get_the_ID(),"comingsoon",true);
				 $i = 1;
				 $class = "";	
			if($coming == "coming"){$class .= '<div class="elementor-widget-container">
									<h6 class="elementor-heading-title elementor-size-default">Coming Soon!</h6>	
						</div>';}
			else{
				if($liveclass != ""){
				
					foreach($liveclass as $results){
						if($i == 1){
							$post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $results ."')");
							$start_date = get_post_meta($post_id,'_meeting_date',true);
							
							$class_date = date('Y-m-d',strtotime($start_date));
							$class_datee = date('d-M-Y h:i a',strtotime($start_date));
							$blogtime = date("Y-m-d"); 
							
							 

							if($class_date == $blogtime){
								//echo do_shortcode('[zoom_api_link meeting_id="'.$results.'" link_only="no"]');
							}
							if($class_date >= $blogtime){
								$start_url = get_post_meta($post_id,'_meeting_zoom_start_url',true);
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
			}
			?>
        
            <div id="tutor-dashboard-course-<?php the_ID(); ?>" class="tutor-mycourse-wrap tutor-mycourse-<?php the_ID(); ?>">
                <div class="tutor-mycourse-thumbnail" style="background-image: url(<?php echo esc_url($tutor_course_img); ?>)"></div>
                <div class="tutor-mycourse-content">
                    <div class="tutor-mycourse-rating">
						<?php
						tutor_utils()->star_rating_generator($avg_rating);
						?>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p><?php echo $class; ?></p>
                    <div class="tutor-meta tutor-course-metadata">
						<?php
                            $total_lessons = tutor_utils()->get_lesson_count_by_course();
                            $completed_lessons = tutor_utils()->get_completed_lesson_count_by_course();

                            $course_duration = get_tutor_course_duration_context();
                            $course_students = tutor_utils()->count_enrolled_users_by_course();
						?>
                        <ul>
                            <li>
								<?php
								_e('Status:', 'tutor');
								$status = ucwords($post->post_status);
								if($status == "Publish"){
									$status = $status."ed";
								}
								echo "<span>$status</span>";
								?>
                            </li>
                            <li>
								<?php
								_e('Duration:', 'tutor');
								echo "<span>$course_duration</span>";
								?>
                            </li>
                            <li>
								<?php
								_e('Students:', 'tutor');
								echo "<span>$course_students</span>";
								?>
                            </li>
                        </ul>
                    </div>

                    <div class="mycourse-footer">
                        <div class="tutor-mycourses-stats">
	                        <?php echo tutor_utils()->tutor_price(tutor_utils()->get_course_price()); ?>
                            <a href="<?php echo tutor_utils()->course_edit_link($post->ID); ?>" class="tutor-mycourse-edit">
                                <i class="tutor-icon-pencil"></i>
                                <?php _e('Edit', 'tutor'); ?>
                            </a>
							<?php if($course_students == 0){ ?>
								
							
                            <a href="#tutor-course-delete" class="tutor-dashboard-element-delete-btn" data-id="<?php echo $post->ID; ?>">
                                <i class="tutor-icon-garbage"></i> <?php _e('Delete', 'tutor') ?>
                            </a>
							<?php } ?>
							<a href="/my-account/quizes/?course_id=<?php echo $post->ID; ?>" >
                                <i class="tutor-icon-pencil"></i> <?php _e('View Quizzes', 'tutor') ?>
                            </a>
							<?php if($coming == "coming"){ }else{ if($start_url != ""){ ?><a target="_blank" href="<?php echo $start_url; ?>" class="tutor_button" >
                                <i class="tutor-icon-user"></i> <?php _e('Start Class', 'tutor') ?>
                            </a>
							<?php } } 
							
							$getEnrolledInfo = $wpdb->get_results( "select ID, post_author, post_date,post_date_gmt,post_title from {$wpdb->posts} WHERE post_type = 'tutor_enrolled' AND post_parent = {$post->ID} AND post_status = 'completed'; " );  
			
							$count = count($getEnrolledInfo);
							if($count > 0){
								?>
								<a href="#tutor-course-alert" class="tooltip tutor-dashboard-element-alert-btn" data-id="<?php echo $post->ID; ?>" data-content="<?php echo get_post_meta($courseid,'alertmessage',true); ?>">
                                <i class="tutor-icon-speaker"></i> <?php _e('Alert', 'tutor') ?>
								<span class="tooltiptext">Send notification to students related to class!</span>
                            </a>
								<?php
							$is_completed_course = tutor_utils()->is_completed_course();
							if ( ! $is_completed_course) {	?>
								<div class="tutor-course-compelte-form-wrap" style="width:200px;float:right;">

									<form method="post">
										<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>

										<input type="hidden" value="<?php echo get_the_ID(); ?>" name="course_id"/>
										<input type="hidden" value="tutor_complete_course" name="tutor_action"/>
										<div class="box-border-btn">
										<i class="tutor-icon-mark"></i><button onclick="return confirm('Are you sure you want to complete it?')" type="submit" style="background:none;    color: #25a9e0;margin: 0px;padding: 0px 0px 0px 9px;vertical-align:top;" class="course-complete-button" name="complete_course_btn" value="complete_course"><?php _e( 'Complete Course', 'tutor' ); ?></button>
										</div>
									</form>
								</div>
								<?php }else{ 
								echo '<div class="tutor-course-compelte-form-wrap" style="width:200px;float:right;"><div class="box-border-btn" style="width:130px;"><button type="button" style="background:none;color: #555;margin:0px;padding:0px 0px 0px 9px;vertical-align:top;">Completed</button></div></div>';
								 }  
							} ?>
							
                        </div>
                    </div>
                </div>

            </div>
			<?php } 
			elseif($_GET['class'] == "on-demand-classes" && $type_list[0]->slug == "on-demand-classes" && $is_completed_course == "" && get_post_meta(get_the_ID(),'relationclass',true) == "parent" && $_GET['classes'] != "child"){
				
			$avg_rating = tutor_utils()->get_course_rating()->rating_avg;
            $tutor_course_img = get_tutor_course_thumbnail_src();
			
			?>
			
            <div id="tutor-dashboard-course-<?php the_ID(); ?>" class="tutor-mycourse-wrap tutor-mycourse-<?php the_ID(); ?>">
                <div class="tutor-mycourse-thumbnail" style="background-image: url(<?php echo esc_url($tutor_course_img); ?>)"></div>
                <div class="tutor-mycourse-content">
                    <div class="tutor-mycourse-rating">
						<?php
						tutor_utils()->star_rating_generator($avg_rating);
						?>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					
                    <div class="tutor-meta tutor-course-metadata">
						<?php
                            $total_lessons = tutor_utils()->get_lesson_count_by_course();
                            $completed_lessons = tutor_utils()->get_completed_lesson_count_by_course();

                            $course_duration = get_tutor_course_duration_context();
                            $course_students = tutor_utils()->count_enrolled_users_by_course();
						?>
                        <ul>
                            <li>
								<?php
								_e('Status:', 'tutor');
								$status = ucwords($post->post_status);
								if($status == "Publish"){
									$status = $status."ed";
								}
								echo "<span>$status</span>";
								?>
                            </li>
                            <li>
								<?php
								_e('Duration:', 'tutor');
								echo "<span>$course_duration</span>";
								?>
                            </li>
                            <li>
								<?php
								_e('Students:', 'tutor');
								echo "<span>$course_students</span>";
								?>
                            </li>
                        </ul>
                    </div>
<div class="mycourse-footer">
                        <div class="tutor-mycourses-stats">
	                        <?php echo tutor_utils()->tutor_price(tutor_utils()->get_course_price()); ?>
                            <a href="<?php echo tutor_utils()->course_edit_link($post->ID); ?>" class="tutor-mycourse-edit">
                                <i class="tutor-icon-pencil"></i>
                                <?php _e('Edit', 'tutor'); ?>
                            </a>
							<?php if($course_students == 0){ ?>
								
							
                            <a href="#tutor-course-delete" class="tutor-dashboard-element-delete-btn" data-id="<?php echo $post->ID; ?>">
                                <i class="tutor-icon-garbage"></i> <?php _e('Delete', 'tutor') ?>
                            </a>
							<?php } ?>
							<a href="/my-account/quizes/?course_id=<?php echo $post->ID; ?>" >
                                <i class="tutor-icon-pencil"></i> <?php _e('View Quizzes', 'tutor') ?>
                            </a>
							<?php if($coming == "coming"){ }else{ if($start_url != ""){ ?><a target="_blank" href="<?php echo $start_url; ?>" class="tutor_button" >
                                <i class="tutor-icon-user"></i> <?php _e('Start Class', 'tutor') ?>
                            </a>
							<?php } } 
							
							$getEnrolledInfo = $wpdb->get_results( "select ID, post_author, post_date,post_date_gmt,post_title from {$wpdb->posts} WHERE post_type = 'tutor_enrolled' AND post_parent = {$post->ID} AND post_status = 'completed'; " );  
			
							$count = count($getEnrolledInfo);
							if($count > 0){
								?>
								<a href="#tutor-course-alert" class="tooltip tutor-dashboard-element-alert-btn" data-id="<?php echo $post->ID; ?>" data-content="<?php echo get_post_meta($courseid,'alertmessage',true); ?>">
                                <i class="tutor-icon-speaker"></i> <?php _e('Alert', 'tutor') ?>
								<span class="tooltiptext">Send notification to students related to class!</span>
                            </a>
								<?php
							$is_completed_course = tutor_utils()->is_completed_course();
							if ( ! $is_completed_course) {	?>
								<div class="tutor-course-compelte-form-wrap" style="width:200px;float:right;">

									<form method="post">
										<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>

										<input type="hidden" value="<?php echo get_the_ID(); ?>" name="course_id"/>
										<input type="hidden" value="tutor_complete_course" name="tutor_action"/>
										<div class="box-border-btn">
										<i class="tutor-icon-mark"></i><button onclick="return confirm('Are you sure you want to complete it?')" type="submit" style="background:none;    color: #25a9e0;margin: 0px;padding: 0px 0px 0px 9px;vertical-align:top;" class="course-complete-button" name="complete_course_btn" value="complete_course"><?php _e( 'Complete Course', 'tutor' ); ?></button>
										</div>
									</form>
								</div>
								<?php }else{ 
								echo '<div class="tutor-course-compelte-form-wrap" style="width:200px;float:right;"><div class="box-border-btn" style="width:130px;"><button type="button" style="background:none;color: #555;margin:0px;padding:0px 0px 0px 9px;vertical-align:top;">Completed</button></div></div>';
								 }  
							} ?>
							
                        </div>
                    </div>
                </div>

            </div>
		<?php
			}
			elseif($_GET['class'] == "on-demand-classes" && $_GET['classes'] == "child" && $type_list[0]->slug == "on-demand-classes" && $is_completed_course == "" && get_post_meta(get_the_ID(),'relationclass',true) == "child"){
				
				
			$avg_rating = tutor_utils()->get_course_rating()->rating_avg;
            $tutor_course_img = get_tutor_course_thumbnail_src();
			
			?>
			
            <div id="tutor-dashboard-course-<?php the_ID(); ?>" class="tutor-mycourse-wrap tutor-mycourse-<?php the_ID(); ?>">
                <div class="tutor-mycourse-thumbnail" style="background-image: url(<?php echo esc_url($tutor_course_img); ?>)"></div>
                <div class="tutor-mycourse-content">
                    <div class="tutor-mycourse-rating">
						<?php
						tutor_utils()->star_rating_generator($avg_rating);
						?>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					
                    <div class="tutor-meta tutor-course-metadata">
						<?php
                            $total_lessons = tutor_utils()->get_lesson_count_by_course();
                            $completed_lessons = tutor_utils()->get_completed_lesson_count_by_course();

                            $course_duration = get_tutor_course_duration_context();
                            $course_students = tutor_utils()->count_enrolled_users_by_course();
						?>
                        <ul>
                            <li>
								<?php
								_e('Status:', 'tutor');
								$status = ucwords($post->post_status);
								if($status == "Publish"){
									$status = $status."ed";
								}
								echo "<span>$status</span>";
								?>
                            </li>
                            <li>
								<?php
								_e('Duration:', 'tutor');
								echo "<span>$course_duration</span>";
								?>
                            </li>
                            <li>
								<?php
								_e('Students:', 'tutor');
								echo "<span>$course_students</span>";
								?>
                            </li>
                        </ul>
                    </div>

                   <div class="mycourse-footer">
                        <div class="tutor-mycourses-stats">
	                        <?php echo tutor_utils()->tutor_price(tutor_utils()->get_course_price()); ?>
                            <a href="<?php echo tutor_utils()->course_edit_link($post->ID); ?>" class="tutor-mycourse-edit">
                                <i class="tutor-icon-pencil"></i>
                                <?php _e('Edit', 'tutor'); ?>
                            </a>
							<?php if($course_students == 0){ ?>
								
							
                            <a href="#tutor-course-delete" class="tutor-dashboard-element-delete-btn" data-id="<?php echo $post->ID; ?>">
                                <i class="tutor-icon-garbage"></i> <?php _e('Delete', 'tutor') ?>
                            </a>
							<?php } ?>
							<a href="/my-account/quizes/?course_id=<?php echo $post->ID; ?>" >
                                <i class="tutor-icon-pencil"></i> <?php _e('View Quizzes', 'tutor') ?>
                            </a>
							<?php if($coming == "coming"){ }else{ if($start_url != ""){ ?><a target="_blank" href="<?php echo $start_url; ?>" class="tutor_button" >
                                <i class="tutor-icon-user"></i> <?php _e('Start Class', 'tutor') ?>
                            </a>
							<?php } } 
							
							$getEnrolledInfo = $wpdb->get_results( "select ID, post_author, post_date,post_date_gmt,post_title from {$wpdb->posts} WHERE post_type = 'tutor_enrolled' AND post_parent = {$post->ID} AND post_status = 'completed'; " );  
			
							$count = count($getEnrolledInfo);
							if($count > 0){
								?>
								<a href="#tutor-course-alert" class="tooltip tutor-dashboard-element-alert-btn" data-id="<?php echo $post->ID; ?>" data-content="<?php echo get_post_meta($courseid,'alertmessage',true); ?>">
                                <i class="tutor-icon-speaker"></i> <?php _e('Alert', 'tutor') ?>
								<span class="tooltiptext">Send notification to students related to class!</span>
                            </a>
								<?php
							$is_completed_course = tutor_utils()->is_completed_course();
							if ( ! $is_completed_course) {	?>
								<div class="tutor-course-compelte-form-wrap" style="width:200px;float:right;">

									<form method="post">
										<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>

										<input type="hidden" value="<?php echo get_the_ID(); ?>" name="course_id"/>
										<input type="hidden" value="tutor_complete_course" name="tutor_action"/>
										<div class="box-border-btn">
										<i class="tutor-icon-mark"></i><button onclick="return confirm('Are you sure you want to complete it?')" type="submit" style="background:none;    color: #25a9e0;margin: 0px;padding: 0px 0px 0px 9px;vertical-align:top;" class="course-complete-button" name="complete_course_btn" value="complete_course"><?php _e( 'Complete Course', 'tutor' ); ?></button>
										</div>
									</form>
								</div>
								<?php }else{ 
								echo '<div class="tutor-course-compelte-form-wrap" style="width:200px;float:right;"><div class="box-border-btn" style="width:130px;"><button type="button" style="background:none;color: #555;margin:0px;padding:0px 0px 0px 9px;vertical-align:top;">Completed</button></div></div>';
								 }  
							} ?>
							
                        </div>
                    </div>
                </div>

            </div>
		<?php
			}
			elseif($_GET['class'] == "complete-class" && $is_completed_course != ""){
			$avg_rating = tutor_utils()->get_course_rating()->rating_avg;
            $tutor_course_img = get_tutor_course_thumbnail_src();
			$liveclass = get_post_meta(get_the_ID(),'_insert_meeting_zoom_meeting_id',true);
				$i = 1;
				 $class = "";	
				if($liveclass != ""){
				
					foreach($liveclass as $results){
						if($i == 1){
							$post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $results ."')");
							$start_date = get_post_meta($post_id,'_meeting_date',true);
							
							$class_date = date('Y-m-d',strtotime($start_date));
							$class_datee = date('d-M-Y h:i a',strtotime($start_date));
							$blogtime = date("Y-m-d"); 

							if($class_date == $blogtime){
								//echo do_shortcode('[zoom_api_link meeting_id="'.$results.'" link_only="no"]');
							}
							if($class_date >= $blogtime){
								$start_url = get_post_meta($post_id,'_meeting_zoom_start_url',true);
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
        
            <div id="tutor-dashboard-course-<?php the_ID(); ?>" class="tutor-mycourse-wrap tutor-mycourse-<?php the_ID(); ?>">
                <div class="tutor-mycourse-thumbnail" style="background-image: url(<?php echo esc_url($tutor_course_img); ?>)"></div>
                <div class="tutor-mycourse-content">
                    <div class="tutor-mycourse-rating">
						<?php
						tutor_utils()->star_rating_generator($avg_rating);
						?>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p><?php echo $class; ?></p>
                    <div class="tutor-meta tutor-course-metadata">
						<?php
                            $total_lessons = tutor_utils()->get_lesson_count_by_course();
                            $completed_lessons = tutor_utils()->get_completed_lesson_count_by_course();

                            $course_duration = get_tutor_course_duration_context();
                            $course_students = tutor_utils()->count_enrolled_users_by_course();
						?>
                        <ul>
                            <li>
								<?php
								_e('Status:', 'tutor');
								$status = ucwords($post->post_status);
								if($status == "Publish"){
									$status = $status."ed";
								}
								echo "<span>$status</span>";
								?>
                            </li>
                            <li>
								<?php
								_e('Duration:', 'tutor');
								echo "<span>$course_duration</span>";
								?>
                            </li>
                            <li>
								<?php
								_e('Students:', 'tutor');
								echo "<span>$course_students</span>";
								?>
                            </li>
                        </ul>
                    </div>

                    <div class="mycourse-footer">
                        <div class="tutor-mycourses-stats">
	                        <?php echo tutor_utils()->tutor_price(tutor_utils()->get_course_price()); ?>
                            <a href="<?php echo tutor_utils()->course_edit_link($post->ID); ?>" class="tutor-mycourse-edit">
                                <i class="tutor-icon-pencil"></i>
                                <?php _e('Edit', 'tutor'); ?>
                            </a>
							<?php if($course_students == 0){ ?>
								
							
                            <a href="#tutor-course-delete" class="tutor-dashboard-element-delete-btn" data-id="<?php echo $post->ID; ?>">
                                <i class="tutor-icon-garbage"></i> <?php _e('Delete', 'tutor') ?>
                            </a>
							<?php } ?>
							<a href="/my-account/quizes/?course_id=<?php echo $post->ID; ?>" >
                                <i class="tutor-icon-pencil"></i> <?php _e('View Quizzes', 'tutor') ?>
                            </a>
							<?php if($coming == "coming"){ }else{ if($start_url != ""){ ?><a target="_blank" href="<?php echo $start_url; ?>" class="tutor_button" >
                                <i class="tutor-icon-user"></i> <?php _e('Start Class', 'tutor') ?>
                            </a>
							<?php } } 
							
							$getEnrolledInfo = $wpdb->get_results( "select ID, post_author, post_date,post_date_gmt,post_title from {$wpdb->posts} WHERE post_type = 'tutor_enrolled' AND post_parent = {$post->ID} AND post_status = 'completed'; " );  
			
							$count = count($getEnrolledInfo);
							if($count > 0){
								?>
								<a href="#tutor-course-alert" class="tooltip tutor-dashboard-element-alert-btn" data-id="<?php echo $post->ID; ?>" data-content="<?php echo get_post_meta($courseid,'alertmessage',true); ?>">
                                <i class="tutor-icon-speaker"></i> <?php _e('Alert', 'tutor') ?>
								<span class="tooltiptext">Send notification to students related to class!</span>
                            </a>
								<?php
							$is_completed_course = tutor_utils()->is_completed_course();
							if ( ! $is_completed_course) {	?>
								<div class="tutor-course-compelte-form-wrap" style="width:200px;float:right;">

									<form method="post">
										<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>

										<input type="hidden" value="<?php echo get_the_ID(); ?>" name="course_id"/>
										<input type="hidden" value="tutor_complete_course" name="tutor_action"/>
										<div class="box-border-btn">
										<i class="tutor-icon-mark"></i><button onclick="return confirm('Are you sure you want to complete it?')" type="submit" style="background:none;    color: #25a9e0;margin: 0px;padding: 0px 0px 0px 9px;vertical-align:top;" class="course-complete-button" name="complete_course_btn" value="complete_course"><?php _e( 'Complete Course', 'tutor' ); ?></button>
										</div>
									</form>
								</div>
								<?php }else{ 
								echo '<div class="tutor-course-compelte-form-wrap" style="width:200px;float:right;"><div class="box-border-btn" style="width:130px;"><button type="button" style="background:none;color: #555;margin:0px;padding:0px 0px 0px 9px;vertical-align:top;">Completed</button></div></div>';
								 }  
							} ?>
							
                        </div>
                    </div>
                </div>

            </div>
		<?php
			} ?>
		<?php
		endforeach;
	else : ?>
        <div>
            <h2><?php _e("No Records Found!" , 'tutor'); ?></h2>
            
        </div>
	<?php endif; ?>

	<div class="tutor-frontend-modal" data-popup-rel="#tutor-course-delete" style="display: none">
        <div class="tutor-frontend-modal-overlay"></div>
        <div class="tutor-frontend-modal-content">
            <button class="tm-close tutor-icon-line-cross"></button>

            <div class="tutor-modal-body tutor-course-delete-popup">
                <img src="<?php echo tutor()->url . 'assets/images/delete-icon.png' ?>" alt="">
                <h3><?php _e('Delete This Course?', 'tutor'); ?></h3>
                <p><?php _e("You are going to delete this course, it can't be undone", 'tutor'); ?></p>
                <div class="tutor-modal-button-group">
                    <form action="" id="tutor-dashboard-delete-element-form">
                        <input type="hidden" name="action" value="tutor_delete_dashboard_course">
                        <input type="hidden" name="course_id" id="tutor-dashboard-delete-element-id" value="">
                        <button type="button" class="tutor-modal-btn-cancel"><?php _e('Cancel', 'tutor') ?></button>
                        <button type="submit" class="tutor-danger tutor-modal-element-delete-btn"><?php _e('Yes, Delete Course', 'tutor') ?></button>
                    </form>
                </div>
            </div>
            
        </div> <!-- tutor-frontend-modal-content -->
    </div> <!-- tutor-frontend-modal -->
    <div class="alertmodal tutor-frontend-modal" data-popup-rel="#tutor-course-alert" style="display: none">
        <div class="tutor-frontend-modal-overlay"></div>
        <div class="tutor-frontend-modal-content">
            <button class="tm-close tutor-icon-line-cross"></button>
			 <div class="tutor-modal-body tutor-course-alert-popup tutor-course-delete-popup">
                
                <h3><?php _e('Alert Students', 'tutor'); ?></h3>
                <div class="tutor-modal-button-group">
                    <form action="" id="tutor-dashboard-alert-element-form">
						<textarea id="alertcontent" style="margin-bottom:30px;" name="message"></textarea>
                        <input type="hidden" name="id" id="tutor-course-alert-id" value="">
                        <button type="button" class="tutor-modal-btn-cancel"><?php _e('Cancel', 'tutor') ?></button>
                        <button type="button" class="successgreen tutor-danger tutor-alertmessage tutor-modal-element-delete-btn"><?php _e('Submit', 'tutor') ?></button> 
                        <button type="button" class="required tutor-danger tutor-alertmessage tutor-modal-element-delete-btn"><?php _e('Remove Alert', 'tutor') ?></button> 
                    </form>
                </div>
            </div>
           
            
        </div> <!-- tutor-frontend-modal-content -->
    </div>

</div>
<script>
/* jQuery(document).on("click",".alertstudent",function(e){
	e.preventDefault();
	var id = jQuery(this).attr("data-id");
	jQuery.ajax({
				url: '/alert_class_student.php/',
				type: 'POST',
				data: {id:id},
				success: function(response) {
					console.log(response);
				}
			});
	
	
	
}) */
jQuery(document).on('click', '.tutor-dashboard-element-alert-btn', function (e) {
        e.preventDefault();
        var course_id = jQuery(this).attr('data-id');
        var course_content = jQuery(this).attr('data-content');
        jQuery('#tutor-course-alert-id').val(course_id);
        jQuery('#alertcontent').val(course_content);
    });
	jQuery(document).on("click",".successgreen.tutor-alertmessage",function(e){
		e.preventDefault();

		submitform("successgreen");
	})
	jQuery(document).on("click",".required.tutor-alertmessage",function(e){
		e.preventDefault();
		jQuery('#alertcontent').val("");
		submitform("required");
	})
    function submitform($type){
        
        var course_id = jQuery('#tutor-course-alert-id').val();
		
		var $btn = jQuery("."+$type);
		
        var data = jQuery('#tutor-dashboard-alert-element-form').serialize();

        jQuery.ajax({
				url: '/alert_class_student.php/',
				type: 'POST',
				data: data,
				beforeSend: function () {
						$btn.addClass('updating-icon');
					},
				success: function(response) {
					
					//alert(response);
					if(response == "success"){
						jQuery('.tutor-frontend-modal').hide();
						$btn.removeClass('updating-icon');
						jQuery(".tutor-course-alert-popup textarea").val();
						window.location.reload(true);

					}
					else{
						jQuery(".tutor-course-alert-popup").append("<div class='required'>Something went wrong!</div>")
					}
				}
			});
    }
</script>