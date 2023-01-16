<?php
/**
 * A single course loop rating
 *
 * @since v.1.0.0
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$classmeetings = get_post_meta(get_the_ID(),"_insert_meeting_zoom_meeting_id",true);
$classCount = count($classmeetings);
$coming = get_post_meta(get_the_ID(),"comingsoon",true);

?>
<div class="class-meeting"><em style="color:#25A9E0;">Class Meetings:</em> <strong><?php if($coming == "coming"){ echo "TBD";}else{echo $classCount;} ?></strong></div>
<div class="rating-wrap">
	Rating:<br>
	<?php
	$course_rating = tutor_utils()->get_course_rating();
	tutor_utils()->star_rating_generator($course_rating->rating_avg);
	?>
    <span class="tutor-rating-count">
        <?php
        if ($course_rating->rating_avg > 0) {
	        echo apply_filters('tutor_course_rating_average', $course_rating->rating_avg);
	        echo '<i>(' . apply_filters('tutor_course_rating_count', $course_rating->rating_count) . ')</i> Reviews';
        }
        ?>
    </span>
</div>

