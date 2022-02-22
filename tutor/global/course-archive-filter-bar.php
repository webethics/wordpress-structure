<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>
<?php
global $wpdb;
$taxonomies = get_terms( array(
				'taxonomy' => 'course-category',
				'hide_empty' => false
			) );
$group = get_terms([
          'taxonomy'  => 'course-tag',
          'hide_empty'    => false,
		  'orderby' => 'ID'

        ]);
$group =  wp_list_sort( $group, 'ID', 'ASC' );
$type = get_terms( array(
				'taxonomy' => 'coursetype',
				'hide_empty' => false
			) );
$args = array(
    'role'    => 'tutor_instructor',
    'orderby' => 'user_nicename',
    'order'   => 'ASC'
);
$users = get_users( $args );

$user = wp_get_current_user();
$user_id = get_current_user_id();
	
/* if ( is_user_logged_in() &&  in_array( 'subscriber', (array) $user->roles ) && !in_array( 'tutor_instructor', (array) $user->roles )) {
}
else{
echo do_shortcode('[elementor-template id="10597"]');
echo do_shortcode('[elementor-template id="10600"]');
} */


$coursearr = array();

$getcourses = $wpdb->get_results("SELECT `post_author` FROM {$wpdb->prefix}posts where `post_type` = 'courses' AND `post_status` = 'publish' order by ID ASC");

foreach($getcourses as $courseauthor){

	array_push($coursearr,$courseauthor->post_author);
}

$newarr = array_unique($coursearr);

$insturctorID = $_GET['tutor_instructor_filter'];

?>
<section  class="findcurriculum section-wrap" id="liveclass">
            <div class="container-wrap">
               <div class="row-wrap">
			      <div class="col-wrap-full"><h3 class="form-title">Find Live Classes</h3><!--h5 style="text-align:center;" class="error">Teachers are enrolling now and adding classes daily!</h5--></div>
                  <div class="col-wrap-full">
					<form method="GET" action="/virtual-classroom">
						<div class="form-wrap">
							<div class="field-wrap">
								<input class="form-control" type="text" class="form-control" maxlength="255" placeholder="Search term" name="s" value="<?php echo $_GET["s"] ; ?>">
							</div>
							<div class="field-wrap">
							<select class="form-control" name="tutor_category_filter">
								<option value="">All Categories</option>
								<?php $other_id = "";
								$other_name = "";
								foreach( $taxonomies as $subcategory ) { 
									if($subcategory->name != "Other"){?>
									<option value="<?php echo $subcategory->term_id; ?>" <?php if (isset($_GET["tutor_category_filter"]) ? selected($subcategory->term_id,$_GET["tutor_category_filter"]) : "" ); ?>><?php echo $subcategory->name; ?></option>
									<?php } 
									elseif($subcategory->name == "Other"){ 
										$other_id = $subcategory->term_id;
										$other_name = $subcategory->name;
									 	}
									}
									?>
									<option value="<?php echo $other_id; ?>" <?php if (isset($_GET["tutor_category_filter"]) ? selected($other_id,$_GET["tutor_category_filter"]) : "" ); ?>><?php echo $other_name; ?></option>									
							</select>
							</div>
							<div class="field-wrap">
								<select class="form-control" name="tutor_tag_filter">
									<option value="">All Grades</option>
									<?php foreach( $group as $subcategory ) { ?>
										<option value="<?php echo $subcategory->term_id; ?>" <?php if (isset($_GET["tutor_tag_filter"]) ? selected($subcategory->term_id,$_GET["tutor_tag_filter"]) : "" ); ?>><?php echo $subcategory->name; ?></option>
									<?php }	?> 
								</select>
							</div>
							<div class="field-wrap">	
								<select class="form-control" style="width:215px;" name="tutor_type_filter">
									<option value="">Select Class/Private Tutor</option>
									<?php foreach( $type as $subcategory ) { 
										
									?>
										<option value="<?php echo $subcategory->term_id; ?>" <?php if (isset($_GET["tutor_type_filter"]) ? selected($subcategory->term_id,$_GET["tutor_type_filter"]) : "" ); ?>><?php echo $subcategory->name; ?></option>
									<?php }	?> 
								</select>
								
								<!--input type="radio" name="tutor_type_filter" value=""> All
								<?php foreach( $type as $subcategory ) { ?>
									<input type="radio" name="tutor_type_filter" value="<?php echo $subcategory->term_id; ?>" <?php if (isset($_GET["tutor_type_filter"]) ? checked($subcategory->term_id,$_GET["tutor_type_filter"]) : "" ); ?>> <?php echo $subcategory->name; ?> 
								<?php }	?> -->
							</div>
							<div class="field-wrap">
							<select class="form-control" name="tutor_instructor_filter">
								<option value="">All Instructors</option>
								<?php foreach ( $users as $user ) {
									$fname = get_user_meta($user->ID,'first_name',true);
									$lname = get_user_meta($user->ID,'last_name',true);
										echo '<option ';
										if(!in_array($user->ID,$newarr)){
											echo 'disabled ';
											echo 'class="disabled"  ';
										}
										if($insturctorID == $user->ID){
											echo 'selected';
										}
										echo '  value='.$user->ID.'>' . esc_html( $fname ) .' '. esc_html( $lname ) .'</option>';
									}	?> 
							</select>
							</div>
							<div class="btn-wrap">
						
								<input type="button" id="inputfile" value="Search" class="btn-submit">
								<?php if (strpos($_SERVER['REQUEST_URI'], "tutor_category_filter") !== false){ ?>
								<input type="button" value="Clear Search" onclick="window.location.href='<?php echo site_url(); ?>/virtual-classroom/';"/>
								<?php } ?>
							</div>
						</div>
					</form>
                  </div>
               </div>
            </div>
         </section>	

<script>
jQuery(document).ready(function($) {

	$('#inputfile').click(function(){
		$(this).closest('form').submit();
	});	
	
});
</script>