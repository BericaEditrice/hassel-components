/* global Hls, elementorFrontend, jQuery */
(function ($) {
  // Inizializzazione base: attacca HLS al <video> leggendo i data-attrs
  function initBunnyPlayerRoot(root) {
    if (!root || root._hpInit) return;
    root._hpInit = true;

    var video = root.querySelector(".bunny-player__video");
    if (!video) return;

    var src = root.getAttribute("data-player-src") || "";
    var auto = root.getAttribute("data-player-autoplay") === "true";
    var muted = root.getAttribute("data-player-muted") === "true";
    var lazy = root.getAttribute("data-player-lazy") || "";
    var poster = root.querySelector(".bunny-player__placeholder");

    // poster come poster nativo
    if (poster && poster.src) {
      video.setAttribute("poster", poster.src);
    }

    // Se lazy="true" aspetta interazione (click) per caricare
    var loadSource = function () {
      if (!src) return;
      if (video.canPlayType("application/vnd.apple.mpegurl")) {
        video.src = src;
      } else if (typeof Hls !== "undefined" && Hls.isSupported()) {
        var hls = new Hls();
        hls.loadSource(src);
        hls.attachMedia(video);
      } else {
        // fallback: alcuni browser supportano mp4 ma non hls
        video.src = src;
      }
      root.setAttribute("data-player-status", "ready");
    };

    if (lazy === "true") {
      // carica al primo click
      root.addEventListener("click", function onFirst() {
        root.removeEventListener("click", onFirst);
        loadSource();
        if (auto && muted) {
          video.muted = true;
          video.play().catch(() => {});
        }
      });
    } else {
      // eager o metadata
      loadSource();
      if (auto && muted) {
        video.muted = true;
        video.play().catch(() => {});
      }
    }

    // Controls base
    var playBtns = root.querySelectorAll('[data-player-control="playpause"]');
    playBtns.forEach(function (btn) {
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        if (video.paused) {
          video.play().catch(() => {});
        } else {
          video.pause();
        }
      });
    });

    var muteBtn = root.querySelector('[data-player-control="mute"]');
    if (muteBtn) {
      muteBtn.addEventListener("click", function (e) {
        e.preventDefault();
        video.muted = !video.muted;
        root.setAttribute("data-player-muted", String(video.muted));
      });
    }

    // Hover UI
    root.addEventListener("mouseenter", function () {
      root.setAttribute("data-player-hover", "active");
    });
    root.addEventListener("mouseleave", function () {
      root.setAttribute("data-player-hover", "idle");
    });

    // Stato
    video.addEventListener("playing", function () {
      root.setAttribute("data-player-status", "playing");
    });
    video.addEventListener("pause", function () {
      root.setAttribute("data-player-status", "paused");
    });
    video.addEventListener("waiting", function () {
      root.setAttribute("data-player-status", "loading");
    });
    video.addEventListener("canplay", function () {
      if (root.getAttribute("data-player-status") === "idle")
        root.setAttribute("data-player-status", "ready");
    });

    // Keyboard shortcuts (k/m/f)
    root.addEventListener("keydown", function (e) {
      var tag = (e.target && e.target.tagName) || "";
      if (/INPUT|TEXTAREA|SELECT|BUTTON/.test(tag)) return;
      if (e.key === "k" || e.code === "Space") {
        e.preventDefault();
        playBtns[0]?.click();
      }
      if (e.key === "m") {
        e.preventDefault();
        muteBtn?.click();
      }
      if (e.key === "f") {
        e.preventDefault();
        if (root.requestFullscreen) root.requestFullscreen();
      }
    });
  }

  function initAll() {
    document
      .querySelectorAll("[data-bunny-player-init]")
      .forEach(initBunnyPlayerRoot);
  }

  // Frontend page load
  $(function () {
    initAll();
  });

  // Elementor frontend (non editor-only)
  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/hassel_bunny_hls_player.default",
      function ($scope) {
        $scope.find("[data-bunny-player-init]").each(function () {
          initBunnyPlayerRoot(this);
        });
      }
    );
  });
})(jQuery);
