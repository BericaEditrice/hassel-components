<?php
namespace Hassel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

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
        return __('Button Stagger', 'hassel-components');
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
        return ['hassel-button-stagger-css'];
    }
    public function get_script_depends()
    {
        return ['hassel-button-stagger-js'];
    }

    protected function register_controls()
    {
        /* ----------- CONTENUTO ----------- */
        $this->start_controls_section('content_section', [
            'label' => __('Contenuto', 'hassel-components'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('text', [
            'label' => __('Testo', 'hassel-components'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Staggering Button',
        ]);
        $this->add_control('link', [
            'label' => __('Link', 'hassel-components'),
            'type' => Controls_Manager::URL,
            'default' => ['url' => '#'],
        ]);
        $this->end_controls_section();

        /* ----------- STILE ----------- */
        $this->start_controls_section('style_section', [
            'label' => __('Stile', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .btn-animate-chars__text',
        ]);

        $this->start_controls_tabs('tabs_button_style');
        // Normale
        $this->start_controls_tab('tab_normal', ['label' => __('Normale', 'hassel-components')]);
        $this->add_control('text_color', [
            'label' => __('Colore testo', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .btn-animate-chars' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('bg_color', [
            'label' => __('Colore sfondo', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .btn-animate-chars__bg' => 'background-color: {{VALUE}};'],
        ]);
        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab('tab_hover', ['label' => __('Hover', 'hassel-components')]);
        $this->add_control('hover_text_color', [
            'label' => __('Colore testo (hover)', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .btn-animate-chars:hover' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('hover_bg_color', [
            'label' => __('Colore sfondo (hover)', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .btn-animate-chars:hover .btn-animate-chars__bg' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_control('hover_animation_duration', [
            'label' => __('Durata animazione hover (s)', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['s' => ['min' => 0.1, 'max' => 5, 'step' => 0.1]],
            'default' => ['unit' => 's', 'size' => 0.6],
            'selectors' => [
                '{{WRAPPER}} .btn-animate-chars__bg' => 'transition-duration: {{SIZE}}s;',
                '{{WRAPPER}} .btn-animate-chars [data-button-animate-chars] span' => 'transition-duration: {{SIZE}}s;',
            ],
        ]);
        $this->add_control('animation_easing', [
            'label' => __('Tipo di animazione', 'hassel-components'),
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

        $this->add_responsive_control('padding', [
            'label' => __('Padding', 'hassel-components'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'selectors' => ['{{WRAPPER}} .btn-animate-chars' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'border',
            'selector' => '{{WRAPPER}} .btn-animate-chars__bg',
        ]);
        $this->add_responsive_control('border_radius', [
            'label' => __('Raggio bordo', 'hassel-components'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .btn-animate-chars, {{WRAPPER}} .btn-animate-chars__bg' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
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
        echo '  <span data-button-animate-chars class="btn-animate-chars__text">' . esc_html($s['text']) . '</span>';
        echo '</a>';
    }
}
