<?php
namespace Hassel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH'))
    exit;

class Button_Arrow_Animated extends Widget_Base
{
    public function get_name()
    {
        return 'hassel_button_arrow_animated';
    }

    public function get_title()
    {
        return __('Button Arrow Animated', 'hassel-components');
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
        return ['hassel-button-arrow-animated-css'];
    }

    public function get_script_depends()
    {
        return ['hassel-button-arrow-animated-js'];
    }

    protected function register_controls()
    {
        /* ========== CONTENUTO ========== */
        $this->start_controls_section('content_section', [
            'label' => __('Contenuto', 'hassel-components'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('text', [
            'label' => __('Testo', 'hassel-components'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Scopri di più',
        ]);

        $this->add_control('link', [
            'label' => __('Link', 'hassel-components'),
            'type' => Controls_Manager::URL,
            'default' => ['url' => '#'],
        ]);

        $this->add_control('custom_svg', [
            'label' => __('Icona SVG personalizzata', 'hassel-components'),
            'type' => Controls_Manager::MEDIA,
            'media_types' => ['svg'],
            'description' => __('Carica un file SVG personalizzato per sostituire la freccia di default.', 'hassel-components'),
        ]);

        $this->end_controls_section();

        /* ========== STILE TESTO ========== */
        $this->start_controls_section('style_text_section', [
            'label' => __('Testo', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .button-arrow-animated__text',
        ]);

        $this->add_control('text_color', [
            'label' => __('Colore testo', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'default' => '#585857',
            'selectors' => [
                '{{WRAPPER}} .button-arrow-animated__text' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        /* ========== STILE ICONA ========== */
        $this->start_controls_section('style_icon_section', [
            'label' => __('Icona', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('icon_bg_color', [
            'label' => __('Colore sfondo cerchio', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'default' => '#8D9C71',
            'selectors' => [
                '{{WRAPPER}} .button-arrow-animated__icon' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('icon_arrow_color', [
            'label' => __('Colore freccia', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .button-arrow-animated__icon svg path' => 'fill: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('icon_size', [
            'label' => __('Dimensione cerchio', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => ['px' => ['min' => 0, 'max' => 128]],
            'default' => ['size' => 32, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .button-arrow-animated__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('arrow_size', [
            'label' => __('Dimensione icona interna', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => ['px' => ['min' => 0, 'max' => 64]],
            'default' => ['size' => 11, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .button-arrow-animated__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $link = $s['link']['url'] ?? '#';
        $target = !empty($s['link']['is_external']) ? ' target="_blank"' : '';
        $rel = !empty($s['link']['nofollow']) ? ' rel="nofollow"' : '';

        $custom_svg_url = $s['custom_svg']['url'] ?? '';
        $svg_icon = '';

        if (!empty($custom_svg_url)) {
            // Permetti solo file SVG caricati
            $svg_icon = file_get_contents($custom_svg_url);
        } else {
            // SVG di default (freccia)
            $svg_icon = '<svg viewBox="0 0 11 8" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.3536 4.35355C10.5488 4.15829 10.5488 3.84171 10.3536 3.64645L7.17157 0.464466C6.97631 0.269204 6.65973 0.269204 6.46447 0.464466C6.2692 0.659728 6.2692 0.976311 6.46447 1.17157L9.29289 4L6.46447 6.82843C6.2692 7.02369 6.2692 7.34027 6.46447 7.53553C6.65973 7.7308 6.97631 7.7308 7.17157 7.53553L10.3536 4.35355ZM0 4L0 4.5L10 4.5V4V3.5L0 3.5L0 4Z" fill="white"/>
            </svg>';
        }

        echo '<a href="' . esc_url($link) . '" role="button" class="button-arrow-animated"' . $target . $rel . '>';
        echo '  <span class="button-arrow-animated__text">' . esc_html($s['text']) . '</span>';
        echo '  <span class="button-arrow-animated__icon">';
        echo $svg_icon;
        echo '  </span>';
        echo '</a>';
    }
}
