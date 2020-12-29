<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 3/27/2018
 * Time: 12:30 PM
 */
function market_customize_register_misc( $wp_customize )
{

//Upgrade
    $wp_customize->add_section(
        'market_sec_help',
        array(
            'title' => __('MARKET Theme - Help & Support', 'market'),
            'priority' => 1,
        )
    );

    $wp_customize->add_setting(
        'market_help',
        array('sanitize_callback' => 'esc_textarea')
    );

    $wp_customize->add_control(
        new market_WP_Customize_Upgrade_Control(
            $wp_customize,
            'market_help',
            array(
                'label' => __('Visit inkhive.com For Help', 'market'),
                'description' => __('Hello, Thanks for Downloading Market Pro. Due to a Huge no. of People who use Market Free Version, I can not answer all your queries. But I will try my best to answer your Queries. But for Bugs/Issues, We try to fix them ASAP. To Report a Bug or Ask for Help - <a href="https://inkhive.com/free-theme-support/">Click Here</a>.', 'market'),
                'section' => 'market_sec_help',
                'settings' => 'market_help',
            )
        )
    );

    $wp_customize->add_section(
        'market_sec_upgrade',
        array(
            'title' => __('Discover MARKET PRO', 'market'),
            'priority' => 2,
        )
    );

    $wp_customize->add_setting(
        'market_upgrade',
        array('sanitize_callback' => 'esc_textarea')
    );

    $wp_customize->add_control(
        new market_WP_Customize_Upgrade_Control(
            $wp_customize,
            'market_upgrade',
            array(
                'label' => __('More of Everything', 'market'),
                'description' => __('Market Pro has more of Everything. More New Features, More Options, Unlimited Designs, More Fonts, More Layouts, Configurable Slider, Inbuilt Advertising Options, More Widgets, Unlimited Colors and a lot more options and comes with Dedicated Support. To Know More about the Pro Version, click here: <a href="https://inkhive.com/product/market-pro/">Upgrade to Pro</a>.', 'market'),
                'section' => 'market_sec_upgrade',
                'settings' => 'market_upgrade',
            )
        )
    );
}
add_action( 'customize_register', 'market_customize_register_misc' );