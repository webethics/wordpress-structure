<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */

function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor',
		],
		'1.0.0'
	);
	wp_enqueue_style(
		'tutor-student',
		get_stylesheet_directory_uri() . '/css/tutor-student.css',
		[
			'hello-elementor',
		],
		'1.0.0'
	);
	wp_enqueue_style(
		'hello-child-style',
		get_stylesheet_directory_uri() . '/css/bootstrap.min.css',
		[
			'hello-style',
		],
		'4.5.0'
	);
	wp_enqueue_script ( 'custom-script', get_stylesheet_directory_uri() . '/js/tutor-student.js' );
	wp_enqueue_media ();
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts' );

##############GOOGLE ANALYTICS###########
add_action('wp_head','my_analytics', 20);
function my_analytics() {
	?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-84PZVNMZBW"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-84PZVNMZBW');
</script>
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '592402194791917'); 
fbq('track', 'PageView');
</script>
<noscript>
<img height="1" width="1" src="https://www.facebook.com/tr?id=592402194791917&ev=PageView&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->


	<?php
}

##############Added By Shalini to do custom coding ########################

//  Added to display custom fields on woocommerce registration page //
add_action( 'woocommerce_register_form_start', 'bbloomer_add_name_woo_account_registration' );
  
function bbloomer_add_name_woo_account_registration() {
    ?>
  
    <p class="form-row form-row-wide">
       <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
       <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
   </p>
   <p class="form-row form-row-wide">
	   <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
	   <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
	   <input type="hidden" name="seller_register_check"  value="seller_register_check" />
   
   </p>
   
	   
  
    <div class="clear"></div>
  
    <?php
}

// Go to Settings > Permalinks and just push "Save Changes" button.

// Add the code below to your theme's functions.php file to add a confirm password field on the register form under My Accounts.

