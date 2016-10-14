<?php use Roots\Sage\Extras; ?>
<?php $init = (isset($_GET['login_error'])) ? ' ng-init="isLoginPopup = true"' : ''; ?>
<div class="modal" id="login-modal" ng-class="{visible : isLoginPopup}"<?php echo $init; ?>>
    <nav class="nav">
        <div class="container">
            <a href="<?php bloginfo('url'); ?>" class="logo"><?php bloginfo('name'); ?></a>
            <?php Extras\close('isLoginPopup'); ?>
        </div>
        <div class="divider"></div>
    </nav>
    <div class="modal-container" ng-ps>
        <div class="scroller">
        <?php
            if(!is_user_logged_in()) :
                woocommerce_login_form(
                    array(
                        'message'  => __( 'Registrati per acquistare i prodotti Castadiva.', 'woocommerce' ),
                        'redirect' => wc_get_page_permalink( 'checkout' ),
                        'hidden'   => true
                    )
                ); 
            else :
                do_action( 'woocommerce_account_navigation' ); 
            endif;    
        ?>
        </div>
    </div>
</div>