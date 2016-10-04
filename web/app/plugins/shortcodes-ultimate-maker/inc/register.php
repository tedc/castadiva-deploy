<?php
function sumk_register( $shortcodes ) {
	$sc = new WP_Query( array( 'post_type' => 'shortcodesultimate',
			'posts_per_page' => -1,
			'post_status' => 'publish' ) );
	// Prepare array for new shortcodes
	$add = array();
	// Loop through added shortcodes
	if ( $sc->post_count ) foreach ( $sc->posts as $scpost ) {
			// Get shortcode data from post meta
			$meta = get_post_custom( $scpost->ID );
			// Prepare slug
			$slug = ( isset( $meta['sumk_slug'][0] ) ) ? $meta['sumk_slug'][0] : 'shortcode_' . $scpost->ID;
			// Code
			$code = ( isset( $meta['sumk_code'][0] ) ) ? $meta['sumk_code'][0] : '';
			// New shortcode type wrap|single
			$type = ( strpos( $code, '{{content}}' ) !== false || strpos( $code, '$content' ) !== false ) ? 'wrap' : 'single';
			// Code type
			$code_type = ( isset( $meta['sumk_code_type'][0] ) ) ? $meta['sumk_code_type'][0] : '';
			// Shortcode attributes (will be converted to $atts)
			$attr = sumk_get_atts( $scpost->ID );
			// Prepare array for attributes
			$atts = array();
			// Loop through attributes (convert structure)
			foreach ( $attr as $att ) {
				// Prepare values (used only for selects)
				$values = array();
				// Parse options for select field
				if ( $att['type'] === 'select' ) foreach ( (array) explode( "\n", $att['options'] ) as $option ) {
						if ( strpos( $option, '|' ) === false ) $option = array( $option, $option );
						else $option = explode( '|', $option );
						$values[sanitize_html_class( $option[0] )] = sanitize_text_field( $option[1] );
					}
				// Replace number with slider
				if ( $att['type'] === 'number' ) $att['type'] = 'slider';
				// Insert attribute
				$atts[$att['slug']] = array(
					'type' => $att['type'],
					'default' => ( isset( $att['default'] ) ) ? $att['default'] : '',
					'name' => ( !empty( $att['name'] ) ) ? $att['name'] : $att['slug'],
					'desc' => ( !empty( $att['desc'] ) ) ? $att['desc'] : '',
					'min' => ( isset( $att['min'] ) ) ? $att['min'] : 0,
					'max' => ( isset( $att['max'] ) ) ? $att['max'] : 100,
					'step' => ( isset( $att['step'] ) ) ? $att['step'] : 1,
					'values' => $values
				);
			}
			// Prepare function code
			$defaults = array();
			foreach ( $atts as $att => $attdata ) $defaults[$att] = $attdata['default'];
			$function = 'return sumk_do_shortcode(\'' . $code_type . '\',\'' . $code . '\', \'' . serialize( $defaults ) . '\',$atts, $content);';
			// Create new shortcode
			$shortcodes[$slug] = array(
				'name' => ( isset( $meta['sumk_name'][0] ) ) ? $meta['sumk_name'][0] : '',
				'type' => $type,
				'group' => 'custom',
				'atts' => $atts,
				'usage' => ( isset( $meta['sumk_slug'][0] ) ) ? '[' . $meta['sumk_slug'][0] . ']' : '',
				'content' => ( isset( $meta['sumk_content'][0] ) ) ? $meta['sumk_content'][0] : '',
				'desc' => ( isset( $meta['sumk_desc'][0] ) ) ? $meta['sumk_desc'][0] : '',
				'icon' => ( isset( $meta['sumk_icon'][0] ) ) ? $meta['sumk_icon'][0] : '',
				'function' => create_function( '$atts,$content', $function )
			);
		}
	wp_reset_postdata();
	return $shortcodes;
}

function sumk_add_custom_group( $groups ) {
	global $sumk;
	$groups['custom'] = __( 'Custom', $sumk->textdomain );
	return $groups;
}

function sumk_do_shortcode( $type, $code, $defaults, $atts, $content ) {
	// Decode
	$code = htmlspecialchars_decode( stripslashes( $code ), ENT_QUOTES );
	// Prepare args
	$atts = wp_parse_args( $atts, unserialize( $defaults ) );
	// HTML mode
	if ( $type === 'html' ) {
		// Replace all attribute variables
		foreach ( $atts as $att => $value ) $code = str_replace( '{{' . $att . '}}', $value, $code );
		// Replace content
		$code = str_replace( '{{content}}', do_shortcode( $content ), $code );
		// Return result
		return do_shortcode( $code );
	}
	// PHP return
	elseif ( $type === 'php_return' ) {
		extract( $atts );
		$return = eval( $code );
		return $return;
	}
	// PHP echo
	elseif ( $type === 'php_echo' ) {
		extract( $atts );
		ob_start();
		eval( $code );
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	return false;
}
