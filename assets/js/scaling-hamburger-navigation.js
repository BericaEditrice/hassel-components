function initScalingHamburgerNavigation(root) {
  const scope = root && root.querySelector ? root : document;

  scope.querySelectorAll("[data-navigation-status]").forEach((nav) => {
    // Toggle Menu
    nav.querySelectorAll('[data-navigation-toggle="toggle"]').forEach((btn) => {
      btn.addEventListener("click", () => {
        const active = nav.getAttribute("data-navigation-status") === "active";
        nav.setAttribute(
          "data-navigation-status",
          active ? "not-active" : "active"
        );
      });
    });

    // Close Menu
    nav.querySelectorAll('[data-navigation-toggle="close"]').forEach((btn) => {
      btn.addEventListener("click", () => {
        nav.setAttribute("data-navigation-status", "not-active");
      });
    });

    // ESC Key
    document.addEventListener("keydown", (e) => {
      if (
        e.key === "Escape" &&
        nav.getAttribute("data-navigation-status") === "active"
      ) {
        nav.setAttribute("data-navigation-status", "not-active");
      }
    });

    // Submenu toggle: genitori con figli
    nav
      .querySelectorAll(
        ".hamburger-nav__li.menu-item-has-children > .hamburger-nav__a"
      )
      .forEach((link) => {
        link.addEventListener("click", (e) => {
          const submenu = link.nextElementSibling; // <ul class="hamburger-nav__submenu">
          if (submenu && submenu.classList.contains("hamburger-nav__submenu")) {
            if (!submenu.classList.contains("is-open")) {
              e.preventDefault(); // primo click: apri
              submenu.classList.add("is-open");
            } // secondo click: submenu già aperto -> lascia navigare
          }
        });
      });
  });
}

// Avvio FRONTEND
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", () =>
    initScalingHamburgerNavigation(document)
  );
} else {
  initScalingHamburgerNavigation(document);
}

// Avvio EDITOR Elementor (per singola istanza widget)
window.addEventListener("elementor/frontend/init", () => {
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/hassel_scaling_hamburger_navigation.default",
    ($scope) => {
      const el = $scope && $scope[0] ? $scope[0] : $scope;
      if (el) initScalingHamburgerNavigation(el);
    }
  );
});
