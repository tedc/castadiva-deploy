<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
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
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$ngModel = esc_attr( $ng_model ) != '' ? ' ng-model="'.esc_attr( $ng_model ).'" ng-init="' .esc_attr( $ng_model ). '='.esc_attr( $input_value ). '"': '';
?>
<div class="quantity">
<span class="minus" ng-click="<?php echo esc_attr( $ng_model ); ?> = <?php echo esc_attr( $ng_model ); ?> > <?php echo esc_attr( $min_value ); ?> ? <?php echo esc_attr( $ng_model ); ?> - 1 : <?php echo esc_attr( $min_value ); ?>">-</span>
<input type="number" step="<?php echo esc_attr( $step ); ?>" min="<?php echo esc_attr( $min_value ); ?>" max="<?php echo esc_attr( $max_value ); ?>" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-text qty text" size="4" pattern="<?php echo esc_attr( $pattern ); ?>" inputmode="<?php echo esc_attr( $inputmode ); ?>"<?php echo $ngModel; ?> />
<span ng-click="<?php echo esc_attr( $ng_model ); ?> = <?php if(esc_attr( $max_value ) != '') : ?><?php echo esc_attr( $ng_model ); ?> < <?php echo esc_attr( $max_value ); ?> && <?php endif; ?><?php echo esc_attr( $ng_model ); ?> + 1">+</span>
</div>
