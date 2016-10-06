<?php
    
    require_once get_template_directory().'/lib/Instaphp/vendor/autoload.php';
    
    add_action( 'init', 'my_wp_api', 25 );
    function my_wp_api() {
        global $wp_post_types;

        //be sure to set this to the name of your post type!
            $post_type_name = 'product';
        if( isset( $wp_post_types[ $post_type_name ] ) ) {
            $wp_post_types[$post_type_name]->show_in_rest = true;
            $wp_post_types[$post_type_name]->rest_base = $post_type_name;
            $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
        }

    }

    add_action( 'rest_api_init', 'api_init' );
    
    function api_init() {
        register_api_field(  array('post', 'ricette'),
            'post_cat',
            array(
                'get_callback'    => __NAMESPACE__.'\\register_cat_field',
                'update_callback' => null,
                'schema'          => null,
            )
        );
        function register_cat_field($object) {
            $cat = '';
            $tax = ($object['type'] == 'post') ? 'category' : 'recipe_cat';
            $className = ($object['type'] == 'post') ? '' : ' class="recipe-cat"';
            $categories = wp_get_post_terms($object['id'], $tax);
            $count = 0;
            foreach($categories as $c){
                $comma = ($count < count($categories) - 1) ? ', ' : '';
                $cat .= '<a href='.get_term_link($c->term_id).'"'.$className.'>'.$c->name.'</a>'.$comma;
                $count++;
            }
            return $cat;
        }
        // ADD THUMB
        // POST THUMBNAIL
        register_api_field(  array('post', 'itinerari', 'ricette'),
            'post_thumbnail',
            array(
                'get_callback'    => __NAMESPACE__.'\\add_post_thumbnail_src',
                'update_callback' => null,
                'schema'          => null,
            )
        );
        function add_post_thumbnail_src($object) {
            $id = get_post_thumbnail_id($object['id']);
            return wp_get_attachment_image_src($id, 'full');
        }// POST THUMBNAIL
        register_api_field(  array('post', 'product', 'itinerari', 'ricette'),
            'post_class',
            array(
                'get_callback'    => __NAMESPACE__.'\\add_post_class',
                'update_callback' => null,
                'schema'          => null,
            )
        );
        function add_post_class($object) {
            return join(' ', get_post_class(null, $object['id']));
        }
        // POST THUMBNAIL
        register_api_field(  array('product'),
            'product_attrs',
            array(
                'get_callback'    => __NAMESPACE__.'\\add_product_attributes',
                'update_callback' => null,
                'schema'          => null,
            )
        );
        function add_product_attributes($object) {
            $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' );
            $props = wc_get_product_attachment_props( get_post_thumbnail_id(), $object );
            $thumb = get_the_post_thumbnail( $object['id'], $image_size, array(
                'title'	 => $props['title'],
                'alt'    => $props['alt'],
            ) );
            $post = get_post($object['id']);
            
            $product = wc_get_product($object['id']);
            $id = get_post_thumbnail_id($object['id']);
            $attrs = array(
                'price_value' => $product->get_price(),
                'price' => $product->get_price_html(),
                'onsale' => $product->is_on_sale(),
                'weight' => ($product->has_weight()) ? wc_format_localized_decimal( $product->get_weight() . ' ' . esc_attr( get_option( 'woocommerce_weight_unit' ) ) ) : false,
                'attributes' => $product->get_attributes(),
                'thumb' => $thumb,
                'desc' => (has_excerpt($object['id'])) ? apply_filters( 'woocommerce_short_description', $post->post_excerpt ) : false 
            );

            return $attrs;
        }
        register_rest_route('api/v1', '/instagram', array(
            "methods" => 'GET',
            "callback" => 'instagram_posts'
        ));
        function instagram_posts() {
            $option = get_option('instagram_settings');
            $client_id = $option['instagram_client_id'];
            $client_secret = $option['instagram_client_secret'];
            $access_token = $option['instagram_access_token'];
            $user_id = $option['instagram_user_id'];
            $count = $option['instagram_count'];
            $api = new Instaphp\Instaphp([
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                    'redirect_uri' => get_bloginfo('url'),
                    'http_timeout' => 6000,
                    'http_connect_timeout' => 2000
                ]);
            if(!$api) {
                return;
            }
            $api->setAccessToken($access_token);
            $items = $api->Users->Recent($user_id, array('count'=>$count));
            return $items;
//            $cached = get_transient($user_id);
//            if($cached !== false) {
//                return $cached;
//            } else {
//                $expiration_time = 60*60*2;
//                set_transient($user_id, $items, $expiration_time);
//                return $items;
//            }
        }
    }
