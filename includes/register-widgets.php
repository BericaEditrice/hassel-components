<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widgets_Manager;

// include esplicito dei file widget (best practice: niente glob in produzione)
require_once HASSEL_COMPONENTS_PATH . 'widgets/button-stagger.php';

add_action('elementor/widgets/register', function (Widgets_Manager $widgets_manager) {

    // Registra i widget uno per uno
    $widgets_manager->register(new \Hassel\Widgets\Button_Stagger());

});
