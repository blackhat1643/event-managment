<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Add admin_redirect
if ( ! function_exists('admin_redirect')) {
	function admin_redirect($uri = '', $method = 'auto', $code = NULL) {
		if ( ! preg_match('#^(\w+:)?//#i', $uri)){
			$uri = site_url('admin/'.$uri);
		}
		return redirect($uri, $method, $code);
	}
}