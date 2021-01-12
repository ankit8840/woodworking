<?php
session_start();


/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Ced_products_shop
 * @subpackage Ced_products_shop/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ced_products_shop
 * @subpackage Ced_products_shop/admin
 * @author     cedcommerce <https://cedcoss.com/>
 */
class Ced_products_shop_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ced_products_shop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_products_shop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced_products_shop-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ced_products_shop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_products_shop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced_products_shop-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * This function for Register custom post type which name is products
	 * @since    1.0.0
	 * @return void
	 */
	
	function ced_products_post_type()
	{
		register_post_type('products', [
			'labels' => [
				'name' => __('products', 'products'),
				'singular_name' => __('products', 'products'),
			],
			'public' => true,
			'has_archive' => true,
			'supports' => [
				'title',
				'editor',
				'excerpt',
				'author',
				'thumbnail',
				'comments',
				'revisions',
				'custom-fields',
			],
		]);
	}

	
	/**
	 * This is function for add inventory meta box this meta box tells how much Inventory of your 
	 * product
	 * @since    1.0.0
	 * @return void
	 */
	public function Add_Inventory_meta_box() {
			 add_meta_box(
				 'productmeta', // Unique ID
				 'Inventory MetaBox', // Box title
				 array($this,'ced_Inventory_box_html'),  // Content callback, must be of type callable
				 'products',  // Post type
				 'side'
			 );
		
	 }
	 
	 /**
	  * This is a callback function of Inventroy meta box this will contain HTML of your meta box
	  * @since    1.0.0
	  * @param  mixed $post this is current post of your page
	  * @return void
	  */
	 public function ced_Inventory_box_html( $post ) {
		$id=get_the_ID();
		$inventory=get_post_meta( $id,'product1',1);
	   ?>
	   <lable>Total Inventory</lable>
	   <input type="number" min=0 id="invn" name="inventroy_filed" placeholder="Enter Inventory" value="<?php echo $inventory?>" >
	   <p id="error"><p>
	 <?php
	 }
	 	 
	 /**
	  * This is a save function of your custom meta box with the help of this we can update metabox value
	  * @since   1.0.0
	  * @param  mixed $post_id
	  * @return void
	  */
	 public function ced_save_Inventory( int $post_id ) {
		 //die("enter");
		 if ( array_key_exists( 'inventroy_filed', $_POST ) ) {
			 if($_POST['inventroy_filed']=='')
			 $_POST['inventroy_filed']=0;
			 update_post_meta(
				 $post_id,
				 'product1',
				 $_POST['inventroy_filed']
			 );
		 }
	 }

	/**
	 * This is function for add pricing meta box this meta box tells how much pricing of your 
	 * product
	 * @since    1.0.0
	 * @return void
	 */
	 public function Add_Pricing_meta_box() {
		//$choice=get_option('brand_meta_box');
			 add_meta_box(
				 'pricing_id', // Unique ID
				 'Pricing MetaBox', // Box title
				 array($this,'ced_Pricing_box_html'), // Content callback, must be of type callable
				 'products'
			 );
			 
		 //add_option( 'brand_meta_box');
	 }
	

	 /**
	  * This is a callback function of pricing meta box this will contain HTML of your meta box
	  * @since    1.0.0
	  * @param  mixed $post this will current post of your page
	  * @return void
	  */
	  public function ced_Pricing_box_html( $post ) {
		$id=get_the_ID();
		$showprice=get_post_meta( $id,'productmeta',1);
		?>
		<lable>Regular Price</lable>
		<input type="number"  min=0 class="price" id="getrprice" name="price_filed1" placeholder="Regular_Pricing_box" value="<?php echo $showprice['regularprice']?>" >
		<input type="hidden" id="getid" name="brand_id" value=<?php echo get_the_ID();?>><br><br>
		<lable>Discount Price</lable>
		<input type="number" min=0 class="price" id="getdprice" name="price_filed2" placeholder="Discount_Pricing_box" value="<?php echo $showprice['discountprice']?>" >
		<p id="mess"><p>
	  <?php
	  }
	/**
	  * This is a save function of your custom meta box with the help of this we can update metabox value
	  * @since   1.0.0
	  * @param  mixed $post_id
	  * @return void
	  */
	 public function ced_save_Pricing( int $post_id ) {
		 //die("enter");
		 if ( array_key_exists( 'price_filed1', $_POST ) ) {
			$regp=$_POST['price_filed1'];
			$discount=$_POST['price_filed2'];
			 update_post_meta(
				 $post_id,
				 'productmeta',
				array('regularprice'=>$_POST['price_filed1'],
						'discountprice'=>$_POST['price_filed2'])
			 );
		 }
	 }


	 
	 /**
	  * This is a function of Register custom Taxonomy which name is product taxonomy 
	  * @since   1.0.0
	  * @return void
	  */
	 function ced_clothing_taxonomy()
	 {
		 $labels = [
			 'name' => _x('product_taxonomy', 'taxonomy general name'),
			 'singular_name' => _x('product', 'taxonomy singular name'),
			 'search_items' => __('Search product_taxonomy'),
		 ];
		 $args = [
			 'hierarchical' => true, // make it hierarchical (like categories)
			 'labels' => $labels,
			 'show_ui' => true,
			 'show_admin_column' => true,
			 'query_var' => true,
			 // 'rewrite' => array('slug' => 'portfolio'),
		 ];
		 register_taxonomy('clothing', ['products'], $args);
	 }
	 function session_unset_logout(){
		 session_start();
		 if(!empty($_SESSION['items'])){
			 unset($_SESSION['items']);
		 }
	 }
	
}
//session_destroy();