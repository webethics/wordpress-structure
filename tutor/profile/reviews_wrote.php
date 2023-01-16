<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

$enable_show_reviews_wrote = tutor_utils()->get_option('students_own_review_show_at_profile');
if ( ! $enable_show_reviews_wrote){
    return;
}

$user_name = sanitize_text_field(get_query_var('tutor_student_username'));

$get_user = tutor_utils()->get_user_by_login($user_name);

$user_id = $get_user->ID;

/** 
	Get User Role By ID
**/

$user = get_userdata( $user_id );

$user_roles = $user->roles;

global $post,$wpdb;


$args = array(
    'author'        =>  $user_id, // I could also use $user_ID, right?
    'orderby'       =>  'post_date',
    'order'         =>  'ASC' ,
	'post_type' 	=> 'courses',
	'numberposts'	=> -1,
	'post_status'	=> 'any'
    );



$current_user_posts = get_posts( $args );

$array_comments = array();

foreach($current_user_posts as $finaldata){
	
	$array_commentss = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID =".$finaldata->ID." AND comment_type='tutor_course_rating'");
	foreach($array_commentss as $array_comment){
		if(!empty($array_comment)){
			$array_comments[] = $array_comment;
		}
	}
}

array_multisort(array_column($array_comments, 'comment_date'),SORT_DESC,$array_comments);

$reviews = tutor_utils()->get_reviews_by_user($user_id);


?>

<div class=" tutor-course-reviews-wrap">
    <div class="course-target-reviews-title">
	<?php if ( in_array( 'tutor_instructor', $user_roles, true ) ) { ?>
        <h4><?php echo sprintf(__('Reviews', 'tutor')); ?></h4>
	<?php }else{ ?>
		<h4><?php echo sprintf(__('Reviews wrote by %s ', 'tutor'), $get_user->display_name); ?></h4>
	<?php } ?> 
    </div>
	
    <div class="tutor-reviews-list">
		<?php
		if ( in_array( 'tutor_instructor', $user_roles, true ) ) { 
			if ( ! is_array($array_comments) || ! count($array_comments)){ ?>
				<div>
					<h2><?php _e("No Reviews Added" , 'tutor'); ?></h2>
					<p><?php _e("There is no reviews added for this instrcutor" , 'tutor'); ?></p>
				</div>
				<?php
				return;
			}
			foreach ($array_comments as $review){
				
				$new_user = get_userdata($review->user_id);
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
				
				$profile_url = tutor_utils()->profile_url($review->user_id);
				?>
				<div class="tutor-review-individual-item tutor-review-<?php echo $review->comment_ID; ?>">
					<div class="review-left">
						<div class="review-avatar">
								<?php echo tutor_utils()->get_tutor_avatar($review->user_id); ?>
						</div>

						<div class="review-time-name">

							<p> <?php echo $full_name; ?></p>
							<p class="review-meta">
								<?php echo sprintf(__('%s ago', 'tutor'), human_time_diff(strtotime($review->comment_date))) ?>
							</p>
						</div>
					</div>

					<div class="review-content review-right">

						<div class="individual-review-course-name">
							<?php _e('On', 'tutor'); ?>
							<a href="<?php echo get_the_permalink($review->comment_post_ID); ?>"><?php echo get_the_title
							($review->comment_post_ID);
							?></a>
						</div>

						<div class="individual-review-rating-wrap">
						
							<?php 
							
							$rating = get_comment_meta($review->comment_ID,"tutor_rating",true);
							tutor_utils()->star_rating_generator($rating); ?>
						</div>
						<?php echo wpautop($review->comment_content); ?>
					</div>
				</div>
				<?php
			}
		}
		else{
			if ( ! is_array($reviews) || ! count($reviews)){ ?>
				<div>
					<h2><?php _e("No Reviews Added" , 'tutor'); ?></h2>
					<p><?php _e("There is no reviews added for this instrcutor" , 'tutor'); ?></p>
				</div>
				<?php
				return;
			}
			foreach ($reviews as $review){
				$profile_url = tutor_utils()->profile_url($review->user_id);
				?>
				<div class="tutor-review-individual-item tutor-review-<?php echo $review->comment_ID; ?>">
					<div class="review-left">
						<div class="review-avatar">
							<a href="<?php echo $profile_url; ?>">
								<?php echo tutor_utils()->get_tutor_avatar($review->user_id); ?>
							</a>
						</div>

						<div class="review-time-name">

							<p> <a href="<?php echo $profile_url; ?>">  <?php echo $review->display_name; ?> </a> </p>
							<p class="review-meta">
								<?php echo sprintf(__('%s ago', 'tutor'), human_time_diff(strtotime($review->comment_date))) ?>
							</p>
						</div>
					</div>

					<div class="review-content review-right">

						<div class="individual-review-course-name">
							<?php _e('On', 'tutor'); ?>
							<a href="<?php echo get_the_permalink($review->comment_post_ID); ?>"><?php echo get_the_title
							($review->comment_post_ID);
							?></a>
						</div>

						<div class="individual-review-rating-wrap">
							<?php tutor_utils()->star_rating_generator($review->rating); ?>
						</div>
						<?php echo wpautop($review->comment_content); ?>
					</div>
				</div>
				<?php
			}
		}
		?>
    </div>
</div>