<?
/**
 * User Reviews
 *
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */
 defined( 'ABSPATH' ) || exit;
 global $wpdb;
 
 $user_id = get_current_user_id();
 $reviews =  wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); 
 
 ?>
 
<div class="tutor-dashboard-content-inner">

	

    <div class="tutor-dashboard-reviews-wrap">
		<?
		if ( ! is_array($reviews) || ! count($reviews)){ ?>
            <div class="tutor-dashboard-content-inner">
                <p><? _e("No Records Found!" , 'tutor'); ?></p>
            </div>
			<?
		}
		?>

        <div class="tutor-dashboard-reviews">
			<?
			foreach ($reviews as $review){
				$profile_url = tutor_utils()->profile_url($review->user_id);
				?>
                <div class="tutor-dashboard-single-review tutor-review-<? echo $review->comment_ID; ?>">
                    <div class="tutor-dashboard-review-header">

                        <div class="tutor-dashboard-review-heading">
                            <div class="tutor-dashboard-review-title">
								<? _e('Course: ', 'tutor'); ?>
                                <a href="<? echo get_the_permalink($review->comment_post_ID); ?>"><? echo get_the_title($review->comment_post_ID); ?></a>
                            </div>

                            <!--div class="tutor-dashboard-review-links">
                                <a href="javascript:;" class="open-tutor-edit-review-modal" data-review-id="<? echo $review->comment_ID; ?>">
                                    <i class="tutor-icon-pencil"></i> <span><? _e('Edit Feedback', 'tutor'); ?></span>
                                </a>
                            </div-->
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
    </div>
</div>

<div class="tutor-modal-wrap tutor-edit-review-modal-wrap">
    <div class="tutor-modal-content">
        <div class="modal-header">
            <div class="modal-title">
                <h1><? _e('Edit Review', 'tutor'); ?></h1>
            </div>
            <div class="modal-close-wrap">
                <a href="javascript:;" class="modal-close-btn"><i class="tutor-icon-line-cross"></i> </a>
            </div>
        </div>
        <div class="modal-container"></div>
    </div>
</div>
