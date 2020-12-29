<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 3/27/2018
 * Time: 12:50 PM
 */
function market_customize_register_skins( $wp_customize )
{

//Replace Header Text Color with, separate colors for Title and Description
//Override market_site_titlecolor
    $wp_customize->remove_control('display_header_text');
    $wp_customize->remove_setting('header_textcolor');
    $wp_customize->get_section('colors')->panel = 'market_design_panel';
    $wp_customize->get_section('background_image')->panel = 'market_design_panel';


    $wp_customize->add_setting('market_site_titlecolor', array(
        'default' => '#3a85ae',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'market_site_titlecolor', array(
            'label' => __('Site Title Color', 'market'),
            'section' => 'colors',
            'settings' => 'market_site_titlecolor',
            'type' => 'color'
        ))
    );
}
add_action( 'customize_register', 'market_customize_register_skins' );