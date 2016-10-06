<?php while(have_posts()) : the_post(); ?>
<header class="main-header" ng-sm to="{y : -100}" trigger-hook="onLeave" duration="100%">
    <?php get_template_part('templates/block', 'header'); ?>
</header>
<?php get_template_part('templates/page', 'layout'); ?>
<?php get_template_part('templates/tour', 'form'); ?>
<?php endwhile; ?>