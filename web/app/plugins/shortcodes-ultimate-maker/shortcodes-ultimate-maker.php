<?php
/*
  Plugin Name: Shortcodes Ultimate: Maker addon
  Plugin URI: http://gndev.info/shortcodes-ultimate/maker/
  Version: 1.5.4
  Author: Vladimir Anokhin
  Author URI: http://gndev.info/
  Description: Shortcodes Ultimate add-on. Provides UI for creating custom shortcodes
  Text Domain: sumk
  Domain Path: /lang
  License: license.txt
 */

define( 'SUMK_PLUGIN_FILE', __FILE__ );
define( 'SUMK_PLUGIN_VERSION', '1.5.4' );

require_once 'classes/sunrise.class.php';
require_once 'inc/update.php';
require_once 'inc/check.php';
require_once 'inc/helpers.php';
require_once 'inc/posttype.php';
require_once 'inc/metabox.php';
require_once 'inc/register.php';
require_once 'inc/assets.php';
require_once 'inc/help.php';
require_once 'inc/import.php';

// Prepare plugin object
$sumk = null;

/**
 * Init hook
 */
function sumk_init() {
	global $sumk;
	// Init framework
	$sumk = new Sunrise_Plugin_Framework_2( __FILE__ );
	// Check for Shortcodes Ultimate
	if ( !function_exists( 'shortcodes_ultimate' ) ) {
		// Show notice
		add_action( 'admin_notices', 'sumk_su_notice' );
		// Break initialization
		return;
	}
	// Register CPT for custom shortcodes
	add_action( 'init', 'sumk_register_cpt' );
	// Register new shortcode group
	add_filter( 'su/data/groups', 'sumk_add_custom_group' );
	// Register custom shortcodes
	add_filter( 'su/data/shortcodes', 'sumk_register' );
	// Add plugin meta links
	add_filter( 'plugin_row_meta', 'sumk_plugin_meta_links', 10, 2 );
	// Import demo shortcodes
	add_action( 'load-plugins.php', 'sumk_import_demo' );
	// Hook to save metabox data
	add_action( 'save_post', 'sumk_save' );
	// Clear generator cache
	delete_transient( 'su/generator/popup' );
	// Make plugin meta translatable
	__( 'Shortcodes Ultimate: Maker addon', 'sumk' );
	__( 'Vladimir Anokhin', 'sumk' );
	__( 'Shortcodes Ultimate add-on. Provides UI for creating custom shortcodes', 'sumk' );
}

add_action( 'plugins_loaded', 'sumk_init' );

new WPUpdatesPluginUpdater_562( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__) );
