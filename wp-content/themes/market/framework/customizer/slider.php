<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 3/27/2018
 * Time: 12:34 PM
 */
function market_customize_register_slider( $wp_customize ) {

// SLIDER PANEL
$wp_customize->add_panel( 'market_slider_panel', array(
    'priority'       => 35,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => 'Main Slider',
) );

$wp_customize->add_section(
    'market_sec_slider_options',
    array(
        'title'     => __('Enable/Disable','market'),
        'priority'  => 0,
        'panel'     => 'market_slider_panel'
    )
);


$wp_customize->add_setting(
    'market_main_slider_enable',
    array( 'sanitize_callback' => 'market_sanitize_checkbox' )
);

$wp_customize->add_control(
    'market_main_slider_enable', array(
        'settings' => 'market_main_slider_enable',
        'label'    => __( 'Enable Slider.', 'market' ),
        'section'  => 'market_sec_slider_options',
        'type'     => 'checkbox',
    )
);

$wp_customize->add_setting(
    'market_main_slider_count',
    array(
        'default' => '0',
        'sanitize_callback' => 'market_sanitize_positive_number'
    )
);

// Select How Many Slides the User wants, and Reload the Page.
$wp_customize->add_control(
    'market_main_slider_count', array(
        'settings' => 'market_main_slider_count',
        'label'    => __( 'No. of Slides(Min:0, Max: 5)' ,'market'),
        'section'  => 'market_sec_slider_options',
        'type'     => 'number',
        'description' => __('Save the Settings, and Reload this page to Configure the Slides.','market'),

    )
);



if ( get_theme_mod('market_main_slider_count') > 0 ) :
    $slides = get_theme_mod('market_main_slider_count');

    for ( $i = 1 ; $i <= $slides ; $i++ ) :

        //Create the settings Once, and Loop through it.

        $wp_customize->add_setting(
            'market_slide_img'.$i,
            array( 'sanitize_callback' => 'esc_url_raw' )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'market_slide_img'.$i,
                array(
                    'label' => '',
                    'section' => 'market_slide_sec'.$i,
                    'settings' => 'market_slide_img'.$i,
                )
            )
        );


        $wp_customize->add_section(
            'market_slide_sec'.$i,
            array(
                'title'     => 'Slide '.$i,
                'priority'  => $i,
                'panel'     => 'market_slider_panel'
            )
        );

        $wp_customize->add_setting(
            'market_slide_title'.$i,
            array( 'sanitize_callback' => 'sanitize_text_field' )
        );

        $wp_customize->add_control(
            'market_slide_title'.$i, array(
                'settings' => 'market_slide_title'.$i,
                'label'    => __( 'Slide Title','market' ),
                'section'  => 'market_slide_sec'.$i,
                'type'     => 'text',
            )
        );

        $wp_customize->add_setting(
            'market_slide_desc'.$i,
            array( 'sanitize_callback' => 'sanitize_text_field' )
        );

        $wp_customize->add_control(
            'market_slide_desc'.$i, array(
                'settings' => 'market_slide_desc'.$i,
                'label'    => __( 'Slide Description','market' ),
                'section'  => 'market_slide_sec'.$i,
                'type'     => 'text',
            )
        );


        $wp_customize->add_setting(
            'market_slide_url'.$i,
            array( 'sanitize_callback' => 'esc_url_raw' )
        );

        $wp_customize->add_control(
            'market_slide_url'.$i, array(
                'settings' => 'market_slide_url'.$i,
                'label'    => __( 'Target URL','market' ),
                'section'  => 'market_slide_sec'.$i,
                'type'     => 'url',
            )
        );

    endfor;


endif;
}
add_action( 'customize_register', 'market_customize_register_slider' );