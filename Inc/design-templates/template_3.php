<?php
if (!defined('ABSPATH')) exit;

global $product;
$varimo_enable_global_stock_management = $product->get_manage_stock();
$varimo_global_stock_quantity          = $varimo_enable_global_stock_management ? $product->get_stock_quantity() : null;
$varimo_all_attributes                 = $product->get_attributes();
$varimoVariableSetting                = get_option('variable_all_checked', array());
$varimoQuickTableOnOff                = isset($varimoVariableSetting['quickTableOnOff']) ? $varimoVariableSetting['quickTableOnOff'] : '';
$varimoBulkSelectionHideShow          = isset($varimoVariableSetting['bulkSelectionHideShow']) ? $varimoVariableSetting['bulkSelectionHideShow'] : 'true';
$varimoImageHideShow                  = isset($varimoVariableSetting['imageHideShow']) ? $varimoVariableSetting['imageHideShow'] : 'true';
$varimoSkuHideShow                    = isset($varimoVariableSetting['skuHideShow']) ? $varimoVariableSetting['skuHideShow'] : 'true';
$varimoAllAttributeHideShow           = isset($varimoVariableSetting['allAttributeHideShow']) ? $varimoVariableSetting['allAttributeHideShow'] : 'true';
$varimoPriceHideShow                  = isset($varimoVariableSetting['priceHideShow']) ? $varimoVariableSetting['priceHideShow'] : 'true';
$varimoQuantityHideShow               = isset($varimoVariableSetting['quantityHideShow']) ? $varimoVariableSetting['quantityHideShow'] : 'true';
$varimoActionHideShow                 = isset($varimoVariableSetting['actionHideShow']) ? $varimoVariableSetting['actionHideShow'] : 'true';
$varimoOnSaleHideShow                 = isset($varimoVariableSetting['onSaleHideShow']) ? $varimoVariableSetting['onSaleHideShow'] : 'true';
$varimoSearchOptionHideShow           = isset($varimoVariableSetting['searchOptionHideShow']) ? $varimoVariableSetting['searchOptionHideShow'] : 'true';
$varimoBulkAddToCartPosition          = isset($varimoVariableSetting['bulkAddToCartPosition']) ? $varimoVariableSetting['bulkAddToCartPosition'] : 'after';
$varimoDesignSingleProductPageMobile  = isset($varimoVariableSetting['designSingleProductPageMobile']) ? $varimoVariableSetting['designSingleProductPageMobile'] : 'template_1';
$varimoCartButtonText                 = isset($varimoVariableSetting['cartButtonText']) ? $varimoVariableSetting['cartButtonText'] : 'Add-to-cart';
$varimoOnSaleNameChange               = isset($varimoVariableSetting['onSaleNameChange']) ? $varimoVariableSetting['onSaleNameChange'] : 'On Sale';
$varimoSearchOptionTextChange         = isset($varimoVariableSetting['searchOptionTextChange']) ? $varimoVariableSetting['searchOptionTextChange'] : 'Search...';
$varimoShowPopUpImage                 = isset($varimoVariableSetting['showPopUpImage']) ? $varimoVariableSetting['showPopUpImage'] : 'true';
$varimoVariationGalleryOnOff          = isset($varimoVariableSetting['variationGalleryOnOff']) ? $varimoVariableSetting['variationGalleryOnOff'] : '';
$varimoPopUPImageShow                 = isset($varimoVariableSetting['popUPImageShow']) ? $varimoVariableSetting['popUPImageShow'] : 'default';

?>

