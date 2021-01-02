<?php
/**
 * Plugin Name
 *
 * @package           PluginPackage
 * @author            Ankit Dixit
 * @copyright         2019 Your Name or Company Name
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       woodworking-plugin
 * Plugin URI:        https://example.com/plugin-name
 * Description:       This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from Hello, Dolly in the upper right of your admin screen on every page.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Ankit Dixit
 * Author URI:        https://example.com
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
//require_once('/opt/lampp/htdocs/wordpress/wp-config.php');
global $wpdb;
if(isset($_POST['Submit'])){
    $wpdb->insert( 'wp_cedcontact', array(
        'name' => $_POST['Name'],
        'number' => $_POST['PhoneNumber'],
        'email' => $_POST['FromEmailAddress'],
        'Comment' => $_POST['Comments'], ));
        echo '<script>alert("Submit")</script>';

}
function create_plugin_database_table()
{
    global $table_prefix, $wpdb;

    $tblname = 'wp_cedcontact';
    $wp_track_table = $table_prefix . "$tblname ";

    #Check to see if the table exists already, if not, then create it

    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) 
    {

        $sql="CREATE TABLE `wp_cedcontact` (
            `id` int(50) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `number` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `comment` varchar(500) NOT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }
}
register_activation_hook( __FILE__, 'create_plugin_database_table' );

add_action("admin_menu", "addMenu");
function addMenu()
{
    add_menu_page("Woodworking",
                    "Woodworking", 
                    'manage_options',
                    "example-options", 
                    "woodMenu");
    add_submenu_page("example-options",
     "option 1", 
     "option 1",'manage_options', "example-option-1", "option1");
}
add_shortcode('wporg', 'wporg_shortcode');
function wporg_shortcode() {
    // do something to $content
    // always return
    $content="<form method='POST'>
    <script type='text/javascript'></script>
    <table style='width:100%;max-width:550px;border:0;' cellpadding='8' cellspacing='0'>
    <tr> <td>
    <label for='Name'>Name*:</label>
    </td> <td>
    <input name='Name' type='text' maxlength='60' style='width:100%;max-width:250px;' />
    </td> </tr> <tr> <td>
    <label for='PhoneNumber'>Phone number:</label>
    </td> <td>
    <input name='PhoneNumber' type='text' maxlength='43' style='width:100%;max-width:250px;' />
    </td> </tr> <tr> <td>
    <label for='FromEmailAddress'>Email address*:</label>
    </td> <td>
    <input name='FromEmailAddress' type='text' maxlength='90' style='width:100%;max-width:250px;' />
    </td> </tr> <tr> <td>
    <label for='Comments'>Comments*:</label>
    </td> <td>
    <textarea name='Comments' rows='7' cols='40' style='width:100%;max-width:350px;'></textarea>
    </td> </tr> <tr> <td>
    </td> <td>
    <input name='Submit' type='submit' value='Submit' />
    </td> </tr>
    </table>
    </form>";
    return $content;
}
function woodMenu()
{
    require_once 'class-wplisttable.php';
    plugin_settings_page();
}


/**
* Plugin settings page
*/
 function plugin_settings_page() {
    // die("ok");
	?>
	<div class="wrap">
		<h2>WP_List_Table Class Example</h2>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<?php
                            $customers_obj = new Customers_List();
                            $customers_obj->prepare_items();
						    $customers_obj->display(); ?>
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>
<?php
}
   
function option1()
{
    echo do_shortcode('[wporg]');
}
?>