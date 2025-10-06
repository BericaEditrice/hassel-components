<?php
/**
 * Plugin Name: Hassel Components for Elementor
 * Plugin URI: https://github.com/BericaEditrice/hassel-components
 * Description: Libreria di componenti Elementor sviluppata da Hassel Omnichannel.
 * Version: 1.0.34
 * Author: Hassel Omnichannel
 * Author URI: https://hassel.it
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * GitHub Plugin URI: BericaEditrice/hassel-components
 * Primary Branch: main
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Definizioni globali del plugin
define( 'HASSEL_COMPONENTS_VERSION', '1.0.4' );
define( 'HASSEL_COMPONENTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'HASSEL_COMPONENTS_URL', plugin_dir_url( __FILE__ ) );

// Esegui tutto solo se Elementor è attivo
add_action( 'plugins_loaded', function() {

    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-error"><p><strong>Hassel Components</strong> richiede Elementor attivo per funzionare.</p></div>';
        });
        return;
    }

    // Includi le categorie e la registrazione dei widget
    require_once HASSEL_COMPONENTS_PATH . 'includes/categories.php';
    require_once HASSEL_COMPONENTS_PATH . 'includes/register-widgets.php';

    // Registra CSS e JS globali (caricati solo se un widget ne ha bisogno)
    add_action( 'wp_enqueue_scripts', function() {
        wp_register_style( 'hassel-components-css', HASSEL_COMPONENTS_URL . 'assets/css/style.css', [], HASSEL_COMPONENTS_VERSION );
        wp_register_script( 'hassel-components-js', HASSEL_COMPONENTS_URL . 'assets/js/script.js', [ 'jquery' ], HASSEL_COMPONENTS_VERSION, true );
    });
});
