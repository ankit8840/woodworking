<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 3/27/2018
 * Time: 12:52 PM
 */
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
