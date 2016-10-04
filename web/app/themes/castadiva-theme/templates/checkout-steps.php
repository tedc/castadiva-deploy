<?php if(is_cart()) : ?>
<div ng-show="miniCartItems.count > 0" class="cart-wrapper">
<?php endif; ?>
<div class="checkout-steps-container">
    <ul class="checkout-steps row row-md">
        <li class="checkout-step<?php if(is_cart()) : ?> active<?php endif; ?>">
            <span class="checkout-step-point">
                <span class="checkout-step-point-text">1</span>
            </span>
            <p class="checkout-step-text"><?php echo __('Il tuo carrello'); ?></p>
        </li>
        <li class="checkout-step<?php if(is_checkout() && !(is_wc_endpoint_url( 'order-received' ) || is_wc_endpoint_url( 'order-pay' ))) : ?> active<?php endif; ?>">
            <span class="checkout-step-point">
                <span class="checkout-step-point-text">2</span>
            </span>
            <p class="checkout-step-text"><?php echo __('Il tuo dati'); ?></p>
        </li>
        <li class="checkout-step<?php if(is_wc_endpoint_url( 'order-received' ) || is_wc_endpoint_url( 'order-pay' )) : ?> active<?php endif; ?>">
            <span class="checkout-step-point">
                <span class="checkout-step-point-text">3</span>
            </span>
            <p class="checkout-step-text"><?php echo __('Pagamento completato'); ?></p>
        </li>
    </ul>
</div>