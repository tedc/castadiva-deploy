<?php
/**
 * Show Shortcodes Ultimate notice
 */
function sumk_su_notice() {
	global $sumk;
?>
		<div class="updated">
			<p><?php _e( 'Please install and activate latest version of <b>Shortcodes Ultimate</b> to use it\'s addon <b>Shortcodes Ultimate: Maker</b>.<br />Deactivate this addon to hide message.', $sumk->textdomain ); ?></p>
			<p><a href="<?php echo admin_url( 'plugin-install.php?tab=plugin-information&plugin=shortcodes-ultimate' ); ?>" onClick="document.getElementById('sumk_su_install_iframe').style.display='block';this.style.display='none';return false;" target="_blank" class="button button-primary"><?php _e( 'Install Sortcodes Ultimate', $sumk->textdomain ); ?> &rarr;</a></p>
			<iframe src="<?php echo admin_url( 'plugin-install.php?tab=plugin-information&plugin=shortcodes-ultimate' ); ?>" id="sumk_su_install_iframe" style="display:none;width:100%;height:600px;margin-top:1em;overflow:auto;border:none"></iframe>
		</div>
	<?php
}
