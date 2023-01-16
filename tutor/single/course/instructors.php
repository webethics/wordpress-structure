<?
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
	<h4 class="tutor-segment-title"><? _e('About the instructors', 'tutor'); ?></h4>

	<div class="tutor-course-instructors-wrap tutor-single-course-segment" id="single-course-ratings">
		<?
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
                            <a href="<? echo $profile_url; ?>">
                                <? echo tutor_utils()->get_tutor_avatar($instructor->ID); ?>
                            </a>
                        </div>

                        <div class="instructor-name">
                            <h3><a href="<? echo $profile_url; ?>"><? echo $full_name; ?></a> </h3>
                            <?
                            if ( ! empty($instructor->tutor_profile_job_title)){
                                echo "<h4>{$instructor->tutor_profile_job_title}</h4>";
                            }
                            ?>
                        </div>
						<div class="tutor-single-course">
							<ul class="tutor-dashboard-permalinks">
								<li class="tutor-dashboard-menu-bio active"><a href="<? echo $profile_url; ?>">Bio</a></li>
								<li class="tutor-dashboard-menu-reviews_wrote"><a href="<? echo $profile_url; ?>/reviews_wrote"> Reviews Written </a> </li>                        
							</ul>
						</div>
                    </div>
					<div class="instructor-bio">
						<? echo $instructor->tutor_profile_bio ?>
					</div>
				</div>

                <?
                $instructor_rating = tutor_utils()->get_instructor_ratings($instructor->ID);
                ?>

				<div class="single-instructor-bottom">
					<div class="ratings">
						<span class="rating-generated">
							<? tutor_utils()->star_rating_generator($instructor_rating->rating_avg); ?>
						</span>

						<?
						echo " <span class='rating-digits'>{$instructor_rating->rating_avg}</span> ";
						echo " <span class='rating-total-meta'>({$instructor_rating->rating_count} ".__('ratings', 'tutor').")</span> ";
						?>
					</div>

					<div class="courses">
						<p>
							<i class='tutor-icon-mortarboard'></i>
							<? echo tutor_utils()->get_course_count_by_instructor($instructor->ID); ?> <span class="tutor-text-mute"> <? _e('Courses', 'tutor'); ?></span>
						</p>
					</div>

					<div class="students">
						<?
						$total_students = tutor_utils()->get_total_students_by_instructor($instructor->ID);
						?>

						<p>
							<i class='tutor-icon-user'></i>
							<? echo $total_students; ?>
							<span class="tutor-text-mute">  <? _e('students', 'tutor'); ?></span>
						</p>
					</div>
				</div>
			</div>
			<?
		}
		?>
	</div>
	<?
}

do_action('tutor_course/single/enrolled/after/instructors');
