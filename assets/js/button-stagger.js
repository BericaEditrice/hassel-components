(function () {
  function initButtonCharacterStagger($scope) {
    const scope = $scope ? $scope[0] : document;
    const roots = scope.querySelectorAll("[data-button-animate-chars]");
    const offsetIncrement = 0.01;

    roots.forEach((root) => {
      if (root.dataset.hasselCharsInit === "1") return;

      const text = root.textContent.trim();
      root.innerHTML = "";
      [...text].forEach((char, i) => {
        const span = document.createElement("span");
        span.textContent = char;
        span.style.transitionDelay = i * offsetIncrement + "s";
        if (char === " ") span.style.whiteSpace = "pre";
        root.appendChild(span);
      });
      root.dataset.hasselCharsInit = "1";
    });
  }

  // ✅ Frontend classico
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", () =>
      initButtonCharacterStagger()
    );
  } else {
    initButtonCharacterStagger();
  }

  // ✅ Elementor: attivazione anche su caricamenti AJAX o duplicazioni widget
  window.addEventListener("elementor/frontend/init", () => {
    const handler = ($scope) => initButtonCharacterStagger($scope);

    // Hook specifico del widget
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/hassel_button_stagger.default",
      handler
    );

    // Hook di fallback generico (in caso Elementor non riconosca il nome)
    elementorFrontend.hooks.addAction("frontend/element_ready/global", handler);
  });

  // ✅ Fallback finale: se Elementor non ha triggerato, esegui dopo 1s
  setTimeout(() => initButtonCharacterStagger(), 1000);
})();
