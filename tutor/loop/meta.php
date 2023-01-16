<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

global $post, $authordata, $wpdb;


//$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'tutor_enrolled' AND post_parent=".get_the_ID());


$profile_url = tutor_utils()->profile_url($authordata->ID);
$course_categories = get_tutor_course_categories();

$course_duration = get_tutor_course_duration_context();
$course_students = tutor_utils()->count_enrolled_users_by_course();
	
$settings_meta = get_post_meta(get_the_ID(), '_tutor_course_settings', true);
$maximum_student = $settings_meta['maximum_students'];
	
$course_id = get_the_ID();

$tag = get_the_terms( $course_id, 'course-tag' );
$tag =  wp_list_sort( $tag, 'slug', 'ASC' );
$type = get_the_terms( $course_id, 'coursetype' );
$category_name = "";
$grade_name = "";
$gradee = "";
$grade1 = "";
$grade2 = "";
$type_name = "";
	if(!empty($course_categories) && is_array($course_categories ) && count($course_categories)){
           
            foreach ($course_categories as $course_category){
					$category_name .= $course_category->name.",";
				
            }
    } 
	if(!empty($tag) && is_array($tag ) && count($tag)){
          
            foreach ($tag as $course_category){  
					$category_namee = $course_category->name;
					if($category_namee == "K")
					{
						$grade1 = $category_namee.",";
					}
					elseif($category_namee == "Pre-K")
					{
						$grade2 = " ".$category_namee.",";
					} 
					else{
						$gradee .= " ".$category_namee.",";
					}
            }
			$grade_name = $grade1.$grade2.$gradee;
			
    }
	if(!empty($type) && is_array($type ) && count($type)){
          
            foreach ($type as $course_category){  
					$type_name .= $course_category->name;	
            }
    }
$category_name = rtrim($category_name,",");
$grade_name = rtrim($grade_name,",");
$type_name = rtrim($type_name,",");
if($maximum_student == "" || $maximum_student == 0){
	$maximum_student = "NA";
}
if($maximum_student != "" || $maximum_student != 0){	
	$seat_available = $maximum_student - $course_students;	
}

if($seat_available < 0 || $maximum_student == "NA"){
	$seat_available = "NA";
} 
if($seat_available == 0){
	$class = "error";
}
$fname = get_the_author_meta('first_name');
$lname = get_the_author_meta('last_name');
$full_name = '';

if( empty($fname)){
    $full_name = $lname;
} elseif( empty( $lname )){
    $full_name = $fname;
} else {
    //both first name and last name are present
    $full_name = "{$fname} {$lname}";
}
$coming = get_post_meta(get_the_ID(),"comingsoon",true);
$lateenroll = get_post_meta(get_the_ID(),"lateenroll",true);
$lateenrollnumber = get_post_meta(get_the_ID(),"lateenrollnumber",true);
?>

