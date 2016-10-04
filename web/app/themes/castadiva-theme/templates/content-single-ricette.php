<?php while(have_posts()) : the_post(); ?>
<style>
    .main-header {
        background-image: url(<?php the_post_thumbnail_url(); ?>);
    }
</style>
<article <?php post_class(); ?>>
<header class="main-header">
    <div class="main-header-content">
        <i class="flowers"></i>
        <h1 class="title">
            <?php the_title(); ?>
        </h1>
    </div>
</header>
<?php get_template_part('templates/recipe', 'builder'); ?>
</article>

<?php endwhile; ?>