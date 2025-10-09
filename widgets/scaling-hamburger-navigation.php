<?php
namespace Hassel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH'))
    exit;

class Scaling_Hamburger_Navigation extends Widget_Base
{

    public function get_name()
    {
        return 'hassel_scaling_hamburger_navigation';
    }

    public function get_title()
    {
        return __('Scaling Hamburger Navigation', 'hassel-components');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function get_categories()
    {
        return ['hassel-library'];
    }

    public function get_style_depends()
    {
        return ['hassel-scaling-hamburger-navigation-css'];
    }

    public function get_script_depends()
    {
        return ['hassel-scaling-hamburger-navigation-js'];
    }

    /* ------------------ CONTROLLI ------------------ */
    protected function register_controls()
    {

        /* === CONTENUTO === */
        $this->start_controls_section('content_section', [
            'label' => __('Contenuto', 'hassel-components'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('menu_id', [
            'label' => __('Seleziona Menu WordPress', 'hassel-components'),
            'type' => Controls_Manager::SELECT,
            'options' => $this->get_menus(),
            'default' => '',
        ]);

        $this->add_control('menu_label_text', [
            'label' => __('Testo intestazione', 'hassel-components'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Menu',
        ]);

        $this->end_controls_section();

        /* === LAYOUT GENERALE === */
        $this->start_controls_section('layout_section', [
            'label' => __('Layout', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('min_width', [
            'label' => __('Larghezza minima', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem', '%'],
            'range' => ['px' => ['min' => 0, 'max' => 1600]],
            'selectors' => ['{{WRAPPER}} .hamburger-nav' => 'min-width: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('min_height', [
            'label' => __('Altezza minima', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem', '%'],
            'range' => ['px' => ['min' => 0, 'max' => 1200]],
            'selectors' => ['{{WRAPPER}} .hamburger-nav' => 'min-height: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('container_padding', [
            'label' => __('Padding contenitore', 'hassel-components'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'selectors' => [
                '{{WRAPPER}} .hamburger-nav__group' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('container_margin', [
            'label' => __('Margine', 'hassel-components'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'selectors' => [
                '{{WRAPPER}} .hamburger-nav' =>
                    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        /* === TITOLO MENU === */
        $this->start_controls_section('menu_label_style', [
            'label' => __('Titolo Menu', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'menu_label_typography',
            'selector' => '{{WRAPPER}} .hamburger-nav__menu-p',
        ]);

        $this->add_control('menu_label_color', [
            'label' => __('Colore testo', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .hamburger-nav__menu-p' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();

        /* === VOCI MENU PRINCIPALE === */
        $this->start_controls_section('main_menu_style', [
            'label' => __('Voci Menu Principale', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'main_menu_typography',
            'selector' => '{{WRAPPER}} .hamburger-nav__p',
        ]);

        $this->add_control('main_menu_color', [
            'label' => __('Colore testo', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .hamburger-nav__a' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('main_menu_hover_color', [
            'label' => __('Colore hover', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .hamburger-nav__a:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('main_menu_active_color', [
            'label' => __('Colore attivo', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hamburger-nav__a[aria-current]' => 'color: {{VALUE}};',
                '{{WRAPPER}} .hamburger-nav__li.current-menu-item > .hamburger-nav__a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('main_menu_gap', [
            'label' => __('Spaziatura tra voci', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'selectors' => ['{{WRAPPER}} .hamburger-nav__ul' => 'row-gap: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        /* === SOTTOMENU === */
        $this->start_controls_section('submenu_style', [
            'label' => __('Sottomenu', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'submenu_typography',
            'selector' => '{{WRAPPER}} .hamburger-nav__submenu .hamburger-nav__p',
        ]);

        $this->add_control('submenu_color', [
            'label' => __('Colore testo', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .hamburger-nav__submenu .hamburger-nav__a' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('submenu_hover_color', [
            'label' => __('Colore hover', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .hamburger-nav__submenu .hamburger-nav__a:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('submenu_indent', [
            'label' => __('Indentazione sinistra', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'selectors' => ['{{WRAPPER}} .hamburger-nav__submenu' => 'padding-left: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('submenu_gap', [
            'label' => __('Spaziatura tra voci sottomenu', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'selectors' => ['{{WRAPPER}} .hamburger-nav__submenu' => 'row-gap: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        /* === PALLINO === */
        $this->start_controls_section('dot_style', [
            'label' => __('Indicatore Pallino', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dot_show', [
            'label' => __('Mostra pallino', 'hassel-components'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Sì', 'hassel-components'),
            'label_off' => __('No', 'hassel-components'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('dot_color', [
            'label' => __('Colore pallino', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .hamburger-nav__dot' => 'background-color: {{VALUE}};'],
            'condition' => ['dot_show' => 'yes'],
        ]);

        $this->add_responsive_control('dot_size', [
            'label' => __('Dimensione pallino', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'selectors' => ['{{WRAPPER}} .hamburger-nav__dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'],
            'condition' => ['dot_show' => 'yes'],
        ]);

        $this->end_controls_section();

        /* === STILE: ICONA CHEVRON (SOTTOMENU) === */
        $this->start_controls_section('chevron_style', [
            'label' => __('Icona Chevron', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('chevron_color', [
            'label' => __('Colore icona', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-link__dropdown-icon path' => 'stroke: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('chevron_size', [
            'label' => __('Dimensione icona', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => ['px' => ['min' => 8, 'max' => 64]],
            'selectors' => [
                '{{WRAPPER}} .nav-link__dropdown-icon' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
            ],
        ]);

        $this->add_responsive_control('chevron_padding', [
            'label' => __('Spaziatura cliccabile (padding)', 'hassel-components'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .nav-link__dropdown-icon' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('chevron_transition_duration', [
            'label' => __('Durata animazione rotazione (s)', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['s'],
            'range' => ['s' => ['min' => 0.1, 'max' => 2, 'step' => 0.1]],
            'default' => ['size' => 0.4, 'unit' => 's'],
            'selectors' => [
                '{{WRAPPER}} .nav-link__dropdown-icon' =>
                    'transition: transform {{SIZE}}{{UNIT}} ease;',
            ],
        ]);

        $this->end_controls_section();

        /* === ICONA HAMBURGER === */
        $this->start_controls_section('hamburger_style', [
            'label' => __('Icona Hamburger', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('hamburger_color', [
            'label' => __('Colore linee', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .hamburger-nav__toggle-bar' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('hamburger_bg', [
            'label' => __('Colore sfondo', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .hamburger-nav__bg' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('hamburger_line_thickness', [
            'label' => __('Spessore linee', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'selectors' => ['{{WRAPPER}} .hamburger-nav__toggle-bar' => 'height: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'hamburger_shadow',
            'selector' => '{{WRAPPER}} .hamburger-nav__bg',
        ]);

        $this->end_controls_section();
    }

    private function get_menus()
    {
        $menus = wp_get_nav_menus();
        $options = [];
        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }
        return $options;
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $menu_slug = $s['menu_id'] ?? '';

        if (empty($menu_slug)) {
            echo '<p style="color:#888;">' . __('Seleziona un menu WordPress nel pannello.', 'hassel-components') . '</p>';
            return;
        }

        echo '<nav data-navigation-status="not-active" class="navigation">';
        echo '<div data-navigation-toggle="close" class="navigation__dark-bg"></div>';
        echo '<div class="hamburger-nav">';
        echo '<div class="hamburger-nav__bg"></div>';
        echo '<div class="hamburger-nav__group">';
        echo '<p class="hamburger-nav__menu-p">' . esc_html($s['menu_label_text']) . '</p>';
        echo '<ul class="hamburger-nav__ul">';
        wp_nav_menu([
            'menu' => $menu_slug,
            'container' => false,
            'items_wrap' => '%3$s',
            'walker' => new \Hassel\Widgets\Scaling_Hamburger_Navigation_Walker(),
        ]);
        echo '</ul>';
        echo '</div>';
        echo '<div data-navigation-toggle="toggle" class="hamburger-nav__toggle">';
        echo '<div class="hamburger-nav__toggle-bar"></div>';
        echo '<div class="hamburger-nav__toggle-bar"></div>';
        echo '</div>';
        echo '</div>';
        echo '</nav>';
    }
}
