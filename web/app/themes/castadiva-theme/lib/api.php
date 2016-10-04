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
                'price' => $product->get_price_html(),
                'onsale' => ($product->is_on_sale()) ? __('Offerta', 'castadiva') : false,
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
        return $args;
    }
add_action( 'rest_glossary_query', 'custom_rest_query', 10, 2 );