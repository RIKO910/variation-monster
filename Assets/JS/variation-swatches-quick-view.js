
function variationSwatchesQuickView(){

        let selectedAttributes       = {};
        let firstAttributeSelected  = null;
        let secondAttributeSelected = null;
        let thirdAttributeSelected  = null;

        // Store all preloaded images
        const preloadedImages = {};
        let allImagesPreloaded = false;

        /**
         * Preload all gallery images from the tooltip data
         */
        function preloadAllGalleryImages(tooltip) {
            const termGalleryData = tooltip.data('all-term-gallery-tooltip');
            const variationGalleryData = tooltip.data('all-variation-gallery-tooltip');

            let totalImages = 0;
            let loadedImages = 0;

            // Function to preload a single image
            function preloadImage(src) {
                return new Promise((resolve) => {
                    if (preloadedImages[src]) {
                        resolve();
                        return;
                    }

                    const img = new Image();
                    img.onload = function() {
                        preloadedImages[src] = true;
                        loadedImages++;
                        resolve();
                    };
                    img.onerror = function() {
                        loadedImages++;
                        resolve();
                    };
                    img.src = src;
                });
            }

            // Preload term gallery images
            if (termGalleryData) {
                const parsedTermGallery = typeof termGalleryData === 'string' ? JSON.parse(termGalleryData) : termGalleryData;
                Object.values(parsedTermGallery).forEach(gallery => {
                    if (Array.isArray(gallery)) {
                        gallery.forEach(imageUrl => {
                            totalImages++;
                            preloadImage(imageUrl);
                        });
                    }
                });
            }

            // Preload variation gallery images
            if (variationGalleryData) {
                const parsedVariationGallery = typeof variationGalleryData === 'string' ? JSON.parse(variationGalleryData) : variationGalleryData;
                Object.values(parsedVariationGallery).forEach(gallery => {
                    if (Array.isArray(gallery)) {
                        gallery.forEach(imageUrl => {
                            totalImages++;
                            preloadImage(imageUrl);
                        });
                    }
                });
            }

            // Track when all images are loaded
            if (totalImages > 0) {
                const checkLoading = setInterval(() => {
                    if (loadedImages >= totalImages) {
                        allImagesPreloaded = true;
                        clearInterval(checkLoading);
                        console.log('All quick view gallery images preloaded');
                    }
                }, 100);
            } else {
                allImagesPreloaded = true;
            }
        }

        function resetProductSelections(productID) {
            selectedAttributes = {};
            firstAttributeSelected = null;
            secondAttributeSelected = null;
            thirdAttributeSelected = null;
            jQuery(`[data-product_id="${productID}"]`).removeClass('');
        }

        let toolTip = jQuery(".vmonster-quick-view-modal");

        // Preload images when tooltip is opened
        toolTip.each(function() {
            preloadAllGalleryImages(jQuery(this));
        });

        /**
         * Set default variation when modal opens
         */
        function setDefaultVariation(modal) {
            const defaultVariationId = modal.attr('data-default-variation-id');
            const defaultAttributes = JSON.parse(modal.attr('data-default-attributes') || '{}');

            if (defaultVariationId && defaultVariationId !== '0' && Object.keys(defaultAttributes).length > 0) {
                const $variationsDisplay = modal.find('.variations-display');

                // Loop through each default attribute and trigger click on corresponding button
                Object.keys(defaultAttributes).forEach(attributeKey => {
                    const attributeValue = defaultAttributes[attributeKey];
                    if (attributeValue) {
                        const attributeName = attributeKey;
                        const $button = $variationsDisplay.find(`[data-variation-name="${attributeName}"][data-value="${attributeValue}"]`);

                        if ($button.length) {
                            // Remove selected class from all buttons in this attribute group first
                            $variationsDisplay.find(`[data-variation-name="${attributeName}"]`).removeClass('selected');
                            // Trigger click event
                            $button.trigger('click');
                        }
                    }
                });

                // Update add to cart button
                const addToCartButton = modal.find('.variation-monster-quick-view-cart');
                if (addToCartButton.length && defaultVariationId) {
                    addToCartButton.attr('data-variationid', defaultVariationId);
                    addToCartButton.prop('disabled', false);
                    addToCartButton.css('opacity', '1');
                }
            }
        }

        // Make setDefaultVariation available globally
        window.setDefaultVariation = setDefaultVariation;


        toolTip.find('.variations-display input[type="radio"], .variations-display button').off('click').on('click', function () {
            const $currentProduct = jQuery(this).closest('.variations-display');
            const selectedValue = jQuery(this).attr('data-value');
            let availableVariations = jQuery(this).data('available_variations');
            let attributeName = jQuery(this).data('variation-name');
            const selectedAttribute = jQuery(this).attr('data-variation-name');
            const productID = jQuery(this).attr('data-product_id');
            const addToCartButton = jQuery(`.variation-monster-quick-view-cart[data-productid="${productID}"]`);
            const tooltip = jQuery('.vmonster-quick-view-modal[data-productid="' + productID + '"]').not('.quick-hidden').first();

            // 1. FIRST COMPLETELY CLEAR THE EXISTING GALLERY
            const $galleryContainer = tooltip.find(".vm-quick-variable-gallery-quick-view");

            // 3. GET NEW GALLERY DATA
            const galleryData = tooltip.data('all-term-gallery-tooltip');
            const parsedGallery = typeof galleryData === 'string' ? JSON.parse(galleryData) : galleryData;
            const variationGallery = parsedGallery[selectedValue];

            // Show loading state only if images aren't preloaded
            if (!allImagesPreloaded) {
                $galleryContainer.find(".quick-variable-active-image-quick-view").html(
                    '<div class="gallery-loading" style="height: 300px; display: flex; align-items: center; justify-content: center;">' +
                    '<div class="spinner"></div>' +
                    '</div>'
                );
            }

            // 6. INITIALIZE NEW GALLERY
            if (variationGallery && variationGallery.length > 0) {
                initializeGallery($galleryContainer, variationGallery);
            }


            /**
             * Initialize gallery with preloaded images
             */
            function initializeGallery($galleryContainer, galleryImages) {
                // Remove loading state if it exists
                $galleryContainer.find(".quick-variable-active-image-quick-view").html('');

                // Create fresh image container with preloading check
                const $activeImageContainer = jQuery('<div class="quick-variable-active-image-quick-view"></div>');

                // Use preloaded image if available, otherwise load normally
                const firstImageSrc = galleryImages[0];
                const $activeImage = jQuery(`<img src="${firstImageSrc}" style="max-width: 100%; border-radius: 5px;${!preloadedImages[firstImageSrc] ? 'opacity: 0; transition: opacity 0.3s ease;' : ''}"/>`);

                $activeImageContainer.append($activeImage);

                // Create fresh navigation buttons
                const $prevBtn = jQuery('<button style="outline: none" class="quick-gallery-prev-quick-view" disabled>&#10094;</button>');
                const $nextBtn = jQuery('<button style="outline: none" class="quick-gallery-next-quick-view">&#10095;</button>');

                // Rebuild gallery structure
                $galleryContainer.empty().append(
                    $prevBtn,
                    $activeImageContainer,
                    $nextBtn
                );

                // Initialize gallery navigation
                let currentIndex = 0;

                // Update button states
                $prevBtn.prop('disabled', true);
                $nextBtn.prop('disabled', galleryImages.length <= 1);

                // Hide buttons if only one image
                if (galleryImages.length === 1) {
                    $prevBtn.hide();
                    $nextBtn.hide();
                }

                // Preload all gallery images in the background
                galleryImages.forEach((imageUrl, index) => {
                    if (!preloadedImages[imageUrl]) {
                        const img = new Image();
                        img.onload = function() {
                            preloadedImages[imageUrl] = true;
                            // If this is the first image and it was loading, fade it in
                            if (index === 0) {
                                $activeImage.css('opacity', '1');
                            }
                        };
                        img.src = imageUrl;
                    }
                });

                // Function to update gallery state with smooth transitions
                const updateGallery = (index) => {
                    const newImageSrc = galleryImages[index];
                    const $newImage = jQuery(`<img src="${newImageSrc}" style="max-width: 100%; border-radius: 5px;${!preloadedImages[newImageSrc] ? 'opacity: 0; transition: opacity 0.3s ease;' : ''}"/>`);

                    // If image is preloaded, show it immediately
                    if (preloadedImages[newImageSrc]) {
                        $newImage.css('opacity', '1');
                    } else {
                        // Otherwise, fade it in when loaded
                        const img = new Image();
                        img.onload = function() {
                            preloadedImages[newImageSrc] = true;
                            $newImage.css('opacity', '1');
                        };
                        img.src = newImageSrc;
                    }

                    // Replace the current image with the new one
                    $activeImageContainer.html($newImage);
                    currentIndex = index;

                    // Update button states
                    $prevBtn.prop('disabled', index === 0);
                    $nextBtn.prop('disabled', index === galleryImages.length - 1);
                };

                // Click event handlers with smooth transitions
                $nextBtn.off('click touchstart').on('click touchstart', function(e) {
                    e.preventDefault();
                    if (currentIndex < galleryImages.length - 1) {
                        updateGallery(currentIndex + 1);
                    }
                });

                $prevBtn.off('click touchstart').on('click touchstart', function(e) {
                    e.preventDefault();
                    if (currentIndex > 0) {
                        updateGallery(currentIndex - 1);
                    }
                });

                // Fade in the first image if it was loading
                if (!preloadedImages[firstImageSrc]) {
                    const img = new Image();
                    img.onload = function() {
                        preloadedImages[firstImageSrc] = true;
                        $activeImage.css('opacity', '1');
                    };
                    img.src = firstImageSrc;
                }
            }

            if (!$currentProduct.data('product-initialized')) {
                resetProductSelections(productID);
                $currentProduct.data('product-initialized', true);
            } else {
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
                        var $select                    = jQuery(el);
                        var attributeName   = $select.attr('data-variation-name');
                        var checkAttributes            = jQuery.extend(true, {}, currentAttributes);
                        checkAttributes[attributeName] = '';

                        var variations = findMatchingVariations(availableVariations, checkAttributes);
                        if (attributes.count === attributes.chosenCount){
                            checkVariation(attributes, variations, productID);
                        }else {
                            addToCartButton
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

            function findMatchingVariations(variations, attributes){
                var matching = [];
                for (var i = 0; i < variations.length; i++) {
                    var variation = variations[i];

                    if (isMatch(variation.attributes, attributes)) {
                        matching.push(variation);
                    }
                }
                return matching;
            }

            function isMatch(variation_attributes, attributes){
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

                    addToCartButton
                        .attr('data-variationid', matchingVariation.variation_id)
                        .prop('disabled', false)
                        .css('opacity', '1');

                    if (variation_id) {


                        const tooltip = jQuery('.vmonster-quick-view-modal[data-productid="' + productID + '"]').not('.quick-hidden').first();

                        // 1. FIRST COMPLETELY CLEAR THE EXISTING GALLERY
                        const $galleryContainer = tooltip.find(".vm-quick-variable-gallery-quick-view");
                        $galleryContainer.find(".quick-variable-active-image-quick-view").html('');
                        $galleryContainer.find(".quick-variable-thumbnails-quick-view").html('');
                        $galleryContainer.find(".quick-gallery-prev-quick-view, .quick-gallery-next-quick-view").remove();

                        // 2. ADD LOADING STATE
                        $galleryContainer.find(".quick-variable-active-image-quick-view").html(
                            '<div class="gallery-loading" style="height: 300px; display: flex; align-items: center; justify-content: center;">' +
                            '<div class="spinner"></div>' +
                            '</div>'
                        );

                        // 3. GET NEW GALLERY DATA
                        const galleryData = tooltip.data('all-variation-gallery-tooltip');
                        const parsedGallery = typeof galleryData === 'string' ? JSON.parse(galleryData) : galleryData;
                        const variationGallery = parsedGallery[variation_id];

                        // 4. GET PRICE/SKU DATA
                        const priceSkuData = tooltip.data('all-variation-price-sku-tooltip');
                        const parsedPriceSku = typeof priceSkuData === 'string' ? JSON.parse(priceSkuData) : priceSkuData;
                        const variationPriceSku = parsedPriceSku[variation_id];

                        // 5. UPDATE PRICE/SKU
                        tooltip.find("p.variable-sku").text(variationPriceSku.sku);
                        tooltip.find("span#variable-product-price").html(variationPriceSku.price);

                        // 6. Update New Meta Data

                        const newMetaData = tooltip.data('all-variation-new-meta-show');
                        const newMeta = typeof newMetaData === 'string' ? JSON.parse(newMetaData) : newMetaData;
                        const newMetaShow = newMeta[variation_id];

                        console.log('newMetaShow', newMetaShow)

                        let newMetaShowHTML = "";

                        if (Array.isArray(newMetaShow)) {
                            newMetaShow.forEach((data) => {
                                const keyValue = data.keyValue ?? '';
                                const label    = data.label ?? '';
                                newMetaShowHTML += `<div style="display: inline-flex; gap: 5px"><strong style="margin: 0;padding: 0; line-height: 25px;" class="new-meta-add-label">${label}:</strong> <p style="margin: 0;padding: 0; line-height: 25px;" class="new-meta-add-key-value">${keyValue}</p></div>`;
                            });
                        }

                        tooltip.find("#new-meta-data-show-for-variation").html(newMetaShowHTML);

                        // 6. INITIALIZE NEW GALLERY
                        if (variationGallery && variationGallery.length > 0) {
                            initializeGallery($galleryContainer, variationGallery);
                        } else {
                            // Handle case with no gallery images
                            $galleryContainer.find(".quick-variable-active-image-quick-view").html(
                                '<img src="" alt="Placeholder" style="max-width: 100%; border-radius: 5px;"/>'
                            );
                        }



                        let addToCartButton = jQuery('.quick-add-to-cart-shop-page-template-four[data-productid="' + productID + '"]');
                        if (addToCartButton.length) {
                            addToCartButton.attr('data-variationid', variation_id);
                        }
                        // Set the flag to indicate that the request is in progress
                        // Remove any existing click handlers first
                        addToCartButton.off('click');

                        // Add new click handler
                        addToCartButton.on('click', function() {
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
                                success:function (response){
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
                                    jQuery( document.body).trigger('wc_fragment_refresh');
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

            findWhichButtonDisabled ()

        });
    }

function variationMonsterQuickViewButton(qvButton) {
    var modalId = jQuery(qvButton).attr("data-modal");
    var modal = jQuery("#" + modalId);
    if (modal.length) {
        modal.css("display", "block");
        vmQuickVariableGalleryQuickView(modal);
        variationSwatchesQuickView();

        // Set default variation after a small delay to ensure DOM is ready
        setTimeout(() => {
            if (typeof setDefaultVariation === 'function') {
                setDefaultVariation(modal);
            }
        }, 100);
    }
}

function quickViewModalClose(qvCloseBtn){
    var modal = jQuery(qvCloseBtn).closest(".vmonster-quick-view-modal");
    if (modal.length) {
        modal.css("display", "none");
    }
}


function vmQuickVariableGalleryQuickView(modal){
    const gallery = jQuery(modal).find('.vm-quick-variable-gallery-quick-view');
    const prevBtn = gallery.find('.quick-gallery-prev-quick-view');
    const nextBtn = gallery.find('.quick-gallery-next-quick-view');
    const activeImage = gallery.find('.quick-variable-active-image-quick-view img');
    const thumbnails = gallery.find('.quick-variable-thumbnail-quick-view img');

    if (thumbnails.length > 0) {
        let currentIndex = 0;

        // Set first image as active
        updateActiveImage(currentIndex);
        updateButtons();

        // Next button click
        nextBtn.on('click', function () {
            currentIndex = (currentIndex + 1) % thumbnails.length;
            updateActiveImage(currentIndex);
            updateButtons();
        });

        // Previous button click
        prevBtn.on('click', function () {
            currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
            updateActiveImage(currentIndex);
            updateButtons();
        });

        function updateActiveImage(index) {
            const imgSrc = thumbnails.eq(index).attr('data-full-src');
            const imgAlt = thumbnails.eq(index).attr('alt');
            activeImage.attr('src', imgSrc);
            activeImage.attr('alt', imgAlt);
        }

        function updateButtons() {
            prevBtn.prop('disabled', currentIndex === 0);
            nextBtn.prop('disabled', currentIndex === thumbnails.length - 1);
        }
    } else {
        // If no thumbnails, disable both buttons
        prevBtn.prop('disabled', true);
        nextBtn.prop('disabled', true);
    }
}


jQuery(document).ready(function () {

    jQuery(window).on("click", function (event) {
        if(!jQuery(event.target).hasClass('variation-monster-quick-view')){
            const quickViewModal = document.querySelector('.vmonster-quick-view-modal');

            // Check if the click is outside the modal and the modal exists
            if (quickViewModal && !quickViewModal.contains(event.target)) {
                quickViewModal.style.display = 'none';
            }
        }
    });

    variationSwatchesQuickView();
});