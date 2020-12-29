	
<?php /* Template Name: custompage */ 
get_template_part( 'template_part/header','port' );
?>
<!-- end #menu -->
<div id="page">
    <div id="page-bgtop">
        <div id="page-bgbtm">
             <div id="content" class="childpage">
        <?php
            $loop = new WP_Query( array( 'post_type' => 'portfolio', 'posts_per_page' => 10 ) ); 

            while ( $loop->have_posts() ) : $loop->the_post();

            the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' ); 
            ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

        <?php endwhile; ?>
            </div>
            <!-- end #content -->
            <!-- end #sidebar -->
            <div style="clear: both;">&nbsp;</div>
        </div>
    </div>
</div>
<!-- end #page -->
<?php get_template_part( 'template_part/footer','port' );?>

