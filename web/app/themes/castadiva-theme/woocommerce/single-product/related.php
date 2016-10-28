<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

if ( ! $related = $product->get_related( $posts_per_page ) ) {
	return;
}

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products                    = new WP_Query( $args );
$woocommerce_loop['name']    = 'related';
$woocommerce_loop['columns'] = apply_filters( 'woocommerce_related_products_columns', $columns );

$count_product = 0; 

if ( $products->have_posts() ) : $total_product = $posts_per_page - 1; ?>
   
	<div class="related products row row-lg">
        <header class="related-header container trapeze pattern">
            <div class="row row-md">
                <h2 class="title xl-size light"><?php _e( 'Prodotti simili', 'castadiva' ); ?></h2>
            </div>
        </header>    
        <div class="products row-top row-lg-top" ng-products>
            <ul class="products-row" ng-swipe-right="move(false, <?php echo $total_product; ?>)" ng-swipe-left="move(true, <?php echo $total_product; ?>)">
                <?php while($products->have_posts()) : $products->the_post(); ?>
                <li <?php post_class("products-row-item product-show-more"); ?> ng-class="{current : pos == <?php echo $count_product; ?>}">
                    <?php get_template_part('templates/content', 'product'); ?>      
               </li>
                <?php $count_product++; endwhile; wp_reset_query(); ?>
            </ul>
            <nav class="buttons products-row-buttons">
                <div class="carousel-nav" data-total="<?php echo $total_product; ?>">
                    <?php if($total_product > 0) : ?>
                    <span class="arrow arrow-left" ng-click="move(false, <?php echo $total_product; ?>)" ng-class="{inactive : pos == 0}"><span class="arrow-text">&lsaquo;</span></span>
                    <?php endif; ?>
                    <a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>" class="btn"><span class="btn-text"><?php echo __('Guarda<br/>tutti', 'castadiva'); ?></span></a>
                    <?php if($total_product > 0) : ?>
                    <span class="arrow arrow-right" ng-click="move(true, <?php echo $total_product; ?>)" ng-class="{inactive : pos == <?php echo $total_product; ?>}"><span class="arrow-text">&rsaquo;</span></span>
                   <?php endif; ?>
                </div>
            </nav>
        </div>   
	</div>

<?php endif;

wp_reset_postdata();
