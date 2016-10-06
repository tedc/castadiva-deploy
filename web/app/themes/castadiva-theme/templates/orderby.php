<?php use Roots\Sage\Extras; $product_count = count(get_posts(array('post_type'=>'product','posts_per_page'=>-1)));
?>
<div class="modal" id="login-modal" ng-class="{visible : isOrderFilters}">
    <nav class="nav">
        <div class="container">
            <h5 class="title xs-size"><?php echo __('Ordina la tua ricerca', 'castadiva'); ?></h5>
            <?php Extras\close('isOrderFilters'); ?>
        </div>
        <div class="divider"></div>
    </nav>
    <div class="modal-container" ng-ps>
        <div class="scroller filters-scroller">
            <nav class="filters">
                <ul class="filters-list">
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="radio" id="filter_order_by_price" name="filter_order_by" />
                        <label for="filter_order_by_price" ng-click="filterData.orderby='price'">
                            <span class="filters-list-text"><?php echo __('Per prezzo', 'castadiva'); ?></span>
                        </label>
                    </li>
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="radio" id="filter_order_by_name" name="filter_order_by" />
                        <label for="filter_order_by_name" ng-click="filterData.orderby='name'">
                            <span class="filters-list-text"><?php echo __('Per nome', 'castadiva'); ?></span>
                        </label>
                    </li>
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="radio" id="filter_order_by_date" name="filter_order_by" />
                        <label for="filter_order_by_date" ng-click="filterData.orderby='date'">
                            <span class="filters-list-text"><?php echo __('Per data', 'castadiva'); ?></span>
                        </label>
                    </li>
                </ul>   
                <ul class="filters-list order-list" ng-class="{current : filterData.orderby=='price'}">
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="radio" id="filter_price_desc" name="order_by_price" checked />
                        <label for="filter_price_desc" ng-click="filterData.order='desc'">
                            <span class="filters-list-text"><?php echo __('Dal più alto al più basso', 'castadiva'); ?></span>
                        </label>
                    </li>
                    <li class="filters-list-item row-btm row-s-btm" ng-click="filterData.order='asc'">
                        <input type="radio" id="filter_price_asc" name="order_by_price" />
                        <label for="filter_price_asc">
                            <span class="filters-list-text"><?php echo __('Dal più basso al più alto', 'castadiva'); ?></span>
                        </label>
                    </li>
                </ul>
                <ul class="filters-list order-list" ng-class="{current : filterData.orderby=='name'}">
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="radio" id="filter_name_desc" name="order_by_name" checked />
                        <label for="filter_name_desc" ng-click="filterData.order='desc'">
                            <span class="filters-list-text"><?php echo __('Z-A', 'castadiva'); ?></span>
                        </label>
                    </li>
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="radio" id="filter_name_asc" name="order_by_name" />
                        <label for="filter_name_asc" ng-click="filterData.order='asc'">
                            <span class="filters-list-text"><?php echo __('A-Z', 'castadiva'); ?></span>
                        </label>
                    </li>     
                </ul>
                <ul class="filters-list order-list" ng-class="{current : filterData.orderby=='date'}">
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="radio" id="filter_date_desc" name="order_by_date" checked />
                        <label for="filter_date_desc" ng-click="filterData.order='desc'">
                            <span class="filters-list-text"><?php echo __('Dal più recente', 'castadiva'); ?></span>
                        </label>
                    </li>
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="radio" id="filter_date_asc" name="order_by_date" />
                        <label for="filter_date_asc" ng-click="filterData.order='asc'">
                            <span class="filters-list-text"><?php echo __('Dal meno recente', 'castadiva'); ?></span>
                        </label>
                    </li>
                </ul>
            </nav>
            <p class="buttons filters-buttons">
                <span class="btn" ng-click="applyFilters(<?php echo $product_count; ?>)">
                    <span class="btn-text"><?php echo __('Ordina', 'castadiva'); ?></span>
                </span>
            </p>
        </div>
    </div>
</div>