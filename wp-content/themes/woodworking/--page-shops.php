<?php 
get_header();
$posttypes=array('post_type'=>'products');
$products=new WP_Query($posttypes);
?>
<style>   
td {   
    padding-right: 135px; 
}   
</style>
<div id="page">




            <table class="table">
            <thead>
                <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($products->have_posts()) : while ($products->have_posts() ) :$products->the_post(); ?>
            <tr>
                <?php $id=$post->ID;
                $id=get_post_meta( $id,1);
                ?>
                <td><a href="<?php the_permalink();?>"><?php the_title(); ?></td>
                <td><?php the_post_thumbnail( 'thumbnail', array('class'=>'alignleft border' ) );?></td>
                <td>1</td>
                </tr>
            <?php endwhile; else : ?>
				<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php endif; ?>
				</div>
			</div>
            </tbody>
            </table>
		</div>
    <?php get_footer();?>