<div class="table-scroll-container" style="overflow-x: auto; width: 100%;">
    <div class="table-before" style="display: inline-flex; gap: 30px; align-items: baseline; margin-left: 5px">

        <?php if ($varimoOnSaleHideShow === "true"){
            ?>
            <div style="display: inline-flex; align-items: baseline; gap: 10px">
                <input style="outline: none" id="stock_status" type="checkbox"  name="" >
                <p for="stock_status" ><?php echo esc_html($varimoOnSaleNameChange); ?></p>
            </div>
            <?php
        }?>

        <?php if ($varimoSearchOptionHideShow === "true"){
            ?>
            <div class="search_option">
                <input style="outline: none" class="variation-table-search" type="text" placeholder="<?php echo esc_html($varimoSearchOptionTextChange); ?>" name="search" id="variation-search">
            </div>
            <?php
        }?>
    </div>

    <?php if ($varimoBulkAddToCartPosition === "before"  || $varimoBulkAddToCartPosition === "both"){
        ?>
        <button class="bulk-add-to-cart"  id="bulk-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>"  style="background-color: #007CBA; color: white; border-radius: 5px ; margin-bottom: 10px; outline: none">
            <i class="fa fa-cart-plus" aria-hidden="true"></i>
            <span><?php echo esc_html($varimoCartButtonText); ?></span>
            <span  class="bulk-add-to-cart-success-icon"> </span>
        </button>
        <?php
    }?>

    <table id="quick-variable-table" class="mobile-table" style="min-width: 100%; table-layout: auto;">
        <tr>
            <?php if ($varimoBulkSelectionHideShow === "true"){
                ?>
                <th><input id="bulk_checkbox_select_all" type="checkbox"  name="" style="outline: none" ></th>
                <?php
            }?>

            <?php if ($varimoImageHideShow === "true"){
                ?>
                <th><?php esc_html_e('Image', 'variation-monster-pro'); ?></th>
                <?php
            }?>


            <?php if ($varimoSkuHideShow === "true"){
                ?>

                <th>
                    <span>
                        <?php esc_html_e('SKU', 'variation-monster-pro'); ?>
                    </span>
                    <span style=" float: right" id="sku-sort-arrows">
                        <span class="dashicons dashicons-arrow-up-alt" id="sort-asc"></span>
                    </span>
                </th>

                <?php
            }?>

            <?php if ($varimoAllAttributeHideShow === "true"){
                foreach ($varimo_all_attributes as $varimo_attribute_name => $varimo_attribute) {
                    // Reflection to access the attribute's private data
                    $varimo_reflection   = new ReflectionClass($varimo_attribute);
                    $varimo_dataProperty = $varimo_reflection->getProperty("data");
                    $varimo_dataProperty->setAccessible(true);
                    $varimo_data = $varimo_dataProperty->getValue($varimo_attribute);

                    // Only display attribute columns that are variations
                    if (taxonomy_exists($varimo_attribute_name) && isset($varimo_data["variation"]) && $varimo_data["variation"]) {
                        $taxonomy = get_taxonomy($varimo_attribute_name);
                        $varimo_label = str_replace("Product ", "", $taxonomy->label);

                        ?>
                        <th>
                            <span ><?php echo esc_html(ucfirst($varimo_label)); ?>
                                <span style="float: right" class="attribute-sort-arrows" data-attribute="<?php echo esc_attr($varimo_attribute_name); ?>">
                                    <span class="dashicons dashicons-arrow-up-alt" id="sort-toggle-<?php echo esc_attr($varimo_attribute_name); ?>"></span>
                                </span>
                            </span>
                        </th>
                        <?php
                    } elseif (isset($varimo_data["variation"]) && $varimo_data["variation"]) {
                        // Output the attribute column header with sorting arrows
                        ?>
                        <th>
                            <span><?php echo esc_html(ucfirst($varimo_attribute_name)); ?>
                                <span style="float: right" class="attribute-sort-arrows" data-attribute="<?php echo esc_attr($varimo_attribute_name); ?>">
                                    <span class="dashicons dashicons-arrow-up-alt" id="sort-toggle-<?php echo esc_attr($varimo_attribute_name); ?>"></span>
                                </span>
                            </span>
                        </th>
                        <?php
                    }
                }
            }
            ?>

            <?php if ($varimoPriceHideShow === "true"){
                ?>
                <th>
                    <span>
                        <?php esc_html_e('Price', 'variation-monster-pro'); ?>
                    </span>
                    <span style="float: right" id="price-sort-arrows">
                        <span class="dashicons dashicons-arrow-up-alt" id="price-sort-toggle"></span>
                    </span>
                </th>
                <?php
            }?>

            <?php if ($varimoQuantityHideShow === "true"){
                ?>
                <th><?php esc_html_e('Quantity', 'variation-monster-pro'); ?></th>
                <?php
            }?>

            <?php if ($varimoActionHideShow === "true"){
                ?>
                <th><?php esc_html_e('Action', 'variation-monster-pro'); ?></th>
                <?php
            }?>

        </tr>

        <?php
        $varimo_variations = $product->get_available_variations();

        // Sort the variations by SKU
        usort($varimo_variations, function($a, $b) {
            $skuA = $a['sku'];
            $skuB = $b['sku'];

            return strcmp($skuA, $skuB); // Ascending order
        });

        // Sort the variations by Price (ascending)
        usort($varimo_variations, function($a, $b) {
            // Get variation objects
            $variationA = new WC_Product_Variation($a['variation_id']);
            $variationB = new WC_Product_Variation($b['variation_id']);

            // Get the prices for each variation
            $priceA = $variationA->get_price();
            $priceB = $variationB->get_price();

            // Check if prices are available and perform numerical comparison
            if ($priceA === false || $priceB === false) {
                return 0; // If price is not available, consider them equal
            }

            return $priceA - $priceB; // Ascending order by price
        });


        // Add sorting for each attribute (example for 'color' and 'size')
        foreach ($varimo_all_attributes as $varimo_attribute_name => $varimo_attribute) {
            usort($varimo_variations, function($a, $b) use ($varimo_attribute_name) {
                // Get the variation attributes (e.g., color, size)
                $attrA = $a['attributes'][$varimo_attribute_name] ?? '';
                $attrB = $b['attributes'][$varimo_attribute_name] ?? '';

                // Sort based on attribute value (lexicographical order)
                return strcmp($attrA, $attrB); // Ascending order
            });
        }

        foreach ($varimo_variations as $varimo_var) {
            $varimo_variation_id             = $varimo_var['variation_id'];
            $varimo_variation                = new WC_Product_Variation($varimo_variation_id);
            $varimo_variation_stock_quantity = $varimo_variation->get_manage_stock() ? $varimo_variation->get_stock_quantity() : null;

            if ($varimoPopUPImageShow === 'default'){
                $varimo_image_popup_height = 500;
                $varimo_image_popup_width  = 100;
            }elseif($varimoPopUPImageShow === 'default2'){
                $varimo_image_popup_height = 300;
                $varimo_image_popup_width  = 300;
            }else{

                $varimo_image_size = wc_get_image_size($varimoPopUPImageShow);
                $varimo_image_popup_height = $varimo_image_size['height'];
                $varimo_image_popup_width  = $varimo_image_size['width'];
            }

            // Retrieve the gallery images
            $varimo_gallery_images = get_post_meta($varimo_variation_id, '_variation_gallery_images', true);
            $varimo_image_ids      = $varimo_gallery_images ? explode(',', $varimo_gallery_images) : [];
            $varimo_thumbnail_id   = $varimo_variation->get_image_id();
            $varimo_stock_status   = $varimo_variation->is_on_sale();
            ?>
            <tr class="variation-row" data-variation-id="<?php echo esc_attr($varimo_variation_id); ?>" data-stock-status="<?php echo esc_attr($varimo_stock_status); ?>" data-gallery-images="<?php echo esc_attr(wp_json_encode($varimo_image_ids)); ?>">
                <?php if ($varimoBulkSelectionHideShow === "true"){
                    ?>

                    <td style="padding: 20px; text-align: center">
                        <input class="bulk_cart" style="outline: none" type="checkbox" id="bulk_cart_<?php echo esc_attr($varimo_variation_id); ?>" name="bulk_cart[]" value="<?php echo esc_attr($varimo_variation_id); ?>">
                    </td>

                    <?php
                }?>

                <?php if ($varimoImageHideShow === "true") { ?>
                    <td class="table_image">
                        <?php
                        // Use wp_get_attachment_image() to render the image
                        echo wp_get_attachment_image(
                            $varimo_thumbnail_id, // Attachment ID for the thumbnail
                            "",   // Image size (you can adjust this)
                            false,         // Icon (false for actual image)
                            array(         // Additional attributes
                                'alt' => esc_attr($varimo_variation->get_name()),
                                'class' => 'gallery-trigger',
                                'style' => 'cursor: pointer; ',
                                'data-gallery-onoff' => esc_attr($varimoVariationGalleryOnOff),
                                'data-gallery' =>  esc_attr(implode(',', $varimo_image_ids)) // Pass URLs
                            )
                        );
                        ?>
                    </td>


                    <!-- Modal Popup -->
                    <?php if ($varimoShowPopUpImage === "true"){

                        ?>
                        <div id="imagePopup" class="popup-container">
                            <div class="popup-content">
                                <span class="close-btn">&times;</span>
                                <button style="outline: none; ma" id="prevImage" class="lightbox-nav prev">⟨</button>
                                <?php
                                echo wp_get_attachment_image(
                                    $varimo_thumbnail_id, // Initially display the main variation image
                                    '', // Default size; JavaScript will adjust dimensions dynamically
                                    false, // No icon
                                    array(
                                        'id' => 'popupImage',
                                        'alt' => esc_attr__('Popup Image', 'variation-monster-pro'),
                                        'style' => sprintf(
                                            'object-fit: contain; %s',
                                            $varimoPopUPImageShow === 'default' ?
                                                "max-height: " . esc_attr($varimo_image_popup_height) . "px; max-width: " . esc_attr($varimo_image_popup_width) . "%;" :
                                                "height: " . esc_attr($varimo_image_popup_height) . "px; width:" . esc_attr($varimo_image_popup_width) . "px;"
                                        )
                                    )
                                );
                                ?>
                                <button style="outline: none" id="nextImage" class="lightbox-nav next">⟩</button>
                            </div>
                        </div>
                        <?php
                    }?>


                    <?php
                }?>

                <?php if ($varimoSkuHideShow === "true"){
                    ?>
                    <td style="padding: 20px; text-align: center" class="quick-variable-title variable-sku"><?php echo esc_html($varimo_variation->get_sku()); ?></td>
                    <?php
                }?>


                <?php if ($varimoAllAttributeHideShow === "true"){
                    foreach ($varimo_all_attributes as $varimo_attribute_name => $varimo_attribute) {
                        $varimo_attribute_value = $varimo_variation->get_attribute($varimo_attribute_name);

                        if (empty($varimo_attribute_value)) {
                            echo "<td><select class='quick-attribute-select' name='attribute_" . esc_attr($varimo_attribute_name) . "' data-attribute-name='" . esc_attr($varimo_attribute_name) . "'>";

                            if ($varimo_attribute->is_taxonomy()) {
                                $varimo_options = wc_get_product_terms($product->get_id(), $varimo_attribute_name, ['fields' => 'names']);
                            } else {
                                $varimo_options = $varimo_attribute->get_options();
                            }

                            foreach ($varimo_options as $varimo_option) {
                                echo "<option value='" . esc_attr($varimo_option) . "'>" . esc_html($varimo_option) . "</option>";
                            }

                            echo "</select></td>";
                        } else {
                            // Display value as static text if it’s set for the variation
                            echo "<td  class='quick-variable-title quick-attribute-text'  data-attribute-name='" . esc_attr($varimo_attribute_name) . "' name='attribute_" . esc_attr($varimo_attribute_name) . "'>" . esc_html($varimo_attribute_value) . "</td>";
                        }
                    }
                }
                ?>

                <?php if ($varimoPriceHideShow === "true"){
                    ?>
                    <td class='variable-price quick-variable-title'><?php echo wp_kses_post($varimo_variation->get_price_html()); ?></td>
                    <?php
                }?>

                <?php if ($varimoQuantityHideShow === "true"){
                    ?>
                    <td>
                        <div class="quick-quantity-container" style="margin-bottom: 10px">
                            <button onclick="varimoShopPageQuantityDecrease(this)" class="quick-quantity-decrease" id="decrease">-</button>
                            <input  type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity ?: 99); ?>">
                            <button onclick="varimoShopPageQuantityIncrese(this)" class="quick-quantity-increase" id="increase">+</button>
                        </div>
                        <div class="quick-cart-notification quick-hidden"></div>
                    </td>
                    <?php
                }?>

                <?php if ($varimoActionHideShow === "true"){
                    ?>
                    <td class="stock-notification" style="padding: 20px; text-align: center ; justify-items: center">
                        <?php if (0 === ($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity)) : ?>
                            <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                        <?php else : ?>
                            <button style="width: 100%; text-align: center" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($varimo_variation_id); ?>">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                <span><?php echo esc_html($varimoCartButtonText); ?></span>
                            </button>
                        <?php endif; ?>
                    </td>
                    <?php
                }?>

            </tr>
            <?php
        }
        ?>
    </table>

    <?php if ($varimoBulkAddToCartPosition === "after"  || $varimoBulkAddToCartPosition === "both"){
        ?>
        <button class="bulk-add-to-cart"  id="bulk-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>"  style="background-color: #007CBA; color: white; border-radius: 5px ; outline: none">
            <i class="fa fa-cart-plus" aria-hidden="true"></i>
            <span><?php echo esc_html($varimoCartButtonText); ?></span>
            <span  class="bulk-add-to-cart-success-icon"> </span>
        </button>
        <?php
    }?>
