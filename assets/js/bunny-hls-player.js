/* global Hls, elementorFrontend, jQuery */
(function ($) {
  function initBunnyPlayerRoot(root) {
    if (!root || root._hpInit) return;
    root._hpInit = true;

    var video = root.querySelector(".bunny-player__video");
    if (!video) return;

    // 🔧 Failsafe: se il wrapper è 0x0, imposta una height calcolata (16:9)
    try {
      if (root.clientHeight === 0) {
        var w = root.clientWidth || root.offsetWidth || 0;
        if (w > 0) root.style.height = Math.round((w * 9) / 16) + "px";
      }
    } catch (e) {}

    var src = root.getAttribute("data-player-src") || "";
    var auto = root.getAttribute("data-player-autoplay") === "true";
    var muted = root.getAttribute("data-player-muted") === "true";
    var lazy = root.getAttribute("data-player-lazy") || "";
    var poster = root.querySelector(".bunny-player__placeholder");

    // poster nativo
    if (poster && poster.src) video.setAttribute("poster", poster.src);

    // --- helper: attiva UI (toglie il placeholder anche se è in "ready") ---
    function activateUI() {
      if (root.getAttribute("data-player-activated") !== "true") {
        root.setAttribute("data-player-activated", "true");
      }
    }

    // --- carica sorgente HLS / nativa ---
    function loadSource() {
      if (!src) return;
      try {
        if (video.canPlayType("application/vnd.apple.mpegurl")) {
          // Safari / nativo HLS
          video.src = src;
        } else if (typeof Hls !== "undefined" && Hls.isSupported()) {
          var hls = new Hls({ lowLatencyMode: true });
          hls.on(Hls.Events.ERROR, function (event, data) {
            // se è fatale, prova fallback best-effort
            if (data && data.fatal) {
              try {
                hls.destroy();
              } catch (e) {}
              video.src = src; // qualche CDN/browsers lo digeriscono comunque
            }
          });
          hls.loadSource(src);
          hls.attachMedia(video);
        } else {
          video.src = src; // fallback
        }
        root.setAttribute("data-player-status", "ready");
      } catch (e) {
        // in caso di qualsiasi errore, siamo comunque "ready" per tentare play su click
        root.setAttribute("data-player-status", "ready");
      }
    }

    // --- bind bottoni ---
    var playBtns = root.querySelectorAll('[data-player-control="playpause"]');
    function togglePlay(e) {
      if (e) e.preventDefault();
      activateUI(); // <— fondamentale per nascondere il placeholder in "ready"
      if (video.paused) {
        root.setAttribute("data-player-status", "loading");
        // prova a partire non muto; se fallisce, riprova muto
        video.play().catch(function () {
          video.muted = true;
          root.setAttribute("data-player-muted", "true");
          return video.play().catch(function () {
            /* lascia in pausa se ancora blocca */
          });
        });
      } else {
        video.pause();
      }
    }
    playBtns.forEach(function (btn) {
      btn.addEventListener("click", togglePlay);
    });

    var muteBtn = root.querySelector('[data-player-control="mute"]');
    if (muteBtn) {
      muteBtn.addEventListener("click", function (e) {
        e.preventDefault();
        video.muted = !video.muted;
        root.setAttribute("data-player-muted", String(video.muted));
        activateUI();
      });
    }

    // --- lazy policy ---
    if (lazy === "true") {
      // carica al primo click sul container o sui bottoni
      var firstLoad = function () {
        root.removeEventListener("click", firstLoad);
        playBtns.forEach(function (b) {
          b.removeEventListener("click", firstLoad);
        });
        loadSource();
      };
      root.addEventListener("click", firstLoad);
      playBtns.forEach(function (b) {
        b.addEventListener("click", firstLoad, { once: true });
      });
    } else {
      // eager / metadata
      loadSource();
    }

    // --- hover UI ---
    root.addEventListener("mouseenter", function () {
      root.setAttribute("data-player-hover", "active");
    });
    root.addEventListener("mouseleave", function () {
      root.setAttribute("data-player-hover", "idle");
    });

    // --- eventi video -> stato UI ---
    video.addEventListener("playing", function () {
      root.setAttribute("data-player-status", "playing");
      activateUI();
    });
    video.addEventListener("pause", function () {
      root.setAttribute("data-player-status", "paused");
      activateUI();
    });
    video.addEventListener("waiting", function () {
      root.setAttribute("data-player-status", "loading");
    });
    video.addEventListener("canplay", function () {
      // anche se resta in pausa, permetti di vedere il frame senza poster
      activateUI();
      if (auto && muted) {
        video.muted = true;
        video.play().catch(function () {
          /* ok, resta in pausa fino a gesto utente */
        });
      }
    });

    // scorciatoie tastiera
    root.addEventListener("keydown", function (e) {
      var tag = (e.target && e.target.tagName) || "";
      if (/INPUT|TEXTAREA|SELECT|BUTTON/.test(tag)) return;
      if (e.key === "k" || e.code === "Space") {
        e.preventDefault();
        togglePlay(e);
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

  // Frontend load
  $(initAll);

  // Elementor frontend hook
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
