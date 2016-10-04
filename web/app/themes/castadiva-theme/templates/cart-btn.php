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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $woocommerce;
$cart_url = $woocommerce->cart->get_cart_url();

?>

<li class="tools-menu-item cart-menu-item"><a ng-click="$event.preventDefault(); isCartPopup= true;" href="<?php echo $cart_url; ?>">
    <span class="cart-menu-total"><span class="cart-menu-total-text" ng-bind-html="miniCartItems.count" ng-class="{adding : isAdding}"></span></span><?php echo __('Carrello', 'castadiva'); ?></a>
</li>