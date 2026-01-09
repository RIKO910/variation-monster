jQuery(function($) {

    initSwatches();

    /**
     * Handle filter changes
     */
    jQuery(document).on('change', '.varimo-filter-checkbox', function() {
        applyFilters();
    });

    /**
     * Handle swatch/list item clicks (for better UX with all filter types)
     */
    jQuery(document).on('click', '.varimo-filter-color-box, .varimo-filter-image-swatch, .varimo-filter-button-swatch, .varimo-filter-list-item label', function(e) {
        e.preventDefault();
        var $label = jQuery(this).closest('label');
        var $checkbox = $label.find('.varimo-filter-checkbox');

        $checkbox.prop('checked', !$checkbox.prop('checked')).trigger('change');

        $label.toggleClass('checked', $checkbox.prop('checked'));
    });

    // Handle browser back/forward
    jQuery(window).on('popstate', function() {
        varimo_filter_update_products();
    });

    /**
     * Initialize swatches with proper classes
     */
    function initSwatches() {
        jQuery('.varimo-filter-checkbox:checked').each(function() {
            jQuery(this).closest('label').addClass('checked');
        });
    }

    /**
     * Apply all current filters
     */
    function applyFilters() {
        var $widget = jQuery('.varimo-filter-filters-container');
        var queryType = $widget.data('query-type') || 'and';
        var filters = {};

        jQuery('.varimo-filter-checkbox:checked', $widget).each(function() {
            var attribute = jQuery(this).data('attribute');
            if (!filters['filter_' + attribute]) {
                filters['filter_' + attribute] = [];
            }
            filters['filter_' + attribute].push(jQuery(this).val());
        });

        // Convert arrays to comma-separated strings
        for (var key in filters) {
            if (Array.isArray(filters[key])) {
                filters[key] = filters[key].join(',');
            }
        }

        // Add query type
        filters['query_type'] = queryType;
        filters['page'] = 1; // Always reset to first page

        // Update URL without reloading
        updateUrl(filters);
        varimo_filter_update_products();
    }

    /**
     * Update URL without page reload
     */
    function updateUrl(filters) {
        var params = new URLSearchParams(window.location.search);

        // Clear existing filter params
        params.forEach((value, key) => {
            if (key.startsWith('filter_') || key === 'query_type') {
                params.delete(key);
            }
        });

        // Add new filters
        for (var key in filters) {
            if (filters[key]) {
                params.set(key, filters[key]);
            }
        }

        var newUrl = window.location.pathname + '?' + params.toString();
        history.pushState({}, '', newUrl);

        window.location.reload();
    }

    /**
     * Update products via AJAX
     */
    function varimo_filter_update_products() {
        var $productsContainer = jQuery('.products, .woocommerce-pagination');
        var $filtersContainer = jQuery('.varimo-filter-filters-container');

        $productsContainer.addClass('varimo-filter-loading');
        $filtersContainer.addClass('varimo-filter-loading');

        // Get current filters from URL
        var params = new URLSearchParams(window.location.search);
        var filters = {};
        params.forEach(function(value, key) {
            filters[key] = value;
        });

        jQuery.ajax({
            url: varimo_filter_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'varimo_filter_get_products',
                nonce: varimo_filter_vars.nonce,
                ...filters
            },
            success: function(response) {
                if (response.success) {
                    // Replace products and pagination
                    $productsContainer.replaceWith(response.data.products);

                    // Update active filter states
                    updateActiveFilters(filters);

                    // Reinitialize WooCommerce scripts
                    jQuery(document.body).trigger('wc-products-loaded');

                    // Reinitialize swatches
                    initSwatches();
                }
            },
            complete: function() {
                $productsContainer.removeClass('varimo-filter-loading');
                $filtersContainer.removeClass('varimo-filter-loading');
            }
        });
    }

    /**
     * Update active filter states
     */
    function updateActiveFilters(filters) {
        // Reset all filters
        jQuery('.varimo-filter-checkbox').prop('checked', false).closest('label').removeClass('checked');

        // Set active filters
        for (var key in filters) {
            if (key.startsWith('filter_')) {
                var attribute = key.replace('filter_', '');
                var values = filters[key].split(',');


                // Handle checkboxes/radios
                values.forEach(function(value) {
                    jQuery('.varimo-filter-checkbox[data-attribute="' + attribute + '"][value="' + value + '"]')
                        .prop('checked', true)
                        .closest('label').addClass('checked');
                });
            }
        }
    }

    /**
     * Handle Load More button clicks
     */
    jQuery(document).on('click', '.varimo-filter-load-more', function() {
        var $button = jQuery(this);
        var $container = $button.siblings('.varimo-filter-terms-container');
        var attribute = $button.data('attribute');

        // Show all hidden terms
        $container.find('.varimo-filter-term-hidden').removeClass('varimo-filter-term-hidden');

        // Hide Load More and show Show Less
        $button.hide();
        $button.siblings('.varimo-filter-show-less').show();
    });

    /**
     * Handle Show Less button clicks
     */
    jQuery(document).on('click', '.varimo-filter-show-less', function() {
        var $button = jQuery(this);
        var $container = $button.siblings('.varimo-filter-terms-container');
        var attribute = $button.data('attribute');
        var initialCount = varimo_variation_swatches.filterAttributeDisplayLimit;

        // Hide terms beyond the initial count
        $container.find('.varimo-filter-term:gt(' + (initialCount - 1) + ')').addClass('varimo-filter-term-hidden');

        // Hide Show Less and show Load More
        $button.hide();
        $button.siblings('.varimo-filter-load-more').show();

        // Scroll to the top of the attribute filter
        $container.parent().get(0).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});