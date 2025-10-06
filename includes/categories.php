<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Crea una categoria personalizzata in Elementor
add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
    $elements_manager->add_category(
        'hassel-library',
        [
            'title' => 'Hassel Components',
            'icon'  => 'fa fa-puzzle-piece', // icona che vedi nel pannello Elementor
        ]
    );
});