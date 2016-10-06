<?php use Roots\Sage\Extras;?>
<div class="modal" id="login-modal" ng-class="{visible : isFilters}">
    <nav class="nav">
        <div class="container">
            <h5 class="title xs-size"><?php echo __('Filtra la tua ricerca', 'castadiva'); ?></h5>
            <?php Extras\close('isFilters'); ?>
        </div>
        <div class="divider"></div>
    </nav>
    <div class="modal-container" ng-ps>
        <div class="scroller filters-scroller">
            <nav class="filters">
                <?php $product_cats = get_terms('product_cat', array('hierarchical' => false)); 
                    if($product_cats) : ?>
                <ul class="filters-list">
                    <li class="filters-list-title row-btm row-md-btm">
                        <h4 class="title"><?php echo __('Categorie', 'castadiva'); ?></h4>
                    </li>
                    <?php foreach($product_cats as $cat) : ?>
                    <li class="<?php echo $cat->slug; ?> filters-list-item row-btm row-s-btm">
                        <input type="checkbox" id="product_cat_field_<?php echo $cat->slug; ?>" />
                        <label for="product_cat_field_<?php echo $cat->slug; ?>" class="filters-list-label" ng-click="isCat[<?php echo $cat->term_id; ?>]=!isCat[<?php echo $cat->term_id; ?>]; filters(filterData.cat, '<?php echo $cat->slug; ?>', isCat[<?php echo $cat->term_id; ?>])">
                            <span class="filters-list-text" style="color:<?php the_field('color', 'product_cat_'.$cat->term_id); ?>"><?php echo $cat->name; ?></span>
                        </label>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <?php $product_tags = get_terms('product_tag', array('hierarchical' => false)); 
                    if($product_tags) : ?>
                <ul class="filters-list">
                    <li class="filters-list-title row-btm row-md-btm">
                        <h4 class="title"><?php echo __('Tipologia', 'castadiva'); ?></h4>
                    </li>
                    <?php foreach($product_tags as $tag) : ?>
                    <li class="<?php echo $tag->slug; ?> filters-list-item row-btm row-s-btm">
                        <input type="checkbox" id="product_tag_field_<?php echo $tag->slug; ?>" />
                        <label for="product_tag_field_<?php echo $tag->slug; ?>" ng-click="isTag[<?php echo $tag->term_id; ?>]=!isTag[<?php echo $tag->term_id; ?>];filters(filterData.tag, '<?php echo $tag->slug; ?>',isTag[<?php echo $tag->term_id; ?>])">
                            <span class="filters-list-text"><?php echo $tag->name; ?></span>
                        </label>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <ul class="filters-list">
                    <li class="filters-list-title row-btm row-md-btm">
                        <h4 class="title"><?php echo __('Altro', 'castadiva'); ?></h4>
                    </li>
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="checkbox" id="filter_in_stock" />
                        <label for="filter_in_stock" ng-click="isInStock=!isInStock;filters(filterData.check.instock, 1, isInStock)">
                            <span class="filters-list-text"><?php echo __('Attualmente non disponibili', 'castadiva'); ?></span>
                        </label>
                    </li>
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="checkbox" id="filter_offers" />
                        <label for="filter_offers" ng-click="isOnSale=!isOnSale;filters(filterData.check.onsale, 1, isOnSale)">
                            <span class="filters-list-text"><?php echo __('In offerta', 'castadiva'); ?></span>
                        </label>
                    </li>
                </ul>
            </nav>
            <p class="buttons filters-buttons">
                <span class="btn" ng-click="applyFilters()">
                    <span class="btn-text"><?php echo __('Applica<br/>filtri', 'castadiva'); ?></span>
                </span>
            </p>
        </div>
    </div>
</div>