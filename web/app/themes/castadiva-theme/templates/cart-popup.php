<?php use Roots\Sage\Extras; global $woocommerce; ?>
<div class="modal" id="login-modal" ng-class="{visible : isCartPopup}">
    <nav class="nav">
        <div class="container">
            <h5 class="title xs-size"><?php echo __('La tua spesa', 'castadiva'); ?></h5>
            <?php Extras\close('isCartPopup'); ?>
        </div>
        <div class="divider"></div>
    </nav>
    <div class="modal-container cart-modal" ng-ps>
        <div class="scroller cart-wrapper" ng-show="miniCartItems.count > 0">
            <div class="cart-table">
                <div class="cart-table-item">
                    <div class="row cart-table-item-container">
                        <div class="cart-item-img"></div>
                        <div class="cart-item-name"><strong class="upper s-size"><?php echo __('Prodotto', 'castadiva'); ?></strong></div>
                        <div class="cart-item-qnt"><strong class="upper s-size"><?php echo __('Quantità', 'castadiva'); ?></strong></div>
                        <div class="cart-item-price"><strong class="upper s-size"><?php echo __('Prezzo', 'castadiva'); ?></strong></div>
                        <div class="cart-item-subtotal"><strong class="upper s-size"><?php echo __('Subtotale', 'castadiva'); ?></strong></div>
                    </div>
                </div>
                <div ng-repeat="item in miniCartItems.items" class="cart-table-item" ng-class="{removed : isRemoved=={{item.product_id}}}">
                    <div class="row cart-table-item-container">
                        <figure class="cart-item-img" ng-bind-html="item.thumbnail">
                        </figure>
                        <div class="cart-item-name">
                            <h4 class="title">
                                <a ng-href="{{item.link}}" ng-bind-html="item.product_name"></a>
                            </h4>
                        </div>
                        <div class="cart-item-qnt">
                            <p>x <span ng-bind-html="item.quantity"></span></p>
                        </div>
                        <div class="cart-item-price">
                            <p ng-bind-html="item.price" class="price" ng-class="{discount : item.onsale}"></p>
                        </div>
                        <div class="cart-item-subtotal">
                            <p ng-bind-html="item.subtotal" class="price"></p>
                        </div>
                    </div> 
                    <a class="remove" ng-href="{{decodeUrl(item.remove_link)}}" ng-click="$event.preventDefault(); removeItem(decodeUrl(item.remove_link),item.product_id);">
                        <span class="remove-text"><?php echo __('Elimina', 'castadiva'); ?></span>
                        <span class="close">
                            <span class="btn"><i class="plus"></i></span>
                        </span>
                    </a>
                </div>
                <div class="cart-table-total">
                    <div class="row-top row-lg-top">
                        <h6 class="title m-size"><?php echo __('Totale', 'castadiva'); ?></h6>
                        <p class="price" ng-bind-html="miniCartItems.total"></p>
                    </div>
                    <p class="wc-proceed-to-checkout"><?php Extras\btn(__('Vai al<br/>carrello', 'castadiva'), wc_get_cart_url(), false, null, 'xs-size' ); ?></p>
                </div>
            </div>
        </div>
        <div class="scroller cart-empty cart-wrapper" ng-show="miniCartItems.count < 1">
            <div class="cart-table-empty aligncenter">
                <h5 class="title"><?php echo __('Il tuo carrello è vuoto.', 'castadiva'); ?></h5>
                <p class="buttons">
                    <?php Extras\btn($text = __('Vai al<br/>negozio', 'castadiva'), $link = get_permalink( woocommerce_get_page_id( 'shop' ) )); ?>
                </p>
            </div>
        </div>
    </div>
</div>