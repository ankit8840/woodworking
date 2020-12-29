<div class="default-nav-wrapper col-md-11 col-xs-12">
    <nav id="site-navigation" class="main-navigation" role="navigation">
        <div id="nav-container">
            <h1 class="menu-toggle"></h1>
            <div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'market' ); ?>"><?php esc_html_e( 'Skip to content', 'market' ); ?></a></div>

            <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
        </div>
    </nav><!-- #site-navigation -->
</div>
