<?php
/*
Template Name: On Demand Class
*/
get_header();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
if($_GET['tutor_instructor_filter'] == ""){
	$post_author = "";
}
else{
	$post_author = $_GET['tutor_instructor_filter'];
}
if($_GET['search'] != "" && $_GET['tutor_category_filter'] == "" && $_GET['tutor_tag_filter'] == ""){
	$args  = array(
	's' => $_GET['search'],
    'post_type' => 'courses',
	'posts_per_page' => 10,
     'paged' => $paged,
	 'author' => $post_author,
	'tax_query' => array(
		array(
		  'taxonomy' => 'coursetype',
		  'field' => 'term_id',
          'terms' => 191,
		)
	  ),
	  'meta_query' => array(
        'relation' => 'AND',
         array(
            'key' => 'relative_class',
            'value' => 'yes',
        )
	)
);
}
elseif($_GET['search'] == "" && $_GET['tutor_category_filter'] != "" && $_GET['tutor_tag_filter'] == ""){
	$args  = array(
    'post_type' => 'courses',
	'posts_per_page' => 10,
     'paged' => $paged,
	 'author' => $post_author,
	'tax_query' => array(
	'relation' => 'AND',
		array(
		  'taxonomy' => 'coursetype',
		  'field' => 'term_id',
          'terms' => 191,
		),
		array(
				'taxonomy' => 'course-category',
				'field' => 'id',
				'terms' => array( $_GET['tutor_category_filter'] )
			)
	  ),
	  'meta_query' => array(
        'relation' => 'AND',
         array(
            'key' => 'relative_class',
            'value' => 'yes',
        ),
		)
	  );
}
elseif($_GET['search'] == "" && $_GET['tutor_category_filter'] == "" && $_GET['tutor_tag_filter'] != ""){
	$args  = array(
    'post_type' => 'courses',
	'posts_per_page' => 10,
     'paged' => $paged,
	 'author' => $post_author,
	'tax_query' => array(
	'relation' => 'AND',
		array(
		  'taxonomy' => 'coursetype',
		  'field' => 'term_id',
          'terms' => 191,
		),
		array(
				'taxonomy' => 'course-tag',
				'field' => 'id',
				'terms' => array( $_GET['tutor_tag_filter'] )
			),
		)
		);
} 
elseif($_GET['search'] == "" && $_GET['tutor_category_filter'] != "" && $_GET['tutor_tag_filter'] != ""){
	$args  = array(
    'post_type' => 'courses',
	'posts_per_page' => 10,
     'paged' => $paged,
	 'author' => $post_author,
	'tax_query' => array(
	'relation' => 'AND',
		array(
		  'taxonomy' => 'coursetype',
		  'field' => 'term_id',
          'terms' => 191,
		),
		array(
				'taxonomy' => 'course-tag',
				'field' => 'id',
				'terms' => array( $_GET['tutor_tag_filter'] )
			),
		
		array(
				'taxonomy' => 'course-category',
				'field' => 'id',
				'terms' => array( $_GET['tutor_category_filter'] )
			),
		),'meta_query' => array(
        'relation' => 'AND',
         array(
            'key' => 'relative_class',
            'value' => 'yes',
        )
	)
		);
} 
elseif($_GET['search'] != "" && $_GET['tutor_category_filter'] == "" && $_GET['tutor_tag_filter'] != ""){
	$args  = array(
	's' => $_GET['search'],
    'post_type' => 'courses',
	'posts_per_page' => 10,
     'paged' => $paged,
	 'author' => $post_author,
	'tax_query' => array(
	'relation' => 'AND',
		array(
		  'taxonomy' => 'coursetype',
		  'field' => 'term_id',
          'terms' => 191,
		),
		array(
				'taxonomy' => 'course-tag',
				'field' => 'id',
				'terms' => array( $_GET['tutor_tag_filter'] )
			),
		),'meta_query' => array(
        'relation' => 'AND',
         array(
            'key' => 'relative_class',
            'value' => 'yes',
        )
	)
		);
} 
elseif($_GET['search'] != "" && $_GET['tutor_category_filter'] != "" && $_GET['tutor_tag_filter'] == ""){
	$args  = array(
	's' => $_GET['search'],
    'post_type' => 'courses',
	'posts_per_page' => 10,
     'paged' => $paged,
	 'author' => $post_author,
	'tax_query' => array(
	'relation' => 'AND',
		array(
		  'taxonomy' => 'coursetype',
		  'field' => 'term_id',
          'terms' => 191,
		
		),
		array(
				'taxonomy' => 'course-category',
				'field' => 'id',
				'terms' => array( $_GET['tutor_category_filter'] )
			)
		),'meta_query' => array(
        'relation' => 'AND',
         array(
            'key' => 'relative_class',
            'value' => 'yes',
        )
	)
	);
}

else{
$args  = array(
    'post_type' => 'courses',
	'posts_per_page' => 10,
     'paged' => $paged,
	 'author' => $post_author,
	'tax_query' => array(
		array(
		  'taxonomy' => 'coursetype',
		  'field' => 'term_id',
          'terms' => 191,
		)
	  ),'meta_query' => array(
        'relation' => 'AND',
         array(
            'key' => 'relative_class',
            'value' => 'yes',
        )
	)
);
}
$query = new WP_Query( $args );