function wooc_extra_register_fields() {?>
		<p class="form-row form-row-wide">
		<label for="reg_password2"><?php _e( 'Password confirmation', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
		</p>
		
       <p class="form-row form-row-wide">
       <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
       <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
       </p>
	<p class="form-row form-row-wide">
       <label for="reg_billing_address_1"><?php _e( 'Address 1', 'woocommerce' ); ?></label>
       <input type="text" class="input-text" name="billing_address_1" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_address_1'] ); ?>" />
       </p>
	    <p class="form-row form-row-wide">
       <label for="reg_billing_address_2"><?php _e( 'Address 2', 'woocommerce' ); ?></label>
       <input type="text" class="input-text" name="billing_address_2" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_address_2'] ); ?>" />
       </p>
	    <p class="form-row form-row-wide">
       <label for="reg_billing_city"><?php _e( 'City', 'woocommerce' ); ?></label>
       <input type="text" class="input-text" name="billing_city" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_city'] ); ?>" />
       </p>
	   <p class="form-row form-row-wide">
       <label for="reg_billing_state"><?php _e( 'State', 'woocommerce' ); ?></label>
       <input type="text" class="input-text" name="billing_state" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_state'] ); ?>" />
       </p>
	   
	   <p class="form-row form-row-wide">
       <label for="reg_billing_country"><?php _e( 'Country', 'woocommerce' ); ?></label>
       <input type="text" class="input-text" name="billing_country" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_country'] ); ?>" />
       </p>
	   
	   <p class="form-row form-row-wide">
       <label for="reg_billing_postcode"><?php _e( 'Postcode', 'woocommerce' ); ?></label>
       <input type="text" class="input-text" name="billing_postcode" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_postcode'] ); ?>" />
       </p>
       <div class="clear"></div>
       <?php
 }
 add_action( 'woocommerce_register_form', 'wooc_extra_register_fields' );

add_filter( 'woocommerce_registration_errors', 'bbloomer_validate_name_fields', 10, 3 );
  
function bbloomer_validate_name_fields( $errors, $username, $email ) {
	extract( $_POST );
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
    }
	if ( strcmp( $password, $password2 ) !== 0 ) {
			$errors->add( 'registration-error', __( '<strong>Error</strong>: Passwords do not match.', 'woocommerce' ) );
		}
    return $errors;
}
// Added to save registration fields //
function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['billing_phone'] ) ) {
                 // Phone input filed which is used in WooCommerce
                 update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
          }
      if ( isset( $_POST['billing_first_name'] ) ) {
             //First name field which is by default
             update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
             // First name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
      }
      if ( isset( $_POST['billing_last_name'] ) ) {
             // Last name field which is by default
             update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
             // Last name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
      }
	   if ( isset( $_POST['billing_address_1'] ) ) {
             // Last name field which is by default
             update_user_meta( $customer_id, 'address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
             // Last name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
      }
	    if ( isset( $_POST['billing_address_2'] ) ) {
             // Last name field which is by default
             update_user_meta( $customer_id, 'address_2', sanitize_text_field( $_POST['billing_address_2'] ) );
             // Last name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_address_2', sanitize_text_field( $_POST['billing_address_2'] ) );
      }
	  
	    if ( isset( $_POST['billing_city'] ) ) {
             // Last name field which is by default
             update_user_meta( $customer_id, 'address_city', sanitize_text_field( $_POST['billing_city'] ) );
             // Last name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );
      }

	   if ( isset( $_POST['billing_state'] ) ) {
             // Last name field which is by default
             update_user_meta( $customer_id, 'address_state', sanitize_text_field( $_POST['billing_state'] ) );
             // Last name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_state', sanitize_text_field( $_POST['billing_state'] ) );
      }
	    if ( isset( $_POST['billing_country'] ) ) {
             // Last name field which is by default
             update_user_meta( $customer_id, 'address_country', sanitize_text_field( $_POST['billing_country'] ) );
             // Last name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_country', sanitize_text_field( $_POST['billing_country'] ) );
      }
	  
	   if ( isset( $_POST['billing_postcode'] ) ) {
             // Last name field which is by default
             update_user_meta( $customer_id, 'address_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
             // Last name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
      }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

// Code added to add extra (Add Products) link on woocommerce default myaccount page //
add_filter ( 'woocommerce_account_menu_items', 'myaccount_add_product_link' );
function myaccount_add_product_link( $menu_links ){
 
	// we will hook "anyuniquetext123" later
	$new = array( 'anyuniquetext123' => 'Sell an Item' );
 
	// or in case you need 2 links
	// $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );
 
	// array_slice() is good when you want to add an element between the other ones
	$menu_links = array_slice( $menu_links, 0, 1, true ) 
	+ $new 
	+ array_slice( $menu_links, 1, NULL, true );
 
 
	return $menu_links;
 
 
}
 
add_filter( 'woocommerce_get_endpoint_url', 'myaccount_add_product_hook_endpoint', 10, 4 );
function myaccount_add_product_hook_endpoint( $url, $endpoint, $value, $permalink ){
 
	if( $endpoint === 'anyuniquetext123' ) {
 
		// ok, here is the place for your custom URL, it could be external
		$url = site_url().'/add-product/';
 
	}
	return $url;
 
}
	

// Code added to add extra link (manage Products) on woocommerce default myaccount page //
add_filter ( 'woocommerce_account_menu_items', 'myaccount_manage_products_link' );
function myaccount_manage_products_link( $menu_links ){
 
	$new = array( 'anyuniquetext321' => 'My Items for sale' );
 
	$menu_links = array_slice( $menu_links, 0, 1, true ) 
	+ $new 
	+ array_slice( $menu_links, 1, NULL, true );
 
 
	return $menu_links;
 
 
}
 
add_filter( 'woocommerce_get_endpoint_url', 'myaccount_manage_products_hook_endpoint', 10, 4 );
function myaccount_manage_products_hook_endpoint( $url, $endpoint, $value, $permalink ){
 
	if( $endpoint === 'anyuniquetext321' ) {
 
		// ok, here is the place for your custom URL, it could be external
		$url = site_url().'/manage-products/';
 
	}
	return $url;
 
}


add_filter( 'woocommerce_taxonomy_args_product_cat', 'custom_wc_taxonomy_label_product_cat' );
function custom_wc_taxonomy_label_product_cat( $args ) {
	$args['label'] = 'Type';
	$args['labels'] = array(
        'name' 				=> 'Type',
        'singular_name' 	=> 'Type',
        'menu_name'			=> 'Type'
	);

	return $args; 
}
add_filter('gettext', 'bbloomer_translate_tag_taxonomy');
add_filter( 'ngettext', 'bbloomer_translate_tag_taxonomy' );
 
function bbloomer_translate_tag_taxonomy($translated) {
 
if ( is_product() ) {
// This will only trigger on the single product page
$translated = str_ireplace('category', 'Type', $translated);
}
 
return $translated;
}
################## Ends Here ###################################

/** Anita Code Start **/

/** Add fields to Registration forms **/
add_action("init","activate_zoom_user");
function activate_zoom_user(){
	if ( is_user_logged_in() ) {
		$user = wp_get_current_user();
		$user_id = $user->ID;
		$host_id = get_user_meta($user->ID,_zoom_host_id,true);
		$host_status = get_user_meta($user->ID,_zoom_status_id,true);
		if($host_id != "" && $host_status == "pending"){
			$getUserInfo = json_decode(zoom_conference()->getUserInfo( $host_id ));
			if($getUserInfo->status == "active"){
				update_user_meta($user_id, '_zoom_status_id', "approved");
			}
		}
	}
}


add_filter('tutor_student_registration_required_fields', 'required_phone_no_callback');
add_filter('tutor_instructor_registration_required_fields', 'required_phone_no_callback');
if ( ! function_exists('required_phone_no_callback')){
    function required_phone_no_callback($atts){
		if($_POST['tutor_action'] == "tutor_register_instructor"){
			$atts['phone_number'] = 'Phone Number field is required';
		}
        $atts['gender'] = 'Gender field is required';
		if($_POST['tutor_action'] == "tutor_register_student"){
			$atts['dob'] = 'DOB field is required';
		}
        return $atts;
    }
}

/** Update Registration data to database ***/
add_action('user_register', 'add_phone_after_user_register');
add_action('profile_update', 'add_phone_after_user_register');
if ( ! function_exists('add_phone_after_user_register')) {
    function add_phone_after_user_register($user_id){
		
		/*** Subscribe user when register ***/
		global $wpdb;
		$table_name = $wpdb->prefix . 'mailpoet_subscribers';
		$update_subscribestatus = $wpdb->query($wpdb->prepare("UPDATE $table_name SET status='subscribed' WHERE wp_user_id=$user_id"));
		
        if ( ! empty($_POST['phone_number']) || ! empty($_POST['gender']) || ! empty($_POST['dob'])) {
			
            $phone_number = sanitize_text_field($_POST['phone_number']);
            $gender = sanitize_text_field($_POST['gender']);
			$dob = sanitize_text_field($_POST['dob']);
            update_user_meta($user_id, 'phone_number', $phone_number);
            update_user_meta($user_id, 'genderstatus', $gender);
			update_user_meta($user_id, 'dob', $dob);
        }
		if($_POST['tutor_action'] == "tutor_register_instructor"){
			 $theUser = new WP_User($user_id);
			 $theUser->add_role( 'customer' );
			 $theUser->add_role( 'tutor_instructor' );
			 $theUser->remove_role( 'subscriber' );
			$user = array(
				"email" => $_POST['email'],
				"action" => "create",
				"first_name" => $_POST['first_name'],
				"last_name" => $_POST['last_name'],
				"type" => 2
			);
			$zoomuserid = json_decode(zoom_conference()->createAUser( $user ));
			update_user_meta($user_id, '_zoom_host_id', $zoomuserid->id);
			update_user_meta($user_id, '_zoom_status_id', "pending");
			
			/** Enroll to teacher list **/
			if($update_subscribestatus){
				$update_subscribeid = $wpdb->get_var("SELECT id FROM $table_name WHERE wp_user_id = $user_id");
				
				$table_name = $wpdb->prefix . 'mailpoet_subscriber_segment';
				
				$array = array(7,8);
				foreach($array as $reslt){
					$wpdb->insert($table_name, array(
						'subscriber_id' => $update_subscribeid,
						'segment_id' => $reslt
					));
				}
			}
		}
		
		/** Enroll Student and seller to Global, student and seller list ***/
		if($_POST['tutor_action'] == "tutor_register_student"){
			
			
			if($update_subscribestatus){
				$update_subscribeid = $wpdb->get_var("SELECT id FROM $table_name WHERE wp_user_id = $user_id");
				
				$table_name = $wpdb->prefix . 'mailpoet_subscriber_segment';
				
				$array = array(5,8);
				foreach($array as $reslt){
					$wpdb->insert($table_name, array(
						'subscriber_id' => $update_subscribeid,
						'segment_id' => $reslt
					));
				}
				
			}
		}
		
		if($_POST['seller_register_check'] == "seller_register_check"){
		
			if($update_subscribestatus){
				$update_subscribeid = $wpdb->get_var("SELECT id FROM $table_name WHERE wp_user_id = $user_id");
				
				$table_name = $wpdb->prefix . 'mailpoet_subscriber_segment';
				
				$array = array(6,8);
				foreach($array as $reslt){
					$wpdb->insert($table_name, array(
						'subscriber_id' => $update_subscribeid,
						'segment_id' => $reslt
					));
				}
				
			}
		}
    }
}
/** Add new page to Instrcutor dashboard **/
add_filter('tutor_dashboard/nav_items', 'add_links_dashboard',99);
function add_links_dashboard($links){
	
	$user = wp_get_current_user();
	$user_id = get_current_user_id();
	$status = get_user_meta($user_id, '_tutor_instructor_status',true);
	if ( in_array( 'tutor_instructor', (array) $user->roles ) && !in_array( 'administrator', (array) $user->roles )) {
		$links['zoom_classes'] = __('Zoom Classes', 'tutor');
		unset($links['wishlist']);
		unset($links['my-quiz-attempts']);
		//unset($links['quiz-attempts']);
		unset($links['enrolled-courses']);
		unset($links['purchase_history']);
		unset($links['my-questions']);
		unset($links['my-assignments']);
		
	}
	
	if ( in_array( 'subscriber', (array) $user->roles ) && !in_array( 'tutor_instructor', (array) $user->roles )) {
		unset($links['zoom_meeting']);
		//unset($links['wishlist']);
		unset($links['reviews']);
	} 
	return $links;
}

/*** Category Filters on course page ***/
add_action( 'pre_get_posts', 'course_category_post_filter' );
function course_category_post_filter($query){
	if ( $query->is_archive ){
		$post_type = get_query_var('post_type');
		$course_category = get_query_var('course-category');
		if ( ($post_type === "courses" || ! empty($course_category) )){
			
			$query->set('posts_per_page', 12);
			if ( ! empty($_GET['tutor_category_filter']) || ! empty($_GET['tutor_tag_filter']) || !empty($_GET['tutor_type_filter'])){
				$taxquery = "";
				if(! empty($_GET['tutor_category_filter']) && $_GET['tutor_tag_filter'] == "" && $_GET['tutor_type_filter'] == ""){
					
					$taxquery = array(
						array(
							'taxonomy' => 'course-category',
							'field' => 'id',
							'terms' => array( $_GET['tutor_category_filter'] )
						)
					);
				}
				if(! empty($_GET['tutor_tag_filter']) && $_GET['tutor_category_filter'] == "" && $_GET['tutor_type_filter'] == ""){
					
					$taxquery = array(
						array(
							'taxonomy' => 'course-tag',
							'field' => 'id',
							'terms' => array( $_GET['tutor_tag_filter'] )
						)
					);
				}
				if(! empty($_GET['tutor_type_filter']) && $_GET['tutor_category_filter'] == "" && $_GET['tutor_tag_filter'] == ""){
					
					$taxquery = array(
						array(
							'taxonomy' => 'coursetype',
							'field' => 'id',
							'terms' => array( $_GET['tutor_type_filter'] )
						)
					);
				}
				if(! empty($_GET['tutor_category_filter']) && ! empty($_GET['tutor_tag_filter'] ) && $_GET['tutor_type_filter'] ==""){
					
					$taxquery = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'course-category',
							'field' => 'id',
							'terms' => array( $_GET['tutor_category_filter'] )
						),
						array(
							'taxonomy' => 'course-tag',
							'field' => 'id',
							'terms' => array( $_GET['tutor_tag_filter'] )
						)
					);
				}
				if(! empty($_GET['tutor_category_filter']) && $_GET['tutor_tag_filter'] == "" && ! empty($_GET['tutor_type_filter'] )){
					
					$taxquery = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'course-category',
							'field' => 'id',
							'terms' => array( $_GET['tutor_category_filter'] )
						),
						array(
							'taxonomy' => 'coursetype',
							'field' => 'id',
							'terms' => array( $_GET['tutor_type_filter'] )
						)
					);
				}
				if($_GET['tutor_category_filter'] == "" && ! empty($_GET['tutor_tag_filter'] ) && ! empty($_GET['tutor_type_filter'] )){
					
					$taxquery = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'course-tag',
							'field' => 'id',
							'terms' => array( $_GET['tutor_tag_filter'] )
						),
						array(
							'taxonomy' => 'coursetype',
							'field' => 'id',
							'terms' => array( $_GET['tutor_type_filter'] )
						)
					);
				}
				if(! empty($_GET['tutor_category_filter']) && ! empty($_GET['tutor_tag_filter'] ) && ! empty($_GET['tutor_type_filter'] )){
					
					$taxquery = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'course-category',
							'field' => 'id',
							'terms' => array( $_GET['tutor_category_filter'] )
						),
						array(
							'taxonomy' => 'course-tag',
							'field' => 'id',
							'terms' => array( $_GET['tutor_tag_filter'] )
						),
						array(
							'taxonomy' => 'coursetype',
							'field' => 'id',
							'terms' => array( $_GET['tutor_type_filter'] )
						)
					);
				}

				$query->set( 'tax_query', $taxquery );
			}
			
		}
	} 
}


/** Redirect to account dashboard after login **/
/*function wc_custom_user_redirect( $redirect, $user ) {
	$role = $user->roles[0];
	$dashboard = admin_url();
	$myaccount = '/my-account/';

	if (  $role == 'subscriber' || $role == 'tutor_instructor' ) {
		$redirect = $myaccount;
	}
	return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 ); */

