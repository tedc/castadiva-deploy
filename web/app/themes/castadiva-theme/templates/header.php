<?php use Roots\Sage\Extras; 
    $ov = (is_front_page() || is_page_template('template-custom.php') || is_singular('ricette') || is_singular('itinerari') || is_post_type_archive('itinerari') || is_tax('product_cat')) ? ' overlay-nav' : '';
?>
<nav class="nav<?php echo $ov; ?>"<?php if(is_front_page() || is_page_template('template-custom.php') || is_singular('ricette') || is_singular('itinerari') || is_post_type_archive('itinerari') || is_tax('product_cat')) : ?> ng-sticky-menu<?php endif; ?>>
    <div class="container">
        <div class="brand">
            <a href="<?php bloginfo('url'); ?>" class="logo"><?php bloginfo('name'); ?></a>
            <?php Extras\lang_nav(); ?>
            <span class="toggle" ng-click="isMenuOpen = !isMenuOpen" ng-class="{active : isMenuOpen}">
                <span class="toggle-open">
                    <?php echo __('Menu', 'castadiva'); ?>
                </span>
                <span class="toggle-close">
                    <?php echo __('Chiudi', 'castadiva'); ?>
                </span>
            </span>    
        </div>
        <?php
        if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'menu', 'items_wrap' => '<ul class="%2$s" ng-class="{visible: isMenuOpen}">%3$s</ul>']);
        endif;
        ?>
        <ul class="tools-menu">
            <li class="tools-menu-item">
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php echo (is_user_logged_in()) ? __('Account','castadiva') : __('Accedi','castadiva'); ?>" ng-click="$event.preventDefault(); isLoginPopup = true;"><?php echo (is_user_logged_in()) ? __('Account','castadiva') : __('Accedi','castadiva'); ?></a>
            </li>
            <?php get_template_part('templates/cart', 'btn'); ?>
        </ul>  
    </div>
    <div class="divider" ng-class="{'cart-active' : miniCartItems.items.length > 0}"></div>
</nav>

