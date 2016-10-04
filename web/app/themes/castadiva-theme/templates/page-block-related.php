<?php if(get_sub_field('related_type') == 'category') : ?>
<?php woocommerce_output_related_products(); ?>
<?php elseif(get_sub_field('related_type') == 'upsell') : ?>
<?php woocommerce_upsell_display(); ?>
<?php endif; ?>