<?php while(have_posts()) : the_post(); ?>
<header class="main-header">
    <div class="main-header-content">
        <i class="flowers"></i>
        <h1 class="title">
            <?php the_title(); ?>
        </h1>
    </div>
</header>
<?php get_template_part('templates/page', 'layout'); ?>
<?php get_template_part('templates/tour', 'form'); ?>
<?php endwhile; ?>