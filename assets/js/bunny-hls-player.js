(function () {
  // Step 1: placeholder senza logica. Verifichiamo solo che si carichi.
  if (typeof window !== "undefined") {
    window.addEventListener("elementor/frontend/init", function () {
      /* no-op */
    });
  }
})();
