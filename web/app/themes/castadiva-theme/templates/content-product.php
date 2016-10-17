<div class="offset product-item-figure">
    <?php woocommerce_template_loop_product_thumbnail(); ?>
    <?php get_template_part('templates/product', 'more'); ?>  
    <a class="permalink" href="<?php the_permalink(); ?>"></a>
</div>
<div class="offset row row-md">
    <?php woocommerce_show_product_loop_sale_flash(); ?>
    <h3 class="title"><?php the_title(); ?></h3>
    <?php woocommerce_template_single_excerpt(); ?>
    <?php get_template_part('templates/product', 'attributes'); ?>
    <?php woocommerce_template_single_price(); ?>
    <a class="permalink" href="<?php the_permalink(); ?>"></a>
</div>