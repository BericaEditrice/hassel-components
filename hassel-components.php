<?php
/**
 * Plugin Name: Hassel Components for Elementor
 * Plugin URI: https://github.com/BericaEditrice/hassel-components
 * Description: Libreria di componenti Elementor sviluppata da Hassel Omnichannel.
 * Version: 1.3.14
 * Author: Hassel Omnichannel
 * Author URI: https://hassel.it
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Text Domain: hassel-components
 * GitHub Plugin URI: BericaEditrice/hassel-components
 * Primary Branch: main
 */

if (!defined('ABSPATH'))
    exit;

// === Costanti ===
define('HASSEL_COMPONENTS_VERSION', '1.3.14');
define('HASSEL_COMPONENTS_PATH', plugin_dir_path(__FILE__));
define('HASSEL_COMPONENTS_URL', plugin_dir_url(__FILE__));

/**
 * Registra tutti gli asset (CSS/JS) dei widget.
 * Richiamata sia sul frontend classico sia nel contesto Elementor.
 */
function hassel_components_register_assets()
{

    // === Global ===
    wp_register_style(
        'hassel-components-css',
        HASSEL_COMPONENTS_URL . 'assets/css/style.css',
        [],
        HASSEL_COMPONENTS_VERSION
    );
    wp_register_script(
        'hassel-components-js',
        HASSEL_COMPONENTS_URL . 'assets/js/script.js',
        ['jquery'],
        HASSEL_COMPONENTS_VERSION,
        true
    );

    // === Scaling Hamburger Navigation ===
    wp_register_style(
        'hassel-scaling-hamburger-navigation-css',
        HASSEL_COMPONENTS_URL . 'assets/css/scaling-hamburger-navigation.css',
        [],
        HASSEL_COMPONENTS_VERSION
    );
    wp_register_script(
        'hassel-scaling-hamburger-navigation-js',
        HASSEL_COMPONENTS_URL . 'assets/js/scaling-hamburger-navigation.js',
        [],
        HASSEL_COMPONENTS_VERSION,
        true
    );

    // === Button Stagger ===
    wp_register_style(
        'hassel-button-stagger-css',
        HASSEL_COMPONENTS_URL . 'assets/css/button-stagger.css',
        [],
        HASSEL_COMPONENTS_VERSION
    );
    wp_register_script(
        'hassel-button-stagger-js',
        HASSEL_COMPONENTS_URL . 'assets/js/button-stagger.js',
        [],
        HASSEL_COMPONENTS_VERSION,
        true
    );

    // === Button Arrow Animated ===
    wp_register_style(
        'hassel-button-arrow-animated-css',
        HASSEL_COMPONENTS_URL . 'assets/css/button-arrow-animated.css',
        [],
        HASSEL_COMPONENTS_VERSION
    );
    wp_register_script(
        'hassel-button-arrow-animated-js',
        HASSEL_COMPONENTS_URL . 'assets/js/button-arrow-animated.js',
        [],
        HASSEL_COMPONENTS_VERSION,
        true
    );

    // === Hls.js da CDN (necessario per .m3u8 su browser non-Safari) ===
    wp_register_script(
        'hls-js',
        'https://cdn.jsdelivr.net/npm/hls.js@1.6.11/dist/hls.min.js',
        [],
        '1.6.11',
        true
    );

    // === Bunny HLS Player (ATTENZIONE: 'hls' nei path, non 'hsl') ===
    wp_register_style(
        'hassel-bunny-hls-player-css',
        HASSEL_COMPONENTS_URL . 'assets/css/bunny-hls-player.css',
        [],
        HASSEL_COMPONENTS_VERSION
    );
    wp_register_script(
        'hassel-bunny-hls-player-js',
        HASSEL_COMPONENTS_URL . 'assets/js/bunny-hls-player.js',
        ['jquery', 'elementor-frontend', 'hls-js'], // dipendenze corrette
        HASSEL_COMPONENTS_VERSION,
        true
    );
}

add_action('plugins_loaded', function () {

    // Elementor non caricato?
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p><strong>Hassel Components</strong>: ' .
                esc_html__('richiede Elementor attivo per funzionare.', 'hassel-components') .
                '</p></div>';
        });
        return;
    }

    // Registra gli asset nel frontend classico
    add_action('wp_enqueue_scripts', 'hassel_components_register_assets', 9);

    // Registra gli asset anche nel contesto di Elementor (iframe editor/anteprima)
    add_action('elementor/frontend/after_register_scripts', 'hassel_components_register_assets', 9);
    add_action('elementor/frontend/after_enqueue_styles', 'hassel_components_register_assets', 9);

    // Includes
    require_once HASSEL_COMPONENTS_PATH . 'includes/categories.php';
    require_once HASSEL_COMPONENTS_PATH . 'includes/register-widgets.php';
});
