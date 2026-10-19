/* Student View: live keyword search + category/status filters (DOM manipulation, no page reload). */
(function () {
    var search   = document.getElementById('search');
    var category = document.getElementById('filter-category');
    var status   = document.getElementById('filter-status');
    var grid     = document.getElementById('item-grid');
    var empty    = document.getElementById('empty-state');
    var count    = document.getElementById('result-count');
    var clearBtn = document.getElementById('clear-filters');
    var cards    = Array.prototype.slice.call(grid.querySelectorAll('.item-card'));

    function applyFilters() {
        var q = search.value.trim().toLowerCase();
        var shown = 0;

        cards.forEach(function (card) {
            var match =
                (q === '' || card.dataset.search.indexOf(q) !== -1) &&
                (category.value === '' || card.dataset.category === category.value) &&
                (status.value === '' || card.dataset.status === status.value);

            card.hidden = !match;
            if (match) { shown++; }
        });

        count.textContent = shown + (shown === 1 ? ' item' : ' items');
        empty.hidden = shown !== 0;
        grid.hidden = shown === 0;
    }

    function clearFilters() {
        search.value = '';
        category.value = '';
        status.value = '';
        applyFilters();
        search.focus();
    }

    search.addEventListener('input', applyFilters);
    category.addEventListener('change', applyFilters);
    status.addEventListener('change', applyFilters);
    clearBtn.addEventListener('click', clearFilters);

    applyFilters();
})();
