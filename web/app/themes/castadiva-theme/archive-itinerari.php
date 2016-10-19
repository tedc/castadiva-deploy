<?php 
    use Roots\Sage\Extras; ?>
<?php
global $wp_query;
$args = array('post_type'=> get_post_type(),'posts_per_page'=>-1);
$posts_count = $GLOBALS['wp_query']->post_count;
if(is_search()) {
    $max = $wp_query->found_posts;
} else {
    $max = count(get_posts($args));
}
$posts_per_page = get_option('posts_per_page');
?>
<header class="main-header">
    <div class="main-header-content">
        <i class="flowers"></i>
        <h1 class="title light"><?php echo __('Gli <strong>Itinerari</strong>', 'castadiva'); ?></h1>
        <div class="content row-top row-md-top">
        <em><?php echo __('Vi offriamo itinerari turistici alla scoperta del territorio per regalarvi esperienze uniche e profonde attraverso le meraviglie dei nostri paesaggi siciliani.', 'castadiva'); ?></em></div>
    </div>
</header>
<section class="container row row-lg" ng-load-more>
<?php while(have_posts()) : the_post(); ?>
<article <?php post_class(); ?> id="tour_<?php the_ID(); ?>">
    <div class="tour-diamond-header">
        <div class="pattern" style="background-image:url(<?php echo get_field('pattern_tour')['url']; ?>); background-size: <?php echo get_field('pattern_tour')['width']/2; ?>px <?php echo get_field('pattern_tour')['height']/2; ?>px;"></div>
    </div>
    <figure class="tour-figure">
        <?php the_post_thumbnail(array(600,600, true)); ?>
        
    </figure>
    <div class="tour-content-single">
        <div class="tour-content-map" style="background-image:url(<?php the_field('tour_image'); ?>)"></div>
        <h2 class="title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <div class="row-top row-md-top">
        <?php the_excerpt(); ?>
        </div>
    </div>
    <?php Extras\btn(__('Scopri', 'castadiva'), get_permalink(get_the_ID())); ?>
    <figure class="diamond" ng-sm from="{y: '100%'}" to="{y: '-100%'}" duration="200%" offset="-100" trigger-hook="onEnter" trigger-element="#tour_<?php the_ID(); ?>">
        <?php the_post_thumbnail(array(600,600, true), array('class'=>'img')); ?>
    </figure>
</article>
<?php endwhile; ?>
<?php 
// stuff
if($posts_count >= $posts_per_page) :  ?>
<?php get_template_part('templates/ajax', get_post_type()); ?>
<?php $search (is_search()) ? ", '".get_search_query()."'" : ""; ?>
<div class="buttons">
    <span class="btn" ng-click="$event.stopPropagation(); loadMorePosts('posts', <?php echo (is_category()) ? get_queried_object()->term_id : 'false'; ?>, '<?php echo ICL_LANGUAGE_CODE; ?>', <?php echo $max . $search; ?>)" ng-show="!hideMore">
        <span class="btn-text" ng-class="{hidden: : isLoading}" ng-click="$event.stopPropagation(); loadMorePosts('posts', <?php echo (is_category()) ? get_queried_object()->term_id : 'false'; ?>, '<?php echo ICL_LANGUAGE_CODE; ?>', <?php echo $max . $search; ?>)"><?php echo __('Altri', 'castadiva'); ?></span>
        <span class="btn-loading" ng-class="{visible : isLoading}"></span>
    </span>
</div>
<?php endif; ?>
</section>
<div class="triangle">
    <div class="pattern-main" ng-sm from="{y: '-100%'}" to="{y : '0%'}" trigger-element=".triangle" duration="150" trigger-hook="1"></div>
</div>
</section>
<?php get_template_part('templates/page', 'block-newsletter'); ?>