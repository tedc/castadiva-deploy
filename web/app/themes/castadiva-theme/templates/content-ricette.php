<?php $flex = (has_post_thumbnail()) ? ' flx' : ''; ?>
<article <?php post_class('news-item-content'.$flex); ?>>
    <?php if(has_post_thumbnail()) : ?>
    <figure class="recipe-figure">
        <div class="diamond">
            <?php the_post_thumbnail(array(600,600), array('class' => 'img')); ?>
        </div>
    </figure>
    <div class="post-content">
    <?php endif; ?>
    <header>
        <?php $cats = wp_get_post_terms( get_the_ID(), 'recipe_cat');
                foreach($cats as $ct){ echo '<a href="'.get_term_link($ct->term_id).'" class="recipe-cat">'.$ct->name.'</a>';}
            ?>
        <h2 class="title news-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <?php while(have_rows('recipe_builder')) : the_row(); 
            if(get_row_layout() == 'first') : ?>
        <div class="recipe-first-line">
           <span>
                <?php echo __('Difficoltà', 'castadiva'); ?>
                <?php for($i = 1; $i <= 5; $i++) : ?>
                <i class="dot<?php if($i <= get_sub_field('difficulty')): ?> fill<?php endif; ?>"></i>
                <?php endfor; ?>
            </span>
            <span>
                <?php echo __('Preparazione', 'castadiva'); ?>
                <time class="recipe-time"><?php the_sub_field('time'); ?></time>
            </span>
        </div>
        <?php endif; ?>
        <?php endwhile; ?>
    </header>
    <div class="news-summury">
        <?php the_excerpt(); ?>
        <a href="<?php the_permalink(); ?>" class="read-more"><?php echo __('Leggi tutto', 'castadiva'); ?></a>
    </div>
    <?php if((has_post_thumbnail()) : ?>
    </div>
    <?php endif; ?>
</article>
