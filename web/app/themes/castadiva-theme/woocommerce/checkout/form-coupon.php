<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
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
 * @version 2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if(! $checkout->enable_guest_checkout && ! is_user_logged_in()) {
    return;
}

if ( ! wc_coupons_enabled() ) {
	return;
}

echo '<div class="content">';

if ( empty( WC()->cart->applied_coupons )) {
	$info_message = apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ) . ' <a href="#"  class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>' );
	wc_print_notice( $info_message, 'notice' );
}
?>
    <form class="checkout_coupon" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" method="post" ng-class="{'visible' : isCouponActive}">
        <div class="coupon form-container row-top row-md-top">
        <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
        <button type="submit" class="btn-plain" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Applica', 'castadiva' ); ?></button>
        </div>
	</form>
</div>