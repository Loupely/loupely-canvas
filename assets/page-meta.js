// Loupely Canvas - per page settings: header and footer mode toggle
//
// Shows the sub-control that matches the selected mode for each header and
// footer control, and hides the others. A sub-control is any element carrying
// data-lc-part (matching the select's part) and data-lc-mode (the mode it
// belongs to): the theme's own custom HTML box uses data-lc-mode="custom", and
// an extension like Canvas Pro adds a set picker with data-lc-mode="set". Reads
// the DOM only, with no values passed from PHP, so the same script serves the
// controls wherever they are mounted, including the Canvas Pro page editor.
// Behavior lives here, not in an inline script, per the build rules.

(function () {
  "use strict";

  var selects = document.querySelectorAll('select[data-lc-part]');

  selects.forEach(function (sel) {
    var part = sel.getAttribute('data-lc-part');
    var subs = document.querySelectorAll('[data-lc-part="' + part + '"][data-lc-mode]');

    function sync() {
      subs.forEach(function (el) {
        el.style.display = (el.getAttribute('data-lc-mode') === sel.value) ? '' : 'none';
      });
    }

    sel.addEventListener('change', sync);
    sync();
  });
})();
