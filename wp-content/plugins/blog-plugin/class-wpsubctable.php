<?php 
class Subscriber_List extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Customer', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Customers', 'sp' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

        }
      function get_subscribe(){
        $args = array(
          'post_type'     => 'any',
          'post_status'   => 'publish',
          'fields'        => 'ids',
          'meta_query'    => array(
            array(
              'key'    => 'sucr_email',
              'compare'       => 'exist'
            ),
          ),
        );
    
        $result_query=new WP_Query($args);
        // print_r($result_query);
        $id=$result_query->posts;
       
        
        wp_reset_postdata();
        $data=array();

        foreach($id as $val){
          $value=get_post_meta($val,'sucr_email',1);
          foreach($value as $result){
          $post_title = get_the_title($val);
           $data[]  = array('posttitle'=> $post_title,'post_id'=>$val, 'email'=> $result);
          //  print_r($data);
          //  die;
        }
    }
   // print_r($res);//die;
    return $data;
      }
    
// column name function 
function column_name( $item ) {
    //print_r($item);
    // create a nonce
    $delete_nonce = wp_create_nonce( 'sp_delete_customer' );
  
    $title = '<strong>' . $item['name'] . '</strong>';
  
    $actions = [
      'delete' => sprintf( '<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
    ];
  
    return $title . $this->row_actions( $actions );
  }

  /**
 * Render a column when no column specific method exists.
 *
 * @param array $item
 * @param string $column_name
 *
 * @return mixed
 */
public function column_default( $item, $column_name ) {
    switch ( $column_name ) {
      case 'posttitle':
        return $item[ $column_name ];
      case 'post_id':
        return $item[ $column_name ];
        case 'email':
        return $item[ $column_name ];
      default:
        return print_r( $item, true ); //Show the whole array for troubleshooting purposes
    }
  }
  /**
 * Render the bulk edit checkbox
 *
 * @param array $item
 *
 * @return string
 */
function column_cb( $item ) {
    return sprintf(
      '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
    );
  }

   /**
 * Render the bulk edit checkbox
 *
 * @param array $item
 *
 * @return string
 */
function column_posttitle( $item ) {
    $address = isset($item['posttitle']) ? $item['posttitle'] : '';
    return $address;
  }
   /**
 * Render the bulk edit checkbox
 *
 * @param array $item
 *
 * @return string
 */
function column_email( $item ) {
    $address = isset($item['email']) ? $item['email'] : '';
    return $address;
  }
function column_post_id( $item ) {
    $address = isset($item['post_id']) ? $item['post_id'] : '';
    return $address;
  }
/**
 *  Associative array of columns
 *
 * @return array
 */
function get_columns() {
    $columns = [
      //'cb'      => '<input type="checkbox" />',
      'posttitle'    => __( 'posttitle', 'sp' ),
      'post_id' => __( 'post_id', 'sp' ),
      'email'    => __( 'email', 'sp' )
    ];
  
    return $columns;
  }
  /**
 * Columns to make sortable.
 *
 * @return array
 */
public function get_sortable_columns() {
    $sortable_columns = array(
      'posttitle' => array( 'posttitle', true ),
      'post_id' => array( 'post_id', true ),
      'email' => array( 'email', true )
    );
  
    return $sortable_columns;
  }

  /**
 * Handles data query and filter, sorting, and pagination.
 */
public function prepare_items() {
    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columnsarray();
    $this->_column_headers = array($columns, $hidden, $sortable);
    // $this->items = $this->example_data;
  
    /** Process bulk action */
    $this->process_bulk_action();
  
    $per_page     = $this->get_items_per_page( 'customers_per_page', 5 );
    $current_page = $this->get_pagenum();
    $total_items  = self::record_count();
    //$column= self::get_columns();
    // print_r($column);
    // die();
    $this->set_pagination_args( [
      'total_items' => $total_items, //WE have to calculate the total number of items
      'per_page'    => $per_page //WE have to determine how many items to show on a page
    ] );
  
  
    $this->items =$this->get_subscribe( $per_page, $current_page );
  }
  public function process_bulk_action() {

    //Detect when a bulk action is being triggered...
    if ( 'delete' === $this->current_action() ) {
  
      // In our file that handles the request, verify the nonce.
      $nonce = esc_attr( $_REQUEST['_wpnonce'] );
  
      if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
        die( 'Go get a life script kiddies' );
      }
      else {
        self::delete_customer( absint( $_GET['customer'] ) );
  
        wp_redirect( esc_url( add_query_arg() ) );
        exit;
      }
  
    }
  
    // If the delete bulk action is triggered
    if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
         || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
    ) {
  
      $delete_ids = esc_sql( $_POST['bulk-delete'] );
  
      // loop over the array of record IDs and delete them
      foreach ( $delete_ids as $id ) {
        self::delete_customer( $id );
  
      }
  
      wp_redirect( esc_url( add_query_arg() ) );
      exit;
    }
  }
  public static function set_screen( $status, $option, $value ) {
	return $value;
}

public function plugin_menu() {

	$hook = add_menu_page(
		'Sitepoint WP_List_Table Example',
		'SP WP_List_Table',
		'manage_options',
		'wp_list_table_class',
		[ $this, 'plugin_settings_page' ]
	);

	add_action( "load-$hook", [ $this, 'screen_option' ] );

}
/**
* Screen options
*/
public function screen_option() {

	$option = 'per_page';
	$args   = [
		'label'   => 'Customers',
		'default' => 5,
		'option'  => 'customers_per_page'
	];

	add_screen_option( $option, $args );

	// $this->customers_obj = new Customers_List();
}

/** Singleton instance */
public static function get_instance() {
	if ( ! isset( self::$instance ) ) {
		self::$instance = new self();
	}

	return self::$instance;
}
}
?>



