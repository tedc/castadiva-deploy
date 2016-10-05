<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
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

if ( ! $upsells = $product->get_upsells() ) {
	return;
}

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => 'post__in',
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => WC()->query->get_meta_query()
);

$count_product = 0; $total_product = count($upsells) - 1; 

$products                    = new WP_Query( $args );
$woocommerce_loop['name']    = 'up-sells';
$woocommerce_loop['columns'] = apply_filters( 'woocommerce_up_sells_columns', $columns );

if ( $products->have_posts() ) : ?>

	<section class="related products row row-lg">
        <header class="related-header container trapeze pattern">
            <div class="row row-md">
                <h2 class="title xl-size light"><?php _e( 'Prodotti simili', 'castadiva' ); ?></h2>
            </div>
        </header>
        <div class="products" ng-products>
            <ul class="products-row" ng-swipe-right="dir(false, pos, <?php echo $total_product; ?>)" ng-swipe-left="dir(true, pos, <?php echo $total_product; ?>)">
                <?php while($products->have_posts()) : $products->the_post(); ?>
                <li <?php post_class("products-row-item product-show-more"); ?> ng-class="{current : pos == <?php echo $count_product; ?>}">
                    <?php get_template_part('templates/content', 'product'); ?>      
               </li>
                <?php $count_product++; endwhile; wp_reset_query(); ?>
            </ul>
            <nav class="buttons products-row-buttons">
                <div class="carousel-nav">
                    <span class="arrow arrow-left" ng-click="dir(false, pos, <?php echo $total_product; ?>)" ng-class="{inactive : pos == 0}"><span class="arrow-text">&lsaquo;</span></span>
                    <a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>" class="btn"><span class="btn-text"><?php the_sub_field('button_text'); ?></span></a>
                    <span class="arrow arrow-right" ng-click="dir(true, pos, <?php echo $total_product; ?>)" ng-class="{inactive : pos == <?php echo $total_product; ?>}"><span class="arrow-text">&rsaquo;</span></span>
                </div>
            </nav>
        </div>
	</section>

<?php endif;

wp_reset_postdata();
