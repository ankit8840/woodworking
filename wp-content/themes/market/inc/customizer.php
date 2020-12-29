<?php
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


    //Logo Settings
    $wp_customize->add_section( 'title_tagline' , array(
        'title'      => __( 'Title, Tagline & Logo', 'market' ),
        'priority'   => 30,
    ) );

    $wp_customize->add_setting( 'market_logo' , array(
        'default'     => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'market_logo',
            array(
                'label' => __('Upload Logo','market'),
                'section' => 'title_tagline',
                'settings' => 'market_logo',
                'priority' => 5,
            )
        )
    );



    //Replace Header Text Color with, separate colors for Title and Description
    //Override market_site_titlecolor
    $wp_customize->remove_control('display_header_text');
    $wp_customize->remove_setting('header_textcolor');
    $wp_customize->add_setting('market_site_titlecolor', array(
        'default'     => '#3a85ae',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'market_site_titlecolor', array(
            'label' => __('Site Title Color','market'),
            'section' => 'colors',
            'settings' => 'market_site_titlecolor',
            'type' => 'color'
        ) )
    );

    //Settings For Logo Area

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

    if (class_exists('WP_Customize_Control')) {
        class market_WP_Customize_Upgrade_Control extends WP_Customize_Control {
            /**
             * Render the control's content.
             */
            public function render_content() {
                printf(
                    '<label class="customize-control-upgrade"><span class="customize-control-title"><i class="fa fa-star"></i>%s</span> %s</label>',
                    $this->label,
                    $this->description
                );
            }
        }
    }


    //Upgrade
    $wp_customize->add_section(
        'market_sec_help',
        array(
            'title'     => __('MARKET Theme - Help & Support','market'),
            'priority'  => 40,
        )
    );

    $wp_customize->add_setting(
        'market_help',
        array( 'sanitize_callback' => 'esc_textarea' )
    );

    $wp_customize->add_control(
        new market_WP_Customize_Upgrade_Control(
            $wp_customize,
            'market_help',
            array(
                'label' => __('Visit Rohitink.com For Help','market'),
                'description' => __('Hello, Thanks for Downloading Market Pro. Due to a Huge no. of People who use Market Free Version, I can not answer all your queries. But I will try my best to answer your Queries. But for Bugs/Issues, We try to fix them ASAP. To Report a Bug or Ask for Help - <a href="https://rohitink.com/2014/03/13/market/">Click Here</a>.','market'),
                'section' => 'market_sec_help',
                'settings' => 'market_help',
            )
        )
    );

    $wp_customize->add_section(
        'market_sec_upgrade',
        array(
            'title'     => __('#Discover MARKET PRO','market'),
            'priority'  => 40,
        )
    );

    $wp_customize->add_setting(
        'market_upgrade',
        array( 'sanitize_callback' => 'esc_textarea' )
    );

    $wp_customize->add_control(
        new market_WP_Customize_Upgrade_Control(
            $wp_customize,
            'market_upgrade',
            array(
                'label' => __('More of Everything','market'),
                'description' => __('Market Pro has more of Everything. More New Features, More Options, Unlimited Designs, More Fonts, More Layouts, Configurable Slider, Inbuilt Advertising Options, More Widgets, Unlimited Colors and a lot more options and comes with Dedicated Support. To Know More about the Pro Version, click here: <a href="http://rohitink.com/product/market-pro/">Upgrade to Pro</a>.','market'),
                'section' => 'market_sec_upgrade',
                'settings' => 'market_upgrade',
            )
        )
    );


    class market_Custom_CSS_Control extends WP_Customize_Control {
        public $type = 'textarea';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
            </label>
            <?php
        }
    }

    $wp_customize-> add_section(
        'market_custom_codes',
        array(
            'title'			=> __('Custom CSS','market'),
            'description'	=> __('Enter your Custom CSS to Modify design.','market'),
            'priority'		=> 41,
        )
    );

    $wp_customize->add_setting(
        'market_custom_css',
        array(
            'default'		=> '',
            'capability'           => 'edit_theme_options',
            'sanitize_callback'    => 'wp_filter_nohtml_kses',
            'sanitize_js_callback' => 'wp_filter_nohtml_kses'
        )
    );

    $wp_customize->add_control(
        new market_Custom_CSS_Control(
            $wp_customize,
            'market_custom_css',
            array(
                'section' => 'market_custom_codes',


            )
        )
    );

    function market_sanitize_text( $input ) {
        return wp_kses_post( force_balance_tags( $input ) );
    }

    $wp_customize-> add_section(
        'market_custom_footer',
        array(
            'title'			=> __('Custom Footer Text','market'),
            'description'	=> __('Enter your Own Copyright Text.','market'),
            'priority'		=> 42,
        )
    );

    $wp_customize->add_setting(
        'market_footer_text',
        array(
            'default'		=> '',
            'sanitize_callback'	=> 'sanitize_text_field'
        )
    );

    $wp_customize->add_control(
        'market_footer_text',
        array(
            'section' => 'market_custom_footer',
            'settings' => 'market_footer_text',
            'type' => 'text'
        )
    );


    // Social Icons
    $wp_customize->add_section('market_social_section', array(
        'title' => __('Social Icons','market'),
        'priority' => 44 ,
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
            'google-plus',
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


    /* Sanitization Functions Common to Multiple Settings go Here, Specific Sanitization Functions are defined along with add_setting() */
    function market_sanitize_checkbox( $input ) {
        if ( $input == 1 ) {
            return 1;
        } else {
            return '';
        }
    }

    function market_sanitize_positive_number( $input ) {
        if ( ($input >= 0) && is_numeric($input) )
            return $input;
        else
            return '';
    }

    function market_sanitize_category( $input ) {
        if ( term_exists(get_cat_name( $input ), 'category') )
            return $input;
        else
            return '';
    }


}
add_action( 'customize_register', 'market_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function market_customize_preview_js() {
    wp_enqueue_script( 'market_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'market_customize_preview_js' );
