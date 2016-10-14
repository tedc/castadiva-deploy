<?php $shape_id = null; ?>
<?php if(get_sub_field('colonne') < 2) : ?>
<?php $count_field = 0; while(the_flexible_field('contenuti')) :  ?>
    <?php if(get_row_layout() == 'forme') :
            $shape_id = 'shapes_'.$count_field;
        ?>
        <?php include(locate_template('templates/block-main-'.get_row_layout().'.php', false, false ) ); ?>
    <?php else : ?>
       <?php include(locate_template('templates/block-main-'.get_row_layout().'.php', false, false ) ); ?>
    <?php endif; ?>
<?php $count_field++; endwhile; ?>
<?php else : ?>
<ul class="grid-2 shapes-cols">
    <?php while(the_flexible_field('contenuti') || the_flexible_field('contenuti_2')) :  ?>
    <li class="col-1">
    <?php include(locate_template('templates/block-main-'.get_row_layout().'.php', false, false ) ); ?>
    </li>
    <?php endwhile; ?>
</ul>
<?php endif; ?>