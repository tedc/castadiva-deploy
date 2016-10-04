<?php if(is_front_page() || is_page_template('template-custom.php')) : ?>

<?php get_template_part('templates/page', 'layout'); ?>
<?php else : ?>
<?php if(!is_checkout() && !is_cart()) : ?>
<div class="container row row-lg content">
    
    <?php the_content(); ?>
</div>
<?php get_template_part('templates/page', 'layout'); ?>
<?php else : ?>
<?php the_content(); ?>
<?php endif; endif; ?>
