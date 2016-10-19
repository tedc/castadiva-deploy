<?php use Roots\Sage\Extras; $product_count = count(get_posts(array('post_type'=>'product','posts_per_page'=>-1)));
?>
<div class="modal" id="orderby-modal" ng-class="{visible : isOrderFilters}">
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
                <ul class="filters-list order-list">
                    <li class="filters-list-item row-btm row-s-btm">
                        <h3 class="title order-title"><?php echo __('Ordina per', 'castadiva'); ?></h3>
                        <div class="select-container">
                            <div class="select row options">
                                <span class="select-text" ng-bind-html="(filterData.orderby == 'price') ? '<?php echo __('Prezzo', 'castadiva'); ?>' : (filterData.orderby == 'date') ? '<?php echo __('Data', 'castadiva'); ?>' : '<?php echo __('Nome', 'castadiva'); ?>'"></span>
                                <select ng-model="filterData.orderby" ng-options="opt.val as opt.label for opt in [{val : 'date', label : '<?php echo __('Data', 'castadiva'); ?>'},{val : 'price', label : '<?php echo __('Prezzo', 'castadiva'); ?>'},{val : 'name', label : '<?php echo __('Nome', 'castadiva'); ?>'}]">
                                    <option disabled value=""><?php echo __('Scegli un ordine'); ?></option>
                                </select>
                                <i class="select-arrow selecto-arrow-inv"></i>
                            </div>
                        </div>
                    </li>
                    <li class="filters-list-item row-btm row-s-btm">
                        <h3 class="title order-title"><?php echo __('Ordine', 'castadiva'); ?></h3>
                        <div class="select-container">
                            <div class="select row options order-options" ng-class="{current : filterData.orderby=='date'}">
                                <span class="select-text" ng-bind-html="(filterData.order='desc') ? '<?php echo __('Dal più recente al meno recente', 'castadiva'); ?>' : '<?php echo __('Dal meno recente al più recente', 'castadiva'); ?>'"></span>
                                <select ng-model="filterData.order" ng-options="opt.val as opt.label for opt in [{val : 'desc', label : '<?php echo __('Dal più recente al meno recente', 'castadiva'); ?>'},{val : 'asc', label : '<?php echo __('Dal meno recente al più recente', 'castadiva'); ?>'}]">
                                    <option disabled value=""><?php echo __('Scegli un ordine'); ?></option>
                                </select>
                                <i class="select-arrow selecto-arrow-inv"></i>
                            </div>
                            <div class="select row options order-options" ng-class="{current : filterData.orderby=='price'}">
                                <span class="select-text" ng-bind-html="(filterData.order='desc') ? '<?php echo __('Dal più alto al più basso', 'castadiva'); ?>' : '<?php echo __('Dal più basso al più alto', 'castadiva'); ?>'"></span>
                                <select ng-model="filterData.order" ng-options="opt.val as opt.label for opt in [{val : 'desc', label : '<?php echo __('Dal pià alto al più basso', 'castadiva'); ?>'},{val : 'asc', label : '<?php echo __('Dal più basso al più alto', 'castadiva'); ?>'}]">
                                    <option disabled value=""><?php echo __('Scegli un ordine'); ?></option>
                                </select>
                                <i class="select-arrow selecto-arrow-inv"></i>
                            </div>
                            <div class="select row options order-options" ng-class="{current : filterData.orderby=='name'}">
                                <span class="select-text" ng-bind-html="(filterData.order='desc') ? '<?php echo __('Z-A', 'castadiva'); ?>' : '<?php echo __('A-Z', 'castadiva'); ?>'"></span>
                                <select ng-model="filterData.order" ng-options="opt.val as opt.label for opt in [{val : 'desc', label : '<?php echo __('Z-A', 'castadiva'); ?>'},{val : 'asc', label : '<?php echo __('A-Z', 'castadiva'); ?>'}]">
                                    <option disabled value=""><?php echo __('Scegli un ordine'); ?></option>
                                </select>
                                <i class="select-arrow selecto-arrow-inv"></i>
                            </div>
                        </div>
                    </li>
                </ul>   
            </nav>
            <p class="buttons filters-buttons">
                <span class="btn" ng-click="$event.stopPropagation(); applyFilters('<?php echo ICL_LANGUAGE_CODE; ?>')">
                    <span class="btn-text" ng-click="$event.stopPropagation(); applyFilters('<?php echo ICL_LANGUAGE_CODE; ?>')" ng-class="{hidden : isApplying}"><?php echo __('Ordina', 'castadiva'); ?></span>
                    <span class="btn-loading" ng-class="{visible : isApplying}"></span>
                </span>
            </p>
        </div>
    </div>
</div>