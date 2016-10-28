<?php while(the_flexible_field('titolo')) :  ?>
<header class="row row-lg container aligncenter">
    <h2 class="title <?php the_sub_field('title_size'); ?> light">
        <?php the_sub_field('prima_riga'); ?><br/>
        <span><?php the_sub_field('seconda_riga'); ?></span>
    </h2>
</header>
<?php endwhile; ?>
<?php $args = get_sub_field('prodotti'); $count_product = 0; $total_product = count($args) - 1; $products = new WP_Query(array('post_type' => 'product', 'post__in' => $args)); print_r($products->post_count); if(get_sub_field('is_carousel')) : ?>
<div class="carousel products" ng-carousel>
    <ul class="carousel-wrapper" ng-swipe-right="dir(false, pos, <?php echo $total_product; ?>, false, false)" ng-swipe-left="dir(true, pos, <?php echo $total_product; ?>, false, false)">
        <?php while($products->have_posts()) : $products->the_post(); ?>
        <li <?php $currentClass = ($count_product == 0) ? ' current' : '';  post_class('carousel-item product-show-more product '.$currentClass); ?> ng-class="{current : pos == <?php echo $count_product; ?>}">
            <figure class="carousel-img product-item-figure">
                <?php the_post_thumbnail(); ?>
                <?php get_template_part('templates/product', 'more'); ?>
                <a href="<?php the_permalink(); ?>" class="permalink"><?php the_title(); ?></a> 
            </figure>
            <div class="carousel-content row-top row-md-top">
                <h3 class="title">
                    <?php the_title(); ?>
                </h3>
                <?php get_template_part('templates/product', 'attributes'); ?>
                <?php woocommerce_template_single_price(); ?>      
                <a href="<?php the_permalink(); ?>" class="permalink"><?php the_title(); ?></a> 
            </div>        
       </li>
        <?php $count_product++; endwhile; wp_reset_query(); ?>
    </ul>
    <nav class="buttons">
        <div class="carousel-nav">
            <span class="arrow arrow-left" ng-click="dir(false, pos, <?php echo $total_product; ?>, false, false)" ng-class="{inactive : pos == 0}"><span class="arrow-text">&lsaquo;</span></span>
            <a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>" class="btn"><span class="btn-text"><?php the_sub_field('button_text'); ?></span></a>
            <span class="arrow arrow-right" ng-click="dir(true, pos, <?php echo $total_product; ?>, false, false)" ng-class="{inactive : pos == <?php echo $total_product; ?>}"><span class="arrow-text">&rsaquo;</span></span>
        </div>
    </nav>
</div>
<?php else : ?>
<div class="products" ng-products>
    <ul class="products-row" ng-swipe-left="move(true, <?php echo $total_product; ?>)" ng-swipe-right="move(false, <?php echo $total_product; ?>)">
        <?php while($products->have_posts()) : $products->the_post(); ?>
        <li <?php post_class("products-row-item product-show-more"); ?>>
            <?php get_template_part('templates/content', 'product'); ?>
       </li>
        <?php $count_product++; endwhile; wp_reset_query(); ?>
    </ul>
    <nav class="buttons products-row-buttons">
        <div class="carousel-nav" data-total="<?php echo $total_product; ?>">
            <?php if($total_product > 0) : ?>
            <span class="arrow arrow-left" ng-click="move(true, <?php echo $total_product; ?>)"><span class="arrow-text">&lsaquo;</span></span>
            <?php endif; ?>
            <a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>" class="btn"><span class="btn-text"><?php the_sub_field('button_text'); ?></span></a>
            <?php if($total_product > 0) : ?>
            <span class="arrow arrow-right" ng-click="move(false, <?php echo $total_product; ?>)"><span class="arrow-text">&rsaquo;</span></span>
            <?php endif; ?>
        </div>
    </nav>
</div>
<?php endif; ?>