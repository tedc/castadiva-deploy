<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
use Roots\Sage\Extras;
global $wp_query;
$posts_count = $GLOBALS['wp_query']->post_count;
if(is_search()) {
    $product_count = $wp_query->found_posts;
} else {
    $product_count = count(get_posts(array('post_type'=>'product','posts_per_page'=>-1)));
}
$posts_per_page = get_option('posts_per_page');
?>
<?php if(have_posts()) : ?>
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
if($posts_count > $posts_per_page) :  ?>
<div class="buttons" ng-show="!hideMore">
    <?php $search (is_search()) ? ", '".get_search_query()."'" : ""; ?>
    <span class="btn" ng-click="loadMorePosts('product', false, '<?php echo ICL_LANGUAGE_CODE; ?>', <?php echo $product_count . $search; ?>)">
        <span class="btn-text"><?php echo __('Altri', 'castadiva'); ?></span>
    </span>
</div>
<?php endif; endif; ?>
</div>
<?php get_template_part('templates/filters'); ?>
<?php get_template_part('templates/orderby'); ?>