</div>


<style>
    .table-scroll-container {
        overflow-x: auto; /* Enables horizontal scrolling */
        display: block;  /* Ensures it's treated as a block-level container */
        width: 100%;     /* Adjusts to the parent width */
    }

    .mobile-table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
        table-layout: auto; /* Allows the table to adjust column widths automatically */
    }

    .mobile-table th, .mobile-table td {
        text-align: left;
        padding: 8px;
        white-space: nowrap; /* Prevents wrapping of text */
    }
</style>

<script>


    // Bulk checkbox select
    jQuery(document).ready(function($) {
        function toggleAddToCartButton() {
            if (jQuery('.bulk_cart:checked').length > 0) {
                jQuery('.bulk-add-to-cart').show();
            } else {
                jQuery('.bulk-add-to-cart').hide();
                // jQuery('.search_option').css('margin-top', '100px');
            }
        }

        // Initial check to ensure button state is correct
        toggleAddToCartButton();

        jQuery('.bulk_cart').on('change', function() {
            toggleAddToCartButton();
        });

        jQuery('#bulk_checkbox_select_all').on('change', function() {
            var isChecked = jQuery(this).prop('checked');
            jQuery('.bulk_cart').prop('checked', isChecked);
            toggleAddToCartButton();
        });
    });


    // Bulk checkbox all checkbox is checked.
    jQuery(document).ready(function($) {
        jQuery('#bulk_checkbox_select_all').on('change', function() {
            var isChecked = jQuery(this).prop('checked');
            jQuery('.bulk_cart').prop('checked', isChecked);
        });

        jQuery('.bulk_cart').on('change', function() {
            var allChecked = jQuery('.bulk_cart').length === jQuery('.bulk_cart:checked').length;
            jQuery('#bulk_checkbox_select_all').prop('checked', allChecked);
        });

    });


    // Attribute and Price Sorting.
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("quick-variable-table");
        const rows = Array.from(table.querySelectorAll(".variation-row"));

        // Function to sort rows by price
        function sortByPrice(order) {
            rows.sort((rowA, rowB) => {
                const priceA = parseFloat(rowA.querySelector(".variable-price").textContent.replace(/[^0-9.-]+/g, ""));
                const priceB = parseFloat(rowB.querySelector(".variable-price").textContent.replace(/[^0-9.-]+/g, ""));
                return order === "asc" ? priceA - priceB : priceB - priceA;
            });
            rows.forEach(row => table.appendChild(row));
        }

        // Function to sort rows by attribute
        function sortByAttribute(attribute, order) {
            rows.sort((rowA, rowB) => {
                const attrA = rowA.querySelector(`[data-attribute-name="${attribute}"]`)?.textContent.trim() || "";
                const attrB = rowB.querySelector(`[data-attribute-name="${attribute}"]`)?.textContent.trim() || "";
                return order === "asc" ? attrA.localeCompare(attrB) : attrB.localeCompare(attrA);
            });
            rows.forEach(row => table.appendChild(row));
        }

        // Toggle sorting order and icon for price
        const priceSortToggle = document.getElementById("price-sort-toggle");
        let priceOrder = "asc"; // Initial order
        priceSortToggle.addEventListener("click", function () {
            sortByPrice(priceOrder);
            priceSortToggle.classList.toggle("dashicons-arrow-up-alt");
            priceSortToggle.classList.toggle("dashicons-arrow-down-alt");
            priceOrder = priceOrder === "asc" ? "desc" : "asc";
        });

        // Toggle sorting order and icon for attributes
        const attributeSortArrows = document.querySelectorAll(".attribute-sort-arrows");
        attributeSortArrows.forEach(arrow => {
            const attribute = arrow.dataset.attribute;
            let attributeOrder = "asc"; // Initial order
            const toggleIcon = document.getElementById(`sort-toggle-${attribute}`);

            toggleIcon.addEventListener("click", function () {
                sortByAttribute(attribute, attributeOrder);
                toggleIcon.classList.toggle("dashicons-arrow-up-alt");
                toggleIcon.classList.toggle("dashicons-arrow-down-alt");
                attributeOrder = attributeOrder === "asc" ? "desc" : "asc";
            });
        });
    });


    // SKU Sorting.
    document.addEventListener("DOMContentLoaded", function () {
        // Get the sorting arrow container for SKU
        const SKUArrow = document.getElementById("sort-asc");

        // Get the table rows (variations)
        const table = document.getElementById("quick-variable-table");
        const rows = Array.from(table.querySelectorAll(".variation-row"));

        // Current sort order tracker
        let currentOrder = 'asc';

        // Function to sort table rows by SKU
        function sortBySKU(order) {
            rows.sort((a, b) => {
                const skuA = a.querySelector(".variable-sku").textContent.trim();
                const skuB = b.querySelector(".variable-sku").textContent.trim();

                return order === 'asc' ? skuA.localeCompare(skuB) : skuB.localeCompare(skuA);
            });

            // Re-attach sorted rows to the table
            rows.forEach(row => table.appendChild(row));
        }

        // Function to toggle the icon and sort the table
        SKUArrow.addEventListener('click', function () {
            if (currentOrder === 'asc') {
                sortBySKU('asc');
                SKUArrow.classList.remove('dashicons-arrow-up-alt');
                SKUArrow.classList.add('dashicons-arrow-down-alt');
                currentOrder = 'desc';
            } else {
                sortBySKU('desc');
                SKUArrow.classList.remove('dashicons-arrow-down-alt');
                SKUArrow.classList.add('dashicons-arrow-up-alt');
                currentOrder = 'asc';
            }
        });
    });


    // Popup image on the table.
    // document.addEventListener('DOMContentLoaded', () => {
    //     const images = document.querySelectorAll('.gallery-trigger');
    //     const popup = document.getElementById('imagePopup');
    //     const popupImage = document.getElementById('popupImage');
    //     const closeBtn = document.querySelector('.close-btn');
    //     const nextImage = document.getElementById('nextImage');
    //     const prevImage = document.getElementById('prevImage');
    //     let gallery = [];
    //     let currentIndex = 0;
    //
    //     // Function to load an image into the popup
    //     function loadImage(index) {
    //         if (index < 0 || index >= gallery.length) return; // Avoid index out of bounds
    //         currentIndex = index;
    //         popupImage.src = gallery[currentIndex];
    //         updateNavigationButtons();
    //     }
    //
    //     // Update navigation buttons visibility
    //     function updateNavigationButtons() {
    //         if (gallery.length <= 1) {
    //             nextImage.style.display = 'none';
    //             prevImage.style.display = 'none';
    //         } else {
    //             nextImage.style.display = currentIndex < gallery.length - 1 ? 'block' : 'none';
    //             prevImage.style.display = currentIndex > 0 ? 'block' : 'none';
    //         }
    //     }
    //
    //     // Event listener for each image in the table
    //     images.forEach(image => {
    //         image.addEventListener('click', () => {
    //             const galleryImages = JSON.parse(image.getAttribute('data-gallery')) || [];
    //             const galleryOnOff  = image.getAttribute('data-gallery-onoff');
    //
    //             if (galleryImages.length > 0 && galleryOnOff == 'true') {
    //                 gallery = galleryImages; // Set gallery images
    //                 loadImage(0); // Load the first image
    //             } else {
    //                 // If no gallery, just show the clicked image
    //                 gallery = [image.src];
    //                 loadImage(0);
    //             }
    //             popup.style.display = 'flex'; // Show the popup
    //         });
    //     });
    //
    //     // Close popup when close button is clicked
    //     closeBtn.addEventListener('click', () => {
    //         popup.style.display = 'none';
    //     });
    //
    //     // Close popup when clicking outside the popup content
    //     popup.addEventListener('click', (event) => {
    //         if (event.target === popup) {
    //             popup.style.display = 'none';
    //         }
    //     });
    //
    //     // Navigate to the next image
    //     nextImage.addEventListener('click', () => {
    //         loadImage(currentIndex + 1);
    //     });
    //
    //     // Navigate to the previous image
    //     prevImage.addEventListener('click', () => {
    //         loadImage(currentIndex - 1);
    //     });
    // });

    document.addEventListener('DOMContentLoaded', () => {
        const images = document.querySelectorAll('.gallery-trigger');
        const popup = document.getElementById('imagePopup');
        const popupImage = document.getElementById('popupImage');
        const closeBtn = document.querySelector('.close-btn');
        const nextImage = document.getElementById('nextImage');
        const prevImage = document.getElementById('prevImage');
        let gallery = [];
        let currentIndex = 0;

        // Function to load an image into the popup
        function loadImage(index) {
            if (index < 0 || index >= gallery.length) return; // Avoid index out of bounds
            currentIndex = index;
            if (popupImage) {
                popupImage.src = gallery[currentIndex];
                updateNavigationButtons();
            } else {
                console.error("Popup image element not found.");
            }
        }

        // Update navigation buttons visibility
        function updateNavigationButtons() {
            if (gallery.length <= 1) {
                nextImage.style.display = 'none';
                prevImage.style.display = 'none';
            } else {
                nextImage.style.display = currentIndex < gallery.length - 1 ? 'block' : 'none';
                prevImage.style.display = currentIndex > 0 ? 'block' : 'none';
            }
        }

        // Event listener for each image in the table
        images.forEach(image => {
            image.addEventListener('click', () => {

                const galleryImagesID = image.getAttribute('data-gallery') || '';
                console.log(galleryImagesID);
                const galleryOnOff = image.getAttribute('data-gallery-onoff');

                if (galleryImagesID.length > 0 && galleryOnOff === 'true') {
                    gallery = galleryImagesID; // Set gallery images
                    loadImage(0); // Load the first image
                } else {
                    // If no gallery, just show the clicked image
                    gallery = [image.src];
                    loadImage(0);
                }
                popup.style.display = 'flex'; // Show the popup
            });
        });

        // Close popup when close button is clicked
        closeBtn?.addEventListener('click', () => {
            popup.style.display = 'none';
        });

        // Close popup when clicking outside the popup content
        popup?.addEventListener('click', (event) => {
            if (event.target === popup) {
                popup.style.display = 'none';
            }
        });

        // Navigate to the next image
        nextImage?.addEventListener('click', () => {
            loadImage(currentIndex + 1);
        });

        // Navigate to the previous image
        prevImage?.addEventListener('click', () => {
            loadImage(currentIndex - 1);
        });
    });



    // Issue for On Sale Checked and Unchecked
    jQuery(document).ready(function($) {
        var removedRows = [];

        jQuery('.variation-row').show();

        jQuery('#stock_status').on('change', function () {
            var isChecked = jQuery(this).prop('checked');

            jQuery('.variation-row').each(function () {
                var stockStatus = jQuery(this).data('stock-status');

                if (isChecked && stockStatus === 1) {
                    jQuery(this).show();
                    jQuery(this).find('.quick-add-to-cart').css('min-width', '140px');
                } else if (!isChecked) {
                    jQuery(this).show();
                } else {
                    if (stockStatus !== 'instock') {
                        removedRows.push(jQuery(this).detach());
                    }
                }
            });

            if (!isChecked) {
                for (var i = 0; i < removedRows.length; i++) {
                    jQuery('#quick-variable-table').append(removedRows[i].addClass('re-added'));
                    jQuery(this).find('.quick-add-to-cart').css('min-width', '140px');
                }

                removedRows = [];

                jQuery('.re-added').each(function () {
                    bindAddToCart(jQuery(this));
                    jQuery(this).removeClass('re-added');
                });

                bindQuantityButtons();
            }
        });

        // Add to cart for On Sale unchecked portion
        function bindAddToCart(row) {
            row.find('.quick-add-to-cart').off('click').on('click', function () {

                function isMobile() {
                    return /Mobi|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i.test(navigator.userAgent);
                }

                var $button = jQuery(this);
                var productId = $button.data('productid');
                var variationId = $button.data('variationid');
                var quantity = row.find(".quick-quantity-input").val();

                if (!$button.hasClass('loading')) {

                    $button.addClass('loading');

                    $button.append('<span class="spinner"><i class="fa fa-spinner fa-spin"></i></span>');

                    setTimeout(function() {
                        $button.removeClass('loading');
                        $button.find('.spinner').remove();
                    }, 2000);
                }

                if (isMobile()) {
                    quantity = $button.closest('.mobile-variation-card').find('.quick-quantity-input').val();
                } else {
                    quantity = $button.closest('tr').find(".quick-quantity-input").val();
                }

                var selectedAttributes = {};
                var $container = isMobile()
                    ? $button.closest('.mobile-variation-card')
                    : $button.closest('tr');

                $container.find('.quick-attribute-select, .quick-attribute-text').each(function () {
                    var attributeKey = jQuery(this).attr('name');
                    var attributeValue;

                    if (jQuery(this).is('select')) {
                        attributeValue = jQuery(this).val();
                    } else {
                        attributeValue = jQuery(this).text().trim();
                    }

                    if (attributeValue && attributeKey) {
                        selectedAttributes[attributeKey] = attributeValue;
                    }
                });

                const data = {
                    'action': 'woocommerce_ajax_add_to_cart',
                    'product_id': productId,
                    'quantity': quantity,
                    'variation_id': variationId,
                    'variation': selectedAttributes,
                    "_wpnonce": quick_front_ajax_obj.nonce, // Add the nonce here
                };


                $button.prop('disabled', true);
                $button.find('i, span').hide();

                $.post(quick_front_ajax_obj.ajax_url, data, function(response) {

                    if (response.success) {
                        $button.append('<span class="updated-check-add-to-cart"><i class="fa fa-check"></i></span>');

                        setTimeout(function() {
                            $button.find('.updated-check-add-to-cart').remove();
                            $button.prop('disabled', false);
                            $button.find('i, span').show();
                        }, 3000);

                        jQuery( document.body).trigger('wc_fragment_refresh');

                    } else {
                        console.error('Failed to add product: ', response);
                        $button.prop('disabled', false);
                        $button.find('i, span').show();
                    }
                });
            });
        }


        // Add search functionality (filter by SKU or attribute)
        jQuery('#variation-search').on('input', function () {
            var searchTerm = jQuery(this).val().toLowerCase();

            jQuery('.variation-row').each(function () {
                var rowContent = jQuery(this).text().toLowerCase();
                if (rowContent.includes(searchTerm)) {
                    jQuery(this).show();
                } else {
                    jQuery(this).hide();
                }
            });
        });

        // Function to bind quantity buttons
        function bindQuantityButtons() {
            jQuery(".quick-quantity-decrease").off("click").on("click", function () {
                let currentValue = parseInt(
                    jQuery(this).siblings(".quick-quantity-input").val(),
                    10
                );

                if (currentValue > 1) {
                    // Prevent going below 1
                    jQuery(this)
                        .siblings(".quick-quantity-input")
                        .val(currentValue - 1);
                    jQuery(".quick-cart-notification").text("");
                }
            });

            jQuery(".quick-quantity-increase").off("click").on("click", function () {
                console.log("increase");
                maxQuantity = jQuery(this)
                    .siblings(".quick-quantity-input")
                    .attr("data-max");
                let currentValue = parseInt(
                    jQuery(this).siblings(".quick-quantity-input").val(),
                    10
                );

                if (currentValue < maxQuantity) {
                    // Prevent exceeding max limit
                    jQuery(this)
                        .siblings(".quick-quantity-input")
                        .val(currentValue + 1);
                    jQuery(".quick-cart-notification").text("");
                }
            });
        }
    });

