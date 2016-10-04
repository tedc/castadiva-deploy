<?php $flex = ((is_home() || is_category()) && has_post_thumbnail()) ? ' flx' : ''; ?>
<article <?php post_class('news-item-content'.$flex); ?>>
    <?php if((is_home() || is_category()) && has_post_thumbnail()) : ?>
    <figure class="figure">
        <?php the_post_thumbnail(array(600,600), array('class' => 'img')); ?>
    </figure>
    <div class="post-content">
    <?php endif; ?>
    <header>
        <?php get_template_part('templates/entry-meta'); ?>
        <h2 class="title news-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2> 
    </header>
    <div class="news-summury">
        <?php the_excerpt(); ?>
        <a href="<?php the_permalink(); ?>" class="read-more"><?php echo __('Leggi tutto', 'castadiva'); ?></a>
    </div>
    <?php if((is_home() || is_category()) && has_post_thumbnail()) : ?>
    </div>
    <?php endif; ?>
</article>
