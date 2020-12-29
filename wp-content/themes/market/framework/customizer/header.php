<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 3/27/2018
 * Time: 12:28 PM
 */
function market_customize_register_header( $wp_customize )
{
    $wp_customize->add_panel( 'market_header_panel', array(
        'priority'       => 3,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Header Panel','market'),
    ) );

    //Logo Settings
    $wp_customize->add_section( 'title_tagline' , array(
        'title'      => __( 'Title, Tagline & Logo', 'market' ),
        'priority'   => 1,
        'panel'      => 'market_header_panel'
    ) );

    $wp_customize->add_setting(
        'market_hide_title_tagline',
        array( 'sanitize_callback' => 'market_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'market_hide_title_tagline', array(
            'settings' => 'market_hide_title_tagline',
            'label'    => __( 'Hide Title and Tagline.', 'market' ),
            'section'  => 'title_tagline',
            'type'     => 'checkbox',
        )
    );

    function market_title_visible( $control ) {
        $option = $control->manager->get_setting('market_hide_title_tagline');
        return $option->value() == false ;
    }

}
add_action( 'customize_register', 'market_customize_register_header' );