function varimoVariationSwatchesTemplateFour(){
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

        jQuery("body").on('click touchstart', '.quick-slide-variable', function () {
            const tooltip = jQuery(this).closest(".quick-variable-slide").siblings(".quick-variable-tooltip");

            // Find all attribute groups
            tooltip.find('.variations-display .custom-wc-buttons').each(function () {
                const attributeGroup = jQuery(this);
                const selectedButtons = attributeGroup.find('button.custom-button.selected, button.custom-image-button.selected, button.custom-color-button.selected');

                // Should only have one selected button per attribute group
                if (selectedButtons.length > 1) {
                    // Keep only the first one selected
                    selectedButtons.slice(1).removeClass('selected');
                }
            });

            // Now get the properly selected buttons
            const selectedButtons = tooltip.find('.variations-display button.custom-button.selected , .variations-display button.custom-image-button.selected , .variations-display button.custom-color-button.selected');

            selectedButtons.each(function () {
                const $currentProduct = jQuery(this).closest('.variations-display');
                const selectedValue = jQuery(this).attr('data-value');
                let availableVariations = jQuery(this).data('available_variations');
                let attributeName = jQuery(this).data('variation-name');
                const selectedAttribute = jQuery(this).attr('data-variation-name');
                const productID = jQuery(this).attr('data-product_id');
                const addToCartButtonFour = jQuery(`.variation-monster-template-four-cart[data-productid="${productID}"]`);

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


                        $currentProduct.find('[data-variation-name]').each(function (index, el) {
                            var $select = jQuery(el);
                            var attributeName = $select.attr('data-variation-name');
                            var checkAttributes = jQuery.extend(true, {}, currentAttributes);
                            checkAttributes[attributeName] = '';

                            var variations = findMatchingVariations(availableVariations, checkAttributes);
                            if (attributes.count === attributes.chosenCount) {
                                checkVariation(attributes, variations, productID);
                            } else {
                                addToCartButtonFour
                                    .attr('data-variationid', '')
                                    .prop('disabled', true)
                                    .css('opacity', '0.5');
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

                        addToCartButtonFour
                            .attr('data-variationid', matchingVariation.variation_id)
                            .prop('disabled', false)
                            .css('opacity', '1');

                        if (variation_id) {

                            const tooltip = jQuery('.quick-variable-tooltip[data-productid="' + productID + '"]').not('.quick-hidden').first();

                            // Get the gallery data and parse it
                            const galleryData = tooltip.data('all-variation-gallery-tooltip');
                            const parsedGallery = typeof galleryData === 'string' ? JSON.parse(galleryData) : galleryData;

                            // Get the specific variation's gallery
                            const variationGallery = parsedGallery[variation_id];

                            // Get price and SKU data
                            const priceSkuData = tooltip.data('all-variation-price-sku-tooltip');
                            const parsedPriceSku = typeof priceSkuData === 'string' ? JSON.parse(priceSkuData) : priceSkuData;
                            const variationPriceSku = parsedPriceSku[variation_id];

                            tooltip.find("p.variable-sku").text(variationPriceSku.sku);
                            tooltip.find("span#variable-product-price").html(variationPriceSku.price);

                            const $activeImageContainer = tooltip.find(".quick-variable-active-image img");
                            const $dotsContainer = tooltip.find(".quick-variable-dots");

                            // Clear existing dots
                            $dotsContainer.empty();

                            if (variationGallery && variationGallery.length > 0) {
                                // Set the first image as active
                                let currentIndex = 0;
                                $activeImageContainer.attr("src", variationGallery[0]);

                                // Clear existing dots
                                $dotsContainer.empty();

                                // Get or create navigation buttons
                                let $prevBtn = tooltip.find(".quick-gallery-prev");
                                let $nextBtn = tooltip.find(".quick-gallery-next");

                                // Create navigation buttons if they don't exist
                                if ($prevBtn.length === 0) {
                                    $prevBtn = jQuery('<button class="quick-gallery-prev" disabled>&#10094;</button>');
                                    $nextBtn = jQuery('<button class="quick-gallery-next">&#10095;</button>');
                                    $activeImageContainer.before($prevBtn);
                                    $activeImageContainer.after($nextBtn);
                                } else {
                                    // Reset button states
                                    $prevBtn.prop('disabled', true);
                                    $nextBtn.prop('disabled', variationGallery.length <= 1);
                                }

                                // Hide buttons if only one image
                                if (variationGallery.length === 1) {
                                    $prevBtn.hide();
                                    $nextBtn.hide();
                                } else {
                                    $prevBtn.show();
                                    $nextBtn.show();
                                }

                                // Create dots for each image
                                variationGallery.forEach((image, index) => {
                                    const dot = `<div class="quick-variable-dot" data-index="${index}" style="width: 10px; height: 10px; background: ${index === 0 ? '#000' : '#ccc'}; border-radius: 50%; cursor: pointer;"></div>`;
                                    $dotsContainer.append(dot);
                                });

                                // Function to update gallery state
                                const updateGallery = (index) => {
                                    currentIndex = index;
                                    $activeImageContainer.attr("src", variationGallery[index]);

                                    // Update dot styles
                                    $dotsContainer.find(".quick-variable-dot").css("background", "#ccc");
                                    $dotsContainer.find(`.quick-variable-dot[data-index="${index}"]`).css("background", "#000");

                                    // Update button states
                                    $prevBtn.prop('disabled', index === 0);
                                    $nextBtn.prop('disabled', index === variationGallery.length - 1);
                                };

                                // Click event for dots
                                $dotsContainer.off('click', '.quick-variable-dot').on('click', '.quick-variable-dot', function () {
                                    const index = jQuery(this).data("index");
                                    updateGallery(index);
                                });

                                // Click event for next button (mobile-friendly)
                                $nextBtn.off('click touchstart').on('click touchstart', function (e) {
                                    e.preventDefault();
                                    if (currentIndex < variationGallery.length - 1) {
                                        updateGallery(currentIndex + 1);
                                    }
                                });

                                // Click event for prev button (mobile-friendly)
                                $prevBtn.off('click touchstart').on('click touchstart', function (e) {
                                    e.preventDefault();
                                    if (currentIndex > 0) {
                                        updateGallery(currentIndex - 1);
                                    }
                                });
                            }


                            let addToCartButton = jQuery('.quick-add-to-cart-shop-page-template-four[data-productid="' + productID + '"]');
                            if (addToCartButton.length) {
                                addToCartButton.attr('data-variationid', variation_id);
                            }
                            // Set the flag to indicate that the request is in progress
                            // Remove any existing click handlers first
                            addToCartButton.off('click');

                            // Add new click handler
                            addToCartButton.on('click', function () {
                                if (isRequestInProgress) return;

                                const button = jQuery(this);
                                button.prop('disabled', true);
                                button.find('i, span').hide();

                                if (!button.hasClass('loading')) {
                                    button.append('<i class="fa fa-spinner fa-spin spin-icon-remove"></i>');
                                }

                                var quantity = button.closest('.quick-quantity-container').find(".quick-quantity-input").val();

                                isRequestInProgress = true;

                                jQuery.ajax({
                                    type: 'POST',
                                    url: quick_front_ajax_obj.ajax_url,
                                    data: {
                                        action: 'woocommerce_ajax_add_to_cart',
                                        product_id: productID,
                                        quantity: quantity,
                                        variation_id: variation_id,  // Pass correct variation ID
                                        variation: selectedAttributes,
                                        _wpnonce: quick_front_ajax_obj.nonce,
                                    },
                                    success: function (response) {
                                        button.find('.spin-icon-remove').remove();
                                        button.find('.updated-check-add-to-cart').remove();
                                        button.append('<span class="updated-check-add-to-cart"><i class="fa fa-check"></i></span>');
                                        jQuery('.shop-page-show-success-message').html(`
                                        <div class="success-message" style="color: ${response.color}">
                                            <p>${response.message}</p>
                                        </div>
                                    `).fadeIn();

                                        // Hide the message after 3 seconds
                                        setTimeout(function () {
                                            button.find('.updated-check-add-to-cart').remove();
                                            jQuery('.shop-page-show-success-message').fadeOut();
                                            button.prop('disabled', false);
                                            button.find('i, span').show(); // Show icon and text
                                        }, 1000);

                                        // Update cart totals and item count
                                        jQuery(document.body).trigger('wc_fragment_refresh');
                                        isRequestInProgress = false;
                                    },
                                    error: function (response) {
                                        button.find('.spin-icon-remove').remove();
                                        jQuery('.shop-page-show-failed-message').html(`
                                        <div class="failed-message" style="color: ${response.color}">
                                            <p>${response.message}</p>
                                        </div>
                                    `).fadeIn();

                                        // Hide the message after 3 seconds
                                        setTimeout(function () {
                                            jQuery('.shop-page-show-failed-message').fadeOut();
                                            button.prop('disabled', false);
                                            button.find('i, span').show();
                                        }, 1000);
                                        isRequestInProgress = false;
                                    }
                                })

                            });
                        }
                    } else {
                        console.log("No matching variation found.");
                    }
                }

                findWhichButtonDisabled()
            });
        });

        let toolTip = jQuery(".quick-variable-tooltip");

        toolTip.find('.variations-display input[type="radio"], .variations-display button').on('click', function () {

            const $currentProduct = jQuery(this).closest('.variations-display');
            const selectedValue = jQuery(this).attr('data-value');
            let availableVariations = jQuery(this).data('available_variations');
            let attributeName = jQuery(this).data('variation-name');
            const selectedAttribute = jQuery(this).attr('data-variation-name');
            const productID = jQuery(this).attr('data-product_id');
            const addToCartButtonFour = jQuery(`.variation-monster-template-four-cart[data-productid="${productID}"]`);
            const tooltip = jQuery('.quick-variable-tooltip[data-productid="' + productID + '"]').not('.quick-hidden').first();

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


                    $currentProduct.find('[data-variation-name]').each(function (index, el) {
                        var $select = jQuery(el);
                        var attributeName = $select.attr('data-variation-name');
                        var checkAttributes = jQuery.extend(true, {}, currentAttributes);
                        checkAttributes[attributeName] = '';

                        var variations = findMatchingVariations(availableVariations, checkAttributes);
                        if (attributes.count === attributes.chosenCount) {
                            checkVariation(attributes, variations, productID);
                        } else {
                            addToCartButtonFour
                                .attr('data-variationid', '')
                                .prop('disabled', true)
                                .css('opacity', '0.5');

                            tooltip.find("p.variable-sku").text(" ");
                            tooltip.find("span#variable-product-price").html(" ");
                            tooltip.find("#new-meta-data-show-for-variation .new-meta-add-key-value").text("");
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

                    addToCartButtonFour
                        .attr('data-variationid', matchingVariation.variation_id)
                        .prop('disabled', false)
                        .css('opacity', '1');

                    if (variation_id) {


                        const tooltip = jQuery('.quick-variable-tooltip[data-productid="' + productID + '"]').not('.quick-hidden').first();

                        // Get the gallery data and parse it
                        const galleryData = tooltip.data('all-variation-gallery-tooltip');
                        const parsedGallery = typeof galleryData === 'string' ? JSON.parse(galleryData) : galleryData;

                        // Get the specific variation's gallery
                        const variationGallery = parsedGallery[variation_id];

                        // Get price and SKU data
                        const priceSkuData = tooltip.data('all-variation-price-sku-tooltip');
                        const parsedPriceSku = typeof priceSkuData === 'string' ? JSON.parse(priceSkuData) : priceSkuData;
                        const variationPriceSku = parsedPriceSku[variation_id];

                        tooltip.find("p.variable-sku").text(variationPriceSku.sku);
                        tooltip.find("span#variable-product-price").html(variationPriceSku.price);

                        const newMetaData = tooltip.data('all-variation-new-meta-show');
                        if (newMetaData.length !== 0) {
                            const newMeta = typeof newMetaData === 'string' ? JSON.parse(newMetaData) : newMetaData;
                            const newMetaShow = newMeta[variation_id];

                            let newMetaShowHTML = "";

                            Object.entries(newMetaShow).forEach(([key, data]) => {
                                const keyValue = data.keyValue;
                                const label = data.label;
                                newMetaShowHTML += `<div style="display: inline-flex; align-items: center; gap: 5px"><strong class="new-meta-add-label">${label}:</strong> <p class="new-meta-add-key-value"> ${keyValue} </p> </div>`;
                            });

                            document.querySelector("#new-meta-data-show-for-variation").innerHTML = newMetaShowHTML;
                            toolTip.find("div#new-meta-data-show-for-variation").html(newMetaShowHTML);
                        }

                        const $activeImageContainer = tooltip.find(".quick-variable-active-image img");
                        const $dotsContainer = tooltip.find(".quick-variable-dots");

                        // Clear existing dots
                        $dotsContainer.empty();

                        if (variationGallery && variationGallery.length > 0) {
                            // Set the first image as active
                            let currentIndex = 0;
                            $activeImageContainer.attr("src", variationGallery[0]);

                            // Clear existing dots
                            $dotsContainer.empty();

                            // Get or create navigation buttons
                            let $prevBtn = tooltip.find(".quick-gallery-prev");
                            let $nextBtn = tooltip.find(".quick-gallery-next");

                            // Create navigation buttons if they don't exist
                            if ($prevBtn.length === 0) {
                                $prevBtn = jQuery('<button class="quick-gallery-prev" disabled>&#10094;</button>');
                                $nextBtn = jQuery('<button class="quick-gallery-next">&#10095;</button>');
                                $activeImageContainer.before($prevBtn);
                                $activeImageContainer.after($nextBtn);
                            } else {
                                // Reset button states
                                $prevBtn.prop('disabled', true);
                                $nextBtn.prop('disabled', variationGallery.length <= 1);
                            }

                            // Hide buttons if only one image
                            if (variationGallery.length === 1) {
                                $prevBtn.hide();
                                $nextBtn.hide();
                            } else {
                                $prevBtn.show();
                                $nextBtn.show();
                            }

                            // Create dots for each image
                            variationGallery.forEach((image, index) => {
                                const dot = `<div class="quick-variable-dot" data-index="${index}" style="width: 10px; height: 10px; background: ${index === 0 ? '#000' : '#ccc'}; border-radius: 50%; cursor: pointer;"></div>`;
                                $dotsContainer.append(dot);
                            });

                            // Function to update gallery state
                            const updateGallery = (index) => {
                                currentIndex = index;
                                $activeImageContainer.attr("src", variationGallery[index]);

                                // Update dot styles
                                $dotsContainer.find(".quick-variable-dot").css("background", "#ccc");
                                $dotsContainer.find(`.quick-variable-dot[data-index="${index}"]`).css("background", "#000");

                                // Update button states
                                $prevBtn.prop('disabled', index === 0);
                                $nextBtn.prop('disabled', index === variationGallery.length - 1);
                            };

                            // Click event for dots
                            $dotsContainer.off('click', '.quick-variable-dot').on('click', '.quick-variable-dot', function () {
                                const index = jQuery(this).data("index");
                                updateGallery(index);
                            });

                            // Click event for next button (mobile-friendly)
                            $nextBtn.off('click touchstart').on('click touchstart', function (e) {
                                e.preventDefault();
                                if (currentIndex < variationGallery.length - 1) {
                                    updateGallery(currentIndex + 1);
                                }
                            });

                            // Click event for prev button (mobile-friendly)
                            $prevBtn.off('click touchstart').on('click touchstart', function (e) {
                                e.preventDefault();
                                if (currentIndex > 0) {
                                    updateGallery(currentIndex - 1);
                                }
                            });
                        }


                        let addToCartButton = jQuery('.quick-add-to-cart-shop-page-template-four[data-productid="' + productID + '"]');
                        if (addToCartButton.length) {
                            addToCartButton.attr('data-variationid', variation_id);
                        }
                        // Set the flag to indicate that the request is in progress
                        // Remove any existing click handlers first
                        addToCartButton.off('click');

                        // Add new click handler
                        addToCartButton.on('click', function () {
                            if (isRequestInProgress) return;

                            const button = jQuery(this);
                            button.prop('disabled', true);
                            button.find('i').hide();
                            button.find('span').css('visibility', 'hidden');


                            if (!button.hasClass('loading')) {
                                button.append('<i class="fa fa-spinner fa-spin spin-icon-remove"></i>');
                            }

                            var quantity = button.closest('.quick-quantity-container').find(".quick-quantity-input").val();

                            isRequestInProgress = true;

                            jQuery.ajax({
                                type: 'POST',
                                url: quick_front_ajax_obj.ajax_url,
                                data: {
                                    action: 'woocommerce_ajax_add_to_cart',
                                    product_id: productID,
                                    quantity: quantity,
                                    variation_id: variation_id,  // Pass correct variation ID
                                    variation: selectedAttributes,
                                    _wpnonce: quick_front_ajax_obj.nonce,
                                },
                                success: function (response) {
                                    button.find('.spin-icon-remove').remove();
                                    button.find('.updated-check-add-to-cart').remove();
                                    button.append('<span class="updated-check-add-to-cart"><i class="fa fa-check"></i></span>');
                                    jQuery('.shop-page-show-success-message').html(`
                                        <div class="success-message" style="color: ${response.color}">
                                            <p>${response.message}</p>
                                        </div>
                                    `).fadeIn();

                                    // Hide the message after 3 seconds
                                    setTimeout(function () {
                                        button.find('.updated-check-add-to-cart').remove();
                                        jQuery('.shop-page-show-success-message').fadeOut();
                                        button.prop('disabled', false);
                                        button.find('i').show();
                                        button.find('span').css('visibility', 'visible');

                                    }, 1000);

                                    // Update cart totals and item count
                                    jQuery(document.body).trigger('wc_fragment_refresh');
                                    isRequestInProgress = false;
                                },
                                error: function (response) {
                                    button.find('.spin-icon-remove').remove();
                                    jQuery('.shop-page-show-failed-message').html(`
                                        <div class="failed-message" style="color: ${response.color}">
                                            <p>${response.message}</p>
                                        </div>
                                    `).fadeIn();

                                    // Hide the message after 3 seconds
                                    setTimeout(function () {
                                        jQuery('.shop-page-show-failed-message').fadeOut();
                                        button.prop('disabled', false);
                                        button.find('i, span').show();
                                    }, 1000);
                                    isRequestInProgress = false;
                                }
                            })

                        });
                    }
                } else {
                    console.log("No matching variation found.");
                }
            }

            findWhichButtonDisabled()

        });
    }