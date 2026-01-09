<?php
if (!defined('ABSPATH')) exit;

/**
 * Define class table before add to cart.
 *
 * @return void
 * @since 1.0.1
 *
 */
class VARIMO_Table_Before_AddTo_Cart_Template_Two{

    /**
     * Define Constant.
     *
     * @return void
     * @since 1.0.1
     *
     */
    public function __construct(){
        add_action('woocommerce_loaded', function() {
            add_action('wp', array($this, 'remove_default_actions'));
        });
    }

    /**
     * Remove woocommerce meta, description, add-to-cart button, and show table initialize into this funcion.
     *
     * @return void
     * @since 1.0.1
     *
     */
    public function remove_default_actions() {

        global $post;

        $beforeCartVariationTableMeta       = '';
        if (is_object($post) && isset($post->ID)) {
            $beforeCartVariationTableMeta = get_post_meta($post->ID, '_before_cart_variation_table_meta', true);
        }
        $variableSetting                    = get_option('variable_all_checked', array());
        $beforeCartQuickTableOnOff          = isset($variableSetting['beforeCartQuickTableOnOff']) ? $variableSetting['beforeCartQuickTableOnOff'] : '';
        $overwriteDefaultCartTableTemplate  = isset($variableSetting['overwriteDefaultCartTableTemplate']) ? $variableSetting['overwriteDefaultCartTableTemplate'] : 'template_1';
        if ($beforeCartQuickTableOnOff === 'true' && $overwriteDefaultCartTableTemplate === 'template_2'){

            if ($beforeCartVariationTableMeta === 'true' || $beforeCartVariationTableMeta === ''){

                // Remove single product add to cart
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

                // Remove loop add to cart
                remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

                // Remove variable product form
                remove_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);

                // Remove product meta tag
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

                // Remove product description (optional)
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);

                // Add your custom table
                add_action('woocommerce_share', array($this, 'woocommerce_before_add_to_cart_button'));
            }
        }
    }


    /**
     * Variation Monster table show before the add to cart button.
     *
     * @return void
     * @since 1.0.1
     *
     */
    public function woocommerce_before_add_to_cart_button(){

        global $product;
        global $post;
        if (isset($product) && $product->is_type("variable")) {
            $product_id                     = $product->get_id();
            $enable_global_stock_management = $product->get_manage_stock();
            $global_stock_quantity          = $enable_global_stock_management ? $product->get_stock_quantity() : null;
            $all_attributes                 = $product->get_attributes();
            $variableSetting                = get_option('variable_all_checked', array());
            $bulkSelectionHideShow          = isset($variableSetting['bulkSelectionHideShow']) ? $variableSetting['bulkSelectionHideShow'] : 'true';
            $allAttributeHideShow           = isset($variableSetting['allAttributeHideShow']) ? $variableSetting['allAttributeHideShow'] : 'true';
            $priceHideShow                  = isset($variableSetting['priceHideShow']) ? $variableSetting['priceHideShow'] : 'true';
            $quantityHideShow               = isset($variableSetting['quantityHideShow']) ? $variableSetting['quantityHideShow'] : 'true';
            $onSaleHideShow                 = isset($variableSetting['onSaleHideShow']) ? $variableSetting['onSaleHideShow'] : 'true';
            $searchOptionHideShow           = isset($variableSetting['searchOptionHideShow']) ? $variableSetting['searchOptionHideShow'] : 'true';
            $cartButtonText                 = isset($variableSetting['cartButtonText']) ? $variableSetting['cartButtonText'] : 'Add-to-cart';
            $onSaleNameChange               = isset($variableSetting['onSaleNameChange']) ? $variableSetting['onSaleNameChange'] : 'On Sale';
            $searchOptionTextChange         = isset($variableSetting['searchOptionTextChange']) ? $variableSetting['searchOptionTextChange'] : 'Search...';
            $showDoublePrice                = isset($variableSetting['showDoublePrice']) ? $variableSetting['showDoublePrice'] : 'true';
            $quickCartIcon                  = isset($variableSetting['quickCartIcon']) ? $variableSetting['quickCartIcon'] : 'fa fa-shopping-cart';
            $quickCartIconImageLink         = isset($variableSetting['quickCartIconImageLink']) ? $variableSetting['quickCartIconImageLink'] : '';
            $tableRowPagination             = isset($variableSetting['tableRowPagination']) ? $variableSetting['tableRowPagination'] : '5';
            $newMetaDataForVariationsTableOverwrite = isset($variableSetting['newMetaDataForVariationsTableOverwrite']) ? $variableSetting['newMetaDataForVariationsTableOverwrite'] : array();
            $variations                     = $product->get_available_variations();
            $variation_count                = count($variations);

            $selectVariationButtonBgColor    = isset($variableSetting['selectVariationButtonBgColor']) ? $variableSetting['selectVariationButtonBgColor'] : '#0071a1';
            $selectVariationButtonTextColor  = isset($variableSetting['selectVariationButtonTextColor']) ? $variableSetting['selectVariationButtonTextColor'] : '#FFFFFF';
            $imageColorWidth                 = isset($variableSetting['imageColorWidth']) ? $variableSetting['imageColorWidth'] : '40';
            $imageColorHeight                = isset($variableSetting['imageColorHeight']) ? $variableSetting['imageColorHeight'] : '40';
            $imageColorBorderRadius          = isset($variableSetting['imageColorBorderRadius']) ? $variableSetting['imageColorBorderRadius'] : '50';

            ?>
            <div class="table-template-max-width template-one-table">

                <div id="loading-spinner-pagination-table-before-cart" style="display: none; text-align: center;">
                    <i class="fa fa-spinner fa-spin "></i>
                </div>

                <div class="table-before" >
                    <?php if ($onSaleHideShow === "true"){
                        ?>
                        <div style="display: inline-flex; align-items: baseline; gap: 10px ; margin-right: 10px; margin-left: 10px">
                            <input id="stock_status_before_cart" type="checkbox"  name=""  style="outline: none">
                            <p for="stock_status_before_cart" ><?php echo esc_html($onSaleNameChange); ?></p>
                        </div>
                        <?php
                    }?>

                    <?php if ($searchOptionHideShow === "true"){
                        ?>
                        <div class="search_option" style="display: inline-flex; align-items: baseline; gap: 10px">
                            <input class="variation-table-search" type="text" placeholder="<?php echo esc_html($searchOptionTextChange); ?>" name="search" id="variation-search-before-cart">
                        </div>
                        <?php
                    }?>
                </div>
                <table id="quick-variable-table-before-cart" class="table-template1-before-cart" data-pagination-table="<?php echo esc_attr($tableRowPagination); ?>" data-Variation-count="<?php echo esc_attr($variation_count); ?>" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                    <tr>
                        <?php
                        if ($bulkSelectionHideShow === "true"){
                            ?>
                            <th><input id="bulk_checkbox_select_all_before_cart" type="checkbox"  name="" style="outline: none" ></th>
                            <?php
                        }

                        if ($allAttributeHideShow === "true"){
                            foreach ($all_attributes as $attribute_name => $attribute) {

                                $reflection   = new ReflectionClass($attribute);
                                $dataProperty = $reflection->getProperty("data");
                                $dataProperty->setAccessible(true);
                                $data = $dataProperty->getValue($attribute);

                                if (taxonomy_exists($attribute_name) && isset($data["variation"]) && $data["variation"]) {
                                    $taxonomy = get_taxonomy($attribute_name);
                                    $label    = str_replace("Product ", "", $taxonomy->label);

                                    ?>
                                    <th >
                                        <span style="display: inline-block; margin-top: 9px">
                                            <?php echo esc_html(ucfirst($label)); ?>
                                        </span>
                                        <span style="float: right; display: grid" class="attribute-sort-arrows" data-attribute="<?php echo esc_attr($attribute_name); ?>">
                                            <span style="height: 10px" class="dashicons dashicons-arrow-up" id="sort-toggle-<?php echo esc_attr($attribute_name); ?>"></span>
                                            <span style="height: 10px" class="dashicons dashicons-arrow-down" id="sort-toggle-<?php echo esc_attr($attribute_name); ?>"></span>
                                        </span>
                                    </th>
                                    <?php
                                } elseif (isset($data["variation"]) && $data["variation"]) {
                                    ?>
                                    <th >
                                        <span style="display: inline-block; margin-top: 9px">
                                            <?php echo esc_html(ucfirst($attribute_name)); ?>
                                        </span>
                                        <span style="float: right; display: grid" class="attribute-sort-arrows" data-attribute="<?php echo esc_attr($attribute_name); ?>">
                                            <span style="height: 10px" class="dashicons dashicons-arrow-up" id="sort-arrow-up-<?php echo esc_attr($attribute_name); ?>"></span>
                                            <span style="height: 10px" class="dashicons dashicons-arrow-down" id="sort-arrow-down-<?php echo esc_attr($attribute_name); ?>"></span>
                                        </span>
                                    </th>
                                    <?php
                                }
                            }
                        }

                        if ($priceHideShow === "true"){
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

                        foreach ($newMetaDataForVariationsTableOverwrite as $newMetaDataForVariation){
                            $label    =  $newMetaDataForVariation["value"]; ?>
                            <th><?php echo esc_html($label); ?></th><?php
                        }

                        if ($quantityHideShow === "true"){
                            ?>
                            <th><?php esc_html_e('Quantity', 'variation-monster'); ?></th>
                            <?php
                        }?>
                    </tr>

                    <?php
                    $variations = $product->get_available_variations();

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

                    $variations_for_pagination = $product->get_available_variations();
                    $current_variation         = array_slice($variations_for_pagination, 0, $tableRowPagination);

                    foreach ($current_variation as $var) {
                        $variation_id             = $var['variation_id'];
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
                                        <span style="font-size: 11px; color: red; margin: 0; padding: 0"> <?php esc_html_e('Out of Stock', 'variation-monster'); ?> </span>
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
                                        // Start the table cell
                                        echo '<td class="quick-variable-title quick-attribute-text" data-attribute-name="' . esc_attr($attribute_name) . '">';

                                        if ($attribute->is_taxonomy()) {
                                            // For taxonomy attributes
                                            $attribute_id = wc_attribute_taxonomy_id_by_name($attribute_name);

                                            $meta_display_type = get_post_meta($post->ID, 'variation_meta_attribute_display_type_' . sanitize_title($attribute_name), true);

                                            if (empty($meta_display_type)){
                                                $display_type          = get_option( 'wc_attribute_display_type_' . $attribute_id );
                                            }else{
                                                $display_type = $meta_display_type;
                                            }
                                            $term = get_term_by('slug', $attribute_value, $attribute_name);
                                            if ($term) {
                                                if ($display_type === 'button' || $display_type === '') {
                                                    echo '<button type="button" class="custom-button"
                                                            style="background-color: ' . esc_attr($selectVariationButtonBgColor) . '; 
                                                            color: ' . esc_attr($selectVariationButtonTextColor) . ';">';
                                                    echo esc_html(apply_filters('woocommerce_variation_option_name', $term->name)); //phpcs:ignore
                                                    echo '</button>';
                                                } elseif ($display_type === 'color') {

                                                    $color            = null;
                                                    $secondary_color  = null;
                                                    $check_meta_color = get_post_meta($post->ID, 'variation_meta_attribute_color_' . $term->term_id . '_' . $attribute_id, true);
                                                    if (!empty($check_meta_color)) {
                                                        $color = get_post_meta($post->ID, 'variation_meta_attribute_color_' . $term->term_id . '_' . $attribute_id, true);
                                                    }else{
                                                        $color   = get_term_meta($term->term_id, 'term_color', true);
                                                    }

                                                    if (!empty($check_meta_secondary_color)) {
                                                        $secondary_color = get_post_meta($post->ID, 'variation_meta_attribute_secondary_color_' . $term->term_id . '_' . $attribute_id, true);
                                                    }else{
                                                        $secondary_color   = get_term_meta($term->term_id, 'term_secondary_color', true);
                                                    }

                                                    if ($color || $secondary_color){
                                                        echo '<button type="button" class="custom-color-button"style="';
                                                        if ($secondary_color) {
                                                            echo 'background: linear-gradient(to right, ' . esc_attr($color) . ' 50%, ' . esc_attr($secondary_color) . ' 50%);';
                                                        } else {
                                                            echo 'background-color: ' . esc_attr($color) . ';';
                                                        }
                                                        echo 'height: ' . esc_attr($imageColorHeight) . 'px; 
                                                            width: ' . esc_attr($imageColorWidth) . 'px; 
                                                            border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;">';
                                                        echo '</button>';
                                                    }else{
                                                        echo '<button type="button" class="custom-color-button"
                                                                style="height: ' . esc_attr($imageColorHeight) . 'px; 
                                                                width: ' . esc_attr($imageColorWidth) . 'px; 
                                                                border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;
                                                                padding: 0;">';
                                                        echo esc_html(apply_filters('woocommerce_variation_option_name', $attribute_value)); //phpcs:ignore
                                                        echo '</button>';
                                                    }
                                                } elseif ($display_type === 'image') {
                                                    $image_url = null;
                                                    $check_meta_image    = get_post_meta($post->ID, 'variation_meta_attribute_image_' . $term->term_id . '_' . $attribute_id, true);

                                                    if (!empty($check_meta_image)) {
                                                        $image_url = get_post_meta($post->ID, 'variation_meta_attribute_image_' . $term->term_id . '_' . $attribute_id, true);
                                                    }else{
                                                        $image_url = get_term_meta($term->term_id, 'term_image', true);
                                                    }

                                                    if ($image_url) {
                                                        echo '<button type="button" class="custom-image-button"
                                                                style="height: ' . esc_attr($imageColorHeight) . 'px; 
                                                                width: ' . esc_attr($imageColorWidth) . 'px; 
                                                                border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;
                                                                padding: 0; border: none; background: transparent;">';
                                                        // phpcs:ignore
                                                        echo '<img src="' . esc_url($image_url) . '" 
                                                               style="height: 100%; width: 100%; object-fit: cover; border-radius: inherit;">';
                                                        echo '</button>';
                                                    } else {
                                                        echo '<button type="button" class="custom-image-button"
                                                                style="height: ' . esc_attr($imageColorHeight) . 'px; 
                                                                width: ' . esc_attr($imageColorWidth) . 'px; 
                                                                border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;
                                                                padding: 0;">';
                                                        echo esc_html(apply_filters('woocommerce_variation_option_name', $attribute_value)); //phpcs:ignore
                                                        echo '</button>';
                                                    }
                                                }
                                            }
                                        } else {
                                            // For custom attributes
                                            $attribute_id = wc_attribute_taxonomy_id_by_name($attribute_name);
                                            $attribute_slug = $attribute_id ? sanitize_title(wc_get_attribute($attribute_id)->name) : sanitize_title($attribute_name);
                                            $display_type = get_post_meta($product->get_id(), 'variation_meta_attribute_display_type_' . $attribute_slug, true);

                                            if ($display_type === 'button' || empty($display_type)) {
                                                echo '<button type="button" class="custom-button"
                                                            style="background-color: ' . esc_attr($selectVariationButtonBgColor) . '; 
                                                            color: ' . esc_attr($selectVariationButtonTextColor) . ';">';
                                                echo esc_html(apply_filters('woocommerce_variation_option_name', $attribute_value)); //phpcs:ignore
                                                echo '</button>';
                                            } elseif ($display_type === 'color') {
                                                // Handle color display type for custom attribute
                                                $color = get_post_meta($product->get_id(), 'variation_meta_attribute_color_' . sanitize_title($attribute_value) . '_' . $attribute_id, true);
                                                $secondary_color = get_post_meta($product->get_id(), 'variation_meta_attribute_secondary_color_' . sanitize_title($attribute_value) . '_' . $attribute_id, true);

                                                if ($color || $secondary_color){
                                                    echo '<button type="button" class="custom-color-button" style="';
                                                    if ($secondary_color) {
                                                        echo 'background: linear-gradient(to right, ' . esc_attr($color) . ' 50%, ' . esc_attr($secondary_color) . ' 50%);';
                                                    } else {
                                                        echo 'background-color: ' . esc_attr($color) . ';';
                                                    }
                                                    echo 'height: ' . esc_attr($imageColorHeight) . 'px; 
                                                        width: ' . esc_attr($imageColorWidth) . 'px; 
                                                        border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;">';
                                                    echo '</button>';
                                                }else{
                                                    echo '<button type="button" class="custom-color-button"
                                                                style="height: ' . esc_attr($imageColorHeight) . 'px; 
                                                                width: ' . esc_attr($imageColorWidth) . 'px; 
                                                                border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;
                                                                padding: 0;">';
                                                    echo esc_html(apply_filters('woocommerce_variation_option_name', $attribute_value)); //phpcs:ignore
                                                    echo '</button>';
                                                }

                                            } elseif ($display_type === 'image') {

                                                $custom_value_slug = sanitize_title(sanitize_title($attribute_value));
                                                $image             = get_post_meta($post->ID, 'variation_meta_attribute_image_' . $custom_value_slug . '_' . $attribute_id, true);
                                                $image_url         = $image ? (is_numeric($image) ? wp_get_attachment_url($image) : esc_url($image)) : '';

                                                if ($image_url) {
                                                    echo '<button type="button" class="custom-image-button"
                                                                style="height: ' . esc_attr($imageColorHeight) . 'px; 
                                                                width: ' . esc_attr($imageColorWidth) . 'px; 
                                                                border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;
                                                                padding: 0; ">';
                                                    // phpcs:ignore
                                                    echo '<img src="' . esc_url($image_url) . '" 
                                                                style="height: 100%; width: 100%; object-fit: cover; border-radius: inherit;">';
                                                    echo '</button>';
                                                } else {
                                                    echo '<button type="button" class="custom-image-button"
                                                                style="height: ' . esc_attr($imageColorHeight) . 'px; 
                                                                width: ' . esc_attr($imageColorWidth) . 'px; 
                                                                border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;
                                                                padding: 0;">';
                                                    echo esc_html(apply_filters('woocommerce_variation_option_name', $attribute_value)); //phpcs:ignore
                                                    echo '</button>';
                                                }
                                            }
                                        }

                                        echo '</td>';
                                    }
                                }
                            }
                            ?>

                            <?php if ($priceHideShow === "true"){
                                ?>
                                <td class='variable-price quick-variable-title' data-regular-price="<?php echo esc_attr($variation->get_regular_price()); ?>" data-sale-price="<?php echo esc_attr($variation->get_sale_price()); ?>"><?php
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
                                            echo wp_kses_post(wc_price($sale_price_available_sorting)); // nosemgrep
                                            ?>
                                        </span>
                                    <?php }
                                    ?></td>
                                <?php
                            }

                            foreach ($newMetaDataForVariationsTableOverwrite as $newMetaDataForVariation){
                                $keyValue =  get_post_meta($variation_id, $newMetaDataForVariation["key"], true);
                                ?>
                                <td class="quick-variable-title"><?php echo esc_html($keyValue); ?></td><?php
                            }

                            if ($quantityHideShow === "true"){
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
                    ?>
                </table>

                <button  class="bulk-add-to-cart-before-cart"  id="bulk-add-to-cart-before-cart" data-carticon="<?php echo esc_attr($quickCartIcon ?: 'fa-cart-plus'); ?>"  data-productId="<?php echo esc_attr($product->get_id()); ?>"  style="border-radius: 5px ; outline: none; display: none; margin-bottom: 10px;">
                    <?php if (!empty($quickCartIconImageLink)): ?>
                        <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($quickCartIconImageLink); ?>"></span>
                    <?php else: ?>
                        <i class="<?php echo esc_attr($quickCartIcon); ?> cart-icon-remove" aria-hidden="true"></i>
                    <?php endif; ?>
                    <span><?php echo esc_html($cartButtonText); ?></span>
                    <span class="total-and-currency-sign"><?php esc_html_e('Total: ','variation-monster' ); ?></span>
                    <span class="total-price-count"></span>
                    <span class="bulk-add-to-cart-before-cart-success-icon"> </span>
                </button>

                <!-- Pagination Controls -->
                <div id="pagination">
                    <button disabled style="margin-right: 5px; padding: 5px; border-radius: 5px; font-weight: 500; <?php echo ($tableRowPagination >= $variation_count) ? ' display:none;' : ''; ?>" id="prevPage-before-cart" ><?php esc_html_e('Previous', 'variation-monster'); ?></button>
                    <button id="nextPage-before-cart" style="padding: 5px; border-radius: 5px; font-weight: 500; <?php echo ($tableRowPagination >= $variation_count) ? ' display:none;' : ''; ?> " ><?php esc_html_e('Next', 'variation-monster'); ?></button>
                </div>
            </div>
            <?php
        }

        ?>

        <script>
            jQuery(document).ready(function ($) {
                var $table        = jQuery("#quick-variable-table-before-cart");
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
                            action: 'variation_table_before_add_to_cart',
                            product_id: productId,
                            page: page,
                            pagination_nonce: quick_front_ajax_obj.nonce,
                        },
                        success: function (response) {
                            if (response.success) {
                                jQuery("#loading-spinner-pagination-table-before-cart").hide();
                                $table.find('tr.variation-row-before-cart').remove();
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
                    jQuery("#prevPage-before-cart").prop("disabled", currentPage === 1);
                    jQuery("#nextPage-before-cart").prop("disabled", currentPage === totalPages);
                }

                jQuery("#prevPage-before-cart").click(function () {

                    jQuery("#loading-spinner-pagination-table-before-cart").show();
                    jQuery(".table-template-max-width").css("opacity", "0.5");

                    setTimeout(function() {
                        jQuery("#loading-spinner-pagination-table-before-cart").hide();
                        jQuery(".table-template-max-width").css("opacity", "1");
                    }, 1000);


                    if (currentPage > 1) {
                        currentPage--;
                        resetCheckboxes()
                        loadPage(currentPage);
                    }
                });

                jQuery("#nextPage-before-cart").click(function () {

                    jQuery("#loading-spinner-pagination-table-before-cart").show();
                    jQuery("#quick-variable-table-before-cart").css("opacity", "0.5");

                    setTimeout(function() {
                        jQuery("#loading-spinner-pagination-table-before-cart").hide();
                        jQuery("#quick-variable-table-before-cart").css("opacity", "1");
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
                    const rows = $table.find(".variation-row-before-cart").toArray();
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
                    if (jQuery('.bulk_cart_before_add_to_cart:checked').length > 0) {
                        jQuery('.bulk-add-to-cart-before-cart').show();
                    } else {
                        jQuery('.bulk-add-to-cart-before-cart').hide();
                    }

                    /**
                     * Price Calculation for regular and sell. Firstly check sell then regular.
                     */
                    let totalPrice = 0;

                    jQuery('.bulk_cart_before_add_to_cart:checked').each(function () {
                        const $row = jQuery(this).closest('tr.variation-row-before-cart');
                        const $priceCell = $row.find('.variable-price');

                        // Get prices from data attributes
                        const salePrice = parseFloat($priceCell.data('sale-price')) || 0;
                        const regularPrice = parseFloat($priceCell.data('regular-price')) || 0;

                        // Use sale price if available, otherwise regular price
                        const price = salePrice > 0 ? salePrice : regularPrice;
                        const quantity = parseInt($row.find('.quick-quantity-input').val()) || 1;

                        totalPrice += price * quantity;
                    });

                    jQuery('.total-price-count').text(varimo_before_two_formated_price(totalPrice));

                }

                function resetCheckboxes() {
                    jQuery('#bulk_checkbox_select_all_before_cart').prop('checked', false);
                    jQuery('.bulk_cart_before_add_to_cart').prop('checked', false);
                    updateBulkCheckbox();
                }

                jQuery('#bulk_checkbox_select_all_before_cart').on('change', function () {
                    var isChecked = jQuery(this).prop('checked');
                    jQuery('.bulk_cart_before_add_to_cart').prop('checked', isChecked);
                    updateBulkCheckbox();
                });

                jQuery(document).on('change', '.bulk_cart_before_add_to_cart', function () {
                    const allChecked = jQuery('.bulk_cart_before_add_to_cart').length === jQuery('.bulk_cart_before_add_to_cart:checked').length;
                    jQuery('#bulk_checkbox_select_all_before_cart').prop('checked', allChecked);
                    updateBulkCheckbox();
                });

                // Update on quantity change
                jQuery(document).on('change', '.quick-quantity-input', function() {
                    updateBulkCheckbox(); // Recalculate total
                });


                reapplySorting();

                // if ($table.length > 0) {
                //     loadPage(currentPage);
                // }


                var removedRows = [];
                jQuery('#stock_status_before_cart').on('change', function () {
                    var isChecked = jQuery(this).prop('checked');

                    jQuery('.variation-row-before-cart').each(function () {
                        var stockStatus = jQuery(this).data('stock-status');

                        if (isChecked && stockStatus === 1) {
                            jQuery(this).show();
                            // jQuery(this).find('.quick-add-to-cart').css('min-width', '140px');
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
                            jQuery('#quick-variable-table-before-cart').append(removedRows[i].addClass('re-added-before-cart-table'));
                            // jQuery(this).find('.quick-add-to-cart').css('min-width', '140px');
                        }

                        removedRows = [];

                        jQuery('.re-added-before-cart-table').each(function () {
                            bindAddToCart(jQuery(this));
                            jQuery(this).removeClass('re-added-before-cart-table');
                        });

                    }
                });

                jQuery('#variation-search-before-cart').on('input', function () {
                    var searchTerm = jQuery(this).val().toLowerCase();

                    jQuery('.variation-row-before-cart').each(function () {
                        var rowContent = jQuery(this).text().toLowerCase();
                        if (rowContent.includes(searchTerm)) {
                            jQuery(this).show();
                        } else {
                            jQuery(this).hide();
                        }
                    });
                });

            });

            function varimo_before_two_formated_price(amount){

                let cur = quick_front_ajax_obj.currency_symbol;

                let pos = quick_front_ajax_obj.currency_position;

                let format = '%v %s';

                switch(pos) {

                    case 'right':

                        format = '%v%s';

                        break;

                    case 'left':

                        format = '%s%v';

                        break;

                    case 'right_space':

                        format = '%v %s';

                        break;

                    case 'left_space':

                        format = '%s %v';

                        break;

                }

                return accounting.formatMoney(amount, {

                    symbol: cur,

                    decimal: quick_front_ajax_obj.decimal_separator,

                    thousand: quick_front_ajax_obj.thousand_separator,

                    precision: quick_front_ajax_obj.number_of_decimals,

                    format: format

                });
            }

        </script>

        <style>

            #nextPage-before-cart:disabled, #prevPage-before-cart:disabled {
                opacity: 0.5;
            }

            .template-one-table #loading-spinner-pagination-table-before-cart {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 999;
            }

            #variation-search-before-cart{
                max-width:140px;
                max-height: 28px;
            }

            /* Force compact padding on all table cells */
            #quick-variable-table-before-cart.table-template1-before-cart th,
            #quick-variable-table-before-cart.table-template1-before-cart td {
                padding: 3px 5px !important; /* Very compact padding with !important */
                text-align: center !important;
                vertical-align: middle !important;
                font-size: 12px !important;
                line-height: 1.2 !important;
                border: 1px solid #ddd;
            }

            /* Override any inline styles on td elements */
            #quick-variable-table-before-cart.table-template1-before-cart td[style*="padding"] {
                padding: 3px 5px !important;
            }

            /* Compact header styling */
            #quick-variable-table-before-cart.table-template1-before-cart th {
                font-weight: 600;
                padding: 4px 6px !important;
            }

            /* Compact form inputs */
            #quick-variable-table-before-cart.table-template1-before-cart input[type="checkbox"] {
                margin: 0 !important;
                padding: 0 !important;
                width: 14px;
                height: 14px;
            }

            #quick-variable-table-before-cart.table-template1-before-cart input[type="number"] {
                width: 50px !important;
                padding: 2px 4px !important;
                font-size: 11px !important;
                height: 24px !important;
                margin: 0 !important;
            }

            #quick-variable-table-before-cart.table-template1-before-cart select {
                padding: 2px 4px !important;
                font-size: 11px !important;
                height: 24px !important;
                margin: 0 !important;
                max-width: 100px;
            }

            /* Compact icons */
            #quick-variable-table-before-cart.table-template1-before-cart .dashicons {
                font-size: 10px !important;
                width: 10px !important;
                height: 10px !important;
                line-height: 10px !important;
            }

            /* Compact quantity container */
            #quick-variable-table-before-cart.table-template1-before-cart .quick-quantity-container {
                margin-bottom: 2px !important;
                margin-top: 0 !important;
            }

            /* Compact text elements */
            #quick-variable-table-before-cart.table-template1-before-cart .quick-variable-title,
            #quick-variable-table-before-cart.table-template1-before-cart .quick-attribute-text,
            #quick-variable-table-before-cart.table-template1-before-cart .variable-price {
                font-size: 11px !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            #quick-variable-table-before-cart.table-template1-before-cart .quick-variable-title span,
            #quick-variable-table-before-cart.table-template1-before-cart .variable-price span {
                font-size: 11px !important;
                /*display: inline-block;*/
                margin: 0 !important;
            }

            /* Compact sort arrows */
            #quick-variable-table-before-cart.table-template1-before-cart .attribute-sort-arrows {
                display: grid !important;
                grid-gap: 0 !important;
                margin: 0 !important;
            }

            #quick-variable-table-before-cart.table-template1-before-cart .attribute-sort-arrows span {
                height: 6px !important;
                font-size: 8px !important;
                line-height: 6px !important;
            }

            /* Remove extra spacing from header spans */
            #quick-variable-table-before-cart.table-template1-before-cart th span {
                margin-top: 0 !important;
                display: inline-block;
                font-size: 12px !important;
            }

            /* Compact notification */
            #quick-variable-table-before-cart.table-template1-before-cart .quick-cart-notification {
                font-size: 10px !important;
                margin: 0 !important;
                padding: 2px !important;
            }

            /* Responsive adjustments for very small screens */
            @media (max-width: 768px) {
                #quick-variable-table-before-cart.table-template1-before-cart th,
                #quick-variable-table-before-cart.table-template1-before-cart td {
                    padding: 2px 3px !important;
                    font-size: 10px !important;
                }

                #quick-variable-table-before-cart.table-template1-before-cart input[type="number"] {
                    width: 40px !important;
                    font-size: 10px !important;
                }
            }

        </style>
        <?php
    }
}