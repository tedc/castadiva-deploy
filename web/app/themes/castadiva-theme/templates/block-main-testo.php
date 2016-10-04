<?php $row = (get_sub_field('row') != '') ? ' '.get_sub_field('row') : ''; ?>
<div class="content<?php echo $row; ?>" ng-sm to="{y : '-30%'}" duration="100%">
    <?php the_sub_field('contenuto'); ?>
</div>