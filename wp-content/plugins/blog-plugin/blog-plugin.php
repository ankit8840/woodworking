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
 * Plugin Name:       blog-plugin
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



//Add Menu for Blog plugin
$meta_value=array();
if(isset($_POST['subscribe'])){
$post_id=$_POST['id'];
$meta_key="sucr_email";
echo($meta_key);
$meta_value=get_post_meta($post_id,$meta_key,1);
if(!empty($meta_value)){
    $meta_value[]=$_POST['email'];
}else{
    $meta_value=array($_POST['email']);
}
update_post_meta( $post_id, $meta_key, $meta_value );
}
function addMenu()
{
    add_menu_page("Blog-plugin",//menu-title
                    "Blog-plugin",//menu-name
                    'manage_options',//capability
                    "example-options",//slug
                    "BlogMenu");//function
    
    add_submenu_page("example-options",//parent-slug
                    "custom_metabox", //menu-title
                    "custom_metabox",//menu-name
                    'manage_options',//capabilty
                    "example-option-1",//slug
                    "custom_metabox"//function
    );
}
add_action("admin_menu", "addMenu");

//Create a custom post_type Blog
function blog_post_type() {
    register_post_type('Blog',
        array(
            'labels'      => array(
                'name'          => __('Blog', 'Blog'),
                'singular_name' => __('Blog', 'Blog'),
            ),
                'public'      => true,
                'has_archive' => true,
                'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
  
                
        )
    );
  }
  add_action('init', 'blog_post_type');
require_once 'custommetabox.php';
class blogsubscribe_widget extends WP_Widget {
  
    function __construct() {
    parent::__construct(
      
    // Base ID of your widget
    'blogsubscribe_widget', 
      
    // Widget name will appear in UI
    __('Subscribe', 'blogsubscribe_widget_domain'), 
      
    // Widget description
    array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'blogsubscribe_widget_domain' ), ) 
    );
    }
      
    // Creating widget front-end
      
    public function widget( $args, $instance ) {
      $title = apply_filters( 'widget_title', $instance['title'] );
        
        
      // before and after widget arguments are defined by themes
      echo $args['before_widget'];
      if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];
        
    /**
      * Setup query to show the ‘services’ post type with ‘8’ posts.
      * Output the title with an excerpt.
    */
        $args = array(  
          'post_type' => 'blog',
          'post_status' => 'publish',
          'posts_per_page' => 8
      );

      $loop = new WP_Query( $args ); 
      while ($loop->have_posts()) : $loop->the_post();?>
      <ul>
        <li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
      </ul>
      <?php wp_reset_postdata(); ?>
       <?php endwhile;
       global $post;
       $post_type=get_post_type($post->ID);
       ?>

       <?php if (is_array($instance['posttype'])) :?>
          <?php  if (is_single() && in_array($post_type, $instance['posttype'])) :?>
       <form method="POST">
       <div><input type="text" placeholder="enter email" name="email" size=15></div>
       <?php $id = get_the_ID();?>
       <div><input type="text" placeholder="enter email"  name="id" size=15 value="<?php echo $id ?>" hidden></div>
       <div style="margin-top:10px;"><input type="submit" name="subscribe" value="subscribe"></div>
       </form>
       <?php endif; ?>
       <?php endif; ?>
    <?php   
    }          
    // Widget Backend 
    public function form( $instance ) {

      if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
      }
      else {
      $title = __( 'New title', 'blogsubscribe_widget_domain' );
    }
// Widget admin form
?>
<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
  <?php
    $args = array(
    'public'   => true,
      '_builtin' => false,
    );

    $output = 'names'; // names or objects, note names is the default
    $operator = 'or'; // 'and' or 'or'

    $post_types = get_post_types( $args, $output, $operator ); 
      
    $checked='';
    foreach ( $post_types  as $post_type ) {
        if($post_type=="attachment"){
            continue;
            }
          if(is_array($instance['posttype'])){
          if(in_array($post_type,$instance['posttype'])){
              $checked='checked';
            } else {
              $checked='';
          }
        }
      ?>
        <p><input id="<?php echo $this->get_field_id('posttype') . $post_type; ?>" name="<?php echo $this->get_field_name('posttype[]'); ?>" type="checkbox" value="<?php echo $post_type; ?>" <?php echo $checked ?> /> <?php echo $post_type ?>
       <?php  } ?>

    <?php 
    }
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
//print_r($new_instance);
  $instance = array();
  $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
  $instance['posttype'] = isset(( $new_instance['posttype'] ) ) ? $new_instance['posttype']  : false;
  $this->my_test_plugin_admin_notice();
  return $instance;
  }
   
   
} 
 // Class wpb_widget ends here    
    
// Register and load the widget
function blogsubscribe_widget() {
  register_widget( 'blogsubscribe_widget' );
}
add_action( 'widgets_init', 'blogsubscribe_widget' );
function BlogMenu()
{
    require_once 'class-wpsubctable.php';
    plugin_settings_page();
}


/**
* Plugin settings page
*/
 function plugin_settings_page() { ?>
	<div class="wrap">
		<h2>WP_List_Table Class Example</h2>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<?php
                $customers_obj = new Subscriber_List();
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

  






