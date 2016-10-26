<?php

//require_once 'vendor/autoload.php';
//use Automattic\WooCommerce\Client;
//use Automattic\WooCommerce\HttpClient\HttpClientException;
use Roots\Sage\Assets;

add_filter('woocommerce_show_page_title', '__return_false');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function my_mini_cart() {
    ob_start();

    woocommerce_mini_cart();

    $mini_cart = ob_get_clean();
    return array(json_decode($mini_cart));
}

add_filter('woocommerce_add_to_cart_fragments', __NAMESPACE__ . '\\my_mini_cart');

function my_added_msg() { ?>
<script>
var go_to_cart = '<?php echo __('Continua<br />la spesa', 'castadiva'); ?>';
<?php if(is_user_logged_in()) : ?>
var current_user_country = '<?php echo get_user_meta(get_current_user_id(), 'billing_country', true); ?>';
var sercurity_update = '<?php echo wp_create_nonce( 'update-order-review' ); ?>';
var user_ajax_url = '<?php echo esc_url( wc_get_checkout_url() ); ?>?wc-ajax=';
<?php endif; ?>
</script>
<?php }

add_action('wp_footer', __NAMESPACE__.'\\my_added_msg');

function colors() {
?>
<style type="text/css">
    <?php $args = array(); $product_cats = get_terms('product_cat', $args); 
                   foreach($product_cats as $cat) : ?>
    <?php if(get_field('color', 'product_cat_'.$cat->term_id) != '') : ?>
    .product-show-more.product_cat-<?php echo $cat->slug; ?>:hover .price, .product-show-more.product_cat-<?php echo $cat->slug; ?> .product-more .btn-text {
        color: <?php the_field('color', 'product_cat_'.$cat->term_id); ?>;
    }
    .product-cat-<?php echo $cat->slug; ?> {
        color: <?php the_field('color', 'product_cat_'.$cat->term_id); ?>;
    }
    <?php endif; ?>
    <?php if(get_field('pattern', 'product_cat_'.$cat->term_id) != '') : ?>
    .product-show-more.product_cat-<?php echo $cat->slug; ?> .product-more .pattern:before, .product_cat-<?php echo $cat->slug; ?> .related-header {
        background-image: url(<?php echo get_field('pattern', 'product_cat_'.$cat->term_id)['url']; ?>);
        -moz-background-size: <?php echo get_field('pattern', 'product_cat_'.$cat->term_id)['width']/2; ?>px <?php echo get_field('pattern', 'product_cat_'.$cat->term_id)['height']/2; ?>px;
        background-size: <?php echo get_field('pattern', 'product_cat_'.$cat->term_id)['width']/2; ?>px <?php echo get_field('pattern', 'product_cat_'.$cat->term_id)['height']/2; ?>px;
    }
    <?php endif; ?>
    <?php endforeach; ?>
</style>
<?php }

add_action('wp_head', __NAMESPACE__.'\\colors');


//* Do NOT include the opening php tag shown above. Copy the code shown below into functions.php

/**
 * Manage WooCommerce styles and scripts.
 */
