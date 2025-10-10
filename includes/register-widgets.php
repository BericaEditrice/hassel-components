<?php
if (!defined('ABSPATH'))
    exit;

use Elementor\Widgets_Manager;

/**
 * =====================================================
 *  REGISTER HESSEL CUSTOM WIDGETS
 * =====================================================
 */
add_action('elementor/widgets/register', function (Widgets_Manager $widgets_manager) {

    // === Include dependencies ===
    require_once HASSEL_COMPONENTS_PATH . 'includes/class-scaling-hamburger-navigation-walker.php';

    // === Widgets ===
    require_once HASSEL_COMPONENTS_PATH . 'widgets/button-stagger.php';
    require_once HASSEL_COMPONENTS_PATH . 'widgets/scaling-hamburger-navigation.php';
    require_once HASSEL_COMPONENTS_PATH . 'widgets/button-arrow-animated.php';

    // === Register ===
    $widgets_manager->register(new \Hassel\Widgets\Button_Stagger());
    $widgets_manager->register(new \Hassel\Widgets\Scaling_Hamburger_Navigation());
    $widgets_manager->register(new \Hassel\Widgets\Button_Arrow_Animated());

}, 20);
