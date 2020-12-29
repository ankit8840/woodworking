<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 3/22/2018
 * Time: 1:39 PM
 */

function market_custom_css_mods() {

    $custom_css = "";

    if ( get_theme_mod('market_site_titlecolor','#aaa') ) :
        $custom_css .= ".site-title a { color: ".get_theme_mod('market_site_titlecolor', '#aaa')."; }";
    endif;


    if ( get_theme_mod('market_header_desccolor','#aaa') ) :
        $custom_css .= ".site-description { color: ".get_theme_mod('market_header_desccolor','#aaa')."; }";
    endif;

    if ( get_theme_mod('market_hide_title_tagline')) :
        $custom_css .= "#masthead h2.site-description, #masthead h1.site-title { display:none; }
                        #social-icons{margin-bottom: 30px;}";
    endif;


    wp_add_inline_style( 'market-main-skin', wp_strip_all_tags($custom_css) );

}

add_action('wp_enqueue_scripts', 'market_custom_css_mods');