/*** create type taxonomy **/
add_action( 'init', 'custom_taxonomy_course_type',1);
function custom_taxonomy_course_type()  {
$labels = array(
    'name'                       => 'Course Type',
    'singular_name'              => 'Course Type',
    'menu_name'                  => 'Course Type',
    'all_items'                  => 'All Items',
    'parent_item'                => 'Parent Item',
    'parent_item_colon'          => 'Parent Item:',
    'new_item_name'              => 'New Item Name',
    'add_new_item'               => 'Add New Item',
    'edit_item'                  => 'Edit Item',
    'update_item'                => 'Update Item',
    'separate_items_with_commas' => 'Separate Items with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'coursetype', 'courses', $args );
}

add_action('admin_menu', 'wpdocs_register_my_custom_submenu_page');
 
function wpdocs_register_my_custom_submenu_page() {
    add_submenu_page('tutor', __('Course Type', 'tutor'), __('Course Type', 'tutor'), 'manage_tutor', 'edit-tags.php?taxonomy=coursetype&post_type=courses', null );
}
/*** Save Course Group from frontend module ***/
function group_save_postdata($post_id)
{
	global $wpdb;
	
	if (array_key_exists('comingsoon', $_POST)) {
		update_post_meta($post_id,"comingsoon",$_POST['comingsoon']);
		update_post_meta($post_id,"comingfavourite","");
	}
	else{
		update_post_meta($post_id,"comingsoon","");
		$check = get_post_meta($post_id,"comingfavourite",true);
		if($check == 2){
			
		}
		else{
			update_post_meta($post_id,"comingfavourite",1);
		}
		
		$check1 = get_post_meta($post_id,"comingfavourite",true);
		if($check1 == 1){
			$user_email_favourite = $wpdb->get_results("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '_tutor_course_wishlist' AND meta_value =$post_id");
			foreach($user_email_favourite as $result){
				$id = $result->user_id;
				$user_email = $wpdb->get_results("SELECT user_email FROM $wpdb->users WHERE ID = $id");
				$fav_email = $user_email[0]->user_email;
				$to = $fav_email;
				$body = 'Hello,<br>You recently added '.get_the_title($post_id).' Class to your favorites. It is now available for Enrollment. Hurry and Enroll today to secure your spot! <a href="'.get_the_permalink($post_id).'">'. get_the_permalink($post_id)."</a>";
				$headers = array('Content-Type: text/html; charset=UTF-8','From: MyHomeSchoolFamily <info@myhomeschoolfamily.com>');
				wp_mail( $to, "Favorites Class Status", $body, $headers );
				
				update_post_meta($post_id,"comingfavourite",2);
			} 
		}
	}
	if (array_key_exists('bibical', $_POST)) {
		update_post_meta($post_id,"_bibical_data",$_POST['bibical']);
	}
	if (array_key_exists('lateenroll', $_POST)) {
		update_post_meta($post_id,"lateenroll",$_POST['lateenroll']);
	}
	if (array_key_exists('lateenrollnumber', $_POST)) {
		update_post_meta($post_id,"lateenrollnumber",$_POST['lateenrollnumber']);
	}
    if (array_key_exists('course-tag', $_POST)) {
		wp_set_object_terms($post_id, $_POST['course-tag'], 'course-tag', true);
    }	
	if (array_key_exists('courseetype', $_POST)) {
		wp_set_object_terms($post_id, array($_POST['courseetype']), 'coursetype', false);
		$current_user = wp_get_current_user();
		$newfolder = $current_user->display_name;
		if($_POST['courseetype'] == "on-demand-classes"){
			
			$upload_dir = '/var/www/html/uploads';
			$upload_dir = $upload_dir . '/'.$newfolder.'/';
			
			
			if (! is_dir($upload_dir)) {
				
			   mkdir( $upload_dir, 0777,true );
			}
			$uploadfile = $upload_dir . basename($_FILES['userfile']['name']);
			$extensions_arr = array("mp4","avi","3gp","mov","mpeg");
			move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
			if (!empty(basename($_FILES['userfile']['name']))) {
				update_post_meta($post_id, '_on_demand_video', $uploadfile);  
			}
			if (array_key_exists('relatedclasses', $_POST)) {
				update_post_meta($post_id, 'relative_class', "yes");  
				update_post_meta($post_id, 'relative_class_id', $_POST['relatedclasses']); 
				foreach($_POST['relatedclasses'] as $final){
					
					update_post_meta($final, 'relationparent', $post_id);  
				}
			}
			if (array_key_exists('relationclass', $_POST)) {
				update_post_meta($post_id, 'relationclass', $_POST['relationclass']);  
			}
		}
	}
	if (array_key_exists('refund', $_POST)) {
		update_post_meta($post_id,"refund",$_POST['refund']);
	}
}
add_action('save_post', 'group_save_postdata',99);
add_action( 'save_post_courses', 'saveGuideMeta' );
function saveGuideMeta(){
	global $wpdb;
	
	$hours = $_POST['course_duration']['hours'];
	$duration = $_POST['course_duration']['minutes']+(60*$hours);
	$start_dateee = $_POST['start_datee'];
	$checkasign_meta = get_post_meta($_POST['post_ID'],"_insert_meeting_zoom_meeting_id",true);
	$time_in_24_hour_format  = date("H:i", strtotime($_POST['liveclasstime']));
	$hostid = $_POST['userId'];
	if(empty($checkasign_meta)){
		if($hours == "" && $start_dateee == ""){
			
			return;
		}
		else{
			
			$start_dateee = explode(",", $start_dateee);
			
			foreach($start_dateee as $classdate){
				
				$classdate = $classdate." ".$time_in_24_hour_format;
				
				 $post = array(
					"meetingTopic" => $_POST['title'],
					"userId" => $_POST['userId'],
					"start_date" => $classdate,
					"timezone" => "America/New_York",
					"duration" => $duration,
					"password" => "welcome"
				 );
				$meeting_updated = json_decode(zoom_conference()->createAMeeting( $post ));
				if(empty( $meeting_updated->error )){
					if($meeting_updated->code != 429){
					
						//the array of arguements to be inserted with wp_insert_post
						$new_post = array(
							'post_title'    => $_POST['title'],
							'post_status'   => 'publish',          
							'post_type'     => 'zoom-meetings'
						);
						$create_meeting_arr = array(
								'userId'                    => $meeting_updated->host_id,
								'start_date'                => $classdate,
								'timezone'                  => "America/New_York",
								'duration'                  => $duration,
								'password'                  => "welcome",
								'join_before_host'          => filter_input( INPUT_POST, 'join_before_host' ),
								'option_host_video'         => filter_input( INPUT_POST, 'option_host_video' ),
								'option_participants_video' => filter_input( INPUT_POST, 'option_participants_video' ),
								'option_mute_participants'  => filter_input( INPUT_POST, 'option_mute_participants' ),
								'option_auto_recording'     => filter_input( INPUT_POST, 'option_auto_recording' ),
								'alternative_host_ids'      => filter_input( INPUT_POST, 'alternative_host_ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY )
							);
						$pid = wp_insert_post($new_post); 
						if(! empty($pid)){
							update_post_meta( $pid, '_meeting_fields', $create_meeting_arr );
							update_post_meta( $pid, '_meeting_host_id', $meeting_updated->host_id );
							update_post_meta( $pid, '_meeting_zoom_details', $meeting_updated );
							update_post_meta( $pid, '_meeting_zoom_join_url', $meeting_updated->join_url );
							update_post_meta( $pid, '_meeting_zoom_start_url', $meeting_updated->start_url );
							update_post_meta( $pid, '_meeting_zoom_meeting_id', $meeting_updated->id );
							update_post_meta( $pid, '_meeting_date', $classdate );
							//update_post_meta( $_POST['ID'], '_insert_meeting_zoom_meeting_id', $meeting_updated->id );
							$meeting_array = array();
							$meeting_array[] = $meeting_updated->id;
							$checkasign_meta = get_post_meta($_POST['post_ID'],"_insert_meeting_zoom_meeting_id",true);
							if($checkasign_meta == ""){
								update_post_meta( $_POST['post_ID'], '_insert_meeting_zoom_meeting_id', $meeting_array );
								update_post_meta( $_POST['post_ID'], '_insert_zoom_post_id', $pid );
							}
							else{
								$finalval = array_merge($checkasign_meta,$meeting_array);
								update_post_meta( $_POST['post_ID'], '_insert_meeting_zoom_meeting_id', $finalval );
								update_post_meta( $_POST['post_ID'], '_insert_zoom_post_id', $pid );
							}
							 
						}
					}
				}
				
			}
			return;
		}
	}
	else{
			$j = 0;
			$meetingid = $_POST['meetingid'];
			$site_datee = explode(",", $start_dateee);
			$site_dateecount = count($site_datee);
			$meeting = explode(",", $meetingid);
			$meetingcount = count($meeting);
			
			if ($site_dateecount == $meetingcount){
				foreach($checkasign_meta as $meeting_id){
					$zoom_post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $meeting_id ."')");
					$meeting_info = json_decode( zoom_conference()->getMeetingInfo( $meeting_id, $_POST['userId']) );
					$time = $site_datee[$j];
					$class_date = date('m/d/Y',strtotime($time));
					$classdate = $class_date." ".$time_in_24_hour_format;
						
					
					$post = array(
						"host_id" => $_POST['userId'],
						"meeting_id" => $meeting_id,
						"start_date" => $classdate,
						"duration" => $duration,
						"timezone" => "America/New_York",
					 );
					 $meeting_updated = json_decode(zoom_conference()->updateMeetingInfo( $post ));
						if ( empty( $meeting_updated->error ) ) {
							if($meeting_updated->code != 429){
								$create_meeting_arr = array(
									'userId'                    => $_POST['userId'],
									'start_date'                => $classdate,
									'timezone'                  => "America/New_York",
									'duration'                  => $duration,
									'password'                  => "welcome",
									'join_before_host'          => filter_input( INPUT_POST, 'join_before_host' ),
									'option_host_video'         => filter_input( INPUT_POST, 'option_host_video' ),
									'option_participants_video' => filter_input( INPUT_POST, 'option_participants_video' ),
									'option_mute_participants'  => filter_input( INPUT_POST, 'option_mute_participants' ),
									'option_auto_recording'     => filter_input( INPUT_POST, 'option_auto_recording' ),
									'alternative_host_ids'      => filter_input( INPUT_POST, 'alternative_host_ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY )
								);
								update_post_meta( $zoom_post_id, '_meeting_fields', $create_meeting_arr );
								update_post_meta( $zoom_post_id, '_meeting_zoom_details', $meeting_info );
								update_post_meta( $zoom_post_id, '_meeting_zoom_join_url', $meeting_info->join_url );
								update_post_meta( $zoom_post_id, '_meeting_zoom_start_url', $meeting_info->start_url );
								update_post_meta( $zoom_post_id, '_meeting_zoom_meeting_id', $meeting_info->id );
								update_post_meta( $zoom_post_id, '_meeting_date', $classdate );
							}
						}
					$j++;
				}
			}
			else{
				foreach($meeting as $final_id){
					zoom_conference()->deleteAMeeting( $final_id, $hostid);
					$zoom_post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $final_id ."')");
					update_post_meta( $_POST['post_ID'], '_insert_meeting_zoom_meeting_id', "" );
					wp_delete_post( $zoom_post_id, true );

				}
				foreach($site_datee as $classdate){
					
					$classdate = $classdate." ".$time_in_24_hour_format;
					
					 $post = array(
						"meetingTopic" => $_POST['title'],
						"userId" => $_POST['userId'],
						"start_date" => $classdate,
						"timezone" => "America/New_York",
						"duration" => $duration,
						"password" => "welcome"
					 );
					$meeting_updated = json_decode(zoom_conference()->createAMeeting( $post ));
					if(empty( $meeting_updated->error )){
						if($meeting_updated->code != 429){							//the array of arguements to be inserted with wp_insert_post
							$new_post = array(
								'post_title'    => $_POST['title'],
								'post_status'   => 'publish',          
								'post_type'     => 'zoom-meetings'
							);
							$create_meeting_arr = array(
									'userId'                    => $meeting_updated->host_id,
									'start_date'                => $classdate,
									'timezone'                  => "America/New_York",
									'duration'                  => $duration,
									'password'                  => "welcome",
									'join_before_host'          => filter_input( INPUT_POST, 'join_before_host' ),
									'option_host_video'         => filter_input( INPUT_POST, 'option_host_video' ),
									'option_participants_video' => filter_input( INPUT_POST, 'option_participants_video' ),
									'option_mute_participants'  => filter_input( INPUT_POST, 'option_mute_participants' ),
									'option_auto_recording'     => filter_input( INPUT_POST, 'option_auto_recording' ),
									'alternative_host_ids'      => filter_input( INPUT_POST, 'alternative_host_ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY )
								);
							$pid = wp_insert_post($new_post); 
							if(! empty($pid)){
								update_post_meta( $pid, '_meeting_fields', $create_meeting_arr );
								update_post_meta( $pid, '_meeting_host_id', $meeting_updated->host_id );
								update_post_meta( $pid, '_meeting_zoom_details', $meeting_updated );
								update_post_meta( $pid, '_meeting_zoom_join_url', $meeting_updated->join_url );
								update_post_meta( $pid, '_meeting_zoom_start_url', $meeting_updated->start_url );
								update_post_meta( $pid, '_meeting_zoom_meeting_id', $meeting_updated->id );
								update_post_meta( $pid, '_meeting_date', $classdate );
								//update_post_meta( $_POST['ID'], '_insert_meeting_zoom_meeting_id', $meeting_updated->id );
								$meeting_array = array();
								$meeting_array[] = $meeting_updated->id;
								$checkasign_meta = get_post_meta($_POST['post_ID'],"_insert_meeting_zoom_meeting_id",true);
								if($checkasign_meta == ""){
									update_post_meta( $_POST['post_ID'], '_insert_meeting_zoom_meeting_id', $meeting_array );
									update_post_meta( $_POST['post_ID'], '_insert_zoom_post_id', $pid );
								}
								else{
									$finalval = array_merge($checkasign_meta,$meeting_array);
									update_post_meta( $_POST['post_ID'], '_insert_meeting_zoom_meeting_id', $finalval );
									update_post_meta( $_POST['post_ID'], '_insert_zoom_post_id', $pid );
								}
								 
							}

						}
					}
				
				} 
			}
		
			 
			return;
	}
}
/* function add_theme_caps(){
    $role = get_role( 'subscriber' );
    $role->add_cap( 'upload_files' ); 

}
add_action( 'init', 'add_theme_caps' ); */
add_action( 'admin_init', function() {
    $role = get_role( 'tutor_instructor' );
    $role->add_cap( 'delete_attachments' );
	$role1 = get_role( 'customer' );
    $role1->add_cap( 'upload_files' );
    $role1->add_cap( 'delete_attachments' );	
});
/** Anita code end **/

######### Code added bu shalini to add woocommerce hooks ##########
add_action('woocommerce_new_order_item', 'add_user_earning_data', 10, 3);
add_action( 'woocommerce_order_status_changed', 'add_user_earning_data_status_change', 10, 3 );


 function add_user_earning_data( $item_id, $item, $order_id){
	    global $wpdb;
		$item = new \WC_Order_Item_Product($item);
		$product_id = $item->get_product_id();
		$user_id = $wpdb->get_var("SELECT post_author FROM {$wpdb->posts} WHERE ID = {$product_id} ");
		$order_status = $wpdb->get_var("SELECT post_status from {$wpdb->posts} where ID = {$order_id} ");
		$total_price = $item->get_total();
			$fees_deduct_data = array();
			$tutor_earning_fees = tutor_utils()->get_option('tutor_earning_fees');
			$enable_fees_deducting = tutor_utils()->avalue_dot('enable_fees_deducting', $tutor_earning_fees);

			$course_price_grand_total = $total_price;

			if ($enable_fees_deducting){
				$fees_name = tutor_utils()->avalue_dot('fees_name', $tutor_earning_fees);
				$fees_amount = (int) tutor_utils()->avalue_dot('fees_amount', $tutor_earning_fees);
				$fees_type = tutor_utils()->avalue_dot('fees_type', $tutor_earning_fees);

				if ($fees_amount > 0) {
					if ( $fees_type === 'percent' ) {
                        $fees_amount = ( $total_price * $fees_amount ) / 100;
					}

					/*
					if ( $fees_type === 'fixed' ) {
						$course_price_grand_total = $total_price - $fees_amount;
					}*/

                    $course_price_grand_total = $total_price - $fees_amount;
                }

				$fees_deduct_data = array(
					'deduct_fees_amount'    => $fees_amount,
					'deduct_fees_name'      => $fees_name,
					'deduct_fees_type'      => $fees_type,
                );
            }

			$instructor_rate = tutor_utils()->get_option('earning_instructor_commission');
			$admin_rate = tutor_utils()->get_option('earning_admin_commission');

			$instructor_amount = 0;
			if ($instructor_rate > 0){
				$instructor_amount = ($course_price_grand_total * $instructor_rate) / 100;
            }

			$admin_amount = 0;
			if ($admin_rate > 0){
				$admin_amount = ($course_price_grand_total * $admin_rate) / 100;
			}
		$earning_datas = array(
				'user_id'                   => $user_id,
				'product_id'                 => $product_id,
				'order_id'                  => $order_id,
				'order_status'              => $order_status,
				'product_price_total'        => $total_price,
				'product_price_grand_total'  => $course_price_grand_total,
				'user_amount'         => $instructor_amount,
				'user_rate'           => $instructor_rate,
				'admin_amount'              => $admin_amount,
				'admin_rate'                => $admin_rate,
				'commission_type'           => 'percent',
				'process_by'                => 'woocommerce',
				'created_at'                => date( 'Y-m-d H:i:s', tutor_time()), 
			);
			$earning_datas = apply_filters('user_new_earning_data', array_merge($earning_datas, $fees_deduct_data));
			if(!empty($user_id) && !empty($product_id)){
				$wpdb->insert($wpdb->prefix.'user_earnings', $earning_datas);
			}
		
 }

 function add_user_earning_data_status_change($order_id, $status_from, $status_to){
		global $wpdb;

		$is_earning_data = (int) $wpdb->get_var("SELECT COUNT(earning_id) FROM {$wpdb->prefix}user_earnings WHERE order_id = {$order_id}  ");
		if ($is_earning_data){
		    $wpdb->update( $wpdb->prefix.'user_earnings', array( 'order_status' => $status_to ), array( 'order_id' => $order_id ) );
		}
	}
		


/*
 * Step 1. Add Link (Tab) to My Account menu
 */
add_filter ( 'woocommerce_account_menu_items', 'misha_earnings_link', 40 );
function misha_earnings_link( $menu_links ){
 
	$menu_links = array_slice( $menu_links, 0, 5, true ) 
	+ array( 'earnings' => 'My Earnings' )
	+ array_slice( $menu_links, 5, NULL, true );
 
	return $menu_links;
 
}

/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'misha_add_endpoint' );
function misha_add_endpoint() {
	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
	add_rewrite_endpoint( 'earnings', EP_PAGES );
	
	wp_enqueue_script( 'tutor-front-chart-js', tutor()->url . 'assets/js/Chart.bundle.min.js', array(), tutor()->version );
	wp_enqueue_script( 'jquery-ui-datepicker' );
}


/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_earnings_endpoint', 'misha_my_account_endpoint_content' );
function misha_my_account_endpoint_content() {
	
	get_template_part('my-account-earnings');
	
	// of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
 
}
################# Added by shalini on 09-06-2020 #####################


function bbloomer_add_earning_reports_endpoint() {
    add_rewrite_endpoint( 'earning-reports', EP_ROOT | EP_PAGES );
}
  
add_action( 'init', 'bbloomer_add_earning_reports_endpoint' );
  
  
// ------------------
// 2. Add new query var
  
function bbloomer_earning_reports_query_vars( $vars ) {
    $vars[] = 'earning-reports';
    return $vars;
}
  
add_filter( 'query_vars', 'bbloomer_earning_reports_query_vars', 0 );
  
  
// ------------------
// 3. Insert the new endpoint into the My Account menu
  
function bbloomer_add_earning_reports_link_my_account( $menu_links ){
 
	$menu_links = array_slice( $menu_links, 0, 6, true ) 
	+ array( 'earning-reports' => 'My Reports' )
	+ array_slice( $menu_links, 6, NULL, true );
 
	return $menu_links;
 
}
  
add_filter( 'woocommerce_account_menu_items', 'bbloomer_add_earning_reports_link_my_account' );
  
  
// ------------------
// 4. Add content to the new endpoint
  
function bbloomer_earning_reports_content() {
get_template_part('template-earning-reports');

}
  
add_action( 'woocommerce_account_earning-reports_endpoint', 'bbloomer_earning_reports_content' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format 


function get_user_earnings_completed_statuses(){
		return apply_filters(
			'user_get_earnings_completed_statuses',
			array (
				'wc-completed',
				'completed',
				'complete',
			)
		);
	}
function get_user_earning_sum($user_id,$date_filter = array()){
		global $wpdb;
		$date_query = '';
		if (count($date_filter)){
			extract($date_filter);
			if ( ! empty($dataFor)){
				if ($dataFor === 'yearly'){
					if (empty($year)){
						$year = date('Y');
					}
					$date_query = "AND YEAR(created_at) = {$year} ";
				}
			}else{
				$date_query = " AND (created_at BETWEEN '{$start_date}' AND '{$end_date}') ";
			}
		}
		$complete_status = get_user_earnings_completed_statuses();
		$complete_status = "'".implode("','", $complete_status)."'";

		$earning_sum = $wpdb->get_row("SELECT SUM(product_price_total) as product_price_total, 
                    SUM(product_price_grand_total) as product_price_grand_total, 
                    SUM(user_amount) as user_amount, 
                    (SELECT SUM(amount) FROM {$wpdb->prefix}user_withdraws WHERE user_id = {$user_id} AND status != 'rejected' ) as 
                    withdraws_amount,
                    SUM(admin_amount) as admin_amount, 
                    SUM(deduct_fees_amount)  as deduct_fees_amount
                    FROM {$wpdb->prefix}user_earnings 
                    WHERE user_id = {$user_id} AND order_status IN({$complete_status}) {$date_query}");

		//TODO: need to check
		// (SUM(instructor_amount) - (SELECT withdraws_amount) ) as balance,


		if ( $earning_sum->product_price_total){
			$earning_sum->balance = $earning_sum->user_amount - $earning_sum->withdraws_amount;
		}else{

			$earning_sum = (object) array(
				'product_price_total'        => 0,
				'product_price_grand_total'  => 0,
				'user_amount'         => 0,
				'withdraws_amount'          => 0,
				'balance'                   => 0,
				'admin_amount'              => 0,
				'deduct_fees_amount'        => 0,
			);
		}

		return $earning_sum;
	}




add_filter( 'woocommerce_account_menu_items', 'bbloomer_remove_address_my_account', 999 );
 
function bbloomer_remove_address_my_account( $items ) {
unset($items['downloads']);
unset($items['edit-address']);
unset($items['withdraw-methods']);
unset($items['inquiry']);
return $items;
}

add_filter( 'woocommerce_account_menu_items', 'bbloomer_rename_address_my_account', 999 );
 
function bbloomer_rename_address_my_account( $items ) {
$items['orders'] = 'Purchase History and Downloads';
$items['dashboard'] = 'Dashboard';
$items['edit-account'] = 'Account Settings';
return $items;
}


add_action( 'init', 'custom_taxonomy_Item' );
function custom_taxonomy_Item()  {
$labels = array(
    'name'                       => 'Subjects',
    'singular_name'              => 'Subject',
    'menu_name'                  => 'Subject',
    'all_items'                  => 'All Subjects',
    'parent_item'                => 'Parent Subject',
    'parent_item_colon'          => 'Parent Subject:',
    'new_item_name'              => 'New Subject Name',
    'add_new_item'               => 'Add New Subject',
    'edit_item'                  => 'Edit Subject',
    'update_item'                => 'Update Subject',
    'separate_items_with_commas' => 'Separate Subject with commas',
    'search_items'               => 'Search Subjects',
    'add_or_remove_items'        => 'Add or remove Subjects',
    'choose_from_most_used'      => 'Choose from the most used Subjects',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'subject', 'product', $args );
register_taxonomy_for_object_type( 'subject', 'product' );
}


add_action( 'init', 'custom_taxonomy_Grade_level' );
function custom_taxonomy_Grade_level()  {
$labels = array(
    'name'                       => 'Grade Levels',
    'singular_name'              => 'Grade Level',
    'menu_name'                  => 'Grade Level',
    'all_items'                  => 'All Items',
    'parent_item'                => 'Parent Item',
    'parent_item_colon'          => 'Parent Item:',
    'new_item_name'              => 'New Item Name',
    'add_new_item'               => 'Add New Item',
    'edit_item'                  => 'Edit Item',
    'update_item'                => 'Update Item',
    'separate_items_with_commas' => 'Separate Items with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'grade-levels', 'product', $args );
register_taxonomy_for_object_type( 'grade-levels', 'product' );
}
add_action( 'init', 'custom_taxonomy_condition' );
function custom_taxonomy_condition()  {
$labels = array(
    'name'                       => 'Condition',
    'singular_name'              => 'Condition',
    'menu_name'                  => 'Condition',
    'all_items'                  => 'All Items',
    'parent_item'                => 'Parent Item',
    'parent_item_colon'          => 'Parent Item:',
    'new_item_name'              => 'New Item Name',
    'add_new_item'               => 'Add New Item',
    'edit_item'                  => 'Edit Item',
    'update_item'                => 'Update Item',
    'separate_items_with_commas' => 'Separate Items with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'condition', 'product', $args );
register_taxonomy_for_object_type( 'condition', 'product' );
}
################################################################


function bbloomer_add_withdraw_earnings_endpoint() {
    add_rewrite_endpoint( 'withdraw-earnings', EP_ROOT | EP_PAGES );
}
  
add_action( 'init', 'bbloomer_add_withdraw_earnings_endpoint' );
  
  
// ------------------
// 2. Add new query var
  
function bbloomer_withdraw_earnings_query_vars( $vars ) {
    $vars[] = 'withdraw-earnings';
    return $vars;
}
  
add_filter( 'query_vars', 'bbloomer_withdraw_earnings_query_vars', 0 );
  
  
// ------------------
// 3. Insert the new endpoint into the My Account menu
  
function bbloomer_add_withdraw_earnings_link_my_account( $menu_links ){
 
	$menu_links = array_slice( $menu_links, 0, 6, true ) 
	+ array( 'withdraw-earnings' => 'Withdraw Earnings' )
	+ array_slice( $menu_links, 6, NULL, true );
 
	return $menu_links;
 
}
  
add_filter( 'woocommerce_account_menu_items', 'bbloomer_add_withdraw_earnings_link_my_account' );
  
  
// ------------------
// 4. Add content to the new endpoint
  
function bbloomer_withdraw_earnings_content() {
get_template_part('template-withdraw-earnings');

}
  
add_action( 'woocommerce_account_withdraw-earnings_endpoint', 'bbloomer_withdraw_earnings_content' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format 




##########################################################################


function bbloomer_add_withdraw_methods_endpoint() {
    add_rewrite_endpoint( 'withdraw-methods', EP_ROOT | EP_PAGES );
}
  
add_action( 'init', 'bbloomer_add_withdraw_methods_endpoint' );
  
  
// ------------------
// 2. Add new query var
  
function bbloomer_withdraw_methods_query_vars( $vars ) {
    $vars[] = 'withdraw-methods';
    return $vars;
}
  
add_filter( 'query_vars', 'bbloomer_withdraw_methods_query_vars', 0 );
  
  
// ------------------
// 3. Insert the new endpoint into the My Account menu
  
function bbloomer_add_withdraw_methods_link_my_account( $menu_links ){
 
	$menu_links = array_slice( $menu_links, 0, 6, true ) 
	+ array( 'withdraw-methods' => 'Withdraw Methods' )
	+ array_slice( $menu_links, 6, NULL, true );
 
	return $menu_links;
 
}
  
add_filter( 'woocommerce_account_menu_items', 'bbloomer_add_withdraw_methods_link_my_account' );
  
  
// ------------------
// 4. Add content to the new endpoint
  
function bbloomer_withdraw_methods_content() {
get_template_part('template-withdraw-methods');

}
  
add_action( 'woocommerce_account_withdraw-methods_endpoint', 'bbloomer_withdraw_methods_content' );
##########################################################################




############################################################################
add_action('wp_ajax_user_make_an_withdraw','user_make_an_withdraw');

add_action( 'wp_ajax_user_make_an_withdraw', 'user_make_an_withdraw' );    // If called from admin panel
add_action( 'wp_ajax_nopriv_user_make_an_withdraw', 'user_make_an_withdraw' );    // If called from front end

function user_make_an_withdraw(){
		global $wpdb;
		$user_id = get_current_user_id();
		$post = $_POST;
		$withdraw_amount = sanitize_text_field(tutor_utils()->avalue_dot('tutor_withdraw_amount', $post));
		$earning_sum = get_user_earning_sum($user_id);
	//	$min_withdraw = tutor_utils()->get_option('min_withdraw_amount');
		$min_withdraw = get_option( 'woocommerce_user_withdrawl_amount', 1 );
		$saved_withdraw_account = tutor_utils()->get_user_withdraw_method();
		$formatted_balance = tutor_utils()->tutor_price($earning_sum->balance);
		$formatted_min_withdraw_amount = tutor_utils()->tutor_price($min_withdraw);

		if ( ! tutor_utils()->count($saved_withdraw_account)){
			$no_withdraw_method = apply_filters('tutor_no_withdraw_method_msg', __('Please save withdraw method ', 'tutor')  );
			wp_send_json_error(array('msg' => $no_withdraw_method ));
		}

		if ($withdraw_amount < $min_withdraw){
			$required_min_withdraw = apply_filters('tutor_required_min_amount_msg', sprintf(__('Minimum withdraw amount is %s %s %s ', 'tutor') , '<strong>', $formatted_min_withdraw_amount, '</strong>' ) );
			wp_send_json_error(array('msg' => $required_min_withdraw ));
		}

		if ($earning_sum->balance < $withdraw_amount){
			$insufficient_balence = apply_filters('tutor_withdraw_insufficient_balance_msg', sprintf(__('Insufficient balance to withdraw, your balance is %s %s %s ', 'tutor'),'<strong>', $formatted_balance, '</strong>' ) );

			wp_send_json_error(array('msg' => $insufficient_balence ));
		}


        $date = date("Y-m-d H:i:s", tutor_time());

		$withdraw_data = apply_filters('tutor_pre_withdraw_data', array(
			'user_id'       => $user_id,
			'amount'        => $withdraw_amount,
			'method_data'   => maybe_serialize($saved_withdraw_account),
			'status'        => 'pending',
			'created_at'    => $date,
		));

		do_action('tutor_insert_withdraw_before', $withdraw_data);

		$wpdb->insert($wpdb->prefix."user_withdraws", $withdraw_data);
		$withdraw_id = $wpdb->insert_id;

		do_action('tutor_insert_withdraw_after', $withdraw_id, $withdraw_data);


		/**
		 * Getting earning and balance data again
		 */
		$earning = get_user_earning_sum($user_id);
		$new_available_balance = tutor_utils()->tutor_price($earning->balance);


		do_action('tutor_withdraw_after');

		$withdraw_successfull_msg = apply_filters('tutor_withdraw_successful_msg', __('Withdraw has been successful', 'tutor'));
		wp_send_json_success(array('msg' => $withdraw_successfull_msg, 'available_balance' => $new_available_balance ));
}

function get_user_withdrawals_history($user_id = 0, $filter = array()){
		global $wpdb;

		$filter = (array) $filter;
		extract($filter);

		$query_by_status_sql = "";
		$query_by_user_sql = "";
		$query_by_pagination = "";

		if ( ! empty($status)){
			$status = (array) $status;
			$status = "'".implode("','", $status)."'";

			$query_by_status_sql = " AND status IN({$status}) ";
		}

		if ( ! empty($per_page)){
			if ( empty($start))
				$start = 0;

			$query_by_pagination = " LIMIT {$start}, {$per_page} ";
		}

		if ($user_id){
			$query_by_user_sql = " AND user_id = {$user_id} ";
		}

		
		$count1 = (int) $wpdb->get_var("SELECT COUNT(withdraw_id) FROM {$wpdb->prefix}user_withdraws WHERE 1=1 {$query_by_user_sql} {$query_by_status_sql} ");

		
		$results1 = $wpdb->get_results("SELECT withdraw_tbl.*, 
		user_tbl.display_name as user_name, 
		user_tbl.user_email 
		FROM {$wpdb->prefix}user_withdraws withdraw_tbl 
		INNER JOIN {$wpdb->users} user_tbl ON withdraw_tbl.user_id = user_tbl.ID
		WHERE 1=1 
		{$query_by_user_sql} 
		{$query_by_status_sql} ORDER BY 
		created_at DESC  {$query_by_pagination} ");

		$withdraw_history2 = array(
			'count' => 0,
			'results' => null,
		);
		
		

		if ($count1){
			$withdraw_history['count'] = $count1;
		}
	
		foreach ($results1 as $result1) {
			$result1->type = "user";
			}
	
		if (tutor_utils()->count($results1)){
			$withdraw_history['results'] = $results1;
		}
		
		return (object) $withdraw_history;

	}
	
function add_user_withdrawl_amount_setting( $settings ) {

  $updated_settings = array();

  foreach ( $settings as $section ) {

    // at the bottom of the General Options section
    if ( isset( $section['id'] ) && 'general_options' == $section['id'] &&
       isset( $section['type'] ) && 'sectionend' == $section['type'] ) {

      $updated_settings[] = array(
        'name'     => __( 'Minimum Withdraw Amount', 'wc_seq_order_numbers' ),
        'id'       => 'woocommerce_user_withdrawl_amount',
        'type'     => 'number',
        'css'      => 'min-width:300px;',
        'std'      => '1',  // WC < 2.0
        'default'  => '80',  // WC >= 2.0
        'desc'     => __( 'Users should earn equal or above this amount to make a withdraw request.', 'wc_seq_order_numbers' ),
      );
    }

    $updated_settings[] = $section;
  }

  return $updated_settings;
}


add_action( 'woocommerce_shop_loop_item_title', 'obox_woocommerce_product_title', 10 );
if (!function_exists('obox_woocommerce_product_title'))  
{ 
     function obox_woocommerce_product_title()  
     { 
	 global $product;
     if ( ! $product->post->get_title ) return;
	?>
	<div itemprop="description">
		<?php echo apply_filters( 'woocommerce_short_description', $product->post->get_title ) ?>
	</div>
	<?php
     } 
}
function mycustomthumbsize()
{
    return array(150, 150,true);
}
add_filter( 'woocommerce_general_settings', 'add_user_withdrawl_amount_setting' );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'obox_woocommerce_product_excerpt', 35, 2); 
if (!function_exists('obox_woocommerce_product_excerpt'))  
{ 
     function obox_woocommerce_product_excerpt()  
     { 
	 global $product;
		//$size = array(750, 940,true);
		$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'mycustomthumbsize' );
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		$condition =  get_post_meta($product->get_id(),'_condition',true); 
	 ?>
	 <div class="boxy-inner">
	 <div class="img-container"><a href = "<?php echo $link; ?>"><?php echo $product ? $product->get_image( $image_size ) : ''; 	?></a><?php if($condition): ?><span class="condition"><?php echo $condition; ?></span><?php endif; ?></div>
	<div class="prd-content">
		<div class="elementor-widget-container">
			<h4 class="elementor-heading-title elementor-size-default"><?php echo $product->post->post_title; ?></h4>		
		</div>
    <?php if ( ! $product->post->post_content ) return;
	?>
	<p class="descrition-wrap">
		<?php 
	echo	$post_content = substr(strip_tags($product->post->post_content),0,100).'...';
	//	echo apply_filters( 'woocommerce_short_description', $post_content ) ?>
	</p>
		<?php $cat_ids = $product->get_category_ids();
 
// if product has categories, concatenate cart item name with them
if ( $cat_ids ) 
	echo $name = wc_get_product_category_list( $product->get_id(), ', ', '<p class="category-wrap">' . _n( 'Type:', 'Type:', count( $cat_ids ), 'woocommerce' ) . ' ', '</p>' );
	$catsarr = array();
  
	$term_obj_list = get_the_terms( $product->get_id(), 'subject' );
	$terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
	
	$term_obj_list1 = get_the_terms( $product->get_id(), 'grade-levels' );
	$terms_string1 = join(', ', wp_list_pluck($term_obj_list1, 'name'));
	$course_tag =  wp_list_sort( $term_obj_list1, 'term_id', 'ASC' );
		
		foreach ($course_tag as $course_category){
			 $category_name = $course_category->name;
			array_push($catsarr,$category_name);
		}
	
if($terms_string)
	echo '<p class="grade-wrap">Subject: '.$terms_string.'</p>';

if(!empty($catsarr))
	echo '<p class="grade-wrap">Grade: '.implode(", ",$catsarr).'</p>';   
	
	//get_the_term_list( $product_id, 'product_tag', $before, $sep, $after );

  ?>
	<div class="btn-wrap"><a href="<?php echo $link ; ?>" class="r_more_btn">Read more</a></div>	
	</div>
	
	<?php
     } 
}



remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 35, 2 );
//add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_product_archive_description', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 45 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 45 );

add_filter( 'add_to_cart_text', 'woo_custom_single_add_to_cart_text' );                // < 2.1
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text' );  // 2.1 +
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
function woo_custom_single_add_to_cart_text() {
  global $product, $post;
  
if($post->post_type == "product"){
    return __( 'Buy Curriculum', 'woocommerce' );
}else{
	 return __( 'Add to Cart', 'woocommerce' );
}
  
}	



//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
/* **/

add_action( 'woocommerce_after_single_product', 'description_and_requirements_products', 20 );
function description_and_requirements_products() {
   global $product,$post;
   $additional_content = get_post_meta($post->ID, '_additional_content', true);
   
   echo '   <section  class="section-wrap pd-spec-wrap" style="clear:both;">
   <div class="container-wrap">
               <div class="row-wrap">';
    if( has_term(20, 'product_cat' ) ) {
   }
   else{
    echo '   
                  <div class="col-wrap">
				  <div id="contentmain" class="course-desc-wrap">
				  <h4 class="heading-title">Curriculum Description</h4>
				  '.$post->post_content.'
					<div class="btn-wrap"><a href="'.$product->add_to_cart_url().'" class="buy-btn">Buy Curriculum</a></div>		
                  </div>				  
                  </div>

				  <div class="col-wrap">
				  <h4 class="heading-title">Curriculum information</h4>
				  <ul class="listing">
					<li><strong>Seller :</strong> ';
					ucfirst(the_author());
				echo	'</li>
				
				  </ul>
				  '.$additional_content.'
                  </div>

				 		 	   			   
           	';
   }
   
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_after_single_product', 'woocommerce_output_product_data_tabs', 30 );



add_filter( 'woocommerce_product_tabs', 'misha_remove_description_tab', 11 );
 
function misha_remove_description_tab( $tabs ) {
 
	unset( $tabs['description'] );
	return $tabs;
 
}

add_shortcode( 'profilepics', 'wpdocs_profile_pic_func' );
function wpdocs_profile_pic_func(  ) {
	global $wpdb;
 $fooval = '';
 $fooval .= '<form class="wordpress-ajax-form" method="post" action="'.admin_url('admin-ajax.php').'">';
 $fooval .= '<input type="hidden" value="add_user_profilepic_action" name="action" >';
	for($i=1;$i<=30;$i++){
		$fooval .= '<div class="p-img"><input type="radio" class="radiocheck" name="profilepic" value="https://myhomeschoolfamily.com/wp-content/themes/hello-theme-yoyovisio/profile-pics/images'.$i.'.png"><img width="75" src = "https://myhomeschoolfamily.com/wp-content/themes/hello-theme-yoyovisio/profile-pics/images'.$i.'.png" /></div>';

    

	}
	$fooval .= '<div class="sub-btn"> <button class="btn">Save Changes</button></div>';
	$fooval .= '</form>';
	return $fooval;
}


add_action( 'wp_ajax_add_user_profilepic_action', 'add_user_profilepic_action' );
add_action( 'wp_ajax_nopriv_add_user_profilepic_action', 'add_user_profilepic_action' );
function add_user_profilepic_action() {
	global $wpdb;
	$user_id = get_current_user_id();
	$getprofilepic = get_user_meta( $user_id, '_user_profile_pic_url', true );
	
	if(empty($getprofilepic)){
		echo $updateval = add_user_meta($user_id, '_user_profile_pic_url', $_POST['profilepic']);
	}else{
		echo $updateval =update_user_meta($user_id, '_user_profile_pic_url', $_POST['profilepic']);
	}
}

/* Code to remove roles from admin */
remove_role( 'contributor' );
remove_role( 'editor' );
remove_role( 'shop_manager' );
remove_role( 'wcfm_vendor' );
remove_role( 'disable_vendor' );
remove_role( 'author' );

/* ends here */

function change_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    //You can list all currently available roles like this...
    //$roles = $wp_roles->get_names();
    //print_r($roles);

    //You can replace "administrator" with any other role "editor", "author", "contributor" or "subscriber"...
    $wp_roles->roles['tutor_instructor']['name'] = 'Educator';
    $wp_roles->role_names['tutor_instructor'] = 'Educator';        

	$wp_roles->roles['subscriber']['name'] = 'Learner';
    $wp_roles->role_names['subscriber'] = 'Learner';   

	$wp_roles->roles['customer']['name'] = 'Seller';
    $wp_roles->role_names['customer'] = 'Seller';  	
}
add_action('init', 'change_role_name');


 add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {
	$posted_custom_fields = $_POST;
	$module = "Leads";
	$url = 'https://accounts.zoho.com/oauth/v2/token';
	$refresh_token = "1000.9bcb1f48938fbce6a26683b3afbff160.42f70c2cd351ace3ee3715dfcb2b9a93";
	$client_id = '1000.Y08N5Z29WS2V8L9TXAM171TB18S7NM';
	$client_secret = '2cc7425e082f385187e011ea216371b3a99799d4d5';
	$grant_type = 'refresh_token';
	
		$headers = array(
			'Content-Type: application/x-www-form-urlencoded'
		);
	
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS , rawurldecode(http_build_query(array(
			'refresh_token' => '1000.9bcb1f48938fbce6a26683b3afbff160.42f70c2cd351ace3ee3715dfcb2b9a93',
			'client_id' => '1000.Y08N5Z29WS2V8L9TXAM171TB18S7NM',
			'client_secret' => '2cc7425e082f385187e011ea216371b3a99799d4d5',
			'grant_type' => 'refresh_token'
		  ))));
		
		$response = curl_exec($ch);

		if(curl_errno($ch)){
			//If an error occured, throw an Exception.
			throw new Exception(curl_error($ch));
		}
		
		$json = json_decode($response);
		 $accessToken = $json->access_token;
	
/* 	$headers = array(
			'Content-Type: application/x-www-form-urlencoded',
			'Authorization: Basic '. base64_encode("$username:$password")
		); */


		$urln1 = 'https://www.zohoapis.com/crm/v2/Leads';
		$headers = array(
			'Content-Type: application/json',
			 'Authorization: Zoho-oauthtoken '.$accessToken
		);

		$curl1 = curl_init($urln1);
		curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl1, CURLOPT_POST, true);
		
		if($posted_custom_fields['seller_register_check'] == "seller_register_check"){
			
		$email = $posted_custom_fields['email'];
		$first_name = $posted_custom_fields['billing_first_name'];
		$last_name = $posted_custom_fields['billing_last_name'];
		$phone = $posted_custom_fields['billing_phone'];
		$address1 = $posted_custom_fields['billing_address_1'];
		$address2 = $posted_custom_fields['billing_address_2'];
		$city = $posted_custom_fields['billing_city'];
		$state = $posted_custom_fields['billing_state'];
		$country = $posted_custom_fields['billing_country'];
		$postcode = $posted_custom_fields['billing_postcode'];
		$street =  $address1.' '.$address2;
		
		curl_setopt($curl1, CURLOPT_POSTFIELDS, '{ "data": [{ "Last_Name": "'.$last_name.'", "First_Name": "'.$first_name.'",  "Email": "'.$email.'", "Phone": "'.$phone.'", "Street": "'.$street.'", "City": "'.$city.'", "State": "'.$state.'", "Country": "'.$country.'", "Zip_Code": "'.$postcode.'", "User_Type": "Customer" } ]}');
		curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers);
		 $response2 = curl_exec($curl1);
		
		 $res1 = json_decode($response2);
		 $headers = array('Content-Type: text/html; charset=UTF-8','From: MyHomeSchoolFamily <info@myhomeschoolfamily.com>');
		$body = "New user registration on your site MyHomeSchoolFamily:";
		$body .= "<p>Username: ".$first_name.' '.$last_name."</p>";
		$body .= "<p>Email: ".$email."</p>";
		$body .= "<p>Role: Seller</p>";
		wp_mail( "registration@myhomeschoolfamily.com", "[MyHomeSchoolFamily] New User Registration", $body, $headers );
		
		}else{
			$email = $posted_custom_fields['email'];
			$first_name = $posted_custom_fields['first_name'];
			$last_name = $posted_custom_fields['last_name'];
			$phone = $posted_custom_fields['phone_number'];
			$tutorAction = $posted_custom_fields['tutor_action'];
			$gender = $posted_custom_fields['gender'];
			$selgender = "";
			$type = "";
			if($gender == "male"){
				$selgender = "Male";
			}else if ($gender == "female"){
				$selgender = "Female";
			}else{
				$selgender = "Other";
			}
			if($tutorAction == "tutor_register_instructor"){
				$type = "Educator";
			}else{
				$type = "Learner";
			}
		curl_setopt($curl1, CURLOPT_POSTFIELDS, '{ "data": [{ "Last_Name": "'.$last_name.'", "First_Name": "'.$first_name.'",  "Email": "'.$email.'", "Phone": "'.$phone.'", "User_Type": "'.$type.'", "Gender": "'.$selgender.'" } ]}');
		curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers);
		 $response2 = curl_exec($curl1);
		
		 $res1 = json_decode($response2);
		 $headers = array('Content-Type: text/html; charset=UTF-8','From: MyHomeSchoolFamily <info@myhomeschoolfamily.com>');
		$body = "New user registration on your site MyHomeSchoolFamily:";
		$body .= "<p>Username: ".$first_name.' '.$last_name."</p>";
		$body .= "<p>Email: ".$email."</p>";
		$body .= "<p>Role: ".$type."</p>";
		wp_mail( "registration@myhomeschoolfamily.com", "[MyHomeSchoolFamily] New User Registration", $body, $headers );
		}
	  curl_close($curl1);
		/* print_r($res1);
		die; */
		
		
}


