<?php
namespace Hassel\Widgets;

use Elementor\Widget_Base;

if (!defined('ABSPATH'))
    exit;

class Bunny_HLS_Player extends Widget_Base
{

    public function get_name()
    {
        return 'hassel_bunny_hls_player';
    }

    public function get_title()
    {
        return __('Bunny HLS Player', 'hassel-components');
    }

    public function get_icon()
    {
        return 'eicon-play';
    }

    public function get_categories()
    {
        return ['hassel-library'];
    }

    public function get_style_depends()
    {
        return ['hassel-bunny-hls-player-css'];
    }

    public function get_script_depends()
    {
        return ['hassel-bunny-hls-player-js'];
    }

    // NIENTE controlli in questo step: li aggiungiamo dopo

    protected function render()
    {
        // Segnaposto minimale per verificare hooking + asset
        echo '<div class="hassel-bunny-hls placeholder">';
        echo '  <div class="hassel-bunny-hls__box">';
        echo '    <strong>Bunny HLS Player</strong><br/>';
        echo '    <small>(Step 1: wiring OK — i controlli arrivano nello step 2)</small>';
        echo '  </div>';
        echo '</div>';
    }
}
