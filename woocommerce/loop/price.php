<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>
<div class="prd-right">
		<div class="prd-right-inner">	
			
<?php if ( $price_html = $product->get_price_html() ) : ?>
	<div class="price-wrap"><?php echo $price_html; ?></div>
<?php endif; ?>
<?php if ( ! wc_review_ratings_enabled() ) {
	return;
} 
$comments_count = wp_count_comments( $product->get_id() );
$average = $product->get_average_rating();

 if($comments_count->total_comments > 1){
	 $review_labl = "Reviews";
 }else{
	 $review_labl = "Review";
 }
echo '<div class="rating-wrap">Rating:<br><div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>  '.$average.' | '.$comments_count->total_comments.' '.$review_labl.'</div>';

?>
	</div>
</div>
</div>