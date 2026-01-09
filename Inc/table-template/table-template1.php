<?php
if (!defined('ABSPATH')) exit;

global $product;
global $post;
if (isset($product) && $product->is_type("variable")) {
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
    $varimoTableTemplateTwoEnable         = isset($varimoVariableSetting['tableTemplateTwoEnable']) ? $varimoVariableSetting['tableTemplateTwoEnable'] : '';
    $varimoTitleHideShow                  = isset($varimoVariableSetting['titleHideShow']) ? $varimoVariableSetting['titleHideShow'] : 'true';
    $varimoDescriptionHideShow            = isset($varimoVariableSetting['descriptionHideShow']) ? $varimoVariableSetting['descriptionHideShow'] : 'true';
    $varimoWeightDimensionsHideShow       = isset($varimoVariableSetting['weightDimensionsHideShow']) ? $varimoVariableSetting['weightDimensionsHideShow'] : 'true';
    $varimoShowDoublePrice                = isset($varimoVariableSetting['showDoublePrice']) ? $varimoVariableSetting['showDoublePrice'] : 'true';
    $varimoQuickCartIcon                  = isset($varimoVariableSetting['quickCartIcon']) ? $varimoVariableSetting['quickCartIcon'] : 'fa fa-shopping-cart';
    $varimoQuickCartIconImageLink         = isset($varimoVariableSetting['quickCartIconImageLink']) ? $varimoVariableSetting['quickCartIconImageLink'] : '';
    $varimoPopUPImageShow                 = isset($varimoVariableSetting['popUPImageShow']) ? $varimoVariableSetting['popUPImageShow'] : 'thumbnail';
    $varimoShowGalleyImageIntoPopup       = isset($varimoVariableSetting['showGalleyImageIntoPopup']) ? $varimoVariableSetting['showGalleyImageIntoPopup'] : 'true';
    $varimoTableRowPagination             = isset($varimoVariableSetting['tableRowPagination']) ? $varimoVariableSetting['tableRowPagination'] : '5';
    $varimoNewMetaDataForVariationsTable  = isset($varimoVariableSetting['newMetaDataForVariationsTable']) ? $varimoVariableSetting['newMetaDataForVariationsTable'] : array();
    $varimo_variations                     = $product->get_available_variations();
    $varimo_variation_count                = count($varimo_variations);

    ?>
    <div class="table-template-max-width template-one-table alignwide">

        <div id="loading-spinner-pagination-table" style="display: none; text-align: center;">
            <i class="fa fa-spinner fa-spin "></i>
        </div>

        <div class="table-before" >
            <?php if ($varimoBulkAddToCartPosition === "before"  || $varimoBulkAddToCartPosition === "both"){
                ?>
                <button class="bulk-add-to-cart"  id="bulk-add-to-cart" data-carticon="<?php echo esc_attr($varimoQuickCartIcon ?: 'fa-cart-plus'); ?>" data-productId="<?php echo esc_attr($product->get_id()); ?>"  style=" border-radius: 5px ; outline: none;display: none">
                    <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                        <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>"></span>
                    <?php else: ?>
                        <i class="<?php echo esc_attr($varimoQuickCartIcon); ?>" aria-hidden="true"></i>
                    <?php endif; ?>
                    <span><?php echo esc_html($varimoCartButtonText); ?></span>
                    <span  class="bulk-add-to-cart-success-icon"> </span>
                </button>
                <?php
            }?>

            <?php if ($varimoOnSaleHideShow === "true"){
                ?>
                <div style="display: inline-flex; align-items: baseline; gap: 10px ; margin-right: 10px; margin-left: 10px">
                    <input id="stock_status" type="checkbox"  name=""  style="outline: none">
                    <p for="stock_status" ><?php echo esc_html($varimoOnSaleNameChange); ?></p>
                </div>
                <?php
            }?>

            <?php if ($varimoSearchOptionHideShow === "true"){
                ?>
                <div class="search_option" style="display: inline-flex; align-items: baseline; gap: 10px">
                    <input class="variation-table-search" type="text" placeholder="<?php echo esc_html($varimoSearchOptionTextChange); ?>" name="search" id="variation-search">
                </div>
                <?php
            }?>
        </div>
        <table id="quick-variable-table" class="table-template1" data-pagination-table="<?php echo esc_attr($varimoTableRowPagination); ?>" data-Variation-count="<?php echo esc_attr($varimo_variation_count); ?>" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
            <tr>
                <?php if ($varimoBulkSelectionHideShow === "true"){
                    ?>
                    <th><input id="bulk_checkbox_select_all" type="checkbox"  name="" style="outline: none" ></th>
                    <?php
                }?>

                <?php if ($varimoImageHideShow === "true"){
                    ?>
                    <th><?php esc_html_e('Image', 'variation-monster'); ?></th>
                    <?php
                }?>

                <?php if ($varimoSkuHideShow === "true"){
                    ?>

                    <th>
                        <span style="display: inline-block; margin-top: 9px">
                            <?php esc_html_e('SKU', 'variation-monster'); ?>
                        </span>
                        <span style=" float: right; display: grid;" id="sku-sort-arrows">
                            <span style="height: 10px" class="dashicons dashicons-arrow-up" id="sort-arrow-up"></span>
                            <span style="height: 10px" class="dashicons dashicons-arrow-down" id="sort-arrow-down"></span>
                        </span>
                    </th>

                    <?php
                }?>

                <?php if ($varimoAllAttributeHideShow === "true"){
                    foreach ($varimo_all_attributes as $varimo_attribute_name => $varimo_attribute) {

                        $varimo_reflection   = new ReflectionClass($varimo_attribute);
                        $varimo_dataProperty = $varimo_reflection->getProperty("data");
                        $varimo_dataProperty->setAccessible(true);
                        $varimo_data = $varimo_dataProperty->getValue($varimo_attribute);

                        if (taxonomy_exists($varimo_attribute_name) && isset($varimo_data["variation"]) && $varimo_data["variation"]) {
                            $taxonomy = get_taxonomy($varimo_attribute_name);
                            $varimo_label    = str_replace("Product ", "", $taxonomy->label);

                            ?>
                            <th >
                                <span style="display: inline-block; margin-top: 9px">
                                    <?php echo esc_html(ucfirst($varimo_label)); ?>
                                </span>
                                <span style="float: right; display: grid" class="attribute-sort-arrows" data-attribute="<?php echo esc_attr($varimo_attribute_name); ?>">
                                    <span style="height: 10px" class="dashicons dashicons-arrow-up" id="sort-toggle-<?php echo esc_attr($varimo_attribute_name); ?>"></span>
                                    <span style="height: 10px" class="dashicons dashicons-arrow-down" id="sort-toggle-<?php echo esc_attr($varimo_attribute_name); ?>"></span>
                                </span>
                            </th>
                            <?php
                        } elseif (isset($varimo_data["variation"]) && $varimo_data["variation"]) {
                            ?>
                            <th >
                                <span style="display: inline-block; margin-top: 9px">
                                    <?php echo esc_html(ucfirst($varimo_attribute_name)); ?>
                                </span>
                                <span style="float: right; display: grid" class="attribute-sort-arrows" data-attribute="<?php echo esc_attr($varimo_attribute_name); ?>">
                                    <span style="height: 10px" class="dashicons dashicons-arrow-up" id="sort-arrow-up-<?php echo esc_attr($varimo_attribute_name); ?>"></span>
                                    <span style="height: 10px" class="dashicons dashicons-arrow-down" id="sort-arrow-down-<?php echo esc_attr($varimo_attribute_name); ?>"></span>
                                </span>
                            </th>
                            <?php
                        }
                    }
                }
                ?>

                <?php if ($varimoPriceHideShow === "true"){
                    ?>
                    <th >
                        <span style="display: inline-block; margin-top: 9px">
                        <?php esc_html_e('Price', 'variation-monster'); ?>
                        </span>
                        <span style="float: right; display: grid" id="price-sort-arrows">
                            <span style="height: 10px" class="dashicons dashicons-arrow-up" id="price-sort-arrow-up"></span>
                            <span style="height: 10px" class="dashicons dashicons-arrow-down" id="price-sort-arrow-down"></span>
                        </span>
                    </th>
                    <?php
                }

                foreach ($varimoNewMetaDataForVariationsTable as $varimo_newMetaDataForVariation){
                    $varimo_label    =  $varimo_newMetaDataForVariation["value"]; ?>
                    <th><?php echo esc_html($varimo_label); ?></th><?php
                }

                if ($varimoQuantityHideShow === "true"){
                    ?>
                    <th><?php esc_html_e('Quantity', 'variation-monster'); ?></th>
                    <?php
                }?>

                <?php if ($varimoActionHideShow === "true"){
                    ?>
                    <th><?php esc_html_e('Action', 'variation-monster'); ?></th>
                    <?php
                }?>

            </tr>

            <?php
            $varimo_variations = $product->get_available_variations();

            usort($varimo_variations, function($a, $b) {
                $skuA = $a['sku'];
                $skuB = $b['sku'];
                return strcmp($skuA, $skuB);
            });

            usort($varimo_variations, function($a, $b) {

                $variationA = new WC_Product_Variation($a['variation_id']);
                $variationB = new WC_Product_Variation($b['variation_id']);
                $priceA     = $variationA->get_price();
                $priceB     = $variationB->get_price();

                if ($priceA === false || $priceB === false) {
                    return 0;
                }
                return $priceA - $priceB;
            });

            foreach ($varimo_all_attributes as $varimo_attribute_name => $varimo_attribute) {
                // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
                usort($varimo_variations, function($a, $b) use ($varimo_attribute_name) {
                    // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
                    $attrA = $a['attributes'][$varimo_attribute_name] ?? '';
                    // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
                    $attrB = $b['attributes'][$varimo_attribute_name] ?? '';

                    return strcmp($attrA, $attrB);
                });
            }

            $varimo_variations_for_pagination = $product->get_available_variations();
            $varimo_current_variation         = array_slice($varimo_variations_for_pagination, 0, $varimoTableRowPagination);

            foreach ($varimo_current_variation as $varimo_var) {
                $varimo_variation_id             = $varimo_var['variation_id'];
                $varimo_variation                = new WC_Product_Variation($varimo_variation_id);
                $varimo_variation_stock_quantity = $varimo_variation->get_manage_stock() ? $varimo_variation->get_stock_quantity() : null;

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
                            // nosemgrep
                            echo wp_get_attachment_image(
                                $varimo_thumbnail_id,
                                esc_attr($varimoPopUPImageShow),
                                false,
                                array(
                                    'alt' => esc_attr($varimo_variation->get_name()),
                                    'class' => 'gallery-trigger',
                                    'style' => 'cursor: pointer; ',
                                    'data-gallery-onoff' => esc_attr($varimoShowGalleyImageIntoPopup),
                                    'data-gallery' => esc_attr(wp_json_encode(array_map(function ($image_id) use ($varimoPopUPImageShow) {
                                        $image_size = in_array($varimoPopUPImageShow, ['thumbnail', 'medium', 'large', 'full']) ? $varimoPopUPImageShow : 'thumbnail';
                                        return wp_get_attachment_image_src($image_id, $image_size)[0] ?? '';
                                    }, $varimo_image_ids))),

                                )
                            );
                            ?>
                        </td>

                        <!-- Modal Image Popup -->
                        <?php if ($varimoShowPopUpImage === "true"){
                            ?>
                            <div class="popup-container">
                                <div class="popup-content">
                                    <span class="close-btn">&times;</span>
                                    <button style="outline: none;" id="prevImage" class="lightbox-nav prev">⟨</button>

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
                        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
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

                                echo "<td  class='quick-variable-title quick-attribute-text'  data-attribute-name='" . esc_attr($varimo_attribute_name) . "' name='attribute_" . esc_attr($varimo_attribute_name) . "'>" . esc_html($varimo_attribute_value) . "</td>";
                            }
                        }
                    }
                    ?>

                    <?php if ($varimoPriceHideShow === "true"){
                        ?>
                        <td class='variable-price quick-variable-title'><?php
                            if ($varimoShowDoublePrice === 'true'){
                                $varimo_price_html = $varimo_variation->get_price_html();
                                echo $varimo_price_html ? wp_kses_post($varimo_price_html) : ''; // nosemgrep
                            }else{
                                $varimo_sale_price = $varimo_variation->get_sale_price();
                                if($varimo_sale_price) {
                                    echo $varimo_sale_price ? wp_kses_post(wc_price($varimo_sale_price)) : ''; // nosemgrep
                                } else {
                                    $varimo_regular_price_html = $varimo_variation->get_regular_price();
                                    echo $varimo_regular_price_html ? wp_kses_post(wc_price($varimo_regular_price_html)) : ''; // nosemgrep
                                }
                            }
                            $varimo_sale_price_available_sorting = $varimo_variation->get_sale_price();
                            if ($varimo_sale_price_available_sorting){
                                ?>
                                <span class="variable-sale-price" style="display: none">
                                    <?php
                                    echo wp_kses_post(wc_price($varimo_sale_price_available_sorting)); // nosemgrep
                                    ?>
                                </span>
                            <?php }
                            ?></td>
                        <?php
                    }


                    foreach ($varimoNewMetaDataForVariationsTable as $varimo_newMetaDataForVariation){
                        $varimo_keyValue =  get_post_meta($varimo_variation_id, $varimo_newMetaDataForVariation["key"], true);
                        ?>
                        <td class="quick-variable-title"><?php echo esc_html($varimo_keyValue); ?></td><?php
                    }

                     if ($varimoQuantityHideShow === "true"){
                        ?>
                        <td>
                            <div class="quick-quantity-container" style="margin-bottom: 10px">
                                <button class="quick-quantity-decrease" onclick="varimoShopPageQuantityDecrease(this)" id="decrease">-</button>
                                <input  type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity ?: 99); ?>">
                                <button class="quick-quantity-increase" onclick="varimoShopPageQuantityIncrese(this)" id="increase">+</button>
                            </div>
                            <div class="quick-cart-notification quick-hidden"></div>
                        </td>
                        <?php
                    }?>

                    <?php if ($varimoActionHideShow === "true"){
                        ?>
                        <td class="stock-notification" style="padding: 20px; text-align: center ; justify-items: center">
                            <?php if (0 === ($varimo_variation_stock_quantity) || $varimo_variation->get_stock_status() === "outofstock") : ?>
                                <p><?php esc_html_e('Out Of Stock', 'variation-monster'); ?></p>
                            <?php else : ?>
                                <button style="width: 100%; text-align: center" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($varimo_variation_id); ?>">
                                    <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                                        <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>"></span>
                                    <?php else: ?>
                                        <i class="<?php echo esc_attr($varimoQuickCartIcon); ?>" aria-hidden="true"></i>
                                    <?php endif; ?>
                                    <span style="margin-left: 3px"><?php echo esc_html($varimoCartButtonText); ?></span>
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
            <button  class="bulk-add-to-cart"  id="bulk-add-to-cart" data-carticon="<?php echo esc_attr($varimoQuickCartIcon ?: 'fa-cart-plus'); ?>"  data-productId="<?php echo esc_attr($product->get_id()); ?>"  style="border-radius: 5px ; outline: none; display: none; margin-bottom: 10px;">
                <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                    <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>"></span>
                <?php else: ?>
                    <i class="<?php echo esc_attr($varimoQuickCartIcon); ?> cart-icon-remove" aria-hidden="true"></i>
                <?php endif; ?>
                <span><?php echo esc_html($varimoCartButtonText); ?></span>
                <span  class="bulk-add-to-cart-success-icon"> </span>
            </button>
            <?php
        }?>

        <!-- Pagination Controls -->
        <div id="pagination">
            <button style="margin-right: 5px" id="prevPage" disabled><?php esc_html_e('Previous', 'variation-monster'); ?></button>
            <button id="nextPage"><?php esc_html_e('Next', 'variation-monster'); ?></button>
        </div>
    </div>
    <?php
}

