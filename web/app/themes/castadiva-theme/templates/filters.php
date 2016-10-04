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
                        <label for="product_cat_field_<?php echo $cat->slug; ?>" class="filters-list-label">
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
                        <label for="product_tag_field_<?php echo $tag->slug; ?>">
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
                        <label for="filter_in_stock">
                            <span class="filters-list-text"><?php echo __('Prodotti disponibili', 'castadiva'); ?></span>
                        </label>
                    </li>
                    <li class="filters-list-item row-btm row-s-btm">
                        <input type="checkbox" id="filter_offers" />
                        <label for="filter_offers">
                            <span class="filters-list-text"><?php echo __('Prodotti in offerta', 'castadiva'); ?></span>
                        </label>
                    </li>
                </ul>
            </nav>
            <p class="buttons filters-buttons">
                <?php Extras\btn(__('Applica<br/>filtri', 'castadiva'), null, true); ?>
            </p>
        </div>
    </div>
</div>