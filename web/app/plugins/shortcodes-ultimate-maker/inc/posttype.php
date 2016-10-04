<?php

/**
 * Register CPT for custom shortcodes
 */
function sumk_register_cpt() {
	$labels = array(
		'name'               => __( 'Custom shortcodes', 'sumk' ),
		'singular_name'      => __( 'Shortcode', 'sumk' ),
		'add_new'            => __( 'Create shortcode', 'sumk' ),
		'add_new_item'       => __( 'Add new Shortcode', 'sumk' ),
		'edit_item'          => __( 'Edit shortcode', 'sumk' ),
		'new_item'           => __( 'New shortcode', 'sumk' ),
		'all_items'          => __( 'Custom shortcodes', 'sumk' ),
		'view_item'          => __( 'View shortcode', 'sumk' ),
		'search_items'       => __( 'Search shortcodes', 'sumk' ),
		'not_found'          => __( 'No shortcodes found', 'sumk' ),
		'not_found_in_trash' => __( 'No shortcodes in Trash', 'sumk' ),
		'parent_item_colon'  => '',
		'menu_name'          => __( 'Shortcodes', 'sumk' )
	);
	$args = array(
		'labels'               => $labels,
		'public'               => false,
		'exclude_from_search'  => true,
		'publicly_queryable'   => false,
		'show_ui'              => true,
		'show_in_nav_menus'    => false,
		'show_in_menu'         => 'shortcodes-ultimate',
		'show_in_admin_bar'    => false,
		'capability_type'      => 'post',
		'register_meta_box_cb' => 'sumk_register_metabox',
		'supports'             => array( '' ),
		'query_var'            => false,
		'capabilities'         => array(
			'publish_posts'       => 'manage_options',
			'edit_posts'          => 'manage_options',
			'edit_others_posts'   => 'manage_options',
			'delete_posts'        => 'manage_options',
			'delete_others_posts' => 'manage_options',
			'read_private_posts'  => 'manage_options',
			'edit_post'           => 'manage_options',
			'delete_post'         => 'manage_options',
			'read_post'           => 'edit_posts',
		)
	);
	// Register CPT
	register_post_type( 'shortcodesultimate', $args );
	// Customize CPT UI
	add_filter( 'post_updated_messages', 'sumk_updated_messages' );
	add_filter( 'manage_shortcodesultimate_posts_columns', 'sumk_manage_posts_columns', -10 );
	add_action( 'manage_shortcodesultimate_posts_custom_column', 'sumk_custom_column_content', 10, 2 );
	add_filter( 'post_row_actions', 'sumk_post_row_actions', 10, 2 );
}

/**
 * Filter to modify edit screen messages
 *
 * @param unknown $messages
 *
 * @return array Messages
 */
function sumk_updated_messages( $messages ) {
	$button = Su_Generator::button( array(
			'target'    => '',
			'text'      => __( 'View shortcode', 'sumk' ),
			'class'     => '',
			'icon'      => false,
			'echo'      => false,
			'shortcode' => false
		) );
	$messages['shortcodesultimate'][1]  = $messages['shortcodesultimate'][4] = __( 'Shortcode updated', 'sumk' ) . '. ' . $button;
	$messages['shortcodesultimate'][6]  = __( 'Shortcode added', 'sumk' ) . '. ' . $button;
	$messages['shortcodesultimate'][7]  = __( 'Shortcode saved', 'sumk' ) . '. ' . $button;
	$messages['shortcodesultimate'][8]  = __( 'Shortcode submitted', 'sumk' ) . '. ' . $button;
	$messages['shortcodesultimate'][10] = __( 'Shortcode draft updated', 'sumk' );
	return $messages;
}

function sumk_manage_posts_columns( $columns, $post_type = 'page' ) {
	// Remove date column
	unset( $columns['date'] );
	// Add shortcode column
	$columns['shortcode'] = __( 'Shortcode', 'sumk' );
	// Add icon column
	$columns['icon'] = __( 'Icon', 'sumk' );
	return $columns;
}

function sumk_custom_column_content( $column, $post_id ) {
	if ( $column === 'icon' )
		echo '<img src="' . get_post_meta( $post_id, 'sumk_icon', true ) . '" width="32" height="32" />';
	elseif ( $column === 'shortcode' ) {
		echo '<code>[' . su_cmpt() . get_post_meta( $post_id, 'sumk_slug', true ) . ']</code>';
		if ( get_post_meta( $post_id, 'sumk_desc', true ) )
			echo '<p class="description">' . get_post_meta( $post_id, 'sumk_desc', true ) . '</p>';
	}
}

function sumk_post_row_actions( $actions, $p ) {
	if ( $p->post_status !== 'publish' || $p->post_type !== 'shortcodesultimate' ) return $actions;
	$shortcode = get_post_meta( $p->ID, 'sumk_slug', true );
	$actions['su_generator'] = Su_Generator::button( array(
			'target'    => '',
			'text'      => __( 'View shortcode', 'sumk' ),
			'class'     => '',
			'icon'      => false,
			'echo'      => false,
			'shortcode' => $shortcode
		) );
	unset( $actions['inline hide-if-no-js'] );
	return $actions;
}
