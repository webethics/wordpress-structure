<?php
/**
 * My profile
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
 
global $wpdb;

$uid = get_current_user_id();
$user = get_userdata( $uid );


$rdate = date( "D d M Y, h:i:s a", strtotime( $user->user_registered ) );
 $fname = $user->first_name;
$lname = $user->last_name;
$uname = $user->user_login;
$email = $user->user_email;
$phone = get_user_meta($uid,'phone_number',true);
?>

<h3><?php _e('My Profile', 'tutor'); ?></h3>
<div class="tutor-dashboard-content-inner">
    <div class="tutor-dashboard-profile">
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><?php _e('Registration Date', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><?php echo esc_html($rdate) ?>&nbsp;</p>
            </div>
        </div>
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><?php _e('First Name', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><?php echo $fname ? $fname : esc_html('________'); ?>&nbsp;</p>
            </div>
        </div>
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><?php _e('Last Name', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><?php echo $lname ? $lname : __('________'); ?>&nbsp;</p>
            </div>
        </div>
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><?php _e('Username', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><?php echo $uname; ?>&nbsp;</p>
            </div>
        </div>
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><?php _e('Email', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><?php echo $email; ?>&nbsp;</p>
            </div>
        </div>
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><?php _e('Phone Number', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><?php echo $phone ? $phone : "________"; ?>&nbsp;</p>
            </div>
        </div>

      

		<a class="tutor-btn bordered-btn" href="/user-account/edit-account"><i class="tutor-icon-checkbox-pen-outline"></i> &nbsp; Edit Information</a>
    </div>

</div>