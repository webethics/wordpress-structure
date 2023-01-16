<?php
/**
* Template Name: Store Page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

get_header(); 
	$newarr = array();
	$post_per_page = 8;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;	

		 $args = array(
            'post_type' => array('product','courses'),
            'posts_per_page' => $post_per_page,
			'post_status'=> 'publish',	
			'paged' => $paged,
			'tax_query' => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => array( 20 ),
						'operator' => 'NOT IN',
					),
				),
            );
        $loop1 = new WP_Query( $args );
		
$user_posts = get_posts($args);	
//$count = get_num_row($user_posts);	
		?>
		 <section  class="prd-wrap section-wrap">
            <div class="container-wrap">
               <div class="row-wrap">
				  <!--div class="col-wrap-full"><p class="search_result_wrap">22 Results based on search criteria:</p></div-->	
                  <div class="col-wrap-full">
		
		
		<?php
        if ( $user_posts ) {
           foreach($user_posts as $post):
			global $product;
			
			$post_meta = get_post_meta($post->ID);	
			if($post->post_type == "product"){
			if(isset($post_meta['_regular_price'][0]))
						$reg_price = $post_meta['_regular_price'][0];
			}else{
					$reg_price = tutor_utils()->get_course_price($post->ID);
			}
			?>
			        
					<div class="boxy-inner">
						<div class="img-container"> <a href="<?php echo esc_url( get_permalink($post->ID) ); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog');?></a></div>
						<div class="prd-content">
						<div class="elementor-widget-container">
									<h4 class="elementor-heading-title elementor-size-default"><?php echo $post->post_title; ?></h4>		
						</div>
						<p class="descrition-wrap">
							<?php echo  substr(strip_tags($post->post_content), 0, 200		); ?></p>
							<?php 
							if($post->post_type == "product"){
							  	$term_obj_list2 = get_the_terms(  $post->ID, 'product_cat' );
								$terms_string2 = join(', ', wp_list_pluck($term_obj_list2, 'name'));
							}else{
								$term_obj_list2 = get_the_terms(  $post->ID, 'course-category' );
								$terms_string2 = join(', ', wp_list_pluck($term_obj_list2, 'name'));
							}
								$term_obj_list = get_the_terms(  $post->ID, 'subject' );
								$terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
								
								$term_obj_list1 = get_the_terms(  $post->ID, 'grade-levels' );
								$terms_string1 = join(', ', wp_list_pluck($term_obj_list1, 'name'));
								
							if($terms_string2)
								echo '<p class="grade-wrap">Type: '.$terms_string2.'</p>';			
							
							if($terms_string)
								echo '<p class="grade-wrap">Subject: '.$terms_string.'</p>';

							if($terms_string1)
								echo '<p class="grade-wrap">Grade: '.$terms_string1.'</p>';   
							
							?>
				
						<div class="btn-wrap"><a href="<?php echo esc_url( get_permalink($post->ID) ); ?>" class="r_more_btn">Read more</a></div>
						</div>
						<div class="prd-right">
							<div class="prd-right-inner">	
							<div class="price-wrap">Price: $<?php echo $reg_price; ?></div>
							<div class="rating-wrap">Rating:<br>★★★★★ 4.9 | 47&nbsp; Reviews</div>
							</div>
						</div>
					</div>
					
			


                 
			<?php
               // wc_get_template_part( 'content', 'product' );
           endforeach;
        } else {
            echo __( 'No products found' );
        }
        wp_reset_postdata();
    ?>
<nav class="pagination">
     <?php
     $big = 999999999;
     echo paginate_links( array(
          'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
          'format' => '?paged=%#%',
          'current' => max( 1, get_query_var('paged') ),
          'total' => $loop1->max_num_pages,
          'prev_text' => '&laquo;',
          'next_text' => '&raquo;'
     ) );
?>
</nav>
 </div>
               </div>
            </div>
         </section>	 
			


<?php get_footer(); ?>