add_filter( 'rest_query_vars', 'flux_allow_meta_query' );
function flux_allow_meta_query( $valid_vars )
{
    $valid_vars = array_merge( $valid_vars, array( 'meta_query', 'meta_key', 'meta_value', 'meta_compare' ) );
    return $valid_vars;
}

function custom_rest_query( $args, $request ) {
    if ( array_key_exists( 'product_cat', $args) ) {
        $tax_query = array(
            'relation' => 'AND'
        );
        $terms = explode( ',', $args['product_cat'] );  // NOTE: Assumes comma separated taxonomies
        for ( $i = 0; $i < count( $terms ); $i++) {
            array_push( $tax_query, array(
                'taxonomy' => $args[ 'product_cat' ],
                'field' => 'slug',
                'terms' => array( $terms[ $i ] )
            ));            
        }
        unset( $args[ 'taxonomy' ] );  // We are replacing with our tax_query
        $args[ 'tax_query' ] = $tax_query;
    }
    if ( array_key_exists( 'product_tag', $args) ) {
        $tax_query = array(
            'relation' => 'AND'
        );
        $terms = explode( ',', $args['product_tag'] );  // NOTE: Assumes comma separated taxonomies
        for ( $i = 0; $i < count( $terms ); $i++) {
            array_push( $tax_query, array(
                'taxonomy' => $args[ 'product_tag' ],
                'field' => 'slug',
                'terms' => array( $terms[ $i ] )
            ));            
        }
        unset( $args[ 'taxonomy' ] );  // We are replacing with our tax_query
        $args[ 'tax_query' ] = $tax_query;
    }
    if ( array_key_exists( 'meta_query', $args) ) {
    $relation = 'AND';
    if( isset($args['meta_query']['relation']) && in_array($args['meta_query']['relation'], array('AND', 'OR'))) {
        $relation = sanitize_text_field( $args['meta_query']['relation'] );
    }
    $meta_query = array(
        'relation' => $relation
    );

    foreach ( $args['meta_query'] as $inx => $query_req ) {
    /*
        Array (

            [key] => test
            [value] => testing
            [compare] => =
        )
    */
        $query = array();

        if( is_numeric($inx)) {

            if( isset($query_req['key'])) {
                $query['key'] = sanitize_text_field($query_req['key']);
            }
            if( isset($query_req['value'])) {
                $query['value'] = sanitize_text_field($query_req['value']);
            }
            if( isset($query_req['type'])) {
                $query['type'] = sanitize_text_field($query_req['type']);
            }
            if( isset($query_req['compare']) && in_array($query_req['compare'], array('=', '!=', '>','>=','<','<=','LIKE','NOT LIKE','IN','NOT IN','BETWEEN','NOT BETWEEN', 'NOT EXISTS')) ) {
                $query['compare'] = sanitize_text_field($query_req['compare']);
            }
        }

        if( ! empty($query) ) $meta_query[] = $query;
    }

    // replace with sanitized query args
    $args['meta_query'] = $meta_query;
    }
    
    if(array_key_exists('orderby', $args)) {
        if($args['orderby'] === 'price') {
            $args['meta_key'] = '_price';
            $args['orderby'] = 'meta_value_num';
        }
    }
    return $args;
}
add_action( 'rest_product_query', 'custom_rest_query', 10, 2 );

//function category_rest_query( $args, $request ) {
//    if ( array_key_exists( '', $args) ) {
//        print_r($args);
//        $cat_query = array(
//            'relation' => 'AND'
//        );
//        $cats = explode( ',', $args['category'] );  // NOTE: Assumes comma separated taxonomies
//        for ( $i = 0; $i < count( $cats ); $i++) {
//            array_push( $cat_query, array(
//                'taxonomy' => $args[ 'category' ],
//                'field' => 'slug',
//                'terms' => array( $cats[ $i ] )
//            ));            
//        }
//        unset( $args[ 'taxonomy' ] );  // We are replacing with our tax_query
//        $args[ 'tax_query' ] = $cat_query;
//    }
//    return $args;
//}
//add_action( 'rest_ricette_query', 'category_rest_query', 10, 2 );