function grd_woocommerce_script_cleaner() {

    // Remove the generator tag
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

    // Unless we're in the store, remove all the cruft!
    wp_dequeue_style( 'woocommerce_frontend_styles' );
    wp_dequeue_style( 'woocommerce-general');
    wp_dequeue_style( 'woocommerce-layout' );
    wp_dequeue_style( 'woocommerce-smallscreen' );
    wp_dequeue_style( 'woocommerce_fancybox_styles' );
    wp_dequeue_style( 'woocommerce_chosen_styles' );
    wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
    wp_dequeue_style( 'select2' );
    wp_dequeue_script( 'wc-add-payment-method' );
    wp_dequeue_script( 'wc-lost-password' );
    wp_dequeue_script( 'wc_price_slider' );
    wp_dequeue_script( 'wc-single-product' );
    //wp_dequeue_script( 'wc-add-to-cart' );
    //wp_dequeue_script( 'wc-cart-fragments' );
    wp_dequeue_script( 'wc-credit-card-form' );
    //wp_dequeue_script( 'wc-checkout' );
    wp_dequeue_script( 'wc-add-to-cart-variation' );
    wp_dequeue_script( 'wc-cart' );
    wp_dequeue_script( 'wc-chosen' );
    wp_dequeue_script( 'woocommerce' );
    wp_dequeue_script( 'prettyPhoto' );
    wp_dequeue_script( 'prettyPhoto-init' );
    wp_dequeue_script( 'jquery-blockui' );
    wp_dequeue_script( 'jquery-placeholder' );
    wp_dequeue_script( 'jquery-payment' );
    wp_dequeue_script( 'fancybox' );
    wp_dequeue_script( 'jqueryui' );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\grd_woocommerce_script_cleaner', 99 );


function remove_wc_js($input) {
    if(!is_admin()){
        $input = preg_match('/<script(.*?)(jquery)(.*?)><\/script>/', $input) ? '' : $input;
        $input = preg_match('/<script(.*?)(social-login)(.*?)><\/script>/', $input) ? '' : $input;
        $input = preg_match('/<script(.*?)(woocommerce)(.*?)><\/script>/', $input) ? '' : $input;
    }
    return $input;
}
add_filter('script_loader_tag', __NAMESPACE__.'\\remove_wc_js', 9999);

function my_html_price($price) {
    $price = str_replace(array('<ins>', '</ins>','&euro;</span>&nbsp;', ',', ':'), array('', '', '&euro;</span>&nbsp;<strong>', '</strong>,', ''), $price);
    return $price;
}
add_filter('woocommerce_coupon_discount_amount_html', __NAMESPACE__.'\\my_html_price');
add_filter('woocommerce_cart_item_price', __NAMESPACE__.'\\my_html_price');
add_filter('woocommerce_get_price_html', __NAMESPACE__.'\\my_html_price');
add_filter('woocommerce_cart_subtotal', __NAMESPACE__.'\\my_html_price');
add_filter('woocommerce_cart_totals_order_total_html', __NAMESPACE__.'\\my_html_price');
add_filter('woocommerce_cart_shipping_method_full_label', __NAMESPACE__.'\\my_html_price');

function coupon_price($price) {
    $price = str_replace(array('<span class="woocommerce-Price-amount', '<a'), array('<span class="price"><span class="woocommerce-Price-amount', '</span><br/><a'), $price);
    return $price;
}
add_filter('woocommerce_cart_totals_coupon_html', __NAMESPACE__.'\\coupon_price');


function wrap_shipping_price($price) {
    $price = preg_replace('/<span(.*?)(woocommerce-Price-amount)(.*?)>(.*)<\/span>/', '<span class="price"><span$1$2$3>$4</span></span>', $price);
    return $price;
}

add_filter('woocommerce_cart_shipping_method_full_label', __NAMESPACE__.'\\wrap_shipping_price');
// FILTER HTML INPUTS

function my_woocommerce_form_field( $key, $args, $value = null, $name = null, $shipping = false ) {
    $defaults = array(
        'type'              => 'text',
        'label'             => '',
        'description'       => '',
        'placeholder'       => '',
        'maxlength'         => false,
        'required'          => false,
        'autocomplete'      => false,
        'id'                => $key,
        'class'             => array(),
        'label_class'       => array(),
        'input_class'       => array(),
        'return'            => false,
        'options'           => array(),
        'custom_attributes' => array(),
        'validate'          => array(),
        'default'           => '',
    );

    $ngName = ($name != null) ? $name .'.' : '';
    $args = wp_parse_args( $args, $defaults );
    $args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );
    if ( $args['required'] ) {
        $args['class'][] = 'validate-required';
        if($name == 'checkout') {
            $required_field = ($shipping) ? ' ng-required="isShippingAddress"' : ' required';
        } else {
            $required_field = ' required';
        }
        $required_text_end = ' ('.__('Campo obbligatorio','castadiva').')';
        $required = ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>';
    } else {
        $required_text_end = '';
        $required_field = '';
        $required = '';
    }
    $args['maxlength'] = ( $args['maxlength'] ) ? 'maxlength="' . absint( $args['maxlength'] ) . '"' : '';
    $args['autocomplete'] = ( $args['autocomplete'] ) ? 'autocomplete="' . esc_attr( $args['autocomplete'] ) . '"' : '';
    if ( is_string( $args['label_class'] ) ) {
        $args['label_class'] = array( $args['label_class'] );
    }
    $ngInit = '';
    if ( is_null( $value ) ) {
        $value = $args['default'];
    } else {
        $ngInit = ' ng-init="' .esc_attr( $key ). '=\''.$value.'\'"';
    }
    // Custom attribute handling
    $custom_attributes = array();
    if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
        foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
            $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
        }
    }
    if ( ! empty( $args['validate'] ) ) {
        foreach ( $args['validate'] as $validate ) {
            $args['class'][] = 'validate-' . $validate;
        }
    }
    $field = '';
    $label_id = $args['id'];
    $field_container = '<div class="form-row row %1$s" id="%2$s">%3$s</div>';
    $args['placeholder'] = ($args['placeholder']!='') ? $args['placeholder'] . $required_text_end : $args['label']. $required_text_end;
    switch ( $args['type'] ) {
        case 'country' :
            $countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();
            $ngChange = ($name == 'checkout') ? ' ng-change="updateCheckout(' . esc_attr( $key ) . ', isShippingAddress)"' : '';
            if ( 1 === sizeof( $countries ) ) {
                $field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $custom_attributes ) . $ngInit . ' class="country_to_state" />';
            } else {
                $ngInit = 
                    $field = '<div class="select options"><span class="select-text" ng-bind-html="(' . esc_attr( $key ) . ') ? ' . esc_attr( $key ) . ' : \'' . __( 'Paese', 'castadiva' )  . $required_text_end. '\'" ng-class="{error : ('.$name.'.' . esc_attr( $key ) . '.$dirty && '.$name.'.' . esc_attr( $key ) . '.$invalid)}"></span><select ng-model="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . $args['autocomplete'] . ' class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . $ngInit . $ngChange . '>' . '<option value="">' . __( 'Select a country&hellip;', 'woocommerce' ) . '</option>';
                foreach ( $countries as $ckey => $cvalue ) {
                    $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
                }
                $field .= '</select><i class="select-arrow select-arrow-inv"></i></div>';
                $field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '" /></noscript>';
            }
            break;
        case 'state' :
            /* Get Country */
            $country_key = 'billing_state' === $key ? 'billing_country' : 'shipping_country';
            $current_cc  = WC()->checkout->get_value( $country_key );
            $states      = WC()->countries->get_states( $current_cc );
            if ( is_array( $states ) && empty( $states ) ) {
                $field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" />';
            } elseif ( is_array( $states ) ) {
                $field .= '<div class="select options" ng-class="{error : ('.$name.'.' . esc_attr( $key ) . '.$dirty && '.$name.'.' . esc_attr( $key ) . '.$invalid)}"><span class="select-text" ng-bind-html="(' . esc_attr( $key ) . ') ? ' . esc_attr( $key ) . ' : \'' . __( 'Provincia', 'castadiva' )  . $required_text_end. '\'"></span><select ng-model="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . $ngInit .' data-placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['autocomplete'] . $required_field .'>
						<option value="">' . __( 'Select a state&hellip;', 'woocommerce' ) . '</option>';
                foreach ( $states as $ckey => $cvalue ) {
                    $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
                }
                $field .= '</select><i class="select-arrow select-arrow-inv"></i></div>';
            } else {
                $field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['autocomplete'] . ' name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . $ngInit . ' />';
            }
            break;
        case 'textarea' :
            $field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' ' . $args['autocomplete'] . ' ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . $ngInit . '>' . esc_textarea( $value ) . '</textarea>';
            break;
        case 'checkbox' :
            $field = '<input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' />';
            $field .= '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '>'
                . $args['label'] . $required . '</label>';
            break;
        case 'password' :
        case 'text' :
        case 'email' :
        case 'tel' :
        case 'number' :
            $my_field = '<input ng-model="'. esc_attr( $key ) .'" type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' '.$required_field.' ' . $args['autocomplete'] . ' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . $ngInit . ' />';
            if( esc_attr( $key ) == 'billing_cf') {
                $field .= (ICL_LANGUAGE_CODE == 'it') ? $my_field : '';
            } else {
                $field .= $my_field;
            }
            break;
        case 'select' :
            $options = $field = '';
            if ( ! empty( $args['options'] ) ) {
                foreach ( $args['options'] as $option_key => $option_text ) {
                    if ( '' === $option_key ) {
                        // If we have a blank option, select2 needs a placeholder
                        if ( empty( $args['placeholder'] ) ) {
                            $args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
                        }
                        $custom_attributes[] = 'data-allow_clear="true"';
                    }
                    $options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) . '</option>';
                }
                $field .= '<div class="select options"><span class="select-text" ng-bind-html="(' . esc_attr( $key ) . ') ? ' . esc_attr( $key ) . ' : \'' . __( 'Select&hellip;', 'woocommerce' )  .'\'" ng-class="{error : ('.$name.'.' . esc_attr( $key ) . '.$dirty && '.$name.'.' . esc_attr( $key ) . '.$invalid)}"><<select ng-model="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['autocomplete'] . $ngInit . '>
							' . $options . '
						</select><i class="select-arrow select-arrow-inv"></i></div>';
            }
            break;
        case 'radio' :
            $label_id = current( array_keys( $args['options'] ) );
            if ( ! empty( $args['options'] ) ) {
                foreach ( $args['options'] as $option_key => $option_text ) {
                    $field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
                    $field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . $option_text . '</label>';
                }
            }
            break;
    
    }
    if ( ! empty( $field ) ) {
        $field_html = '';
        if ( $args['label'] && 'checkbox' != $args['type'] ) {

        }
        $field_html .= $field;
        if ( $args['description'] ) {
            $field_html .= '<span class="description">' . esc_html( $args['description'] ) . '</span>';
        }
        $container_class = 'form-row ' . esc_attr( implode( ' ', $args['class'] ) );
        $container_id = esc_attr( $args['id'] ) . '_field';
        $field = sprintf( $field_container, $container_class, $container_id, $field_html ) ;
    }
    $field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );
    if ( $args['return'] ) {
        return $field;
    } else {
        echo $field;
    }
}
function add_ng_model_quantity($args, $product) {
    $new_array = array(
        'ng_model' => apply_filters( 'woocommerce_quantity_input_max', '', $product ),
        'ng_change' => ''
    );
    array_push($args, $new_array);
    return $args;
}

