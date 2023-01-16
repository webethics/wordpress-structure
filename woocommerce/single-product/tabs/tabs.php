<?
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>
 <div class="col-wrap-full">
	<div class="woocommerce-tabs wc-tabs-wrapper">
		<ul class="tabs wc-tabs" role="tablist">
			<? foreach ( $product_tabs as $key => $product_tab ) : ?>
				<li class="<? echo esc_attr( $key ); ?>_tab" id="tab-title-<? echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<? echo esc_attr( $key ); ?>">
					<a href="#tab-<? echo esc_attr( $key ); ?>">
						<? echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
					</a>
				</li>
			<? endforeach; ?>
		</ul>
		<? foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<? echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<? echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<? echo esc_attr( $key ); ?>">
				<?
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				?>
			</div>
		<? endforeach; ?>

		<? do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>
	</div>

<? endif; ?>
