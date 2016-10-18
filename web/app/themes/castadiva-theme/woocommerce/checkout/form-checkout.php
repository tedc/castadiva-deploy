<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


do_action( 'woocommerce_before_checkout_form', $checkout );

wc_print_notices();

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', '<div class="aligncenter row-btm row-lg-btm">'.__( 'You must be logged in to checkout.', 'woocommerce' ) .'</div>' );
	return;
}


?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" novalidate>

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<div class="checkout-form">
        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<?php do_action( 'woocommerce_checkout_billing' ); ?>
        
        <?php do_action( 'woocommerce_checkout_shipping' ); ?>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
        </div>

	<?php endif; ?>

	
	
	<div id="order_review" class="woocommerce-checkout-review-order row row-md">
		<h3 class="title aligncenter l-size" id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>
        <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>    
        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</div>


</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