add_filter('woocommerce_quantity_input_args', __NAMESPACE__.'\\add_ng_model_quantity', 10, 2);

// WRAPPERS

function checkout_steps() {
    get_template_part('templates/checkout', 'steps');
}

function cart_item_after() {
    echo '</div></div>';
}

add_action('woocommerce_before_cart', __NAMESPACE__.'\\checkout_steps');
add_action('woocommerce_before_checkout_form', __NAMESPACE__.'\\checkout_steps', 1);

function closing_wrapper_after() {
    echo '</div>';
}

function form_wrapper_before() {
    echo '<div class="form-row-container">';
}
add_action('woocommerce_before_checkout_billing_form', __NAMESPACE__.'\\form_wrapper_before');
add_action('woocommerce_before_checkout_shipping_form', __NAMESPACE__.'\\form_wrapper_before');

add_action('woocommerce_after_checkout_billing_form', __NAMESPACE__.'\\closing_wrapper_after');
add_action('woocommerce_after_checkout_shipping_form', __NAMESPACE__.'\\closing_wrapper_after');

function my_after_cart() {
?>
</div>   
<div class="cart-wrapper" ng-show="miniCartItems.count < 1">
    <?php wc_get_template('cart/cart-empty.php'); ?>
</div>
<?php }


add_action('woocommerce_after_cart', __NAMESPACE__.'\\my_after_cart');

