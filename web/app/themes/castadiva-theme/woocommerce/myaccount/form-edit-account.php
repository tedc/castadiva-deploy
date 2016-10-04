<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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
 * @version 2.6.0
 */
use Roots\Sage\Extras;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account form-container" action="" method="post">

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row row-btm form-row-first">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" required placeholder="<?php _e( 'Nome (campo obbligatorio)', 'castadiva' ); ?>" />
	</p>
	<p class="woocommerce-FormRow woocommerce-FormRow--last form-row row-btm form-row-last">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" required placeholder="<?php _e( 'Cognome (campo obbligatorio)', 'castadiva' ); ?>" title="<?php _e( 'Cognome (campo obbligatorio)', 'castadiva' ); ?>" />
	</p>

	<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" required placeholder="<?php _e( 'Indirizzo email (campo obbligatorio)', 'castadiva' ); ?>" title="<?php _e( 'Indirizzo email (campo obbligatorio)', 'castadiva' ); ?>" />
	</p>

	<fieldset>
		<legend><?php _e( 'Password Change', 'woocommerce' ); ?></legend>

		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row row-btm form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" placeholder="<?php _e( 'Current Password (leave blank to leave unchanged)', 'woocommerce' ); ?>" title="<?php _e( 'Current Password (leave blank to leave unchanged)', 'woocommerce' ); ?>" />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row row-btm form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" placeholder="<?php _e( 'New Password (leave blank to leave unchanged)', 'woocommerce' ); ?>" title="<?php _e( 'New Password (leave blank to leave unchanged)', 'woocommerce' ); ?>" />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" placeholder="<?php _e( 'Confirm New Password', 'woocommerce' ); ?>" title="<?php _e( 'Confirm New Password', 'woocommerce' ); ?>" />
		</p>
	</fieldset>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p class="form-buttons">
		<?php wp_nonce_field( 'save_account_details' ); ?>
		<?php Extras\btn(__('Salva', 'castadiva'), null, true, 'save_account_details'); ?>
        <input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
