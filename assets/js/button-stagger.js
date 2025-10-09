(function () {
  const initButtonCharacterStagger = ($scope) => {
    const roots = ($scope ? $scope[0] : document).querySelectorAll(
      "[data-button-animate-chars]"
    );

    roots.forEach((root) => {
      if (root.dataset.hasselCharsInit === "1") return;

      const text = root.textContent;
      root.innerHTML = "";
      [...text].forEach((char, i) => {
        const span = document.createElement("span");
        span.textContent = char;
        span.style.transitionDelay = `${i * 0.01}s`;
        if (char === " ") span.style.whiteSpace = "pre";
        root.appendChild(span);
      });
      root.dataset.hasselCharsInit = "1";
    });
  };

  document.addEventListener("DOMContentLoaded", () => {
    initButtonCharacterStagger();
  });

  window.addEventListener("elementor/frontend/init", () => {
    const handler = ($scope) => initButtonCharacterStagger($scope);
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/hassel_button_stagger.default",
      handler
    );
  });
})();
