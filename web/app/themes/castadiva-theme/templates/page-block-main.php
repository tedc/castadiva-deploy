<?php if(get_sub_field('colonne') < 2) : ?>
<?php while(the_flexible_field('contenuti')) :  ?>
<?php get_template_part('templates/block', 'main-'.get_row_layout()); ?>
<?php endwhile; ?>
<?php else : ?>
<ul class="grid-2 shapes-cols">
    <?php while(the_flexible_field('contenuti') || the_flexible_field('contenuti_2')) :  ?>
	<li class="col-1">
        <?php get_template_part('templates/block', 'main-'.get_row_layout()); ?>
    <?php endwhile; ?>
    </li>
</ul>
<?php endif; ?>