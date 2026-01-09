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
    $varimoDesignAddCartTableTemplate2    = isset($varimoVariableSetting['designAddCartTableTemplate2']) ? $varimoVariableSetting['designAddCartTableTemplate2'] : 'template_1';
    $varimoSelectAllNameChange            = isset($varimoVariableSetting['selectAllNameChange']) ? $varimoVariableSetting['selectAllNameChange'] : 'Select All';
    $varimoShowDoublePrice                = isset($varimoVariableSetting['showDoublePrice']) ? $varimoVariableSetting['showDoublePrice'] : 'true';
    $varimoStockStatusHideShow            = isset($varimoVariableSetting['stockStatusHideShow']) ? $varimoVariableSetting['stockStatusHideShow'] : 'true';
    $varimoQuickCartIcon                  = isset($varimoVariableSetting['quickCartIcon']) ? $varimoVariableSetting['quickCartIcon'] : 'fa fa-shopping-cart';
    $varimoQuickCartIconImageLink         = isset($varimoVariableSetting['quickCartIconImageLink']) ? $varimoVariableSetting['quickCartIconImageLink'] : '';
    $varimoPopUpImageShow                 = isset($varimoVariableSetting['popUPImageShow']) ? $varimoVariableSetting['popUPImageShow'] : 'thumbnail';
    $varimoShowGalleyImageIntoPopup       = isset($varimoVariableSetting['showGalleyImageIntoPopup']) ? $varimoVariableSetting['showGalleyImageIntoPopup'] : 'true';
    $varimoTableRowPagination             = isset($varimoVariableSetting['tableRowPagination']) ? $varimoVariableSetting['tableRowPagination'] : '5';
    $varimoNewMetaDataForVariationsTable  = isset($varimoVariableSetting['newMetaDataForVariationsTable']) ? $varimoVariableSetting['newMetaDataForVariationsTable'] : array();
    $varimoMetaTableTemplate2CartStyle    = get_post_meta($post->ID, '_table_template2_cart_section_style_template', true);
    $varimoMetaVariableTableTemplate      = get_post_meta($post->ID, '_variation_table_template', true);
    $varimo_variations                     = $product->get_available_variations();
    $varimo_variation_count                = count($varimo_variations);

    ?>
    <div class="template-two-table table-template-max-width alignwide">

        <div id="loading-spinner-pagination-table" style="display: none; text-align: center;">
            <i class="fa fa-spinner fa-spin "></i>
        </div>

        <table id="quick-variable-table" class="table-template2" data-pagination-table="<?php echo esc_attr($varimoTableRowPagination); ?>" data-Variation-count="<?php echo esc_attr($varimo_variation_count); ?>" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
            <tr style="width: 400px">
                <?php if ($varimoBulkSelectionHideShow === "true"){
                    ?>
                    <div >

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

                        <div style="display: inline-flex; align-items: baseline; gap: 10px ; margin-right: 10px; margin-left: 10px">
                            <input id="bulk_checkbox_select_all" type="checkbox"  name="" style="outline: none" >
                            <p for="stock_status" ><?php echo esc_html($varimoSelectAllNameChange); ?></p>
                        </div>

                        <?php if ($varimoOnSaleHideShow === "true"){
                            ?>
                            <div style="display: inline-flex; align-items: baseline; gap: 10px ; margin-right: 10px; margin-left: 10px">
                                <input id="stock_status" type="checkbox"  name=""  style="outline: none">
                                <p for="stock_status" ><?php echo esc_html($varimoOnSaleNameChange); ?></p>
                            </div>
                            <?php
                        }?>

                        <div style="display: inline-flex; align-items: baseline; gap: 10px; margin-right: 10px; margin-left: 10px">
                            <select id="sort-options" style="outline: none; border-radius: 3px">
                                <option value=""><?php  esc_html_e('Sort By', 'variation-monster-pro'); ?></option>
                                <option value="sku-asc"><?php  esc_html_e('SKU Asc', 'variation-monster-pro'); ?></option>
                                <option value="sku-desc"><?php  esc_html_e('SKU Desc', 'variation-monster-pro'); ?></option>
                                <option value="price-asc"><?php  esc_html_e('Price Asc', 'variation-monster-pro'); ?></option>
                                <option value="price-desc"><?php  esc_html_e('Price Desc', 'variation-monster-pro'); ?></option>

                                <?php
                                foreach ($varimo_all_attributes as $varimo_attribute_name => $varimo_attribute) {
                                    $varimo_label = wc_attribute_label($varimo_attribute_name);
                                    ?>
                                    <option value="<?php echo esc_attr($varimo_attribute_name); ?>-asc">
                                        <?php echo esc_html($varimo_label . ' Asc'); ?>
                                    </option>
                                    <option value="<?php echo esc_attr($varimo_attribute_name); ?>-desc">
                                        <?php echo esc_html($varimo_label . ' Desc'); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <?php if ($varimoSearchOptionHideShow === "true"){
                            ?>
                            <div class="search_option" style="display: inline-flex; align-items: baseline; gap: 10px; ">
                                <input class="variation-table-search" type="text" placeholder="<?php echo esc_html($varimoSearchOptionTextChange); ?>" name="search" id="variation-search">
                            </div>
                            <?php
                        }?>
                    </div>
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

                $priceA = $variationA->get_price();
                $priceB = $variationB->get_price();

                if ($priceA === false || $priceB === false) {
                    return 0;
                }

                return $priceA - $priceB;
            });


            foreach ($varimo_all_attributes as $varimo_attribute_name => $varimo_attribute) {
                usort($varimo_variations, function($a, $b) use ($varimo_attribute_name) {
                    $attrA = $a['attributes'][$varimo_attribute_name] ?? '';
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

                // Retrieve the gallery images.
                $varimo_gallery_images = get_post_meta($varimo_variation_id, '_variation_gallery_images', true);
                $varimo_image_ids      = $varimo_gallery_images ? explode(',', $varimo_gallery_images) : [];
                $varimo_thumbnail_id   = $varimo_variation->get_image_id();
                $varimo_stock_status   = $varimo_variation->is_on_sale();
                ?>
                <tr style=" margin: 10px; display: flex; " class="variation-row" data-variation-id="<?php echo esc_attr($varimo_variation_id); ?>" data-stock-status="<?php echo esc_attr($varimo_stock_status); ?>" data-gallery-images="<?php echo esc_attr(wp_json_encode($varimo_image_ids)); ?>">

                    <td class="table-template2-details-section" >
                        <?php if ($varimoBulkSelectionHideShow === "true"){ ?>
                            <input class="bulk_cart" style="outline: none" type="checkbox" id="bulk_cart_<?php echo esc_attr($varimo_variation_id); ?>" name="bulk_cart[]" value="<?php echo esc_attr($varimo_variation_id); ?>">
                        <?php }?>
                        <div>
                            <?php if ($varimoImageHideShow === "true") {
                                // nosemgrep
                                echo wp_get_attachment_image(
                                    $varimo_thumbnail_id,
                                    esc_attr($varimoPopUpImageShow),
                                    false,
                                    array(
                                        'alt' => esc_attr($varimo_variation->get_name()),
                                        'class' => 'gallery-trigger',
                                        'style' => 'cursor: pointer; ',
                                        'data-gallery-onoff' => esc_attr($varimoShowGalleyImageIntoPopup),
                                        'data-gallery' => esc_attr(wp_json_encode(array_map(function ($image_id) use ($varimoPopUpImageShow) {
                                            $image_size = in_array($varimoPopUpImageShow, ['thumbnail', 'medium', 'large', 'full']) ? $varimoPopUpImageShow : 'thumbnail';
                                            return wp_get_attachment_image_src($image_id, $image_size)[0] ?? '';
                                        }, $varimo_image_ids))),

                                    )
                                );
                            }?>
                        </div>

                        <div>
                            <?php if ($varimoAllAttributeHideShow === "true"){
                                foreach ($varimo_all_attributes as $varimo_attribute_name => $varimo_attribute) {
                                    $varimo_attribute_value = $varimo_variation->get_attribute($varimo_attribute_name);

                                    if (empty($varimo_attribute_value)) {
                                        echo "<div><select class='quick-attribute-select' name='attribute_" . esc_attr($varimo_attribute_name) . "' data-attribute-name='" . esc_attr($varimo_attribute_name) . "'>";
                                        if ($varimo_attribute->is_taxonomy()) {
                                            $varimo_options = wc_get_product_terms($product->get_id(), $varimo_attribute_name, ['fields' => 'names']);
                                        } else {
                                            $varimo_options = $varimo_attribute->get_options();
                                        }
                                        foreach ($varimo_options as $varimo_option) {
                                            echo "<option value='" . esc_attr($varimo_option) . "'>" . esc_html($varimo_option) . "</option>";
                                        }
                                        echo "</select></div>";
                                    } else {
                                        echo "<div  class='quick-variable-title quick-attribute-text'  data-attribute-name='" . esc_attr($varimo_attribute_name) . "' name='attribute_" . esc_attr($varimo_attribute_name) . "'>" . esc_html($varimo_attribute_value) . "</div>";
                                    }
                                }
                            } ?>
                        </div>

                        <div class="quick-variable-title variable-sku" style="max-width: 500px">
                            <?php if ($varimoTitleHideShow === "true"){ ?>
                                <div>
                                    <?php echo esc_html($varimo_variation->get_name()); ?>
                                </div>
                            <?php }?>

                            <?php if ($varimoSkuHideShow === "true"){ ?>
                                <div>
                                    <strong><?php esc_html_e('SKU: ', 'variation-monster-pro'); ?></strong> <?php echo esc_html($varimo_variation->get_sku()); ?>
                                </div>
                            <?php }

                            foreach ($varimoNewMetaDataForVariationsTable as $varimo_newMetaDataForVariation){
                                $varimo_label    =  $varimo_newMetaDataForVariation["value"];
                                $varimo_keyValue =  get_post_meta($varimo_variation_id, $varimo_newMetaDataForVariation["key"], true);
                                ?>
                                <div>
                                    <strong><?php echo esc_html($varimo_label); ?>:</strong> <?php echo esc_html($varimo_keyValue); ?>
                                </div>
                                <?php
                            }

                            if ($varimoWeightDimensionsHideShow === "true"){

                                $varimo_weight = $varimo_variation->get_weight();
                                if ($varimo_weight) {
                                    ?>
                                    <div>
                                        <strong><?php esc_html_e('Weight: ', 'variation-monster-pro'); ?></strong> <?php echo esc_html($varimo_weight) . ' ' . esc_html(get_option('woocommerce_weight_unit')); ?>
                                    </div>
                                <?php } ?>

                                <?php

                                $varimo_length = $varimo_variation->get_length();
                                $varimo_width  = $varimo_variation->get_width();
                                $varimo_height = $varimo_variation->get_height();

                                if ($varimo_length || $varimo_width || $varimo_height) {
                                    ?>
                                    <div>
                                        <strong><?php esc_html_e('Dimensions: ', 'variation-monster-pro'); ?></strong>
                                        <?php
                                        echo esc_html($varimo_length ? $varimo_length : '-') . ' x ' .
                                            esc_html($varimo_width ? $varimo_width : '-') . ' x ' .
                                            esc_html($varimo_height ? $varimo_height : '-') . ' ' .
                                            esc_html(get_option('woocommerce_dimension_unit'));
                                        ?>
                                    </div>
                                <?php }
                            } ?>

                            <div class="description-container">
                                <span class="truncated-description"><?php if ($varimoDescriptionHideShow ==='true'){ echo esc_html($varimo_variation->get_description()); } ?></span>
                            </div>
                            <?php
                            $varimo_full_description = $varimo_variation->get_description();
                            if ((!empty($varimo_variation->get_description()))  && ($varimoDescriptionHideShow ==='true')) : ?>
                                <div>
                                    <a href="#" class="load-more-description" data-description="<?php echo esc_attr($varimo_variation->get_description()); ?>">Load More</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>

                    <!-- Modal HTML Description -->
                    <div id="descriptionModal" class="modal">
                        <div class="modal-content">
                            <span class="close-modal">&times;</span>
                            <p id="fullDescriptionContent"></p>
                        </div>
                    </div>

                    <!-- Modal Variation Image Show -->
                    <?php if ($varimoShowPopUpImage === "true"){
                        ?>
                        <div class="popup-container">
                            <div class="popup-content">
                                <span class="close-btn">&times;</span>
                                <button style="outline: none; ma" id="prevImage" class="lightbox-nav prev">⟨</button>

                                <button style="outline: none" id="nextImage" class="lightbox-nav next">⟩</button>
                            </div>
                        </div>
                        <?php
                    }?>

                    <td class="table-template2-cart-section" >
                        <?php if ($varimoPriceHideShow === "true"){ ?>
                            <div class='variable-price quick-variable-title'><?php
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
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <?php
                        if ($varimoMetaTableTemplate2CartStyle === '' || $varimoMetaTableTemplate2CartStyle === 'none'){
                            if ($varimoDesignAddCartTableTemplate2 === 'template_1'){
                                if ($varimoQuantityHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                    ?>
                                    <div>
                                        <div class="quick-quantity-container" style="margin-bottom: 10px">
                                            <button onclick="varimoShopPageQuantityDecrease(this)" class="quick-quantity-decrease" id="decrease">-</button>
                                            <input  type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity ?: 99); ?>">
                                            <button onclick="varimoShopPageQuantityIncrese(this)" class="quick-quantity-increase" id="increase">+</button>
                                        </div>
                                        <div class="quick-cart-notification quick-hidden"></div>
                                    </div>
                                    <?php
                                }?>

                                <?php if ($varimoActionHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                    ?>
                                    <div class="stock-notification" style="padding-left: 25%; padding-right: 25%">
                                        <?php if (0 === ($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity)) : ?>
                                            <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                        <?php else : ?>
                                            <button style="width: 100%; text-align: center" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($varimo_variation_id); ?>">
                                                <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                                                    <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>"></span>
                                                <?php else: ?>
                                                    <i class="<?php echo esc_attr($varimoQuickCartIcon); ?>" aria-hidden="true"></i>
                                                <?php endif; ?>
                                                <span><?php echo esc_html($varimoCartButtonText); ?></span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                }
                            }elseif ($varimoDesignAddCartTableTemplate2 === 'template_2'){
                                ?>
                                <div style="display: flex; gap: 10px; align-items: center; justify-content: center; margin-top: 15px ; margin-bottom: 15px">
                                    <?php if ($varimoQuantityHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                        ?>
                                        <div>
                                            <div class="quick-quantity-container" style="gap: 0 !important; margin-top: 0 !important;">
                                                <button style="border-top-left-radius: 50%;   border-bottom-left-radius: 50%; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;" class="quick-quantity-decrease" onclick="varimoShopPageQuantityDecrease(this)" id="decrease">-</button>
                                                <input style="border-radius: 0 !important;" type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity ?: 99); ?>">
                                                <button style="border-top-right-radius: 50%;   border-bottom-right-radius: 50%; border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" class="quick-quantity-increase" onclick="varimoShopPageQuantityIncrese(this)" id="increase">+</button>
                                            </div>
                                            <div class="quick-cart-notification quick-hidden"></div>
                                        </div>
                                        <?php
                                    }?>

                                    <?php if ($varimoActionHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                        ?>
                                        <div class="stock-notification">
                                            <?php if (0 === ($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity)) : ?>
                                                <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                            <?php else : ?>
                                                <button style="text-align: center; border-radius: 50%; height: 28px; width: 28px" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($varimo_variation_id); ?>">
                                                    <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                                                        <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>"></span>
                                                    <?php else: ?>
                                                        <i class="<?php echo esc_attr($varimoQuickCartIcon); ?>" aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <?php
                                    }?>
                                </div>
                                <?php
                            }
                        }else{
                            if ($varimoMetaVariableTableTemplate === '' || $varimoMetaVariableTableTemplate === 'none'){
                                if ($varimoDesignAddCartTableTemplate2 === 'template_1'){
                                    if ($varimoQuantityHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                        ?>
                                        <div>
                                            <div class="quick-quantity-container" style="margin-bottom: 10px">
                                                <button class="quick-quantity-decrease" onclick="varimoShopPageQuantityDecrease(this)" id="decrease">-</button>
                                                <input  type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity ?: 99); ?>">
                                                <button class="quick-quantity-increase" onclick="varimoShopPageQuantityIncrese(this)" id="increase">+</button>
                                            </div>
                                            <div class="quick-cart-notification quick-hidden"></div>
                                        </div>
                                        <?php
                                    }?>

                                    <?php if ($varimoActionHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                        ?>
                                        <div class="stock-notification" style="padding-left: 25%; padding-right: 25%">
                                            <?php if (0 === ($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity)) : ?>
                                                <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                            <?php else : ?>
                                                <button style="width: 100%; text-align: center" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($varimo_variation_id); ?>">
                                                    <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                                                        <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>"></span>
                                                    <?php else: ?>
                                                        <i class="<?php echo esc_attr($varimoQuickCartIcon); ?>" aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                    <span><?php echo esc_html($varimoCartButtonText); ?></span>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <?php
                                    }
                                }elseif ($varimoDesignAddCartTableTemplate2 === 'template_2'){
                                    ?>
                                    <div style="display: flex; gap: 10px; align-items: center; justify-content: center; margin-top: 15px ; margin-bottom: 15px">
                                        <?php if ($varimoQuantityHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                            ?>
                                            <div>
                                                <div class="quick-quantity-container" style="gap: 0 !important; margin-top: 0 !important;">
                                                    <button style="border-top-left-radius: 50%;   border-bottom-left-radius: 50%; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;" class="quick-quantity-decrease" onclick="varimoShopPageQuantityDecrease(this)" id="decrease">-</button>
                                                    <input style="border-radius: 0 !important;" type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity ?: 99); ?>">
                                                    <button style="border-top-right-radius: 50%;   border-bottom-right-radius: 50%; border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" class="quick-quantity-increase" onclick="varimoShopPageQuantityIncrese(this)" id="increase">+</button>
                                                </div>
                                                <div class="quick-cart-notification quick-hidden"></div>
                                            </div>
                                            <?php
                                        }?>

                                        <?php if ($varimoActionHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                            ?>
                                            <div class="stock-notification">
                                                <?php if (0 === ($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity)) : ?>
                                                    <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                                <?php else : ?>
                                                    <button style="text-align: center; border-radius: 50%; height: 28px; width: 28px" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($varimo_variation_id); ?>">
                                                        <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                                                            <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>"></span>
                                                        <?php else: ?>
                                                            <i class="<?php echo esc_attr($varimoQuickCartIcon); ?>" aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                        }?>
                                    </div>
                                    <?php
                                }
                            }else{
                                if ($varimoMetaTableTemplate2CartStyle === 'template_1'){
                                    if ($varimoQuantityHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                        ?>
                                        <div>
                                            <div class="quick-quantity-container" style="margin-bottom: 10px">
                                                <button class="quick-quantity-decrease" onclick="varimoShopPageQuantityDecrease(this)" id="decrease">-</button>
                                                <input  type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity ?: 99); ?>">
                                                <button class="quick-quantity-increase" onclick="varimoShopPageQuantityIncrese(this)" id="increase">+</button>
                                            </div>
                                            <div class="quick-cart-notification quick-hidden"></div>
                                        </div>
                                        <?php
                                    }?>

                                    <?php if ($varimoActionHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                        ?>
                                        <div class="stock-notification" style="padding-left: 25%; padding-right: 25%">
                                            <?php if (0 === ($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity)) : ?>
                                                <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                            <?php else : ?>
                                                <button style="width: 100%; text-align: center" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($varimo_variation_id); ?>">
                                                    <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                                                        <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>"></span>
                                                    <?php else: ?>
                                                        <i class="<?php echo esc_attr($varimoQuickCartIcon); ?>" aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                    <span><?php echo esc_html($varimoCartButtonText); ?></span>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <?php
                                    }
                                }elseif ($varimoMetaTableTemplate2CartStyle === 'template_2'){
                                    ?>
                                    <div style="display: flex; gap: 10px; align-items: center; justify-content: center; margin-top: 15px ; margin-bottom: 15px">
                                        <?php if ($varimoQuantityHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                            ?>
                                            <div>
                                                <div class="quick-quantity-container" style="gap: 0 !important; margin-top: 0 !important;">
                                                    <button style="border-top-left-radius: 50%;   border-bottom-left-radius: 50%; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;" class="quick-quantity-decrease" onclick="varimoShopPageQuantityDecrease(this)" id="decrease">-</button>
                                                    <input style="border-radius: 0 !important;" type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity ?: 99); ?>">
                                                    <button style="border-top-right-radius: 50%;   border-bottom-right-radius: 50%; border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" class="quick-quantity-increase" onclick="varimoShopPageQuantityIncrese(this)" id="increase">+</button>
                                                </div>
                                                <div class="quick-cart-notification quick-hidden"></div>
                                            </div>
                                            <?php
                                        }?>

                                        <?php if ($varimoActionHideShow === "true" && $varimo_variation->get_stock_status() !== "outofstock"){
                                            ?>
                                            <div class="stock-notification">
                                                <?php if (0 === ($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity)) : ?>
                                                    <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                                <?php else : ?>
                                                    <button style="text-align: center; border-radius: 50%; height: 28px; width: 28px" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($varimo_variation_id); ?>">
                                                        <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                                                            <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>"></span>
                                                        <?php else: ?>
                                                            <i class="<?php echo esc_attr($varimoQuickCartIcon); ?>" aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                        }?>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <div><?php
                            if ($varimo_variation->get_stock_status() === "outofstock"){
                                ?>
                                <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                    <?php
                            }else{
                                if ($varimoStockStatusHideShow === 'true'){
                                    ?>
                                    <p><?php esc_html_e('In Stock', 'variation-monster-pro'); ?></p>
                                    <?php
                                }
                        }?></div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>

        <?php if ($varimoBulkAddToCartPosition === "after"  || $varimoBulkAddToCartPosition === "both"){
            ?>
            <button  class="bulk-add-to-cart"  id="bulk-add-to-cart" data-carticon="<?php echo esc_attr($varimoQuickCartIcon ?: 'fa-cart-plus'); ?>" data-productId="<?php echo esc_attr($product->get_id()); ?>"  style="border-radius: 5px ; outline: none; display: none; margin-bottom: 10px;">
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

        <!-- Pagination Controls -->
        <div class="pagination-controls">
            <button id="prev-btn" style="margin-right: 10px;" disabled><?php esc_html_e('Previous', 'variation-monster-pro'); ?></button>
            <button id="next-btn"><?php esc_html_e('Next', 'variation-monster-pro'); ?></button>
        </div>
    </div>
    <?php
}
?>

<script>
    jQuery(document).ready(function ($) {
        var $table        = jQuery("#quick-variable-table");
        const rowsPerPage = $table.data('pagination-table') || 5;
        const totalRows   = $table.data('variation-count');
        var currentPage   = 1;
        var totalPages    = 1;
        var productId     = $table.data('product-id');

        if (totalRows <= rowsPerPage) {
            jQuery(".pagination-controls").hide();
        }

        function loadPage(page) {
            jQuery.ajax({
                url: quick_front_ajax_obj.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_more_variations_table_template_two',
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
            jQuery("#prev-btn").prop("disabled", currentPage === 1);
            jQuery("#next-btn").prop("disabled", currentPage === totalPages);
            jQuery("#pageInfo").text(`Page ${currentPage} of ${totalPages}`);
        }

        jQuery("#prev-btn").click(function () {

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

        jQuery("#next-btn").click(function () {

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

        // Add sorting functionality
        function reapplySorting(){
            const sortSelect = document.getElementById('sort-options');
            const table = document.getElementById("quick-variable-table");
            if (!table) {
                return;
            }
            const rows = Array.from(table.querySelectorAll(".variation-row"));

            if (sortSelect) {
                sortSelect.addEventListener('change', function () {
                    const selectedOption = this.value;

                    if (selectedOption) {
                        console.log("work")
                        const [type, direction] = selectedOption.split('-');
                        sortTable(type, direction);
                    }
                });
            }
        }


        // Function to sort the table
        function sortTable(type, direction) {
            const rows = $table.find(".variation-row").toArray();
            const table = document.getElementById("quick-variable-table");
            rows.sort((a, b) => {
                let valueA, valueB;

                if (type === 'sku') {
                    valueA = a.querySelector('.variable-sku div').textContent.trim();
                    valueB = b.querySelector('.variable-sku div').textContent.trim();
                } else if (type === 'price') {
                    let salePriceA    = a.querySelector('.variable-sale-price')?.textContent.trim();
                    let regularPriceA = a.querySelector('.variable-price')?.textContent.trim();
                    let salePriceB    = b.querySelector('.variable-sale-price')?.textContent.trim();
                    let regularPriceB = b.querySelector('.variable-price')?.textContent.trim();

                    // Convert prices to numbers, prioritize sale price if available
                    valueA = parseFloat(salePriceA?.replace(/[^0-9.]/g, '') || regularPriceA?.replace(/[^0-9.]/g, '') || 0);
                    valueB = parseFloat(salePriceB?.replace(/[^0-9.]/g, '') || regularPriceB?.replace(/[^0-9.]/g, '') || 0);
                } else {
                    // Attribute sorting
                    valueA = a.querySelector(`[data-attribute-name="${type}"]`)?.textContent.trim() || "";
                    valueB = b.querySelector(`[data-attribute-name="${type}"]`)?.textContent.trim() || "";
                }

                if (direction === 'asc') {
                    return valueA > valueB ? 1 : -1;
                } else {
                    return valueA < valueB ? 1 : -1;
                }
            });

            // Reorder rows in the table
            rows.forEach(row => table.appendChild(row));
        }

        reapplySorting();

        // if ($table.length > 0) {
        //     loadPage(currentPage);
        // }
    });
</script>
