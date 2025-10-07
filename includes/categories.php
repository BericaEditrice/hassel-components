<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('elementor/elements/categories_registered', function ($elements_manager) {
    $elements_manager->add_category(
        'hassel-library',
        [
            'title' => __('Hassel Components', 'hassel-components'),
            'icon' => 'fa fa-puzzle-piece',
        ]
    );
});