add_filter ( 'woocommerce_account_menu_items', 'misha_log_history1_link', 40 );
function misha_log_history1_link( $menu_links ){
 
	$menu_links = array_slice( $menu_links, 0, 1, true ) 
	+ array( 'profile' => 'My Profile' )
	+ array_slice( $menu_links, 1, NULL, true );
 
	return $menu_links;
 
}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'misha_add_endpoint1' );
function misha_add_endpoint1() {
 
	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
	add_rewrite_endpoint( 'profile', EP_PAGES );
 
}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_profile_endpoint', 'misha_my_account_endpoint_content1' );
function misha_my_account_endpoint_content1() {
 
	// of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
	get_template_part('template-my-profile');

 
}


################# User reviews page #############################

/* add_filter ( 'woocommerce_account_menu_items', 'misha_log_history2_link', 40 );
function misha_log_history2_link( $menu_links ){
 
	$menu_links = array_slice( $menu_links, 0, 4, true ) 
	+ array( 'user-reviews' => 'My Reviews' )
	+ array_slice( $menu_links, 4, NULL, true );
 
	return $menu_links;
 
} */
/*
 * Step 2. Register Permalink Endpoint
 */
/* add_action( 'init', 'misha_add_endpoint2' );
function misha_add_endpoint2() {
 
	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
	add_rewrite_endpoint( 'user-reviews', EP_PAGES );
 
} */
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
/* add_action( 'woocommerce_account_user-reviews_endpoint', 'misha_my_account_endpoint_content2' );
function misha_my_account_endpoint_content2() {
 
	// of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
	get_template_part('template-user-reviews');

 
} */

