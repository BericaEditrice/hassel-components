<?php
namespace Hassel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH'))
    exit;

class Button_Stagger extends Widget_Base
{

    public function get_name()
    {
        return 'hassel_button_stagger';
    }

    public function get_title()
    {
        return 'Button Stagger';
    }

    public function get_icon()
    {
        return 'eicon-button';
    }

    public function get_categories()
    {
        return ['hassel-library'];
    }

    public function get_style_depends()
    {
        return ['hassel-components-css'];
    }

    public function get_script_depends()
    {
        return ['hassel-components-js'];
    }

    protected function register_controls()
    {

        /* ----------- SEZIONE CONTENUTO ----------- */
        $this->start_controls_section('content_section', [
            'label' => 'Contenuto',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('text', [
            'label' => 'Testo',
            'type' => Controls_Manager::TEXT,
            'default' => 'Staggering Button',
        ]);

        $this->add_control('link', [
            'label' => 'Link',
            'type' => Controls_Manager::URL,
            'default' => ['url' => '#'],
        ]);

        $this->end_controls_section();


        /* ----------- SEZIONE STILE ----------- */
        $this->start_controls_section('style_section', [
            'label' => 'Stile',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        // TIPOGRAFIA
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .btn-animate-chars__text',
        ]);

        // STATI NORMALE / HOVER
        $this->start_controls_tabs('tabs_button_style');

        // ---- Normale ----
        $this->start_controls_tab('tab_button_normal', ['label' => 'Normale']);

        $this->add_control('text_color', [
            'label' => 'Colore testo',
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .btn-animate-chars' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('bg_color', [
            'label' => 'Colore sfondo',
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .btn-animate-chars__bg' => 'background-color: {{VALUE}};'],
        ]);

        $this->end_controls_tab();

        // ---- Hover ----
        $this->start_controls_tab('tab_button_hover', ['label' => 'Hover']);

        $this->add_control('hover_text_color', [
            'label' => 'Colore testo (hover)',
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .btn-animate-chars:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('hover_bg_color', [
            'label' => 'Colore sfondo (hover)',
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .btn-animate-chars:hover .btn-animate-chars__bg' => 'background-color: {{VALUE}};'],
        ]);

        // ✅ Unico set ANIMAZIONE (compare qui ma vale per entrata+uscita)
        $this->add_control('animation_duration', [
            'label' => 'Durata animazione (s)',
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'], // serve solo per rendere visibile lo slider
            'range' => [
                'px' => ['min' => 0.1, 'max' => 5, 'step' => 0.1],
            ],
            'default' => ['size' => 0.6, 'unit' => 'px'],
            'selectors' => [
                // Applicato agli elementi nello stato base così funziona sia in hover-in che in hover-out
                '{{WRAPPER}} .btn-animate-chars__bg' => 'transition-duration: {{SIZE}}s;',
                '{{WRAPPER}} .btn-animate-chars [data-button-animate-chars] span' => 'transition-duration: {{SIZE}}s;',
            ],
        ]);

        $this->add_control('animation_easing', [
            'label' => 'Tipo di animazione',
            'type' => Controls_Manager::SELECT,
            'default' => 'ease-in-out',
            'options' => [
                'ease' => 'Ease',
                'ease-in' => 'Ease In',
                'ease-out' => 'Ease Out',
                'ease-in-out' => 'Ease In-Out',
                'linear' => 'Linear',
                'cubic-bezier(0.625, 0.05, 0, 1)' => 'Custom (cubic-bezier)',
            ],
            'selectors' => [
                '{{WRAPPER}} .btn-animate-chars__bg' => 'transition-timing-function: {{VALUE}};',
                '{{WRAPPER}} .btn-animate-chars [data-button-animate-chars] span' => 'transition-timing-function: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // PADDING
        $this->add_responsive_control('padding', [
            'label' => 'Padding',
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'selectors' => [
                '{{WRAPPER}} .btn-animate-chars' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // BORDER
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'border',
            'selector' => '{{WRAPPER}} .btn-animate-chars__bg',
        ]);

        // BORDER RADIUS
        $this->add_responsive_control('border_radius', [
            'label' => 'Raggio bordo',
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .btn-animate-chars, {{WRAPPER}} .btn-animate-chars__bg' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // OMBRA
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'box_shadow',
            'selector' => '{{WRAPPER}} .btn-animate-chars__bg',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $link = $s['link']['url'] ?? '#';
        $target = !empty($s['link']['is_external']) ? ' target="_blank"' : '';
        $rel = !empty($s['link']['nofollow']) ? ' rel="nofollow"' : '';

        echo '<a href="' . esc_url($link) . '" aria-label="' . esc_attr($s['text']) . '" class="btn-animate-chars"' . $target . $rel . '>';
        echo '  <div class="btn-animate-chars__bg"></div>';
        echo '  <span data-button-animate-chars class="btn-animate-chars__text">'
            . esc_html($s['text']) .
            '</span>';
        echo '</a>';
    }
}
