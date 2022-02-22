<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
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

<div class="woocommerce-order">

	<?php
	if ( $order ) :
	global  $woocommerce; 
$authorarray = array();
$sum = 0;
$sum1 = 0;
		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>
		<?php	foreach ( $order->get_items() as $item_id => $item ) {
					$product_id = $item->get_product_id();
					$post_author_id = get_post_field( 'post_author', $product_id );
					array_push($authorarray,$post_author_id);
				}
				array_unique($authorarray);
				foreach($authorarray as $authorID){
					$user_info = get_userdata($authorID);
					$buyer_info = get_userdata($order->get_user_id());
					$user_info->user_email;
					$to = $user_info->user_email;
					$subject = 'New Order Received';
					$body = '<table style="width:100.0%" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td valign="top"><div align="center"><table style="background:white;border:solid #dedede 1px" width="600" cellspacing="0" cellpadding="0"><tbody><tr><td style="border:none;" valign="top"><div align="center"><table style="width:100.0%;background:#96588a" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding:27.0pt .5in 27.0pt .5in"><h1 style="margin:0px;line-height:150%"><span style="font-size:22.5pt;line-height:150%;font-family:&quot;Helvetica&quot;,sans-serif;color:white;font-weight:normal">New Order: #'.$order->get_order_number().'<u></u><u></u></span></h1></td></tr></tbody></table></div></td></tr><tr><td style="border:none;" valign="top"><div align="center"><table style="width:6.25in" width="600" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="background:white;" valign="top"><table style="width:100.0%" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding:.5in .5in 24.0pt .5in" valign="top"><p style="margin-right:0px;margin-bottom:10px;line-height:150%"><span style="font-size:10.5pt;line-height:150%;font-family:&quot;Helvetica&quot;,sans-serif;color:#636363">You’ve received the following order from '.$buyer_info->display_name.':<u></u><u></u></span></p><h2 style="margin-right:0in;margin-bottom:15px;margin-left:0in;line-height:130%"><span style="font-size:13.5pt;line-height:130%;font-family:&quot;Helvetica&quot;,sans-serif;color:#96588a"><span style="color:#96588a;font-weight:normal">'.wp_kses_post( sprintf( __( '[Order #%s]', 'woocommerce' ) . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) ).'</span><u></u><u></u></span></h2>';
					
					
					$body .= '<div style="margin-bottom:30.0pt"><table style="width:100.0%;border:solid #e5e5e5 1.0pt" width="100%" cellspacing="0" cellpadding="0" border="1"><thead><tr><td style="border:solid #e5e5e5 1px;padding:9.0pt 9.0pt 9.0pt 9.0pt"><p class="MsoNormal"><b><span style="font-family:Helvetica,sans-serif;color:#636363">Product<u></u><u></u></span></b></p></td><td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt"><p class="MsoNormal"><b><span style="font-family:Helvetica;,sans-serif;color:#636363">Quantity<u></u><u></u></span></b></p></td><td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt"><p class="MsoNormal"><b><span style="font-family:Helvetica,sans-serif;color:#636363">Price<u></u><u></u></span></b></p></td></tr></thead><tbody>';
			
			foreach ($order->get_items() as $item_id => $item_data) {
				$product_ID = $item_data['product_id'].'<br>';
				$item_author_id = get_post_field( 'post_author', $product_ID );
				$product_name = $item_data['name'];	 
				$item_quantity = $order->get_item_meta($item_id, '_qty', true);
				$item_total = $order->get_item_meta($item_id, '_line_total', true);
				if($item_author_id == $authorID){
					$body .= '<tr><td style="border:solid #e5e5e5 1px;padding:9.0pt 9.0pt 9.0pt 9.0pt;word-wrap:break-word"><p class="MsoNormal"><span style="font-family:Helvetica,sans-serif;color:#636363">'.$product_name.'</span></p>
					</td><td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
					<p class="MsoNormal"><span style="font-family:Helvetica,sans-serif;color:#636363">'.$item_quantity.'<span style="font-family:Helvetica,sans-serif;color:#636363"></span></p></td><td style="border:solid #e5e5e5 1px;padding:9.0pt 9.0pt 9.0pt 9.0pt"><p class="MsoNormal"><span><span style="font-family:Helvetica,sans-serif;color:#636363">'.get_woocommerce_currency_symbol(). ' '.$item_total.'</span></span><span style="font-family:Helvetica,sans-serif;color:#636363">
					</span></p></td></tr>';
					$sum+= $item_total;
					
				}else{
					
					$sum1+= $item_total;
				}
			} 
			
		$item_totals = $order->get_order_item_totals();

			if ( $item_totals ) {
				$i = 0;
				foreach ( $item_totals as $total ) {
					$i++;
					//echo "<pre>";
					//print_r($total);
					if (($total['label'] !== 'Total:') && ($total['label'] !== 'Subtotal:')) {
						// unset($totals['cart_subtotal']  );
				
				$body .= '<tr><td colspan="2" style="border:solid #e5e5e5 1.0px;border-top:solid #e5e5e5 3.0px;padding:9.0pt 9.0pt 9.0pt 9.0pt"><p class="MsoNormal"><b><span style="font-family:Helvetica,sans-serif;color:#636363">'.wp_kses_post( $total['label'] ).'</span></b></p></td><td style="border:solid #e5e5e5 1px;border-top:solid #e5e5e5 3.0px;padding:9.0pt 9.0pt 9.0pt 9.0pt"><p class="MsoNormal"><span><span style="font-family:Helvetica;,sans-serif;color:#636363">'.wp_kses_post( $total['value'] ).'</span></span><span style="font-family:Helvetica,sans-serif;color:#636363"></span></p></td></tr>';
					}
					
				}
				
			}
			if ( $order->get_customer_note() ) {
				
				$body .= '<tr><td colspan="2" style="border:solid #e5e5e5 1.0px;border-top:solid #e5e5e5 3.0px;padding:9.0pt 9.0pt 9.0pt 9.0pt"><p class="MsoNormal"><b><span style="font-family:Helvetica,sans-serif;color:#636363">'.'Note:'.'</span></b></p></td><td style="border:solid #e5e5e5 1px;border-top:solid #e5e5e5 3.0px;padding:9.0pt 9.0pt 9.0pt 9.0pt"><p class="MsoNormal"><span><span style="font-family:Helvetica;,sans-serif;color:#636363">'.wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ).'</span></span><span style="font-family:Helvetica,sans-serif;color:#636363"></span></p></td></tr>';
				
			}
			
			$body .='</tbody></table></div>';
			
			$body .= '<table style="width:100.0%" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="width:50.0%;" width="50%" valign="top"><h2 style="margin-right:0px;margin-bottom:15px;margin-left:0in;line-height:130%"><span style="font-size:13.5pt;line-height:130%;font-family:Helvetica,sans-serif;color:#96588a">Billing address</span></h2><div style="border:solid #e5e5e5 1px;padding:9.0pt 9.0pt 9.0pt 9.0pt"><address><span style="font-family:Helvetica,sans-serif;color:#636363">';
			$body .= $order->billing_first_name.' '.$order->billing_last_name."<br/>";
			if($order->billing_company):
			$body .= $order->billing_company."<br/>";
			endif;
			if($order->billing_address_1):
			$body .= $order->billing_address_1."<br/>";
			endif;
			if($order->billing_address_2):
			$body .= $order->billing_address_2."<br/>";
			endif;
			$body .= $order->billing_city.' '.$order->billing_state.' '. $order->billing_postcode.' '.$order->billing_country."<br/>";
			
			if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : 
			
			$body .= '<a href="mailto:'.$order->get_billing_email().'" target="_blank">'.$order->get_billing_email().'</a><br/>';
			$body .= '<a href="tel:'.$order->get_billing_phone().'" target="_blank"><span style="color:#96588a">'.$order->get_billing_phone().'</span></a> <br/>';
			endif;
			$body .= '</span></address>';
			$body .= '</div></td><td style="width:50.0%;" width="50%" valign="top"><h2 style="margin-right:0px;margin-bottom:15px;margin-left:0in;line-height:130%"><span style="font-size:13.5pt;line-height:130%;font-family:Helvetica,sans-serif;color:#96588a">Shipping address</span></h2><div style="border:solid #e5e5e5 1px;padding:9.0pt 9.0pt 9.0pt 9.0pt"><address><span style="font-family:&quot;Helvetica&quot;,sans-serif;color:#636363">';
			$body .= $order->shipping_first_name.' '.$order->shipping_last_name."<br/>";
			if($order->shipping_company):
			$body .= $order->shipping_company."<br/>";
			endif;
			if($order->shipping_address_1):
			$body .= $order->shipping_address_1."<br/>";
			endif;
			if($order->shipping_address_2):
			$body .= $order->shipping_address_2."<br/>";
			endif;
			$body .= $order->shipping_city.' '.$order->shipping_state.' '.$order->shipping_postcode.' '.$order->shipping_country."</span></address>";
			
			$body .= '</div></td></tr></tbody></table><p style="margin-right:0px;margin-bottom:12.0pt;margin-left:0px;line-height:150%"><span style="font-size:10.5pt;line-height:150%;font-family:Helvetica,sans-serif;color:#636363">Congratulations on the sale.</span></p></td></tr></tbody></table></td></tr></tbody></table></div></td></tr></tbody></table></div></td></tr></tbody></table>';
		
					$headers = array('Content-Type: text/html; charset=UTF-8','From: MyHomeSchoolFamily <info@myhomeschoolfamily.com>');
 
					 wp_mail( $to, $subject, $body, $headers );
					
				} 				
			?>
			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

</div>
