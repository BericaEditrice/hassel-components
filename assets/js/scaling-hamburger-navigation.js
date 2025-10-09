function initScalingHamburgerNavigation() {
  const navStatusEl = document.querySelector("[data-navigation-status]");
  if (!navStatusEl) return;

  // Toggle Navigation
  document
    .querySelectorAll('[data-navigation-toggle="toggle"]')
    .forEach((toggleBtn) => {
      toggleBtn.addEventListener("click", () => {
        const isActive =
          navStatusEl.getAttribute("data-navigation-status") === "active";
        navStatusEl.setAttribute(
          "data-navigation-status",
          isActive ? "not-active" : "active"
        );
      });
    });

  // Close Navigation
  document
    .querySelectorAll('[data-navigation-toggle="close"]')
    .forEach((closeBtn) => {
      closeBtn.addEventListener("click", () => {
        navStatusEl.setAttribute("data-navigation-status", "not-active");
      });
    });

  // Close on ESC
  document.addEventListener("keydown", (e) => {
    if (
      e.key === "Escape" &&
      navStatusEl.getAttribute("data-navigation-status") === "active"
    ) {
      navStatusEl.setAttribute("data-navigation-status", "not-active");
    }
  });

  // Handle submenu click
  document
    .querySelectorAll(
      ".hamburger-nav__li.menu-item-has-children > .hamburger-nav__a"
    )
    .forEach((link) => {
      let firstClickTime = 0;
      link.addEventListener("click", (e) => {
        const now = Date.now();
        const submenu = link.nextElementSibling;
        if (submenu && submenu.classList.contains("hamburger-nav__submenu")) {
          if (
            !submenu.classList.contains("is-open") ||
            now - firstClickTime < 600
          ) {
            e.preventDefault();
            submenu.classList.toggle("is-open");
            firstClickTime = now;
          }
        }
      });
    });
}

// Initialize on frontend and Elementor editor
function initHamburgerOnElementor() {
  initScalingHamburgerNavigation();
  window.addEventListener("elementor/frontend/init", () => {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/hassel_scaling_hamburger_navigation.default",
      () => {
        initScalingHamburgerNavigation();
      }
    );
  });
}

document.addEventListener("DOMContentLoaded", initHamburgerOnElementor);
