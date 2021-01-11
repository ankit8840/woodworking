<?php
$id=get_the_ID();
$title=get_the_title();
$value = get_post_meta($id, 'productmeta', 1 );	
	if(isset($_POST['add_to_cart'])){
		$quantity=1;
		if (isset($_SESSION['items'][$id])){
		$quantity=$_SESSION['items'][$id]["quantity"];
		$quantity=$quantity+1;
		$price=$value['regularprice'];	
		$price1=$value['discountprice'];
		$upadtevalue=array('regularprice'=>$price*$quantity,'discountprice'=>$price1*$quantity);
		$ProductCart=array(
			'ProductId' => $id,
			'ProductName' => $title,
			'ProductPrice' => $upadtevalue,
			'quantity' => $quantity
		);
		$_SESSION['items'][$id]=$ProductCart;

		if(is_user_logged_in()){
			$id=get_current_user_id();
			$userdata=get_user_meta($id,"orderlist");
			
			update_user_meta($id,"orderlist",$_SESSION['items']);
		}
	}
	else{
		$ProductCart=array(
			'ProductId' => $id,
			'ProductName' => $title,
			'ProductPrice' => $value,
			'quantity' => $quantity
		);
		$_SESSION['items'][$id]=$ProductCart;

		if(is_user_logged_in()){
			$id=get_current_user_id();
			
			update_user_meta($id,"orderlist",$_SESSION['items']);
		}
	}

}    
get_header();	
?>
<style>
#submit{
	padding:15px;
	color:red;
	background-color:black;
}
</style>
<div id="page">
    <div id="page-bgtop">

                <?php the_post(); ?>
                <?php ?>
                <?php ?>
				<h1>Product:</h1>
				<?php $title=get_the_title();?>
                <h1 style="color:red";><?php the_title(); ?></h1>
				<?php the_post_thumbnail( 'thumbnail', array('class'=>'center border' ) );?><p></p>
				<h2>Regular Price: <?php echo $value['regularprice']?></h2>	
				<h2>Discount Price: <?php echo $value['discountprice']?></h2>	
                <?php the_content(); ?>

				<form action="" method="post">
				<input type="hidden" value='<?php echo $id;?>' name = "id">
				<input type="submit"  id="submit" value="Add to Cart" name="add_to_cart">
				</form>
        	    </div>
					
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
<?php //session_destroy();?>
