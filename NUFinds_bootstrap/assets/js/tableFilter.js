/*
 * Generic table filter for the Admin Panel (Manage Items, Report Log).
 * Markup: a [data-filter-scope] container with data-target="#tbodyId" and data-count="#countId",
 * holding inputs/selects marked data-filter="search|status|category|type".
 * Each <tr> carries data-search, data-status, data-category and/or data-type.
 */
(function () {
    document.querySelectorAll('[data-filter-scope]').forEach(function (scope) {
        var body    = document.querySelector(scope.dataset.target);
        var counter = document.querySelector(scope.dataset.count);
        var rows    = Array.prototype.slice.call(body.querySelectorAll('tr[data-search]'));
        var none    = body.querySelector('.no-results');
        var controls = scope.querySelectorAll('[data-filter]');
        var noun = counter.textContent.trim().split(' ').pop(); // items, reports, or claims

        function apply() {
            var f = {};
            controls.forEach(function (c) { f[c.dataset.filter] = c.value.trim().toLowerCase(); });

            var shown = 0;
            rows.forEach(function (row) {
                var ok =
                    (!f.search   || row.dataset.search.indexOf(f.search) !== -1) &&
                    (!f.status   || (row.dataset.status   || '').toLowerCase() === f.status) &&
                    (!f.category || (row.dataset.category || '').toLowerCase() === f.category) &&
                    (!f.type     || (row.dataset.type     || '').toLowerCase() === f.type);
                row.hidden = !ok;
                if (ok) { shown++; }
            });

            if (none) { none.hidden = shown !== 0; }
            counter.textContent = 'Showing ' + shown + ' of ' + rows.length + ' ' + noun;
        }

        controls.forEach(function (c) {
            c.addEventListener(c.tagName === 'SELECT' ? 'change' : 'input', apply);
        });
    });
})();
