<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>

<h3><?php _e('Completed Course', 'tutor'); ?></h3>

<div class="tutor-dashboard-content-inner">

    <div class="tutor-dashboard-inline-links">
        <ul>
            <li><a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses'); ?>"> <?php _e('All Courses', 'tutor'); ?></a> </li>
            <li><a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses/active-courses'); ?>"> <?php _e('Active Courses', 'tutor'); ?> </a> </li>
            <li class="active"><a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('enrolled-courses/completed-courses'); ?>">
                    <?php _e('Completed Courses', 'tutor'); ?> </a> </li>
        </ul>
    </div>

	<?php
	global $wpdb;
	$completed_courses = tutor_utils()->get_courses_by_user();
	$current_user = wp_get_current_user();
	if ($completed_courses && $completed_courses->have_posts()):
		while ($completed_courses->have_posts()):
			$completed_courses->the_post();

            $avg_rating = tutor_utils()->get_course_rating()->rating_avg;
            $tutor_course_img = get_tutor_course_thumbnail_src();
			$course_id = get_the_ID();
			$userID = $current_user->ID;
			
			$getEnrolledInfo = $wpdb->get_row( "select ID, post_author, post_date,post_date_gmt,post_title from {$wpdb->posts} WHERE post_type = 'tutor_enrolled' AND post_parent = {$course_id} AND post_author = {$userID} AND post_status = 'completed'; " );  
			
			$count = count($getEnrolledInfo);
			if($count > 0){
            ?>
            <div class="tutor-mycourse-wrap tutor-mycourse-<?php the_ID(); ?>">


                <div class="tutor-mycourse-thumbnail" style="background-image: url(<?php echo esc_url($tutor_course_img); ?>)"></div>

                <div class="tutor-mycourse-content">

                    <div class="tutor-mycourse-rating">
                        <?php
                        tutor_utils()->star_rating_generator($avg_rating);
                        ?>
                        <a href="<?php echo get_the_permalink().'#single-course-ratings'; ?>"><?php _e('Leave a rating', 'tutor') ?></a>
						<?php do_action('tutor_enrolled_box_after') ?>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3>
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
                        </ul>
                    </div>
                    <?php tutor_course_completing_progress_bar(); ?>
                </div>

            </div>

			<?php
			}
		endwhile;

		wp_reset_postdata();

	else:
        echo "<div class='tutor-mycourse-wrap'><div class='tutor-mycourse-content'>".__('There\'s no completed course', 'tutor')."</div></div>";
	endif;

	?>
</div>
