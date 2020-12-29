<?php
//die("single port");
/* Template Name: custompage */ 
get_template_part( 'template_part/header','port' );

?>
<div id="page">
	<div id="page-bgtop">
		<div id="page-bgbtm">
			<div id="content">
                <?php the_post(); ?>
                <?php the_content(); ?>
                <?php comments_template(); ?>
        	</div>
					<!-- end #content -->
                    <?php get_sidebar();?>
			<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
    <!-- end #page -->
    <?php get_template_part( 'template_part/footer','port' );?>