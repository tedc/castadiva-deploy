<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
    <section class="product-header">
        <?php get_template_part('templates/block', 'header'); ?>
        <div class="product-content grid-2 container">
            <figure class="col-1 figure offset-right row-lg row">
                <?php woocommerce_template_loop_product_thumbnail(); ?>
            </figure>
            <div class="col-1 offset-left row-lg row">
                <?php woocommerce_show_product_loop_sale_flash(); ?>
                <h3 class="title xl-size"><?php the_title(); ?></h3>
                <?php $cats = wp_get_post_terms(get_the_ID(), 'product_cat');
                    $total = count($cats) - 1; $count = 0; foreach($cats as $cat){
                        $comma = ($count < $total ) ? ', ' : '';
                        echo '<a class="product-cat product-cat-'.$cat->slug.'" href="'.get_term_link($cat->term_id).'">'.$cat->name.'</a>'.$comma;
                        $count++;
                    } ?>                
                <?php woocommerce_template_single_excerpt(); ?>
                <?php get_template_part('templates/product', 'attributes'); ?>
                <div class="row row-md">
                    <?php the_content(); ?>
                </div>
                <?php woocommerce_template_single_price(); ?>
                <?php get_template_part('templates/share'); ?> 
            </div>
        </div>
        <?php woocommerce_simple_add_to_cart(); ?>
    </section>  
    <?php get_template_part('templates/page', 'layout'); ?>
    <meta itemprop="url" content="<?php the_permalink(); ?>" />
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
