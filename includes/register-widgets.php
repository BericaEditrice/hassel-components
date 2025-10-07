<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widgets_Manager;

add_action('elementor/widgets/register', function (Widgets_Manager $widgets_manager) {

    // Includiamo qui (dentro l’hook), così Elementor è già caricato
    require_once HASSEL_COMPONENTS_PATH . 'widgets/button-stagger.php';

    // Registra i widget uno per uno
    $widgets_manager->register(new \Hassel\Widgets\Button_Stagger());

}, 20); // il "20" garantisce che venga dopo l’inizializzazione di Elementor
