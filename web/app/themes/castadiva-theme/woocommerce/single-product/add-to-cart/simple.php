<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

?>

<?php
	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data' ng-submit="addToCart(cartData)" name="productCart">
	 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
        <?php
	 		if ( ! $product->is_sold_individually() ) {
	 			woocommerce_quantity_input( array(
	 				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
	 				'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ),
                    'ng_model' => 'cartData.quantity',
					'ng_change' => ''
	 			) );
	 		}
	 	?>
        
	 	<input type="hidden" name="add-to-cart" ng-model="cartData.product_id" ng-init="cartData.product_id = '<?php echo esc_attr( $product->id ); ?>'" />

	 	<p class="buttons">  
	 	<button class="single_add_to_cart_button btn alt" ng-disabled="productCart.quantity.$invalid" ng-class="{added : isAdded}"><span class="btn-text" ng-class="{hidden : isAdding}" ng-bind-html="(isAdded) ? '<?php echo __('Aggiorna il<br/>carrello', 'castadiva'); ?>' : '<?php echo __('Aggiungi al<br/>carrello', 'castadiva'); ?>' "><?php echo __('Aggiungi al<br/>carrello', 'castadiva'); ?></span>
	 	    <span class="btn-loading" ng-class="{visible : isAdding}"></span>
	 	</button>
	 	<a class="btn btn-go-to-shop" href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ) ;?>">
	 		<span class="btn-text"><?php echo __('Continua<br />la spesa', 'castadiva'); ?></span>
	 	</a>
	 	</p>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
