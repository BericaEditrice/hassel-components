function initScalingHamburgerNavigation(scope = document) {
  const navs = scope.querySelectorAll("[data-navigation-status]");
  if (!navs.length) return;

  navs.forEach((nav) => {
    // Toggle menu principale
    nav.querySelectorAll('[data-navigation-toggle="toggle"]').forEach((btn) => {
      btn.addEventListener("click", () => {
        const active = nav.getAttribute("data-navigation-status") === "active";
        nav.setAttribute(
          "data-navigation-status",
          active ? "not-active" : "active"
        );
      });
    });

    // Chiudi menu (overlay o ESC)
    nav.querySelectorAll('[data-navigation-toggle="close"]').forEach((btn) => {
      btn.addEventListener("click", () =>
        nav.setAttribute("data-navigation-status", "not-active")
      );
    });
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape")
        nav.setAttribute("data-navigation-status", "not-active");
    });

    // Toggle submenu SOLO sul chevron
    nav
      .querySelectorAll(
        ".hamburger-nav__li.menu-item-has-children .nav-link__dropdown-icon"
      )
      .forEach((icon) => {
        icon.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          const li = icon.closest(".hamburger-nav__li");
          const submenu = li.querySelector(".hamburger-nav__submenu");
          if (submenu) {
            submenu.classList.toggle("is-open");
            li.classList.toggle("is-open");
          }
        });
      });
  });
}

// Frontend: DOM ready
document.addEventListener("DOMContentLoaded", () => {
  initScalingHamburgerNavigation(document);

  // Fallback per markup dinamico
  const observer = new MutationObserver(() => {
    initScalingHamburgerNavigation(document);
  });
  observer.observe(document.body, { childList: true, subtree: true });
});

// Elementor editor
window.addEventListener("elementor/frontend/init", () => {
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/hassel_hamburger_navigation.default",
    ($scope) => {
      initScalingHamburgerNavigation($scope[0]);
    }
  );
});
