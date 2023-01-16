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
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

global $post, $authordata;
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

	<? do_action('tutor_course/single/title/before'); ?>
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
                    <strong><? _e('Course level:', 'tutor'); ?></strong>
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
			$course_tag = wp_get_post_terms( get_the_ID(), 'course-tag' , array( 'fields' => 'all' ) );
			if(is_array($course_tag) && count($course_tag)){
				?>
                <li>
                    <span><? esc_html_e('Group', 'tutor') ?></span>
					<?
					foreach ($course_tag as $course_category){
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