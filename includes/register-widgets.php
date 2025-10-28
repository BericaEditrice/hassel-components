<?php
if (!defined('ABSPATH'))
    exit;

/**
 * =====================================================
 *  REGISTER HASSEL CUSTOM WIDGETS (robust)
 * =====================================================
 */
add_action('elementor/widgets/register', function ($widgets_manager) {

    // === Include dependencies (walker, ecc.) ===
    require_once HASSEL_COMPONENTS_PATH . 'includes/class-scaling-hamburger-navigation-walker.php';

    // === Widgets ===
    // Attento ai path: devono esistere esattamente con questi nomi
    require_once HASSEL_COMPONENTS_PATH . 'widgets/button-stagger.php';
    require_once HASSEL_COMPONENTS_PATH . 'widgets/scaling-hamburger-navigation.php';
    require_once HASSEL_COMPONENTS_PATH . 'widgets/button-arrow-animated.php';
    // require_once HASSEL_COMPONENTS_PATH . 'widgets/bunny-hls-player.php';

    // === Register (safe) ===
    if (class_exists('\Hassel\Widgets\Button_Stagger')) {
        $widgets_manager->register(new \Hassel\Widgets\Button_Stagger());
    }
    if (class_exists('\Hassel\Widgets\Scaling_Hamburger_Navigation')) {
        $widgets_manager->register(new \Hassel\Widgets\Scaling_Hamburger_Navigation());
    }
    if (class_exists('\Hassel\Widgets\Button_Arrow_Animated')) {
        $widgets_manager->register(new \Hassel\Widgets\Button_Arrow_Animated());
    }
    if (class_exists('\Hassel\Widgets\Bunny_HLS_Player')) {
        // $widgets_manager->register(new \Hassel\Widgets\Bunny_HLS_Player());
    }

}, 20);
