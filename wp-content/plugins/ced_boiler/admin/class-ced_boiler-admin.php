<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Ced_boiler
 * @subpackage Ced_boiler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ced_boiler
 * @subpackage Ced_boiler/admin
 * @author     cedcoss <xyz@gmail.com>
 */
class Ced_boiler_Admin {

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
		 * defined in Ced_boiler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_boiler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced_boiler-admin.css', array(), $this->version, 'all' );

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
		 * defined in Ced_boiler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_boiler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( 'ajax_custom_script',  plugin_dir_url( __FILE__ ) . 'js/ced_boiler-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'ajax_custom_script', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),
																		'name' =>'Ankit',
																		'nonce'=>'ced_ajax'));

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced_boiler-admin.js', array( 'jquery' ), $this->version, false );

	}
public function add_boliermenu(){
	add_menu_page("Blog-plugin",//menu_title
                    "Ced_Boiler-plugin", //menu name
                    'manage_options',//capability
                    "ced_boiler_slug", //slug
                   array($this,'blogMenu'));//function
    add_submenu_page("ced_boiler_slug",// parent slugs
     				"boiler1", //menu_title
					"boiler2",//menu_name
					'manage_options', //capability
					"boiler1_options", //slug
					array($this, 'Ced_Bolier'));//function
					
}
public function blogMenu(){
	echo "ced boliling";
	// die;
}
public function Ced_Bolier(){
	echo "ced boiling sub menu";
	//die;
}

// if(isset($_POST['metavalue'])){
//     $choice=$_POST['posttypechoice'];
//     update_option( 'custom_meta_box', $choice);
// }
public function Add_brand_custom_box() {
   //$choice=get_option('brand_meta_box');
    $screens = ['post', 'wporg_cpt' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_id', // Unique ID
            'Brand MetaBox', // Box title
			array($this,'brand_custom_box_html'),  // Content callback, must be of type callable
            $screen   // Post type
        );
    }
    //add_option( 'brand_meta_box');
}

//Add HTML For MetaBox
public function brand_custom_box_html( $post ) {
  ?>
  <input type="text" id="getname" name="brand_filed" placeholder="Enter Custom Color" >
  <input type="hidden" id="getid" name="brand_id" value=<?php echo get_the_ID();?> >
  <input type="button" value="Add" id="submitbrand" >
<?php
}

public function savebrand( int $post_id ) {
	//die("enter");
    if ( array_key_exists( 'brand_filed', $_POST ) ) {
		
        update_post_meta(
            $post_id,
            'brandmeta',
            $_POST['brand_filed']
		);
		$this->my_test_plugin_admin_notice();
    }
}

/**
* Add new columns to the post table
*
* @param Array $columns - Current columns on the list post
*/
function add_new_columns($columns){

    $column_meta = array( 'Brands' => 'Brands' );
    $columns = array_slice( $columns, 0, 6, true ) + $column_meta + array_slice( $columns, 6, NULL, true );
    return $columns;

}

// Register the columns as sortable
function register_sortable_columns( $columns ) {
    $columns['Brands'] = 'Brands';
    return $columns;
}

//Add filter to the request to make the hits sorting process numeric, not string
function hits_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'Brands' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'brandmeta',
            'orderby' => 'meta_value_num'
        ) );
    }

    return $vars;
}
/**
* Display data in new columns
*
* @param  $column Current column
*
* @return Data for the column
*/
function custom_columns($column) {

    global $post;

    switch ( $column ) {
        case 'Brands':
            $hits = get_post_meta( $post->ID, 'brandmeta', true );
            echo $hits;
        break;
    }
}
function add_brand(){
	$id=$_POST['id'];
	$name=$_POST['name'];
	if(update_post_meta($id,'brandmeta',$name)){
		echo "updated";
	}
}

function ced_cedpool_post_type()
{
    register_post_type('ced_pool', [
        'labels' => [
            'name' => __('ced_pool', 'ced_pool'),
            'singular_name' => __('ced_pool', 'ced_pool'),
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
}
