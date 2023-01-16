<?
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */


if ( ! defined( 'ABSPATH' ) )
	exit;

get_tutor_header(true);
do_action('tutor_load_template_before', 'dashboard.create-course', null);
global $post;

$course_id = get_the_ID();
if(isset($_GET['duplicate_id'])){
	
	$duplicate_id = $_GET['duplicate_id'];
	$course_id = $duplicate_id;
	
	if($duplicate_id !== ""){
		$course_id = $duplicate_id;
		$_title = get_the_title($duplicate_id);
		$_content_post = get_post($duplicate_id);
		$_content = $_content_post->post_content;
	
	}
}
$can_publish_course = (bool) tutor_utils()->get_option('instructor_can_publish_course');
if ( ! $can_publish_course){
	$can_publish_course = current_user_can('administrator');
}
//$terms = get_terms_per_post_type( 'course-tag', array( 'post_type' => 'courses' ) );

$tags = get_terms([
          'taxonomy'  => 'course-tag',
          'hide_empty'    => false,
		  'orderby' => 'slug'

        ]);
$tags =  wp_list_sort( $tags, 'slug', 'ASC' );
$term_list =  wp_get_post_terms( $course_id, 'course-tag' , array( 'fields' => 'all' ) );

$type = get_terms([
          'taxonomy'  => 'coursetype',
          'hide_empty'    => false,
		  'orderby' => 'slug'

        ]);
$type =  wp_list_sort( $type, 'slug', 'ASC' );
$type_list =  wp_get_post_terms( $course_id, 'coursetype' , array( 'fields' => 'all' ) );



get_tutor_header(true);
$user = wp_get_current_user();
$user_id = $user->ID;
$host_id = get_user_meta($user->ID,_zoom_host_id,true);
$host_status = get_user_meta($user->ID,_zoom_status_id,true);
$status = get_user_meta($user_id, '_tutor_instructor_status',true);

$liveclass = get_post_meta(get_the_ID(),'_insert_meeting_zoom_meeting_id',true);
$start_date = "";
$meeting_id = "";
$time = "";
$duration = "";
if($liveclass != "")
{				
	foreach($liveclass as $results){
		$post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $results ."')");
		$meeting_data = get_post_meta($post_id,'_meeting_fields',true);
		if($meeting_id  == ""){
			$meeting_id  = $results;
		}
		else{
			$meeting_id  = $meeting_id.",".$results;
		}
		if($start_date == ""){
			$str=substr($meeting_data['start_date'], 0, strrpos($meeting_data['start_date'], ' '));
			$tt = explode(" ",$meeting_data['start_date']);
			$time=$tt[1];
			$start_date = $str;
			
		}
		else{
			$str=substr($meeting_data['start_date'], 0, strrpos($meeting_data['start_date'], ' '));
			$start_date = $start_date.",".$str;
		}
		$duration = $meeting_data['duration'];
		
	}
}
if($time != ""){
$time = date("g:i a", strtotime($time));
}

$durationn = maybe_unserialize(get_post_meta($course_id, '_course_duration', true));
$durationHours = tutor_utils()->avalue_dot('hours', $durationn);
$durationMinutes = tutor_utils()->avalue_dot('minutes', $durationn);
$durationSeconds = tutor_utils()->avalue_dot('seconds', $durationn);

$get_product_id= get_post_meta($course_id,"_tutor_course_product_id",true);
$get_product_woo_id= get_post_meta($get_product_id,"woobt_ids",true);
$get_product_woo_id_array = explode(",",$get_product_woo_id);
$relationtext = get_post_meta(get_the_ID(),'relationclass',true);
?>


