<?php
namespace Hassel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

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
        // Sezione principale contenuto
        $this->start_controls_section('content_section', [
            'label' => __('Menu', 'hassel-components'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        // Selettore menu WP
        $this->add_control('menu_id', [
            'label' => __('Seleziona Menu WordPress', 'hassel-components'),
            'type' => Controls_Manager::SELECT,
            'options' => $this->get_menus(),
            'default' => '',
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
