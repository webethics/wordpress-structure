<?
/**
 * Template for displaying student Public Profile
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

get_header();


global $wp_query;

$dashboard_page_slug = '';
$dashboard_page_name = '';
if (isset($wp_query->query_vars['tutor_dashboard_page']) && $wp_query->query_vars['tutor_dashboard_page']) {
    $dashboard_page_slug = $wp_query->query_vars['tutor_dashboard_page'];
    $dashboard_page_name = $wp_query->query_vars['tutor_dashboard_page'];
}
/**
 * Getting dashboard sub pages
 */
if (isset($wp_query->query_vars['tutor_dashboard_sub_page']) && $wp_query->query_vars['tutor_dashboard_sub_page']) {
    $dashboard_page_name = $wp_query->query_vars['tutor_dashboard_sub_page'];
    if ($dashboard_page_slug){
        $dashboard_page_name = $dashboard_page_slug.'/'.$dashboard_page_name;
    }
}

$user_id = get_current_user_id();
$user = get_user_by('ID', $user_id);
$status = get_user_meta($user_id, '_tutor_instructor_status',true);
$gender = get_user_meta($user_id, 'genderstatus',true);
do_action('tutor_dashboard/before/wrap');

$new_user = get_userdata($user_id);
$full_name = $new_user->user_firstname;


$roleuser = wp_get_current_user();

$instrcutormessage = get_option("instrcutormessage");
$studentmessage = get_option("studentmessage");
$allmessage = get_option("allmessage");

