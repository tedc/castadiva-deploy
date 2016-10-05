<?php use Roots\Sage\Extras; ?>
<section class="recipes" ng-carousel full-slider="true">
<?php if(get_sub_field('title')) : ?>
    <header class="row-btm row-lg-btm container recipes-header">
        <h3 class="title light">
            <?php echo __('Le ricette', 'castadiva'); ?>
            <strong><?php echo __('di Castadiva', 'castadiva'); ?></strong>
        </h3>
    </header>
<?php endif; ?>
<?php 
    $recipes = get_sub_field('ricette');
    $total = count($recipes);
    $query = new WP_Query(array(
        'post_type' => 'ricette',
        'post__in' => $recipes,
        "orderby" => 'post__in'
    ));
    $count = 0;
    if($query->have_posts()) : ?>
        <ul class="carousel-wrapper slider-wrapper" ng-class="{'slider-completed' : isCompleted}" ng-swipe-right="dir(false, pos, <?php echo $total - 1; ?>, false, false)" ng-swipe-left="dir(true, pos, <?php echo $total - 1; ?>, false, false)">
        <?php while($query->have_posts()) : $query->the_post(); ?>
            <li class="carousel-item recipe-item<?php echo ($count == 0) ? ' current' : ''; ?>" ng-class="{current : pos == <?php echo $count; ?>}" style="background-image: url(<?php echo the_post_thumbnail_url('full'); ?>)">
                <div class="recipe-content">
                    <i class="flowers"></i>
                    <h2 class="title xl-size light">
                        <?php the_title(); ?>
                    </h2>
                    <div class="row-top row-md-top">
                    <?php the_excerpt(); ?>
                    </div>
                    <?php Extras\btn($text = __('Leggi', 'castadiva'), $link = get_permalink()); ?>
                </div>
                <?php $img = get_field('recipe_png', get_the_ID());
                    echo '<img src="'.$img['url'].'" alt="'.$img['alt'].'" class="recipe-png" />'; ?>
                <a href="<?php the_permalink(); ?>" class="permalink"><?php the_title(); ?></a>     
            </li>
        <?php $count++; endwhile; wp_reset_query(); ?>
        </ul>
    <?php if($total > 1) : ?>
    <div class="recipe-buttons">
        <nav class="carousel-nav">
            <span class="arrow arrow-left" ng-click="dir(false, pos, <?php echo $total - 1; ?>, false, false)" ng-class="{inactive : pos == 0}"><span class="arrow-text">&lsaquo;</span></span>
                <a href="<?php echo get_post_type_archive_link( 'ricette' ); ?>" class="btn recipe-btn"><span class="btn-text"><?php echo __('Tutte le<br/>ricette'); ?></span></a>
                <span class="arrow arrow-right" ng-click="dir(true, pos, <?php echo $total - 1; ?>, false, false)" ng-class="{inactive : pos == <?php echo $total - 1; ?>}"><span class="arrow-text">&rsaquo;</span></span>
            </div>
        </nav>
    </div>

    <?php endif; endif; ?>
</section>