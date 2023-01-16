<?
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>

<form method="post" enctype="multipart/form-data">
	<? wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
    <!--input type="hidden" value="tutor_register_instructor" name="tutor_action"/-->
	
    <?
	
	if($_POST['tutor_action'] == "tutor_register_student"){
		$errors = apply_filters('tutor_student_register_validation_errors', array());
	}
	if($_POST['tutor_action'] == "tutor_register_instructor"){
		$errors = apply_filters('tutor_instructor_register_validation_errors', array());
	}
	
	$first_name = "";
	$last_name = "";
	$email = "";
	$gender = "";
	$user_login = "";
	$password = "";
	$password_confirmation = "";
	$phone_number = "";
	$dob = "";
	
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
			if($error_value == "Gender field is required"){
				$gender = $error_value;
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
			if($error_value == "DOB field is required"){
				$dob = $error_value;
			}
			
        }
    }
	
    ?>
	<div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
					<? _e('Account Type', 'tutor'); ?>
                </label>
				<span class="error"><? echo $account_type; ?></span>
				
				<select name="tutor_action">
					<option <? if(!isset($_GET['account'])){echo "selected";} ?> value="tutor_register_instructor">Educator - Instructor/Tutor</option>
					<option <? if(isset($_GET['account']) && $_GET['account'] == "learner"){echo "selected";} ?> value="tutor_register_student">Learner/Student</option>
				</select>
                
            </div>
        </div>
    </div>
    <div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
				<? if($_GET['account'] == 'learner'){ 
					_e('Student First Name', 'tutor'); 
				}
				else{
					 _e('First Name', 'tutor'); 
				}
				?>
                </label>
				<span class="error"><? echo $first_name; ?></span>
                <input type="text" name="first_name" value="<? echo tutor_utils()->input_old('first_name'); ?>" placeholder="<? _e('First Name', 'tutor'); ?>">
            </div>
        </div>
    </div>  
	<div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
					<? if($_GET['account'] == 'learner'){ 
						_e('Student Last Name', 'tutor'); 
					}
					else{
						 _e('Last Name', 'tutor'); 
					}
					?>
					
                </label>
				<span class="error"><? echo $last_name; ?></span>
                <input type="text" name="last_name" value="<? echo tutor_utils()->input_old('last_name'); ?>" placeholder="<? _e('Last Name', 'tutor'); ?>">
            </div>
        </div>
    </div>

    <div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
				    <? _e('User Name', 'tutor'); ?>
                </label>
				<span class="error"><? echo $user_login; ?></span>
                <input type="text" name="user_login" class="tutor_user_name" value="<? echo tutor_utils()->input_old('user_login'); ?>" placeholder="<? _e('User Name', 'tutor'); ?>">
            </div>
        </div>
    </div>
	<div class="tutor-form-row">
		<div class="tutor-form-col-12">
				<div class="tutor-form-group">
					<label>
						<? _e('E-Mail', 'tutor'); ?>
					</label>
					<span class="error"><? echo $email; ?></span>
					<input type="text" name="email" value="<? echo tutor_utils()->input_old('email'); ?>" placeholder="<? _e('E-Mail', 'tutor'); ?>">
				</div>
		</div>
	</div>
	<div class="tutor-form-row">
		<div class="tutor-form-col-12">
				<div class="tutor-form-group">
					<label>
						<? _e('Gender', 'tutor'); ?>
					</label>
					<span class="error"><? echo $gender; ?></span>
					<select name="gender">
						<option value="">Select Gender</option>
						<option value="male">Male</option>
						<option value="female">Female</option>
				</select>
				</div>
		</div>
	</div>
	<? if($_GET['account'] == 'learner'){ ?>
	<div class="tutor-form-row">
		<div class="tutor-form-col-12">
				<div class="tutor-form-group">
					<label>
						<? _e('DOB', 'tutor'); ?>
					</label>
					<span class="error"><? echo $dob; ?></span>
					<input type="text" name="dob" placeholder="DD/MM/YYYY">
				</div>
		</div>
	</div>
	<? } ?>
	<div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
				    <? _e('Phone Number', 'tutor'); ?>
                </label>
				<span class="error"><? echo $phone_number; ?></span>
                <input type="text" name="phone_number" value="<? echo tutor_utils()->input_old('phone_number'); ?>" placeholder="Phone Number">
            </div>
        </div>
    </div>

    <div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
					<? _e('Password', 'tutor'); ?>
                </label>
				<span class="error"><? echo $password; ?></span>
                <input type="password" name="password" value="<? echo tutor_utils()->input_old('password'); ?>" placeholder="<? _e('Password', 'tutor'); ?>">
            </div>
        </div>
    </div>
	<div class="tutor-form-row">
        <div class="tutor-form-col-12">
            <div class="tutor-form-group">
                <label>
					<? _e('Password confirmation', 'tutor'); ?>
                </label>
				<span class="error"><? echo $password_confirmation; ?></span>
                <input type="password" name="password_confirmation" value="<? echo tutor_utils()->input_old('password_confirmation'); ?>" placeholder="<? _e('Password Confirmation', 'tutor'); ?>">
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
				<button type="submit" name="tutor_register_instructor_btn" value="register" class="tutor-button"><? _e('Create Account', 'tutor'); ?></button>
            </div>
        </div>
    </div>

</form>