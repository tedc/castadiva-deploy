<?php 
// IF GALLERY
if(get_field('tipo_di_slider') == 'Gallery') : ?>

<?php get_template_part('templates/block', 'header-gallery'); ?>
<?php //ELSE NOT GALLERY
else : ?>

<?php get_template_part('templates/block', 'header-slider'); ?>

<?php
// END MAIN IF
endif; ?>