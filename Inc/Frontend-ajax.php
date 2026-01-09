<?php
if (!defined('ABSPATH')) exit;

add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'varimo_ajax_add_to_cart_handler');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'varimo_ajax_add_to_cart_handler');

add_action('wp_ajax_bulk_add_to_cart', 'varimo_handle_bulk_add_to_cart');
add_action('wp_ajax_nopriv_bulk_add_to_cart', 'varimo_handle_bulk_add_to_cart');

add_action('wp_ajax_add_variation_to_cart', 'varimo_add_variation_to_cart');
add_action('wp_ajax_nopriv_add_variation_to_cart', 'varimo_add_variation_to_cart');

add_action('wp_ajax_variation_table_before_add_to_cart', 'varimo_variation_table_before_add_to_cart');
add_action('wp_ajax_nopriv_variation_table_before_add_to_cart', 'varimo_variation_table_before_add_to_cart');

add_action('wp_ajax_load_more_variations', 'varimo_more_variations');
add_action('wp_ajax_nopriv_load_more_variations', 'varimo_more_variations');

add_action('wp_ajax_load_more_variations_table_template_two', 'varimo_more_variations_table_template_two');
add_action('wp_ajax_nopriv_load_more_variations_table_template_two', 'varimo_more_variations_table_template_two');

add_action('wp_ajax_load_more_variations_list_template_one', 'varimo_more_variations_list_template_one');
add_action('wp_ajax_nopriv_load_more_variations_list_template_one', 'varimo_more_variations_list_template_one');

add_action('wp_ajax_load_more_variations_list_template_two', 'varimo_more_variations_list_template_two');
add_action('wp_ajax_nopriv_load_more_variations_list_template_two', 'varimo_more_variations_list_template_two');

/**
 * Table template 1 pagination ajax.
 *
 * @since 1.0.0
 * @return void
 */
