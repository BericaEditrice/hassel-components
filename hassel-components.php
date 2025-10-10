<?php
/**
 * Plugin Name: Hassel Components for Elementor
 * Plugin URI: https://github.com/BericaEditrice/hassel-components
 * Description: Libreria di componenti Elementor sviluppata da Hassel Omnichannel.
 * Version: 1.1.16
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
define('HASSEL_COMPONENTS_VERSION', '1.1.16');
define('HASSEL_COMPONENTS_PATH', plugin_dir_path(__FILE__));
define('HASSEL_COMPONENTS_URL', plugin_dir_url(__FILE__));

// === Avvio plugin solo se Elementor è attivo ===
add_action('plugins_loaded', function () {

    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p><strong>Hassel Components</strong>: ' .
                esc_html__('richiede Elementor attivo per funzionare.', 'hassel-components') .
                '</p></div>';
        });
        return;
    }

    /**
     * =====================================================
     *  ASSET REGISTRATION
     * =====================================================
     */
    add_action('wp_enqueue_scripts', function () {

        // === Global Styles ===
        wp_register_style(
            'hassel-components-css',
            HASSEL_COMPONENTS_URL . 'assets/css/style.css',
            [],
            HASSEL_COMPONENTS_VERSION
        );

        // === Global Scripts ===
        wp_register_script(
            'hassel-components-js',
            HASSEL_COMPONENTS_URL . 'assets/js/script.js',
            ['jquery'],
            HASSEL_COMPONENTS_VERSION,
            true
        );

        /**
         * =======================================
         *  WIDGET: SCALING HAMBURGER NAVIGATION
         * =======================================
         */
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

        /**
         * =======================================
         *  WIDGET: BUTTON STAGGER
         * =======================================
         */
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
    });

    /**
     * =====================================================
     *  INCLUDES
     * =====================================================
     */
    require_once HASSEL_COMPONENTS_PATH . 'includes/categories.php';
    require_once HASSEL_COMPONENTS_PATH . 'includes/register-widgets.php';
});
