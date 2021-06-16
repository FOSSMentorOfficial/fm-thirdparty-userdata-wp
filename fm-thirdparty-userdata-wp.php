<?php # -*- coding: utf-8 -*-

/**
 * Plugin Name: ThirdParty User Data
 * Plugin URI:
 * Description: A simple plugin to display user data from thirdparty API
 * Author: Wasif Younas
 * Author URI: https://github.com/FOSSMentorOfficial/
 * License: GPL-2.0
 */

namespace Inpsyde\WpStash;

if( ! defined( 'ABSPATH' ) ) {
    return;
}

define( 'SCRIPT_URL', plugin_dir_url( __FILE__ ).'scripts/custom.js' );
//define( 'SCRIPT_URL', 'http://localhost/wp-test-project/public/wp-content/plugins/fm-thirdparty-userdata-wp/scripts/custom.js' );
	
	// Only non-admin users can access this page
	if(!is_admin()){

		// Test if url string contains the required slug
		if(strpos($_SERVER["REDIRECT_URL"], "my-lovely-users-table") !== false){

			if (!class_exists(MyPrivatePlugin::class) && is_readable(__DIR__.'/vendor/autoload.php')) {
				/** @noinspection PhpIncludeInspection */
				require_once __DIR__.'/vendor/autoload.php';
			}
			class_exists(MyPrivatePlugin::class) && MyPrivatePlugin::instance();

		} 
	}
