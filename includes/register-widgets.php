<?php
if (!defined('ABSPATH'))
    exit;

use Elementor\Widgets_Manager;

add_action('elementor/widgets/register', function (Widgets_Manager $widgets_manager) {

    require_once HASSEL_COMPONENTS_PATH . 'widgets/button-stagger.php';
    require_once HASSEL_COMPONENTS_PATH . 'includes/class-scaling-hamburger-navigation-walker.php';
    require_once HASSEL_COMPONENTS_PATH . 'widgets/scaling-hamburger-navigation.php';

    $widgets_manager->register(new \Hassel\Widgets\Button_Stagger());
    $widgets_manager->register(new \Hassel\Widgets\Scaling_Hamburger_Navigation());

}, 20);
