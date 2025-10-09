<?php
namespace Hassel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

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

    /* ---------------------------------------------------------------------- */
    /* CONTROLLI */
    /* ---------------------------------------------------------------------- */
    protected function register_controls()
    {

        /* ----------- SEZIONE CONTENUTO ----------- */
        $this->start_controls_section('content_section', [
            'label' => __('Menu', 'hassel-components'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('menu_id', [
            'label' => __('Seleziona Menu WordPress', 'hassel-components'),
            'type' => Controls_Manager::SELECT,
            'options' => $this->get_menus(),
            'default' => '',
        ]);

        $this->end_controls_section();

        /* ----------- STILE: MENU PRINCIPALE ----------- */
        $this->start_controls_section('main_menu_style', [
            'label' => __('Menu Principale', 'hassel-components'),
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

        $this->end_controls_section();

        /* ----------- STILE: SOTTOMENU ----------- */
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

        $this->add_responsive_control('submenu_icon_size', [
            'label' => __('Dimensione icona sottomenu', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 8, 'max' => 60]],
            'selectors' => ['{{WRAPPER}} .nav-link__dropdown-icon' => 'width: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        /* ----------- STILE: ICONA HAMBURGER ----------- */
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

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'hamburger_shadow',
            'selector' => '{{WRAPPER}} .hamburger-nav__bg',
        ]);

        $this->end_controls_section();

        /* ----------- STILE: SFONDO MENU APERTO ----------- */
        $this->start_controls_section('background_style', [
            'label' => __('Sfondo Menu Aperto', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'menu_open_bg',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .navigation__dark-bg',
        ]);

        $this->end_controls_section();

        /* ----------- STILE: ANIMAZIONI ----------- */
        $this->start_controls_section('animation_section', [
            'label' => __('Animazione', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('animation_type', [
            'label' => __('Tipo di animazione', 'hassel-components'),
            'type' => Controls_Manager::SELECT,
            'default' => 'ease-in-out',
            'options' => [
                'ease' => 'Ease',
                'ease-in' => 'Ease In',
                'ease-out' => 'Ease Out',
                'ease-in-out' => 'Ease In-Out',
                'linear' => 'Linear',
                'cubic-bezier(0.5, 0.5, 0, 1)' => 'Custom (cubic-bezier)',
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-nav__bg, {{WRAPPER}} .hamburger-nav__group' => 'transition-timing-function: {{VALUE}};',
            ],
        ]);

        $this->add_control('animation_duration', [
            'label' => __('Durata animazione (s)', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['s' => ['min' => 0.1, 'max' => 2, 'step' => 0.1]],
            'default' => ['size' => 0.7, 'unit' => 's'],
            'selectors' => [
                '{{WRAPPER}} .hamburger-nav__bg, {{WRAPPER}} .hamburger-nav__group' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('submenu_animation_duration', [
            'label' => __('Durata animazione sottomenu (s)', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['s' => ['min' => 0.1, 'max' => 2, 'step' => 0.1]],
            'default' => ['size' => 0.4, 'unit' => 's'],
        ]);

        $this->end_controls_section();

        /* ----------- STILE: LAYOUT ----------- */
        $this->start_controls_section('layout_section', [
            'label' => __('Layout', 'hassel-components'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        // Larghezza
        $this->add_responsive_control('nav_width', [
            'label' => __('Larghezza', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 50, 'max' => 800]],
            'selectors' => ['{{WRAPPER}} .hamburger-nav' => 'width: {{SIZE}}{{UNIT}};'],
        ]);

        // Altezza
        $this->add_responsive_control('nav_height', [
            'label' => __('Altezza', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 50, 'max' => 800]],
            'selectors' => ['{{WRAPPER}} .hamburger-nav' => 'height: {{SIZE}}{{UNIT}};'],
        ]);

        // Padding
        $this->add_responsive_control('nav_padding', [
            'label' => __('Padding', 'hassel-components'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .hamburger-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // Margine
        $this->add_responsive_control('nav_margin', [
            'label' => __('Margine', 'hassel-components'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .hamburger-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // Allineamento
        $this->add_responsive_control('nav_alignment', [
            'label' => __('Allineamento', 'hassel-components'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => __('Sinistra', 'hassel-components'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __('Centro', 'hassel-components'),
                    'icon' => 'eicon-text-align-center',
                ],
                'flex-end' => [
                    'title' => __('Destra', 'hassel-components'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'flex-end',
            'selectors' => [
                '{{WRAPPER}} .hamburger-nav' => 'align-self: {{VALUE}};',
            ],
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
        $settings = $this->get_settings_for_display();
        $menu_slug = $settings['menu_id'] ?? '';

        if (empty($menu_slug)) {
            echo '<p style="color:#888;">' . __('Seleziona un menu WordPress nel pannello a sinistra.', 'hassel-components') . '</p>';
            return;
        }

        echo '<nav data-navigation-status="not-active" class="navigation">';
        echo '  <div data-navigation-toggle="close" class="navigation__dark-bg"></div>';
        echo '  <div class="hamburger-nav">';
        echo '    <div class="hamburger-nav__bg"></div>';
        echo '    <div class="hamburger-nav__group">';
        echo '      <p class="hamburger-nav__menu-p">Menu</p>';
        echo '      <ul class="hamburger-nav__ul">';

        wp_nav_menu([
            'menu' => $menu_slug,
            'container' => false,
            'items_wrap' => '%3$s',
            'walker' => new \Hassel\Widgets\Scaling_Hamburger_Navigation_Walker(),
        ]);

        echo '      </ul>';
        echo '    </div>';
        echo '    <div data-navigation-toggle="toggle" class="hamburger-nav__toggle">';
        echo '      <div class="hamburger-nav__toggle-bar"></div>';
        echo '      <div class="hamburger-nav__toggle-bar"></div>';
        echo '    </div>';
        echo '  </div>';
        echo '</nav>';
    }
}
