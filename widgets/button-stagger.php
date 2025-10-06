<?php
namespace Hassel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Button_Stagger extends Widget_Base {

    public function get_name() {
        return 'hassel_button_stagger';
    }

    public function get_title() {
        return 'Button Stagger';
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return [ 'hassel-library' ];
    }

    public function get_style_depends() {
        return [ 'hassel-components-css' ];
    }

    public function get_script_depends() {
        return [ 'hassel-components-js' ];
    }

    protected function register_controls() {

        /* ----------- SEZIONE CONTENUTO ----------- */
        $this->start_controls_section( 'content_section', [
            'label' => 'Contenuto',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control( 'text', [
            'label' => 'Testo',
            'type' => Controls_Manager::TEXT,
            'default' => 'Staggering Button',
        ]);

        $this->add_control( 'link', [
            'label' => 'Link',
            'type' => Controls_Manager::URL,
            'default' => [ 'url' => '#' ],
        ]);

        $this->end_controls_section();


        /* ----------- SEZIONE STILE ----------- */
        $this->start_controls_section( 'style_section', [
            'label' => 'Stile',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        // tipografia
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .btn-animate-chars__text',
        ]);

        // colore del testo
        $this->add_control( 'text_color', [
            'label' => 'Colore testo',
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .btn-animate-chars' => 'color: {{VALUE}};' ],
            'default' => '#131313',
        ]);

        // colore di sfondo
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name' => 'background',
            'label' => 'Sfondo',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .btn-animate-chars__bg',
        ]);

        // padding
        $this->add_responsive_control( 'padding', [
            'label' => 'Padding',
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .btn-animate-chars' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'default' => [
                'top' => 1,
                'right' => 1,
                'bottom' => 1,
                'left' => 1,
                'unit' => 'em',
            ],
        ]);

        // border radius
        $this->add_control( 'border_radius', [
            'label' => 'Raggio bordo',
            'type' => Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
            'selectors' => [
                '{{WRAPPER}} .btn-animate-chars, {{WRAPPER}} .btn-animate-chars__bg' =>
                    'border-radius: {{SIZE}}px;',
            ],
            'default' => [ 'size' => 4 ],
        ]);

        // ombra opzionale
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name' => 'box_shadow',
            'selector' => '{{WRAPPER}} .btn-animate-chars__bg',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $link = $s['link']['url'] ?? '#';
        $target = $s['link']['is_external'] ? ' target="_blank"' : '';
        $rel = $s['link']['nofollow'] ? ' rel="nofollow"' : '';

        echo '<a href="' . esc_url($link) . '" aria-label="Staggering button" class="btn-animate-chars"' . $target . $rel . '>';
        echo '  <div class="btn-animate-chars__bg"></div>';
        echo '  <span data-button-animate-chars class="btn-animate-chars__text">'
              . esc_html($s['text']) .
              '</span>';
        echo '</a>';
    }
}
