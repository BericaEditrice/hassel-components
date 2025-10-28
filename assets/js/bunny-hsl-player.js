(function () {
  // Step 1: niente logica player, solo ping in console
  if (typeof window !== "undefined") {
    // Hook Elementor ready per sicurezza
    window.addEventListener("elementor/frontend/init", function () {
      // no-op
    });
  }
})();