?>

    <div class="tutor-wrap tutor-dashboard tutor-dashboard-student">
	
        <div class="tutor-container">
            <div class="tutor-row">
                <div class="tutor-col-12">
                    <div class="tutor-dashboard-header">
                        <div class="tutor-dashboard-header-avatar profile-pic-dsbrd">
							<? 
							$getprofilepic = get_user_meta( $user_id, '_user_profile_pic_url', true );
							
							if (current_user_can(tutor()->instructor_role)){ ?>
								<img src="<? echo get_avatar_url($user_id, array('size' => 150)); ?>" />
							<? }	
								elseif(in_array( 'subscriber', (array) $user->roles ) && !in_array( 'tutor_instructor', (array) $user->roles ) && $gender == "male"){
								
								echo do_shortcode('[elementor-template id="10849"]');
							?>
									 <img src="<? if($getprofilepic == ""){echo get_stylesheet_directory_uri().'/images/male.png'; }else{ echo $getprofilepic ; }?>">
							<?
								}
								elseif(in_array( 'subscriber', (array) $user->roles ) && !in_array( 'tutor_instructor', (array) $user->roles ) && $gender == "female"){
									echo do_shortcode('[elementor-template id="10849"]');
							?>
									 <img src="<? if($getprofilepic == ""){echo get_stylesheet_directory_uri().'/images/female.png'; }else{ echo $getprofilepic ; }?>">
							<?
								}
								else
								{
									//echo do_shortcode('[elementor-template id="10849"]');
							?>
									<img src="<? if($getprofilepic == ""){ echo get_avatar_url($user_id, array('size' => 150)); }else{ echo $getprofilepic ; }?>" />
							<?
								}
							?>
                        </div>
                        <div class="tutor-dashboard-header-info">
                            <div class="tutor-dashboard-header-display-name">
                                <h4><? _e('Hi,', 'tutor'); ?> <strong><? echo $full_name; ?></strong> </h4>
								<? if ( in_array( 'subscriber', (array) $user->roles ) && !in_array( 'tutor_instructor', (array) $user->roles ) && $status == "") { echo "<h5>Learner</h5>"; } 
								elseif ( in_array( 'tutor_instructor', (array) $user->roles )) { echo "<h5>Educator</h5>"; }
								else {  } ?>
                            </div>
                            <? $instructor_rating = tutor_utils()->get_instructor_ratings($user->ID); ?>
                            <?
                            if (current_user_can(tutor()->instructor_role)){
                                ?>
                                <div class="tutor-dashboard-header-stats">
                                    <div class="tutor-dashboard-header-ratings">
                                        <? tutor_utils()->star_rating_generator($instructor_rating->rating_avg); ?>
                                        <span><? echo esc_html($instructor_rating->rating_avg);  ?></span>
                                        <span> (<? echo sprintf(__('%d Ratings', 'tutor'), $instructor_rating->rating_count); ?>) </span>
                                    </div>
                                    <!--<div class="tutor-dashboard-header-notifications">
                                        <? /*_e('Notification'); */?> <span>9</span>
                                    </div>-->
                                </div>
                            <? } ?>
							
                        </div>

                        <div class="tutor-dashboard-header-button">
						
							<? if(in_array( 'customer', (array) $user->roles ) && $status != "blocked"){ ?><a class="tutor-btn bordered-btn" href="/user-account/">Go To Seller Account</a> <? } ?>
							<? 
                            if(current_user_can(tutor()->instructor_role)){
                                $course_type = tutor()->course_post_type;
                                ?>
                               <a class="tutor-btn bordered-btn" href="<? echo apply_filters('frontend_course_create_url', admin_url("post-new.php?post_type=".tutor()->course_post_type)); ?>">
                                    <? echo sprintf(__('%s Add A New Live Class ', 'tutor'), '<i class="tutor-icon-checkbox-pen-outline"></i> &nbsp;'); ?>
                                </a>
								 <a class="tutor-btn bordered-btn" href="/my-account/create-course/?type=on-demand-classes&relationclass=child">
                                    <? echo sprintf(__('%s Add OnDemand Teaching Video', 'tutor'), '<i class="tutor-icon-checkbox-pen-outline"></i> &nbsp;'); ?>
                                </a>
								 <a class="tutor-btn bordered-btn" href="/my-account/create-course/?type=on-demand-classes&relationclass=parent">
                                    <? echo sprintf(__('%s Add New OnDemand Class ', 'tutor'), '<i class="tutor-icon-checkbox-pen-outline"></i> &nbsp;'); ?>
                                </a>
                                <?
                            }else{
                                if (tutor_utils()->get_option('enable_become_instructor_btn')) {
                                    ?>
                                    <a class="tutor-btn bordered-btn" href="<? echo esc_url(tutor_utils()->instructor_register_url()); ?>">
                                        <? echo sprintf(__("%s Become an instructor", 'tutor'), '<i class="tutor-icon-man-user"></i> &nbsp;'); ?>
                                    </a>
                                    <?
                                }
                            }
                            ?>
							
                        </div>
						<? if($status == "pending"){ echo "<div><h5 style='color:#25a9e0;'>You're account is almost done. Until then, please enjoy all of the offerings of the site. You may begin creating classes and saving as drafts until the security steps are complete.</h5><h5 style='text-align: center;font-style: italic;'><a style='text-decoration: underline;' target='_blank' id='bgcheckid' href='https://myhomeschoolfamily.com/background-check-form/'>Please click here to complete your background check</a></h5></div>"; } ?>
						<? if($status == "blocked"){ ?>
							<div style="float:right;color:red;">Your Educator Account Status is blocked. You can contact admin <a style="color:#005f93;" href="/contact-us/" target="_blank">Contact Us</a></div>
						<? }?>
                    </div>
                </div>
            </div>
			
			<? if($allmessage != "" || $studentmessage != "" || $instrcutormessage != ""){ ?>
				<div class="tutor-row">
					<div class="tutor-col-12">
						<div class="tutor-dashboard-header">
							<div class="required">
								<? if(in_array( 'subscriber', (array) $user->roles ) && !in_array( 'tutor_instructor', (array) $user->roles )){
									if($allmessage != ""){
										echo "<p>".stripslashes($allmessage)."</p>";
									}
									if($studentmessage != ""){
										echo "<p>".stripslashes($studentmessage)."</p>";
									}
									
								}
								if(in_array( 'tutor_instructor', (array) $user->roles )){
									if($allmessage != ""){
										echo "<p>".stripslashes($allmessage)."</p>";
									}
									if($instrcutormessage != ""){
										echo "<p>".stripslashes($instrcutormessage)."</p>";
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
			<? }
			
			?>

            <div class="tutor-row">
                <div class="tutor-col-3 tutor-dashboard-left-menu">
                    <ul class="tutor-dashboard-permalinks">
                        <?
                        $dashboard_pages = tutor_utils()->tutor_dashboard_nav_ui_items();
                        foreach ($dashboard_pages as $dashboard_key => $dashboard_page){
                            $menu_title = $dashboard_page;
                            $menu_link = tutor_utils()->get_tutor_dashboard_page_permalink($dashboard_key);
                            if (is_array($dashboard_page)){
                                $menu_title = tutor_utils()->array_get('title', $dashboard_page);

                                /**
                                 * Add new menu item property "url" for custom link
                                 * @since v 1.5.5
                                 */
                                if (isset($dashboard_page['url'])){
                                    $menu_link = $dashboard_page['url'];
                                }
                            }

                            $li_class = "tutor-dashboard-menu-{$dashboard_key}";
                            if ($dashboard_key === 'index')
                                $dashboard_key = '';
                            $active_class = $dashboard_key == $dashboard_page_slug ? 'active' : '';

                            echo "<li class='{$li_class}  {$active_class}'><a href='".$menu_link."'> {$menu_title} </a> </li>";
                        }
                        ?>
                    </ul>
                </div>

                <div class="tutor-col-9">
                    <div class="tutor-dashboard-content">
                        <?
                        if ($dashboard_page_name){
                            do_action('tutor_load_dashboard_template_before', $dashboard_page_name);
                            tutor_load_template("dashboard.".$dashboard_page_name);
                            do_action('tutor_load_dashboard_template_before', $dashboard_page_name);
                        }else{
                            tutor_load_template("dashboard.dashboard");
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<? do_action('tutor_dashboard/after/wrap'); ?>

<?
get_footer();
