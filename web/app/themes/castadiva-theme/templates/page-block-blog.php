<?php 
    use Roots\Sage\Extras;
    $news = get_sub_field('qnt');
    $total = $news;
    $query = new WP_Query(array(
        'posts_per_page' => $news
    ));
    $count = 0;
    if($query->have_posts()) : ?>
    <div class="carousel" ng-carousel news-slider="true">
        <ul class="carousel-wrapper news-carousel" ng-swipe-left="pos > 0 && dir(false, pos, <?php echo $total - 1; ?>, false, true)" ng-swipe-right="pos < <?php echo $total - 1; ?> && dir(true, pos, <?php echo $total - 1; ?>, false, true)">
            <?php while($query->have_posts()) : $query->the_post(); ?>
            <li class="carousel-item news-item grid-2<?php echo ($count == 0) ? ' current' : ''; ?>" ng-class="{current : pos == <?php echo $count; ?>}" data-news="<?php echo $count; ?>" style="z-index:<?php echo $total - $count; ?>">
                <div class="news-item-col news-item-col-figure">
                    <figure class="news-item-figure"  style="background-image: url(<?php echo the_post_thumbnail_url('full'); ?>)">
                        <?php the_post_thumbnail('full', array('class' => 'thumb-hidden')); ?>
                    </figure>
                </div>
                <div class="news-item-col news-item-content-col">
                    <?php get_template_part('templates/content'); ?>
                </div>   
            </li>
            <?php $count++; endwhile; wp_reset_query(); ?>
        </ul>
        <?php if($total > 1) : ?>
        <nav class="news-slider-nav">
            <div class="buttons">
                <span class="arrow arrow-left" ng-click="dir(false, pos, <?php echo $total - 1; ?>, false, true)" ng-class="{inactive : pos == 0}"><span class="arrow-text">&lsaquo;</span></span>
                    <a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>" class="btn news-btn"><span class="btn-text"><?php echo __('Vai<br/>al blog'); ?></span></a>
                    <span class="arrow arrow-right" ng-click="dir(true, pos, <?php echo $total - 1; ?>, false, true)" ng-class="{inactive : pos == <?php echo $total - 1; ?>}"><span class="arrow-text">&rsaquo;</span></span>
            </div>
        </nav>
        <?php endif; ?>
    </div>
<?php endif; ?>