?>
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
$argss = array(
    'role'    => 'tutor_instructor',
    'orderby' => 'user_nicename',
    'order'   => 'ASC'
);		
$users = get_users( $argss );

$user = wp_get_current_user();
$user_id = get_current_user_id();


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
			      <div class="col-wrap-full"><h3 class="form-title">Find Live Classes</h3><h5 style="text-align:center;" class="error">Teachers are enrolling now and adding classes daily!</h5></div>
                  <div class="col-wrap-full">
					<form method="GET" action="/on-demand-classes">
						<div class="form-wrap">
							<div class="field-wrap">
								<input class="form-control" type="text" class="form-control" maxlength="255" placeholder="Search term" name="search" value="<?php echo $_GET["search"] ; ?>">
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
<div class="tutor-wrap tutor-courses-wrap tutor-container">
	<div class="prd-wrap section-wrap">
		<div class="container-wrap">
			<div class="row-wrap">
				<h3 style="width:100%;" class="form-title">On Demand Classes</h3>
					<?php if ( $query->have_posts() ) :
						/* Start the Loop */
						
						while ( $query->have_posts() ) : $query->the_post(); 
						$price_id = get_post_meta(get_the_ID(),'relative_class_id',true);
						$final_price = "";
						foreach($price_id as $result_val){
							$final_price = $final_price + get_post_meta($result_val,"_price",true);
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
						$course_id = get_the_ID();
						$course_categories = get_tutor_course_categories();

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
							
							$enroll_btn = '<div  class="tutor-loop-cart-btn-wrap"><a href="'. get_the_permalink(). '">'.__('Get Enrolled', 'tutor'). '</a></div>';
							$price_html = '<div class="price-wrap"> Price:'.__('Free', 'tutor').$enroll_btn. '</div>';
							if (tutor_utils()->is_course_purchasable()) {
								$enroll_btn = tutor_course_loop_add_to_cart(false);

								$product_id = tutor_utils()->get_course_product_id($course_id);
								$product    = wc_get_product( $product_id );

								if ( $product ) {
									$price_html = '<div class="price-wrap"> Price: '.$product->get_price_html().$enroll_btn.' </div>';
								}
							}
    
						?>
						<div class="boxy-inner">
							<div class="img-container">	
								<a href="<?php echo get_the_permalink(); ?>"> <?php tutor_course_loop_thumbnail();?> </a>	
							</div>

							<div class="tutor-loop-course-container prd-content"><div class="elementor-widget-container">
										<h4 class="elementor-heading-title elementor-size-default"><?php echo get_the_title(); ?></h4>		
							</div>
							<p class="descrition-wrap"><?php echo get_the_content(); ?></p>
							<p class="category-wrap">Category: <?php echo $category_name; ?> | Type:  <?php echo $type_name; ?>&nbsp;</p>
							<p class="category-wrap">Grade:  <?php echo $grade_name; ?></p>
							<p class="grade-wrap">Instructor Name: <?php echo $full_name; ?></p>
							<?php if ( is_user_logged_in() ) {
							if ( tutor_utils()->is_enrolled() ) {?><div class="btn-wrap single-coursebtn"><a href="<?php echo get_the_permalink(); ?>" class="r_more_btn">Read more</a></div><?php }
							else{
								?>
							<div class="btn-wrap single-coursebtn"><a href="<?php echo get_the_permalink(get_post_meta(get_the_ID(),"_tutor_course_product_id",true)); ?>" class="r_more_btn">Read more</a></div>
								<?php
							}
							}
							
							else{ ?><div class="btn-wrap single-coursebtn"><a href="<?php echo get_the_permalink(get_post_meta(get_the_ID(),"_tutor_course_product_id",true)); ?>" class="r_more_btn">Read more</a></div><?php } ?>

							</div>
							<div class="tutor-loop-course-footer1 prd-right">
								<div class="prd-right-inner">
									<div class="price-wrap"><?php echo "Price: $".$final_price ; ?></div>
									<div class="rating-wrap">
										Rating:<br>
										<?php
										$course_rating = tutor_utils()->get_course_rating();
										tutor_utils()->star_rating_generator($course_rating->rating_avg);
										?>
										<span class="tutor-rating-count">
											<?php
											if ($course_rating->rating_avg > 0) {
												echo apply_filters('tutor_course_rating_average', $course_rating->rating_avg);
												echo '<i>(' . apply_filters('tutor_course_rating_count', $course_rating->rating_count) . ')</i> Reviews';
											}
											?>
										</span>
									</div>

						</div>
					</div>
					</div>
					<?php endwhile;
						?>
						<nav class="pagination">
     <?php
     $big = 999999999;
     echo paginate_links( array(
          'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
          'format' => '?paged=%#%',
          'current' => max( 1, get_query_var('paged') ),
          'total' => $query->max_num_pages,
          'prev_text' => '&laquo;',
          'next_text' => '&raquo;'
     ) );
?>
</nav>
<?php wp_reset_postdata(); ?> 
						<?php
						else: ?>
						<h5 style="width:100%;text-align:center;" class="error">No Class found!</h5>
					<?php
						endif;
						
					?>
				
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>