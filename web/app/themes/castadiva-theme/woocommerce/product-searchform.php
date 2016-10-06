<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
use Roots\Sage\Extras;
?>
<form class="row row-lg" role="search" action="<?php echo esc_url(home_url( '/' )); ?>" method="get">
    <?php if(!is_tax()):?>
    <div class="search-filters">
        <div class="container" ng-search-filters>
            <div class="select" ng-click="isFilters=!isFilters">
                <i class="select-arrow"></i>
                <span class="select-text">
                    <?php echo __('Filtra', 'castadiva'); ?><span class="filters-active-text" ng-bind-html="filtersText('<?php echo __('Filtri attivi', 'castadiva'); ?>')" ng-show="countFilters > 0"></span>
                </span>
            </div>
            <div class="select" ng-click="isOrderFilters=!isOrderFilters">                
                <span class="select-text"><?php echo __('Ordina per', 'castadiva'); ?>: <strong ng-bind-html="(filterData.orderby == 'price') ? '<?php echo __('Prezzo', 'castadiva'); ?>' : (filterData.orderby == 'date') ? '<?php echo __('Data', 'castadiva'); ?>' : '<?php echo __('Nome', 'castadiva'); ?>'"></strong>
                </span>
                <i class="select-arrow select-arrow-inv"></i>     
            </div>
        </div>
        <div class="divider-inv"></div>
    </div>
    <?php endif; ?>
    <div class="form-container">
        <input type="search" name="s" placeholder="<?php echo __('Ti interessa un prodotto particolare?', 'castadiva'); ?>" value="<?php echo get_search_query(); ?>" />
        <input type="hidden" name="post_type" value="product" />
    </div>
    <p class="buttons">
        <?php Extras\btn($text = 'Cerca', $link = null, $btn = true); ?>
    </p>
</form>