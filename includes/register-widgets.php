<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Hook per registrare automaticamente i widget nella cartella /widgets
add_action( 'elementor/widgets/register', function( $widgets_manager ) {

    // Percorso della cartella dei widget
    $widgets_dir = HASSEL_COMPONENTS_PATH . 'widgets/';

    // Carica tutti i file PHP dentro /widgets
    foreach ( glob( $widgets_dir . '*.php' ) as $file ) {
        require_once $file;
    }

    // Registra ogni classe che estende Elementor\Widget_Base
    foreach ( get_declared_classes() as $class ) {
        if ( is_subclass_of( $class, '\Elementor\Widget_Base' ) && strpos( $class, 'Hassel\\Widgets\\' ) === 0 ) {
            $widgets_manager->register( new $class() );
        }
    }
});