</script>


<style>

    /* Popup container */
    .popup-container {
        display: none;
        position: fixed;
        z-index: 999999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    }

    /* Popup content (image wrapper) */
    .popup-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        border: 5px solid white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    /* Popup content (image) */
    /*.popup-content img {*/
    /*    max-width: 100%;*/
    /*    max-height: 500px;*/
    /*    object-fit: contain;*/
    /*}*/

    /* Close button */
    .close-btn {
        position: absolute;
        top: 0;
        right: 0;
        color: white;
        font-size: 25px;
        font-weight: bold;
        background-color: rgba(0, 0, 0, 0.5);
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        text-align: center;
        line-height: 30px;
        cursor: pointer;
        z-index: 1010;
    }

    .close-btn:hover{
        background-color: #d5d5d5;
        border-color: #d5d5d5;
        color: #333333;
    }

    .quick-add-to-cart.loading .fa-cart-plus,
    .quick-add-to-cart.loading span {
        display: none;
    }


    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        border: none;
        color: white;
        font-size: 2rem;
        padding: 10px;
        cursor: pointer;
        z-index: 1000;
    }

    .lightbox-nav:hover {
        background-color: #d5d5d5;
        border-color: #d5d5d5;
        color: #333333;
    }

    .lightbox-nav.prev {
        left: 10px;
    }

    .lightbox-nav.next {
        right: 10px;
    }


</style>
<style>

    .quick-add-to-cart.loading .fa-cart-plus,
    .quick-add-to-cart.loading span {
        display: none; /* Hide default icon and text */
    }

</style>