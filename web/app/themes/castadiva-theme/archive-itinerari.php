<?php 
    use Roots\Sage\Extras; ?>
<header class="main-header">
    <div class="main-header-content">
        <i class="flowers"></i>
        <h1 class="title light"><?php echo __('Gli <strong>Itinerari</strong>', 'castadiva'); ?></h1>
        <em><?php echo __('Vi offriamo itinerari turistici alla scoperta del territorio per regalarvi esperienze uniche e profonde attraverso le meraviglie dei nostri paesaggi siciliani.', 'castadiva'); ?></em>
    </div>
</header>
<section class="container row row-lg">
<?php while(have_posts()) : the_post(); ?>
<article <?php post_class(); ?> id="tour_<?php the_ID(); ?>">
    <figure class="tour-figure">
        <?php the_post_thumbnail(array(300,300, true)); ?>
    </figure>
    <div class="tour-content-single row-top row-md-top">
        <h2 class="title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <div class="row-top row-md-top">
        <?php the_excerpt(); ?>
        <?php Extras\btn(__('Scopri', 'castadiva'), get_permalink(get_the_ID())); ?>
        </div>
    </div>
    <figure class="diamond" ng-sm from="{y: '100%'}" to="{y: '-100%'}" duration="200%" offset="-100" trigger-hook="onEnter" trigger-element="#tour_<?php the_ID(); ?>">
        <?php the_post_thumbnail(array(600,600, true), array('class'=>'img')); ?>
    </figure>
</article>
<?php endwhile; ?>
</section>