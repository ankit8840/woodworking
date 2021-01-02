<?php
//Add Custom Meta Box
if(isset($_POST['metavalue'])){
    $choice=$_POST['posttypechoice'];
    update_option( 'custom_meta_box', $choice);
}
class custom_meta_box{
public static function Add_color_custom_box() {
   $choice=get_option('custom_meta_box');
    $screens = [ $choice, 'wporg_cpt' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_box_id', // Unique ID
            'Color MetaBox', // Box title
            [self::class, 'color_custom_box_html' ],  // Content callback, must be of type callable
            $screen                          // Post type
        );
    }
    add_option( 'custom_meta_box');
}

//Add HTML For MetaBox
public static function color_custom_box_html( $post ) {
  ?>
  <input type="text" name="color_filed" placeholder="Enter Custom Color" value="" >
  <?php
   $value = get_post_meta( $post->ID, 'colormeta', 1 );?>   
<?php
}

public static function save( int $post_id ) {
    if ( array_key_exists( 'color_filed', $_POST ) ) {
        update_post_meta(
            $post_id,
            'colormeta',
            $_POST['color_filed']
        );
    }
}
}
add_action( 'add_meta_boxes', [ 'custom_meta_box', 'Add_color_custom_box' ] );
add_action( 'save_post', [ 'custom_meta_box', 'save' ] );

function custom_metabox(){?>
    <html>
    <h1>All Post Types</h1><?php
    $args = array(
        'public'   => true,
          '_builtin' => false,
        );
    
        $output = 'names'; // names or objects, note names is the default
        $operator = 'or'; // 'and' or 'or'
    
        $post_types = get_post_types( $args, $output, $operator ); 
        $posttypechoices=get_option('custom_meta_box');
        $checked='';?>
        <form action="" method="post"><?php
        foreach($post_types as $post_type):
            if($post_type=="attachment"){
                continue;
                }
                $checked='';
                if(is_array($posttypechoices)){
                    if(in_array($post_type,$posttypechoices)){
                        $checked="checked";
                    } else {
                        $checked="";
                    }
                } else {
                    $checked='';
                }
        ?>

        <p><input id="posttypechoice" name='posttypechoice[]'  type="checkbox" value="<?php echo $post_type; ?>" <?php echo $checked ?> /> <?php echo $post_type ?></p>
           
        <?php 
        endforeach;?>
        <input type="submit"  value="submit" name="metavalue">
        </form>
        <?php
}
?>