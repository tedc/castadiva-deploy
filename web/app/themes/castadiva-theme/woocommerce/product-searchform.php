<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
use Roots\Sage\Extras;
?>
<form class="row row-lg" role="search" action="<?php echo esc_url(home_url( '/' )); ?>" method="get">
    <div class="search-filters">
        <div class="container">
            <div class="select" ng-click="isFilters=!isFilters">
                <i class="select-arrow"></i>
                <span class="select-text"><?php echo __('Filtra', 'castadiva'); ?></span>
            </div>
            <div class="select" ng-click="isOrderFilters=!isOrderFilters">
                <span class="select-text"><?php echo __('Ordina per', 'castadiva'); ?></span>
                <i class="select-arrow select-arrow-inv"></i>     
            </div>
        </div>
        <div class="divider-inv"></div>
    </div>
    <div class="form-container">
        <input type="search" name="s" placeholder="<?php echo __('Ti interessa un prodotto particolare?', 'castadiva'); ?>" value="<?php echo get_search_query(); ?>" />
        <input type="hidden" name="post_type" value="product" />
    </div>
    <p class="buttons">
        <?php Extras\btn($text = 'Cerca', $link = null, $btn = true); ?>
    </p>
</form>