<?php
/* 
 * Handy Plugin Functions Here
 */

if(!function_exists('jdm_noticebar_is_enabled')){
	function jdm_noticebar_is_enabled() {
		$isEnabled = esc_attr(get_option('jdm_noticebar_enabled', '0'));
		if($isEnabled == '1'){
			return true;
		} else {
			return false;
		}
	}
}

if(!function_exists('jdm_noticebar_isDismissible')){
	function jdm_noticebar_isDismissible() {
		$isDismissible = esc_attr(get_option('jdm_noticebar_dismissible', '0'));
		if($isDismissible == '1'){
			return true;
		} else {
			return false;
		}
	}
}

if(!function_exists('jdm_noticebar_isTop')){
	function jdm_noticebar_isTop() {
		$isTop = esc_attr(get_option('jdm_noticebar_top', '1'));
		if($isTop == '1'){
			return true;
		} else {
			return false;
		}
	}
}

if(!function_exists('jdm_noticebar_is_global')){
	function jdm_noticebar_is_global() {
		$isGlobal = esc_attr(get_option('jdm_noticebar_global', '1'));
		if($isGlobal == '1'){
			return true;
		} else {
			return false;
		}
	}
}

if(!function_exists('jdm_noticebar_is_fullwidth')){
	function jdm_noticebar_is_fullwidth() {
		$isFull = esc_attr(get_option('jdm_noticebar_width', '0'));
		if($isFull == '0'){
			return true;
		} else {
			return false;
		}
	}
}

if(!function_exists('jdm_noticebar_animation_class')){
	function jdm_noticebar_animation_class() {
		$animationVal = esc_attr(get_option('jdm_noticebar_animation', '0'));
		$animationTimeVal = esc_attr(get_option('jdm_noticebar_animation_duration', '0'));
		$animationClass = '';
		
		if($animationVal == '1'){
			$animationClass .= ' animated fadeIn';
		} elseif($animationVal == '2') {
			$animationClass .= ' animated fadeInDown';
		} elseif($animationVal == '3') {
			$animationClass .= ' animated fadeInUp';
		} else {
			$animationClass .= '';
		}
		
		if($animationTimeVal == '1'){
			$animationClass .= ' duration-1';
		} elseif($animationTimeVal == '2') {
			$animationClass .= ' duration-2';
		} elseif($animationTimeVal == '3') {
			$animationClass .= ' duration-3';
		} else {
			$animationClass .= '';
		}
		
		return $animationClass;
	}
}

if(!function_exists('jdm_noticebar_bgcolor')){
	function jdm_noticebar_bgcolor() {
		return get_option('jdm_noticebar_bgcolor', '#2196f3');
	}
}

if(!function_exists('jdm_noticebar_inline_css')){
	function jdm_noticebar_inline_css() {
		if(jdm_noticebar_isTop()){
			$position = 'top:0';
		} else {
			$position = 'bottom:0; top:auto;';
		}
		$style = 'style="background-color:'.jdm_noticebar_bgcolor().'; '.$position.'"';
		return $style;
	}
}

if(!function_exists('jdm_noticebar_container_class')){
	function jdm_noticebar_container_class() {
		if(jdm_noticebar_is_fullwidth()){
			$containerClass = 'jdm-notice-container-fluid';
		} else {
			$containerClass = 'jdm-notice-container';
		}
		return $containerClass;
	}
}