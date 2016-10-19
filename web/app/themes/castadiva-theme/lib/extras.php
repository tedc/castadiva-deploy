<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;
use Roots\Sage\Assets;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return '&hellip;';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


add_image_size( 'post-thumb', 1940, 570 );

add_action( 'admin_init', __NAMESPACE__ . '\\social_settings_init' );


function social_add_admin_menu(  ) { 

	add_submenu_page( null, null, null, 'manage_options', 'general', __NAMESPACE__.'\\social_options_page' );

}


function social_settings_init(  ) { 

	
    register_setting( 'general', 'ga_settings' );
    
	add_settings_section(
		'ga_section', 
		__( 'Google Analytics', 'castadiva' ), 
		__NAMESPACE__.'\\ga_settings_section_callback', 
		'general'
	);
    add_settings_field( 
		'ga_id', 
		__( 'Identificativo Google Analitycs', 'castadiva' ), 
		__NAMESPACE__.'\\ga_field', 
		'general', 
		'ga_section' 
	);
    
    register_setting( 'general', 'tour_settings' );
	add_settings_field( 
		'tour_email', 
		__( 'Indirizzo email di ricezione per gli itinerari', 'castadiva' ), 
		__NAMESPACE__.'\\tour_field', 
		'general', 
		'tour_section' 
	);
    add_settings_section(
		'tour_section', 
		__( 'Gli itinerari di Castadiva', 'castadiva' ), 
		__NAMESPACE__.'\\tour_settings_section_callback', 
		'general'
	);
    
    register_setting( 'general', 'social_settings' );
	register_setting( 'general', 'instagram_settings' );
    
    
	add_settings_section(
		'social_section', 
		__( 'Link social', 'castadiva' ), 
		__NAMESPACE__.'\\social_settings_section_callback', 
		'general'
	);

	add_settings_field( 
		'facebook', 
		__( 'Facebook', 'castadiva' ), 
		__NAMESPACE__.'\\social_facebook_field', 
		'general', 
		'social_section' 
	);

	add_settings_field( 
		'instagram', 
		__( 'Instagram', 'castadiva' ), 
		__NAMESPACE__.'\\social_instagram_field', 
		'general', 
		'social_section' 
	);
    add_settings_field( 
		'instagram_client_id', 
		__( 'Instagram client id', 'castadiva' ), 
		__NAMESPACE__.'\\social_instagram_ci_field', 
		'general', 
		'social_section' 
	);
    add_settings_field( 
		'instagram_client_secret', 
		__( 'Instagram client secret', 'castadiva' ), 
		__NAMESPACE__.'\\social_instagram_cs_field', 
		'general', 
		'social_section' 
	);
    add_settings_field( 
		'instagram_access_token', 
		__( 'Instagram access token', 'castadiva' ), 
		__NAMESPACE__.'\\social_instagram_at_field', 
		'general', 
		'social_section' 
	);
    
    add_settings_field( 
		'instagram_user_id', 
		__( 'Instagram user id', 'castadiva' ), 
		__NAMESPACE__.'\\social_instagram_ui_field', 
		'general', 
		'social_section' 
	);
    
    add_settings_field( 
		'instagram_count', 
		__( 'Quantità di foto da mostrare', 'castadiva' ), 
		__NAMESPACE__.'\\social_instagram_count_field', 
		'general', 
		'social_section' 
	);

}
function ga_field(  ) { 

	$options = get_option( 'ga_settings' );
	?>
	<input type='text' name='ga_settings[ga_id]' value='<?php echo $options['ga_id']; ?>'>
	<?php

}

function tour_field(  ) { 

	$options = get_option( 'tour_settings' );
	?>
	<input type='email' name='tour_settings[email]' value='<?php echo $options['email']; ?>'>
	<?php

}

function social_facebook_field(  ) { 

	$options = get_option( 'social_settings' );
	?>
	<input type='text' name='social_settings[facebook]' value='<?php echo $options['facebook']; ?>'>
	<?php

}


function social_instagram_field(  ) { 

	$options = get_option( 'social_settings' );
	?>
	<input type='text' name='social_settings[instagram]' value='<?php echo $options['instagram']; ?>'>
		
<?php

}

function social_instagram_ci_field(  ) { 

	$options = get_option( 'instagram_settings' );
	?>
	<input type='text' name='instagram_settings[instagram_client_id]' value='<?php echo $options['instagram_client_id']; ?>'>	
<?php

}
function social_instagram_cs_field(  ) { 

	$options = get_option( 'instagram_settings' );
	?>
	<input type='text' name='instagram_settings[instagram_client_secret]' value='<?php echo $options['instagram_client_secret']; ?>'>	
<?php

}
function social_instagram_at_field(  ) { 

	$options = get_option( 'instagram_settings' );
	?>
	<input type='text' name='instagram_settings[instagram_access_token]' value='<?php echo $options['instagram_access_token']; ?>'>	
<?php

}
function social_instagram_ui_field(  ) { 

	$options = get_option( 'instagram_settings' );
	?>
	<input type='text' name='instagram_settings[instagram_user_id]' value='<?php echo $options['instagram_user_id']; ?>'>	
<?php

}
function social_instagram_count_field(  ) { 

	$options = get_option( 'instagram_settings' );
	?>
	<input type='text' name='instagram_settings[instagram_count]' value='<?php echo $options['instagram_count']; ?>'>	
<?php

}
function ga_settings_section_callback(  ) { 

	echo __( 'Impostazioni per il codice di Google Analytics', 'castadiva' );

}

