<?
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<? do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<? echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<? do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>
<div class="btn-wrap">
		<? if( has_term(20, 'product_cat' ) ) { ?>
			<button type="submit" name="add-to-cart" value="<? echo esc_attr( $product->get_id() ); ?>" class="single_ondemand_add_to_cart_button buy-btn button alt">Buy All</button>
		<? } else { ?>
		<button type="submit" name="add-to-cart" value="<? echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button buy-btn button alt"><? echo esc_html( $product->single_add_to_cart_text() ); ?></button>
		<? } ?>
		<? 
		$downloadable = get_post_meta( $product->get_id(), '_downloadable', true);
		if($downloadable != "yes"){ 
			echo '<span style="color:red;margin-left:10px;font-style:14px;">This price includes shipping fees.</span>'; 
		} ?>
		</div>

		<? do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<? do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<? endif; ?></div>
