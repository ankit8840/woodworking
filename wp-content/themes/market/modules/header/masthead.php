<div id="header-top">
    <header id="masthead" class="site-header row container" role="banner">
        <div class="site-branding col-md-6 col-xs-12">
            <?php if ( has_custom_logo() ) : ?>
            <div id="site-logo">
                <?php the_custom_logo(); ?>
            </div>
            <?php else : ?>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
            <?php
            endif;
            ?>
        </div>

        <?php
        get_template_part('modules/social/social', 'default');
        ?>

    </header><!-- #masthead -->
</div>
