<div class="diamonds">
    <?php $count = 0; while(the_flexible_field('shapes')) :  ?>
    <?php 
    $plus = ($count%2==0) ? -( 10 * (rand(10, 50)/10) ) : 10 * (rand(10, 50)/10);
    $fromTo = ' from=\'{ y : "'.$plus.'%"}\' to=\'{ y : "'.-($plus/2).'%"}\' duration="200%" trigger-hook="onEnter" trigger-element="parent"';
    $attrs = (get_row_layout() == 'shape') ? 'ng-sm style="background-color:'.get_sub_field('colore').';top:'.get_sub_field('top').'%;left:'.get_sub_field('left').'%"' : 'ng-sm style="top:'.get_sub_field('top').'%;left:'.get_sub_field('top').'%"';
    $attrs = $attrs.$fromTo; ?>
    <?php if(get_row_layout() == 'immagine') : ?>
        <figure class="diamond <?php the_sub_field('size'); ?>" <?php echo $attrs; ?>>
            <img class="img" src="<?php echo get_sub_field('img_file')['sizes']['large']; ?>" />
        </figure>
    <?php endif; ?>
    <?php if(get_row_layout() == 'pg') : ?>
        <figure class="floating <?php the_sub_field('size'); ?>" <?php echo $attrs; ?>>
            <img class="img" src="<?php echo get_sub_field('img_file')['sizes']['large']; ?>" />
        </figure>
    <?php endif; ?>
    <?php if(get_row_layout() == 'pattern') : ?>
        <div class="diamond <?php the_sub_field('size'); ?>" <?php echo $attrs; ?>>
            <div class="pattern" style="background-image:url(<?php the_sub_field('file'); ?>)"></div>
        </div>
    <?php endif; ?>
    <?php if(get_row_layout() == 'shape') : ?>
        <div class="diamond <?php the_sub_field('size'); ?>" <?php echo $attrs; ?>></div>
    <?php endif; ?>
<?php $count ++; endwhile; ?>
</div>