function before_cart_shipping() {
    echo '<div class="cart-shipping">';
}

add_action('woocommerce_cart_totals_before_shipping', __NAMESPACE__.'\\before_cart_shipping');
add_action('woocommerce_review_order_before_shipping', __NAMESPACE__.'\\before_cart_shipping');
add_action('woocommerce_cart_totals_after_shipping', __NAMESPACE__.'\\closing_wrapper_after');
add_action('woocommerce_review_order_after_shipping', __NAMESPACE__.'\\closing_wrapper_after');

function before_checkout_review() {
    echo '<div class="checkout-order-review row row-md">';
}
add_action('woocommerce_checkout_before_order_review', __NAMESPACE__.'\\before_checkout_review');
add_action('woocommerce_checkout_after_order_review', __NAMESPACE__.'\\closing_wrapper_after');

function order_review_submit_wrapper() {
    echo '<div class="checkout-buttons">';
}
add_action('woocommerce_review_order_before_submit', __NAMESPACE__.'\\order_review_submit_wrapper');
add_action('woocommerce_review_order_after_submit', __NAMESPACE__.'\\closing_wrapper_after');
// PAYPAL ICON

function replacePayPalIcon($iconUrl) {
    return Assets\asset_path('/img/paypal.png');
}

add_filter('woocommerce_paypal_icon', __NAMESPACE__.'\\replacePayPalIcon');

function coupon_message($msg) {
    return str_replace('class="showcoupon"', 'class="showcoupon" ng-click="$event.preventDefault(); isCouponActive = !isCouponActive"', $msg);
}
add_filter('woocommerce_checkout_coupon_message', 'coupon_message');


