<?php

/**
 * Fired during plugin activation
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Ced_products_shop
 * @subpackage Ced_products_shop/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ced_products_shop
 * @subpackage Ced_products_shop/includes
 * @author     cedcommerce <https://cedcoss.com/>
 */
class Ced_products_shop_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$checkpage=get_page_by_title('Shop');
		if($checkpage!="Shop"){
		$my_post = array(
			'post_title'    => 'Shop',
			'post_content'  => '[showitems]',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_type'     => 'page',
		  );
	  
		  // Insert the post into the database
		  wp_insert_post( $my_post );

		  $my_page = array(
			'post_title'    => 'Cart',
			'post_content'  => '[cartitems]',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_type'     => 'page',
		  );
	  
		  // Insert the post into the database
		  wp_insert_post( $my_page );
		}
	
	}
}
