<?php
function sumk_register_metabox() {
	global $sumk;
	add_meta_box( 'a-sumk-metabox', __( 'Shortcode details', $sumk->textdomain ), 'sumk_metabox', 'shortcodesultimate', 'normal', 'high' );
	// Print attribute template
	add_action( 'admin_footer', 'sumk_tmpl_attribute' );
	// Remove Page Builder metabox and it's assets
	remove_meta_box( 'so-panels-panels', 'shortcodesultimate', 'advanced' );
	remove_action( 'admin_print_scripts-post-new.php', 'siteorigin_panels_admin_enqueue_scripts' );
	remove_action( 'admin_print_scripts-post.php', 'siteorigin_panels_admin_enqueue_scripts' );
	remove_action( 'admin_print_styles-post-new.php', 'siteorigin_panels_admin_enqueue_styles' );
	remove_action( 'admin_print_styles-post.php', 'siteorigin_panels_admin_enqueue_styles' );
	add_action( 'admin_head', 'sumk_remove_ace', 99 );
}

function sumk_remove_ace() {
	wp_deregister_script( 'acejs' );
	wp_deregister_script( 'aceinit' );
}

function sumk_metabox( $post ) {
	global $sumk;
	$icon = ( get_post_meta( $post->ID, 'sumk_icon', true ) ) ? get_post_meta( $post->ID, 'sumk_icon', true ) : str_replace( rtrim( get_bloginfo( 'url' ), '/' ), '', plugins_url( 'assets/images/default-icon.png', SUMK_PLUGIN_FILE ) );
?>
	<div class="sumk-req-fields-message error hide-if-js">
		<p><?php _e( 'Please fill all required fields. They marked with red asterisk.', $sumk->textdomain ); ?></p>
	</div>
	<div class="sumk-field sumk-req-field misc-pub-section">
		<p><label for="sumk-name-field"><?php _e( 'Shortcode name', $sumk->textdomain ); ?></label></p>
		<p><input class="widefat" type="text" name="sumk_name" value="<?php echo get_post_meta( $post->ID, 'sumk_name', true ); ?>" id="sumk-name-field" /></p>
		<p class="description"><?php _e( 'Enter shortcode name (1-2 words)', $sumk->textdomain ); ?></p>
	</div>
	<div class="sumk-field sumk-req-field misc-pub-section">
		<p><label for="sumk-slug-field"><?php _e( 'Short name (slug)', $sumk->textdomain ); ?></label></p>
		<p><input class="widefat" type="text" name="sumk_slug" value="<?php echo get_post_meta( $post->ID, 'sumk_slug', true ); ?>" id="sumk-slug-field" /></p>
		<p class="description"><?php _e( 'Allowed characters: a-z, 0-9, \'_\' (underscore)', $sumk->textdomain ); ?></p>
		<p class="description"><?php _e( 'Specify short name for this shortcode. This name will be used for resulting shortcode. For example: type \'div\' and you will get shortcode [div]', $sumk->textdomain ); ?></p>
	</div>
	<div class="sumk-field misc-pub-section">
		<p><label for="sumk-desc-field"><?php _e( 'Shortcode description', $sumk->textdomain ); ?></label></p>
		<p><textarea class="large-text" name="sumk_desc" id="sumk-desc-field" cols="30" rows="3"><?php echo get_post_meta( $post->ID, 'sumk_desc', true ); ?></textarea></p>
		<p class="description"><?php _e( 'Enter short description for this shortcode. 3-7 words is more than enough', $sumk->textdomain ); ?></p>
	</div>
	<div class="sumk-field misc-pub-section">
		<p><label for="sumk-content-field"><?php _e( 'Default content', $sumk->textdomain ); ?></label></p>
		<p><textarea class="large-text" name="sumk_content" id="sumk-content-field" cols="30" rows="3"><?php echo get_post_meta( $post->ID, 'sumk_content', true ); ?></textarea></p>
		<p class="description"><?php _e( 'This text will be added to Content field in shortcode generator. This field is not required and used not by all shortcodes. Content of this field will be placed between open and close shortcode tags by default', $sumk->textdomain ); ?></p>
	</div>
	<div class="sumk-field sumk-field-icon misc-pub-section">
		<p><label for="sumk-icon-field"><?php _e( 'Icon', $sumk->textdomain ); ?></label></p>
		<p>
			<img src="<?php echo $icon; ?>" alt="" width="32" height="32" />
			<a href="javascript:;" class="button"><?php _e( 'Change icon', 'sumk' ); ?></a>
			<input type="hidden" name="sumk_icon" value="<?php echo $icon; ?>" />
		</p>
		<p class="description"><?php _e( 'You can change shortcode icon. This icon will be used in shortcode generator window', $sumk->textdomain ); ?></p>
	</div>
	<div class="sumk-field sumk-field-attributes misc-pub-section">
		<p><label><?php _e( 'Attributes', $sumk->textdomain ); ?></label><a class="alignright button button-small button-primary sumk-help-button" href="#sumk-attributes-help" title="<?php _e( 'Open attributes documentation', $sumk->textdomain ); ?>">?</a></p>
		<p><a class="button button-small sumk-add-attribute" href="#"><?php _e( 'Add attribute', $sumk->textdomain ); ?></a><small class="description alignright"><?php _e( 'Drag and drop attributes to re-order', $sumk->textdomain ); ?></small></p>
		<div class="sumk-attributes"><?php foreach ( sumk_get_atts( $post->ID ) as $i => $att ) sumk_attribute( $i, $att ); ?></div>
	</div>
	<div class="sumk-field sumk-req-field sumk-clearfix misc-pub-section">
		<p><label for="sumk-code-field"><?php _e( 'Code', $sumk->textdomain ); ?></label><a class="alignright button button-small button-primary sumk-help-button" href="#sumk-code-editor-help" title="<?php _e( 'Open code editor documentation', $sumk->textdomain ); ?>">?</a></p>
		<p class="sumk-code-type"><?php
	$code_types = array(
		'html'       => __( 'HTML mode', $sumk->textdomain ),
		'php_return' => __( 'PHP return', $sumk->textdomain ),
		'php_echo'   => __( 'PHP echo', $sumk->textdomain )
	);
	$code_type_meta = get_post_meta( $post->ID, 'sumk_code_type', true );
	$code_type = ( $code_type_meta && in_array( $code_type_meta, array_keys( $code_types ) ) ) ? $code_type_meta : 'html';
	foreach ( $code_types as $type => $label ) {
		?><label for="sumk-code-type-<?php echo $type; ?>"><input type="radio" name="sumk_code_type" value="<?php echo $type; ?>" id="sumk-code-type-<?php echo $type; ?>" <?php echo ( $code_type === $type ) ? 'checked' : ''; ?> /> <?php echo $label; ?></label><?php
	}
	?></p>
		<p class="sumk-variables description"><?php _e( 'You can use next variables', $sumk->textdomain ); ?>: <span title="<?php _e( 'click to insert variable', $sumk->textdomain ); ?>"></span><br /><?php _e( 'They will be replaced with shortcode content and attributes values', $sumk->textdomain ); ?></p>
		<p><textarea class="large-text code" name="sumk_code" id="sumk-code-field" cols="30" rows="10"><?php echo get_post_meta( $post->ID, 'sumk_code', true ); ?></textarea></p>
			<div id="sumk-code-field-editor"></div>
	</div>
	<div class="sumk-field sumk-clearfix misc-pub-section">
		<?php
	global $post;
	if ( $post->post_status === 'publish' ) {
		?><p class="alignright"><input name="save" type="submit" class="button button-primary button-large" id="save" accesskey="p" value="<?php _e( 'Update shortcode', 'sumk' ); ?>" /></p><?php
	} else {
		?><p class="alignright"><input name="save" type="submit" class="button button-large" id="save" accesskey="p" value="<?php _e( 'Save draft', 'sumk' ); ?>" />&nbsp;&nbsp;<input name="publish" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="<?php _e( 'Publish', 'sumk' ); ?>" /></p><?php
	}
?>
	</div>
	<input type="hidden" name="sumk_nonce" value="<?php wp_create_nonce( $sumk->file ); ?>" />
	<?php
}

