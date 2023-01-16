<?
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>

<h2><? _e('Purchase History', 'tutor'); ?></h2>

<?
global $wpdb;
$user_id = get_current_user_id();
$order_statuses = array('wc-on-hold', 'wc-processing', 'wc-completed');

## ==> Define HERE the customer ID
$customer_user_id = get_current_user_id(); // current user ID here for example

// Getting current customer orders
$orders = wc_get_orders( array(
    'meta_key' => '_customer_user',
    'meta_value' => $customer_user_id,
    'post_status' => $order_statuses,
    'numberposts' => -1
) );

//$orders = tutor_utils()->get_orders_by_user_id();

if (tutor_utils()->count($orders)){
	?>
    <div class="responsive-table-wrap">
        <table>
            <tr>
                <th><? _e('ID', 'tutor'); ?></th>
                <th><? _e('Title', 'tutor'); ?></th>
                <th><? _e('Amount', 'tutor'); ?></th>
                <th><? _e('Status', 'tutor'); ?></th>
                <th><? _e('Date', 'tutor'); ?></th>
            </tr>
            <?
            foreach ($orders as $order){
                $wc_order = wc_get_order($order->ID);
                ?>
                <tr>
                    <td>#<? echo $order->ID; ?></td>
                    <td>
                        <?
                        $order_items = $order->get_items();
							$item = "";
						 foreach ($order_items as $items_key => $items_value) {  
								   $item .= " ".$items_value['name'].","; 
						   }
						   $item = rtrim($item,",");
						   echo  $item;
                        ?>
                    </td>
                    <td><? echo tutor_utils()->tutor_price($wc_order->get_total()); ?></td>
                    <td><? echo tutor_utils()->order_status_context($order->post_status); ?></td>

                    <td>
                        <? echo date_i18n(get_option('date_format'), strtotime($order->post_date)) ?>
                    </td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>

	<?
}else{
	echo _e('No purchase history available', 'tutor');
}
do_action( 'woocommerce_after_account_orders', $has_orders );  ?>

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