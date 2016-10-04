<?php $row = 0; while(have_rows('builder')) : the_row();  ?>
    <?php if(!is_page_template('template-custom.php') && !is_front_page()) : ?>
    <?php $classes = (get_sub_field('row') != '') ? ' class="'.get_sub_field('row').'"' : ''; ?>
    <section<?php echo $classes; ?>>
        <?php get_template_part('templates/page', 'block-'.get_row_layout()); ?>
    </section>
    <?php else : ?>
    <?php if(get_row_layout() == 'main') : 
        $classes = (get_sub_field('row') != '') ? 'class="shapes-container '.get_sub_field('row').'"  ng-sm to="{opacity: 1}" from="{opacity : 0}" trigger-hook="1" duration="50%" offset="100"' : 'class="shapes-container"  ng-sm to="{opacity: 1}" from="{opacity : 0}" trigger-hook="1" duration="50%" offset="50"';
    ?>
    <section <?php echo $classes; ?>>
    <?php get_template_part('templates/page', 'block-'.get_row_layout()); ?>
    </section>
    <?php else : ?>
    <?php $attrs = (get_sub_field('row') != '') ? 'class="'.get_sub_field('row').'" ng-sm to="{opacity: 1}" from="{opacity : 0}" trigger-hook="1" duration="50%" offset="100"' : 'ng-sm to="{opacity: 1}" from="{opacity : 0}" trigger-hook="1" duration="50%" offset="50"'; ?>
    <section <?php echo $attrs; ?>>
    <?php get_template_part('templates/page', 'block-'.get_row_layout()); ?>
    </section>
    <?php endif; ?>
    <?php endif; ?>
<?php $row++; endwhile; ?>