<?php
/**
 * Course Loop Start
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

$courseCols = tutor_utils()->get_option( 'courses_col_per_row', 4 );

?>

<div class="prd-wrap section-wrap">
<div class="container-wrap">
<div class="row-wrap">
	<div class="col-wrap-full"><p class="search_result_wrap">
		<?php
			$courseCount = tutor_utils()->get_archive_page_course_count();
			echo "<p class='search_result_wrap'>{$courseCount} Results based on search criteria:</p>";
			?>
		</p>
	</div>

	<div class="col-wrap-full"><p class="search_result_wrap">
		<div class="tutor-course-archive-filters-wrap">
			<form class="tutor-course-filter-form" method="get">
				<select name="tutor_course_filter">
					<option value="">Sort by:</option>
					<option value="newest_first" <?php if (isset($_GET["tutor_course_filter"]) ? selected("newest_first",$_GET["tutor_course_filter"]) : "" ); ?> ><?php _e("Release Date (newest first)", "tutor");
						?></option>
					<option value="oldest_first" <?php if (isset($_GET["tutor_course_filter"]) ? selected("oldest_first",$_GET["tutor_course_filter"]) : "" ); ?>><?php _e("Release Date (oldest first)", "tutor"); ?></option>
					<option value="course_title_az" <?php if (isset($_GET["tutor_course_filter"]) ? selected("course_title_az",$_GET["tutor_course_filter"]) : "" ); ?>><?php _e("Course Title (a-z)", "tutor"); ?></option>
					<option value="course_title_za" <?php if (isset($_GET["tutor_course_filter"]) ? selected("course_title_za",$_GET["tutor_course_filter"]) : "" ); ?>><?php _e("Course Title (z-a)", "tutor"); ?></option>
				</select>	
			</form>
			
		</div>
	</div>