// SET API


function set_my_api() {
    $woocommerce = new Client(
        get_bloginfo('url'), 
        'ck_fc88c0754c9bab272c5e5cf621d1ab2dfe6d8ed2', 
        'cs_94e2e7a988bc3de8a7bd91979ae83c59f57b0fb1',
        [
            'wp_api' => true,
            'version' => 'wc/v1',
            'verify_ssl' => false
        ]
    );
    //    $results = $woocommerce->get('products');
    try {

        // Array of response results.
        $results = $woocommerce->get('products');
        // Example: ['customers' => [[ 'id' => 8, 'created_at' => '2015-05-06T17:43:51Z', 'email' => ...

        // Last request data.
        $lastRequest = $woocommerce->http->getRequest();
        $lastRequest->getUrl(); // Requested URL (string).
        $lastRequest->getMethod(); // Request method (string).
        $lastRequest->getParameters(); // Request parameters (array).
        $lastRequest->getHeaders(); // Request headers (array).
        $lastRequest->getBody(); // Request body (JSON).

        // Last response data.
        $lastResponse = $woocommerce->http->getResponse();
        $lastResponse->getCode(); // Response code (int).
        $lastResponse->getHeaders(); // Response headers (array).
        $lastResponse->getBody(); // Response body (JSON).

    } catch (HttpClientException $e) {
        $e->getMessage(); // Error message.
        $e->getRequest(); // Last request data.
        $e->getResponse(); // Last response data.
    }
}

//add_action('init', __NAMESPACE__.'\\set_my_api');


function wpse_19692_registration_redirect() {
    return get_permalink( get_option('woocommerce_myaccount_page_id') );
}

add_filter( 'registration_redirect', __NAMESPACE__.'\\wpse_19692_registration_redirect' );

add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
    global $woocommerce;
    extract( $_POST );

    if ( strcmp( $password, $password2 ) !== 0 ) {
        return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
    }
    return $reg_errors;
}

add_action( 'woocommerce_register_form', 'wc_register_form_password_repeat' );
function wc_register_form_password_repeat() {
?>
<p class="frow-btm row-md-btm">
    <input type="password" class="input-text" name="password2" id="reg_password2" ng-init="password2 =(registerForm.password2.$error.pattern && registerForm.password2.$touched && registerForm.password2.$dirty) ? '<?php echo __('La password non corrisponde', 'castadiva'); ?>' : password2" placeholder="<?php echo __('Conferma password (obbligatorio)', 'castadiva'); ?>" ng-pattern="password" ng-model="password2" required />
    <span class="password-error" ng-show="(registerForm.password2.$error.pattern && registerForm.password2.$touched && registerForm.password2.$dirty)" ng-bind-html="'<?php echo __('La password non corrisponde', 'castadiva'); ?>'"></span>
</p>
<?php
                                            }

add_filter( 'wp_login_failed', __NAMESPACE__. '\\my_login_fail', 10, 1 );  // hook failed login

function my_login_fail( $user ) {
    global $wp;
    $current_url = wp_get_referer();
    $string = "?login_error";
    //redirect to custom login page and append login error flag
    $redirect = str_replace($string, '', $current_url) . $string;
    wp_redirect($redirect);
    exit;
}

// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
    $fields['billing']['billing_state']['type'] = 'text';
    $fields['shipping']['shipping_state']['type'] = 'text';
    return $fields;

}



 
add_filter( 'woocommerce_address_to_edit', 'reset_address_to_edit' );
function reset_address_to_edit( $address ) {
    global $wp_query;
    
    if(is_wc_endpoint_url('edit-address') && $wp_query->query_vars['edit-address'] != _x( 'billing', 'edit-address-slug', 'woocommerce' )) {
        $address['shipping_state']['type'] = 'text';
        return $address;
    }
	
    $address['billing_state']['type'] = 'text';
    
    return $address;
}


/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );

function my_checkout_update_filters($args) {
    if ( ! defined( 'WOOCOMMERCE_CART' ) ) {
			define( 'WOOCOMMERCE_CART', true );
		}

		WC()->cart->calculate_totals();
    ob_start();
    wc_get_template( 'cart/cart-totals.php' );
    $fragment = ob_get_contents();
    ob_end_clean();
    $args['cart_total_updated'] = $fragment;

	return $args;
    die();
}


add_filter('woocommerce_update_order_review_fragments', 'my_checkout_update_filters');
require_once 'cf.php';