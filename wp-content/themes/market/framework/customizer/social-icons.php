<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 3/27/2018
 * Time: 12:32 PM
 */
function market_customize_register_social( $wp_customize )
{
    // Social Icons
    $wp_customize->add_section('market_social_section', array(
        'title' => __('Social Icons','market'),
        'priority' => 2,
        'panel'      => 'market_header_panel'

    ));

    $social_networks = array( //Redefinied in Sanitization Function.
        'none' => __('-','market'),
        'facebook' => __('Facebook','market'),
        'twitter' => __('Twitter','market'),
        'google' => __('Google Plus','market'),
        'instagram' => __('Instagram','market'),
        'rss' => __('RSS Feeds','market'),
        'flickr' => __('Flickr','market'),
        'linkedin' => __('Linkedin','market'),
        'pinterest' => __('Pinterest','market'),
        'soundcloud' => __('Soundcloud','market'),
        'vimeo' => __('Vimeo','market'),
        'vine' => __('Vine','market'),
        'yelp' => __('Yelp','market'),
        'youtube' => __('Youtube','market'),

    );

    $social_count = count($social_networks);

    for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :

        $wp_customize->add_setting(
            'market_social_'.$x, array(
            'sanitize_callback' => 'market_sanitize_social',
            'default' => 'none'
        ));

        $wp_customize->add_control( 'market_social_'.$x, array(
            'settings' => 'market_social_'.$x,
            'label' => __('Icon ','market').$x,
            'section' => 'market_social_section',
            'type' => 'select',
            'choices' => $social_networks,
        ));

        $wp_customize->add_setting(
            'market_social_url'.$x, array(
            'sanitize_callback' => 'esc_url_raw'
        ));

        $wp_customize->add_control( 'market_social_url'.$x, array(
            'settings' => 'market_social_url'.$x,
            'description' => __('Icon ','market').$x.__(' Url','market'),
            'section' => 'market_social_section',
            'type' => 'url',
            'choices' => $social_networks,
        ));

    endfor;

    function market_sanitize_social( $input ) {
        $social_networks = array(
            'none' ,
            'facebook',
            'twitter',
            'google',
            'instagram',
            'rss',
            'flickr',
            'linkedin',
            'pinterest',
            'soundcloud',
            'vimeo',
            'vine',
            'yelp',
            'youtube'
        );
        if ( in_array($input, $social_networks) )
            return $input;
        else
            return '';
    }

}
add_action( 'customize_register', 'market_customize_register_social' );