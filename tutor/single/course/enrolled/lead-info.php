<?
/**
 * Template for displaying lead info
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.5
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

global $wp_query;
global $post, $authordata, $wpdb;

$profile_url = tutor_utils()->profile_url($authordata->ID);
?>
<div class="tutor-single-course-segment tutor-single-course-lead-info">

	<?
	$disable = get_tutor_option('disable_course_review');
	if ( ! $disable){
		?>
        <div class="tutor-leadinfo-top-meta">
            <span class="tutor-single-course-rating">
            <?
            $course_rating = tutor_utils()->get_course_rating();
            tutor_utils()->star_rating_generator($course_rating->rating_avg);
            ?>
                <span class="tutor-single-rating-count">
                    <?
                    echo $course_rating->rating_avg;
                    echo '<i>('.$course_rating->rating_count.')</i>';
                    ?>
                </span>
            </span>
        </div>
	<? } ?>

    <h1 class="tutor-course-header-h1"><? the_title(); ?></h1>

	<? do_action('tutor_course/single/title/after'); ?>
	<? do_action('tutor_course/single/lead_meta/before'); ?>

    <div class="tutor-single-course-meta tutor-meta-top">
        <?
            $disable_course_author = get_tutor_option('disable_course_author');
            $disable_course_level = get_tutor_option('disable_course_level');
            $disable_course_share = get_tutor_option('disable_course_share');
        ?>
        <ul>
            <? if ( !$disable_course_author){ ?>
                <li class="tutor-single-course-author-meta">
                    <div class="tutor-single-course-avatar">
                        <a href="<? echo $profile_url; ?>"> <? echo tutor_utils()->get_tutor_avatar($post->post_author); ?></a>
                    </div>
                    <div class="tutor-single-course-author-name">
                        <span><? _e('by', 'tutor'); ?></span>
                        <a href="<? echo tutor_utils()->profile_url($authordata->ID); ?>"><? echo get_the_author(); ?></a>
                    </div>
                </li>
            <? } ?>

            <? if ( !$disable_course_level){ ?>
                <li class="tutor-course-level">
                    <span><? _e('Course level:', 'tutor'); ?></span>
                    <? echo get_tutor_course_level(); ?>
                </li>
            <? } ?>

            <? if ( !$disable_course_share){ ?>
                <li class="tutor-social-share">
                    <span><? _e('Share:', 'tutor'); ?></span>
                    <? tutor_social_share(); ?>
                </li>
            <? } ?>
        </ul>

    </div>


    <div class="tutor-single-course-meta tutor-lead-meta">
        <ul>
			<?
			$course_categories = get_tutor_course_categories();
			if(is_array($course_categories) && count($course_categories)){
				?>
                <li>
                    <span><? esc_html_e('Categories', 'tutor') ?></span>
					<?
					foreach ($course_categories as $course_category){
						$category_name = $course_category->name;
						$category_link = get_term_link($course_category->term_id);
						echo "<a href='$category_link'>$category_name</a>";
					}
					?>
                </li>
			<? } ?>

			<?
			$disable_course_duration = get_tutor_option('disable_course_duration');
            $disable_total_enrolled = get_tutor_option('disable_course_total_enrolled');
            $disable_update_date = get_tutor_option('disable_course_update_date');
            $course_duration = get_tutor_course_duration_context();
            
			if( !empty($course_duration) && !$disable_course_duration){ ?>
                <li>
                    <span><? esc_html_e('Duration', 'tutor') ?></span>
                    <? echo $course_duration; ?>
                </li>
            <? }
            
            if( !$disable_total_enrolled){ ?>
                <li>
                    <span><? esc_html_e('Total Enrolled', 'tutor') ?></span>
                    <? echo (int) tutor_utils()->count_enrolled_users_by_course(); ?>
                </li>
            <? } 

            if( !$disable_update_date){ ?>
                <li>
                    <span><? esc_html_e('Last Update', 'tutor') ?></span>
                    <? echo esc_html(get_the_modified_date()); ?>
                </li>
            <? } ?>
        </ul>
    </div>

    <div class="tutor-course-enrolled-info">
		<? $count_completed_lesson = tutor_course_completing_progress_bar(); ?>
		<? $liveclass = get_post_meta(get_the_ID(),'_insert_meeting_zoom_meeting_id',true);
		
				
				if($liveclass != ""){
					$i = 1;
					foreach($liveclass as $results){
						$post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $results ."')");
						$start_date = get_post_meta($post_id,'_meeting_date',true);
						$class_date = date('Y-m-d',strtotime($start_date));
						$blogtime = date("Y-m-d"); 

						if($class_date == $blogtime){
							echo do_shortcode('[zoom_api_link meeting_id="'.$results.'" link_only="no"]');
						}
						else{
							echo $i." Next Live Class starts: ".$start_date." (your local time)<br>";
						}
					$i++;
					}
				}
		?>
        <!--<div class="tutor-lead-info-btn-group">
			<?
		/*			if ( $wp_query->query['post_type'] !== 'lesson') {
						$lesson_url = tutor_utils()->get_course_first_lesson();
						if ( $lesson_url ) {
							*/?>
                    <a href="<? /*echo $lesson_url; */?>" class="tutor-button"><? /*_e( 'Continue to lesson', 'tutor' ); */?></a>
                <? /*}
            }
            */?>
            <? /*tutor_course_mark_complete_html(); */?>
        </div>-->
    </div>

	<? do_action('tutor_course/single/lead_meta/after'); ?>
	<? do_action('tutor_course/single/excerpt/before'); ?>

	<?
    $excerpt = tutor_get_the_excerpt();
    $disable_about = get_tutor_option('disable_course_about');
	if (! empty($excerpt) && ! $disable_about){
		?>
        <div class="tutor-course-summery">
            <h4  class="tutor-segment-title"><? esc_html_e('About Course', 'tutor') ?></h4>
			<? echo $excerpt; ?>
        </div>
		<?
	}
	?>

	<? do_action('tutor_course/single/excerpt/after'); ?>

</div>