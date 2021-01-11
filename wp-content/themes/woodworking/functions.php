<?php
/**
 * function name : ced_add_style
 * Description : Add style file 
 * Version    : 1.0
 * @return void
 */
function ced_add_style()
{
  wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'ced_add_style');

/**
 * function name : ced_register_my_menus
 * Description : This is a function for register navigation menus
 * Version    : 1.0
 * @return void
 */
function ced_register_my_menus()
{
    register_nav_menus([
        'header-menu' => __('Header Menu'),
    ]);
}
add_action('init', 'ced_register_my_menus');
/**
 * function name : ced_woodworking_theme
 * Description : This function contain add_theme_support function 
 * Version    : 1.0
 * @return void
 */
function ced_woodworking_theme()
{
    load_theme_textdomain(
        'woodworking',
        get_template_directory() . '/languages'
    );

    add_theme_support('automatic-feed-links');

    add_theme_support('title-tag');

    add_theme_support('post-formats', [
        'link',
        'aside',
        'gallery',
        'image',
        'quote',     
        'status',
        'video',
        'audio',
        'chat',
    ]);
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ]);
    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1568, 9999);

    register_nav_menus([
        'primary' => esc_html__('Primary menu', 'woodworking'),
        'footer' => __('Secondary menu', 'woodworking'),
    ]);
}

add_action('after_setup_theme', 'ced_woodworking_theme');
/**
 * function name : woo_footer
 * Description : This function is use for register sidebar 
 * Version    : 1.0
 * @return void
 */
function ced_woo_sidebar()
{
    register_sidebar([
        'name' => esc_html__('Footer', 'woodworking'),
        'id' => 'sidebar-1',
        'description' => esc_html__(
            'Add widgets here to appear in your footer.',
            'woodworking'
        ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ]);
}
add_action('widgets_init', 'ced_woo_sidebar');
/**
 * function name : ced_portfolio_post_type
 * Description : This function is use for register custom post type 
 * Version    : 1.0
 * @return void
 */
function ced_portfolio_post_type()
{
    register_post_type('portfolio', [
        'labels' => [
            'name' => __('portfolio', 'portfolio'),
            'singular_name' => __('portfolio', 'portfolio'),
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
add_action('init', 'ced_portfolio_post_type');

/**
 * wpb_widget
 */
class ced_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // Base ID of your widget
            'wpb_widget',

            // Widget name will appear in UI
            __('portfolio-widget', 'wpb_widget_domain'),

            // Widget description
            [
                'description' => __(
                    'Sample widget based on WPBeginner Tutorial',
                    'wpb_widget_domain'
                ),
            ]
        );
    }
 
    /**
     * widget
     *
     * @param  mixed $args
     * @param  mixed $instance
     * @return void
     */
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        /**
         * Setup query to show the ‘services’ post type with ‘8’ posts.
         * Output the title with an excerpt.
         */
        $args = [
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'posts_per_page' => 8,
        ];

        $loop = new WP_Query($args);

        while ($loop->have_posts()):
            $loop->the_post(); ?>
        <ul>
          <li><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if (get_the_title()) {
      the_title();
    } else {
    the_ID();
    } ?></a></li>
        </ul>
         <?php wp_reset_postdata(); ?>
         <?php
        endwhile;
    }  
    /**
     * form
     *
     * @param  mixed $instance
     * @return void
     */
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'wpb_widget_domain');
        }
        ?>
      <p>
      <label for="<?php echo $this->get_field_id(
          'title'
      ); ?>"><?php _e('Title:'); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id(
          'title'
      ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
      </p>
      <?php
    }

    // Updating widget replacing old instances with new    
    /**
     * update
     * 
     * @param  mixed $new_instance
     * @param  mixed $old_instance
     * @return void
     */
    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}

/**
 * wpb_load_widget
 *
 * @return void
 */
function wpb_load_widget()
{
    register_widget('ced_widget');
}
add_action('widgets_init', 'wpb_load_widget');

/**
 * function name : ced_portfolio_taxonomy
 * Description : This function is use for create custom taxonomy 
 * Version    : 1.0
 * @return void
 */
function ced_portfolio_taxonomy()
{
    $labels = [
        'name' => _x('portfolio_taxonomy', 'taxonomy general name'),
        'singular_name' => _x('portfolio', 'taxonomy singular name'),
        'search_items' => __('Search portfolio_taxonomy'),
        // 'all_items' => __('All portfolio_taxonomy'),
        // 'parent_item' => __('Parent portfolio'),
        // 'parent_item_colon' => __('Parent portfolio:'),
        // 'edit_item' => __('Edit portfolio'),
        // 'update_item' => __('Update portfolio'),
        // 'add_new_item' => __('Add New portfolio'),
        // 'new_item_name' => __('New Course portfolio'),
        // 'menu_name' => __('Add Taxonomy'),
    ];
    $args = [
        'hierarchical' => true, // make it hierarchical (like categories)
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        // 'rewrite' => array('slug' => 'portfolio'),
    ];
    register_taxonomy('portfolio', ['portfolio'], $args);
}
add_action('init', 'ced_portfolio_taxonomy');


function callback_edit_title($title){
return ("Ankit".$title);
}
add_filter('name_of_filter_for_edit_title', 'callback_edit_title');


// add_action('checkdata','hellomoto');
// function hellomoto(){
//     echo "this is custom hook";
// }

    add_filter('datetime','add_corn');

    function add_corn($schedules){
        $schedules=array('interval'=>5,'current_time'=>(current_time('Y-m-d H:i:s')),);
        return $schedules;
    }
    add_shortcode( 'showdata', 'showcontent' );
    
    
