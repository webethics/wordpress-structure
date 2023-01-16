<?
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
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

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<? if ( $has_orders ) : ?>
<h2><? echo apply_filters( 'woocommerce_my_account_my_orders_title', esc_html__( 'Recent orders', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
	<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<thead>
			<tr>
				<? foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<? echo esc_attr( $column_id ); ?>"><span class="nobr"><? echo esc_html( $column_name ); ?></span></th>
				<? endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?
			foreach ( $customer_orders->orders as $customer_order ) {
				$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
				$item_count = $order->get_item_count() - $order->get_item_count_refunded();
				?>
				<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<? echo esc_attr( $order->get_status() ); ?> order">
					<? foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<? echo esc_attr( $column_id ); ?>" data-title="<? echo esc_attr( $column_name ); ?>">
							<? if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<? do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

							<? elseif ( 'order-number' === $column_id ) : ?>
								<a href="<? echo esc_url( $order->get_view_order_url() ); ?>">
									<? echo esc_html( _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number() ); ?>
								</a>

							<? elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<? echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><? echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

							<? elseif ( 'order-status' === $column_id ) : ?>
								<? echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

							<? elseif ( 'order-total' === $column_id ) : ?>
								<?
								/* translators: 1: formatted order total 2: total order items */
								echo wp_kses_post( sprintf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
								?>

							<? elseif ( 'order-actions' === $column_id ) : ?>
								<?
								$actions = wc_get_account_orders_actions( $order );

								if ( ! empty( $actions ) ) {
									foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
										echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
									}
								}
								?>
							<? endif; ?>
						</td>
					<? endforeach; ?>
				</tr>
				<?
			}
			?>
		</tbody>
	</table>

	<? do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<? if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<? if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<? echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><? esc_html_e( 'Previous', 'woocommerce' ); ?></a>
			<? endif; ?>

			<? if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<? echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><? esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<? endif; ?>
		</div>
	<? endif; ?>

<? else : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<? echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<? esc_html_e( 'Browse products', 'woocommerce' ); ?>
		</a>
		<? esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>
	</div>
<? endif; ?>

<? do_action( 'woocommerce_after_account_orders', $has_orders );  ?>

<h2><? echo apply_filters( 'woocommerce_my_account_my_downloads_title', esc_html__( 'Available downloads', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>

<? $downloads     = WC()->customer->get_downloadable_products();
$has_downloads = (bool) $downloads;

do_action( 'woocommerce_before_account_downloads', $has_downloads ); ?>

<? if ( $has_downloads ) : ?>

	<? do_action( 'woocommerce_before_available_downloads' ); ?>

	<? do_action( 'woocommerce_available_downloads', $downloads ); ?>

	<? do_action( 'woocommerce_after_available_downloads' ); ?>

<? else : ?>
	<div class="woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<? echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<? esc_html_e( 'Browse products', 'woocommerce' ); ?>
		</a>
		<? esc_html_e( 'No downloads available yet.', 'woocommerce' ); ?>
	</div>
<? endif; ?>

<? do_action( 'woocommerce_after_account_downloads', $has_downloads ); ?>

