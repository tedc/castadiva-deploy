<?php use Roots\Sage\Extras; ?>
<footer class="footer">
    <div class="container">
        <?php dynamic_sidebar('sidebar-footer'); ?>
    </div>
    <?php
      if (has_nav_menu('footer_navigation')) :
        wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'menu']);
      endif;
      ?>
    <?php 
        $social = get_option('social_settings');
        foreach($social as $key=>$value) {
            echo '<a href="'.$value.'" class="social-icon" rel="nofollow"><i class="fa fa-'.$key.'"></i></a>';
        } ?>
    <p class="row-top row-btm row-md-btm credits">
        <em>Credits by</em><br />
        <a href="http://www.bspkn.it/" target="_blank" title="BSPKNStudio" rel="nofollow">
            BSPKNStudio
        </a>
    </p>
    <div class="pattern-main"></div>
</footer>
<?php get_template_part('templates/login', 'popup'); ?>
<?php get_template_part('templates/cart', 'popup'); ?>