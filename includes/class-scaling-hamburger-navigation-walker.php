<?php
namespace Hassel\Widgets;

if (!defined('ABSPATH'))
    exit;

class Scaling_Hamburger_Navigation_Walker extends \Walker_Nav_Menu
{

    function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        $classes = implode(' ', $item->classes);
        $active = in_array('current-menu-item', $item->classes) ? 'aria-current="page"' : '';
        $has_children = in_array('menu-item-has-children', $item->classes);

        $output .= '<div class="hamburger-nav__li">';
        $output .= '<a href="' . esc_url($item->url) . '" class="hamburger-nav__a" ' . $active . '>';
        $output .= '<p class="hamburger-nav__p">' . esc_html($item->title) . '</p>';
        $output .= '<div class="hamburger-nav__dot"></div>';

        if ($has_children) {
            $output .= '<span class="nav-link__dropdown-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" viewBox="0 0 17 10" fill="none">
                    <path d="M1.5 1.5L8.5 8.5L15.5 1.5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>';
        }

        $output .= '</a>';
    }

    function end_el(&$output, $item, $depth = 0, $args = [])
    {
        $output .= '</div>';
    }

    function start_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= '<ul class="hamburger-nav__submenu">';
    }

    function end_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= '</ul>';
    }
}
