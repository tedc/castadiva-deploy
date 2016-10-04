<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.0.0
 */
use Roots\Sage\Extras;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>



<?php do_action( 'woocommerce_cart_is_empty' ); ?>

<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
<div class="row-md row aligncenter">
    <p class="upper">
	<?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?>
    </p>
	<p class="buttons">
		<?php Extras\btn(__('Torna al<br/>negozio', 'castadiva'), esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ) ); ?>
	</p>
</div>
<?php endif; ?>
