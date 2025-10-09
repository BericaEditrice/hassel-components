function initScalingHamburgerNavigation(scope = document) {
  const navs = scope.querySelectorAll("[data-navigation-status]");
  if (!navs.length) return;

  navs.forEach((nav) => {
    // Toggle menu
    nav.querySelectorAll('[data-navigation-toggle="toggle"]').forEach((btn) => {
      btn.addEventListener("click", () => {
        const active = nav.getAttribute("data-navigation-status") === "active";
        nav.setAttribute(
          "data-navigation-status",
          active ? "not-active" : "active"
        );
      });
    });

    // Close on overlay
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

    // Submenu toggle (click only on parents)
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
            submenu.classList.toggle("is-open");
            li.classList.toggle("is-open");
          }
        });
      });
  });
}

// Run on DOM ready (frontend)
document.addEventListener("DOMContentLoaded", () => {
  initScalingHamburgerNavigation(document);

  // Observer fallback (es. markup dinamico o lazy load)
  const observer = new MutationObserver(() => {
    initScalingHamburgerNavigation(document);
  });
  observer.observe(document.body, { childList: true, subtree: true });
});

// Elementor editor hook
window.addEventListener("elementor/frontend/init", () => {
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/hassel_scaling_hamburger_navigation.default",
    ($scope) => {
      initScalingHamburgerNavigation($scope[0]);
    }
  );
});
