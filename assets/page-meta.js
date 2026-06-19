// Loupely Canvas - per page settings: header and footer toggle
//
// Shows a custom HTML box only when its matching "Use custom HTML" option is
// selected, for both the header and footer controls in the Page settings meta
// box. Reads the DOM only, with no values passed from PHP, so the same script
// serves the meta box wherever it is mounted. Behavior lives here, not in an
// inline script, per the build rules.

(function () {
  "use strict";

  var selects = document.querySelectorAll('select[data-lc-target]');

  selects.forEach(function (sel) {
    function sync() {
      var wrap = document.getElementById(sel.getAttribute('data-lc-target'));
      if (wrap) {
        wrap.style.display = (sel.value === 'custom') ? '' : 'none';
      }
    }
    sel.addEventListener('change', sync);
  });
})();
