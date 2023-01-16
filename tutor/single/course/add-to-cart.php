<?php

/**
 * Display single course add to cart
 *
 * @since v.1.0.0
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) )
	exit;
$isLoggedIn = is_user_logged_in();

$monetize_by = tutils()->get_option('monetize_by');
$enable_guest_course_cart = tutor_utils()->get_option('enable_guest_course_cart');

$is_purchasable = tutor_utils()->is_course_purchasable();

$required_loggedin_class = '';
if ( ! $isLoggedIn){
	$required_loggedin_class = apply_filters('tutor_enroll_required_login_class', 'cart-required-login');
}
if ($is_purchasable && $monetize_by === 'wc' && $enable_guest_course_cart){
	$required_loggedin_class = '';
}

$tutor_form_class = apply_filters( 'tutor_enroll_form_classes', array(
	'tutor-enroll-form',
) );

$tutor_course_sell_by = apply_filters('tutor_course_sell_by', null);

do_action('tutor_course/single/add-to-cart/before');
$product_id = tutor_utils()->get_course_product_id();
?>

<div class="tutor-single-add-to-cart-box <?php echo $required_loggedin_class; ?> ">
	<?php
	if ($is_purchasable && $tutor_course_sell_by){ ?>
		<div class="btn-wrap">
			<a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart buy-btn" data-product_id="<?php echo $product_id; ?>" data-product_sku="" aria-label="Add Test to your cart" rel="nofollow"><i class="tutor-icon-shopping-cart"></i> Add to cart</a>
		</div>
	<?php }else{
		?>
		<form class="<?php echo implode( ' ', $tutor_form_class ); ?>" method="post">
			<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
			<input type="hidden" name="tutor_course_id" value="<?php echo get_the_ID(); ?>">
			<input type="hidden" name="tutor_course_action" value="_tutor_course_enroll_now">

			<div class=" tutor-course-enroll-wrap buy-btn">
				<button type="submit" class="tutor-btn-enroll tutor-btn tutor-course-purchase-btn buy-btn">
					<?php _e('Enroll Now', 'tutor'); ?>
				</button>
			</div>
		</form>

	<?php } ?>
</div>

<?php do_action('tutor_course/single/add-to-cart/after'); ?>
