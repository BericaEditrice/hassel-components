function initScalingHamburgerNavigation(root) {
  const scope = root && root.querySelector ? root : document;

  scope.querySelectorAll("[data-navigation-status]").forEach((nav) => {
    // Toggle Navigation
    nav.querySelectorAll('[data-navigation-toggle="toggle"]').forEach((btn) => {
      btn.addEventListener("click", () => {
        nav.setAttribute(
          "data-navigation-status",
          nav.getAttribute("data-navigation-status") === "active"
            ? "not-active"
            : "active"
        );
      });
    });

    // Close Navigation
    nav.querySelectorAll('[data-navigation-toggle="close"]').forEach((btn) => {
      btn.addEventListener("click", () =>
        nav.setAttribute("data-navigation-status", "not-active")
      );
    });

    // ESC key
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape")
        nav.setAttribute("data-navigation-status", "not-active");
    });

    // Submenu toggle (previene la navigazione del genitore)
    nav
      .querySelectorAll(
        ".hamburger-nav__li.menu-item-has-children > .hamburger-nav__a"
      )
      .forEach((link) => {
        link.addEventListener("click", (e) => {
          const li = link.closest(".hamburger-nav__li");
          const submenu = li.querySelector(".hamburger-nav__submenu");
          if (submenu) {
            e.preventDefault();
            const opened = submenu.classList.contains("is-open");
            submenu.classList.toggle("is-open", !opened);
            li.classList.toggle("is-open", !opened);
          }
        });
      });
  });
}

/* Frontend init */
window.addEventListener("load", () => initScalingHamburgerNavigation(document));

/* Elementor editor init */
window.addEventListener("elementor/frontend/init", () => {
  if (typeof elementorFrontend !== "undefined") {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/hassel_scaling_hamburger_navigation.default",
      ($scope) => {
        const el = $scope && $scope[0] ? $scope[0] : $scope;
        if (el) initScalingHamburgerNavigation(el);
      }
    );
  }
});
