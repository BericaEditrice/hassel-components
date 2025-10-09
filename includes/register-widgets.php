<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widgets_Manager;

add_action('elementor/widgets/register', function (Widgets_Manager $widgets_manager) {

    // --- BUTTON STAGGER ---
    require_once HASSEL_COMPONENTS_PATH . 'widgets/button-stagger.php';
    $widgets_manager->register(new \Hassel\Widgets\Button_Stagger());

    // --- SCALING HAMBURGER NAVIGATION ---
    require_once HASSEL_COMPONENTS_PATH . 'widgets/scaling-hamburger-navigation.php';
    require_once HASSEL_COMPONENTS_PATH . 'includes/class-scaling-hamburger-navigation-walker.php';
    $widgets_manager->register(new \Hassel\Widgets\Scaling_Hamburger_Navigation());

}, 20); // "20" assicura che Elementor sia già caricato
