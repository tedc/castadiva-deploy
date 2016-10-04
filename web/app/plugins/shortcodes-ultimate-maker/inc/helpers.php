<?php
function sumk_sanitize_slug( $str ) {
	$iso9_table = array( 'А' => 'A',
		'Б' => 'B',
		'В' => 'V',
		'Г' => 'G',
		'Ѓ' => 'G`',
		'Ґ' => 'G`',
		'Д' => 'D',
		'Е' => 'E',
		'Ё' => 'YO',
		'Є' => 'YE',
		'Ж' => 'ZH',
		'З' => 'Z',
		'Ѕ' => 'Z',
		'И' => 'I',
		'Й' => 'Y',
		'Ј' => 'J',
		'І' => 'I',
		'Ї' => 'YI',
		'К' => 'K',
		'Ќ' => 'K',
		'Л' => 'L',
		'Љ' => 'L',
		'М' => 'M',
		'Н' => 'N',
		'Њ' => 'N',
		'О' => 'O',
		'П' => 'P',
		'Р' => 'R',
		'С' => 'S',
		'Т' => 'T',
		'У' => 'U',
		'Ў' => 'U',
		'Ф' => 'F',
		'Х' => 'H',
		'Ц' => 'TS',
		'Ч' => 'CH',
		'Џ' => 'DH',
		'Ш' => 'SH',
		'Щ' => 'SHH',
		'Ъ' => '``',
		'Ы' => 'YI',
		'Ь' => '`',
		'Э' => 'E`',
		'Ю' => 'YU',
		'Я' => 'YA',
		'а' => 'a',
		'б' => 'b',
		'в' => 'v',
		'г' => 'g',
		'ѓ' => 'g',
		'ґ' => 'g',
		'д' => 'd',
		'е' => 'e',
		'ё' => 'yo',
		'є' => 'ye',
		'ж' => 'zh',
		'з' => 'z',
		'ѕ' => 'z',
		'и' => 'i',
		'й' => 'y',
		'ј' => 'j',
		'і' => 'i',
		'ї' => 'yi',
		'к' => 'k',
		'ќ' => 'k',
		'л' => 'l',
		'љ' => 'l',
		'м' => 'm',
		'н' => 'n',
		'њ' => 'n',
		'о' => 'o',
		'п' => 'p',
		'р' => 'r',
		'с' => 's',
		'т' => 't',
		'у' => 'u',
		'ў' => 'u',
		'ф' => 'f',
		'х' => 'h',
		'ц' => 'ts',
		'ч' => 'ch',
		'џ' => 'dh',
		'ш' => 'sh',
		'щ' => 'shh',
		'ь' => '',
		'ы' => 'yi',
		'ъ' => "'",
		'э' => 'e`',
		'ю' => 'yu',
		'я' => 'ya' );
	$str = preg_replace( "/[^A-Za-z0-9_]/", '', strtr( $str, $iso9_table ) );
	$str = strtolower( $str );
	$str = ltrim( trim( $str, '_' ), '0..9' );
	return $str;
}

function sumk_get_types() {
	return array(
		'text'         => __( 'Text', 'sumk' ),
		'number'       => __( 'Number', 'sumk' ),
		'color'        => __( 'Color', 'sumk' ),
		'select'       => __( 'Dropdown', 'sumk' ),
		'bool'         => __( 'Switch', 'sumk' ),
		'icon'         => __( 'Icon', 'sumk' ),
		'upload'       => __( 'Media library', 'sumk' ),
		'image_source' => __( 'Image source', 'sumk' )
	);
}

function sumk_is_hex( $value ) {
	if ( !is_string( $value ) ) return false;
	return !empty( $value ) && ( strlen( $value ) === 7 || strlen( $value ) === 4 ) && strpos( $value, '#' ) === 0;
}

function sumk_plugin_meta_links( $links, $file ) {
	global $sumk;
	// Check plugin
	if ( $file === $sumk->basename ) $links[] = '<a href="http://gndev.info/cs/" target="_blank">' . __( 'Customer support', 'sumk' ) . '</a>';
	return $links;
}

function sumk_get_atts( $post_id ) {
	$atts = get_post_meta( $post_id, 'sumk_attr', false );
	$array = array();
	// Check $atts[0]
	if ( is_array( $atts ) && isset( $atts[0] ) ) {
		// [0] Convert string to array
		if ( is_string( $atts[0] ) ) $atts[0] = ( strpos( $atts[0], '{' ) !== false ) ? html_entity_decode( $atts[0] ) : base64_decode( $atts[0] );
		// [0] Unserialize array
		$array = maybe_unserialize( $atts[0] );
		// [0] Array not empty
		if ( is_array( $array ) && count( $array ) ) return $array;
		// [0] Array is empty, go to $atts[1]
		else
			// Check $atts[1]
			if ( is_array( $atts ) && isset( $atts[1] ) ) {
				// [1] Convert string to array
				if ( is_string( $atts[1] ) ) $atts[1] = ( strpos( $atts[1], '{' ) !== false ) ? html_entity_decode( $atts[1] ) : base64_decode( $atts[1] );
				// [1] Unserialize array
				$array = maybe_unserialize( $atts[1] );
				if ( is_array( $array ) && count( $array ) ) return $array;
			}
	}
	return $array;
}
