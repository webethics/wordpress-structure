<?
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

do_action( 'tutor_before_reset_password_form' ); ?>

<form method="post" class="tutor-ResetPassword lost_reset_password">
	<? tutor_nonce_field(); ?>
	<input type="hidden" name="tutor_action" value="tutor_process_reset_password">
	<input type="hidden" name="reset_key" value="<? echo tutils()->array_get('reset_key', $_GET); ?>" />
	<input type="hidden" name="user_id" value="<? echo tutils()->array_get('user_id', $_GET); ?>" />
	<div class="tutor-template-segment tutor-login-wrap">
	<p>
		<? echo apply_filters( 'tutor_reset_password_message', esc_html__( 'Enter Password and Confirm Password to reset your password', 'tutor' )
		); ?>
	</p>

	<div class="tutor-form-row">
		<div class="tutor-form-col-6">
			<div class="tutor-form-group">
				<label><? esc_html_e( 'Password', 'tutor' ); ?></label>
				<input type="password" name="password" id="password">
			</div>
		</div>
	</div>

	<div class="tutor-form-row">
		<div class="tutor-form-col-6">
			<div class="tutor-form-group">
				<label><? esc_html_e( 'Confirm Password', 'tutor' ); ?></label>
				<input type="password" name="confirm_password" id="confirm_password">
			</div>
		</div>
	</div>

	<div class="clear"></div>

	<? do_action( 'tutor_reset_password_form' ); ?>

	<div class="tutor-form-row">
		<div class="tutor-form-col-6">
			<div class="tutor-form-group">
				<button type="submit" class="tutor-button tutor-button-primary" value="<? esc_attr_e( 'Reset password', 'tutor' ); ?>"><?
					esc_html_e( 'Reset password', 'tutor' ); ?></button>
			</div>
		</div>
	</div>
	</div>
</form>

<? do_action( 'tutor_after_reset_password_form' ); ?>
