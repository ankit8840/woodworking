<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Market
 */
?>
	</div>
	</div><!-- #content -->
	<?php get_sidebar('footer'); ?>
	<footer id="colophon" class="site-footer row" role="contentinfo">
	<div class="container">
		<div class="site-info col-md-4">
			<?php do_action( 'market_credits' ); ?>
			<?php printf( __( 'Powered by %1$s', 'market' ), '<a rel="nofollow" target="_blank" href="http://rohitink.com/2014/03/13/market/">Market Theme</a>' ); ?>
		</div><!-- .site-info -->
		<div id="footertext" class="col-md-7">
			<?php echo esc_html(get_theme_mod('market_footer_text')); ?> 
        </div>
	</div>   
	</footer><!-- #colophon -->
	
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>