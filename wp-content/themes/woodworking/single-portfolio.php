<?php
//die("single port");
/* Template Name: custompage */ 
//get_template_part( 'template_part/header','port' );
get_header();
?>
<div id="page">
	<div id="page-bgtop">
		<div id="page-bgbtm">
			<div id="content">
			<?php //the_title();?>
			<?php if(has_filter('name_of_filter_for_edit_title')):?>
			<?php echo apply_filters('name_of_filter_for_edit_title',the_title());?>
			<?php endif; ?>
                <?php the_post();?>
				<?php $id=get_the_ID()?>
                <?php $value = get_post_meta($id, 'colormeta', 1 );?>
                <?php the_content(); ?>
                <?php comments_template(); ?>
        	</div>
					<!-- end #content -->
                    <?php get_sidebar();?>
			<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
		<?php echo $date="date: ";?>
		<?php print_r(apply_filters('datetime',$date));
			

		
		?>

	</div>
    <!-- end #page -->
    <?php get_template_part( 'template_part/footer','port' );?>