###############################################################
/* add_action('woocommerce_order_status_changed', 'ts_auto_complete_by_payment_method');

function ts_auto_complete_by_payment_method($order_id)
{
  
  if ( ! $order_id ) {
        return;
  }

  global $product;
  $order = wc_get_order( $order_id );
  
  if ($order->data['status'] == 'processing') {
        $payment_method=$order->get_payment_method();
        if ($payment_method!="cod")
        {
            $order->update_status( 'completed' );
        }
      
  }
  
} */
/**
 * Auto Complete all WooCommerce orders.
 */
add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order( $order_id ) { 
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );
    $order->update_status( 'completed' );
}

############################################################################

add_action( 'woocommerce_before_edit_account_form', 'wc_cus_cpp_form' );
function wc_cus_cpp_form( $atts, $content= NULL) {
    
    $user_id = get_current_user_id();
    
    if( $_GET['action'] == 'delete' ){
        $picture_id = get_user_meta( $user_id, 'profile_pic', true );
        delete_user_meta( $user_id, 'profile_pic' );
        //wp_delete_attachment( $picture_id, true ); // either one will work
        wp_delete_post( $picture_id, true );
    }
    if( $_FILES['profile_pic'] and trim( $_FILES['profile_pic']['name'] ) != '' ){
        $picture_id = wc_cus_upload_picture($_FILES['profile_pic']);
        wc_cus_save_profile_pic($picture_id, $user_id);
    }
    
    echo '<h2>Profile Picture</h2>';
    
    $picture_id = get_user_meta( $user_id, 'profile_pic', true );
    
    if( trim( $picture_id ) == '' ) :
        $delete_link = '';
    else:
        $delete_link = '<a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'/edit-account/?action=delete">Delete Avatar</a>';
    endif;
    echo '<div style="margin-bottom: 15px;">';
    echo get_avatar($user_id).'<br>';
    echo $delete_link;
    echo '</div>';
    
    echo '<div style="margin-bottom: 45px;">';
    echo '
        <form enctype="multipart/form-data" action="" method="POST">
            <input name="profile_pic" type="file" size="25"><br><br>
            <input type="submit" value="Upload">
        </form>
    ';
    echo '</div>';
    
    //echo '<h2>Personal Information</h2>';
    
}
// =========================================================================
/**
 * Function wc_cus_save_profile_pic
 *
 */