function sumk_attribute( $i = 0, $args = array() ) {
	global $sumk;
	$args = wp_parse_args( $args, array(
			'slug'    => '',
			'default' => '',
			'type'    => 'text',
			'name'    => '',
			'desc'    => '',
			'options' => '',
			'min'     => 0,
			'max'     => 100,
			'step'    => 1
		) );
	// Prepare classes
	$class = array( 'sumk-attribute', 'sumk-attribute-type-' . $args['type'] );
	if ( !empty( $args['name'] ) || !empty( $args['desc'] ) ) $class[] = 'sumk-attribute-detailed';
?>
		<div class="<?php echo implode( ' ', $class ); ?>">
			<div class="sumk-attr-head">
				<em class="sumk-attr-prefix"></em><strong><?php echo $args['slug']; ?></strong><em
				class="sumk-attr-postfix"></em> <span><?php _e( 'Delete', $sumk->textdomain ); ?></span> <a href="#"
				class="sumk-attr-open"><?php _e( 'Edit', $sumk->textdomain ); ?></a> <a href="#"
				class="sumk-attr-close"><?php _e( 'Close', $sumk->textdomain ); ?></a>
			</div>
			<div class="sumk-attr-form sumk-clearfix">
				<div class="sumk-attr-main sumk-clearfix">
					<div>
						<label for="sumk-attr-<?php echo $i; ?>-slug"><?php _e( 'Short name (slug)', $sumk->textdomain ); ?></label>
						<br />
						<input type="text" name="sumk_attr[<?php echo $i; ?>][slug]"
						value="<?php echo $args['slug']; ?>" placeholder="attribute_name"
						id="sumk-attr-<?php echo $i; ?>-slug" class="sumk-attribute-slug-value" />
					</div>
					<div>
						<label for="sumk-attr-<?php echo $i; ?>-default"><?php _e( 'Default value', $sumk->textdomain ); ?></label>
						<br />
						<input type="text" name="sumk_attr[<?php echo $i; ?>][default]"
						value="<?php echo $args['default']; ?>" placeholder="default_value"
						id="sumk-attr-<?php echo $i; ?>-default" />
					</div>
					<div>
						<label for="sumk-attr-<?php echo $i; ?>-type"><?php _e( 'Field type', $sumk->textdomain ); ?></label>
						<br />
						<select name="sumk_attr[<?php echo $i; ?>][type]" id="sumk-attr-<?php echo $i; ?>-type" class="sumk-attribute-type-select">
							<?php
	foreach ( sumk_get_types() as $type => $label ) {
		$selected = ( $type === $args['type'] ) ? ' selected' : '';
		echo '<option value="' . $type . '"' . $selected . '>' . $label . '</option>';
	}
?>
						</select>
					</div>
				</div>
				<div class="sumk-attr-additional sumk-attr-detailed-settings sumk-clearfix">
					<div>
						<label for="sumk-attr-<?php echo $i; ?>-name"><?php _e( 'Attribute name', $sumk->textdomain ); ?></label>
						<br />
						<input type="text" name="sumk_attr[<?php echo $i; ?>][name]"
						value="<?php echo $args['name']; ?>"
						placeholder="<?php _e( 'Attribute name', $sumk->textdomain ); ?>"
						id="sumk-attr-<?php echo $i; ?>-name" />
					</div>
					<div style="width:66.66%">
						<label for="sumk-attr-<?php echo $i; ?>-desc"><?php _e( 'Attribute description', $sumk->textdomain ); ?></label>
						<br />
						<input type="text" name="sumk_attr[<?php echo $i; ?>][desc]"
						value="<?php echo $args['desc']; ?>"
						placeholder="<?php _e( 'Attribute description', $sumk->textdomain ); ?>"
						id="sumk-attr-<?php echo $i; ?>-desc" />
					</div>
				</div>
				<div class="sumk-attr-additional sumk-attr-select-settings">
					<label for="sumk-attr-<?php echo $i; ?>-options"><?php _e( 'Dropdown options', $sumk->textdomain ); ?></label>
					<br />
					<textarea name="sumk_attr[<?php echo $i; ?>][options]" id="sumk-attr-<?php echo $i; ?>-options"
						placeholder="value|Option name"
						class="code large-text"
						rows="5"><?php echo $args['options']; ?></textarea>
					</div>
					<div class="sumk-attr-additional sumk-attr-number-settings sumk-clearfix">
						<div>
							<label for="sumk-attr-<?php echo $i; ?>-min"><?php _e( 'Minimal value', $sumk->textdomain ); ?></label>
							<br />
							<input type="number" name="sumk_attr[<?php echo $i; ?>][min]"
							value="<?php echo $args['min']; ?>" id="sumk-attr-<?php echo $i; ?>-min" />
						</div>
						<div>
							<label for="sumk-attr-<?php echo $i; ?>-max"><?php _e( 'Maximal value', $sumk->textdomain ); ?></label>
							<br />
							<input type="number" name="sumk_attr[<?php echo $i; ?>][max]"
							value="<?php echo $args['max']; ?>" id="sumk-attr-<?php echo $i; ?>-max" />
						</div>
						<div>
							<label for="sumk-attr-<?php echo $i; ?>-step"><?php _e( 'Step number', $sumk->textdomain ); ?></label>
							<br />
							<input type="number" name="sumk_attr[<?php echo $i; ?>][step]"
							value="<?php echo $args['step']; ?>" id="sumk-attr-<?php echo $i; ?>-step" />
						</div>
					</div>
					<p class="sumk-attr-toggle-details"><a href="#"><?php _e( 'Add full name and description', $sumk->textdomain ); ?></a>
					<small class="description">(<?php _e( 'not required but recommended', $sumk->textdomain ); ?>)
					</small>
				</p>
			</div>
		</div>
		<?php
}

