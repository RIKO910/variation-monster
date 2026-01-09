jQuery(document).ready(function ($) {


    // Variation  Gallery start
    function initializeSortable() {
        jQuery(".variation-gallery-container").each(function () {
            const container = jQuery(this);

            container.sortable({
                items: ".variation-gallery-item",
                cursor: "move",
                placeholder: "sortable-placeholder",
                forcePlaceholderSize: true,
                tolerance: "pointer",
                stop: function (event, ui) {
                    const variationId = container.attr("id").split("-").pop();
                    const inputField = jQuery(`#variation-gallery-input-${variationId}`);

                    const updatedOrder = container.find(".variation-gallery-item").map(function () {
                        return jQuery(this).data("image-id");
                    }).get();

                    inputField.val(updatedOrder.join(","));
                },
            });
        });
    }

    // Use a delay to ensure dynamic content is loaded
    setTimeout(initializeSortable, 500);

    // Alternatively, listen for changes in the DOM
    const observer = new MutationObserver((mutationsList, observer) => {
        initializeSortable(); // Re-initialize sortable on DOM changes
    });
    observer.observe(document.body, { childList: true, subtree: true });


    // Upload images
    jQuery(document).on("click", ".upload-variation-gallery-image", function (e) {
        e.preventDefault();

        const button = jQuery(this);
        const variationId = button.data("variation-id");
        const inputField = jQuery(`#variation-gallery-input-${variationId}`);
        const galleryContainer = jQuery(`#gallery-container-${variationId}`);

        const mediaUploader = wp.media({
            title: "Select Images",
            button: { text: "Add to Gallery" },
            multiple: true,
        }).on("select", function () {
            const attachments = mediaUploader.state().get("selection").toJSON();
            let imageIds = inputField.val().split(",").filter(Boolean); // Get current image IDs

            attachments.forEach(attachment => {
                if (!imageIds.includes(String(attachment.id))) {
                    imageIds.push(attachment.id); // Add new ID
                    galleryContainer.append(`
                    <li class="variation-gallery-item" data-image-id="${attachment.id}">
                        <img src="${attachment.url}" alt="" width="60" height="60">
                        <button type="button" class="variation-gallery-remove" data-image-id="${attachment.id}">&times;</button>
                    </li>
                `);
                }
            });

            inputField.val(imageIds.join(",")); // Update the input field
        });

        mediaUploader.open();
    });


    // Remove image
    jQuery(document).on("click", ".variation-gallery-remove", function () {
        const button = jQuery(this);
        const imageId = button.data("image-id");
        const container = button.closest(".variation-gallery-item");
        const inputField = button.closest(".form-row").find("input[type=hidden][id^=variation-gallery-input-]");


        // Remove image ID from input value
        let imageIds = inputField.val().split(",").filter(Boolean); // Ensure array
        imageIds = imageIds.filter(id => String(id) !== String(imageId)); // Remove the selected ID
        inputField.val(imageIds.join(",")); // Update the input field value

        // Remove the image from the DOM
        container.remove();
    });


    // Variation  Gallery End

    // Attribute Section Start

    jQuery(document).ready(function ($) {

        var previewDiv = jQuery('#term_image_preview_render_from_js');
        var imageUrl = previewDiv.data('image-url');

        if (imageUrl){
            previewDiv.html('<img id="term_image_preview" src="' + imageUrl + '" alt="Selected Image" style="max-width: 70px; height: auto; display: block; margin-bottom: 10px; border: 1px solid lightgrey; border-radius: 5px">');
        }

        // Remove Image
        jQuery(document).on('click', '#upload_image_button_remove', function (e) {
            e.preventDefault();

            // Clear the hidden input value
            jQuery('#term_image').val('');

            // Hide the preview image
            jQuery('#term_image_preview').attr('src', '').hide();
        });

        // Upload Image
        jQuery('#upload_image_button').on('click', function (e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open()
                .on('select', function () {
                    var uploaded_image = image.state().get('selection').first().toJSON();
                    var image_url = uploaded_image.url;

                    // Update the hidden input value
                    jQuery('#term_image').val(image_url);

                    // Update or show the preview image
                    var previewDiv = jQuery('#term_image_preview_render_from_js');
                    previewDiv.html('<img id="term_image_preview" src="' + image_url + '" alt="Selected Image" style="max-width: 70px; height: auto; display: block; margin-bottom: 10px; border: 1px solid lightgrey; border-radius: 5px">');
                });
        });
    });



    jQuery(document).ready(function ($) {
        jQuery('#upload_image_button_add_new').on('click', function (e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open()
                .on('select', function () {
                    var uploaded_image = image.state().get('selection').first().toJSON();
                    var image_url = uploaded_image.url;

                    // Set the image URL to the hidden input field
                    jQuery('#term_image_add_new').val(image_url);

                    // Update or show the preview image
                    var previewDiv = jQuery('#term_image_preview_add_new_render_from_js');
                    previewDiv.html('<img src="' + image_url + '" alt="Selected Image" style="max-width: 70px; height: auto; border: 1px solid lightgrey; border-radius: 5px;">');
                });
        });
    });


    // Attribute Section End

    // Meta Section Start

    jQuery(document).ready(function($) {


        // redirect single product page, Show in archive show hide

        function toggleRedirectSingleProductPage() {
            var selectedTemplateList = jQuery('#_variation_swatches_archive_page_meta').val();
            if (selectedTemplateList === 'attribute-archive') {
                jQuery('.show-in-archive-page-attribute-select-option').css('visibility', 'visible');
            } else {
                jQuery('.show-in-archive-page-attribute-select-option').css('visibility', 'hidden');
            }
        }
        toggleRedirectSingleProductPage();
        jQuery('#_variation_swatches_archive_page_meta').on('change', function() {
            toggleRedirectSingleProductPage();
        });

    });


    jQuery(document).ready(function ($) {

        jQuery('.attribute-settings').hide();

        jQuery('.attribute-toggle-btn').on('click', function (event) {
            event.stopPropagation(); // Prevents the full row from toggling

            const rowId = jQuery(this).data('row-id');
            const targetRow = jQuery('#attribute-settings-' + rowId);
            const icon = jQuery(this).find('.dashicons');

            jQuery('.attribute-settings').not(targetRow).slideUp();
            jQuery('.attribute-toggle-btn .dashicons').removeClass('dashicons-arrow-up').addClass('dashicons-arrow-down');

            if (targetRow.is(':visible')) {
                targetRow.slideUp();
                icon.removeClass('dashicons-arrow-up').addClass('dashicons-arrow-down');
            } else {
                targetRow.slideDown();
                icon.removeClass('dashicons-arrow-down').addClass('dashicons-arrow-up');
            }
        });

        // Toggle visibility of meta sections based on display type
        // jQuery('select[name^="attribute_display_type"]').on('change', function () {
        //     const selectedValue = jQuery(this).val();
        //     const parentRow = jQuery(this).closest('tr');
        //     const colorMeta = parentRow.find('.color-meta');
        //     const imageMeta = parentRow.find('.image-meta');
        //
        //     if (selectedValue === 'color') {
        //         colorMeta.show();
        //         imageMeta.hide();
        //     } else if (selectedValue === 'image') {
        //         imageMeta.show();
        //         colorMeta.hide();
        //     } else {
        //         colorMeta.hide();
        //         imageMeta.hide();
        //     }
        // }).trigger('change');

        // Image Upload
        jQuery(document).on('click', '.meta_upload_image_button', function (e) {
            e.preventDefault();

            // Get the parent row for this button
            const parentRow = jQuery(this).closest('tr');
            const inputField = parentRow.find('.meta_term_image');
            const previewImage = parentRow.find('.meta_term_image_preview');

            // Open the WordPress media uploader
            var image = wp.media({
                title: 'Upload Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            }).open().on('select', function () {
                var uploaded_image = image.state().get('selection').first().toJSON();
                var image_url = uploaded_image.url;

                // Update the hidden input value and preview image
                inputField.val(image_url);
                previewImage.attr('src', image_url).show();
            });
        });


        // Remove Image
        jQuery(document).on('click', '.meta_image_button_remove', function (e) {
            e.preventDefault();

            // Get the parent row for this button
            const parentRow = jQuery(this).closest('tr');
            const inputField = parentRow.find('.meta_term_image');
            const previewImage = parentRow.find('.meta_term_image_preview');

            // Clear the hidden input value and hide the preview image
            inputField.val('');
            previewImage.attr('src', '').hide();
        });

        /**
         * Image Upload Term Meta for Tooltip.
         */
        jQuery(document).on('click', '.tooltip_meta_upload_image_button', function (e) {
            e.preventDefault();

            const parentRow = jQuery(this).closest('tr');
            const inputField = parentRow.find('.tooltip_meta_term_image');
            const previewImage = parentRow.find('.tooltip_meta_term_image_preview');

            var image = wp.media({
                title: 'Upload Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            }).open().on('select', function () {
                var uploaded_image = image.state().get('selection').first().toJSON();
                var image_url = uploaded_image.url;

                // Update the hidden input value and preview image
                inputField.val(image_url);
                previewImage.attr('src', image_url).show();
            });
        });

        /**
         * Remove Image Term Meta for Tooltip.
         */
        jQuery(document).on('click', '.tooltip_meta_image_button_remove', function (e) {
            e.preventDefault();

            const parentRow = jQuery(this).closest('tr');
            const inputField = parentRow.find('.tooltip_meta_term_image');
            const previewImage = parentRow.find('.tooltip_meta_term_image_preview');

            inputField.val('');
            previewImage.attr('src', '').hide();
        });
    });

    /**
     * Display Type change color or image that time show color or image section based on attribute.
     */
    jQuery(document).ready(function($) {
        function handleDisplayTypeChange() {
            var $select = jQuery(this);
            var attributeSlug = $select.data('rowslug-displaytype');
            var selectedValue = $select.val();

            jQuery('.display-typeShow-color-' + attributeSlug).hide();
            jQuery('.display-typeShow-image-' + attributeSlug).hide();

            if (selectedValue === 'color') {
                jQuery('.display-typeShow-color-' + attributeSlug).show();
            } else if (selectedValue === 'image') {
                jQuery('.display-typeShow-image-' + attributeSlug).show();
            }
        }

        jQuery('select[name^="attribute_display_type"]').each(function() {
            handleDisplayTypeChange.call(this);

            jQuery(this).on('change', handleDisplayTypeChange);
        });
    });

    // Meta Section End

    /**
     * Color Picker show.
     */
    jQuery(document).ready(function ($) {
        if (jQuery('.wvs-color-picker').length) {
            jQuery('.wvs-color-picker').wpColorPicker();
        } else {

        }
    });

    /**
     * Variation monster image into dashboard.
     */
    jQuery(document).ready(function ($) {
        const imageUrl = jQuery('#variation-monster-admin-dashboard-image').data('image-url-variaion-monter');

        if (imageUrl) {
            const imgElement = jQuery('<img>', {
                src: imageUrl,
                alt: 'Variation Monster',
                css: {
                    width: '100%'
                }
            });

            jQuery('#variation-monster-admin-dashboard-image').append(imgElement);
        }
    });

    /**
     * Variation monster notice variation.
     */
    jQuery(document).ready(function ($) {
        // Handle the dismiss button click for your specific notice
        jQuery(document).on('click', '.vmonster-update-version-notice .notice-dismiss', function () {
            // Send an AJAX request to update the option
            jQuery.ajax({
                url: quick_ajax_obj.ajax_url, // WordPress AJAX URL
                type: 'POST',
                data: {
                    action: 'vmonster_version_dismiss_notice',
                },
                success: function (response) {
                    console.log('Notice dismissed');
                }
            });
        });
    });



    jQuery(document).ready(function($) {
        // Initialize select2 for the meta key selector
        jQuery('#meta-key-selector').select2({
            placeholder: 'Select meta keys to add...',
            allowClear: true
        });

        jQuery('#meta-fields-container').sortable({
            handle: '.meta-add-drag-handle', // Optional: grab to drag by label
            update: function(event, ui) {
                // Optionally update field name indexes if needed
                reorderMetaIndexes();
            }
        });

        function reorderMetaIndexes() {
            jQuery('#meta-fields-container .new-meta-data-add-for-every-variation').each(function(index) {
                jQuery(this).find('input.new-meta-data-label').attr('name', `newMetaDataForVariations[${index}][key]`);
                jQuery(this).find('input.new-meta-data-value').attr('name', `newMetaDataForVariations[${index}][value]`);
            });
        }

        // When selection changes, add new fields
        jQuery('#meta-key-selector').on('change', function() {
            var selectedKeys = jQuery(this).val();

            // First, remove any fields for keys that are no longer selected
            jQuery('.new-meta-data-add-for-every-variation').each(function() {
                var key = jQuery(this).data('key');
                if ($.inArray(key, selectedKeys) === -1) {
                    jQuery(this).remove();
                }
            });

            // Then add new fields for newly selected keys
            if (selectedKeys) {
                selectedKeys.forEach(function(key) {
                    if (jQuery('.new-meta-data-add-for-every-variation[data-key="' + key + '"]').length === 0) {
                        var index = Date.now(); // Unique index
                        var newField = `
                        <div class="new-meta-data-add-for-every-variation" data-key="${key}">
                            <div class="meta-add-drag-handle" title="Drag to reorder">≡</div>
                            <div class="new-meta-data-label">
                                <input type="text" class="new-meta-data-label" 
                                       name="newMetaDataForVariations[${index}][key]" 
                                       value="${key}" readonly>
                            </div>
                            <div class="new-meta-data-value">
                                <input type="text" class="new-meta-data-value" placeholder="Label"
                                       name="newMetaDataForVariations[${index}][value]" 
                                       value="">
                            </div>
                            <div class="cross-icon-for-new-meta-data" onclick="removeMetaField(this)">×</div>
                        </div>
                    `;
                        jQuery('#meta-fields-container').append(newField);
                    }
                });
            }
        });
    });


    jQuery(document).ready(function($) {
        // Initialize select2 for the meta key selector
        jQuery('#meta-key-selector-table').select2({
            placeholder: 'Select meta keys to add...',
            allowClear: true
        });

        jQuery('#meta-fields-container-table').sortable({
            handle: '.meta-add-drag-handle-table', // Optional: grab to drag by label
            update: function(event, ui) {
                // Optionally update field name indexes if needed
                reorderMetaIndexes();
            }
        });

        function reorderMetaIndexes() {
            jQuery('#meta-fields-container-table .new-meta-data-add-for-every-variation-table').each(function(index) {
                jQuery(this).find('input.new-meta-data-label-table').attr('name', `newMetaDataForVariationsTable[${index}][key]`);
                jQuery(this).find('input.new-meta-data-value-table').attr('name', `newMetaDataForVariationsTable[${index}][value]`);
            });
        }

        // When selection changes, add new fields
        jQuery('#meta-key-selector-table').on('change', function() {
            var selectedKeys = jQuery(this).val();

            // First, remove any fields for keys that are no longer selected
            jQuery('.new-meta-data-add-for-every-variation-table').each(function() {
                var key = jQuery(this).data('key');
                if ($.inArray(key, selectedKeys) === -1) {
                    jQuery(this).remove();
                }
            });

            // Then add new fields for newly selected keys
            if (selectedKeys) {
                selectedKeys.forEach(function(key) {
                    if (jQuery('.new-meta-data-add-for-every-variation-table[data-key="' + key + '"]').length === 0) {
                        var index = Date.now(); // Unique index
                        var newField = `
                        <div class="new-meta-data-add-for-every-variation-table" data-key="${key}">
                            <div class="meta-add-drag-handle-table" title="Drag to reorder">≡</div>
                            <div class="new-meta-data-label-table">
                                <input type="text" class="new-meta-data-label-table" 
                                       name="newMetaDataForVariationsTable[${index}][key]" 
                                       value="${key}" readonly>
                            </div>
                            <div class="new-meta-data-value-table">
                                <input type="text" class="new-meta-data-value-table" placeholder="Label"
                                       name="newMetaDataForVariationsTable[${index}][value]" 
                                       value="">
                            </div>
                            <div class="cross-icon-for-new-meta-data-table" onclick="removeMetaFieldTable(this)">×</div>
                        </div>
                    `;
                        jQuery('#meta-fields-container-table').append(newField);
                    }
                });
            }
        });
    });


    jQuery(document).ready(function($) {
        // Initialize select2 for the meta key selector
        jQuery('#meta-key-selector-table-overwrite').select2({
            placeholder: 'Select meta keys to add...',
            allowClear: true
        });

        jQuery('#meta-fields-container-table-overwrite').sortable({
            handle: '.meta-add-drag-handle-table-overwrite', // Optional: grab to drag by label
            update: function(event, ui) {
                // Optionally update field name indexes if needed
                reorderMetaIndexes();
            }
        });

        function reorderMetaIndexes() {
            jQuery('#meta-fields-container-table-overwrite .new-meta-data-add-for-every-variation-table-overwrite').each(function(index) {
                jQuery(this).find('input.new-meta-data-label-table-overwrite').attr('name', `newMetaDataForVariationsTableOverwrite[${index}][key]`);
                jQuery(this).find('input.new-meta-data-value-table-overwrite').attr('name', `newMetaDataForVariationsTableOverwrite[${index}][value]`);
            });
        }

        // When selection changes, add new fields
        jQuery('#meta-key-selector-table-overwrite').on('change', function() {
            var selectedKeys = jQuery(this).val();

            // First, remove any fields for keys that are no longer selected
            jQuery('.new-meta-data-add-for-every-variation-table-overwrite').each(function() {
                var key = jQuery(this).data('key');
                if ($.inArray(key, selectedKeys) === -1) {
                    jQuery(this).remove();
                }
            });

            // Then add new fields for newly selected keys
            if (selectedKeys) {
                selectedKeys.forEach(function(key) {
                    if (jQuery('.new-meta-data-add-for-every-variation-table-overwrite[data-key="' + key + '"]').length === 0) {
                        var index = Date.now(); // Unique index
                        var newField = `
                        <div class="new-meta-data-add-for-every-variation-table-overwrite" data-key="${key}">
                            <div class="meta-add-drag-handle-table-overwrite" title="Drag to reorder">≡</div>
                            <div class="new-meta-data-label-table-overwrite">
                                <input type="text" class="new-meta-data-label-table-overwrite" 
                                       name="newMetaDataForVariationsTableOverwrite[${index}][key]" 
                                       value="${key}" readonly>
                            </div>
                            <div class="new-meta-data-value-table-overwrite">
                                <input type="text" class="new-meta-data-value-table-overwrite" placeholder="Label"
                                       name="newMetaDataForVariationsTableOverwrite[${index}][value]" 
                                       value="">
                            </div>
                            <div class="cross-icon-for-new-meta-data-table-overwrite" onclick="removeMetaFieldTableOverwrite(this)">×</div>
                        </div>
                    `;
                        jQuery('#meta-fields-container-table-overwrite').append(newField);
                    }
                });
            }
        });
    });


    jQuery(document).ready(function($) {
        // Initialize select2 for the meta key selector
        jQuery('#meta-key-selector-list').select2({
            placeholder: 'Select meta keys to add...',
            allowClear: true
        });

        jQuery('#meta-fields-container-list').sortable({
            handle: '.meta-add-drag-handle-list', // Optional: grab to drag by label
            update: function(event, ui) {
                // Optionally update field name indexes if needed
                reorderMetaIndexes();
            }
        });

        function reorderMetaIndexes() {
            jQuery('#meta-fields-container-list .new-meta-data-add-for-every-variation-list').each(function(index) {
                jQuery(this).find('input.new-meta-data-label-list').attr('name', `newMetaDataForVariationsList[${index}][key]`);
                jQuery(this).find('input.new-meta-data-value-list').attr('name', `newMetaDataForVariationsList[${index}][value]`);
            });
        }

        // When selection changes, add new fields
        jQuery('#meta-key-selector-list').on('change', function() {
            var selectedKeys = jQuery(this).val();

            // First, remove any fields for keys that are no longer selected
            jQuery('.new-meta-data-add-for-every-variation-list').each(function() {
                var key = jQuery(this).data('key');
                if ($.inArray(key, selectedKeys) === -1) {
                    jQuery(this).remove();
                }
            });

            // Then add new fields for newly selected keys
            if (selectedKeys) {
                selectedKeys.forEach(function(key) {
                    if (jQuery('.new-meta-data-add-for-every-variation-list[data-key="' + key + '"]').length === 0) {
                        var index = Date.now(); // Unique index
                        var newField = `
                        <div class="new-meta-data-add-for-every-variation-list" data-key="${key}">
                            <div class="meta-add-drag-handle-list" title="Drag to reorder">≡</div>
                            <div class="new-meta-data-label-list">
                                <input type="text" class="new-meta-data-label-list" 
                                       name="newMetaDataForVariationsList[${index}][key]" 
                                       value="${key}" readonly>
                            </div>
                            <div class="new-meta-data-value-list">
                                <input type="text" class="new-meta-data-value-list" placeholder="Label"
                                       name="newMetaDataForVariationsList[${index}][value]" 
                                       value="">
                            </div>
                            <div class="cross-icon-for-new-meta-data-list" onclick="removeMetaFieldTable(this)">×</div>
                        </div>
                    `;
                        jQuery('#meta-fields-container-list').append(newField);
                    }
                });
            }
        });
    });

    jQuery('#quick-cart-carousel-template').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#carousel-image-size').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#carousel-gallery-image-size').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#overwrite-default-cart-table-template').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#pop-up-image-show').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#attribute-image-show').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#display-position-swatches-archive-page').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#disable-attribute-style').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#selected-icon-template').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#list-image-show').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#gallery-image-show').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('#attribute-gallery-image-show').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('.quick-table-position').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('.bulk-add-to-cart-position').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

    jQuery('.quick-carousel-position').select2({
        minimumResultsForSearch: 10,
        placeholder: 'Select a template',
        width: '300px',
        allowClear: false
    });

});

