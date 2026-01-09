function varimoSwatchesArchivePageCart(){
    let selectedAttributes = {};
    let firstAttributeSelected = null;
    let secondAttributeSelected = null;
    let thirdAttributeSelected = null;

    function resetProductSelections(productID) {
        // Reset selected attributes, selection order, and states
        selectedAttributes = {};
        // attributeSelectionOrder = [];
        firstAttributeSelected = null;
        secondAttributeSelected = null;
        thirdAttributeSelected = null;
        // Enable all buttons and reset styling for the current product
        jQuery(`[data-product_id="${productID}"]`)
            .removeClass('');
    }

    jQuery('.variations-display input[type="radio"], .variations-display button')
        .not('.quick-variable-tooltip input, .quick-variable-tooltip button')
        .not('.vmonster-quick-view-modal input, .vmonster-quick-view-modal button').off('click')
        .on('click', function () {

            const $currentProduct = jQuery(this).closest('.variations-display');
            const selectedValue = jQuery(this).attr('data-value');
            let availableVariations = jQuery(this).data('available_variations');
            let attributeName = jQuery(this).data('variation-name');
            const selectedAttribute = jQuery(this).attr('data-variation-name');
            const productID = jQuery(this).attr('data-product_id');

            if (!$currentProduct.data('product-initialized')) {
                resetProductSelections(productID);
                // Set the flag to prevent resetting for the same product
                $currentProduct.data('product-initialized', true);
            } else {
                // Now reset the current product selections
                resetProductSelections(productID);
                $currentProduct.data('product-initialized', true);
            }

            // Update selected attributes
            selectedAttributes[selectedAttribute] = selectedValue;

            function findWhichButtonDisabled() {
                setTimeout(() => {
                    const attributes = getChosenAttribute($currentProduct);
                    const currentAttributes = attributes.data;

                    // Get selected values from the current product
                    const selectedValues = {};
                    $currentProduct.find('input[type="radio"]:checked, button.selected').each(function () {
                        const attributeName = jQuery(this).data('variation-name');
                        const value = jQuery(this).data('value');
                        if (value) {
                            selectedValues[attributeName] = value;
                        }
                    });

                    $currentProduct.find('[data-variation-name]').each(function (index, el) {
                        var $select = jQuery(el);
                        var attributeName = $select.attr('data-variation-name');
                        var checkAttributes = jQuery.extend(true, {}, currentAttributes);
                        checkAttributes[attributeName] = '';

                        var variations = findMatchingVariations(availableVariations, checkAttributes);
                        if (attributes.count === attributes.chosenCount) {
                            checkVariation(attributes, variations, productID);
                        }

                        $currentProduct.find('input[type="radio"], button').each(function () {
                            var $button = jQuery(this);
                            if ($button.data('variation-name') === attributeName) {
                                var buttonValue = String($button.data('value') || '');
                                var isEnabled = variations.some(function (variation) {
                                    var attrValue = variation.attributes[attributeName];

                                    // Ensure proper checks for null or undefined values
                                    if (attrValue === buttonValue) {
                                        return true;
                                    } else if (attrValue === '' || attrValue === undefined) {
                                        return true;
                                    } else if (buttonValue === '') {
                                        return true;
                                    }
                                    return false;
                                });

                                $button.prop('disabled', !isEnabled);

                                if (!isEnabled) {
                                    $button.css('opacity', '0.5').addClass('disabled-option');
                                } else {
                                    $button.css('opacity', '1').removeClass('disabled-option');
                                }

                                // Remove any existing tooltip first
                                $button.find('.stock-tooltip-varimo-swatches').remove();

                                // Check if other attributes are selected
                                var otherAttributesSelected = Object.keys(selectedValues).some(function (key) {
                                    return key !== attributeName && selectedValues[key] && selectedValues[key] !== '';
                                });

                                if (otherAttributesSelected && varimo_variation_swatches.variationStockInfo === 'true') {
                                    // Find matching variations for current selections + this button's value
                                    var matchingVariations = availableVariations.filter(function (variation) {
                                        return Object.keys(selectedValues).every(function (key) {
                                            // Skip if this is the current attribute we're processing
                                            if (key === attributeName) return true;

                                            // Get the selected value and variation value
                                            var selectedValue = selectedValues[key];
                                            var variationValue = variation.attributes[key];

                                            // If nothing is selected, match any variation
                                            if (selectedValue === '') return true;

                                            // If variation has no specific value (any size/color), it matches any selection
                                            if (variationValue === '' || variationValue === undefined) return true;

                                            // Otherwise values must match exactly
                                            return variationValue === selectedValue;
                                        }) && (
                                            // Current button's attribute must match
                                            variation.attributes[attributeName] === buttonValue ||
                                            // OR variation accepts any value for this attribute
                                            (variation.attributes[attributeName] === '' && buttonValue !== '')
                                        );
                                    });

                                    // Find the first variation with max_qty (prioritizing in-stock items)
                                    var bestVariation = matchingVariations.find(function (v) {
                                        return v.max_qty > 0 && v.is_in_stock;
                                    }) || matchingVariations[0];

                                    // Only show tooltip if we have quantity data
                                    if (bestVariation && bestVariation.max_qty > 0) {
                                        $button.append(`
                                            <div class="stock-tooltip-varimo-swatches">
                                                ${bestVariation.max_qty} Left
                                            </div>
                                        `);
                                    }
                                }
                            }
                        });
                    });
                }, 50);
            }

            function findMatchingVariations(variations, attributes) {
                var matching = [];
                for (var i = 0; i < variations.length; i++) {
                    var variation = variations[i];

                    if (isMatch(variation.attributes, attributes)) {
                        matching.push(variation);
                    }
                }
                return matching;
            }

            function isMatch(variation_attributes, attributes) {
                var match = true;
                for (var attr_name in variation_attributes) {
                    if (variation_attributes.hasOwnProperty(attr_name)) {
                        var val1 = variation_attributes[attr_name];
                        var val2 = attributes[attr_name];
                        if (val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2) {
                            match = false;
                        }
                    }
                }
                return match;
            }


            function getChosenAttribute($currentProduct) {
                const data = {};
                let count = 0;
                let chosen = 0;

                // Get all variation attributes available for this product
                $currentProduct.find('[data-variation-name]').each(function () {
                    const attributeName = jQuery(this).attr('data-variation-name');

                    // Initialize all attributes with empty values
                    if (!(attributeName in data)) {
                        data[attributeName] = '';
                        count++;
                    }
                });

                // Update selected values
                $currentProduct.find('input[type="radio"]:checked, button.selected').each(function () {
                    const attributeName = jQuery(this).attr('data-variation-name');
                    const value = jQuery(this).attr('data-value');

                    if (value) {
                        data[attributeName] = value;
                        chosen++;
                    }
                });

                return {
                    count: count,
                    chosenCount: chosen,
                    data: data
                };
            }

            let isRequestInProgress = false; // Flag to track AJAX request status

            function checkVariation(attributes, variations, productID) {
                if (isRequestInProgress) {
                    return; // If request is in progress, return and don't proceed
                }

                let selectedAttributes = {};

                selectedAttributes = attributes.data;

                // Check for variations with the attribute match
                const matchingVariation = variations.find(variation => {
                    return isMatch(variation.attributes, attributes.data);
                });

                if (matchingVariation) {
                    const variation_id = matchingVariation.variation_id;

                    if (variation_id) {

                        // Get the gallery data and parse it
                        const tooltip = jQuery('.variation-monster-quick-cart-' + productID + '');
                        const galleryData = tooltip.data('all-variation-gallery-tooltip');
                        const parsedGallery = typeof galleryData === 'string' ? JSON.parse(galleryData) : galleryData;

                        // Get the specific variation's gallery
                        const tooltipImage = parsedGallery[variation_id];

                        if (tooltipImage[0]) {

                            var productItem = jQuery('.variation-monster-quick-cart-' + productID + '').closest('.product, .product-item, li.product');

                            // Try different selectors for the main image
                            var productImage = productItem.find('img:first, img.attachment-woocommerce_thumbnail, .woocommerce-product-gallery__image img, .wp-post-image');

                            console.log("productImage", productImage)

                            if (productImage.length) {
                                // Add cache-busting parameter
                                var newImageSrc = tooltipImage[0] + '?' + new Date().getTime();

                                // Change the image
                                productImage.attr('src', newImageSrc);

                                // For galleries
                                productImage.each(function () {
                                    var $img = jQuery(this);
                                    var $parent = $img.parent();

                                    if ($parent.hasClass('woocommerce-product-gallery__image')) {
                                        $parent.attr('data-thumb', newImageSrc);
                                    }

                                    // Some themes use data-src or other attributes
                                    $img.attr('data-src', newImageSrc);
                                    $img.attr('srcset', newImageSrc + ' 1x');
                                });

                                // Force redraw (sometimes needed for WebKit browsers)
                                productImage.hide().show(0);
                            } else {
                                console.log("No product image found - check your selectors");
                            }
                        }


                        // Set the flag to indicate that the request is in progress
                        isRequestInProgress = true;

                        // Add the spinner
                        $currentProduct.append('<div class="spinner-quick-cart-archive"><div class="spinner-archive"></div></div>');
                        $currentProduct.find('input[type="radio"], button').prop('disabled', true);

                        jQuery.ajax({
                            type: 'POST',
                            url: quick_front_ajax_obj.ajax_url,
                            data: {
                                action: 'add_variation_to_cart',
                                variation_id: variation_id,
                                variation: selectedAttributes,
                                product_id: productID,
                                quantity: 1,
                                nonce: quick_front_ajax_obj.nonce
                            },
                            success: function (response) {
                                if (response.success) {
                                    jQuery(document.body).trigger('wc_fragment_refresh');
                                    setTimeout(() => {
                                        $currentProduct.find('.spinner-quick-cart-archive').remove();
                                        $currentProduct.append(' <div class="archive-checkmark"><div class="checkmark">✔️</div></div> ');
                                    }, 1000);
                                } else {
                                    alert(response.data.message);
                                    $currentProduct.find('.spinner-quick-cart-archive').remove();
                                }

                                selectedAttributes = {}; // Reset selection

                                setTimeout(() => {
                                    $currentProduct.find('.checkmark').remove();
                                    $currentProduct
                                        .find('input[type="radio"], button')
                                        .prop('disabled', false)
                                        .removeClass('selected')
                                        .removeClass('disabled-option')
                                        .css('opacity', '1');
                                    $currentProduct.find('.archive-checkmark').remove();
                                }, 2000);

                                // Reset the flag after the AJAX request completes
                                isRequestInProgress = false;
                            },
                            error: function () {
                                $currentProduct
                                    .find('input[type="radio"], button')
                                    .prop('disabled', false)
                                    .removeClass('selected')
                                    .removeClass('disabled-option')
                                    .css('opacity', '1');

                                // Remove the spinner
                                $currentProduct.find('.spinner-quick-cart-archive').remove();
                                alert('An error occurred. Please try again.');

                                // Reset the flag after the AJAX request fails
                                isRequestInProgress = false;
                            },
                        });
                    }
                } else {
                    console.log("No matching variation found.");
                }
            }

            findWhichButtonDisabled()

        });
    }