function wc_cus_save_profile_pic($picture_id, $user_id){
$usermeta =  update_user_meta( $user_id, 'profile_pic', $picture_id );
if($usermeta){
	 wp_redirect('/user-account/edit-account/');
}
  
}
// =========================================================================
/**
 * Function wc_cus_upload_picture
 *
 */
function wc_cus_upload_picture( $foto ) {
  $wordpress_upload_dir = wp_upload_dir();
  // $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
  // $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
  $i = 1; // number of tries when the file with the same name is already exists
  $profilepicture = $foto;
  $new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
  
  /* we fixed this, mime_content_type() was not working */
  //$new_file_mime = mime_content_type( $profilepicture['tmp_name'] );
  $check = getimagesize($profilepicture['tmp_name']);
  $new_file_mime = $check["mime"];
  
  $log = new WC_Logger();        
  
  if( empty( $profilepicture ) )
  $log->add('custom_profile_picture','File is not selected.');    
  if( $profilepicture['error'] )
  $log->add('custom_profile_picture',$profilepicture['error']);    
  
  if( $profilepicture['size'] > wp_max_upload_size() )
  $log->add('custom_profile_picture','It is too large than expected.');    
  
  if( !in_array( $new_file_mime, get_allowed_mime_types() ))
  $log->add('custom_profile_picture','WordPress doesn\'t allow this type of uploads.' );        
  while( file_exists( $new_file_path ) ) {
  $i++;
  $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
  }
  // looks like everything is OK
  if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {
  
  $upload_id = wp_insert_attachment( array(
    'guid'           => $new_file_path, 
    'post_mime_type' => $new_file_mime,
    'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
    'post_content'   => '',
    'post_status'    => 'inherit'
  ), $new_file_path );
  /* we fixed this, get_admin_url() was not working by itself */
  // wp_generate_attachment_metadata() won't work if you do not include this file
  require_once( str_replace( get_bloginfo( 'url' ) . '/', ABSPATH, get_admin_url() ) . 'includes/image.php' );
  // Generate and save the attachment metas into the database
  wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
  return $upload_id;
  }
}
// =========================================================================
/**
 * Function wc_cus_change_avatar
 *
 */
