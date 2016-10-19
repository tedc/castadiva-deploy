<?php
/**
 * Pay for order form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-pay.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see      https://docs.woocommerce.com/document/template-structure/
 * @author   WooThemes
 * @package  WooCommerce/Templates
 * @version  2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="container">
<form id="order_review" class="order-pay" method="post" novalidate  action="<?php echo esc_url( wc_get_checkout_url() ); ?>">

	<p class="order-pay-row">
		<span class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></span>
		<span class="product-quantity"><?php _e( 'Qty', 'woocommerce' ); ?></span>
		<span class="product-total"><?php _e( 'Totals', 'woocommerce' ); ?></span>
	</p>
	<?php if ( sizeof( $order->get_items() ) > 0 ) : ?>
		<?php foreach ( $order->get_items() as $item_id => $item ) : ?>
			<?php
				if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
					continue;
				}
			?>
			<p class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order-pay-row', $item, $order ) ); ?>">
				<span class="product-name">
					<?php
						echo apply_filters( 'woocommerce_order_item_name', esc_html( $item['name'] ), $item, false );

						do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order );
						$order->display_item_meta( $item );
						do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order );
					?>
				</span>
				<span class="product-quantity"><?php echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', esc_html( $item['qty'] ) ) . '</strong>', $item ); ?></span>
				<span class="product-subtotal"><?php echo str_replace(array('<ins>', '</ins>','&euro;</span>&nbsp;', ',', ':'), array('', '', '&euro;</span>&nbsp;<strong>', '</strong>,', ''),$order->get_formatted_line_subtotal( $item )); ?></span>
			</p>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if ( $totals = $order->get_order_item_totals() ) : ?>
		<?php foreach ( $totals as $total ) : ?>
			<p class="order-details-row">
				<span scope="row" colspan="2"><?php echo $total['label']; ?></span>
				<span class="product-total"><?php echo $total['value']; ?></span>
			</p>
		<?php endforeach; ?>
	<?php endif; ?>
		
	<div id="payment">
		<?php if ( $order->needs_payment() ) : ?>
			<ul class="wc_payment_methods payment_methods methods">
				<?php
					if ( ! empty( $available_gateways ) ) {
						foreach ( $available_gateways as $gateway ) {
							wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
						}
					} else {
						echo '<li>' . apply_filters( 'woocommerce_no_available_payment_methods_message', __( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) ) . '</li>';
					}
				?>
			</ul>
		<?php endif; ?>
		<div class="form-row">
			<input type="hidden" name="woocommerce_pay" value="1" />

			<?php wc_get_template( 'checkout/terms.php' ); ?>

			<?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

			<?php echo apply_filters( 'woocommerce_pay_order_button_html', '<p class="order-pay-buttons"><button type="submit" class="btn" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '"><span class="btn-text">' . __('Paga<br/>l\'ordine') . '</span></button></p>' ); ?>

			<?php do_action( 'woocommerce_pay_order_after_submit' ); ?>

			<?php wp_nonce_field( 'woocommerce-pay' ); ?>
		</div>
	</div>
</form>
</div>