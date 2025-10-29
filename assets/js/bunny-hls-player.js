/* global Hls, elementorFrontend, jQuery */
(function ($) {
  function fmt(t) {
    if (!isFinite(t) || t < 0) t = 0;
    var m = Math.floor(t / 60),
      s = Math.floor(t % 60);
    return (m < 10 ? "0" + m : m) + ":" + (s < 10 ? "0" + s : s);
  }
  function toggleFullscreen(el) {
    var d = document;
    if (!d.fullscreenElement && el.requestFullscreen)
      return el.requestFullscreen();
    if (d.fullscreenElement && d.exitFullscreen) return d.exitFullscreen();
  }

  function initBunnyPlayerRoot(root) {
    if (!root || root._hpInit) return;
    root._hpInit = true;

    var video = root.querySelector(".bunny-player__video");
    if (!video) return;

    var src = root.getAttribute("data-player-src") || "";
    var auto = root.getAttribute("data-player-autoplay") === "true";
    var muted = root.getAttribute("data-player-muted") === "true";
    var lazy = root.getAttribute("data-player-lazy") || "";

    var posterImg = root.querySelector(".bunny-player__placeholder");

    var btnsPlay = root.querySelectorAll('[data-player-control="playpause"]');
    var btnMute = root.querySelector('[data-player-control="mute"]');
    var btnFs = root.querySelector('[data-player-control="fullscreen"]');

    var $progTxt = root.querySelector("[data-player-time-progress]");
    var $durTxt = root.querySelector("[data-player-time-duration]");
    var $bar = root.querySelector("[data-player-progress]");
    var $buff = root.querySelector("[data-player-buffered]");
    var $track = root.querySelector("[data-player-timeline]");
    var $handle = root.querySelector("[data-player-timeline-handle]");
    var $vol = root.querySelector(".bunny-player__volume-range");

    if (posterImg && posterImg.src) video.setAttribute("poster", posterImg.src);

    if (root.clientHeight === 0) {
      var w = root.clientWidth || root.offsetWidth || 0;
      if (w > 0) root.style.height = Math.round((w * 9) / 16) + "px";
    }

    function activateUI() {
      if (root.getAttribute("data-player-activated") !== "true") {
        root.setAttribute("data-player-activated", "true");
      }
    }
    function setAspectFromMeta() {
      var vw = video.videoWidth,
        vh = video.videoHeight;
      if (vw && vh) root.style.setProperty("--hp-aspect", vw + " / " + vh);
    }
    function loadSource() {
      if (!src) return;
      try {
        if (video.canPlayType("application/vnd.apple.mpegurl")) {
          video.src = src;
        } else if (typeof Hls !== "undefined" && Hls.isSupported()) {
          var hls = new Hls({ lowLatencyMode: true });
          hls.on(Hls.Events.ERROR, function (_e, data) {
            if (data && data.fatal) {
              try {
                hls.destroy();
              } catch (e) {}
              video.src = src;
            }
          });
          hls.loadSource(src);
          hls.attachMedia(video);
        } else {
          video.src = src;
        }
        root.setAttribute("data-player-status", "ready");
      } catch (e) {
        root.setAttribute("data-player-status", "ready");
      }
    }
    function doPlay() {
      activateUI();
      root.setAttribute("data-player-status", "loading");
      return video.play().catch(function () {
        video.muted = true;
        root.setAttribute("data-player-muted", "true");
        return video.play().catch(function () {});
      });
    }

    btnsPlay.forEach(function (b) {
      b.addEventListener("click", function (e) {
        e.preventDefault();
        if (video.paused) doPlay();
        else video.pause();
      });
    });
    if (btnMute) {
      btnMute.addEventListener("click", function (e) {
        e.preventDefault();
        video.muted = !video.muted;
        root.setAttribute("data-player-muted", String(video.muted));
        activateUI();
      });
    }
    if ($vol) {
      try {
        $vol.value = String(video.volume || 1);
      } catch (e) {}
      $vol.addEventListener("input", function () {
        var v = Math.min(1, Math.max(0, parseFloat(this.value)));
        video.volume = v;
        video.muted = v === 0;
        root.setAttribute("data-player-muted", String(video.muted));
      });
    }
    if (btnFs) {
      btnFs.addEventListener("click", function (e) {
        e.preventDefault();
        toggleFullscreen(root);
      });
    }
    document.addEventListener("fullscreenchange", function () {
      var on = !!document.fullscreenElement;
      root.setAttribute("data-player-fullscreen", String(on));
    });

    if (lazy === "true") {
      var firstLoad = function () {
        root.removeEventListener("click", firstLoad);
        btnsPlay.forEach(function (b) {
          b.removeEventListener("click", firstLoad);
        });
        loadSource();
      };
      root.addEventListener("click", firstLoad);
      btnsPlay.forEach(function (b) {
        b.addEventListener("click", firstLoad, { once: true });
      });
    } else {
      loadSource();
    }

    var activateOnGesture = function () {
      activateUI();
    };
    root.addEventListener("click", activateOnGesture);
    root.addEventListener("touchstart", activateOnGesture, { passive: true });

    video.addEventListener("loadedmetadata", function () {
      setAspectFromMeta();
      if ($durTxt) $durTxt.textContent = fmt(video.duration);
    });
    video.addEventListener("canplay", function () {
      activateUI();
      if (auto && (muted || video.muted)) {
        video.muted = true;
        doPlay();
      }
    });
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
    video.addEventListener("ended", function () {
      if ($bar) $bar.style.width = "100%";
      if ($handle) $handle.style.left = "100%";
    });

    video.addEventListener("timeupdate", function () {
      if ($progTxt) $progTxt.textContent = fmt(video.currentTime);
      if (isFinite(video.duration) && video.duration > 0) {
        var pct = Math.max(
          0,
          Math.min(100, (video.currentTime / video.duration) * 100)
        );
        if ($bar) $bar.style.width = pct + "%";
        if ($handle) $handle.style.left = pct + "%";
      }
    });
    video.addEventListener("progress", function () {
      if (
        !$buff ||
        !video.buffered ||
        !isFinite(video.duration) ||
        video.duration <= 0
      )
        return;
      try {
        var end = video.buffered.length
          ? video.buffered.end(video.buffered.length - 1)
          : 0;
        var pct = Math.max(0, Math.min(100, (end / video.duration) * 100));
        $buff.style.width = pct + "%";
      } catch (e) {}
    });

    if ($track) {
      var dragging = false;
      function pctFromEvent(ev) {
        var rect = $track.getBoundingClientRect();
        var x = (ev.touches ? ev.touches[0].clientX : ev.clientX) - rect.left;
        return Math.max(0, Math.min(1, x / rect.width));
      }
      function seek(ev) {
        if (!isFinite(video.duration) || video.duration <= 0) return;
        var pct = pctFromEvent(ev);
        video.currentTime = pct * video.duration;
      }
      $track.addEventListener("mousedown", function (ev) {
        dragging = true;
        root.setAttribute("data-timeline-drag", "true");
        seek(ev);
      });
      $track.addEventListener(
        "touchstart",
        function (ev) {
          dragging = true;
          root.setAttribute("data-timeline-drag", "true");
          seek(ev);
        },
        { passive: true }
      );

      window.addEventListener("mousemove", function (ev) {
        if (dragging) seek(ev);
      });
      window.addEventListener(
        "touchmove",
        function (ev) {
          if (dragging) seek(ev);
        },
        { passive: true }
      );

      function endDrag() {
        if (dragging) {
          dragging = false;
          root.setAttribute("data-timeline-drag", "false");
        }
      }
      window.addEventListener("mouseup", endDrag);
      window.addEventListener("touchend", endDrag);
      window.addEventListener("touchcancel", endDrag);
    }

    root.addEventListener("mouseenter", function () {
      root.setAttribute("data-player-hover", "active");
    });
    root.addEventListener("mouseleave", function () {
      root.setAttribute("data-player-hover", "idle");
    });

    root.addEventListener("keydown", function (e) {
      var tag = (e.target && e.target.tagName) || "";
      if (/INPUT|TEXTAREA|SELECT|BUTTON/.test(tag)) return;
      if (e.key === "k" || e.code === "Space") {
        e.preventDefault();
        if (video.paused) doPlay();
        else video.pause();
      }
      if (e.key === "m") {
        e.preventDefault();
        btnMute && btnMute.click();
      }
      if (e.key === "f") {
        e.preventDefault();
        toggleFullscreen(root);
      }
      if (e.key === "ArrowLeft")
        video.currentTime = Math.max(0, video.currentTime - 5);
      if (e.key === "ArrowRight")
        if (isFinite(video.duration))
          video.currentTime = Math.min(
            video.duration - 0.001,
            video.currentTime + 5
          );
    });
  }

  function initAll() {
    document
      .querySelectorAll("[data-bunny-player-init]")
      .forEach(initBunnyPlayerRoot);
  }

  $(initAll);

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
