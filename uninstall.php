<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
delete_option('jdm_noticebar_enabled');
delete_option('jdm_noticebar_dismissible');
delete_option('jdm_noticebar_global');
delete_option('jdm_noticebar_bgcolor');
delete_option('jdm_noticebar_top');
delete_option('jdm_noticebar_width');
delete_option('jdm_noticebar_animation');
delete_option('jdm_noticebar_animation_duration');
delete_option('noticeContent');
 
// for site options in Multisite
//delete_site_option($option_name);
 