function tour_settings_section_callback(  ) { 

	echo __( 'Impostazioni per il form dei singoli itinerari', 'castadiva' );

}

function social_settings_section_callback(  ) { 

	echo __( 'Link per le pagine social', 'castadiva' );

}


function social_options_page(  ) { 

	?>
	<form action='options.php' method='post'>

		<h2>Social</h2>

		<?php
		settings_fields( 'general' );
		do_settings_sections( 'general' );
		submit_button();
		?>

	</form>
	<?php

}
// TYPEKIT

function typekit() {
    echo "<script>WebFontConfig = {typekit: { id: 'gwp8udl' }, active: function() { document.body.classList.remove('loading');}};(function(d) {var wf = d.createElement('script'), s = d.scripts[0];wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js';s.parentNode.insertBefore(wf, s);})(document);</script>";
    echo "<script>var assetsPath = '".get_stylesheet_directory_uri()."/assets/';var posts_per_page = ".get_option('posts_per_page')."; var baseUrl = '".get_bloginfo('url')."';</script>";
}
add_action('wp_footer', __NAMESPACE__ . '\\typekit');


/// BUTTONS


function btn($text = '', $link = '#', $btn = false, $name = '', $size = '', $color = '', $textColor = '') {
    $color = ($color != '') ? ' '.$color : $color;
    $size = ($size != '') ? ' '.$size : $size;
    $textColor = ($textColor != '') ? ' '.$textColor : $textColor;
    $name = ($name != '') ? ' name="'.$name.'" type="submit"' : '';
    echo ($btn) ? '<button class="btn'.$size.$color.'"'.$name.' value="'.strip_tags($text).'"><span class="btn-text'.$textColor.'">'.$text.'</span></button>' : '<a href="'.$link.'" class="btn'.$size.$color.'"><span class="btn-text'.$textColor.'">'.$text.'</span></a>';
}

function close($var = '') {
    echo '<span class="close" ng-click="'.$var.' = false;"><span class="btn"><i class="plus"></i></span> <span class="close-text">'.__('Chiudi', 'castadiva').'</span>';
}


// WOOCOMMERCE

require_once 'woocommerce.php';

// JQUERY

function remove_jquery_migrate( &$scripts)
{
    if(!is_admin())
    {
        $scripts->remove( 'jquery');
    }
}
function jquery_cdn() {
   if (!is_admin()) {
      wp_dequeue_script('jquery');
   }
}
//add_action('init', __NAMESPACE__.'\\jquery_cdn');
//add_filter( 'wp_default_scripts', __NAMESPACE__.'\\remove_jquery_migrate' );




// LANG

if ( !function_exists( __NAMESPACE__ . '\\acf_get_language_default' ) )
{
    function acf_get_language_default()
    {
        return acf_get_setting( 'default_language' );
    }
}

if ( !function_exists( __NAMESPACE__ . '\\acf_set_language_to_default' ) )
{
    function acf_set_language_to_default()
    {
        add_filter( 'acf/settings/current_language', __NAMESPACE__ . '\\acf_get_language_default', 100 );
    }
}

if ( !function_exists( __NAMESPACE__ . '\\acf_unset_language_to_default' ) )
{
    function acf_unset_language_to_default()
    {
        remove_filter( 'acf/settings/current_language', __NAMESPACE__ . '\\acf_get_language_default', 100 );
    }
}

function lang_nav() {
    $languages = icl_get_languages('skip_missing=0');
    $lang = "'lang'";
    $langs = '';
    $count = 0;
    foreach($languages as $l){
        $language_link = $l['url'];
        $language_code = $l['language_code'];
        $sep = ($count == 0) ? '<span class="sep">/</span>' : '';
        $active = ($language_code == ICL_LANGUAGE_CODE) ? ' active' : '';
        $langs .= '<a href="'.$language_link.'" class="lang'.$active.'">'.$language_code.'</a>'.$sep;
        $count++;
    }
    echo $langs;
}

function sitepress_dequeue_script() {
    wp_dequeue_script( 'sitepress' );
    wp_deregister_script( 'sitepress' );
}
add_action( 'wp_head',  __NAMESPACE__ . '\\sitepress_dequeue_script', 11 );

/**
 * enqueue scripts and styles 
 *
 */

function my_acf_init() {
	
	acf_update_setting('google_api_key', 'AIzaSyBaBZMTcCUY8bG4iBb8HlXp5FOfyx4qYSg');
}

add_action('acf/init',  __NAMESPACE__.'\\my_acf_init');



function rkv_remove_columns( $columns ) {
	// remove the Yoast SEO columns
	unset( $columns['wpseo-score'] );
	unset( $columns['wpseo-score-readability'] );
	unset( $columns['wpseo-title'] );
	unset( $columns['wpseo-metadesc'] );
	unset( $columns['wpseo-focuskw'] );
	return $columns;
}
add_filter ( 'manage_edit-product_columns', __NAMESPACE__.'\\rkv_remove_columns' );


## API

require_once 'api.php';