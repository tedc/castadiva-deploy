<?php
class Sumk_Assets {
	function __construct() {
		add_action( 'admin_head',   array( __CLASS__, 'register' ) );
		add_action( 'admin_footer', array( __CLASS__, 'enqueue' ) );
		add_action( 'admin_head',   array( __CLASS__, 'global_css' ) );
	}

	public static function register() {
		// Placeholder
		wp_register_script( 'placeholder', plugins_url( 'assets/js/placeholder.js', SUMK_PLUGIN_FILE ), false, '2.0.7', true );
		// Metabox
		wp_register_style( 'sumk-metabox', plugins_url( 'assets/css/metabox.css', SUMK_PLUGIN_FILE ), false, SUMK_PLUGIN_VERSION, 'all' );
		wp_register_script( 'sumk-metabox', plugins_url( 'assets/js/metabox.js', SUMK_PLUGIN_FILE ), array( 'magnific-popup', 'ace', 'placeholder', 'jquery-ui-sortable' ), SUMK_PLUGIN_VERSION, true );
		wp_localize_script( 'sumk-metabox', 'sumk', array(
				'icon_title' => __( 'Select icon', 'sumk' ),
				'icon_insert' => __( 'Use this image', 'sumk' )
			) );
	}

	public static function enqueue() {
		global $pagenow;
		// Check for add/edit shortcode screen
		if ( !in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) || get_post_type() !== 'shortcodesultimate' ) return;
		// Include CSS
		foreach ( array( 'magnific-popup', 'sumk-metabox' ) as $style ) wp_enqueue_style( $style );
		// Include JS
		foreach ( array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-sortable', 'magnific-popup', 'ace', 'placeholder', 'sumk-metabox' ) as $script ) wp_enqueue_script( $script );
		// Print help blocks
		sumk_help_popup();
	}

	public static function global_css() {
		global $pagenow;
		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] !== 'shortcodesultimate' ) return;
		if ( !in_array( $pagenow, array( 'edit.php', 'post.php', 'post-new.php' ) ) ) return;
		if ( get_post_type() !== 'shortcodesultimate' ) return;
		echo '<style type="text/css">#su-generator .su-generator-insert{display:none}#icon-shortcodes-ultimate{background:50% 50% url(\'' .
			plugins_url( 'assets/images/icon.png', SUMK_PLUGIN_FILE ) . '\') no-repeat}</style>';
	}
}

new Sumk_Assets;
