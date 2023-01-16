<?
/**
 * My Own reviews
 *
 * @since v.1.1.2
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

$per_page = tutils()->get_option('pagination_per_page', 20);
$current_page = max( 1, tutor_utils()->avalue_dot('current_page', $_GET) );
$offset = ($current_page-1)*$per_page;

$reviews = tutor_utils()->get_reviews_by_instructor(get_current_user_id(), $offset, $per_page);
?>

    <div class="tutor-dashboard-content-inner">
		<?
		if (current_user_can(tutor()->instructor_role)){
			?>
            <div class="tutor-dashboard-inline-links">
                <ul>
                   
                    <li class="active"><a><? _e('Received', 'tutor'); ?></a></li>
                </ul>
            </div>
		<? } ?>

        <div class="tutor-dashboard-reviews-wrap">

			<?
			if ($reviews->count){
				?>
                <div class="tutor-dashboard-reviews">
                    <p class="tutor-dashboard-pagination-results-stats">
						<?
						echo sprintf(__('Showing results %d to %d out of %d', 'tutor'), $offset +1, min($reviews->count, $offset +1+tutor_utils()->count($reviews->results)), $reviews->count) ;
						?>
                    </p>

					<?
					foreach ($reviews->results as $review){
						$profile_url = tutor_utils()->profile_url($review->user_id);
						?>
                        <div class="tutor-dashboard-single-review tutor-review-<? echo $review->comment_ID; ?>">
                            <div class="tutor-dashboard-review-header">

                                <div class="tutor-dashboard-review-heading">
                                    <div class="tutor-dashboard-review-title">
										<? _e('Course: ', 'tutor'); ?>
                                        <a href="<? echo get_the_permalink($review->comment_post_ID); ?>"><? echo get_the_title($review->comment_post_ID); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="individual-dashboard-review-body">
                                <div class="individual-star-rating-wrap">
									<? tutor_utils()->star_rating_generator($review->rating); ?>
                                    <p class="review-meta"><?  echo sprintf(__('%s ago', 'tutor'), human_time_diff(strtotime($review->comment_date)));  ?></p>
                                </div>

								<? echo wpautop(stripslashes($review->comment_content)); ?>
                            </div>
                        </div>
						<?
					}
					?>
                </div>
			<? }else{
				?>
                <div class="tutor-dashboard-content-inner">
                    <p><? _e("Sorry, but you are looking for something that isn't here." , 'tutor'); ?></p>
                </div>
				<?
			} ?>

        </div>
    </div>

<?
if ($reviews->count){
	?>
    <div class="tutor-pagination">
		<?
		echo paginate_links( array(
			'format' => '?current_page=%#%',
			'current' => $current_page,
			'total' => ceil($reviews->count/$per_page)
		) );
		?>
    </div>
	<?
}