<? do_action('tutor/dashboard_course_builder_before'); ?>
    <form class="<? if($_GET['type'] == "on-demand-classes" || $type_list[0]->slug == "on-demand-classes"){ echo "ondemand"; } ?>" action="/my-account/create-course/" id="tutor-frontend-course-builder" method="post" enctype="multipart/form-data">
		<? wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
		
        <header class="tutor-dashboard-builder-header">
            <div class="tutor-container tutor-fluid">
                <div class="tutor-row tutor-align-items-center">
                    <div class="tutor-col-auto">
                        <div class="tutor-dashboard-builder-header-left">
                            <div class="tutor-dashboard-builder-logo">
								<? $tutor_course_builder_logo_src = apply_filters('tutor_course_builder_logo_src', tutor()->url . 'assets/images/tutor-logo.png'); ?>
                                <img style="max-width:60%;" src="/wp-content/uploads/2020/05/Logo-MyHomeSchoolFamily.png" alt="">
                            </div>
                            
                        </div>
                    </div>
                    <div class="tutor-col-auto">
                        <div class="tutor-dashboard-builder-header-right tutor-form-field tutor-course-builder-btn-group">
                            
							<?
							if ($can_publish_course){
								if($status == "approved"){
								?>
                                <button class="tutor-button tutor-success" type="submit" name="course_submit_btn" value="publish_course"><? if($_GET['relationclass'] == "child"){_e('Upload Video', 'tutor');} elseif( $relationtext == "child"){_e('Save', 'tutor');}else{_e('Publish Course', 'tutor');} ?></button>
								<?
								}
							}else{
								?>
                                <button class="tutor-button tutor-success" type="submit" name="course_submit_btn" value="submit_for_review"><? _e('Submit for Review', 'tutor'); ?></button>
								<?
							}
							
                            if(isset($_GET['duplicate_id'])){ ?>
								<a class="tutor-button" href="<? echo tutor_utils()->tutor_dashboard_url('my-courses/'); ?>"> <? _e('Discard Class', "tutor") ?></a>
							<? } else { ?>
							<? if(isset($_GET['course_ID'])){ ?>
							<? if($relationtext == "child"){ ?>
								<a class="tutor-button" href="/my-account/create-course/?type=on-demand-classes&relationclass=child"> <? _e('Add Another Teaching Video', "tutor") ?></a>
							<? } elseif($relationtext == "parent"){?>
								<a class="tutor-button" href="/my-account/create-course/?type=on-demand-classes&relationclass=parent"> <? _e('Add New OnDemand Class', "tutor") ?></a>
							<? }else{?>
								 <a class="tutor-button" href="/my-account/create-course/<? if($_GET['type'] == "on-demand-classes" || $type_list[0]->slug == "on-demand-classes"){echo "?type=on-demand-classes";}?>"> <? _e('Add New Class', "tutor") ?></a>
								 <a class="tutor-button tutor-success" href="/my-account/create-course?duplicate_id=<? echo $course_id; ?><? if($_GET['type'] == "on-demand-classes" || $type_list[0]->slug == "on-demand-classes"){echo "&type=on-demand-classes";}?>">Duplicate Class</a>
							<? } ?>
							 
							<? } ?>
							<? if($_GET['relationclass'] == "child" || $relationtext == "child"){}else{ ?>
							 <button type="submit" class="tutor-button" name="course_submit_btn" value="save_course_as_draft"><? _e('Save as draft', 'tutor'); ?></button>
							<? } ?>
							 <a class="tutor-button" href="<? echo tutor_utils()->tutor_dashboard_url('my-courses/'); ?>"> <? _e('Cancel', "tutor") ?></a>
							
							 <a class="tutor-button" href="<? echo tutor_utils()->tutor_dashboard_url('my-courses/'); ?>"> <? _e('Back', "tutor") ?></a>
							 <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="tutor-frontend-course-builder-section">
            <div class="tutor-container">
                <div class="tutor-row">
                    <div class="tutor-col-8">
                        <input type="hidden" value="tutor_add_course_builder" name="tutor_action"/>
                        <input type="hidden" name="course_ID" id="course_ID" value="<? echo get_the_ID(); ?>">
                        <input type="hidden" name="post_ID" id="post_ID" value="<? echo get_the_ID(); ?>">
                        <div class="tutor-dashboard-course-builder-wrap">
							<? do_action('tutor/dashboard_course_builder_form_field_before'); ?>
							
							
                            <div class="tutor-course-builder-section tutor-course-builder-info">
                                <div class="tutor-course-builder-section-title">
                                    <h3><i class="tutor-icon-down"></i><span><? esc_html_e('Class Info', 'tutor'); ?></span></h3>
                                </div> <!--.tutor-course-builder-section-title-->
								<div class="tutor-frontend-builder-item-scope tutor-form-field-course-type">
                                        <div class="tutor-form-group">
                                            <label class="tutor-builder-item-heading">
												<? _e('Choose Class Type', 'tutor'); ?>
												<span class="required">*</span>
                                            </label>
                                            <div class="tutor-form-field-course-categories">
											<ul>
												<? foreach( $type as $term ) { ?>
												<li class="<? echo $term->slug; ?>"> 
												<input required  <? if($_GET['type'] == $term->slug){echo "checked";} foreach($type_list as $val){ if($val->term_id == $term->term_id ){ echo "checked class=''";}} ?> type='radio' name='courseetype' value="<? echo $term->slug; ?>" /> <? echo $term->name; ?>
												</li>
												<? } ?>

											</ul>
											<span class="requiredblue">Class: Allows multiple learners in a “classroom” setting.<br>Private Tutor Session: One on one session to help a learner in a specific area. </span>
                                            </div>
                                        </div>
								</div>
                                <div class="tutor-course-builder-section-content">
                                    <div class="tutor-frontend-builder-item-scope">
                                        <div class="tutor-form-group">
                                            <label class="tutor-builder-item-heading">
												<? if($_GET['relationclass'] == "child" || $relationtext == "child"){ 
												_e('Lesson Title', 'tutor');  
												}else{
													_e('Class Title', 'tutor'); 
												}
												?>
												<span class="required">*</span>
                                            </label>
                                            <input id="title" required type="text" name="title" value="<? if($_title != ""){echo $_title;} else{if(get_the_title() != ""){echo get_the_title();}} ?>" placeholder="<? if($_GET['relationclass'] == "child" || $relationtext == "child"){echo 'Lesson Title';}else{echo "Class Title";}?>">
											<span class="requiredblue"><? if($_GET['relationclass'] == "child" || $relationtext == "child"){ echo "This is the title for a specific teaching video which will be stored in your library. Be specific when naming these to avoid confusion.";}else{echo "Create a catchy title! The title is the main thing that parents and students will read when choosing classes!";}?></span>
                                        </div>
                                    </div> <!--.tutor-frontend-builder-item-scope-->
									<? if($_GET['relationclass'] == "child" || get_post_meta(get_the_ID(),'relationclass',true) == "child"){ }else{?>
									<div class="tutor-frontend-builder-item-scope">
                                        <div class="tutor-form-group">
                                            
                                            <input type="checkbox" value="bibical" name="bibical" <? if(get_post_meta(get_the_ID(),'_bibical_data',true) != ""){echo "checked"; } ?>> This Class is specifically taught with a biblical worldview.
                                        </div>
                                    </div>
                                    <div class="tutor-frontend-builder-item-scope">
                                        <div class="tutor-form-group">
                                            <label> <? _e('Description', 'tutor'); ?>
											<span class="required">*</span>
											</label>
											<?
											$editor_settings = array(
												'media_buttons' => false,
												'quicktags'     => false,
												'editor_height' => 150,
												'textarea_name' => 'content'
											);
											if($_content != ""){
												wp_editor($_content, 'course_description', $editor_settings);
											}
											else{
												wp_editor($post->post_content, 'course_description', $editor_settings);
											}
											?>
											<span class="requiredblue">Here is where you can make your class shine! Be descriptive about what the class is about and what the students will learn. Be sure to make your class sound fun and engaging!  </span>
                                        </div>
                                    </div>  <!--.tutor-frontend-builder-item-scope-->

                                    <? do_action('tutor/frontend_course_edit/after/description', $post) ?>

                                    <div class="tutor-frontend-builder-item-scope">
                                        <div class="tutor-form-group">
                                            <label>
												<? _e('Choose a category', 'tutor'); ?>
												<span class="required">*</span>
                                            </label>
                                            <div class="tutor-form-field-course-categories">
												<? //echo tutor_course_categories_checkbox($course_id);
												echo tutor_course_categories_dropdown($course_id, array('classes' => 'tutor_select2'));
												?>
                                            </div>
											<span class="requiredblue">Choose which subject best fits your class.<span>
                                        </div>
                                    </div>
									<div class="tutor-frontend-builder-item-scope">
                                        <div class="tutor-form-group">
                                            <label>
												<? _e('Choose a Grade Level', 'tutor'); ?>
												<span class="required">*</span>
                                            </label>
                                            <div class="tutor-form-field-course-categories">
											<ul>
												<? foreach( $tags as $term ) { ?>
												<li>
												<input <? foreach($term_list as $val){ if($val->slug == $term->slug ){ echo "checked";}} ?> type='checkbox' name='course-tag[]' value="<? echo $term->slug; ?>" /> <? echo $term->name; ?>
												</li>
												<? } ?>
											</ul>
                                            </div>
											<? if($_GET['type'] == "on-demand-classes" || $type_list[0]->slug == "on-demand-classes"){ } else{?>
											<span class="requiredblue">You may select multiple grades, however; please be mindful of the grade levels allowed for students who will be enrolled in your class. My Home School Family does not recommend having more than 3 grade levels in one class for the experience of the learners involved.</span>
											<? } ?>
                                        </div>
                                    </div>
									<? } ?>
									<?
									$monetize_by = tutils()->get_option('monetize_by');
									if ($monetize_by === 'wc' || $monetize_by === 'edd'){
										$course_price = tutor_utils()->get_raw_course_price(get_the_ID());
										$currency_symbol = tutor_utils()->currency_symbol();

										$_tutor_course_price_type = tutils()->price_type();
										?>
                                        <div  <? if($_GET['relationclass'] == "parent" || get_post_meta(get_the_ID(),'relationclass',true) == "parent"){ echo "style='display:none;'"; }?> class="tutor-frontend-builder-item-scope tutor-frontend-builder-course-price">
                                            <label class="tutor-builder-item-heading">
												<? if($_GET['relationclass'] == "child" || $relationtext == "child"){ _e('Individual Video Price', 'tutor'); }else{_e('Class Price', 'tutor');} ?>
												<span class="required">*(Class fee can not be less than $5.00)</span>
                                            </label>
                                            <div class="tutor-row tutor-align-items-center">
                                                <div class="tutor-col-auto">
                                                    <label for="tutor_course_price_type_pro" class="tutor-styled-radio">
                                                        <input id="tutor_course_price_type_pro" type="radio" name="tutor_course_price_type" value="paid" <? $_tutor_course_price_type ? checked($_tutor_course_price_type, 'paid') : checked('true', 'true'); ?> > 
                                                        <span></span>
                                                        <div class="tutor-form-group">
                                                            <span class="tutor-input-prepand"><? echo $currency_symbol; ?></span>
															<? 
															if($_GET['relationclass'] == "parent" || get_post_meta(get_the_ID(),'relationclass',true) == "parent"){
																$price  = 1;
																$minprice = 1;
															}
															else{
																$price = $course_price->regular_price;
																$minprice = 5;
															}
															?>
                                                            <input min=<? echo $minprice; ?> type="number" name="course_price" value="<? echo $price; ?>" placeholder="<? _e('Set course price', 'tutor'); ?>">
                                                        </div>
                                                    </label>
                                                </div>
                                                <!--div class="tutor-col-auto">
                                                    <label class="tutor-styled-radio">
                                                        <input type="radio" name="tutor_course_price_type" value="free"  <? checked($_tutor_course_price_type, 'free'); ?> >
                                                        <span><? _e('Free', "tutor") ?></span>
                                                    </label>
                                                </div-->
											</div>
											<? if($_GET['relationclass'] == "parent" || get_post_meta(get_the_ID(),'relationclass',true) == "parent"){ ?>
												<span class="requiredblue">You will attach the pricing for your class to each class video that you create. For example, if you wish to charge $100 dollars for your total course, and there are 10 class videos, you will add the $10 charge when you create each class video.</span>
											<? }elseif($_GET['relationclass'] == "child" || get_post_meta(get_the_ID(),'relationclass',true) == "child"){ ?>
												<span class="requiredblue">Each video added to a class will calculate a total sum for the course. </span>
											<? }else{ ?>
											<span class="requiredblue">All classes must have a fee charged for the learner. While we do allow a minimum fee of $3.00, we recommend charging anywhere from $5-$15 per hour depending on whether the class is a core class or an elective.</span>
											<? } ?>
												
                                            
                                        </div> <!--.tutor-frontend-builder-item-scope-->
									<? } ?>
									<? if($_GET['type'] == "on-demand-classes" || $type_list[0]->slug == "on-demand-classes"){ 
										
									?>
										<div style="display:none;"><input type="radio" <? if($_GET['relationclass'] == "parent" || $relationtext == "parent"){echo "checked";} ?> name="relationclass" value="parent">Parent
										<input type="radio" name="relationclass" <? if($_GET['relationclass'] == "child" || $relationtext == "child"){echo "checked";} ?> value="child">Child</div>
									<? }else{?>
									<? if($host_id == "" ){
										echo "<h5 class='error'>To add Live classes Zoom Account is not Activated! Please <a target='_blank' href='/my-account/zoom_classes/'>click here</a> to activate your account!</h5>";
									}
									elseif( $host_status == "pending"){
										echo "<h5 class='error'>To add Live classes Zoom Account is not Activated! Please <a target='_blank' href='/my-account/zoom_classes/'>click here</a> to activate your account!</h5>";
									}
									else{ ?>
											<div class="tutor-option-field-row">
												<div class="tutor-option-field-label">
													<label for=""><? _e('Live Class duration', 'tutor'); ?>
													<span class="required">*</span>
													</label>
													
												</div>
												<div style="margin-bottom:15px;" class="tutor-form-field-course-categories">
													<div class="tutor-form-group"><input <? if(get_post_meta(get_the_ID(),"comingsoon",true)== "coming") {echo "checked";} ?> name="comingsoon" type="checkbox" value="coming"> <strong>Coming Soon Class</strong> </div>
													</div>
												<div class="tutor-option-field">
													<div class="tutor-option-gorup-fields-wrap">
														<div class="tutor-lesson-video-runtimee liveclass">


														</div>
													</div>

												</div>
											</div>
											
											<div class="tutor-frontend-builder-item-scope">
												<div class="tutor-form-group">
													<input type="hidden" name="userId" value="<? echo $host_id; ?>">
													<label>
														<? _e('Live Class date (Add multiple dates for specific class!)', 'tutor'); ?>
														<span class="required">*</span>
														<!--div style="margin:10px 0px;" class="required">*IMPORTANT* Only select ONE calendar date if you plan to save as a draft or if you know you will need to make alternations to your course. Once you are finished and ready to FULLY publish, you can select all of your calendar dates.</div-->
													</label>
													<div class="tutor-form-field-course-categories">
														<span style="margin-top: 30px;display: block;" class="required"><strong>Please read BEFORE adding calendar dates.</strong><br><br>

															Each dates is linked with zoom meeting. Zoom allows for 100 meetings to be scheduled per instrcutor per 24 hours. (for example, a 32 week class uses 32 meetings. If you edit that class, that is now 64 meetings and so on.)<br><br>

															Choose only 1 calendar date until you are ready to publish so that you do not exceed you 100. If you do, the dates will not save when hit publish. If this happens, simply wait 24 hours and you can then add the dates and publish. You do not need to re-create the class.</span>
														<? //if ( get_post_status (get_the_ID()) != 'publish' ) { ?>
														<div id="mdp-demo"></div>
														<? //} ?>
														<input  required type="text" name="start_datee" id="altField" value="<? if($start_date !=""){echo $start_date; }?>">
														<input type="hidden" name="meetingid" value="<? if($meeting_id != ""){
															echo $meeting_id;}?>">
														<input id="datetimepicker" class="datetime"  value="<? if($start_date !=""){echo $start_date; }?>" type="hidden" name="start_date">
													
													</div>
													<span class="requiredblue">Click on all dates in the calendar that you wish your class to occur, or select Coming Soon if you wish to publish your class, but not allow learners to enroll yet.  If choosing “coming soon”, simply check the box next to Coming Soon and select todays date in the calendar as well. (This date is just to activate the calendar and will not actually schedule for today.)</span>
												</div>
											</div>
											<div class="tutor-frontend-builder-item-scope">
												<div class="tutor-form-group">
													<label>
														<? _e('Live Class time', 'tutor'); ?>
														<span class="required">*</span>
													</label>
													
													<div class="tutor-form-field-course-categories">
														<input required <? if($time !=""){echo "";} ?> type="text" value="<? if($time !=""){echo $time;} ?>" id="timepicker" name="liveclasstime"> 
													</div>
													<span Class="requiredblue">Choose the time of day that you would like your class to occur.</span>
												</div>
											</div>
									<? } ?>
									<div class="tutor-frontend-builder-item-scope">
										<div class="tutor-course-builder-section-title">
											<h3><i class="tutor-icon-down"></i> <span>Refund Policy</span></h3>
										</div>
										<div class="tutor-form-group">
											<label class="tutor-builder-item-heading">
												Refund Policy												
												<span class="required">*</span>
											</label>
											<div class="tutor-form-field-course-categories">
											
													<input required="" <? if(get_post_meta($course_id,'refund',true) == "class pack 14"){echo "checked"; } ?> type="radio" name="refund" value="class pack 14"> Class Pack (14 and fewer classes) – 7 days prior to the start of a live class.<br>											
												
													<input required="" <? if(get_post_meta($course_id,'refund',true) == "class pack 15"){echo "checked"; } ?> type="radio" name="refund" value="class pack 15"> Semester/Year (15 or more classes) – 30 days prior to the start of a live class.
												
											
											</div>
										</div>
									</div>
									<div class="tutor-frontend-builder-item-scope refund ">
										<div class="tutor-course-builder-section-title">
											<h3><i class="tutor-icon-down"></i> <span>Late Enrollment</span></h3>
										</div>
										<div class="tutor-form-group">
											<label class="tutor-builder-item-heading">
												Interested in late enrollment?												
												<span class="required">*</span>
											</label>
											<div class="tutor-form-field-course-categories">
												<input required <? if(get_post_meta($course_id,'lateenroll',true) == "yes"){echo "checked";} ?> type="radio" name="lateenroll" value="yes"> Yes
												<input <? if(get_post_meta($course_id,'lateenroll',true) == "no") {echo "checked";} ?> type="radio" name="lateenroll" value="no"> No
											</div>
										</div>
										<div class="tutor-course-builder-section-title">
											
										</div>
										<div class="tutor-form-group" style="margin-top:30px;">
											<label class="tutor-builder-item-heading">
											if yes, please select the number of max classes
												
											</label>
											<div class="tutor-form-field-course-categories">
												<input  <? if(get_post_meta($course_id,'lateenrollnumber',true) == "1"){echo "checked";} ?> type="radio" name="lateenrollnumber" value="1"> One
												<input <? if(get_post_meta($course_id,'lateenrollnumber',true) == "2") {echo "checked";} ?> type="radio" name="lateenrollnumber" value="2"> Two
												<input <? if(get_post_meta($course_id,'lateenrollnumber',true) == "3") {echo "checked";} ?> type="radio" name="lateenrollnumber" value="3"> Three
												<input <? if(get_post_meta($course_id,'lateenrollnumber',true) == "4") {echo "checked";} ?> type="radio" name="lateenrollnumber" value="4"> Four
												<input <? if(get_post_meta($course_id,'lateenrollnumber',true) == "5") {echo "checked";} ?> type="radio" name="lateenrollnumber" value="5"> Five
											</div>
										</div>
									</div>
									<? }  if($_GET['relationclass'] == "child" || get_post_meta(get_the_ID(),'relationclass',true) == "child"){ }else{ ?>
                                    <div class="tutor-frontend-builder-item-scope">
                                        <div class="tutor-form-group">
                                            <label>
												<? _e('Class Thumbnail', 'tutor'); ?> (Click upload image button to change image)
												<span class="required">*</span>
												<p style="color:red;padding-top:10px;">Please be sure to add a class image, otherwise, a default image will appear</p>
                                            </label>
                                            <div class="tutor-form-field tutor-form-field-course-thumbnail tutor-thumbnail-wrap">
                                                <div class="tutor-row tutor-align-items-center">
                                                    <div class="tutor-col-5">
                                                        <div class="builder-course-thumbnail-img-src">
															<?
															$builder_course_img_src = tutor()->url . 'assets/images/placeholder-course.jpg';
															$_thumbnail_url = get_the_post_thumbnail_url($course_id);
															$post_thumbnail_id = get_post_thumbnail_id( $course_id );

															if ( ! $_thumbnail_url){
																$_thumbnail_url = $builder_course_img_src;
															}
															?>
                                                            <img src="<? echo $_thumbnail_url; ?>" class="thumbnail-img" data-placeholder-src="<? echo $builder_course_img_src; ?>">
                                                            <a href="javascript:;" class="tutor-course-thumbnail-delete-btn" style="display: <? echo
															$post_thumbnail_id ? 'block':'none'; ?>;"><i class="tutor-icon-line-cross"></i></a>
                                                        </div>
                                                    </div>

                                                    <div class="tutor-col-7">
                                                        <div class="builder-course-thumbnail-upload-wrap">
                                                            <div><? echo sprintf(__("Important Guideline: %1\$s 700x430 pixels %2\$s %3\$s File Support: %1\$s jpg, .jpeg,. gif, or .png %2\$s no text on the image.", "tutor"), "<strong>", "</strong>", "<br>") ?></div>
                                                            <input required type="hidden" id="tutor_course_thumbnail_id" name="tutor_course_thumbnail_id" value="<? echo $post_thumbnail_id; ?>">
                                                            <a href="javascript:;" class="tutor-course-thumbnail-upload-btn tutor-button bordered-button"><? _e('Upload Image', 'tutor'); ?></a>
                                                        </div>
														
                                                    </div>
                                                </div>
												<span class="requiredblue">They say a picture is worth a thousand words. Adding a thumbnail image is a must!! This is the first thing that will draw the user to your class. Take the time to upload clear images that fit your class. Use Google or any other type of search engine to find something appealing, if necessary. A default picture will be uploaded if nothing is chosen.</span>
												<span class="required">*Important Guideline: 700×430 pixels File Support: jpg, .jpeg,. gif, or .png no text on the image.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<? } ?>
							<? if($_GET['type'] == "on-demand-classes" || $type_list[0]->slug == "on-demand-classes"){ 
								if($_GET['relationclass'] == "child" || get_post_meta(get_the_ID(),'relationclass',true) == "child"){ }else{
								echo '<div class="tutor-course-builder-section">';
									echo '<div class="tutor-course-builder-section-title">
										<h3><i class="tutor-icon-down"></i> <span>Video</span></h3>
									</div>';
									include  tutor()->path.'views/metabox/video-metabox.php';
									
								echo '</div>';
								}
								if($_GET['relationclass'] == "child" || get_post_meta(get_the_ID(),'relationclass',true) == "child"){
								echo '<div class="tutor-course-builder-section">';
									echo '<div class="tutor-course-builder-section-title">
										<h3><i class="tutor-icon-down"></i> <span>Individual Lesson Video</span></h3>
									</div>';
								
									$video_check = get_post_meta(get_the_ID(),"_on_demand_video",true);
									$vide = explode('/',get_post_meta(get_the_ID(),"_on_demand_video",true)); 
									$vide = array_reverse($vide);
									$vide = get_site_url()."/uploads/".$vide[1]."/".$vide[0];
									if($video_check == ""){
										$required = "required";
									}
									else{
										$required  = "";
									}
									echo '	Upload Video: <input '.$required .' name="userfile" type="file" />';
									if($video_check != ""){
										?>
											<video width="50%" height="250" controls>
												<source src="<? echo $vide; ?>" type="video/mp4">
											</video>
										<?
									} ?>
									<span class="requiredblue">Please be patient as uploading large files can take several minutes. Do not close out of this window until you see your video appear.</span>
								<?
								echo '</div>';
								}
								if($_GET['relationclass'] == "child" || get_post_meta(get_the_ID(),'relationclass',true) == "child"){ }else{	
									echo '<div class="tutor-course-builder-section">';
										echo '<div class="tutor-course-builder-section-title">
											<h3><i class="tutor-icon-down"></i> <span>Class Builder</span></h3>
										</div>';
										include  tutor()->path.'views/metabox/course-topics.php';
									echo '</div>';
								}								
								if($_GET['relationclass'] == "parent" || get_post_meta(get_the_ID(),'relationclass',true) == "parent"){
								echo '<div class="tutor-course-builder-section">';
									echo '<div class="tutor-course-builder-section-title">
											<h3><i class="tutor-icon-down"></i> <span>Class Instruction videos</span></h3>
										</div>';
										$user_id = get_current_user_id();

										$args = array(
											'post_type'         => 'courses',
											'post_status'    => 'publish',
											'tax_query'         => array(
												array(
													'taxonomy' => 'coursetype',
													'field'    => 'id',
													'terms'    => '191',
												),
											),
											'meta_query' => array(
												'relation' => 'AND', /* <-- here */
												array(
													'key' => 'relationclass',
													'value' => 'child',
													'compare' => 'LIKE'
												)
											),
											'order'             => 'DESC', 
											'posts_per_page'    => -1,

										);

										$posts_array = new WP_Query($args);
										
										
										 ?>
										 
										<select required class="js-example-basic-multiple" name="relatedclasses[]" multiple="">
											<? if ( $posts_array->have_posts() ) : while ( $posts_array->have_posts() ) : $posts_array->the_post(); 
											$idval = get_post_meta(get_the_ID(),"_tutor_course_product_id",true);
											
;
											if(get_post_field( 'post_author', get_the_ID()) == $user_id ){
											if($idval != ""){
											?>
											<option <? if(!empty($get_product_woo_id_array) && $idval != ""){foreach($get_product_woo_id_array as $reslt){$res_id = explode("/",$reslt);if($idval == $res_id[0]){ echo "selected"; }}}?> value="<? echo $idval; ?>"><? echo get_the_title(); ?></option>
											<? } } endwhile; endif; ?>
											
										</select>
										<?  
									echo '<span class="requiredblue">Select each instructional video that you wish to add to this course. The instructional videos must be created before you will see them available in the list to attach.</span>
									</div>';
								}
							}else{
								
									do_action('tutor/dashboard_course_builder_form_field_after');
								
							
							} ?>
                            <div class="tutor-form-row">
                                <div class="tutor-form-col-12">
                                    <div class="tutor-form-group">
                                        <div class="tutor-form-field tutor-course-builder-btn-group" style="justify-content: unset;">
											<? if ($can_publish_course){ 
											if($status == "approved"){
											?>
                                                <button class="tutor-button tutor-success" type="submit" name="course_submit_btn" value="publish_course"><? if($_GET['relationclass'] == "child"){_e('Upload Video', 'tutor');} elseif( $relationtext == "child"){_e('Save', 'tutor');}else{_e('Publish Course', 'tutor');} ?></button>
											<? } }else{ ?>
                                                <button class="tutor-button tutor-success" type="submit" name="course_submit_btn" value="submit_for_review"><? _e('Submit for Review', 'tutor'); ?></button>
											<? } ?>
											<? if(isset($_GET['course_ID'])){ ?>
											<? if($relationtext == "child"){ ?>
												<a class="tutor-button" href="/my-account/create-course/?type=on-demand-classes&relationclass=child"> <? _e('Add Another Teaching Video', "tutor") ?></a>
											<? } elseif( $relationtext == "parent"){?>
												<a class="tutor-button" href="/my-account/create-course/?type=on-demand-classes&relationclass=parent"> <? _e('Add New OnDemand Class', "tutor") ?></a>
											<? }else{?>
												 <a class="tutor-button" href="/my-account/create-course/<? if($_GET['type'] == "on-demand-classes" || $type_list[0]->slug == "on-demand-classes"){echo "?type=on-demand-classes";}?>"> <? _e('Add New Class', "tutor") ?></a>
												 <a class="tutor-button tutor-success" href="/my-account/create-course?duplicate_id=<? echo $course_id; ?><? if($_GET['type'] == "on-demand-classes" || $type_list[0]->slug == "on-demand-classes"){echo "&type=on-demand-classes";}?>">Duplicate Class</a>
											<? } ?>
							 
											<? } ?>
											<? if($_GET['relationclass'] == "child" || $relationtext == "child"){}else{ ?>
											 <button type="submit" class="tutor-button" name="course_submit_btn" value="save_course_as_draft"><? _e('Save as draft', 'tutor'); ?></button>
											<? } ?>
											 <a class="tutor-button" href="<? echo tutor_utils()->tutor_dashboard_url('my-courses/'); ?>"> <? _e('Cancel', "tutor") ?></a>
											 
											 <a class="tutor-button" href="<? echo tutor_utils()->tutor_dashboard_url('my-courses/'); ?>"> <? _e('Back', "tutor") ?></a>
											
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--.tutor-col-8-->
                    
                </div> <!--.tutor-row-->
            </div>
        </div>
    </form>
	
