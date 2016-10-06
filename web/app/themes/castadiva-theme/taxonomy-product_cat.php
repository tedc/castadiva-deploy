<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
use Roots\Sage\Extras;
global $query;
$product_count = count(get_posts(
    array(
        'post_type'=>'product',
        'posts_per_page'=>-1,
        'tax_query' => array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'term' => get_queried_object()->slug
        )
    )
));
$posts_count = $GLOBALS['wp_query']->post_count;
$cat = $wp_query->get_queried_object();
$posts_per_page = get_option('posts_per_page');
?>
<?php if(have_posts()) : ?>
<?php $thumbnail_id = (get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ) != '') ? get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ) : false; $bg = (get_field('video', 'product_cat_'.$cat->term_id) == '' ) ? ' style="background-image:url('.wp_get_attachment_url($thumbnail_id).');"' : ''; ?>
        
<header class="main-header"<?php echo $bg; ?>>
    <?php 
                   // VIDEO
                   if(get_field('video', 'product_cat_'.$cat->term_id) != '' && $kind < 1) : ?>
            <?php $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', get_field('video', 'product_cat_'.$cat->term_id)['url']); ?>
            <div class="video-cover" style="background-image:url(<?php echo $file; ?>.jpg)">
                <video class="video-item" ng-video loop poster="<?php echo $file; ?>.jpg">
                    <source src="<?php echo $file; ?>.mp4" type="video/mp4" />
                    <source src="<?php echo $file; ?>.ogv" type="video/ogv" />
                    <source src="<?php echo $file; ?>.webm" type="video/webm" />
                </video>
            </div>
            <?php 
                   // ENDVIDEO
                   endif; ?>
    <div class="main-header-content">
        <h1 class="title light"><?php the_field('product_cat_title', 'product_cat_'.$cat->term_id); ?></h1>
    </div>
</header>
<?php get_product_search_form(); ?>
<div ng-load-more>
<ul class="grid-4 container flx wrap row-btm<?php if($posts_count < $posts_per_page){?> row-lg-btm<?php } ?> products">
<?php $my_query = new WP_Query(); while(have_posts()) : the_post(); ?>
<li <?php post_class('col-1 product-show-more'); ?> ng-sm from="{y : '20%', opacity: 0, ease: Back.easeOut.config(1.7)}" trigger-hook="1" speed="1">
    <?php get_template_part('templates/content', 'product'); ?>
</li>
<?php endwhile; wp_reset_query(); ?>
<?php get_template_part('templates/ajax', get_post_type()); ?>
</ul>
<?php 
// stuff
if($posts_count >= $posts_per_page) :  ?>
<div class="buttons">
    <span class="btn" ng-click="loadMorePosts('product', '<?php echo get_queried_object()->slug; ?>', '<?php echo ICL_LANGUAGE_CODE; ?>', <?php echo $product_count; ?>)">
        <span class="btn-text"><?php echo __('Altri', 'castadiva'); ?></span>
    </span>
</div>
<?php endif; endif; ?>
</div>
<?php get_template_part('templates/filters'); ?>
<?php get_template_part('templates/orderby'); ?>