add_filter( 'get_avatar' , 'wc_cus_change_avatar' , 1 , 5 );
function wc_cus_change_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;
    if ( is_numeric( $id_or_email ) ) {
        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );
    } elseif ( is_object( $id_or_email ) ) {
        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }
    } else {
        $user = get_user_by( 'email', $id_or_email );    
    }
    if ( $user && is_object( $user ) ) {
    $picture_id = get_user_meta($user->data->ID,'profile_pic');
    if(! empty($picture_id)){
      $avatar = wp_get_attachment_url( $picture_id[0] );
      $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
    }
    }
    return $avatar;
}



add_action('wp_logout','auto_redirect_after_logout');

function auto_redirect_after_logout(){

  wp_redirect( '/my-account/' );
  exit();

}
add_filter( 'ajax_query_attachments_args', 'show_current_user_attachments' );

function show_current_user_attachments( $query ) {
    $user_id = get_current_user_id();
	$user = wp_get_current_user();
	if(!in_array( 'administrator', (array) $user->roles )){
		if ( $user_id ) {
			$query['author'] = $user_id;
		}
	}
    return $query;
}
/*
 * Step 1. Add Link (Tab) to My Account menu
 */
add_filter ( 'woocommerce_account_menu_items', 'misha_log_history_link', 40 );
function misha_log_history_link( $menu_links ){
 
	$menu_links = array_slice( $menu_links, 0, 5, true ) 
	+ array( 'sales-history' => 'Sales History' )
	+ array_slice( $menu_links, 5, NULL, true );
 
	return $menu_links;
 
}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'misha_add_endpoint89' );
function misha_add_endpoint89() {
 
	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
	add_rewrite_endpoint( 'sales-history', EP_PAGES );
 
}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_sales-history_endpoint', 'misha_my_account_endpoint_content89' );
function misha_my_account_endpoint_content89() {
 
	// of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
	get_template_part('template-sales-history');
 
}
/*
 * Step 4
 */
