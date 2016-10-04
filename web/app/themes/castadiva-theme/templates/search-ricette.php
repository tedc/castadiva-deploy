<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
    use Roots\Sage\Extras;
    if(!is_post_type_archive('ricette') && !is_tax('recipe_cat')) {
        return; 
    } 
?>
<form class="row row-md" role="search" action="<?php echo esc_url(home_url( '/' )); ?>" method="get">
    <div class="form-container">
        <input type="search" name="s" placeholder="<?php echo __('Ti interessa una ricetta particolare?', 'castadiva'); ?>" value="<?php echo get_search_query(); ?>" />
        <input type="hidden" name="post_type" value="ricette" />
    </div>
    <p class="recipe-buttons">
        <?php Extras\btn($text = 'Cerca', $link = null, $btn = true, null, 'recipe-btn'); ?>
    </p>
</form>