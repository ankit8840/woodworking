<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Market
 */
?>
<?php get_template_part('modules/header/head'); ?>

<body <?php body_class(); ?>>
<div id="parallax-bg"></div>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>

    <?php get_template_part('modules/header/top','bar'); ?>
    <?php get_template_part('modules/header/masthead'); ?>
    <?php get_template_part('modules/header/header','nav');

		get_template_part('slider', 'nivo');
	?>
		 <div id="content" class="site-content container row clearfix clear">
		<div class="col-md-12"> 
