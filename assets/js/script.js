(function () {
  function initButtonCharacterStagger($scope) {
    const roots = ($scope ? $scope[0] : document).querySelectorAll(
      "[data-button-animate-chars]"
    );
    const offsetIncrement = 0.01;

    roots.forEach((root) => {
      // evita di reiniettare se già segmentato
      if (root.dataset.hasselCharsInit === "1") return;

      const text = root.textContent;
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

  // Frontend classico
  document.addEventListener("DOMContentLoaded", function () {
    initButtonCharacterStagger();
  });

  // Editor Elementor: re-init ad ogni render del widget
  window.addEventListener("elementor/frontend/init", function () {
    const handler = function ($scope) {
      initButtonCharacterStagger($scope);
    };
    // hook generico per tutti i widget (così funziona se rinomini)
    elementorFrontend.hooks.addAction("frontend/element_ready/widget", handler);
    // o, se vuoi essere super-specifco sul tuo:
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/hassel_button_stagger.default",
      handler
    );
  });
})();
