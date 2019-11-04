<?php
/*
Plugin Name: FSTP Custom Post
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: Basic WordPress Plugin Header Comment
Version:     1.0.0
Author:      WordPress.org
Author URI:  https://developer.wordpress.org/
Text Domain: fstpcp
License:     GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA

https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html

*/
defined( 'ABSPATH' ) or die; // Exit if accessed directly

if ( ! defined( 'FSTP_PLUGIN_PATH' ) ) {
	define( 'FSTP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'FSTP_PLUGIN_URL' ) ) {
	define( 'FSTP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( file_exists( FSTP_PLUGIN_PATH . 'classes/class-fstp-acf-fields.php' ) ) {
	require_once FSTP_PLUGIN_PATH . 'classes/class-fstp-acf-fields.php';
}

if ( file_exists( FSTP_PLUGIN_PATH . 'classes/class-fstp-custom-post.php' ) ) {
	require_once FSTP_PLUGIN_PATH . 'classes/class-fstp-custom-post.php';
}

if ( file_exists( FSTP_PLUGIN_PATH . 'classes/class-fstp-custom-taxonomies.php' ) ) {
	require_once FSTP_PLUGIN_PATH . 'classes/class-fstp-custom-taxonomies.php';
}

if ( file_exists( FSTP_PLUGIN_PATH . 'classes/class-fstp-main.php' ) ) {
	require_once FSTP_PLUGIN_PATH . 'classes/class-fstp-main.php';
}

/*
Description: Start FSTP Custom Post plugin.
*/
function fstp_custom_post_start() {

	$acf_fields = new FSTP_ACF_Fields();
	$custom_post = new FSTP_Custom_Post();
	$custom_taxonomies = new FSTP_Taxonomies();
	$main_class = new FSTP_Main( $acf_fields, $custom_post, $custom_taxonomies );
	
	// activation
	register_activation_hook( __FILE__, array( $main_class, 'activation_check' ) );

	// deactivation
	register_deactivation_hook( __FILE__, array( $main_class, 'deactivate' ) );

	// uninstall
	//register_uninstall_hook( __FILE__, array( $main_class, 'uninstall' ) );
	// Only a static class method or function can be used in an uninstall hook.

}
fstp_custom_post_start();