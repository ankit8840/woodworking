<div id="social-icons" class="col-md-5 col-xs-12">
<?php for ($i = 1; $i < 8; $i++) : 
							$social = esc_html(get_theme_mod('market_social_'.$i));
							if ( ($social != 'none') && ($social != '') ) : ?>
							<a href="<?php echo esc_url(get_theme_mod('market_social_url'.$i)); ?>"><img src="<?php echo get_template_directory_uri().'/images/social/default/'.$social.'.png'; ?>"></i></a>
							<?php endif;
						
						endfor; ?>
</div> 