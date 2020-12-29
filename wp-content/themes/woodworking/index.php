		<?php
		// die("single");
		get_header();
		?>
		<!-- end #menu -->
		<div id="page">
			<div id="page-bgtop">
				<div id="page-bgbtm">
					 <div id="content">
					<?php if ( have_posts()) : while ( have_posts() ) : the_post(); ?>
						<div class="post">
							<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="meta">Posted by <a href="<?php the_permalink(); ?>"><?php echo get_the_author();?></a>
								&nbsp;&bull;&nbsp; <a href="<?php the_permalink(); ?>" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
							<div class="entry">
							<?php the_post_thumbnail( 'thumbnail', array('class'=>'alignleft border' ) );?><p><?php the_content(); ?></p>
							</div>
						</div>
					<?php endwhile; else : ?>
						<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
					<?php endif; ?>

					</div>
					<!-- end #content -->
					<?php get_sidebar();?>
					<!-- end #sidebar -->
					<div style="clear: both;">&nbsp;</div>
				</div>
			</div>
		</div>
		<!-- end #page -->
		<?php get_footer();?>