<!--link rel="stylesheet" href="https://myhomeschoolfamily.com/wp-content/plugins/video-conferencing-with-zoom-api/assets/vendor/dtimepicker/jquery.datetimepicker.min.css?ver=3.4.1"/>
<script src="https://myhomeschoolfamily.com/wp-content/plugins/video-conferencing-with-zoom-api/assets/vendor/dtimepicker/jquery.datetimepicker.full.js?ver=3.4.1"></script-->
<link rel="stylesheet" href="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.css">
<link rel="stylesheet" href="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript">
	/*jQuery("#datetimepicker").multiDatesPicker(
	{
		format: 'm/d/Y H:m:s',
	});*/
	var dates = jQuery("#datetimepicker").val();
	if(dates){
	dates = dates.replace(/\s/g, '');
	dates = dates.split(",");
	if(dates == ""){
		dates = "";
	}
	}
	console.log(dates); 
	jQuery('#mdp-demo').multiDatesPicker({
		
		altField: '#altField',
		dateFormat: 'mm/dd/yy',
		minDate: 0,
		addDates: dates,

	});
	jQuery('#timepicker').timepicker({
			timeFormat: 'h:mm p',
			interval: 15,
			dropdown: true,
			scrollbar: true
	});
	jQuery(".tutor-lesson-video-runtime").appendTo(".liveclass");
	if(jQuery("#title").val() == "Class Title"){
		jQuery("#title").val("");
	}
</script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>jQuery(document).ready(function() {
    jQuery('.js-example-basic-multiple').select2({
		placeholder: "Select a relative class",
		allowClear: true
	});
});
</script>
<style>
	.select2-container .select2-selection--multiple{
		min-height:50px;
	}
	#tutor-page-wrap .select2-search__field {
		padding: 8px 20px;
		width: 100% !important;
	}
	.select2-results__option[id*="videosource"] {
    display: none;
}
.select2-results__options .select2-results__option[id*="html5"] {
    display: block;
}
	
</style>

<? do_action('tutor/dashboard_course_builder_after'); ?>


<?
do_action('tutor_load_template_after', 'dashboard.create-course', null);
get_tutor_footer(true); ?>