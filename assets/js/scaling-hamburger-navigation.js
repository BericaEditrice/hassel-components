function initScalingHamburgerNavigation() {
  const navStatusEl = document.querySelector("[data-navigation-status]");
  if (!navStatusEl) return;

  // Toggle Menu
  document
    .querySelectorAll('[data-navigation-toggle="toggle"]')
    .forEach((toggleBtn) => {
      toggleBtn.onclick = () => {
        const isActive =
          navStatusEl.getAttribute("data-navigation-status") === "active";
        navStatusEl.setAttribute(
          "data-navigation-status",
          isActive ? "not-active" : "active"
        );
      };
    });

  // Close Menu
  document
    .querySelectorAll('[data-navigation-toggle="close"]')
    .forEach((closeBtn) => {
      closeBtn.onclick = () =>
        navStatusEl.setAttribute("data-navigation-status", "not-active");
    });

  // ESC Key
  document.addEventListener("keydown", (e) => {
    if (
      e.key === "Escape" &&
      navStatusEl.getAttribute("data-navigation-status") === "active"
    ) {
      navStatusEl.setAttribute("data-navigation-status", "not-active");
    }
  });

  // Handle Submenu Toggle
  document
    .querySelectorAll(
      ".hamburger-nav__li.menu-item-has-children > .hamburger-nav__a"
    )
    .forEach((link) => {
      let firstClick = 0;
      link.addEventListener("click", (e) => {
        const now = Date.now();
        const submenu = link.nextElementSibling;
        if (submenu && submenu.classList.contains("hamburger-nav__submenu")) {
          if (
            !submenu.classList.contains("is-open") ||
            now - firstClick < 600
          ) {
            e.preventDefault();
            submenu.classList.toggle("is-open");
            firstClick = now;
          }
        }
      });
    });
}

// Init both frontend + editor
document.addEventListener("DOMContentLoaded", initScalingHamburgerNavigation);
window.addEventListener("elementor/frontend/init", () => {
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/hassel_scaling_hamburger_navigation.default",
    initScalingHamburgerNavigation
  );
});
