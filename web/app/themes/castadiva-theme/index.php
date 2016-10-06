<?php
$args = (is_category()) ? array('post_type'=>'post','posts_per_page'=>-1,'category__in' => get_queried_object()->term_id) : array('post_type'=>'post','posts_per_page'=>-1);
$max = count(get_posts($args));
$posts_count = $GLOBALS['wp_query']->post_count;
$posts_per_page = get_option('posts_per_page');
?>
<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>
<section class="posts" ng-load-more ng-class="{'row-btm row-lg-btm' : hideMore}">
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
<?php endwhile; ?>
<?php 
// stuff
if($posts_count >= $posts_per_page) :  ?>
<?php get_template_part('templates/ajax', get_post_type()); ?>
<div class="buttons">
    <span class="btn" ng-click="loadMorePosts('posts', <?php echo (is_category()) ? get_queried_object()->term_id : 'false'; ?>, '<?php echo ICL_LANGUAGE_CODE; ?>', <?php echo $max; ?>)" ng-show="!hideMore">
        <span class="btn-text"><?php echo __('Altri', 'castadiva'); ?></span>
    </span>
</div>
<?php endif; ?>
</section>
<?php get_template_part('templates/page', 'block-newsletter'); ?>