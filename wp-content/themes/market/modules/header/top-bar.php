<div id="top-bar">
    <div class="container">

        <div id="top-search-form" class="col-md-12">
            <?php get_template_part('searchform', 'top'); ?>
        </div>

        <?php get_template_part('modules/navigation/top','menu'); ?>

        <div class="top-icons-container col-md-3">

            <?php if (class_exists('woocommerce')) :
                ?>
                <div class="top-cart-icon">
                    <i class="fa fa-shopping-cart"></i>
                    <?php
                    global $woocommerce; ?>

                    <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php esc_html_e('View your shopping cart', 'market'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'market'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
                </div>
            <?php endif; ?>
            <div class="top-search-icon">
                <i class="fa fa-search"></i>
            </div>
        </div>

    </div>
</div><!--#top-bar-->
