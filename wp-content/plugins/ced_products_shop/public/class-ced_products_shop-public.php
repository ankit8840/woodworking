<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Ced_products_shop
 * @subpackage Ced_products_shop/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ced_products_shop
 * @subpackage Ced_products_shop/public
 * @author     cedcommerce <https://cedcoss.com/>
 */
class Ced_products_shop_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode( "showitems", array( $this, "shop" ) );
		add_shortcode( "cartitems", array( $this, "cart" ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced_products_shop-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced_products_shop-public.js', array( 'jquery' ), $this->version, false );

	}	
	/**
	* This function is provided for single page of products only.
	*
	* @since    1.0.0
	*
	* @param  mixed $temp:this variable return template path
	* @return void
	*/
	public function template($temp) {
		$data = get_post_type();
		$post_type= 'products';
		if($data == $post_type) {
			$temp = plugin_dir_path(__FILE__).'partials/single-page.php';
		}
		return $temp;
	}	

	
	/**
	 * This is a shortcode function which is used by show All products
	 * @since    1.0.0
	 * @return void
	 */
	public function shop() 
	{?>
		<div id="page">
			<div id="page-bgtop">
				<div id="page-bgbtm">
					 <div id="content">
					
					 <?php $loop = new WP_Query( array('posts_per_page'=>2,
                                 'post_type'=>'products',
                                 'paged' => get_query_var('paged') ? get_query_var('paged') : 1) 
                            ); ?>
					<?php if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); ?>
						<div class="post">
							<?php $id = get_the_ID();$pri = get_post_meta($id,'productmeta',1);?>
							<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="meta">Posted by <a href="<?php the_permalink(); ?>"><?php echo get_the_author();?></a>
								&nbsp;&bull;&nbsp; <a href="<?php the_permalink(); ?>" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
							<div class="entry">
							
							<?php the_post_thumbnail( 'thumbnail', array('class'=>'center border' ) );?><p></p>
							<h2>Regular Price: <?php esc_html_e($pri['regularprice'])?></h2>	
							<h2>Discount Price: <?php esc_html_e($pri['discountprice'])?></h2>					
							</div>
						</div>
						<hr>
					<?php endwhile; else : ?>
						<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
					<?php endif; ?>

					</div>
					<!-- end #content -->
					<!-- end #sidebar -->
					<div style="clear: both;">&nbsp;</div>
					<?php
					echo paginate_links( array(
						'current' => max( 1, get_query_var('paged') ),
						'total' => $loop->max_num_pages
					) );
					?>
				</div>
			</div>
		</div>
		
	<?php
	return;}

		
	/**
	 * This is a shortcode function which is show the all cart products
	 * and this function contain all update and delete function products
	 * @since    1.0.0
	 * @return void
	 */
	public function cart() 
	{
		$text='';
		$y=0;	
		unset($_SESSION['mess']);
		if(!empty($_SESSION['items']))
		{
		foreach($_SESSION['items'] as $key =>$tab)
		{
		if(isset($_POST[$tab['ProductId'].'update'])){
				$id=$tab['ProductId'];
				$title=$tab['ProductName'];
				$value = get_post_meta($id, 'productmeta', 1 );	
				$price=$value['regularprice'];	
				$price1=$value['discountprice'];
				$quantity=$_POST['qun'];
				$upadtevalue=array('regularprice'=>$price*$quantity,'discountprice'=>$price1*$quantity);
				
				$ProductCart=array(
					'ProductId' => $id,
					'ProductName' => $title,
					'ProductPrice' => $upadtevalue,
					'quantity' => $quantity
				);
				$_SESSION['items'][$id]=$ProductCart;
				$_SESSION['mess']=array('notice'=>'Product Updated Sucessfully');
			

				if(is_user_logged_in()){
				$id=get_current_user_id();
				$userdata=get_user_meta($id,"orderlist");
				
				update_user_meta($id,"orderlist",$_SESSION['items']);
				}	
			}

				if(isset($_POST[$tab['ProductId'].'delete'])){
				$id=$tab['ProductId'];
				unset($_SESSION['items'][$id]);
				$_SESSION['mess']=array('notice'=>'Product Deleted Sucessfully');
				if(is_user_logged_in()){
				$id=get_current_user_id();
				update_user_meta($id,"orderlist",$_SESSION['items']);
				
					}
				}
			}
		}		


		/**
		 * This if condition runs when user not login this is contain all cart data 
	 	**/
		if(!is_user_logged_in()){
			$text='';
			if(isset($_SESSION['mess'])){
				$text.='<h3>'.$_SESSION['mess']['notice'].'</h3>';
			}
		
			$text.='<table>';
			$text.='<tr>'."<th>"."ProductId"."</th>"."<th>"."ProductName"."</th>"."<th>"."Quantity"."</th>"."<th>"."ProductPrice"."</th>"."<th>"."Action"."</th>"."<th>"."Action"."</th>".'<tr>';
			if(!empty($_SESSION['items'])){
			foreach($_SESSION['items'] as $key =>$tab)
			{
				
				$text.='<form method="POST">'.
				"<tr>" . "<td>" . $tab['ProductId'] . "</td>" .
				"<td>" . $tab['ProductName'] . "</td>" .
				"<td>" . '<input type="number" min=1 id="quantity" value='.$tab['quantity'].' name="qun">'. "</td>" .
				"<td>" . $tab['ProductPrice']['regularprice'] . "</td>" .
				"<td>" . '<input type="submit" name="'.$tab['ProductId'].'update" class="update"  value="Update" />'."</td>". 
				"<td>" . '<input type="submit" name="'.$tab['ProductId'].'delete" class="delete" value="Delete" />'. "</td>". "</tr>".'</form>';
			}
			$text.="</table>";
			
			foreach($_SESSION['items'] as $key =>$tab)
			{
			$y=$y+$tab['ProductPrice']['regularprice'];
			}
			 $text.='<div style="background-color:red;">
						<h1>Total==>Amount= $'.$y.'<span id="pprv"></span></span></h1>
					</div>';		
			
		}
	}
		/**
		 * This else condition runs when user login this is contain all cart data 
	 	**/
		else{
			$id=get_current_user_id();
			$userdata=get_user_meta($id,"orderlist",1);
				if(!empty($_SESSION['items'])){
					update_user_meta($id,"orderlist",$_SESSION['items']);
					$userdata=get_user_meta($id,"orderlist",1);
				}
				if(!empty($userdata)){
					if(isset($_SESSION['mess'])){
						$text.='<h3>'.$_SESSION['mess']['notice'].'</h3>';
				}
				$text.='<table>';
				$text.='<tr>'."<th>"."ProductId"."</th>"."<th>"."ProductName"."</th>"."<th>"."Quantity"."</th>"."<th>"."ProductPrice"."</th>"."<th>"."Action"."</th>"."<th>"."Action"."</th>".'<tr>';
				foreach($userdata as $key=>$tab)
				{
					$text.='<form method="POST">'.
							"<tr>" . "<td>" . $tab['ProductId'] . "</td>" .
				   			"<td>" . $tab['ProductName'] . "</td>" .
				   			"<td>" . '<input type="number" min=1 id="quantity" value='.$tab['quantity'].' name="qun">'. "</td>" .
				   			"<td>" . $tab['ProductPrice']['regularprice'] . "</td>" .
							"<td>" . '<input type="submit" name="'.$tab['ProductId'].'update"  value="Update" />'."</td>". 
							"<td>" . '<input type="submit" name="'.$tab['ProductId'].'delete"  value="Delete" />'. "</td>". "</tr>".'</form>';
				}
				$text.="</table>";
				foreach($userdata as $key =>$tab)
				{	
		 		$y=$y+$tab['ProductPrice']['regularprice'];
		 		}
				 $text.='<div style="background-color:red;color:black;">
							<h1>Total==>Amount= $'.$y.'<span id="pprv"></span></span></h1>
						</div>';		
					
				
			}
		}
		return $text;
	}
	
	/**
	 * This function is use for store cart data into session this will check if user login 
	 * and session empty then get the all data from db and store into session.
	 * @since    1.0.0
	 * @return void
	 */
	function restore_session_data(){
		if(is_user_logged_in()&&(empty($_SESSION['items']))){
			$id=get_current_user_id();
			$previous_data=get_user_meta($id,"orderlist",1);
			$_SESSION['items']=$previous_data;
			}
	}
}
