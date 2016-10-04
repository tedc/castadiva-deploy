<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>



		<?php
        $args = array();
        $qnt = 0;
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = $_product->get_price_html();
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                    $subtotal = str_replace( array('<ins>', '</ins>','&euro;</span>&nbsp;', ','), array('', '', '&euro;</span>&nbsp;<strong>', '</strong>,'), WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ) );
                    $product_array = array(
                        'product_id' => esc_attr( $product_id ),
                        'product_name' => $product_name,
                        'thumbnail' => $thumbnail, 
                        'price' => $product_price, 
                        'link' => $product_permalink, 
                        'quantity'=>$cart_item['quantity'], 
                        'subtotal' => $subtotal, 
                        'remove_link' => esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), 
                        'sku'=> esc_attr( $_product->get_sku() ),
                        'onsale' => $_product->is_on_sale()
                    );
                    $qnt += $cart_item['quantity'];
                    array_push($args, $product_array);
                    ?>
					<?php
				}
			}
        $total_price = str_replace(array('<ins>', '</ins>','&euro;</span>&nbsp;', ','), array('', '', '&euro;</span>&nbsp;<strong>', '</strong>,'), WC()->cart->get_cart_subtotal());
            $order_total = apply_filters( 'woocommerce_cart_totals_order_total_html',
                                         apply_filters( 'woocommerce_cart_total', wc_price( WC()->cart->total ) ) 
                        );
            echo json_encode(
                array(
                    'items' => $args,
                    'count' => $qnt,
                    'total' => WC()->cart->get_cart_subtotal(),
                    'order_total' => $order_total
                )
            );
		?>