function sumk_tmpl_attribute() {
	echo '<script type="text/html" id="sumk_tmpl_attribute">';
	sumk_attribute();
	echo '</script>';
}

function sumk_save( $post_id ) {
	global $sumk;
	// Check post ID
	if ( !is_numeric( $post_id ) ) return $post_id;
	// Verify nonce
	if ( isset( $_POST['sumk_nonce'] ) && wp_verify_nonce( $_POST['sumk_nonce'], $sumk->file ) ) return $post_id;
	// Check post type
	if ( get_post_type( $post_id ) !== 'shortcodesultimate' ) return $post_id;
	// Save name
	if ( isset( $_POST['sumk_name'] ) ) {
		remove_action( 'save_post', 'sumk_save' );
		wp_update_post( array( 'ID' => $post_id, 'post_title' => sanitize_text_field( $_POST['sumk_name'] ) ) );
		add_action( 'save_post', 'sumk_save' );
		update_post_meta( $post_id, 'sumk_name', sanitize_text_field( $_POST['sumk_name'] ) );
	}
	// Save slug
	if ( isset( $_POST['sumk_slug'] ) || !empty( $_POST['sumk_slug'] ) ) {
		$slug = sumk_sanitize_slug( $_POST['sumk_slug'] );
		if ( !$slug ) $slug = sumk_sanitize_slug( $_POST['sumk_name'] );
		if ( !$slug ) $slug = sumk_sanitize_slug( 'shortcode_' . $post_id );
		update_post_meta( $post_id, 'sumk_slug', $slug );
	}
	// Save description
	if ( isset( $_POST['sumk_desc'] ) ) update_post_meta( $post_id, 'sumk_desc', sanitize_text_field( $_POST['sumk_desc'] ) );
	// Save default content
	if ( isset( $_POST['sumk_content'] ) ) update_post_meta( $post_id, 'sumk_content', esc_textarea( $_POST['sumk_content'] ) );
	// Save icon
	if ( isset( $_POST['sumk_icon'] ) && !empty( $_POST['sumk_icon'] ) ) update_post_meta( $post_id, 'sumk_icon', sanitize_text_field( $_POST['sumk_icon'] ) );
	// Save attributes
	if ( isset( $_POST['sumk_attr'] ) && !empty( $_POST['sumk_attr'] ) ) {
		$atts = $_POST['sumk_attr'];
		$attributes = array();
		foreach ( $atts as $att ) {
			$new = array(
				'name'    => sanitize_text_field( $att['name'] ),
				'desc'    => esc_textarea( $att['desc'] ),
				'slug'    => sumk_sanitize_slug( $att['slug'] ),
				'default' => esc_textarea( $att['default'] ),
				'type'    => ( in_array( $att['type'], array_keys( sumk_get_types() ) ) ) ? $att['type'] : 'text',
				'options' => esc_html( strip_tags( $att['options'] ) ),
				'min'     => ( is_numeric( $att['min'] ) ) ? $att['min'] : 0,
				'max'     => ( is_numeric( $att['max'] ) ) ? $att['max'] : 100,
				'step'    => ( is_numeric( $att['step'] ) ) ? $att['step'] : 1
			);
			// Check default value for different field types
			switch ( $new['type'] ) {
			case 'number':
				$new['default'] = ( is_numeric( $new['default'] ) ) ? $new['default'] : 1;
				break;
			case 'color':
				$new['default'] = ( sumk_is_hex( $new['default'] ) ) ? sanitize_text_field( $new['default'] ) : '#ffffff';
				break;
			case 'bool':
				$new['default'] = ( in_array( strtolower( $new['default'] ), array( 'yes', 'no' ) ) ) ? sumk_sanitize_slug( $new['default'] ) : 'no';
				break;
			}
			// Add attribute if slug defined
			if ( !empty( $new['slug'] ) ) $attributes[] = $new;
		}
		delete_post_meta( $post_id, 'sumk_attr' );
		update_post_meta( $post_id, 'sumk_attr', base64_encode( serialize( $attributes ) ) );
	}
	else update_post_meta( $post_id, 'sumk_attr', base64_encode( serialize( array() ) ) );
	// Save code type
	if ( isset( $_POST['sumk_code_type'] ) ) update_post_meta( $post_id, 'sumk_code_type', sanitize_key( $_POST['sumk_code_type'] ) );
	// Save code
	if ( isset( $_POST['sumk_code'] ) ) {
		$code = $_POST['sumk_code'];
		// Clean up html code
		if ( isset( $_POST['sumk_code_type'] ) && $_POST['sumk_code_type'] === 'html' ) {
			$code = str_replace( array( '<?php', '<?=', '<?', '?>' ), '', $code );
		}
		// Clean up PHP return code
		elseif ( isset( $_POST['sumk_code_type'] ) && $_POST['sumk_code_type'] === 'php_return' ) {
			$code = str_replace( array( '<?php', '<?=', '<?', '?>' ), '', $code );
			$code = str_replace( array( 'echo', 'die', 'var_dump' ), 'return', $code );
		}
		update_post_meta( $post_id, 'sumk_code', esc_html( $code ) );
	}
	// Clear generator cache
	delete_transient( 'su/generator/popup' );
	if ( isset( $slug ) ) delete_transient( 'su/generator/settings/' . $slug );
	return $post_id;
}