function removeMetaField(element) {
    var container = jQuery(element).closest('.new-meta-data-add-for-every-variation');
    var key = container.data('key');

    // Remove from select2 selection
    var selector = jQuery('#meta-key-selector');
    var selected = selector.val();
    if (selected) {
        var index = selected.indexOf(key);
        if (index !== -1) {
            selected.splice(index, 1);
            selector.val(selected).trigger('change');
        }
    }

    // Remove the field
    container.remove();
}


function removeMetaFieldTable(element) {
    var container = jQuery(element).closest('.new-meta-data-add-for-every-variation-table');
    var key = container.data('key');

    // Remove from select2 selection
    var selector = jQuery('#meta-key-selector-table');
    var selected = selector.val();
    if (selected) {
        var index = selected.indexOf(key);
        if (index !== -1) {
            selected.splice(index, 1);
            selector.val(selected).trigger('change');
        }
    }

    // Remove the field
    container.remove();
}


function removeMetaFieldList(element) {
    var container = jQuery(element).closest('.new-meta-data-add-for-every-variation-list');
    var key = container.data('key');

    // Remove from select2 selection
    var selector = jQuery('#meta-key-selector-list');
    var selected = selector.val();
    if (selected) {
        var index = selected.indexOf(key);
        if (index !== -1) {
            selected.splice(index, 1);
            selector.val(selected).trigger('change');
        }
    }

    // Remove the field
    container.remove();
}

function removeMetaFieldTableOverwrite(element) {
    var container = jQuery(element).closest('.new-meta-data-add-for-every-variation-table-overwrite');
    var key = container.data('key');

    // Remove from select2 selection
    var selector = jQuery('#meta-key-selector-table-overwrite');
    var selected = selector.val();
    if (selected) {
        var index = selected.indexOf(key);
        if (index !== -1) {
            selected.splice(index, 1);
            selector.val(selected).trigger('change');
        }
    }

    // Remove the field
    container.remove();
}