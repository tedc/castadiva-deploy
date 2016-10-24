<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

use Roots\Sage\Extras;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>



<form id="cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>
    
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
    <?php do_action( 'woocommerce_before_cart_contents' ); ?>
    <?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
    <div class="cart-table-item"  ng-class="{removed : isRemoved==<?php echo $_product->id; ?>}">
        <div class="row cart-table-item-container">
            <figure class="cart-item-img">
                <?php
                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                    if ( ! $product_permalink ) {
                        echo $thumbnail;
                    } else {
                        printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                    }
                ?>
            </figure>
            <div class="cart-item-name">
                <?php
                                if ( ! $product_permalink ) {
                                    echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                                } else {
                                    echo '<h4 class="title">'.apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key ).'</h4>';
                                }

                            ?>
            </div>
            <div class="cart-item-qnt">
                    <?php 
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0',
                                    'ng_model'    => 'quantity['. $_product->id . ']',
					               'ng_change' => 'updateCart()'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
				
            </div>
            <div class="cart-item-price">
                <p class="price"><?php
							echo $_product->get_price_html();
						?></p>
            </div>
            <div class="cart-item-subtotal">
                <p class="price"><?php
							echo str_replace( array('<ins>', '</ins>','&euro;</span>&nbsp;', ','), array('', '', '&euro;</span>&nbsp;<strong>', '</strong>,'), WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ) );
                    ?></p>
            </div>
        </div>
        <a class="remove" href="<?php echo esc_url( WC()->cart->get_remove_url( $cart_item_key ) ); ?>" ng-click="$event.preventDefault(); removeItem(decodeUrl('<?php echo esc_url( WC()->cart->get_remove_url( $cart_item_key ) ); ?>'), <?php echo $_product->id; ?>)">
                    <span class="remove-text"><?php echo __('Elimina', 'castadiva'); ?></span>
                    <span class="close">
                        <span class="btn"><i class="plus"></i></span>
                    </span>
                </a>
    </div>
    <?php 
                }
            }
    
		do_action( 'woocommerce_cart_contents' );
    ?>
        
        <div class="cart-buttons-row">
            <?php if ( wc_coupons_enabled() ) { ?>
                <div class="coupon row row-md">
                    <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /><button class="btn-plain" name="apply_coupon" value="<?php echo __('Applica', 'castadiva'); ?>"><?php echo __('Applica', 'castadiva'); ?></button>
                </div>
                <?php do_action( 'woocommerce_cart_coupon' ); ?>
            <?php } ?>
            <nav class="cart-buttons">
                <button class="btn xs-size" name="update_cart" type="submit" value="<?php echo  __( 'Aggiorna', 'castadiva' ); ?>">
                    <span class="btn-text"><?php echo  __( 'Aggiorna', 'castadiva' ); ?></span>
                </button>
                <a class="btn xs-size" href="<?php echo esc_url( wc_get_checkout_url() ) ;?>">
                    <span class="btn-text"><?php echo  __( 'Concludi<br/>l\'ordine', 'castadiva' ); ?></span>
                </a>
            </nav>
        </div>
        <?php do_action( 'woocommerce_cart_actions' ); ?>
		<?php wp_nonce_field( 'woocommerce-cart' ); ?>
</div>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals row row-md">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>
<div class="row-btm row-lg-btm">
    <p class="wc-proceed-to-checkout">
        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </p>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