add_filter( 'manage_users_columns', 'rudr_modify_user_table' );
 
function rudr_modify_user_table( $columns ) {
 
	// unset( $columns['posts'] ); // maybe you would like to remove default columns
	$columns['registration_date'] = 'Registration date'; // add new
 
	return $columns;
 
}
 
/*
 * Fill our new column with the registration dates of the users
 * @param string $row_output text/HTML output of a table cell
 * @param string $column_id_attr column ID
 * @param int $user user ID (in fact - table row ID)
 */
add_filter( 'manage_users_custom_column', 'rudr_modify_user_table_row', 10, 3 );
 
function rudr_modify_user_table_row( $row_output, $column_id_attr, $user ) {
 
	$date_format = 'j M, Y H:i';
 
	switch ( $column_id_attr ) {
		case 'registration_date' :
			return date( $date_format, strtotime( get_the_author_meta( 'registered', $user ) ) );
			break;
		default:
	}
 
	return $row_output;
 
}
 
/*
 * Make our "Registration date" column sortable
 * @param array $columns Array of all user sortable columns {column ID} => {orderby GET-param} 
 */
add_filter( 'manage_users_sortable_columns', 'rudr_make_registered_column_sortable' );
 
function rudr_make_registered_column_sortable( $columns ) {
	return wp_parse_args( array( 'registration_date' => 'registered' ), $columns );
}

/* function wpse66094_no_admin_access() {
    $redirect = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : home_url( '/my-account' );
    global $current_user;
   
    if ( isset( $current_user->roles ) && is_array( $current_user->roles ) ) {
		if ( in_array( 'tutor_instructor', $current_user->roles ) && !in_array( 'administrator', $current_user->roles ) ) {
			exit( wp_redirect( $redirect ) );
		}
    }
 }

add_action( 'admin_init', 'wpse66094_no_admin_access', 1 ); */

add_action( 'woocommerce_order_item_meta_start', 'ts_order_item_meta_start', 10, 4 );
function ts_order_item_meta_start( $item_id, $item, $order, $plain_text ){
	
	$itemid = $item['product_id'];
$terms = get_the_terms( $itemid, 'product_cat' );

	echo '<p style="margin-top:10px;color:red;"> Type: '.$terms[0]->name.'</p>';
}

function add_this_to_new_products( $new_status, $old_status, $post ) {
    global $post;
	
	
    if ( 'publish' !== $new_status or 'publish' === $old_status ) return;
	if($_POST['ns-is-edit-prod'] == ""  && $_POST['ns-add-product-frontend-ca-checkbox'] != ""){
		$to = "info@myhomeschoolfamily.com";
		$body = 'The new '.$_POST['ns-product-name'].' Product is added';
		$headers = array('Content-Type: text/html; charset=UTF-8','From: MyHomeSchoolFamily <info@myhomeschoolfamily.com>');
		wp_mail( $to, "New Product added", $body, $headers );
	}
	 
}
add_action( 'transition_post_status', 'add_this_to_new_products', 10, 3 );
function add_this_to_new_classes( ) {

			$to = "info@myhomeschoolfamily.com";
			$body = 'The new '.get_the_title($_POST['post_ID']).' class is added <a href="'.get_the_permalink($_POST['post_ID']).'">'.get_the_permalink($_POST['post_ID']).'</a>';
			$headers = array('Content-Type: text/html; charset=UTF-8','From: MyHomeSchoolFamily <info@myhomeschoolfamily.com>');
		
			wp_mail( $to, "New Class added", $body, $headers );

	 
}
add_action( 'auto-draft_to_publish', 'add_this_to_new_classes', 10, 3 );