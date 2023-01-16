<?php
/**
 * Template for displaying course instructors/ instructor
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */



do_action('tutor_course/single/enrolled/before/instructors');

$instructors = tutor_utils()->get_instructors_by_course();

if ($instructors){
	?>
	<h4 class="tutor-segment-title"><?php _e('About the instructors', 'tutor'); ?></h4>

	<div class="tutor-course-instructors-wrap tutor-single-course-segment" id="single-course-ratings">
		<?php
		foreach ($instructors as $instructor){
			$user_id = $instructor->ID;
			$new_user = get_userdata($user_id);
			$fname = $new_user->user_firstname;
			$lname = $new_user->user_lastname;
			$full_name = '';

			if( empty($fname)){
				$full_name = $lname;
			} elseif( empty( $lname )){
				$full_name = $fname;
			} else {
				//both first name and last name are present
				$full_name = "{$fname} {$lname}";
			}
		    $profile_url = tutor_utils()->profile_url($instructor->ID);
			?>
			<div class="single-instructor-wrap">
				<div class="single-instructor-top">
                    <div class="tutor-instructor-left">
                        <div class="instructor-avatar">
                            <a href="<?php echo $profile_url; ?>">
                                <?php echo tutor_utils()->get_tutor_avatar($instructor->ID); ?>
                            </a>
                        </div>

                        <div class="instructor-name">
                            <h3><a href="<?php echo $profile_url; ?>"><?php echo $full_name; ?></a> </h3>
                            <?php
                            if ( ! empty($instructor->tutor_profile_job_title)){
                                echo "<h4>{$instructor->tutor_profile_job_title}</h4>";
                            }
                            ?>
                        </div>
						<div class="tutor-single-course">
							<ul class="tutor-dashboard-permalinks">
								<li class="tutor-dashboard-menu-bio active"><a href="<?php echo $profile_url; ?>">Bio</a></li>
								<li class="tutor-dashboard-menu-reviews_wrote"><a href="<?php echo $profile_url; ?>/reviews_wrote"> Reviews Written </a> </li>                        
							</ul>
						</div>
                    </div>
					<div class="instructor-bio">
						<?php echo $instructor->tutor_profile_bio ?>
					</div>
				</div>

                <?php
                $instructor_rating = tutor_utils()->get_instructor_ratings($instructor->ID);
                ?>

				<div class="single-instructor-bottom">
					<div class="ratings">
						<span class="rating-generated">
							<?php tutor_utils()->star_rating_generator($instructor_rating->rating_avg); ?>
						</span>

						<?php
						echo " <span class='rating-digits'>{$instructor_rating->rating_avg}</span> ";
						echo " <span class='rating-total-meta'>({$instructor_rating->rating_count} ".__('ratings', 'tutor').")</span> ";
						?>
					</div>

					<div class="courses">
						<p>
							<i class='tutor-icon-mortarboard'></i>
							<?php echo tutor_utils()->get_course_count_by_instructor($instructor->ID); ?> <span class="tutor-text-mute"> <?php _e('Courses', 'tutor'); ?></span>
						</p>
					</div>

					<div class="students">
						<?php
						$total_students = tutor_utils()->get_total_students_by_instructor($instructor->ID);
						?>

						<p>
							<i class='tutor-icon-user'></i>
							<?php echo $total_students; ?>
							<span class="tutor-text-mute">  <?php _e('students', 'tutor'); ?></span>
						</p>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}

do_action('tutor_course/single/enrolled/after/instructors');
