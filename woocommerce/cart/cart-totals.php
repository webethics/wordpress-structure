<?
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <? echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<? do_action( 'woocommerce_before_cart_totals' ); ?>

	<h3 class="heading"><? esc_html_e( 'Cart totals', 'woocommerce' ); ?></h3>

	<table cellspacing="0" class="shop_table shop_table_responsive">

		<tr class="cart-subtotal">
			<th class="cart-head"><? esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td class="cart-data" data-title="<? esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><? wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<? foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<? echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><? wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td data-title="<? echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><? wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<? endforeach; ?>

		<? if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<? do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<? wc_cart_totals_shipping_html(); ?>

			<? do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<? elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

			<tr class="shipping">
				<th><? esc_html_e( 'Shipping', 'woocommerce' ); ?></th>
				<td data-title="<? esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><? woocommerce_shipping_calculator(); ?></td>
			</tr>

		<? endif; ?>

		<? foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><? echo esc_html( $fee->name ); ?></th>
				<td data-title="<? echo esc_attr( $fee->name ); ?>"><? wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<? endforeach; ?>

		<?
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				/* translators: %s location. */
				$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
					?>
					<tr class="tax-rate tax-rate-<? echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><? echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
						<td data-title="<? echo esc_attr( $tax->label ); ?>"><? echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
					<?
				}
			} else {
				?>
				<tr class="tax-total">
					<th><? echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
					<td data-title="<? echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><? wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
				<?
			}
		}
		?>

		<? do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<tr class="order-total">
			<th><? esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td data-title="<? esc_attr_e( 'Total', 'woocommerce' ); ?>"><? wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<? do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<div class="wc-proceed-to-checkout">
		<? do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<? do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
