<?php
global $wp_query;
if(is_category()) :
 var_dump(get_queried_object());
endif;
$args = (is_taxonomy(get_queried_object()->taxonomy)) ? array('post_type'=>get_post_type(),'posts_per_page'=>-1, "tax_query" => array(array(
    "taxonomy" => get_queried_object()->taxonomy,
    "field" => 'term_id',
    "terms" => get_queried_object()->term_id)
)) : array('post_type'=>'post','posts_per_page'=>-1);
$posts_count = $GLOBALS['wp_query']->post_count;
if(is_search()) {
    $max = $wp_query->found_posts;
} else {
    $max = count(get_posts($args));
}
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
if($max > $posts_per_page) :  ?>
<?php get_template_part('templates/ajax', get_post_type()); ?>
<div class="row-top row-lg-top aligncenter" ng-show="posts.length == 0">
    <p><?php echo __('Spiacenti, nessun risultato disponibile per la tua ricerca.', 'castadiva'); ?></p>
    <p class="buttons">
        <a href="<?php echo post_type_archive_link( 'itinerari' ); ?>" class="btn"><span class="btn-text"><?php the_sub_field('button_text'); ?></span></a>
    </p>
</div>
<?php $search = (is_search()) ? ", '".get_search_query()."'" : ""; ?>
<div class="buttons">
    <span class="btn" ng-click="loadMorePosts('posts', <?php echo (is_category()) ? get_queried_object()->term_id : 'false'; ?>, '<?php echo ICL_LANGUAGE_CODE; ?>', <?php echo $max . $search; ?>)" ng-show="!hideMore">
        <span class="btn-text" ng-class="{hidden : isLoading}" ng-click="$event.stopPropagation(); loadMorePosts('posts', <?php echo (is_category()) ? get_queried_object()->term_id : 'false'; ?>, '<?php echo ICL_LANGUAGE_CODE; ?>', <?php echo $max . $search; ?>)"><?php echo __('Altri', 'castadiva'); ?></span>
        <span class="btn-loading" ng-class="{visible : isLoading}"></span>
    </span>
</div>
<?php endif; ?>
</section>
<?php get_template_part('templates/page', 'block-newsletter'); ?>