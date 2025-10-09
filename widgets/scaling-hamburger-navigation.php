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

        $this->add_control('menu_label_text', [
            'label' => __('Testo intestazione menu', 'hassel-components'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Menu',
            'placeholder' => __('Scrivi il titolo del menu', 'hassel-components'),
        ]);

        $this->end_controls_section();


        /* ----------- STILE: TITOLO MENU ----------- */
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


        /* ----------- STILE: MENU PRINCIPALE ----------- */
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

        $this->add_control('show_dot', [
            'label' => __('Mostra pallino accanto al link', 'hassel-components'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Sì', 'hassel-components'),
            'label_off' => __('No', 'hassel-components'),
            'default' => 'yes',
        ]);

        $this->add_control('dot_color', [
            'label' => __('Colore pallino', 'hassel-components'),
            'type' => Controls_Manager::COLOR,
            'condition' => ['show_dot' => 'yes'],
            'selectors' => ['{{WRAPPER}} .hamburger-nav__dot' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('dot_size', [
            'label' => __('Dimensione pallino', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem', '%'],
            'range' => [
                'px' => ['min' => 2, 'max' => 30],
                'em' => ['min' => 0.1, 'max' => 3],
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-nav__dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => ['show_dot' => 'yes'],
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
            'size_units' => ['px', 'em', 'rem'],
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

        $this->add_responsive_control('hamburger_size', [
            'label' => __('Dimensione cerchio', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => ['px' => ['min' => 20, 'max' => 200]],
            'selectors' => [
                '{{WRAPPER}} .hamburger-nav__toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .hamburger-nav__bg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('hamburger_line_thickness', [
            'label' => __('Spessore linee', 'hassel-components'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => ['px' => ['min' => 1, 'max' => 10]],
            'selectors' => ['{{WRAPPER}} .hamburger-nav__toggle-bar' => 'height: {{SIZE}}{{UNIT}};'],
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
        $label_text = $settings['menu_label_text'] ?: 'Menu';

        if (empty($menu_slug)) {
            echo '<p style="color:#888;">' . __('Seleziona un menu WordPress nel pannello a sinistra.', 'hassel-components') . '</p>';
            return;
        }

        echo '<nav data-navigation-status="not-active" class="navigation">';
        echo '  <div data-navigation-toggle="close" class="navigation__dark-bg"></div>';
        echo '  <div class="hamburger-nav">';
        echo '    <div class="hamburger-nav__bg"></div>';
        echo '    <div class="hamburger-nav__group">';
        echo '      <p class="hamburger-nav__menu-p">' . esc_html($label_text) . '</p>';
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
