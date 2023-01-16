<?php
/**
 * Sales History
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
?>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
<?php
 global $wpdb,$woocommerce; 
	$user_id = get_current_user_id();
	
	$query = new WC_Order_Query( array(
		'orderby' => 'date',
		'order' => 'DESC',
		'return' => 'ids',
		'posts_per_page' => '-1'
	) );

$orders = $query->get_orders();
?>

<table id="example1" class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
	<thead>
		<tr>
			<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Order#</span></th>
			<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Billing Address</span></th>
			<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Item(s)</span></th>
			<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Date</span></th>
			<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-total"><span class="nobr">Status</span></th>
			<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions"><span class="nobr">Total</span></th>
		</tr>
	</thead>
	<tbody>
	<?php
foreach($orders as $order_id){
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data(); // The Order data
	
foreach ($order->get_items() as $item_key => $item_values): 

			$item_id = $item_values->get_id();
			## Access Order Items data properties (in an array of values) ##
			$item_data = $item_values->get_data();
			$product_name = $item_data['name'];
			$product_id = $item_data['product_id'];
			$author_id = get_post_field ('post_author', $product_id);
			$variation_id = $item_data['variation_id'];
			$quantity = $item_data['quantity'];
			$tax_class = $item_data['tax_class'];
			$line_subtotal = $item_data['subtotal'];
			$line_subtotal_tax = $item_data['subtotal_tax'];
			$line_total = $item_data['total'];
			$line_total_tax = $item_data['total_tax'];
			$linetotal =  $order->get_item_meta($item_id, '_line_total', true);
			
			if($user_id == $author_id){
		?>
		<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-completed order">
			<td class="woocommerce-orders-table__cell"><?php echo $order_id = '#'.$order_data['id']; ?></td>
			<td class="woocommerce-orders-table__cell" width="250"><?php echo $order->get_billing_first_name().' '.$order->get_billing_last_name().'<br/>'.$order->get_billing_address_1().'<br/>';
			if($order->get_billing_address_2()){
			echo $order->get_billing_address_2().'<br/>';
			}
			echo $order->get_billing_state().'&nbsp;&nbsp;'.$order->get_billing_country().'<br/>'.$order->get_billing_postcode().'<br/>'.'<b>Email: </b>'.$order->get_billing_email().'<br/>'.'<b>Phone: </b>'.$order->get_billing_phone().'<br/>'.'<b>Payment Method: </b>'.$order_data['payment_method_title'].'<br/>'; ?></td>
			<td class="woocommerce-orders-table__cell"><?php echo $product_name.' x '.$quantity;  ?></td>
			<td class="woocommerce-orders-table__cell"><?php echo  $order_data['date_created']->date('Y-m-d H:i:s'); ?></td>
			<td class="woocommerce-orders-table__cell"><?php echo $order_data['status']; ?></td>
			<td class="woocommerce-orders-table__cell"><?php echo get_woocommerce_currency_symbol().'&nbsp;'.number_format($linetotal,2); ?></td>
			
		</tr>
		
			<?php }
		
		endforeach; }	?>
	</tbody>
</table>
<script>
jQuery(document).ready( function($){
    $('#example').DataTable( {
        "pagingType": "full_numbers"
    } );
});
</script>