<?php
function sumk_help_popup() {
	global $sumk;
?>
		<div id="sumk-attributes-help" class="mfp-hide sumk-help-popup">
			<h3><?php _e( 'Short name (slug)', $sumk->textdomain ); ?></h3>
			<p><?php _e( 'Allowed characters: a-z, 0-9, \'_\' (underscore). Enter attribute name that will be used in resulting shortcode. For example: if you type \'style\', you will get next shortcode [shortcode style=""].', $sumk->textdomain ); ?></p>
			<h3><?php _e( 'Default value', $sumk->textdomain ); ?></h3>
			<p><?php _e( 'Enter default value for attribute. This value will be used in shortcode if value not specified. Also, this value will be selected by default in shortcode generator.', $sumk->textdomain ); ?></p>
			<h3><?php _e( 'Field type', $sumk->textdomain ); ?></h3>
			<p><?php _e( 'You can use different attribute field types to make use of the shortcode easier. Field types will be used in shortcode generator window (Insert shortcode button at post editing screen).', $sumk->textdomain ); ?></p>
			<h4><?php _e( 'Text', $sumk->textdomain ); ?></h4>
			<p><?php _e( 'Simple text field. Specified default value will be used as plain text in this field.', $sumk->textdomain ); ?></p>
			<h4><?php _e( 'Number', $sumk->textdomain ); ?></h4>
			<p><?php _e( 'Integer value. You can specify minimum and maximum values available in this field and step size.', $sumk->textdomain ); ?></p>
			<h4><?php _e( 'Color', $sumk->textdomain ); ?></h4>
			<p><?php _e( 'Color picker. Please set default value with # symbol in beginning. For example: #ffcc00 (yellow), #000 (black).', $sumk->textdomain ); ?></p>
			<h4><?php _e( 'Dropdown', $sumk->textdomain ); ?></h4>
			<p><?php _e( 'Dropdown list. You can enter unlimited options for this list in special field "Dropdown options". Use next format:', $sumk->textdomain ); ?></p>
			<p><textarea class="code large-text sumk-click2select" rows="3"><?php echo sprintf( "red|%s\nblue|%s\ngreen|%s", __( 'Red color', 'sumk' ), __( 'Blue color', 'sumk' ), __( 'Green color', 'sumk' ) ); ?></textarea></p>
			<p><?php _e( 'Use option value (not label) to specify default selected value. For example: \'red\'', $sumk->textdomain ) ?></p>
			<h4><?php _e( 'Switch', $sumk->textdomain ); ?></h4>
			<p><?php _e( 'This field works like a check box. It allows you to select the Yes or No option when creating a shortcode. As a default value, use \'yes\' or \'no\'.', $sumk->textdomain ); ?></p>
			<h4><?php _e( 'Upload', $sumk->textdomain ); ?></h4>
			<p><?php _e( 'This field allows you to upload files from computer and use uploaded file link as value.', $sumk->textdomain ); ?></p>
		</div>
		<div id="sumk-code-editor-help" class="mfp-hide sumk-help-popup">
			<h3><?php _e( 'HTML mode', $sumk->textdomain ); ?></h3>
			<p><?php _e( 'In this mode, you can only use HTML code and a specific set of variables. The set of variables depends on the added attributes. For example, if you add the attribute \'color\', you can use the variable {{color}} in your code. Independently of added attributes, you can use the variable {{content}}, which will be replaced by the contents of the shortcode (the text between the opening and closing shortcode tags).', $sumk->textdomain ); ?></p>
			<h4><?php _e( 'Example code', $sumk->textdomain ); ?></h4>
			<p><textarea class="large-text sumk-click2select" rows="3"><?php echo esc_html( '<span style="color: {{color}}">{{content}}</span>' ); ?></textarea></p>
			<h3><?php _e( 'PHP return', $sumk->textdomain ); ?></h3>
			<p><?php _e( 'This mode is a bit complicated than the previous. Using this mode, you need to write code in PHP. The output of the code must be returned, but not displayed. To do this, use \'return\' operator. In this mode you can not use functions such as print_r, echo or die. If you do not understand the difference between the return and echo in PHP, then better to use the HTML mode or PHP echo.', $sumk->textdomain ); ?></p>
			<p><?php _e( 'All added attributes are available as variables. For example, if you add an attribute with short name \'color\', then the code can use a variable named $color. Variable $content will contain actual shortcode content (the text between the opening and closing shortcode tags).', $sumk->textdomain ); ?></p>
			<h4><?php _e( 'Example code', $sumk->textdomain ); ?></h4>
			<p><textarea class="large-text sumk-click2select" rows="3"><?php echo esc_html( 'return \'<span style="color: \' . $color . \'">\' . $content . \'</span>\';' ); ?></textarea></p>
			<h3><?php _e('PHP echo', $sumk->textdomain); ?></h3>
			<p><?php _e('This mode is similar to the previous (PHP return). However, in this mode you can use any of the functions and operators that display text. It is recommended to use the echo statement to output the code. All attributes are available as variables.', $sumk->textdomain); ?></p>
			<h4><?php _e( 'Example code', $sumk->textdomain ); ?></h4>
			<p><textarea class="large-text sumk-click2select" rows="3"><?php echo esc_html( 'echo \'<span style="color: \' . $color . \'">\' . $content . \'</span>\';' ); ?></textarea></p>
		</div>
	<?php
}
