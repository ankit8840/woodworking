<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 3/27/2018
 * Time: 12:43 PM
 */
function market_customize_register_layouts( $wp_customize ) {
    $wp_customize->add_panel( 'market_design_panel', array(
        'priority'       => 5,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Design & Layout','market'),
    ) );
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
            'panel'         => 'market_design_panel'
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
            'panel'         => 'market_design_panel'
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
    //Replace Header Text Color with, separate colors for Title and Description
    //Override market_site_titlecolor
    $wp_customize->remove_control('display_header_text');
    $wp_customize->remove_setting('header_textcolor');
    //$wp_customize->remove_setting('background_color');
    $wp_customize->add_setting('market_site_titlecolor', array(
        'default'     => '#aaa',
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

    $wp_customize->add_setting('market_header_desccolor', array(
        'default'     => '#aaa',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'market_header_desccolor', array(
            'label' => __('Site Tagline Color','market'),
            'section' => 'colors',
            'settings' => 'market_header_desccolor',
            'type' => 'color'
        ) )
    );

}
add_action( 'customize_register', 'market_customize_register_layouts' );