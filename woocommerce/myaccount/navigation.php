<?
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<? 
if ( is_user_logged_in() ) {
    $current_user = wp_get_current_user();
	$sellermessage = get_option("sellermessage");
$allmessage = get_option("allmessage");
    if ( ($current_user instanceof WP_User) ) {
		 $_tutor_instructor_status = get_user_meta( $current_user->ID, '_tutor_instructor_status' , true );
		 
		 
		 if(in_array( 'subscriber',$current_user->roles )){
			 wp_redirect('/my-account/');
		 }
?>
<div class="tutor-row">
	<div class="tutor-col-12">
		<div class="tutor-dashboard-header">
			<div class="tutor-dashboard-header-avatar">
			<? 
				echo '<a href ="/user-account/edit-account/">';
						echo get_avatar( $current_user->ID, 150 ); 
					echo '</a>';
				

				?>
				
			</div> 
			  
			<div class="tutor-dashboard-header-info">
				<div class="tutor-dashboard-header-display-name">
				<? 
						$first_name = get_user_meta( $current_user->ID, 'first_name', true );
						$last_name = get_user_meta( $current_user->ID, 'last_name', true );
				?>
					<h4>Hi, <strong><? echo esc_html( $first_name); ?></strong> </h4>
					<?
						echo '<h5>';
						if($current_user->roles[0] == "customer"){ echo "Seller"; }
						echo '</h5>';
						
					?>
					<? if ( (!(in_array( 'tutor_instructor',$current_user->roles )) && ($_tutor_instructor_status == ""))) {
						?>
					<!--a style="float:right;" class="tutor-btn bordered-btn" href="<? //echo esc_url(tutor_utils()->instructor_register_url()); ?>">
						<? //echo sprintf(__("%s Become an instructor", 'tutor'), '<i class="tutor-icon-man-user"></i> &nbsp;'); ?>
					</a-->
					<div class="btn" style="float:right;">
					<? echo do_shortcode('[tutor_instructor_registration_form]'); ?>		
					</div>					
					<? }else if($_tutor_instructor_status == "approved"){  
						echo '<div class="tutor-btn bordered-btn" style="float:right;"><a style="color:#005f93;" href = "/my-account/">Go to educator account</a></div>'; 
					}
					?>
				</div> 
							  
			</div>
				<? 
				 if($_tutor_instructor_status == "pending"){
					 	echo '<div class="tutor-btn bordered-btn" style="float:right;"><a style="color:#005f93;" href = "/my-account/">Go to educator account</a></div>'; 
						echo '<div class="bordered-btn" style="float:right;color:#25A9E0;"><h5 class="tutor-dashboard-header-info">You\'re account is almost done. Until then, please enjoy all of the offerings of the site. You may begin creating classes and saving as drafts until the security steps are complete.</h5><h5 style="text-align: center;font-style: italic;"><a style="text-decoration: underline;" target="_blank" href="https://myhomeschoolfamily.com/background-check-form/">Please click here to complete your background check</a></h5></div>';
					}else if($_tutor_instructor_status == "blocked"){
						echo '<div style="float:right;color:red;">Your Educator Account Status is '.$_tutor_instructor_status.'. You can contact admin <a style="color:#005f93;" href = "/contact-us/" target="_blank">Contact Us</a></div>';
					} 
				?>
		</div>
		<? if($allmessage != "" || $sellermessage != ""){ ?>
				<div class="tutor-row">
					<div class="tutor-col-12">
						<div class="tutor-dashboard-header">
							<div class="required">
								<?
									if($allmessage != ""){
										echo "<p>".stripslashes($allmessage)."</p>";
									}
									if($sellermessage != ""){
										echo "<p>".stripslashes($sellermessage)."</p>";
									}
								?>
							</div>
						</div>
					</div>
				</div>
			<? } ?>
	</div>
</div>
<? } } ?>
<?
do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation">
	<ul class="tutor-dashboard-permalinks">
		<? foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<? echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<? echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><? echo esc_html( $label ); ?></a>
			</li>
		<? endforeach; ?>
	</ul>
</nav>

<? do_action( 'woocommerce_after_account_navigation' ); ?>
