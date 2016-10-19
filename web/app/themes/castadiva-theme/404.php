<?php 
use Roots\Sage\Extras;
get_template_part('templates/page', 'header'); ?>

<div class="alert alert-warning content aligncenter row-lg-top">
  <p><?php echo __('Spiacenti, la pagina che cercavi non esiste.', 'castadiva'); ?></p>
</div>
<p class="buttons">
  <?php Extras\btn(__('Vai allo<br/>shop', 'castadiva'), get_permalink( woocommerce_get_page_id( 'shop' ))); ?>
</p>