function varimo_variation_table_before_add_to_cart() {

    if (!isset($_POST['pagination_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['pagination_nonce'])), 'woocommerce_ajax_add_to_cart')) {
        wp_send_json_error(['message' => 'Invalid nonce.']);
    }

    global $post;
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $page       = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $product    = wc_get_product($product_id);
    if (!$product || !$product->is_type('variable')) {
        wp_send_json_error('Invalid product');
    }

    $enable_global_stock_management = $product->get_manage_stock();
    $global_stock_quantity          = $enable_global_stock_management ? $product->get_stock_quantity() : null;
    $all_attributes                 = $product->get_attributes();
    $variableSetting                = get_option('variable_all_checked', array());
    $bulkSelectionHideShow          = isset($variableSetting['bulkSelectionHideShow']) ? $variableSetting['bulkSelectionHideShow'] : 'true';
    $imageHideShow                  = isset($variableSetting['imageHideShow']) ? $variableSetting['imageHideShow'] : 'true';
    $skuHideShow                    = isset($variableSetting['skuHideShow']) ? $variableSetting['skuHideShow'] : 'true';
    $allAttributeHideShow           = isset($variableSetting['allAttributeHideShow']) ? $variableSetting['allAttributeHideShow'] : 'true';
    $priceHideShow                  = isset($variableSetting['priceHideShow']) ? $variableSetting['priceHideShow'] : 'true';
    $quantityHideShow               = isset($variableSetting['quantityHideShow']) ? $variableSetting['quantityHideShow'] : 'true';
    $actionHideShow                 = isset($variableSetting['actionHideShow']) ? $variableSetting['actionHideShow'] : 'true';
    $cartButtonText                 = isset($variableSetting['cartButtonText']) ? $variableSetting['cartButtonText'] : 'Add-to-cart';
    $showPopUpImage                 = isset($variableSetting['showPopUpImage']) ? $variableSetting['showPopUpImage'] : 'true';
    $showDoublePrice                = isset($variableSetting['showDoublePrice']) ? $variableSetting['showDoublePrice'] : 'true';
    $quickCartIcon                  = isset($variableSetting['quickCartIcon']) ? $variableSetting['quickCartIcon'] : 'fa fa-shopping-cart';
    $quickCartIconImageLink         = isset($variableSetting['quickCartIconImageLink']) ? $variableSetting['quickCartIconImageLink'] : '';
    $popUPImageShow                 = isset($variableSetting['popUPImageShow']) ? $variableSetting['popUPImageShow'] : 'thumbnail';
    $showGalleyImageIntoPopup       = isset($variableSetting['showGalleyImageIntoPopup']) ? $variableSetting['showGalleyImageIntoPopup'] : 'true';
    $per_page                       = isset($variableSetting['tableRowPagination']) ? $variableSetting['tableRowPagination'] : '5';
    $variations                     = $product->get_available_variations();
    $total_variations               = count($variations);
    $total_pages                    = ceil($total_variations / $per_page);
    $offset                         = ($page - 1) * $per_page;
    $current_variations             = array_slice($variations, $offset, $per_page);

    ob_start();

    $variations = $product->get_available_variations();

    usort($variations, function($a, $b) {

        $variationA = new WC_Product_Variation($a['variation_id']);
        $variationB = new WC_Product_Variation($b['variation_id']);
        $priceA     = $variationA->get_price();
        $priceB     = $variationB->get_price();

        if ($priceA === false || $priceB === false) {
            return 0;
        }
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
        return $priceA - $priceB;
    });

    foreach ($all_attributes as $attribute_name => $attribute) {
        usort($variations, function($a, $b) use ($attribute_name) {

            $attrA = $a['attributes'][$attribute_name] ?? '';
            $attrB = $b['attributes'][$attribute_name] ?? '';
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
            return strcmp($attrA, $attrB);
        });
    }

    $variations_for_pagination = $product->get_available_variations();

    foreach ($current_variations as $var) {
        $variation_id             = $var['variation_id'];
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
        $variation                = new WC_Product_Variation($variation_id);
        $variation_stock_quantity = $variation->get_manage_stock() ? $variation->get_stock_quantity() : null;

        $gallery_images = get_post_meta($variation_id, '_variation_gallery_images', true);
        $image_ids      = $gallery_images ? explode(',', $gallery_images) : [];
        $thumbnail_id   = $variation->get_image_id();
        $thumbnail_url  = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, "thumbnail") : '';
        $stock_status_before_cart   = $variation->is_on_sale();
        ?>
        <tr class="variation-row-before-cart" data-variation-id="<?php echo esc_attr($variation_id); ?>" data-stock-status="<?php echo esc_attr($stock_status_before_cart); ?>" data-gallery-images="<?php echo esc_attr(wp_json_encode($image_ids)); ?>">
            <?php if ($bulkSelectionHideShow === "true"){
                if (($variation->is_purchasable()) && ($variation->is_in_stock())){
                    ?>
                    <td style="padding: 20px; text-align: center">
                        <input class="bulk_cart_before_add_to_cart" style="outline: none" type="checkbox" id="bulk_cart_before_add_to_cart_before_add_to_cart_<?php echo esc_attr($variation_id); ?>" name="bulk_cart_before_add_to_cart[]" value="<?php echo esc_attr($variation_id); ?>">
                    </td>
                    <?php
                }else{
                    ?>
                    <td>
                        <span style="font-size: 11px; color: red; margin: 0; padding: 0"> <?php esc_html_e('Out of Stock', 'variation-monster-pro'); ?> </span>
                    </td>
                    <?php
                }
            }

            if ($allAttributeHideShow === "true"){
                foreach ($all_attributes as $attribute_name => $attribute) {
                    $attribute_value = $variation->get_attribute($attribute_name);

                    if (empty($attribute_value)) {
                        echo "<td><select class='quick-attribute-select' name='attribute_" . esc_attr($attribute_name) . "' data-attribute-name='" . esc_attr($attribute_name) . "'>";

                        if ($attribute->is_taxonomy()) {
                            $options = wc_get_product_terms($product->get_id(), $attribute_name, ['fields' => 'names']);
                        } else {
                            $options = $attribute->get_options();
                        }

                        foreach ($options as $option) {
                            echo "<option value='" . esc_attr($option) . "'>" . esc_html($option) . "</option>";
                        }

                        echo "</select></td>";
                    } else {

                        echo "<td  class='quick-variable-title quick-attribute-text'  data-attribute-name='" . esc_attr($attribute_name) . "' name='attribute_" . esc_attr($attribute_name) . "'>" . esc_html($attribute_value) . "</td>";
                    }
                }
            }
            ?>

            <?php if ($priceHideShow === "true"){
                ?>
                <td class='variable-price quick-variable-title'><?php
                    if ($showDoublePrice === 'true'){
                        $price_html = $variation->get_price_html();
                        echo $price_html ? wp_kses_post($price_html) : ''; // nosemgrep
                    }else{
                        $sale_price = $variation->get_sale_price();
                        if($sale_price) {
                            echo $sale_price ? wp_kses_post(wc_price($sale_price)) : ''; // nosemgrep
                        } else {
                            $regular_price_html = $variation->get_regular_price();
                            echo $regular_price_html ? wp_kses_post(wc_price($regular_price_html)) : ''; // nosemgrep
                        }
                    }
                    $sale_price_available_sorting = $variation->get_sale_price();
                    if ($sale_price_available_sorting){
                        ?>
                        <span class="variable-sale-price" style="display: none">
                            <?php
                            echo $sale_price_available_sorting ?  wp_kses_post(wc_price($sale_price_available_sorting)) : ''; // nosemgrep
                            ?>
                        </span>
                    <?php }
                    ?></td>
                <?php
            }?>

            <?php if ($quantityHideShow === "true"){
                ?>
                <td>
                    <div class="quick-quantity-container" style="margin-bottom: 10px">
                        <input  type="number" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($variation_stock_quantity ?: $global_stock_quantity ?: 99); ?>">
                    </div>
                    <div class="quick-cart-notification quick-hidden"></div>
                </td>
                <?php
            }?>

        </tr>
        <?php
    }
    $html = ob_get_clean();

    wp_send_json_success([
        'html' => $html,
        'total_pages' => $total_pages,
        'current_page' => $page,
    ]);
}


/**
 * List template 2 pagination ajax.
 *
 * @since 1.0.0
 *
 * @return void
 */

function varimo_more_variations_list_template_two(){

    if (!isset($_POST['pagination_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['pagination_nonce'])), 'woocommerce_ajax_add_to_cart')) {
        wp_send_json_error(['message' => 'Invalid nonce.']);
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $page       = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $product    = wc_get_product($product_id);
    if (!$product || !$product->is_type('variable')) {
        wp_send_json_error('Invalid product');
    }

    $variableSetting            = get_option('variable_all_checked', array());
    $listLabelOnOff             = isset($variableSetting['listLabelOnOff']) ? $variableSetting['listLabelOnOff'] : '';
    $listSkuOnOff               = isset($variableSetting['listSkuOnOff']) ? $variableSetting['listSkuOnOff'] : '';
    $listPriceOnOff             = isset($variableSetting['listPriceOnOff']) ? $variableSetting['listPriceOnOff'] : '';
    $listQuantityOnOff          = isset($variableSetting['listQuantityOnOff']) ? $variableSetting['listQuantityOnOff'] : '';
    $listBadgeShowOnOff         = isset($variableSetting['listBadgeShowOnOff']) ? $variableSetting['listBadgeShowOnOff'] : '';
    $listBadgeDiscountFlatPrice = isset($variableSetting['listBadgeDiscountFlatPrice']) ? $variableSetting['listBadgeDiscountFlatPrice'] : '';
    $listAttributeShow          = isset($variableSetting['listAttributeShow']) ? $variableSetting['listAttributeShow'] : '';
    $listTitleShow              = isset($variableSetting['listTitleShow']) ? $variableSetting['listTitleShow'] : '';
    $listForPercent             = isset($variableSetting['listForPercent']) ? $variableSetting['listForPercent'] : '% OFF';
    $listForFlat                = isset($variableSetting['listForFlat']) ? $variableSetting['listForFlat'] : 'OFF';
    $listImageShow              = isset($variableSetting['listImageShow']) ? $variableSetting['listImageShow'] : 'thumbnail';
    $listPagination             = isset($variableSetting['listPagination']) ? $variableSetting['listPagination'] : '3';
    $attributes                 = $product->get_variation_attributes();
    $variations                 = $product->get_available_variations();
    $total_variations           = count($variations);
    $total_pages                = ceil($total_variations / $listPagination);
    $offset                     = ($page - 1) * $listPagination;
    $current_variations         = array_slice($variations, $offset, $listPagination);

    ob_start();

    $variations = $product->get_available_variations();

    foreach ($current_variations as $variation) :
        $variation_obj       = wc_get_product($variation['variation_id']);
        $thumbnail_id        = $variation_obj->get_image_id();
        $regular_price       = floatval($variation_obj->get_regular_price());
        $sale_price          = floatval($variation_obj->get_sale_price());
        $discount_percentage = 0;
        $discount_flat       = 0;

        if ($sale_price && $regular_price && $regular_price > $sale_price) {
            $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
            $discount_flat = ($regular_price - $sale_price) ;
        }
        ?>
        <li class="variation-item" data-variation-id="<?php echo esc_attr($variation['variation_id']); ?>"
            data-attributes="<?php echo esc_attr(json_encode($variation['attributes'])); ?>"
            data-variations="<?php echo esc_attr(json_encode($variations)); ?>">

            <?php if($listBadgeShowOnOff === "true"){
                ?>
                <div class="badge-container">
                    <?php if ($discount_percentage > 0) : ?>
                        <?php if ($listBadgeDiscountFlatPrice === "true"){
                            ?>
                            <span class="sale-badge"><?php echo  wp_kses_post(wc_price($discount_flat)) . esc_attr($listForFlat) ; ?> </span>
                            <?php
                        }else{
                            ?>
                            <span class="sale-badge"><?php echo esc_html($discount_percentage) . esc_attr($listForPercent); ?></span>
                            <?php
                        }?>
                    <?php endif; ?>
                </div>
                <?php
            }?>

            <label >
                <span class="variation-details" >
                    <!-- Display Variation Image -->
                    <span class="variation-image">
                        <?php
                        if ($thumbnail_id) {
                            // nosemgrep
                            echo wp_get_attachment_image(
                                $thumbnail_id, $listImageShow, false,
                                array(
                                    'alt' => esc_attr($variation_obj->get_name()),
                                    'class' => 'gallery-trigger',
                                    'style' => 'cursor: pointer; ',
                                )
                            );
                        } else {
                            // nosemgrep
                            echo wp_get_attachment_image(
                                $product->get_image_id(), $listImageShow, false,
                                array(
                                    // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
                                    'alt' => esc_attr($product->get_name()),
                                    'class' => 'gallery-trigger',
                                    'style' => 'cursor: pointer; ',
                                )
                            );
                        }
                        ?>
                    </span>

                    <!-- Title Label -->
                    <span class="variation-price" >
                        <span><?php
                            if ($listTitleShow === "true"){
                                echo wp_kses_post($variation_obj->get_name()); // nosemgrep
                            } ?></span>
                    </span>

                    <!-- SKU Label -->
                    <span class="variation-price" >
                        <strong><?php if ($listLabelOnOff === "true" && $listSkuOnOff === "true"){
                                esc_html_e('SKU: ', 'variation-monster-pro');
                            } ?></strong>
                        <span><?php if ($listSkuOnOff === "true"){
                            echo wp_kses_post($variation_obj->get_sku()); // nosemgrep
                        } ?></span>
                    </span>

                    <!-- Display Attribute and Dropdown -->
                    <?php foreach ($attributes as $attribute_name => $options) :
                        $value = isset($variation['attributes']['attribute_' . $attribute_name]) ? $variation['attributes']['attribute_' . $attribute_name] : '';

                        if (taxonomy_exists($attribute_name)) {
                            $term = get_term_by('slug', $value, $attribute_name);
                            if ($term) {
                                $value = $term->name;
                            }
                        } else {
                            $custom_key = 'attribute_' . strtolower($attribute_name);
                            if (isset($variation['attributes'][$custom_key])) {
                                $value = $variation['attributes'][$custom_key];
                            }

                            // Populate $options for custom attributes

                            $product_attributes = get_post_meta($product->get_id(), '_product_attributes', true);
                            if (isset($product_attributes[$attribute_name])) {
                                $options = explode('|', $product_attributes[$attribute_name]['value']);
                                $options = array_map('trim', $options);

                            }
                        }

                        ?>

                        <?php if ($listAttributeShow === "true"){
                        ?>
                        <span class="variation-attribute" >
                            <strong><?php  if ($listLabelOnOff === "true"){
                                    // nosemgrep: audit.php.wp.security.xss.unescaped-stored-option
                                    echo wp_kses_post(wc_attribute_label($attribute_name)). ": ";
                                } ?> </strong>
                            <?php if ($value) : ?>
                                <?php echo esc_html($value); ?>
                            <?php else : ?>
                                <span class="attribute-select-wrapper-custom" >
                                    <select name="attribute_<?php echo esc_attr($attribute_name); ?>" class="attribute-select">
                                        <?php foreach ($options as $option) : ?>
                                            <option data-variation-id="<?php echo esc_attr($variation['variation_id']); ?>" value="<?php echo esc_attr($option); ?>">
                                                <?php echo esc_html($option); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </span>
                            <?php endif; ?>
                        </span>
                    <?php } endforeach; ?>

                    <!-- Price Label -->
                    <span class="variation-price" >
                        <strong><?php if ($listLabelOnOff === "true" && $listPriceOnOff === "true"){
                                esc_html_e('Price: ', 'variation-monster-pro');
                            } ?></strong>
                        <span><?php if ($listPriceOnOff === "true"){
                            echo wp_kses_post($variation_obj->get_price_html()); // nosemgrep
                        } ?></span>
                    </span>

                    <!-- Quantity Label -->
                    <?php if ($variation_obj->get_stock_quantity()  ) {
                        ?>
                        <span class="variation-price" >
                            <strong><?php if ($listLabelOnOff === "true" && $listQuantityOnOff === "true"){
                                    esc_html_e('Quantity: ', 'variation-monster-pro');
                                } ?></strong>
                            <span><?php if ($listQuantityOnOff === "true"){
                                echo wp_kses_post($variation_obj->get_stock_quantity()); // nosemgrep
                            } ?></span>
                        </span>
                    <?php }?>
                </span>
            </label>
        </li>
    <?php
    endforeach;

    $html = ob_get_clean();

    wp_send_json_success([
        'html' => $html,
        'total_pages' => $total_pages,
        'current_page' => $page,
    ]);

}

/**
 * List template 1 pagination ajax.
 *
 * @since 1.0.0
 * @return void
 */

function varimo_more_variations_list_template_one(){

    if (!isset($_POST['pagination_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['pagination_nonce'])), 'woocommerce_ajax_add_to_cart')) {
        wp_send_json_error(['message' => 'Invalid nonce.']);
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $page       = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $product    = wc_get_product($product_id);
    if (!$product || !$product->is_type('variable')) {
        wp_send_json_error('Invalid product');
    }

    $variableSetting            = get_option('variable_all_checked', array());
    $listLabelOnOff             = isset($variableSetting['listLabelOnOff']) ? $variableSetting['listLabelOnOff'] : '';
    $listSkuOnOff               = isset($variableSetting['listSkuOnOff']) ? $variableSetting['listSkuOnOff'] : '';
    $listPriceOnOff             = isset($variableSetting['listPriceOnOff']) ? $variableSetting['listPriceOnOff'] : '';
    $listQuantityOnOff          = isset($variableSetting['listQuantityOnOff']) ? $variableSetting['listQuantityOnOff'] : '';
    $listBadgeShowOnOff         = isset($variableSetting['listBadgeShowOnOff']) ? $variableSetting['listBadgeShowOnOff'] : '';
    $listBadgeDiscountFlatPrice = isset($variableSetting['listBadgeDiscountFlatPrice']) ? $variableSetting['listBadgeDiscountFlatPrice'] : '';
    $listAttributeShow          = isset($variableSetting['listAttributeShow']) ? $variableSetting['listAttributeShow'] : '';
    $listTitleShow              = isset($variableSetting['listTitleShow']) ? $variableSetting['listTitleShow'] : '';
    $listForPercent             = isset($variableSetting['listForPercent']) ? $variableSetting['listForPercent'] : '% OFF';
    $listForFlat                = isset($variableSetting['listForFlat']) ? $variableSetting['listForFlat'] : 'OFF';
    $listImageShow              = isset($variableSetting['listImageShow']) ? $variableSetting['listImageShow'] : 'thumbnail';
    $listPagination             = isset($variableSetting['listPagination']) ? $variableSetting['listPagination'] : '3';
    $attributes                 = $product->get_variation_attributes();
    $variations                 = $product->get_available_variations();
    $total_variations           = count($variations);
    $total_pages                = ceil($total_variations / $listPagination);
    $offset                     = ($page - 1) * $listPagination;
    $current_variations         = array_slice($variations, $offset, $listPagination);

    ob_start();

    $variations = $product->get_available_variations();

    foreach ($current_variations as $variation) :
        $variation_obj       = wc_get_product($variation['variation_id']);
        $thumbnail_id        = $variation_obj->get_image_id();
        $regular_price       = floatval($variation_obj->get_regular_price());
        $sale_price          = floatval($variation_obj->get_sale_price());
        $discount_percentage = 0;
        $discount_flat       = 0;

        if ($sale_price && $regular_price && $regular_price > $sale_price) {
            $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
            $discount_flat = ($regular_price - $sale_price) ;
        }
        ?>

        <li class="variation-item" data-variation-id="<?php echo esc_attr($variation['variation_id']); ?>"
            data-attributes="<?php echo esc_attr(json_encode($variation['attributes'])); ?>"
            data-variations="<?php echo esc_attr(json_encode($variations)); ?>">

            <?php if($listBadgeShowOnOff === "true"){
                ?>
                <div class="badge-container">

                    <?php if ($discount_percentage > 0) : ?>
                        <?php if ($listBadgeDiscountFlatPrice === "true"){
                            ?>
                            <span class="sale-badge"><?php // nosemgrep: audit.php.wp.security.xss.unescaped-stored-option
                                echo  wp_kses_post(wc_price($discount_flat)) . esc_attr($listForFlat) ; ?> </span>
                            <?php
                        }else{
                            ?>
                            <span class="sale-badge"><?php echo esc_html($discount_percentage) . esc_attr($listForPercent); ?></span>
                            <?php
                        }?>
                    <?php endif; ?>
                </div>
                <?php
            }?>

            <label style="display: flex; align-items: center; justify-content: center">
                <input type="radio" name="custom_variation"
                       value="<?php echo esc_attr($variation['variation_id']); ?>"
                       class="variation-select-radio">

                <!-- Display Variation Image -->
                <span class="variation-image" style="margin-left: 10px">
                                <?php
                                if ($thumbnail_id) {
                                    // nosemgrep
                                    echo wp_get_attachment_image(
                                        absint($thumbnail_id), sanitize_text_field($listImageShow), false,
                                        array(
                                            'alt' => esc_attr($variation_obj->get_name()),
                                            'class' => 'gallery-trigger',
                                            'style' => 'cursor: pointer; margin-right: 15px;',
                                        )
                                    );
                                } else {
                                    // nosemgrep
                                    echo wp_get_attachment_image(
                                        $product->get_image_id(), sanitize_text_field($listImageShow), false,
                                        array(
                                            'alt' => esc_attr($product->get_name()),
                                            'class' => 'gallery-trigger',
                                            'style' => 'cursor: pointer; margin-right: 15px;',
                                        )
                                    );
                                }
                                ?>
                        </span>

                <span class="variation-details" style="display: flex; justify-content: center;">
                    <!-- SKU Label -->
                    <span class="variation-price" style="display: flex; flex-direction: column">
                        <strong><?php if ($listLabelOnOff === "true" && $listSkuOnOff === "true"){
                                esc_html_e('SKU', 'variation-monster-pro');
                            } ?></strong>
                        <span><?php if ($listSkuOnOff === "true"){
                            echo wp_kses_post($variation_obj->get_sku()); // nosemgrep
                        } ?></span>
                    </span>

            <!-- Display Attribute and Dropdown -->
                    <?php foreach ($attributes as $attribute_name => $options) :
                        $value = isset($variation['attributes']['attribute_' . $attribute_name]) ? $variation['attributes']['attribute_' . $attribute_name] : '';

                        if (taxonomy_exists($attribute_name)) {
                            $term = get_term_by('slug', $value, $attribute_name);
                            if ($term) {
                                $value = $term->name;
                            }
                        } else {
                            $custom_key = 'attribute_' . strtolower($attribute_name);
                            if (isset($variation['attributes'][$custom_key])) {
                                $value = $variation['attributes'][$custom_key];
                            }

                            // Populate $options for custom attributes

                            $product_attributes = get_post_meta($product->get_id(), '_product_attributes', true);
                            if (isset($product_attributes[$attribute_name])) {
                                $options = explode('|', $product_attributes[$attribute_name]['value']);
                                $options = array_map('trim', $options);

                            }
                        }

                        ?>

                        <?php if ($listAttributeShow === "true"){
                        ?>
                        <span class="variation-attribute" style="display: flex; flex-direction: column">
                            <strong><?php  if ($listLabelOnOff === "true"){ // nosemgrep: audit.php.wp.security.xss.unescaped-stored-option
                                    echo wp_kses_post(wc_attribute_label($attribute_name));
                                } ?> </strong>
                            <?php if ($value) : ?>
                                <?php echo esc_html($value); ?>
                            <?php else : ?>
                                <span class="attribute-select-wrapper-custom" style="display: contents">
                                    <select name="attribute_<?php echo esc_attr($attribute_name); ?>" class="attribute-select">
                                        <option value="">
                                            <?php // nosemgrep: audit.php.wp.security.xss.unescaped-stored-option
                                            esc_html_e('Choose', 'variation-monster-pro'); ?> <?php echo wp_kses_post(wc_attribute_label($attribute_name)); ?>
                                        </option>
                                        <?php foreach ($options as $option) :
                                            ?>
                                            <option data-variation-id="<?php echo esc_attr($variation['variation_id']); ?>" value="<?php echo esc_attr($option); ?>">
                                                <?php echo esc_html($option); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </span>
                            <?php endif; ?>
                        </span>
                    <?php } endforeach; ?>

                    <!-- Title Label -->
                    <span class="variation-price" style="display: flex; flex-direction: column">
                        <strong><?php if ($listLabelOnOff === "true" && $listTitleShow === "true"){
                                esc_html_e('Title', 'variation-monster-pro');
                            } ?></strong>
                        <span><?php if ($listTitleShow === "true"){
                            echo wp_kses_post($variation_obj->get_name()); // nosemgrep
                        } ?></span>
                    </span>

            <!-- Price Label -->
                    <span class="variation-price" style="display: flex; flex-direction: column">
                        <strong><?php if ($listLabelOnOff === "true" && $listPriceOnOff === "true"){
                                esc_html_e('Price', 'variation-monster-pro');
                            } ?></strong>
                        <span><?php if ($listPriceOnOff === "true"){
                            echo wp_kses_post($variation_obj->get_price_html()); // nosemgrep
                        } ?></span>
                    </span>

            <!-- Quantity Label -->
                    <?php if ($variation_obj->get_stock_quantity()  ) {
                        ?>
                        <span class="variation-price" style="display: flex; flex-direction: column">
                            <strong><?php if ($listLabelOnOff === "true" && $listQuantityOnOff === "true"){
                                    esc_html_e('Quantity', 'variation-monster-pro');
                                } ?></strong>
                            <span><?php if ($listQuantityOnOff === "true"){
                                echo wp_kses_post($variation_obj->get_stock_quantity()); // nosemgrep
                            } ?></span>
                        </span>
                    <?php }?>
                </span>
            </label>
        </li>
    <?php
    endforeach;

    $html = ob_get_clean();

    wp_send_json_success([
        'html' => $html,
        'total_pages' => $total_pages,
        'current_page' => $page,
    ]);

}

/**
 * Table template 2 pagination ajax.
 *
 * @since 1.0.0
 * @return void
 */
function varimo_more_variations_table_template_two() {

    if (!isset($_POST['pagination_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['pagination_nonce'])), 'woocommerce_ajax_add_to_cart')) {
        wp_send_json_error(['message' => 'Invalid nonce.']);
    }
    global $post;

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $page       = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $product    = wc_get_product($product_id);
    if (!$product || !$product->is_type('variable')) {
        wp_send_json_error('Invalid product');
    }

    $enable_global_stock_management = $product->get_manage_stock();
    $global_stock_quantity          = $enable_global_stock_management ? $product->get_stock_quantity() : null;
    $all_attributes                 = $product->get_attributes();
    $variableSetting                = get_option('variable_all_checked', array());
    $bulkSelectionHideShow          = isset($variableSetting['bulkSelectionHideShow']) ? $variableSetting['bulkSelectionHideShow'] : 'true';
    $imageHideShow                  = isset($variableSetting['imageHideShow']) ? $variableSetting['imageHideShow'] : 'true';
    $skuHideShow                    = isset($variableSetting['skuHideShow']) ? $variableSetting['skuHideShow'] : 'true';
    $allAttributeHideShow           = isset($variableSetting['allAttributeHideShow']) ? $variableSetting['allAttributeHideShow'] : 'true';
    $priceHideShow                  = isset($variableSetting['priceHideShow']) ? $variableSetting['priceHideShow'] : 'true';
    $quantityHideShow               = isset($variableSetting['quantityHideShow']) ? $variableSetting['quantityHideShow'] : 'true';
    $actionHideShow                 = isset($variableSetting['actionHideShow']) ? $variableSetting['actionHideShow'] : 'true';
    $cartButtonText                 = isset($variableSetting['cartButtonText']) ? $variableSetting['cartButtonText'] : 'Add-to-cart';
    $showPopUpImage                 = isset($variableSetting['showPopUpImage']) ? $variableSetting['showPopUpImage'] : 'true';
    $titleHideShow                  = isset($variableSetting['titleHideShow']) ? $variableSetting['titleHideShow'] : 'true';
    $descriptionHideShow            = isset($variableSetting['descriptionHideShow']) ? $variableSetting['descriptionHideShow'] : 'true';
    $weightDimensionsHideShow       = isset($variableSetting['weightDimensionsHideShow']) ? $variableSetting['weightDimensionsHideShow'] : 'true';
    $designAddCartTableTemplate2    = isset($variableSetting['designAddCartTableTemplate2']) ? $variableSetting['designAddCartTableTemplate2'] : 'template_1';
    $showDoublePrice                = isset($variableSetting['showDoublePrice']) ? $variableSetting['showDoublePrice'] : 'true';
    $stockStatusHideShow            = isset($variableSetting['stockStatusHideShow']) ? $variableSetting['stockStatusHideShow'] : 'true';
    $quickCartIcon                  = isset($variableSetting['quickCartIcon']) ? $variableSetting['quickCartIcon'] : 'fa fa-shopping-cart';
    $quickCartIconImageLink         = isset($variableSetting['quickCartIconImageLink']) ? $variableSetting['quickCartIconImageLink'] : '';
    $popUPImageShow                 = isset($variableSetting['popUPImageShow']) ? $variableSetting['popUPImageShow'] : 'thumbnail';
    $showGalleyImageIntoPopup       = isset($variableSetting['showGalleyImageIntoPopup']) ? $variableSetting['showGalleyImageIntoPopup'] : 'true';
    $per_page                       = isset($variableSetting['tableRowPagination']) ? $variableSetting['tableRowPagination'] : '5';
    $variations                     = $product->get_available_variations();
    $total_variations               = count($variations);
    $total_pages                    = ceil($total_variations / $per_page);
    $offset                         = ($page - 1) * $per_page;
    $current_variations             = array_slice($variations, $offset, $per_page);

    ob_start();

    $variations = $product->get_available_variations();

    usort($variations, function($a, $b) {
        $skuA = $a['sku'];
        $skuB = $b['sku'];

        return strcmp($skuA, $skuB);
    });

    usort($variations, function($a, $b) {
        $variationA = new WC_Product_Variation($a['variation_id']);
        $variationB = new WC_Product_Variation($b['variation_id']);

        $priceA = $variationA->get_price();
        $priceB = $variationB->get_price();

        if ($priceA === false || $priceB === false) {
            return 0;
        }

        return $priceA - $priceB;
    });


    foreach ($all_attributes as $attribute_name => $attribute) {
        usort($variations, function($a, $b) use ($attribute_name) {
            $attrA = $a['attributes'][$attribute_name] ?? '';
            $attrB = $b['attributes'][$attribute_name] ?? '';
            return strcmp($attrA, $attrB);
        });
    }

    foreach ($current_variations as $var) {
        $variation_id             = $var['variation_id'];
        $variation                = new WC_Product_Variation($variation_id);
        $variation_stock_quantity = $variation->get_manage_stock() ? $variation->get_stock_quantity() : null;

        // Retrieve the gallery images.
        $gallery_images = get_post_meta($variation_id, '_variation_gallery_images', true);
        $image_ids      = $gallery_images ? explode(',', $gallery_images) : [];
        $thumbnail_id   = $variation->get_image_id();
        $thumbnail_url  = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, "thumbnail") : '';
        $stock_status   = $variation->is_on_sale();
        ?>
        <tr style=" margin: 10px; display: flex; " class="variation-row" data-variation-id="<?php echo esc_attr($variation_id); ?>" data-stock-status="<?php echo esc_attr($stock_status); ?>" data-gallery-images="<?php echo esc_attr(wp_json_encode($image_ids)); ?>">

            <td class="table-template2-details-section" >
                <?php if ($bulkSelectionHideShow === "true"){ ?>
                    <input class="bulk_cart" style="outline: none" type="checkbox" id="bulk_cart_<?php echo esc_attr($variation_id); ?>" name="bulk_cart[]" value="<?php echo esc_attr($variation_id); ?>">
                <?php }?>
                <div>
                    <?php if ($imageHideShow === "true") {
                        // nosemgrep: audit.php.wp.security.xss.unescaped-stored-option
                        echo wp_get_attachment_image(
                            absint($thumbnail_id),
                            esc_attr($popUPImageShow),
                            false,
                            array(
                                'alt' => esc_attr($variation->get_name()),
                                'class' => 'gallery-trigger',
                                'style' => 'cursor: pointer; ',
                                'data-gallery-onoff' => esc_attr($showGalleyImageIntoPopup),
                                'data-gallery' => esc_attr(wp_json_encode(array_map(function ($image_id) use ($popUPImageShow) {
                                    $image_size = in_array($popUPImageShow, ['thumbnail', 'medium', 'large', 'full']) ? $popUPImageShow : 'thumbnail';
                                    return wp_get_attachment_image_src($image_id, $image_size)[0] ?? '';
                                }, $image_ids))),

                            )
                        );
                    }?>
                </div>

                <div>
                    <?php if ($allAttributeHideShow === "true"){
                        foreach ($all_attributes as $attribute_name => $attribute) {
                            $attribute_value = $variation->get_attribute($attribute_name);

                            if (empty($attribute_value)) {
                                echo "<div><select class='quick-attribute-select' name='attribute_" . esc_attr($attribute_name) . "' data-attribute-name='" . esc_attr($attribute_name) . "'>";
                                if ($attribute->is_taxonomy()) {
                                    $options = wc_get_product_terms($product->get_id(), $attribute_name, ['fields' => 'names']);
                                } else {
                                    $options = $attribute->get_options();
                                }
                                foreach ($options as $option) {
                                    echo "<option value='" . esc_attr($option) . "'>" . esc_html($option) . "</option>";
                                }
                                echo "</select></div>";
                            } else {
                                echo "<div  class='quick-variable-title quick-attribute-text'  data-attribute-name='" . esc_attr($attribute_name) . "' name='attribute_" . esc_attr($attribute_name) . "'>" . esc_html($attribute_value) . "</div>";
                            }
                        }
                    } ?>
                </div>

                <div class="quick-variable-title variable-sku" style="max-width: 500px">
                    <?php if ($titleHideShow === "true"){ ?>
                        <div>
                            <?php echo esc_html($variation->get_name()); ?>
                        </div>
                    <?php }?>

                    <?php if ($skuHideShow === "true"){ ?>
                        <div>
                            <strong><?php esc_html_e('SKU: ', 'variation-monster-pro'); ?></strong> <?php echo esc_html($variation->get_sku()); ?>
                        </div>
                    <?php }?>

                    <?php
                    if ($weightDimensionsHideShow === "true"){

                        $weight = $variation->get_weight();
                        if ($weight) {
                            ?>
                            <div>
                                <strong><?php esc_html_e('Weight: ', 'variation-monster-pro'); ?></strong> <?php echo esc_html($weight) . ' ' . esc_html(get_option('woocommerce_weight_unit')); ?>
                            </div>
                        <?php } ?>

                        <?php

                        $length = $variation->get_length();
                        $width  = $variation->get_width();
                        $height = $variation->get_height();

                        if ($length || $width || $height) {
                            ?>
                            <div>
                                <strong><?php esc_html_e('Dimensions: ', 'variation-monster-pro'); ?></strong>
                                <?php
                                echo esc_html($length ? $length : '-') . ' x ' .
                                    esc_html($width ? $width : '-') . ' x ' .
                                    esc_html($height ? $height : '-') . ' ' .
                                    esc_html(get_option('woocommerce_dimension_unit'));
                                ?>
                            </div>
                        <?php }
                    } ?>

                    <div class="description-container">
                        <span class="truncated-description"><?php if ($descriptionHideShow ==='true'){ echo esc_html($variation->get_description()); } ?></span>
                    </div>
                    <?php
                    $full_description = $variation->get_description();
                    $short_description = wp_trim_words($full_description);
                    if ((!empty($variation->get_description()))  &&  ($descriptionHideShow ==='true')) : ?>
                        <div>
                            <a href="#" class="load-more-description" data-description="<?php echo esc_attr($variation->get_description()); ?>">Load More</a>
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
            <?php if ($showPopUpImage === "true"){
                ?>
                <div id="imagePopup" class="popup-container">
                    <div class="popup-content">
                        <span class="close-btn">&times;</span>
                        <button style="outline: none; ma" id="prevImage" class="lightbox-nav prev">⟨</button>

                        <button style="outline: none" id="nextImage" class="lightbox-nav next">⟩</button>
                    </div>
                </div>
                <?php
            }?>

            <td class="table-template2-cart-section" >
                <?php if ($priceHideShow === "true"){ ?>
                    <div class='variable-price quick-variable-title'><?php
                        if ($showDoublePrice === 'true'){
                            $price_html = $variation->get_price_html();
                            echo $price_html ? wp_kses_post($price_html) : ''; // nosemgrep
                        }else{
                            $sale_price = $variation->get_sale_price();
                            if($sale_price) {
                                echo $sale_price ? wp_kses_post(wc_price($sale_price)) : ''; // nosemgrep
                            } else {
                                $regular_price = $variation->get_regular_price();
                                echo $regular_price ? wp_kses_post(wc_price($regular_price)) : ''; // nosemgrep
                            }
                        }
                        ?></div>
                <?php } ?>

                <?php
                if (!empty($metaTableTemplate2CartStyle)){
                    if ($metaTableTemplate2CartStyle === 'template_1'){
                        if ($quantityHideShow === "true" && $variation->get_stock_status() !== "outofstock"){
                            ?>
                            <div>
                                <div class="quick-quantity-container" style="margin-bottom: 10px">
                                    <button class="quick-quantity-decrease" id="decrease">-</button>
                                    <input  type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($variation_stock_quantity ?: $global_stock_quantity ?: 99); ?>">
                                    <button class="quick-quantity-increase" id="increase">+</button>
                                </div>
                                <div class="quick-cart-notification quick-hidden"></div>
                            </div>
                            <?php
                        }?>

                        <?php if ($actionHideShow === "true" && $variation->get_stock_status() !== "outofstock"){
                            ?>
                            <div class="stock-notification" style="padding-left: 25%; padding-right: 25%">
                                <?php if (0 === ($variation_stock_quantity ?: $global_stock_quantity)) : ?>
                                    <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                <?php else : ?>
                                    <button style="width: 100%; text-align: center" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($variation_id); ?>">
                                        <?php if (!empty($quickCartIconImageLink)): ?>
                                            <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($quickCartIconImageLink); ?>"></span>
                                        <?php else: ?>
                                            <i class="<?php echo esc_attr($quickCartIcon); ?>" aria-hidden="true"></i>
                                        <?php endif; ?>
                                        <span><?php echo esc_html($cartButtonText); ?></span>
                                    </button>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    }elseif ($metaTableTemplate2CartStyle === 'template_2'){
                        ?>
                        <div style="display: flex; gap: 10px; align-items: center; justify-content: center; margin-top: 15px ; margin-bottom: 15px">
                            <?php if ($quantityHideShow === "true" && $variation->get_stock_status() !== "outofstock"){
                                ?>
                                <div>
                                    <div class="quick-quantity-container" style="gap: 0 !important; margin-top: 0 !important;">
                                        <button style="border-top-left-radius: 50%;   border-bottom-left-radius: 50%; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;" class="quick-quantity-decrease" id="decrease">-</button>
                                        <input style="border-radius: 0 !important;" type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($variation_stock_quantity ?: $global_stock_quantity ?: 99); ?>">
                                        <button style="border-top-right-radius: 50%;   border-bottom-right-radius: 50%; border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" class="quick-quantity-increase" id="increase">+</button>
                                    </div>
                                    <div class="quick-cart-notification quick-hidden"></div>
                                </div>
                                <?php
                            }?>

                            <?php if ($actionHideShow === "true" && $variation->get_stock_status() !== "outofstock"){
                                ?>
                                <div class="stock-notification">
                                    <?php if (0 === ($variation_stock_quantity ?: $global_stock_quantity)) : ?>
                                        <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                    <?php else : ?>
                                        <button style="text-align: center; border-radius: 50%; height: 28px; width: 28px" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($variation_id); ?>">
                                            <?php if (!empty($quickCartIconImageLink)): ?>
                                                <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($quickCartIconImageLink); ?>"></span>
                                            <?php else: ?>
                                                <i class="<?php echo esc_attr($quickCartIcon); ?>" aria-hidden="true"></i>
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
                    if ($designAddCartTableTemplate2 === 'template_1'){
                        if ($quantityHideShow === "true" && $variation->get_stock_status() !== "outofstock"){
                            ?>
                            <div>
                                <div class="quick-quantity-container" style="margin-bottom: 10px">
                                    <button class="quick-quantity-decrease" id="decrease">-</button>
                                    <input  type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($variation_stock_quantity ?: $global_stock_quantity ?: 99); ?>">
                                    <button class="quick-quantity-increase" id="increase">+</button>
                                </div>
                                <div class="quick-cart-notification quick-hidden"></div>
                            </div>
                            <?php
                        }?>

                        <?php if ($actionHideShow === "true" && $variation->get_stock_status() !== "outofstock"){
                            ?>
                            <div class="stock-notification" style="padding-left: 25%; padding-right: 25%">
                                <?php if (0 === ($variation_stock_quantity ?: $global_stock_quantity)) : ?>
                                    <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                <?php else : ?>
                                    <button style="width: 100%; text-align: center" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($variation_id); ?>">
                                        <?php if (!empty($quickCartIconImageLink)): ?>
                                            <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($quickCartIconImageLink); ?>"></span>
                                        <?php else: ?>
                                            <i class="<?php echo esc_attr($quickCartIcon); ?>" aria-hidden="true"></i>
                                        <?php endif; ?>
                                        <span><?php echo esc_html($cartButtonText); ?></span>
                                    </button>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    }elseif ($designAddCartTableTemplate2 === 'template_2'){
                        ?>
                        <div style="display: flex; gap: 10px; align-items: center; justify-content: center; margin-top: 15px ; margin-bottom: 15px">
                            <?php if ($quantityHideShow === "true" && $variation->get_stock_status() !== "outofstock"){
                                ?>
                                <div>
                                    <div class="quick-quantity-container" style="gap: 0 !important; margin-top: 0 !important;">
                                        <button style="border-top-left-radius: 50%;   border-bottom-left-radius: 50%; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;" class="quick-quantity-decrease" id="decrease">-</button>
                                        <input style="border-radius: 0 !important;" type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($variation_stock_quantity ?: $global_stock_quantity ?: 99); ?>">
                                        <button style="border-top-right-radius: 50%;   border-bottom-right-radius: 50%; border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" class="quick-quantity-increase" id="increase">+</button>
                                    </div>
                                    <div class="quick-cart-notification quick-hidden"></div>
                                </div>
                                <?php
                            }?>

                            <?php if ($actionHideShow === "true" && $variation->get_stock_status() !== "outofstock"){
                                ?>
                                <div class="stock-notification">
                                    <?php if (0 === ($variation_stock_quantity ?: $global_stock_quantity)) : ?>
                                        <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                                    <?php else : ?>
                                        <button style="text-align: center; border-radius: 50%; height: 28px; width: 28px" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($variation_id); ?>">
                                            <?php if (!empty($quickCartIconImageLink)): ?>
                                                <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($quickCartIconImageLink); ?>"></span>
                                            <?php else: ?>
                                                <i class="<?php echo esc_attr($quickCartIcon); ?>" aria-hidden="true"></i>
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
                ?>
                <div><?php
                    if ($variation->get_stock_status() === "outofstock"){
                        ?>
                        <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                        <?php
                    }else{
                        if ($stockStatusHideShow === 'true'){
                            ?>
                            <p><?php esc_html_e('In Stock', 'variation-monster-pro'); ?></p>
                            <?php
                        }
                    }?></div>
            </td>
        </tr>
        <?php
    }
    $html = ob_get_clean();

    wp_send_json_success([
        'html' => $html,
        'total_pages' => $total_pages,
        'current_page' => $page,
    ]);
}

/**
 * Table template 1 pagination ajax.
 *
 * @since 1.0.0
 * @return void
 */
function varimo_more_variations() {

    if (!isset($_POST['pagination_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['pagination_nonce'])), 'woocommerce_ajax_add_to_cart')) {
        wp_send_json_error(['message' => 'Invalid nonce.']);
    }
    global $post;
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $page       = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $product    = wc_get_product($product_id);
    if (!$product || !$product->is_type('variable')) {
        wp_send_json_error('Invalid product');
    }

    $enable_global_stock_management = $product->get_manage_stock();
    $global_stock_quantity          = $enable_global_stock_management ? $product->get_stock_quantity() : null;
    $all_attributes                 = $product->get_attributes();
    $variableSetting                = get_option('variable_all_checked', array());
    $bulkSelectionHideShow          = isset($variableSetting['bulkSelectionHideShow']) ? $variableSetting['bulkSelectionHideShow'] : 'true';
    $imageHideShow                  = isset($variableSetting['imageHideShow']) ? $variableSetting['imageHideShow'] : 'true';
    $skuHideShow                    = isset($variableSetting['skuHideShow']) ? $variableSetting['skuHideShow'] : 'true';
    $allAttributeHideShow           = isset($variableSetting['allAttributeHideShow']) ? $variableSetting['allAttributeHideShow'] : 'true';
    $priceHideShow                  = isset($variableSetting['priceHideShow']) ? $variableSetting['priceHideShow'] : 'true';
    $quantityHideShow               = isset($variableSetting['quantityHideShow']) ? $variableSetting['quantityHideShow'] : 'true';
    $actionHideShow                 = isset($variableSetting['actionHideShow']) ? $variableSetting['actionHideShow'] : 'true';
    $cartButtonText                 = isset($variableSetting['cartButtonText']) ? $variableSetting['cartButtonText'] : 'Add-to-cart';
    $showPopUpImage                 = isset($variableSetting['showPopUpImage']) ? $variableSetting['showPopUpImage'] : 'true';
    $showDoublePrice                = isset($variableSetting['showDoublePrice']) ? $variableSetting['showDoublePrice'] : 'true';
    $quickCartIcon                  = isset($variableSetting['quickCartIcon']) ? $variableSetting['quickCartIcon'] : 'fa fa-shopping-cart';
    $quickCartIconImageLink         = isset($variableSetting['quickCartIconImageLink']) ? $variableSetting['quickCartIconImageLink'] : '';
    $popUPImageShow                 = isset($variableSetting['popUPImageShow']) ? $variableSetting['popUPImageShow'] : 'thumbnail';
    $showGalleyImageIntoPopup       = isset($variableSetting['showGalleyImageIntoPopup']) ? $variableSetting['showGalleyImageIntoPopup'] : 'true';
    $per_page                       = isset($variableSetting['tableRowPagination']) ? $variableSetting['tableRowPagination'] : '5';
    $variations                     = $product->get_available_variations();
    $total_variations               = count($variations);
    $total_pages                    = ceil($total_variations / $per_page);
    $offset                         = ($page - 1) * $per_page;
    $current_variations             = array_slice($variations, $offset, $per_page);

    ob_start();

    $variations = $product->get_available_variations();

    usort($variations, function($a, $b) {
        $skuA = $a['sku'];
        $skuB = $b['sku'];
        return strcmp($skuA, $skuB);
    });

    usort($variations, function($a, $b) {

        $variationA = new WC_Product_Variation($a['variation_id']);
        $variationB = new WC_Product_Variation($b['variation_id']);
        $priceA     = $variationA->get_price();
        $priceB     = $variationB->get_price();

        if ($priceA === false || $priceB === false) {
            return 0;
        }
        return $priceA - $priceB;
    });

    foreach ($all_attributes as $attribute_name => $attribute) {
        usort($variations, function($a, $b) use ($attribute_name) {

            $attrA = $a['attributes'][$attribute_name] ?? '';
            $attrB = $b['attributes'][$attribute_name] ?? '';

            return strcmp($attrA, $attrB);
        });
    }

    foreach ($current_variations as $var) {
        $variation_id             = $var['variation_id'];
        $variation                = new WC_Product_Variation($variation_id);
        $variation_stock_quantity = $variation->get_manage_stock() ? $variation->get_stock_quantity() : null;

        $gallery_images = get_post_meta($variation_id, '_variation_gallery_images', true);
        $image_ids      = $gallery_images ? explode(',', $gallery_images) : [];
        $thumbnail_id   = $variation->get_image_id();
        $thumbnail_url  = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, "thumbnail") : '';
        $stock_status   = $variation->is_on_sale();
        ?>
        <tr class="variation-row" data-variation-id="<?php echo esc_attr($variation_id); ?>" data-stock-status="<?php echo esc_attr($stock_status); ?>" data-gallery-images="<?php echo esc_attr(wp_json_encode($image_ids)); ?>">
            <?php if ($bulkSelectionHideShow === "true"){
                ?>

                <td style="padding: 20px; text-align: center">
                    <input class="bulk_cart" style="outline: none" type="checkbox" id="bulk_cart_<?php echo esc_attr($variation_id); ?>" name="bulk_cart[]" value="<?php echo esc_attr($variation_id); ?>">
                </td>

                <?php
            }?>

            <?php if ($imageHideShow === "true") { ?>
                <td class="table_image">
                    <?php
                    // nosemgrep
                    echo wp_get_attachment_image(
                        $thumbnail_id,
                        esc_attr($popUPImageShow),
                        false,
                        array(
                            'alt' => esc_attr($variation->get_name()),
                            'class' => 'gallery-trigger',
                            'style' => 'cursor: pointer; ',
                            'data-gallery-onoff' => esc_attr($showGalleyImageIntoPopup),
                            'data-gallery' => esc_attr(wp_json_encode(array_map(function ($image_id) use ($popUPImageShow) {
                                $image_size = in_array($popUPImageShow, ['thumbnail', 'medium', 'large', 'full']) ? $popUPImageShow : 'thumbnail';
                                return wp_get_attachment_image_src($image_id, $image_size)[0] ?? '';
                            }, $image_ids))),

                        )
                    );
                    ?>
                </td>

                <!-- Modal Image Popup -->
                <?php if ($showPopUpImage === "true"){
                    ?>
                    <div id="imagePopup" class="popup-container">
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

            <?php if ($skuHideShow === "true"){
                ?>
                <td style="padding: 20px; text-align: center" class="quick-variable-title variable-sku"><?php echo esc_html($variation->get_sku()); ?></td>
                <?php
            }?>


            <?php if ($allAttributeHideShow === "true"){
                foreach ($all_attributes as $attribute_name => $attribute) {
                    $attribute_value = $variation->get_attribute($attribute_name);

                    if (empty($attribute_value)) {
                        echo "<td><select class='quick-attribute-select' name='attribute_" . esc_attr($attribute_name) . "' data-attribute-name='" . esc_attr($attribute_name) . "'>";

                        if ($attribute->is_taxonomy()) {
                            $options = wc_get_product_terms($product->get_id(), $attribute_name, ['fields' => 'names']);
                        } else {
                            $options = $attribute->get_options();
                        }

                        foreach ($options as $option) {
                            echo "<option value='" . esc_attr($option) . "'>" . esc_html($option) . "</option>";
                        }

                        echo "</select></td>";
                    } else {

                        echo "<td  class='quick-variable-title quick-attribute-text'  data-attribute-name='" . esc_attr($attribute_name) . "' name='attribute_" . esc_attr($attribute_name) . "'>" . esc_html($attribute_value) . "</td>";
                    }
                }
            }
            ?>

            <?php if ($priceHideShow === "true"){
                ?>
                <td class='variable-price quick-variable-title'><?php
                    if ($showDoublePrice === 'true'){
                        $price_html = $variation->get_price_html();
                        echo $price_html ? wp_kses_post($price_html) : ''; // nosemgrep
                    }else{
                        $sale_price = $variation->get_sale_price();
                        if($sale_price) {
                            echo $sale_price ? wp_kses_post(wc_price($sale_price)) : ''; // nosemgrep
                        } else {
                            $regular_price = $variation->get_regular_price();
                            echo $regular_price ? wp_kses_post(wc_price($regular_price)) : ''; // nosemgrep
                        }
                    }
                    ?></td>
                <?php
            }?>

            <?php if ($quantityHideShow === "true"){
                ?>
                <td>
                    <div class="quick-quantity-container" style="margin-bottom: 10px">
                        <button class="quick-quantity-decrease" id="decrease">-</button>
                        <input  type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($variation_stock_quantity ?: $global_stock_quantity ?: 99); ?>">
                        <button class="quick-quantity-increase" id="increase">+</button>
                    </div>
                    <div class="quick-cart-notification quick-hidden"></div>
                </td>
                <?php
            }?>

            <?php if ($actionHideShow === "true"){
                ?>
                <td class="stock-notification" style="padding: 20px; text-align: center ; justify-items: center">
                    <?php if (0 === ($variation_stock_quantity) || $variation->get_stock_status() === "outofstock") : ?>
                        <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                    <?php else : ?>
                        <button style="width: 100%; text-align: center" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($variation_id); ?>">
                            <?php if (!empty($quickCartIconImageLink)): ?>
                                <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($quickCartIconImageLink); ?>"></span>
                            <?php else: ?>
                                <i class="<?php echo esc_attr($quickCartIcon); ?>" aria-hidden="true"></i>
                            <?php endif; ?>
                            <span style="margin-left: 3px"><?php echo esc_html($cartButtonText); ?></span>
                        </button>
                    <?php endif; ?>
                </td>
                <?php
            }?>

        </tr>
        <?php
    }
    $html = ob_get_clean();

    wp_send_json_success([
        'html' => $html,
        'total_pages' => $total_pages,
        'current_page' => $page,
    ]);
}

/**
 * Add to cart handel by ajax. It includes frontend-script.js. It works for archive page if i click attributes.
 *
 * @since 1.0.0
 * @return void
 * @throws Exception
 */
function varimo_add_variation_to_cart() {

    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'woocommerce_ajax_add_to_cart')) {
        wp_send_json_error(['message' => 'Invalid nonce.']);
    }

    // phpcs:ignore
    $product_id        = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $variation_id      = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
    $quantity          = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity); // phpcs:ignore
    // phpcs:ignore
    $variation         = array_map('sanitize_text_field', wp_unslash($_POST['variation']));

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation)) {
        wp_send_json_success(['message' => 'Product added to cart!']);
    } else {
        wp_send_json_error(['message' => 'Failed to add product to cart.']);
    }
    wp_die();
}

/**
 * Add to cart handel by ajax. It includes frontend-script.js
 *
 * @since 1.0.0
 * @return void
 * @throws Exception
 */
function varimo_ajax_add_to_cart_handler() {

    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'woocommerce_ajax_add_to_cart')) {
        wp_send_json_error(['message' => 'Invalid nonce.']);
    }
    // phpcs:ignore
    if (!isset($_POST['product_id'])) {
        wp_send_json_error(['message' => 'Invalid request. Product ID is missing.']);
    }
    // phpcs:ignore
    if (!isset($_POST['variation_id'])) {
        wp_send_json_error(['message' => 'Invalid request. Variation ID is missing.']);
    }
    // phpcs:ignore
    if (!isset($_POST['variation'])) {
        wp_send_json_error(['message' => 'Invalid request. Variation is missing.']);
    }

    // phpcs:ignore
    $product_id              = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    // phpcs:ignore
    $quantity                = empty($_POST['quantity']) ? 1 : wc_stock_amount(wp_unslash($_POST['quantity']));
    // phpcs:ignore
    $variation_id            = absint($_POST['variation_id']);
    // phpcs:ignore
    $variation               = array_map('sanitize_text_field', wp_unslash($_POST['variation']));
    $passed_validation       = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity); // phpcs:ignore
    $variableSetting         = get_option('variable_all_checked', array());
    $addToCartSuccessMessage = isset($variableSetting['addToCartSuccessMessage']) ? $variableSetting['addToCartSuccessMessage'] : 'Successfully added to cart.';
    $addToCartSuccessColor   = isset($variableSetting['addToCartSuccessColor']) ? $variableSetting['addToCartSuccessColor'] : '#fff';
    $addToCartErrorColor     = isset($variableSetting['addToCartErrorColor']) ? $variableSetting['addToCartErrorColor'] : '#FF0000';


    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation)) {
        do_action('woocommerce_ajax_added_to_cart', $product_id); // phpcs:ignore

        $response = array(
                'success' => true,
                'message' => $addToCartSuccessMessage,
                'color'   => $addToCartSuccessColor,
        );
        wp_send_json($response);
    } else {

        $product = wc_get_product($variation_id);

        if (!$product) {
            $error_message = 'The product does not exist.';
        } elseif (!$product->is_purchasable()) {
            $error_message = 'This product is not purchasable.';
        } elseif (!$product->is_in_stock()) {
            $error_message = 'This product is out of stock.';
        } else {
            $error_message = 'Could not add the product to the cart.';
        }

        $response = array(
                'error' => true,
                'message' => $error_message,
                'color' => $addToCartErrorColor,
                'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id), // phpcs:ignore
        );
        wp_send_json($response);
    }

    wp_die();
}

/**
 * Bulk add to cart handel by ajax. It includes frontend-script.js
 *
 * @since 1.0.0
 * @return void
 * @throws Exception
 */
function varimo_handle_bulk_add_to_cart() {

    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'varimo_bulk_add_to_cart_nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce.']);
    }
    // phpcs:ignore
    $arrayLength = isset($_POST['arrayLength']) ? absint(wp_unslash($_POST['arrayLength'])): '';
    $variations  = [];

    for ($i = 0; $i < $arrayLength; $i++) {

        $attributes = [];
        // phpcs:ignore
        if (isset($_POST['attributes'][$i]['attributes']) && is_array($_POST['attributes'][$i]['attributes'])) {
            // phpcs:ignore
            $unslashed_attributes = array_map( 'sanitize_text_field',wp_unslash($_POST['attributes'][$i]['attributes']) ) ;

            foreach ($unslashed_attributes as $key => $value) {
                $sanitized_key   = sanitize_text_field($key);
                $sanitized_value = sanitize_text_field($value);
                $attributes[$sanitized_key] = $sanitized_value;
            }
        }

        $variations[] = [
            // phpcs:ignore
            'product_id'   => isset($_POST['product_id'][$i]['product_id']) ? sanitize_text_field(wp_unslash($_POST['product_id'])[$i]['product_id']) : 0,
            // phpcs:ignore
            'variation_id' => isset($_POST['variation_id'][$i]['variation_id']) ? sanitize_text_field(wp_unslash($_POST['variation_id'])[$i]['variation_id']) : 0,
            // phpcs:ignore
            'quantity'     => isset($_POST['quantity'][$i]['quantity']) ? sanitize_text_field(wp_unslash($_POST['quantity'])[$i]['quantity']) : 1,
            'attributes'   => $attributes,
        ];
    }

    if (!is_array($variations) || empty($variations)) {
        wp_send_json_error(['message' => 'Invalid variations data.']);
    }

    foreach ($variations as $variation_data) {

        $variation_id = absint($variation_data['variation_id']);
        $quantity     = isset($variation_data['quantity']) ? wc_stock_amount($variation_data['quantity']) : 1;
        $attributes   = isset($variation_data['attributes']) ? $variation_data['attributes'] : [];

        if (WC()->cart->add_to_cart($variation_data['product_id'], $quantity, $variation_id, $attributes)) {
            continue;
        } else {
            wp_send_json_error(['message' => 'Failed to add variation ID ' . $variation_id]);
        }
    }

    $response = array(
        'success' => true,
        'message' => "Successfully added to cart",
    );
    wp_send_json($response);

}