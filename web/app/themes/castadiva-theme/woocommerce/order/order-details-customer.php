<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<header class="row row-md aligncenter"><h2 class="title l-size"><?php _e( 'Customer Details', 'woocommerce' ); ?></h2></header>

<section class="order-customer-table row-btm row-lg-btm">
	<?php if ( $order->customer_note ) : ?>
		<div class="order-customer-row">
			<p><?php _e( 'Note:', 'woocommerce' ); ?></p>
			<p><?php echo wptexturize( $order->customer_note ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( $order->billing_email ) : ?>
		<div class="order-customer-row">
			<p><?php _e( 'Email:', 'woocommerce' ); ?></p>
			<p><?php echo esc_html( $order->billing_email ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( $order->billing_phone ) : ?>
		<div class="order-customer-row">
			<p><?php _e( 'Telephone:', 'woocommerce' ); ?></p>
			<p><?php echo esc_html( $order->billing_phone ); ?></p>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

<div class="grid-2 wrap order-customer-addresses">
	<div class="col-1">

<?php endif; ?>

<header>
	<h3 class="title"><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>
</header>
<address>
	<?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
</address>

<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

	</div><!-- /.col-1 -->
	<div class="col-1">
		<header>
			<h3 class="title"><?php _e( 'Shipping Address', 'woocommerce' ); ?></h3>
		</header>
		<address>
			<?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
		</address>
	</div><!-- /.col-2 -->
</div><!-- /.col2-set -->
</section>


<?php endif; ?>
