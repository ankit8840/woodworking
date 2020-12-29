<?php
function add_css() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
  }
  add_action( 'wp_enqueue_scripts', 'add_css' );

function register_my_menus() {
    register_nav_menus(
      array(
        'header-menu' => __( 'Header Menu' )
      )
    );
  }
  add_action( 'init', 'register_my_menus' );
  function twenty_twenty_one_setup() {
   
    load_theme_textdomain( 'woodworking', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );


    add_theme_support( 'title-tag' );

    add_theme_support(
        'post-formats',
        array(
            'link',
            'aside',
            'gallery',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat',
        )
        
    );
    add_theme_support(
			'html5',
			array(
        'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);
    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1568, 9999 );

    register_nav_menus(
        array(
            'primary' => esc_html__( 'Primary menu', 'woodworking' ),
            'footer'  => __( 'Secondary menu', 'woodworking' ),
        )
    );

  

   
}

add_action( 'after_setup_theme', 'twenty_twenty_one_setup' );
function woo_footer() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'woodworking' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'woodworking' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'woo_footer' );
function portfolio_post_type() {
  register_post_type('portfolio',
      array(
          'labels'      => array(
              'name'          => __('portfolio', 'portfolio'),
              'singular_name' => __('portfolio', 'portfolio'),
          ),
              'public'      => true,
              'has_archive' => true,
              'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),

              
      )
  );
}
add_action('init', 'portfolio_post_type');
// Creating the widget 
class wpb_widget extends WP_Widget {
  
      function __construct() {
      parent::__construct(
        
      // Base ID of your widget
      'wpb_widget', 
        
      // Widget name will appear in UI
      __('portfolio-widget', 'wpb_widget_domain'), 
        
      // Widget description
      array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), ) 
      );
      }
        
      // Creating widget front-end
        
      public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
          
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];
          
        // This is where you run the code and display the output
        // echo __( 'Hello, World!', 'wpb_widget_domain' );
        // echo $args['after_widget'];
          /**
 * Setup query to show the ‘services’ post type with ‘8’ posts.
 * Output the title with an excerpt.
      */
          $args = array(  
            'post_type' => 'portfolio',
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
      }
                
      // Widget Backend 
      public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
        $title = $instance[ 'title' ];
        }
        else {
        $title = __( 'New title', 'wpb_widget_domain' );
      }
      // Widget admin form
      ?>
      <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <?php 
      }
            
      // Updating widget replacing old instances with new
      public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
      }
      
      // Class wpb_widget ends here
      } 
      
      
      // Register and load the widget
      function wpb_load_widget() {
          register_widget( 'wpb_widget' );
  }
  add_action( 'widgets_init', 'wpb_load_widget' );



//fuction for taxonomy of portfolio date:-28/12/2021
function portfolio_taxonomy() {
  $labels = array(
      'name'              => _x( 'portfolio_taxonomy', 'taxonomy general name' ),
      'singular_name'     => _x( 'portfolio', 'taxonomy singular name' ),
      'search_items'      => __( 'Search portfolio_taxonomy' ),
      'all_items'         => __( 'All portfolio_taxonomy' ),
      'parent_item'       => __( 'Parent portfolio' ),
      'parent_item_colon' => __( 'Parent portfolio:' ),
      'edit_item'         => __( 'Edit portfolio' ),
      'update_item'       => __( 'Update portfolio' ),
      'add_new_item'      => __( 'Add New portfolio' ),
      'new_item_name'     => __( 'New Course portfolio' ),
      'menu_name'         => __( 'Add Taxonomy' ),
  );
  $args   = array(
      'hierarchical'      => true, // make it hierarchical (like categories)
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      // 'rewrite' => array('slug' => 'portfolio'),
  );
  register_taxonomy( 'portfolio', [ 'portfolio' ], $args );
}
add_action( 'init', 'portfolio_taxonomy' );