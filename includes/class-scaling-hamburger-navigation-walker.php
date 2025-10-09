<?php
namespace Hassel\Widgets;

if (!defined('ABSPATH'))
    exit;

class Scaling_Hamburger_Navigation_Walker extends \Walker_Nav_Menu
{

    private $show_dot = true;

    public function __construct($args = [])
    {
        if (isset($args['show_dot'])) {
            $this->show_dot = (bool) $args['show_dot'];
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        $classes = is_array($item->classes) ? $item->classes : [];
        $has_children = in_array('menu-item-has-children', $classes, true);
        $is_current = in_array('current-menu-item', $classes, true) || in_array('current_page_item', $classes, true);
        $container_cls = 'hamburger-nav__li ' . implode(' ', array_map('esc_attr', $classes));
        $aria_current = $is_current ? ' aria-current="page"' : '';

        // wrapper (portiamo anche le classi WP qui, es. menu-item-has-children)
        $output .= '<div class="' . $container_cls . '">';

        // link
        $output .= '<a href="' . esc_url($item->url) . '" class="hamburger-nav__a"' . $aria_current . '>';
        $output .= '<p class="hamburger-nav__p">' . esc_html($item->title) . '</p>';

        // DOT solo se richiesto e SOLO se non ha figli (anche per le voci nel sottomenu)
        if ($this->show_dot && !$has_children) {
            $output .= '<div class="hamburger-nav__dot"></div>';
        }

        // Chevron solo sui genitori
        if ($has_children) {
            $output .= '<span class="nav-link__dropdown-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" viewBox="0 0 17 10" fill="none">
                    <path d="M1.5 1.5L8.5 8.5L15.5 1.5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>';
        }

        $output .= '</a>';
        // il </div> viene chiuso in end_el
    }

    public function end_el(&$output, $item, $depth = 0, $args = [])
    {
        $output .= '</div>';
    }

    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= '<ul class="hamburger-nav__submenu">';
    }

    public function end_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= '</ul>';
    }
}
