<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>

<h3 class="add_logout"><?php _e('Dashboard', 'tutor') ?><a class="tutor-btn bordered-btn" href="<?php echo wp_logout_url('/my-account'); ?>">Log Out</a>
</h3>

<div class="tutor-dashboard-content-inner">

	<?php
	$active_courses = tutor_utils()->get_active_courses_by_user();
	$acative_count = $active_courses->post_count;
	$completed_courses1 = tutor_utils()->get_courses_by_user();
	$enrolled_course = tutor_utils()->get_enrolled_courses_by_user();
	$completed_courses = tutor_utils()->get_completed_courses_ids_by_user();
	$total_students = tutor_utils()->get_total_students_by_instructor(get_current_user_id());
	$my_courses = tutor_utils()->get_courses_by_instructor(get_current_user_id(), 'publish');
	$earning_sum = tutor_utils()->get_earning_sum();

	$enrolled_course_count = $enrolled_course ? $enrolled_course->post_count : 0;
	$completed_course_count = count($completed_courses);
	$active_course_count = $enrolled_course_count - $completed_course_count;
	$user_id = get_current_user_id();
	$user = get_user_by('ID', $user_id);
	$status = get_user_meta($user_id, '_tutor_instructor_status',true);
	?>
	
    <div class="tutor-dashboard-info-cards">
	<?php if(in_array( 'subscriber', (array) $user->roles ) && !in_array( 'tutor_instructor', (array) $user->roles ) && $status == "") :?>
        <div class="tutor-dashboard-info-card">
            <p>
                <span><?php _e('Enrolled Classes', 'tutor'); ?></span>
                <span class="tutor-dashboard-info-val"><?php echo esc_html($enrolled_course_count); ?></span>
            </p>
        </div>
        <div class="tutor-dashboard-info-card">
            <p>
                <span><?php _e('Active Classes', 'tutor'); ?></span>
                <span class="tutor-dashboard-info-val"><?php echo $acative_count ? $acative_count : 0; //echo esc_html($active_course_count); ?></span>
            </p>
        </div>
        <!--div class="tutor-dashboard-info-card">
            <p>
                <span><?php _e('Completed Classes', 'tutor'); ?></span>
                <span class="tutor-dashboard-info-val"><?php echo $completed_courses1->post_count ? $completed_courses1->post_count : 0;   //echo esc_html($completed_course_count); ?></span>
            </p>
        </div-->
		<?php endif; ?>
		<?php
		if(current_user_can(tutor()->instructor_role)) :
			?>
            <div class="tutor-dashboard-info-card">
                <p>
                    <span><?php _e('Total Students', 'tutor'); ?></span>
                    <span class="tutor-dashboard-info-val"><?php echo esc_html($total_students); ?></span>
                </p>
            </div>
            <div class="tutor-dashboard-info-card">
                <p>
                    <span><?php _e('Total Classes', 'tutor'); ?></span>
                    <span class="tutor-dashboard-info-val"><?php echo esc_html(count($my_courses)); ?></span>
                </p>
            </div>
            <div class="tutor-dashboard-info-card">
                <p>
                    <span><?php _e('Total Earnings', 'tutor'); ?></span>
                    <span class="tutor-dashboard-info-val"><?php echo tutor_utils()->tutor_price($earning_sum->instructor_amount); ?></span>
                </p>
            </div>
		<?php
		endif;
		?>
    </div>

	<?php
	$instructor_course = tutor_utils()->get_courses_for_instructors(get_current_user_id());
	if(count($instructor_course)) {
		?>
        <div class="tutor-dashboard-info-table-wrap">
            <h3><?php _e('Most Popular Classes', 'tutor'); ?></h3>
            <table class="tutor-dashboard-info-table">
                <thead>
                <tr>
                    <td><?php _e('Class Name', 'tutor'); ?></td>
                    <td><?php _e('Enrolled', 'tutor'); ?></td>
                    <td><?php _e('Status', 'tutor'); ?></td>
                </tr>
                </thead>
                <tbody>
				<?php
				$instructor_course = tutor_utils()->get_courses_for_instructors(get_current_user_id());
				foreach ($instructor_course as $course){
                    $enrolled = tutor_utils()->count_enrolled_users_by_course($course->ID);
                    $course_status = ($course->post_status == 'publish') ? 'published' : $course->post_status; ?>
                    <tr>
                        <td>
                            <a href="<?php echo get_the_permalink($course->ID); ?>" target="_blank"><?php echo $course->post_title; ?></a>
                        </td>
                        <td><?php echo $enrolled; ?></td>
                        <td>
                            <small class="label-course-status label-course-<?php echo $course->post_status; ?>"> <?php _e($course_status, 'tutor'); ?></small>
                        </td>
                    </tr>
					<?php
				}
				?>
                </tbody>
            </table>
        </div>
	<?php } ?>

</div>