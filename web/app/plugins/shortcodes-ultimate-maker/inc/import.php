<?php
function sumk_import_demo() {
	$option = 'sumk_demo_imported';
	if ( get_option( $option ) || !function_exists('shortcodes_ultimate') ) return;
	global $sumk;
	$data = array( array(
			'post_title' => __( 'Demo shortcode #1: HTML code example', $sumk->textdomain ),
			'post_type' => 'shortcodesultimate',
			'post_status' => 'publish',
			'post_date' => date( 'Y-m-d H:i:03' ),
			'meta' => array(
				'name' => __( 'Demo shortcode #1: HTML code example', $sumk->textdomain ),
				'slug' => 'demo_shortcode_1',
				'desc' => __( 'This shortcode written with simple HTML and allows you to change the color of selected text', $sumk->textdomain ),
				'content' => __( 'Default content', $sumk->textdomain ),
				'icon' => $sumk->assets( 'images', 'demo-1.png' ),
				'attr' => serialize( array( array(
							'name' => __( 'Text color', $sumk->textdomain ),
							'desc' => __( 'Color of selected text', $sumk->textdomain ),
							'slug' => 'color',
							'default' => '#ff3333',
							'type' => 'color' ) ) ),
				'code_type' => 'html',
				'code' => esc_html( "<span style=\"color: {{color}}\">{{content}}</span>" )
			) ),
		array(
			'post_title' => __( 'Demo shortcode #2: PHP return code example', $sumk->textdomain ),
			'post_type' => 'shortcodesultimate',
			'post_status' => 'publish',
			'post_date' => date( 'Y-m-d H:i:02' ),
			'meta' => array(
				'name' => __( 'Demo shortcode #2: PHP return code example', $sumk->textdomain ),
				'slug' => 'demo_shortcode_2',
				'desc' => __( 'This shortcode does the same thing as a shortcode #1 but written in PHP and uses PHP return mode',
					$sumk->textdomain ),
				'content' => __( 'Default content', $sumk->textdomain ),
				'icon' => $sumk->assets( 'images', 'demo-2.png' ),
				'attr' => serialize( array( array(
							'name' => __( 'Text color', $sumk->textdomain ),
							'desc' => __( 'Color of selected text', $sumk->textdomain ),
							'slug' => 'color',
							'default' => '#ff3333',
							'type' => 'color' ) ) ),
				'code_type' => 'php_return',
				'code' => esc_html( 'return \'<span style="color: \' . $color . \'">\' . $content . \'</span>\';' )
			) ),
		array(
			'post_title' => __( 'Demo shortcode #3: PHP echo code example', $sumk->textdomain ),
			'post_type' => 'shortcodesultimate',
			'post_status' => 'publish',
			'post_date' => date( 'Y-m-d H:i:01' ),
			'meta' => array(
				'name' => __( 'Demo shortcode #3: PHP echo code example', $sumk->textdomain ),
				'slug' => 'demo_shortcode_3',
				'desc' => __( 'This shortcode is more complex than shortcodes #1 and #2. This example will show you how to use PHP echo mode, as well as how to use several different types of attributes',
					$sumk->textdomain ),
				'content' => __( 'Default content', $sumk->textdomain ),
				'icon' => $sumk->assets( 'images', 'demo-3.png' ),
				'attr' => serialize( array( array(
							'name' => __( 'Style', $sumk->textdomain ),
							'desc' => __( 'Select box style', $sumk->textdomain ),
							'slug' => 'style',
							'default' => 'success',
							'type' => 'select',
							'options' => sprintf( "info|%s\nerror|%s\nsuccess|%s", __( 'Info', $sumk->textdomain ), __( 'Error', $sumk->textdomain ), __( 'Success', $sumk->textdomain ) )
						), array(
							'name' => __( 'Size', $sumk->textdomain ),
							'desc' => __( 'Choose box size', $sumk->textdomain ),
							'slug' => 'size',
							'default' => 3,
							'type' => 'number',
							'min' => 1,
							'max' => 10,
							'step' => 1
						)
					) ),
				'code_type' => 'php_echo',
				'code' => esc_html( '$styles = array(\'info\', \'error\', \'success\');' . "\n" . '$colors = array(\'#09c\', \'#f03\', \'#6c3\');' . "\n" . '$color = str_replace($styles, $colors, $style);' . "\n" . '$size = round($size * 1.4 + 9);' . "\n" . 'echo \'<div style="background: \' . su_hex_shift($color, \'lighter\', 40) . \';color:\' . su_hex_shift($color, \'darker\', 40) . \';font-size:\' . $size . \'px;margin:0 0 1.5em;padding:\' . $size . \'px">\' . $content . \'</div>\';' )
			) )
	);

	// Insert new posts
	foreach ( $data as $post ) {
		$post_id = wp_insert_post( $post );
		foreach ( $post['meta'] as $key => $val ) update_post_meta( $post_id, 'sumk_' . $key, $val );
	}
	add_action( 'admin_notices', 'sumk_demo_imported' );
	update_option( $option, true );
}

function sumk_demo_imported() {
	global $sumk;
?>
	<div class="updated">
		<p><strong>
			<?php _e( '3 demo shortcodes added to the database', $sumk->textdomain ); ?>.
			<a href="<?php echo admin_url( 'edit.php?post_type=shortcodesultimate' ); ?>"><?php _e( 'View', $sumk->textdomain ); ?></a>
		</strong></p>
	</div>
	<?php
}
