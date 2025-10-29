<?php
namespace Hassel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

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
        return 'eicon-video-playlist';
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

    protected function register_controls()
    {

        /* ============= CONTENUTO ============= */
        $this->start_controls_section('content', [
            'label' => __('Sorgente', 'hassel-components'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('src', [
            'label' => __('URL .m3u8 (Bunny HLS)', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::URL,
            'dynamic' => ['active' => true],
            'placeholder' => 'https://....m3u8',
        ]);

        $this->add_control('poster', [
            'label' => __('Poster', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('autoplay', [
            'label' => __('Autoplay (muted/loop)', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => '',
            'description' => __('Per policy browser l’autoplay parte silenziato.', 'hassel-components'),
        ]);

        $this->add_control('muted', [
            'label' => __('Avvia silenziato', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => ['autoplay!' => 'true'],
        ]);

        $this->add_control('lazy', [
            'label' => __('Lazy load', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'meta',
            'options' => [
                '' => __('No (eager)', 'hassel-components'),
                'meta' => __('Solo metadati (consigliato)', 'hassel-components'),
                'true' => __('Puro (carica al click)', 'hassel-components'),
            ],
        ]);

        $this->add_control('aspect_mode', [
            'label' => __('Gestione rapporto', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'true',
            'options' => [
                'true' => __('Calcola da metadati', 'hassel-components'),
                'cover' => __('CSS cover (disattiva calcolo)', 'hassel-components'),
            ],
        ]);

        $this->add_control('vtt_url', [
            'label' => __('Sottotitoli .vtt (opzionale)', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::URL,
            'dynamic' => ['active' => true],
            'placeholder' => 'https://.../subtitles.vtt',
        ]);

        $this->add_control('vtt_label', [
            'label' => __('Etichetta sottotitoli', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'CC',
            'condition' => ['vtt_url[url]!' => ''],
        ]);

        $this->add_control('vtt_default', [
            'label' => __('Sottotitoli attivi di default', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => '',
            'condition' => ['vtt_url[url]!' => ''],
        ]);

        $this->add_control('analytics_id', [
            'label' => __('Analytics ID (facoltativo)', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => 'video-hero-home',
        ]);

        $this->end_controls_section(); // END content


        /* ============= TEMA & CONTROLLI ============= */
        $this->start_controls_section('theme', [
            'label' => __('Tema & Controlli', 'hassel-components'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name' => 'ui_typo',
            'selector' => '{{WRAPPER}} .bunny-player__text',
        ]);

        $this->add_control('accent', [
            'label' => __('Colore accento (progress/handle)', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ff4c24',
            'selectors' => ['{{WRAPPER}} .bunny-player' => '--hp-accent: {{VALUE}};'],
        ]);

        $this->end_controls_section(); // END theme


        /* ============= LAYOUT ============= */
        $this->start_controls_section('layout', [
            'label' => __('Layout', 'hassel-components'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('player_height', [
            'label' => __('Altezza', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh', 'em', 'rem'],
            'range' => ['px' => ['min' => 120, 'max' => 1200]],
            'selectors' => ['{{WRAPPER}} .bunny-player' => 'height: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('radius', [
            'label' => __('Raggio bordo', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => ['{{WRAPPER}} .bunny-player' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), [
            'name' => 'shadow',
            'selector' => '{{WRAPPER}} .bunny-player',
        ]);

        $this->end_controls_section(); // END layout


        /* ============= PULSANTE PLAY ============= */
        $this->start_controls_section('play_btn', [
            'label' => __('Pulsante Play/Pause', 'hassel-components'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('play_size', [
            'label' => __('Diametro cerchio', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => ['px' => ['min' => 0, 'max' => 200]],
            'default' => ['size' => 96, 'unit' => 'px'],
            'selectors' => ['{{WRAPPER}} .bunny-player' => '--hp-play-size: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('play_icon', [
            'label' => __('Dimensione icona', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => ['px' => ['min' => 0, 'max' => 120]],
            'default' => ['size' => 32, 'unit' => 'px'],
            'selectors' => ['{{WRAPPER}} .bunny-player' => '--hp-play-icon: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_control('play_bg', [
            'label' => __('Colore cerchio', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(100,100,100,.2)',
            'selectors' => ['{{WRAPPER}} .bunny-player' => '--hp-play-bg: {{VALUE}};'],
        ]);

        $this->add_control('play_border', [
            'label' => __('Bordo cerchio', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,.1)',
            'selectors' => ['{{WRAPPER}} .bunny-player' => '--hp-play-border: {{VALUE}};'],
        ]);

        $this->end_controls_section(); // END play_btn


        /* ============= ACCESSIBILITÀ / COMPORTAMENTO ============= */
        $this->start_controls_section('a11y', [
            'label' => __('Accessibilità & Comportamento', 'hassel-components'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('overlay_opacity', [
            'label' => __('Overlay scuro (in pausa)', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 1, 'step' => 0.05]],
            'default' => ['size' => 0.3],
            'selectors' => ['{{WRAPPER}} .bunny-player' => '--hp-overlay: {{SIZE}};'],
        ]);

        $this->add_control('reduce_motion', [
            'label' => __('Riduci animazioni se prefers-reduced-motion', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'true',
        ]);

        $this->add_control('kb_shortcuts', [
            'label' => __('Abilita scorciatoie da tastiera (K/M/F)', 'hassel-components'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'true',
        ]);

        $this->end_controls_section(); // END a11y
    }


    protected function render()
    {
        $s = $this->get_settings_for_display();

        $src = isset($s['src']['url']) ? esc_url($s['src']['url']) : '';
        $poster = isset($s['poster']['url']) ? esc_url($s['poster']['url']) : '';
        $lazy = $s['lazy'] ?? '';
        $auto = (!empty($s['autoplay']) && $s['autoplay'] === 'true') ? 'true' : 'false';
        $muted = ($auto === 'true') ? 'true' : ((!empty($s['muted']) && $s['muted'] === 'true') ? 'true' : 'false');
        $aspect = $s['aspect_mode'] ?? 'true';

        $vtt = isset($s['vtt_url']['url']) ? esc_url($s['vtt_url']['url']) : '';
        $vtt_label = esc_attr($s['vtt_label'] ?? 'CC');
        $vtt_default = (!empty($s['vtt_default']) && $s['vtt_default'] === 'true') ? ' default' : '';

        $analytics = esc_attr($s['analytics_id'] ?? '');

        // Preload in base a "lazy"
        $preload = 'auto';
        if ($lazy === 'meta')
            $preload = 'metadata';
        if ($lazy === 'true')
            $preload = 'none';

        echo '<div class="bunny-player" data-bunny-player-init 
                data-player-src="' . esc_attr($src) . '"
                data-player-autoplay="' . $auto . '"
                data-player-muted="' . $muted . '"
                data-player-update-size="' . esc_attr($aspect) . '"
                data-player-lazy="' . esc_attr($lazy) . '"
                data-player-status="idle"
                data-player-activated="false"
                data-player-hover="idle"
                data-player-fullscreen="false"
                ' . ($analytics ? 'data-analytics-id="' . $analytics . '"' : '') . '
             >';

        echo '  <div data-player-before class="bunny-player__before"></div>';

        // VIDEO: qui inseriamo anche il <track> (se esiste) DENTRO al video
        echo '  <video class="bunny-player__video" playsinline preload="' . esc_attr($preload) . '">';
        if ($vtt) {
            echo '<track kind="subtitles" srclang="en" label="' . $vtt_label . '" src="' . $vtt . '"' . $vtt_default . '>';
        }
        echo '  </video>';

        if ($poster) {
            echo '  <img class="bunny-player__placeholder" src="' . $poster . '" alt="">';
        }

        echo '  <div class="bunny-player__dark"></div>';

        // Pulsante centrale grande
        echo '  <div class="bunny-player__playpause" data-player-control="playpause" aria-label="' . esc_attr__('Play/Pause', 'hassel-components') . '" role="button" tabindex="0">';
        echo '    <div class="bunny-player__big-btn">';
        echo '      <svg class="bunny-player__pause-svg" viewBox="0 0 24 24"><path d="M16 5V19" stroke="currentColor" stroke-width="3"/><path d="M8 5V19" stroke="currentColor" stroke-width="3"/></svg>';
        echo '      <svg class="bunny-player__play-svg" viewBox="0 0 24 24"><path d="M6 12V5.01109C6 4.05131 7.03685 3.4496 7.87017 3.92579L14 7.42855L20.1007 10.9147C20.9405 11.3945 20.9405 12.6054 20.1007 13.0853L14 16.5714L7.87017 20.0742C7.03685 20.5503 6 19.9486 6 18.9889V12Z" fill="currentColor"/></svg>';
        echo '    </div>';
        echo '  </div>';

        // Interfaccia
        echo '  <div class="bunny-player__interface">';
        echo '    <div class="bunny-player__interface-fade"></div>';
        echo '    <div class="bunny-player__interface-bottom">';

        echo '      <div class="bunny-player__toggle-playpause" data-player-control="playpause" aria-label="' . esc_attr__('Play/Pause', 'hassel-components') . '" role="button" tabindex="0">';
        echo '        <svg class="bunny-player__pause-svg" viewBox="0 0 24 24"><path d="M16 5V19" stroke="currentColor" stroke-width="3"/><path d="M8 5V19" stroke="currentColor" stroke-width="3"/></svg>';
        echo '        <svg class="bunny-player__play-svg" viewBox="0 0 24 24"><path d="M6 12V5.01109C6 4.05131 7.03685 3.4496 7.87017 3.92579L14 7.42855L20.1007 10.9147C20.9405 11.3945 20.9405 12.6054 20.1007 13.0853L14 16.5714L7.87017 20.0742C7.03685 20.5503 6 19.9486 6 18.9889V12Z" fill="currentColor"/></svg>';
        echo '      </div>';

        echo '      <div class="bunny-player__time">
                        <p class="bunny-player__text" data-player-time-progress>00:00</p>
                        <p class="bunny-player__text is--transparent">/</p>
                        <p class="bunny-player__text is--transparent" data-player-time-duration>00:00</p>
                      </div>';

        echo '      <div class="bunny-player__timeline" data-player-timeline>
                        <div class="bunny-player__timeline-bar">
                          <div class="bunny-player__timeline-bg"></div>
                          <div class="bunny-player__timeline-buffered" data-player-buffered></div>
                          <div class="bunny-player__timeline-progress" data-player-progress></div>
                        </div>
                        <div class="bunny-player__timeline-handle" data-player-timeline-handle></div>
                      </div>';

        echo '      <div class="bunny-player__interface-btns">
                        <div class="bunny-player__toggle-mute" data-player-control="mute" aria-label="' . esc_attr__('Mute', 'hassel-components') . '" role="button" tabindex="0">
                          <svg class="bunny-player__volume-up-svg" viewBox="0 0 24 24"><path d="M3 8.99998V15H7L12 20V3.99998L7 8.99998H3ZM16.5 12C16.5 10.23 15.48 8.70998 14 7.96998V16.02C15.48 15.29 16.5 13.77 16.5 12ZM14 3.22998V5.28998C16.89 6.14998 19 8.82998 19 12C19 15.17 16.89 17.85 14 18.71V20.77C18.01 19.86 21 16.28 21 12C21 7.71998 18.01 4.13998 14 3.22998Z" fill="currentColor"/></svg>
                          <svg class="bunny-player__volume-mute-svg" viewBox="0 0 24 24"><path d="M4.27 3L3 4.27L7.73 9H3V15H7L12 20V13.27L19.73 21L21 19.73L12 10.73L4.27 3Z" fill="currentColor"/></svg>
                        </div>
                        <div class="bunny-player__toggle-fullscreen" data-player-control="fullscreen" aria-label="' . esc_attr__('Fullscreen', 'hassel-components') . '" role="button" tabindex="0">
                          <svg class="bunny-player__fullscreen-scale-svg" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="2" fill="currentColor"/><rect x="14" y="3" width="7" height="2" fill="currentColor"/><rect x="3" y="19" width="7" height="2" fill="currentColor"/><rect x="14" y="19" width="7" height="2" fill="currentColor"/></svg>
                          <svg class="bunny-player__fullscreen-shrink-svg" viewBox="0 0 24 24"><rect x="7" y="2" width="2" height="7" fill="currentColor"/><rect x="15" y="2" width="2" height="7" fill="currentColor"/></svg>
                        </div>
                      </div>';

        echo '    </div>'; // interface-bottom
        echo '  </div>';   // interface

        // Loading
        echo '  <div class="bunny-player__loading">
                  <svg class="bunny-player__loading-svg" viewBox="0 0 100 100" fill="none"><path fill="currentColor" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50"></path><animateTransform attributeName="transform" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"/></svg>
                </div>';

        echo '</div>'; // bunny-player
    }
}
