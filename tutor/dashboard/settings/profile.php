<?
/**
 * @package TutorLMS/Templates
 * @version 1.6.2
 */

$user = wp_get_current_user();
?>

<div class="tutor-dashboard-content-inner">

    <? do_action('tutor_profile_edit_form_before'); ?>

    <form action="" method="post" enctype="multipart/form-data">
        <? wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
        <input type="hidden" value="tutor_profile_edit" name="tutor_action" />

        <?
        $errors = apply_filters('tutor_profile_edit_validation_errors', array());
        if (is_array($errors) && count($errors)){
            echo '<div class="tutor-alert-warning tutor-mb-10"><ul class="tutor-required-fields">';
            foreach ($errors as $error_key => $error_value){
                echo "<li>{$error_value}</li>";
            }
            echo '</ul></div>';
        }
        ?>

        <? do_action('tutor_profile_edit_input_before'); ?>

        <div class="tutor-form-row">
            <div class="tutor-form-col-4">
                <div class="tutor-form-group">
                    <label>
                        <? _e('First Name', 'tutor'); ?>
                    </label>
                    <input type="text" name="first_name" value="<? echo $user->first_name; ?>" placeholder="<? _e('First Name', 'tutor'); ?>">
                </div>
            </div>

            <div class="tutor-form-col-4">
                <div class="tutor-form-group">
                    <label>
                        <? _e('Last Name', 'tutor'); ?>
                    </label>
                    <input type="text" name="last_name" value="<? echo $user->last_name; ?>" placeholder="<? _e('Last Name', 'tutor'); ?>">
                </div>
            </div>

            <div class="tutor-form-col-4">
                <div class="tutor-form-group">
                    <label>
                        <? _e('Phone Number', 'tutor'); ?>
                    </label>
                    <input type="text" name="phone_number" value="<? echo get_user_meta($user->ID,'phone_number',true); ?>" placeholder="<? _e('Phone Number', 'tutor'); ?>">
                </div>
            </div>
        </div>

        <div class="tutor-form-row">
            <div class="tutor-form-col-12">
                <div class="tutor-form-group">
                    <label>
                        <? _e('Bio', 'tutor'); ?>
                    </label>
                    <textarea name="tutor_profile_bio"><? echo strip_tags(get_user_meta($user->ID,'_tutor_profile_bio',true)); ?></textarea>
                </div>
            </div>
        </div>
		<? if ( in_array( 'tutor_instructor', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles )) { ?>
        <div class="tutor-form-row">
            <div class="tutor-form-col-6">
                <div class="tutor-form-group">
                    <label>
                        <? _e('Profile Photo', 'tutor'); ?>
                    </label>
                    <div class="tutor-profile-photo-upload-wrap">
                        <?
                        $profile_photo_src = tutor_placeholder_img_src();
                        $profile_photo_id = get_user_meta($user->ID, '_tutor_profile_photo', true);
                        if ($profile_photo_id){
                            $profile_photo_src = wp_get_attachment_image_url($profile_photo_id, 'thumbnail');
                        }
                        ?>
                        <a href="javascript:;" class="tutor-profile-photo-delete-btn"><i class="tutor-icon-garbage"></i> </a>
                        <img src="<? echo $profile_photo_src; ?>" class="profile-photo-img">
                        <input type="hidden" id="tutor_profile_photo_id" name="tutor_profile_photo_id" value="<? echo $profile_photo_id; ?>">
                        <input type="file" name="tutor_profile_photo_file" id="tutor_profile_photo_file" style="display:none"/>
                        <button type="button" id="tutor_profile_photo_button" class="tutor-profile-photo-upload-btn"><? _e('Upload Image', 'tutor'); ?></button>
                    </div>
                </div>
            </div>
		<? } ?>

        </div>


        <?
        /*$tutor_user_social_icons = tutor_utils()->tutor_user_social_icons();
        foreach ($tutor_user_social_icons as $key => $social_icon){
            ?>
            <div class="tutor-form-row">
                <div class="tutor-form-col-12">
                    <div class="tutor-form-group">
                        <label for="<? echo esc_attr($key); ?>"><? echo esc_html($social_icon['label']); ?></label>
                        <input type="text" id="<? echo esc_attr($key); ?>" name="<? echo esc_attr($key); ?>" value="<? echo get_user_meta($user->ID,$key,true); ?>" placeholder="<? echo esc_html($social_icon['placeholder']); ?>">
                    </div>
                </div>
            </div>
            <?
        }*/

        ?>

        <div class="tutor-form-row">
            <div class="tutor-form-col-12">
                <div class="tutor-form-group tutor-profile-form-btn-wrap">
                    <button type="submit" name="tutor_register_student_btn" value="register" class="tutor-button"><? _e('Update Profile', 'tutor'); ?></button>
                </div>
            </div>
        </div>



        <? do_action('tutor_profile_edit_input_after'); ?>

    </form>

    <? do_action('tutor_profile_edit_form_after'); ?>

</div>