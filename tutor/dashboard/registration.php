<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>

<form method="post" enctype="multipart/form-data">
	<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
    <input type="hidden" value="tutor_register_student" name="tutor_action"/>

    <?php
    $errors = apply_filters('tutor_student_register_validation_errors', array());
	$first_name = "";
	$last_name = "";
	$email = "";
	$user_login = "";
	$password = "";
	$password_confirmation = "";
	$phone_number = "";
	
    if (is_array($errors) && count($errors)){
        foreach ($errors as $error_key => $error_value){
			
			if($error_value == "First name field is required"){
				$first_name = $error_value;
			}
			if($error_value == "Last name field is required"){
				$last_name = $error_value;
			}
			if($error_value == "Valid E-Mail is required" || $error_value == "Sorry, that email address is already used!"){
				$email = $error_value;
			}
			if($error_value == "User Name field is required" || $error_value == "Sorry, that username already exists!"){
				$user_login = $error_value;
			}
			if($error_value == "Password field is required"){
				$password = $error_value;
			}
			if($error_value == "Password Confirmation field is required" || $error_value == "Confirm password does not matched with Password field"){
				$password_confirmation = $error_value;
			}
			if($error_value == "Phone Number field is required"){
				$phone_number = $error_value;
			}
        }
    }
    ?>

    <div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
					<?php _e('First Name', 'tutor'); ?>
                </label>
				<span class="error"><?php echo $first_name; ?></span>
                <input type="text" name="first_name" value="<?php echo tutor_utils()->input_old('first_name'); ?>" placeholder="<?php _e('First Name', 'tutor'); ?>">
				
            </div>
        </div>
    </div>
	<div class="tutor-form-row">
		<div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
					<?php _e('Last Name', 'tutor'); ?>
                </label>
				<span class="error"><?php echo $last_name; ?></span>
                <input type="text" name="last_name" value="<?php echo tutor_utils()->input_old('last_name'); ?>" placeholder="<?php _e('Last Name', 'tutor'); ?>">
				
            </div>
        </div>
	</div>
    <div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
				    <?php _e('User Name', 'tutor'); ?>
                </label>
				<span class="error"><?php echo $user_login; ?></span>
                <input type="text" name="user_login" class="tutor_user_name" value="<?php echo tutor_utils()->input_old('user_login'); ?>" placeholder="<?php _e('User Name', 'tutor'); ?>">
				
            </div>
        </div>

        

    </div>
	<div class="tutor-form-row">
		<div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
					<?php _e('E-Mail', 'tutor'); ?>
                </label>
				<span class="error"><?php echo $email; ?></span>
                <input type="text" name="email" value="<?php echo tutor_utils()->input_old('email'); ?>" placeholder="<?php _e('E-Mail', 'tutor'); ?>">
				
            </div>
        </div>
	</div>
	 <div class="tutor-form-row">

        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
                    <?php _e('Phone Number', 'tutor'); ?>
                </label>
				<span class="error"><?php echo $phone_number; ?></span>
                <input type="text" name="phone_number" value="<?php echo tutor_utils()->input_old('phone_no'); ?>" placeholder="<?php _e('Phone Number', 'tutor'); ?>">
				
            </div>
        </div>

    </div>
    <div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
					<?php _e('Password', 'tutor'); ?>
                </label>
				<span class="error"><?php echo $password; ?></span>
                <input type="password" name="password" value="<?php echo tutor_utils()->input_old('password'); ?>" placeholder="<?php _e('Password', 'tutor'); ?>">
            </div>
        </div>

    </div>
	<div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
					<?php _e('Password confirmation', 'tutor'); ?>
                </label>
				<span class="error"><?php echo $password_confirmation; ?></span>
                <input type="password" name="password_confirmation" value="<?php echo tutor_utils()->input_old('password_confirmation'); ?>" placeholder="<?php _e('Password Confirmation', 'tutor'); ?>">
				
            </div>
        </div>
	</div>
	<div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
				<div>By creating an account, you agree to MyHomeSchoolFamily. Terms & Conditions and Privacy Policy<br/> </div>
            </div>
        </div>
    </div>
    <div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group tutor-reg-form-btn-wrap">
                <button type="submit" name="tutor_register_student_btn" value="register" class="tutor-button"><?php _e('Register', 'tutor'); ?></button>
            </div>
        </div>
    </div>

</form>