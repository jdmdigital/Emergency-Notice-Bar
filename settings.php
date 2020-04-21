<?php

// Build Settings Page and Declare Options
// @since v1.0

/*
 * Add Admin Menu for Settings
 */
function jdm_noticebar_plugin_setup_menu(){
	add_options_page( 'Emergency Notice Bar', 'Notice Bar', 'manage_options', 'jdm-noticebar', 'jdm_noticebar_settings' );
}
add_action('admin_menu', 'jdm_noticebar_plugin_setup_menu');


// jdm_check_color() for color validation
function jdm_check_color( $value ) { 
	if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #     
		return true;
	} else {
		return false;
	}
}

// Add Settings link under plugin description on WP Plugins Page
function jdm_noticebar_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .admin_url( 'options-general.php?page=jdm-noticebar' ) .'">' . __('Settings') . '</a>';
	return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'jdm_noticebar_add_plugin_page_settings_link');

/* custom JS for Settings Page
 * @since v1.0
 */
if(!function_exists('jdm_noticebar_settings_js')) {
	add_action('admin_enqueue_scripts', 'jdm_noticebar_settings_js');
	function jdm_noticebar_settings_js($hook) {
		/*if ( 'jdm-noticebar' != $hook && is_admin()) {
			return;
		} else {*/
			wp_enqueue_style( 'wp-color-picker' );
			//wp_enqueue_script('boot_js', plugins_url('js/gen-noticebar-settings.js',__FILE__ ));
			//wp_enqueue_script( 'jdm-noticebar', JDM_NOTICEBAR_PLUGIN_URL . 'js/jdm-noticebar-settings.js', array( 'jquery', 'wp-color-picker' ), '', true );
			wp_enqueue_script( 'jdm-noticebar-settings', plugins_url('js/jdm-noticebar-settings.js', __FILE__), array( 'jquery', 'wp-color-picker' ), false, true );
		/*}*/
	}
}

// Register our Settings
function jdm_noticebar_register_settings() {
		
	$jdm_noticebar_enabled_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'jdm_toggle_callback',
		'default' => NULL,
	);

	$jdm_noticebar_dismissible_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'jdm_toggle_callback',
		'default' => NULL,
	);
	
	$jdm_noticebar_global_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'jdm_toggle_callback',
		'default' => NULL,
	);
	
	$jdm_noticebar_bgcolor_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'jdm_color_callback',  or is it 'jdm_check_color'
		'default' => NULL,
	);
	
	$jdm_noticebar_top_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'jdm_toggle_callback',
		'default' => NULL,
	);
	
	$jdm_noticebar_width_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'jdm_toggle_callback',
		'default' => NULL,
	);
	
	$jdm_noticebar_animation_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'jdm_animation_callback',
		'default' => NULL,
	);
	
	$jdm_noticebar_animation_duration_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'jdm_animation_callback',
		'default' => NULL,
	);
	
	$jdm_noticebar_noticeContent_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'jdm_html_callback',
		'default' => NULL,
		'teeny' => true,
    	'textarea_rows' => 6,
		'media_buttons' => false
	);

	
	register_setting( 'jdm_noticebar_options_group', 'jdm_noticebar_enabled', $jdm_noticebar_enabled_args );
	register_setting( 'jdm_noticebar_options_group', 'jdm_noticebar_dismissible', $jdm_noticebar_dismissible_args );
	register_setting( 'jdm_noticebar_options_group', 'jdm_noticebar_global', $jdm_noticebar_global_args );
	register_setting( 'jdm_noticebar_options_group', 'jdm_noticebar_bgcolor', $jdm_noticebar_bgcolor_args );
	register_setting( 'jdm_noticebar_options_group', 'jdm_noticebar_top', $jdm_noticebar_top_args );
	register_setting( 'jdm_noticebar_options_group', 'jdm_noticebar_width', $jdm_noticebar_width_args );
	register_setting( 'jdm_noticebar_options_group', 'jdm_noticebar_animation', $jdm_noticebar_animation_args );
	register_setting( 'jdm_noticebar_options_group', 'jdm_noticebar_animation_duration', $jdm_noticebar_animation_duration_args );
	register_setting( 'jdm_noticebar_options_group', 'noticeContent', $jdm_noticebar_noticeContent_args);
}

add_action( 'admin_init', 'jdm_noticebar_register_settings' );





// Function for Creating Settings Page; last arg in add_options_page()
function jdm_noticebar_settings() {

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'Your user does not have access this page. Sorry about that.' ) );
	}

?>

