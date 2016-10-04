<?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('row-top row-lg-top'); ?>>
        <?php if(has_post_thumbnail()) : ?>
        <figure class="figure">
            <?php the_post_thumbnail('post-thumb'); ?>
        </figure>
        <?php endif; ?>
        <header class="row-top row-md-top">
            <?php get_template_part('templates/entry-meta'); ?>
            <h1 class="title"><?php the_title(); ?></h1>
        </header>
        <div class="post-content row-top">
            <?php the_content(); ?>
        </div>
    </article>
    <footer class="news-post-nav post-nav row-lg row">
        <div class="post-nav-content">
        <?php previous_post_link('%link', '<span class="arrow arrow-left"><span class="arrow-text">&lsaquo;</span></span> <span class="post-nav-text">%title</span>', TRUE); ?>
        <?php get_template_part('templates/share'); ?>
        <?php next_post_link('%link', '<span class="post-nav-text">%title</span><span class="arrow arrow-right"><span class="arrow-text">&rsaquo;</span></span>', TRUE); ?>
        </div>
    </footer>
<?php endwhile; ?>
