<?php use Roots\Sage\Extras; ?>
<div class="row-figure-container">
    <figure class="row-figure">
        <img src="<?php the_sub_field('large_image'); ?>" class="img" />
        <img src="<?php the_sub_field('image_png'); ?>" class="img-png" ng-sm from="{y : '20%', opacity : 0}" to="{y : '0%', opacity : 1}" />
    </figure>
    <?php if(have_rows('bottone')) : while(have_rows('bottone')) : the_row(); ?>
    <?php Extras\btn(get_sub_field('testo'), get_sub_field('link'), false, null, null, get_sub_field('colore')); ?>
    <?php endwhile; endif; ?>
</div>