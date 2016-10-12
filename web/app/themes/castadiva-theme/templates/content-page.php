<?php if(is_front_page() || is_page_template('template-custom.php')) : ?>

<?php get_template_part('templates/page', 'layout'); ?>
<?php else : ?>
<?php if(!is_checkout() && !is_cart()) : ?>
<?php $container = (is_account_page() && !is_user_logged_in()) ? '' : ' container content'; ?>
<div class="row-lg<?php echo $container; ?>">
    
    <?php the_content(); ?>
</div>
<?php get_template_part('templates/page', 'layout'); ?>
<?php else : ?>
<?php the_content(); ?>
<?php endif; endif; ?>
