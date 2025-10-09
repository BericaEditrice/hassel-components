// FRONTEND-ONLY INIT (niente hook Elementor)
document.addEventListener("DOMContentLoaded", () => {
  const navs = document.querySelectorAll("[data-navigation-status]");
  if (!navs.length) return;

  navs.forEach((nav) => {
    // Toggle menu principale
    nav.querySelectorAll('[data-navigation-toggle="toggle"]').forEach((btn) => {
      btn.addEventListener("click", () => {
        const isActive =
          nav.getAttribute("data-navigation-status") === "active";
        nav.setAttribute(
          "data-navigation-status",
          isActive ? "not-active" : "active"
        );
      });
    });

    // Chiudi menu (overlay)
    nav.querySelectorAll('[data-navigation-toggle="close"]').forEach((btn) => {
      btn.addEventListener("click", () => {
        nav.setAttribute("data-navigation-status", "not-active");
      });
    });

    // ESC chiude
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        nav.setAttribute("data-navigation-status", "not-active");
      }
    });

    // SOTTOMENU: PRIMO CLICK APRE, SECONDO CLICK NAVIGA
    nav
      .querySelectorAll(
        ".hamburger-nav__li.menu-item-has-children > .hamburger-nav__a"
      )
      .forEach((link) => {
        link.addEventListener("click", (e) => {
          const li = link.closest(".hamburger-nav__li");
          const submenu = li
            ? li.querySelector(".hamburger-nav__submenu")
            : null;
          if (!submenu) return; // nessun submenu, comportamento normale

          if (!submenu.classList.contains("is-open")) {
            // primo click: APRI e blocca navigazione
            e.preventDefault();
            submenu.classList.add("is-open");
            li.classList.add("is-open");
          } else {
            // submenu già aperto:
            // - se href è “#” o vuoto => usalo come toggle (chiudi)
            // - altrimenti lascia NAVIGARE
            const href = (link.getAttribute("href") || "").trim();
            if (href === "" || href === "#") {
              e.preventDefault();
              submenu.classList.remove("is-open");
              li.classList.remove("is-open");
            }
          }
        });
      });
  });
});