<p class="category-wrap">Category: <?php echo $category_name; ?> | Type: <?php echo $type_name; ?>&nbsp;</p>
<p class="category-wrap">Grade: <?php echo $grade_name; ?></p>
<p class="grade-wrap">Instructor Name: <?php echo $full_name; ?></p>
<p class="keywords-wrap">Duration: <?php if(!empty($course_duration)) { echo $course_duration;} else{ echo "NA";} ?> || <strong class="<?php echo $class; ?>">Seat Available:</strong> <?php echo $seat_available; ?></p>
<?php if($coming == "coming"){echo '<div class="elementor-widget-container">
									<p class="category-wrap"><strong>Coming Soon!</strong></p>	
						</div>';} else {$liveclass = get_post_meta(get_the_ID(),'_insert_meeting_zoom_meeting_id',true);
		
				
				if($liveclass != ""){
					$maincount = count($liveclass);
					$i = 1;
					$counting = 0;
					$classcount = 0;
					foreach($liveclass as $results){
						$post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $results ."')");
							$start_date = get_post_meta($post_id,'_meeting_date',true);
							$class_date = date('Y-m-d',strtotime($start_date));
							$class_datee = date('d-M-y h:i a',strtotime($start_date));
							$blogtime = date("Y-m-d"); 
							
							
							date_default_timezone_set("America/New_York");
							$checkttime = date('Y-m-d h:i:sa',strtotime($start_date));
							$currenttime = date("Y-m-d h:i:sa");
							$checkttime = strtotime($checkttime);
							$currenttime = strtotime($currenttime);
							if($checkttime <= $currenttime ){
								$counting = $counting+1;
							}
							else{
								$classcount = $classcount+1;
							}
						if($i == 1){
							$post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_meeting_zoom_meeting_id' AND meta_value = '". $results ."')");
							$start_date = get_post_meta($post_id,'_meeting_date',true);
							$class_date = date('Y-m-d',strtotime($start_date));
							$class_datee = date('d-M-y h:i a',strtotime($start_date));
							$blogtime = date("Y-m-d"); 
							
							
							date_default_timezone_set("America/New_York");
							$checkttime = date('Y-m-d h:i:sa',strtotime($start_date));
							$currenttime = date("Y-m-d h:i:sa");
							$checkttime = strtotime($checkttime);
							$currenttime = strtotime($currenttime);
							

							if($checkttime >= $currenttime ){
								
									echo '<div class="elementor-widget-container">
											<p class="category-wrap"><strong>Next Live Class starts: '.$class_datee.' (Eastern Daylight Time)</strong></p> 	
										</div>';
									$i++;
								
							}
							else{
								if($course_students == 0){
									if($checkttime >= $currenttime ){
										echo '<div class="elementor-widget-container">
												<p class="category-wrap"><strong>Next Live Class starts: '.$class_datee.' (Eastern Daylight Time)</strong></p>	
											</div>';
										$i++;
									}
									else{
										echo '<div class="elementor-widget-container">
											<p class="category-wrap"><strong>Class in session, closed for enrollment. </strong></p>	
										</div>';
										$i++;
									}
									
								}
								else{
									echo '<div class="elementor-widget-container">
										<p class="category-wrap"><strong>Class in session, closed for enrollment. </strong></p>	
									</div>';
									$i++;
								}
								
							}
							
						}
					
					}
				}
				else{
					echo '<div class="elementor-widget-container">
									<p class="category-wrap"><strong>No Live Class Scheduled for this course! </strong></p>	
						</div>';
					
				}
}
?>

<div class="btn-wrap single-coursebtn"><a href="<?php echo get_the_permalink(); ?>" class="r_more_btn">Read more</a></div>
<?php if($coming == "coming"){ ?>
<div style="position:relative;" class="single-coursebtn btn-wrap tutor-course-loop-header-meta"><?php
        $is_wishlisted = tutor_utils()->is_wishlisted($course_id);
        $has_wish_list = '';
        if ($is_wishlisted){
	        $has_wish_list = 'has-wish-listed';
			$text = "Remove From Favorites";
        }
		else{
			$text = "Add To Favorites";
		}

        $action_class = '';
        if ( is_user_logged_in()){
            $action_class = apply_filters('tutor_wishlist_btn_class', 'tutor-course-wishlist-btn');
        }else{
            $action_class = apply_filters('tutor_popup_login_class', 'cart-required-login');
        }
		echo '<span class="tutor-course-wishlist"><a href="javascript:;" class="tutor-icon-fav-line '.$action_class.' '.$has_wish_list.' " data-course-id="'.$course_id.'"><span>'.$text.'</span></a> </span>';
		?></div>
<?php } 

$count = ""; 

if($counting != 0 && $lateenrollnumber != "" && $classcount > 0){

$count = $counting;


?>
<?php if($lateenroll == "yes" && $count <= $lateenrollnumber && $count > 0){ 

?>
	<div class="btn-wrap single-coursebtn"><a href="<?php echo get_the_permalink(); ?>" class="r_more_btn">Ineterested in late enrollment?</a></div>
<?php
}
}
?>