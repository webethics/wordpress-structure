<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product,$wpdb;
if( has_term(20, 'product_cat' ) ) {
	$course_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE (meta_key = '_tutor_course_product_id' AND meta_value = '". get_the_ID() ."')");

	$content_post = get_post($course_id);
	echo $content = $content_post->post_content;
	//$excerpt = wp_trim_words( $content, 25, '<a id="clickcontent" href="javascript:void(0)">..Read More</a>'); ?>
	
<?php
}
else{
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>

<p><?php 
$strlen =  strlen($product->get_description());
if($strlen > 40){
echo substr(strip_tags($product->get_description()),0,100).'<a id="clickcontent" href="#">..Read More</a>';
}else{
echo substr(strip_tags($product->get_description()),0,40).'<a id="clickcontent" href="#">..Read More</a>';
	
}
 ?></p>
	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<p class="category-wrap">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</p>' ); ?>

	<?php 
	$catsarr = array();
		$term_obj_list = get_the_terms(  $product->get_id(), 'subject' );
		$terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
								
		$term_obj_list1 = get_the_terms(  $product->get_id(), 'grade-levels' );
		$terms_string1 = join(', ', wp_list_pluck($term_obj_list1, 'name'));
		$course_tag =  wp_list_sort( $term_obj_list1, 'term_id', 'ASC' );
		
		foreach ($course_tag as $course_category){
			 $category_name = $course_category->name;
			array_push($catsarr,$category_name);
		}
	
	$condition =  get_post_meta($product->get_id(),'_condition',true); 
	if($terms_string)
		echo '<p class="grade-wrap">Subject: '.$terms_string.'</p>';

	if(!empty($catsarr))
		echo '<p class="grade-wrap">Grade: <span>'.implode(", ",$catsarr).'</span></p>';   
	//echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
	<?php if($condition)
		echo '<p class="grade-wrap">Condition: <span style="color:#000;">'.$condition.'</span></p>';   
	do_action( 'woocommerce_product_meta_end' ); ?>

</div>
<?php } ?>