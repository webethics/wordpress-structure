<?
/**
 * Pay for order form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-pay.php.
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

$totals = $order->get_order_item_totals(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
?>
<form id="order_review" method="post">

	<table class="shop_table">
		<thead>
			<tr>
				<th class="product-name"><? esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-quantity"><? esc_html_e( 'Qty', 'woocommerce' ); ?></th>
				<th class="product-total"><? esc_html_e( 'Totals', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<? if ( count( $order->get_items() ) > 0 ) : ?>
				<? foreach ( $order->get_items() as $item_id => $item ) : ?>
					<?
					if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
						continue;
					}
					?>
					<tr class="<? echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
						<td class="product-name">
							<?
								echo apply_filters( 'woocommerce_order_item_name', esc_html( $item->get_name() ), $item, false ); // @codingStandardsIgnoreLine

								do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

								wc_display_item_meta( $item );

								do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
							?>
						</td>
						<td class="product-quantity"><? echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', esc_html( $item->get_quantity() ) ) . '</strong>', $item ); ?></td><? // @codingStandardsIgnoreLine ?>
						<td class="product-subtotal"><? echo $order->get_formatted_line_subtotal( $item ); ?></td><? // @codingStandardsIgnoreLine ?>
					</tr>
				<? endforeach; ?>
			<? endif; ?>
		</tbody>
		<tfoot>
			<? if ( $totals ) : ?>
				<? foreach ( $totals as $total ) : ?>
					<tr>
						<th scope="row" colspan="2"><? echo $total['label']; ?></th><? // @codingStandardsIgnoreLine ?>
						<td class="product-total"><? echo $total['value']; ?></td><? // @codingStandardsIgnoreLine ?>
					</tr>
				<? endforeach; ?>
			<? endif; ?>
		</tfoot>
	</table>

	<div id="payment">
		<? if ( $order->needs_payment() ) : ?>
			<ul class="wc_payment_methods payment_methods methods">
				<?
				if ( ! empty( $available_gateways ) ) {
					foreach ( $available_gateways as $gateway ) {
						wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
					}
				} else {
					echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', esc_html__( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
				}
				?>
			</ul>
		<? endif; ?>
		<div class="form-row">
			<input type="hidden" name="woocommerce_pay" value="1" />

			<? wc_get_template( 'checkout/terms.php' ); ?>

			<? do_action( 'woocommerce_pay_order_before_submit' ); ?>

			<? echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="r_more_btn" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

			<? do_action( 'woocommerce_pay_order_after_submit' ); ?>

			<? wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
		</div>
	</div>
</form>
