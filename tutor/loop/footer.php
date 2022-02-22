<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>

<div class="tutor-loop-course-footer1 prd-right">
	<div class="prd-right-inner">
		<?php  
			$price_html = '<div class="price-wrap"> Price: '.__('Free', 'tutor').$enroll_btn. '</div>';
			if (tutor_utils()->is_course_purchasable()) {
				$enroll_btn = tutor_course_loop_add_to_cart(false);

				$product_id = tutor_utils()->get_course_product_id($course_id);
				$product    = wc_get_product( $product_id );

				if ( $product ) {
					$price_html = '<div class="price-wrap"> Price: '.$product->get_price_html().$enroll_btn.' </div>';
				}
			}
			echo $price_html;
			do_action('tutor_course/loop/before_rating');
			do_action('tutor_course/loop/rating');
			do_action('tutor_course/loop/after_rating');
		?>
	</div>
</div>
