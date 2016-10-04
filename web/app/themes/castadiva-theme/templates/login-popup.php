<?php use Roots\Sage\Extras; ?>
<div class="modal" id="login-modal" ng-class="{visible : isLoginPopup}">
    <nav class="nav">
        <div class="container">
            <h5 class="title xs-size"><?php echo __('Accedi', 'castadiva'); ?></h5>
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