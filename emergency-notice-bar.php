<?php

/**
 * Plugin Name: Emergency Notice Bar
 * Plugin URI:	https://github.com/jdmdigital/
 * Description: Super-lightweight plugin adds an emergency notice bar for closures, updates, and more on your WordPress site globally, or only on the home page with just a few clicks.
 * Version:     1.0
 * Author:      JDM Digital
 * Author URI:  https://jdmdigital.co
 * License:     GPL2
 */


// If this file is called directly, abandon ship.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'JDM_NOTICEBAR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'JDM_NOTICEBAR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// == Enqueue Resources (CSS and JS) ==
if(!function_exists('jdm_noticebar_enqueued_assets')) {
	add_action( 'wp_enqueue_scripts', 'jdm_noticebar_enqueued_assets' );
	function jdm_noticebar_enqueued_assets() {
		//wp_enqueue_style(  'jdm-noticebar', JDM_NOTICEBAR_PLUGIN_URL . 'css/jdm-noticebar.css', array(), '', 'screen' );
		wp_enqueue_style(  'jdm-noticebar', JDM_NOTICEBAR_PLUGIN_URL . 'css/jdm-noticebar.min.css', array(), '', 'screen' );
	}
}

/* == Build Settings Page and Declare Options == 
 * @since v1.0
 */
require_once(JDM_NOTICEBAR_PLUGIN_PATH . 'settings.php');


require_once(JDM_NOTICEBAR_PLUGIN_PATH . 'handy-functions.php');

// Add Settings Link to Plugins >> Installed Plugins
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'jdmnoticebar_add_plugin_settings_link');
function jdmnoticebar_add_plugin_settings_link( $links ) {
	$links[] = '<a href="' .admin_url( 'options-general.php?page=jdm-noticebar' ) .'">' . __('Settings') . '</a>';
	return $links;
}

/* 
 * Randering the Markup for PRO  
 */
if(!function_exists('jdm_noticebar_markup_render')) {
	function jdm_noticebar_markup_render() {
		// Get Option Settings and Apply As-Needed
		
		$isGlobal = jdm_noticebar_is_global();
		$HTMLmessage =  get_option('noticeContent');
		$isDismissable = jdm_noticebar_isDismissible(); 
		$backgroundColor = jdm_noticebar_bgcolor();
		
		if(jdm_noticebar_is_enabled()) {
			// Enter the JS and CSS
			$markup = '
		<script>
			document.addEventListener("DOMContentLoaded", function(event) {
					document.querySelector("body").classList.add("jdm-notice-on");
			';
				if($isDismissable) {
					$markup .= '
						document.querySelector(".jdm-notice-close").addEventListener("click", function() {  
							document.querySelector("body").classList.remove("jdm-notice-on");
							document.querySelector(".jdm-notice-body").style.display = "none";
						});
					';	
				}
			$markup .= '
			});

		</script>
			';

			// Construct the Markup
			$markup .= '
			<!-- Emergency Notice Bar -->
			<div id="jdm-notice" class="jdm-notice-background'.jdm_noticebar_animation_class().'" role="alert" '.jdm_noticebar_inline_css().'>
				<div class="'.jdm_noticebar_container_class().' jdm-notice-body">';
			if($isDismissable) { 
			$markup .= '
					<div class="jdm-notice-content jdm-notice-dismissable">
						'.$HTMLmessage.'
						<button type="button" class="jdm-notice-close" aria-label="Close"><span aria-hidden="true">&times;</span><span class="screenreader">Close</span></button>
					</div>
						';
			} else {
			$markup .= '
					<div class="jdm-notice-content">
						'.$HTMLmessage.'
					</div>
						';
			}
			$markup .= '			
				</div>
			</div>
			<!-- END Emergency Notice Bar -->
			';

			return $markup;
		} // END if gen_notice_is_enabled()
	}
}

if(!function_exists('jdm_noticebar_add_to_footer')){
	function jdm_noticebar_add_to_footer(){
		if(jdm_noticebar_is_enabled()) {
			if(jdm_noticebar_is_global()){
				echo jdm_noticebar_markup_render();
			} elseif(is_home() || is_front_page()) {
				// Assuming IS enabled AND not global AND is_ home page
				echo jdm_noticebar_markup_render();
			}
		}
	}
	add_action( 'wp_footer', 'jdm_noticebar_add_to_footer' );
}


 