<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 3/27/2018
 * Time: 12:53 PM
 */

/**
 * market Theme Customizer
 *
 * @package market
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function market_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->default = "aaa";


}
add_action( 'customize_register', 'market_customize_register' );
//Load All Individual Settings Based on Sections/Panels.
require_once get_template_directory().'/framework/customizer/layouts.php';
require_once get_template_directory().'/framework/customizer/slider.php';
require_once get_template_directory().'/framework/customizer/sanitizations.php';
require_once get_template_directory().'/framework/customizer/header.php';
require_once get_template_directory().'/framework/customizer/skins&colors.php';
require_once get_template_directory().'/framework/customizer/social-icons.php';
require_once get_template_directory().'/framework/customizer/misc-scripts.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function market_customize_preview_js() {
    wp_enqueue_script( 'market_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'market_customize_preview_js' );
