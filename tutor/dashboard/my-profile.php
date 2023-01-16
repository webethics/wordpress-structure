<?
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */


$uid = get_current_user_id();
$user = get_userdata( $uid );

$profile_settings_link = tutor_utils()->get_tutor_dashboard_page_permalink('settings');
$rdate = date( "D d M Y, h:i:s a", strtotime( $user->user_registered ) );
$fname = $user->first_name;
$lname = $user->last_name;
$uname = $user->user_login;
$email = $user->user_email;
$phone = get_user_meta($uid,'phone_number',true);
$bio = nl2br(strip_tags(get_user_meta($uid,'_tutor_profile_bio',true)));
?>

<h3><? _e('My Profile', 'tutor'); ?></h3>
<div class="tutor-dashboard-content-inner">
    <div class="tutor-dashboard-profile">
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><? _e('Registration Date', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><? echo esc_html($rdate) ?>&nbsp;</p>
            </div>
        </div>
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><? _e('First Name', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><? echo $fname ? $fname : esc_html('________'); ?>&nbsp;</p>
            </div>
        </div>
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><? _e('Last Name', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><? echo $lname ? $lname : __('________'); ?>&nbsp;</p>
            </div>
        </div>
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><? _e('Username', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><? echo $uname; ?>&nbsp;</p>
            </div>
        </div>
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><? _e('Email', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><? echo $email; ?>&nbsp;</p>
            </div>
        </div>
        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><? _e('Phone Number', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><? echo $phone ? $phone : "________"; ?>&nbsp;</p>
            </div>
        </div>

        <div class="tutor-dashboard-profile-item">
            <div class="heading">
                <span><? _e('Bio', 'tutor'); ?></span>
            </div>
            <div class="content">
                <p><? echo $bio ? $bio : '________'; ?>&nbsp;</p>
            </div>
        </div>

		<a class="tutor-btn bordered-btn" href="/my-account/settings"><i class="tutor-icon-checkbox-pen-outline"></i> &nbsp; Edit Information</a>
    </div>

</div>