<div class="wrap">
		
	<h1>Emergency Notice Bar</h1>
	<h2 style="margin-top:0; margin-bottom:2em; font-weight: normal;">By <a href="https://jdmdigital.co" target="_blank" rel="noopener">JDM Digital</a> | Want to say thanks? <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WED3F4H3Q35SW&source=url" title="Donate via PayPal" target="_blank" rel="noopener nofollow">Donate a couple bucks</a>.</h2>
	<?php //settings_errors(); ?>

	<form method="post" action="options.php">
		<?php settings_fields( 'jdm_noticebar_options_group' ); ?>
		<?php do_settings_sections( 'jdm_noticebar_options_group' ); ?>
		<p>Enter the content for the notice bar as well as your settings.  Once you're all set, choose <b>Enabled</b> under "Show the Notice?" to display the notice on your website.  Easy peezy.</p>
		<table class="form-table" role="presentation">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="jdm_noticebar_enabled">Show the Notice?</label></th>
					<td>
						<?php $jdmEnabled = esc_attr(get_option('jdm_noticebar_enabled', '0')); ?>
						<select name="jdm_noticebar_enabled">
							<option value="0"<?php if($jdmEnabled == '0') {echo ' selected'; } ?>>Disabled</option>
							<option value="1"<?php if($jdmEnabled == '1') {echo ' selected'; } ?>>Enabled</option>
						</select>
						<p class="description">Once you have all the notice content entered below, select <b>Enabled</b> from this dropdown and click <b>Save Changes</b> to display it on the website.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="jdm_noticebar_global">Show ONLY on the home page?</label></th>
					<td>
						<?php $jdmGlobal = esc_attr(get_option('jdm_noticebar_global', '1')); ?>
						<select name="jdm_noticebar_global">
							<option value="0"<?php if($jdmGlobal == '0') {echo ' selected'; } ?>>Home Page Only</option>
							<option value="1"<?php if($jdmGlobal == '1') {echo ' selected'; } ?>>Site-Wide</option>
						</select>
						<p class="description">Select "Home Page Only" to display the notice only on the home page.  To show it globally (every page), select "Site-Wide."</p>
					</td>
				</tr>
				<tr valign="top">
					<td colspan="2" style="padding-left:0">
						<label for="noticeContent"><b>Notice Content</b></label>
						<?php $content1 = get_option('noticeContent',''); ?>
						<?php wp_editor( $content1, 'noticeContent', $settings = array('textarea_rows'=> '6','media_buttons' => false) ); ?>
						<p class="description">Type the content you would like displayed in the notice bar.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="jdm_noticebar_dismissible">Make it Dismissable?</label></th>
					<td>
						<?php $jdmDismissable = esc_attr(get_option('jdm_noticebar_dismissible', '1')); ?>
						<select name="jdm_noticebar_dismissible">
							<option value="0"<?php if($jdmDismissable == '0') {echo ' selected'; } ?>>No, Persistant</option>
							<option value="1"<?php if($jdmDismissable == '1') {echo ' selected'; } ?>>Yes, Dismissable</option>
						</select>
						<p class="description">Select "Yes, Dismissable" to allow users to close it temporarily (until they refresh the page).</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="jdm_noticebar_width">Select Width</label></th>
					<td>
						<?php $jdmWidth = esc_attr(get_option('jdm_noticebar_width', '0')); ?>
						<select name="jdm_noticebar_width">
							<option value="0"<?php if($jdmWidth == '0') {echo ' selected'; } ?>>100% Wide</option>
							<option value="1"<?php if($jdmWidth == '1') {echo ' selected'; } ?>>Max-Width</option>
						</select>
						<p class="description">Choose "Max Width" if you want the content to go only partially across the screen.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="jdm_noticebar_top">Select its Position</label></th>
					<td>
						<?php $jdmTop = esc_attr(get_option('jdm_noticebar_top', '1')); ?>
						<select name="jdm_noticebar_top">
							<option value="0"<?php if($jdmTop == '0') {echo ' selected'; } ?>>Bottom</option>
							<option value="1"<?php if($jdmTop == '1') {echo ' selected'; } ?>>Top</option>
						</select>
						<p class="description">Choose if you want the emergency notice bar to be at the top or bottom of the site.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="jdm_noticebar_animation">Select Animation</label></th>
					<td>
						<?php $jdmAnimation = esc_attr(get_option('jdm_noticebar_animation', '0')); ?>
						<select name="jdm_noticebar_animation">
							<option value="0"<?php if($jdmAnimation == '0') {echo ' selected'; } ?>>No Animation</option>
							<option value="1"<?php if($jdmAnimation == '1') {echo ' selected'; } ?>>Fade In</option>
							<option value="2"<?php if($jdmAnimation == '2') {echo ' selected'; } ?>>Fade In and Down</option>
							<option value="3"<?php if($jdmAnimation == '3') {echo ' selected'; } ?>>Fade In and Up</option>
						</select>
						<p class="description">Choose an animation you'd like for the notice bar.  Credit: <a href="https://daneden.github.io/animate.css/" target="_blank" rel="noopener nofollow">Animate.css</a>.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="jdm_noticebar_animation_duration">Select Animation Duration</label></th>
					<td>
						<?php $jdmAnimationDuration = esc_attr(get_option('jdm_noticebar_animation_duration', '0')); ?>
						<select name="jdm_noticebar_animation_duration">
							<option value="0"<?php if($jdmAnimationDuration == '0') {echo ' selected'; } ?>>0 Seconds</option>
							<option value="1"<?php if($jdmAnimationDuration == '1') {echo ' selected'; } ?>>1 Second</option>
							<option value="2"<?php if($jdmAnimationDuration == '2') {echo ' selected'; } ?>>2 Seconds</option>
							<option value="3"<?php if($jdmAnimationDuration == '3') {echo ' selected'; } ?>>3 Seconds</option>
						</select>
						<p class="description">How long should the animation last?</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="jdm_noticebar_bgcolor">Choose a Background Color</label></th>
					<td>
						<?php $jdmBg = get_option('jdm_noticebar_bgcolor', '#007cba'); ?>
						<input name="jdm_noticebar_bgcolor" type="text" class="jdm-color-picker" value="<?php echo $jdmBg; ?>" />
						<p class="description">Select a background color or paste the HEX code here.</p>
					</td>
				</tr>
			</tbody>
  		</table>
  		<?php submit_button('Save Changes'); ?>
	</form>
	<p>If you have any trouble, please don't hesitate to contact us via the GitHub repo or via the WordPress.org support forums.</p>
	<p>Wanna make our day? Consider <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WED3F4H3Q35SW&source=url" title="Donate via PayPal" target="_blank" rel="noopener nofollow">donating a couple bucks</a> via PayPal.</p>
</div>

	

<?php 

}







