<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
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
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>


<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
        <h2 class="title aligncenter"><?php _e( 'Register', 'woocommerce' ); ?></h2>         
    	<form method="post" class="register" novalidate action="<?php echo wp_login_url(); ?>?=register">
			<?php do_action( 'woocommerce_register_form_start' ); ?>
            <div class="form-container row-top row-md-top">
                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                <p class="row-btm row-md-btm">
                    <input type="text" class="input-text" name="username" id="username" placeholder="<?php echo __('Nome utente', 'castadiva'); ?>" />
                </p>
                <?php endif; ?>
                <p class="row-btm row-md-btm">
                    <input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" required placeholder="<?php echo __('Indirizzo e-mail (obbligatorio)', 'castadiva'); ?>" />
                </p>
                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                <p class="row-btm row-md-btm">
                    <input type="password" class="input-text" name="password" id="reg_password" required placeholder="<?php echo __('Password (obbligatoria)', 'castadiva'); ?>" />
                </p>
                <?php endif; ?>
                <!-- Spam Trap -->
                <?php do_action( 'woocommerce_login_form' ); ?>
                <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>
            </div>

            <p class="buttons">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <?php Extras\btn($text = __('Accedi', 'castadiva'), $link = '',  $btn = true, $name = 'login'); ?>
            </p>
            <?php do_action( 'woocommerce_register_form_end' ); ?>            
            <?php echo do_shortcode(' [apsl-login-lite login_text="'.__('Oppure registrati con Faebook', 'castadiva').'"]'); ?>
		</form>
    
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
