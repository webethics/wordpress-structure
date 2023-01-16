<?php
/**
 * Template for displaying course tags
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

do_action('tutor_course/single/before/tags');

$course_tags = get_tutor_course_tags();
if(is_array($course_tags) && count($course_tags)){ ?>
    
<?php
}

do_action('tutor_course/single/after/tags'); ?>