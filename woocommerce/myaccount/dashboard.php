<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;

 $userid = get_current_user_id();
$earning_sum = get_user_earning_sum($userid);

	 $args = Array(									//filter for the get_posts() function
		'author' => wp_get_current_user()->ID,
		'post_type'=> 'product',		
		'post_status'=> array('publish','pending'),		
		'order'     =>  'ASC',
		'orderby'   => 'meta_value_num',
		'meta_key'  => '_price',
		'posts_per_page' => $post_per_page,
		'paged' => $paged,		
		 'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => array( 20,33 ),
				'operator' => 'NOT IN',
			),
		),
	); 
	
	$user_posts = get_posts($args);		
	$count_products = count($user_posts);
	
	
?>
<h3 class="add_logout">Dashboard<!--a class="tutor-btn bordered-btn" href="<?php echo esc_url( wc_logout_url() ); ?>">Log Out</a-->
</h3>
<!--p>
	<?php
	//printf(
	//	/* translators: 1: user display name 2: logout url */
		//__( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ),
		//'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
		//esc_url( wc_logout_url() )
	//);
	?>
</p-->

<p>
	<?php
	printf(
		__( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
	?>
</p>
<div class="tutor-dashboard-content-inner">

		
    <div class="tutor-dashboard-info-cards">
			            <div class="tutor-dashboard-info-card">
                <p>
                   <a href="/manage-products/" style="color:#fff;"> <span>Total items for sale</span>
                    <span class="tutor-dashboard-info-val"><?php echo $count_products; ?></span></a>
                </p>
            </div>
        
            <div class="tutor-dashboard-info-card">
                <p>
                    <a href="/user-account/earnings/" style="color:#fff;"> <span>Total Earnings</span>
                    <span class="tutor-dashboard-info-val"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span><?php echo tutor_utils()->tutor_price($earning_sum->user_amount); ?></span></span></a>
                </p>
            </div>
		    </div>

	    
	
</div>
<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
