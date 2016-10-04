<article class="news-item-content flx" ng-class="post.post_class" >
    <figure class="recipe-figure">
        <div class="diamond">
            <img ng-src="{{post.post_thumbnail[0]}}" class="img" />
        </div>
    </figure>
    <div class="post-content">
        <header>
            <?php $cats = wp_get_post_terms( get_the_ID(), 'recipe_cat');
                    foreach($cats as $ct){ echo '<a href="'.get_term_link($ct->term_id).'" class="recipe-cat">'.$ct->name.'</a>';}
                ?>
            <h2 class="title news-title">
                <a ng-href="{{post.link}}" ng-bind-title="post.title.rendered"></a>
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
            {{post.exerpt}}
            <a ng-href="{{post.link}}" class="read-more"><?php echo __('Leggi tutto', 'castadiva'); ?></a>
        </div>
    </div>
</article>