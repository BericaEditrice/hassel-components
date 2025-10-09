// FRONTEND ONLY
document.addEventListener("DOMContentLoaded", () => {
  const navs = document.querySelectorAll("[data-navigation-status]");
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

    // Chiudi menu (overlay)
    nav.querySelectorAll('[data-navigation-toggle="close"]').forEach((btn) => {
      btn.addEventListener("click", () =>
        nav.setAttribute("data-navigation-status", "not-active")
      );
    });

    // ESC chiude
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape")
        nav.setAttribute("data-navigation-status", "not-active");
    });

    // IMPORTANTISSIMO: niente listener sul link del genitore!
    // Il link (testo) deve navigare. Usiamo SOLO il chevron per aprire/chiudere.

    // Toggle submenu SOLO cliccando il chevron (span.nav-link__dropdown-icon)
    nav
      .querySelectorAll(
        ".hamburger-nav__li.menu-item-has-children .nav-link__dropdown-icon"
      )
      .forEach((icon) => {
        // Click col mouse
        icon.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();

          const li = icon.closest(".hamburger-nav__li");
          const submenu = li
            ? li.querySelector(".hamburger-nav__submenu")
            : null;
          if (!submenu) return;

          submenu.classList.toggle("is-open");
          li.classList.toggle("is-open");
        });

        // Accessibilità base: Enter/Space attivano il toggle
        icon.setAttribute("tabindex", "0");
        icon.setAttribute("role", "button");
        icon.addEventListener("keydown", (e) => {
          if (e.key === "Enter" || e.key === " ") {
            e.preventDefault();
            icon.click();
          }
        });
      });
  });
});
