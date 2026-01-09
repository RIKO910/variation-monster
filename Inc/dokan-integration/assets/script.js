jQuery(document).ready(function (){



    // Meta Section Start

    jQuery(document).ready(function($) {

        // Cart Show Hide.
        function toggleCartSectionTemplate() {
            var selectedCartTemplate = jQuery('#_variation_table_template').val();
            var tableMetaTemplate = jQuery('#_variation_table_meta').val();

            if (selectedCartTemplate === 'template_2' && tableMetaTemplate === 'true') {
                jQuery('._table_template2_cart_section_style_template_field').show();
            } else {
                jQuery('._table_template2_cart_section_style_template_field').hide();
            }
        }

        // Table Show Hide.
        function toggleTableSectionTemplate() {
            var tableMetaTemplate = jQuery('#_variation_table_meta').val();

            if (tableMetaTemplate === 'true') {
                jQuery('._variation_table_template_field').show();
            } else {
                jQuery('._variation_table_template_field').hide();
            }
            toggleCartSectionTemplate();
        }

        // Initial calls to set the correct visibility for cart table
        toggleTableSectionTemplate();
        toggleCartSectionTemplate();

        // Event Listeners for Cart Table
        jQuery('#_variation_table_template, #_variation_table_meta').on('change', function () {
            toggleTableSectionTemplate();
            toggleCartSectionTemplate();
        });

        // List Show Hide.
        function toggleListSectionTemplate() {
            var selectedTemplateList = jQuery('#_variation_list_meta').val();
            if (selectedTemplateList === 'true') {
                jQuery('._variation_list_template_meta_field').show();
            } else {
                jQuery('._variation_list_template_meta_field').hide();
            }
        }
        toggleListSectionTemplate();
        jQuery('#_variation_list_meta').on('change', function() {
            toggleListSectionTemplate();
        });

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
     * Variation  Gallery start.
     */
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

    /**
     * Upload images.
     */
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

    /**
     * Remove image.
     */
    jQuery(document).on("click", ".variation-gallery-remove", function () {
        const button = jQuery(this);
        const imageId = button.data("image-id");
        const container = button.closest(".variation-gallery-item");
        const inputField = button.closest(".form-row").find("input[type=hidden][id^=variation-gallery-input-]");


        // Remove image ID from input value
        let imageIds = inputField.val().split(",").filter(Boolean);
        imageIds = imageIds.filter(id => String(id) !== String(imageId));
        inputField.val(imageIds.join(",")); // Update the input field value

        // Remove the image from the DOM
        container.remove();
    });

});