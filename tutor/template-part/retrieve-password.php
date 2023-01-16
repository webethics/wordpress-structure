<?
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="tutor-dashboard-content-inner">
<?
if (tutils()->array_get('reset_key', $_GET) && tutils()->array_get('user_id', $_GET)){
    tutor_load_template('template-part.form-retrieve-password');
}else{
	do_action( 'tutor_before_retrieve_password_form' );
	?>
	<div class="tutor-template-segment tutor-login-wrap">
	<div class="tutor-alert-error"><? tutor_alert(null, 'any'); ?></div>
    <form method="post" class="tutor-ResetPassword lost_reset_password">
		<? tutor_nonce_field(); ?>
        <input type="hidden" name="tutor_action" value="tutor_retrieve_password">

        <p class="error"><? echo apply_filters( 'tutor_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'tutor' ) ); ?></p><? // @codingStandardsIgnoreLine ?>

        <div class="tutor-form-row">
            <div class="tutor-form-col-12">
                <div class="tutor-form-group">
                    <label><strong><? esc_html_e( 'Username or email', 'tutor' ); ?></strong></label>

                    <input type="text" name="user_login" id="user_login" autocomplete="username">
                </div>
            </div>
        </div>

        <div class="clear"></div>

		<? do_action( 'tutor_lostpassword_form' ); ?>

        <div class="tutor-form-row">
            <div class="tutor-form-col-12">
                <div class="tutor-form-group">
                    <button type="submit" class="tutor-button tutor-button-primary" value="<? esc_attr_e( 'Reset password', 'tutor' ); ?>"><?
						esc_html_e( 'Reset password', 'tutor' ); ?></button>
                </div>
            </div>
        </div>

    </form>
	</div>
	<?
	do_action( 'tutor_after_retrieve_password_form' );
}
?>
</div>