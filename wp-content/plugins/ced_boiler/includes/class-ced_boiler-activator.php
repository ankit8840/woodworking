<?php

/**
 * Fired during plugin activation
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Ced_boiler
 * @subpackage Ced_boiler/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ced_boiler
 * @subpackage Ced_boiler/includes
 * @author     cedcoss <xyz@gmail.com>
 */
class Ced_boiler_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		//is_plugin_active("/opt/lampp/htdocs/wordpress/wp-content/plugins/blog-plugin" );
		$apl=get_option('active_plugins');
		// print_r($apl);
		// die;
		if (!is_plugin_active('blog-plugin/blog-plugin.php')){
			$check="Your blog-plugin is Not Activated";
			wp_die($check);
			return false;
		  }
		// if (class_exists('custom_meta_box'))
		// {
		// 	throw new Exception('The class MyClass does not exist.');
		// }
		if( ! empty( get_option( 'my_update_status' ) ) ) {
			add_action( 'admin_notices', 'my_update_notice' );
		}

	}




}