?>

<script>
    jQuery(document).ready(function ($) {
        if(jQuery('.table-template2').length === 0){
            var $table        = jQuery("#quick-variable-table");
        }
        const rowsPerPage = $table.data('pagination-table') || 5;
        const totalRows   = $table.data('variation-count');
        var currentPage   = 1;
        var totalPages    = 1;
        var productId     = $table.data('product-id');

        if (totalRows <= rowsPerPage) {
            jQuery("#pagination").hide();
        }

        function loadPage(page) {
            jQuery.ajax({
                url: quick_front_ajax_obj.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_more_variations',
                    product_id: productId,
                    page: page,
                    pagination_nonce: quick_front_ajax_obj.nonce,
                },
                success: function (response) {
                    if (response.success) {
                        jQuery("#loading-spinner-pagination-table").hide();
                        $table.find('tr.variation-row').remove();
                        $table.append(response.data.html);
                        totalPages = response.data.total_pages;
                        currentPage = response.data.current_page;
                        updatePaginationControls();
                        reapplySorting();
                    } else {
                        alert('Failed to load variations.');
                    }
                },
                error: function () {
                    alert('Failed to load variations.');
                }
            });
        }

        function updatePaginationControls() {
            jQuery("#prevPage").prop("disabled", currentPage === 1);
            jQuery("#nextPage").prop("disabled", currentPage === totalPages);
            jQuery("#pageInfo").text(`Page ${currentPage} of ${totalPages}`);
        }

        jQuery("#prevPage").click(function () {

            jQuery("#loading-spinner-pagination-table").show();
            jQuery(".table-template-max-width").css("opacity", "0.5");

            setTimeout(function() {
                jQuery("#loading-spinner-pagination-table").hide();
                jQuery(".table-template-max-width").css("opacity", "1");
            }, 1000);


            if (currentPage > 1) {
                currentPage--;
                resetCheckboxes()
                loadPage(currentPage);
            }
        });

        jQuery("#nextPage").click(function () {

            jQuery("#loading-spinner-pagination-table").show();
            jQuery("#quick-variable-table").css("opacity", "0.5");

            setTimeout(function() {
                jQuery("#loading-spinner-pagination-table").hide();
                jQuery("#quick-variable-table").css("opacity", "1");
            }, 1000);

            if (currentPage) {
                currentPage++;
                resetCheckboxes()
                loadPage(currentPage);
            }
        });

        function reapplySorting() {
            const headers = $table.find("th");
            headers.each(function () {
                const header = jQuery(this);
                header.off("click");
                header.on("click", function () {
                    const column = getColumn(header);
                    let currentSort = header.attr("data-sort");

                    headers.each(function () {
                        resetHeader(jQuery(this)); // Ensure this function exists
                    });

                    if (currentSort === "asc") {
                        sortByColumn(column, "desc");
                        setActiveHeader(header, "desc");
                    } else if (currentSort === "desc") {
                        resetSortOrder();
                    } else {
                        sortByColumn(column, "asc");
                        setActiveHeader(header, "asc");
                    }
                });
            });

            resetSortOrder();
        }

        function sortByColumn(column, order) {
            const rows = $table.find(".variation-row").toArray();
            rows.sort((a, b) => {
                let cellA, cellB;
                if (column === "sku") {
                    cellA = jQuery(a).find(".variable-sku").text().trim();
                    cellB = jQuery(b).find(".variable-sku").text().trim();
                    return order === "asc" ? cellA.localeCompare(cellB, undefined, { numeric: true }) : cellB.localeCompare(cellA, undefined, { numeric: true });
                } else if (column === "price") {
                    let salePriceA    = a.querySelector('.variable-sale-price')?.textContent.trim();
                    let regularPriceA = a.querySelector('.variable-price')?.textContent.trim();
                    let salePriceB    = b.querySelector('.variable-sale-price')?.textContent.trim();
                    let regularPriceB = b.querySelector('.variable-price')?.textContent.trim();

                    // Convert prices to numbers, prioritize sale price if available
                    cellA = parseFloat(salePriceA?.replace(/[^0-9.]/g, '') || regularPriceA?.replace(/[^0-9.]/g, '') || 0);
                    cellB = parseFloat(salePriceB?.replace(/[^0-9.]/g, '') || regularPriceB?.replace(/[^0-9.]/g, '') || 0);

                    // cellA = parseFloat(jQuery(a).find(".variable-price").text().replace(/[^0-9.-]+/g, "")) || 0;
                    // cellB = parseFloat(jQuery(b).find(".variable-price").text().replace(/[^0-9.-]+/g, "")) || 0;
                    return order === "asc" ? cellA - cellB : cellB - cellA;
                } else {
                    cellA = jQuery(a).find(`[data-attribute-name="${column}"]`).text().trim() || "";
                    cellB = jQuery(b).find(`[data-attribute-name="${column}"]`).text().trim() || "";
                    return order === "asc" ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
                }
            });

            rows.forEach(row => $table.append(row));
        }

        function getColumn(header) {
            const attributeSort = header.find("[data-attribute]").attr("data-attribute");
            if (attributeSort) {
                return attributeSort;
            }
            if (header.find("#sku-sort-arrows").length) {
                return "sku";
            }
            if (header.find("#price-sort-arrows").length) {
                return "price";
            }
            return null;
        }

        function setActiveHeader(header, order) {
            resetAllHeaders();
            header.attr("data-sort", order);
            const arrows = header.find(".dashicons");

            if (arrows.length > 1) {
                jQuery(arrows[0]).css("color", order === "asc" ? "#B2B2B2" : "#E5E5E5");
                jQuery(arrows[1]).css("color", order === "desc" ? "#B2B2B2" : "#E5E5E5");
            }
        }

        function resetAllHeaders() {
            $table.find("th").each(function () {
                jQuery(this).attr("data-sort", "none");
                jQuery(this).find(".dashicons").css("color", "#E5E5E5");
            });
        }

        function resetSortOrder() {
            sortByColumn("sku", "asc");
            const skuHeader = $table.find("#sku-sort-arrows").closest("th");
            if (skuHeader.length) {
                setActiveHeader(skuHeader, "asc");
            }
        }

        function resetHeader(header) {
            header.attr("data-sort", "none");
            header.find(".dashicons").css("color", "#E5E5E5");
        }

        function updateBulkCheckbox() {
            if (jQuery('.bulk_cart:checked').length > 0) {
                jQuery('.bulk-add-to-cart').show();
            } else {
                jQuery('.bulk-add-to-cart').hide();
            }
        }

        function resetCheckboxes() {
            jQuery('#bulk_checkbox_select_all').prop('checked', false);
            jQuery('.bulk_cart').prop('checked', false);
            updateBulkCheckbox();
        }

        jQuery('#bulk_checkbox_select_all').on('change', function () {
            var isChecked = jQuery(this).prop('checked');
            jQuery('.bulk_cart').prop('checked', isChecked);
            updateBulkCheckbox();
        });

        jQuery(document).on('change', '.bulk_cart', function () {
            var allChecked = jQuery('.bulk_cart').length === jQuery('.bulk_cart:checked').length;
            jQuery('#bulk_checkbox_select_all').prop('checked', allChecked);
            updateBulkCheckbox();
        });


        reapplySorting();

        // if ($table.length > 0) {
        //     loadPage(currentPage);
        // }
    });
</script>
