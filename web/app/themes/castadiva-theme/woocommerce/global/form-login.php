<?php
/**
 * Auth form login
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/auth/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Auth
 * @version 2.4.0
 */



if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use Roots\Sage\Extras;
global $wp;
$current_url = home_url(add_query_arg(array(),$wp->request));
?>

<form method="post" class="login row row-lg" action="<?php echo $current_url; ?>" name="loginForm">
    <div class="form-container">
        <?php if ( $message ) echo '<div class="row-btm row-md-btm aligncenter">' .wpautop( wptexturize( $message ) ) . '</div>'; ?>
        <?php if(isset($_GET['login_error'])) : ?>
        <p class="row-btm error."><?php echo __('Si è verificato un errore, assicurati di aver compilato tutti i campi correttamente', 'castadiva'); ?>
        <?php endif; ?></p>
        <p class="row-btm row-md-btm">
            <input ng-model="loginUser" required type="text" class="input-text" name="username" id="username" placeholder="<?php echo __('Nome utente', 'castadiva'); ?>" />
        </p>
        <p class="row-btm row-md-btm">
            <input ng-model="loginPassword" required class="input-text" type="password" name="password" id="password" placeholder="<?php echo __('Password', 'castadiva'); ?>"  />
        </p>	
        <?php do_action( 'woocommerce_login_form' ); ?>
        <p class="row-btm row-md-btm">
            <?php wp_nonce_field( 'woocommerce-login' ); ?>
            <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
            <input name="rememberme" type="checkbox" id="rememberme" value="forever" /><label for="rememberme" class="inline"><?php _e( 'Remember me', 'woocommerce' ); ?></label>
        </p>
        <p class="lost_password">
            <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
            <?php if(!is_checkout()) : ?>
            <br />
            <?php echo __('Non hai ancora un utente?', 'castadiva'); ?> <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Registrati','castadiva'); ?>"><?php _e('Registrati','castadiva'); ?></a>.
            <?php endif; ?>
        </p>
    </div>
    <p class="buttons">
        <button class="btn" name="login" value="<?php echo __('Accedi', 'castadiva'); ?>" type="submit" ng-disabled="loginForm.$invalid">
                    <span class="btn-text"><?php echo __('Accedi', 'castadiva'); ?></span>
                </button>
    </p>
    <?php echo do_shortcode(' [apsl-login-lite login_text="'.__('Oppure collegati con Facebook', 'castadiva').'"]'); ?>
</form>
