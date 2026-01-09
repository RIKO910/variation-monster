<?php
if (!defined('ABSPATH')) exit;

global $product;
$varimoVariableSettings        = get_option("variable_all_checked", []);
$varimoVariableHoverClick      = isset($varimoVariableSettings['hoverClickValue'][0]) ? $varimoVariableSettings['hoverClickValue'][0] : 'variable-click';
$varimoTooltipPosition         = isset($varimoVariableSettings["boxPositionValue"][0]) ? $varimoVariableSettings["boxPositionValue"][0] : "";
$varimoVariableDetailsTitle    = isset($varimoVariableSettings["variableDetailsTitle"][0]) ? $varimoVariableSettings["variableDetailsTitle"][0] : "";
$varimoVariableSKU             = isset($varimoVariableSettings["variableDetailsSKU"][0]) ? $varimoVariableSettings["variableDetailsSKU"][0] : "";
$varimoVariableDetailsImage    = isset($varimoVariableSettings["variableDetailsImage"][0]) ? $varimoVariableSettings["variableDetailsImage"][0] : "";
$varimoVariableDetailsExcerpt  = isset($varimoVariableSettings["variableDetailsExcerpt"][0]) ? $varimoVariableSettings["variableDetailsExcerpt"][0] : "";
$varimoCartButtonText          = isset($varimoVariableSettings['cartButtonText']) ? $varimoVariableSettings['cartButtonText'] : 'Add-to-cart';
$varimoVariableAddToCartIcon   = isset($varimoVariableSettings['variableAddToCartIcon']) ? $varimoVariableSettings['variableAddToCartIcon'] : '';
$varimoNameImageRedirect       = isset($varimoVariableSettings['nameImageRedirect']) ? $varimoVariableSettings['nameImageRedirect'] : 'true';
$varimoAddToCartSuccessColor   = isset($varimoVariableSettings['addToCartSuccessColor']) ? $varimoVariableSettings['addToCartSuccessColor'] : '#fff';
$varimoQuickCartIcon           = isset($varimoVariableSettings['quickCartIcon']) ? $varimoVariableSettings['quickCartIcon'] : 'fa fa-shopping-cart';
$varimoQuickCartIconImageLink  = isset($varimoVariableSettings['quickCartIconImageLink']) ? $varimoVariableSettings['quickCartIconImageLink'] : '';
$varimoCarouselGalleryImageSize = isset($variableSetting['carouselGalleryImageSize']) ? $variableSetting['carouselGalleryImageSize'] : 'large';
$varimoShowDoublePrice         = isset($varimoVariableSettings['showDoublePrice']) ? $varimoVariableSettings['showDoublePrice'] : 'true';
$varimoMoreInfoTextChange      = isset($varimoVariableSettings['moreInfoTextChange']) ? $varimoVariableSettings['moreInfoTextChange'] : 'More Information';
$varimoNewMetaDataForVariations = isset($variableSetting['newMetaDataForVariations']) ? $variableSetting['newMetaDataForVariations'] : array();

$variations                      = $product->get_available_variations(); // phpcs:ignore
$varimo_all_variation_gallery_tooltip   =[];
$varimo_all_variation_price_sku_tooltip =[];
$varimoNewMetaShow                     =[];

// Loop to get images gallery
foreach ($variations as $varimo_variation) {
    $varimo_variation_id       = $varimo_variation['variation_id'];
    $varimo_variation_obj      = wc_get_product($varimo_variation_id);
    $varimo_thumbnail_id       = $varimo_variation_obj->get_image_id();
    $varimo_parent_image_url   = wp_get_attachment_image_url($varimo_thumbnail_id, $varimoCarouselGalleryImageSize);
    $varimo_gallery_images_id  = get_post_meta($varimo_variation_id, '_variation_gallery_images', true);
    $varimo_gallery_images_url = [];

    if (!empty($varimo_gallery_images_id)) {
        if (is_string($varimo_gallery_images_id)) {
            $varimo_gallery_images_id = explode(',', $varimo_gallery_images_id);
        }

        foreach ($varimo_gallery_images_id as $varimo_image_id) {
            $varimo_image_url = wp_get_attachment_image_url($varimo_image_id, $varimoCarouselGalleryImageSize);
            if ($varimo_image_url) {
                $varimo_gallery_images_url[] = esc_url($varimo_image_url);
            }
        }
    }

    array_unshift( $varimo_gallery_images_url, $varimo_parent_image_url );

    $varimo_all_variation_gallery_tooltip[$varimo_variation_id] = $varimo_gallery_images_url;
}

// Loop to get price and SKU
foreach ($variations as $varimo_variation) {
    $varimo_variation_id = $varimo_variation['variation_id'];
    $varimo_variation_obj = wc_get_product($varimo_variation_id); // Get variation as an object

    if ($varimoShowDoublePrice === 'true') {
        $varimo_price_html = $varimo_variation_obj->get_price_html(); // Get formatted price HTML
    } else {
        $varimo_sale_price = $varimo_variation_obj->get_sale_price();
        if ($varimo_sale_price) {
            $varimo_price_html = wc_price($varimo_sale_price);
        } else {
            $varimo_price_html = wc_price($varimo_variation_obj->get_regular_price());
        }
    }

    $varimo_variation_sku = isset($varimo_variation['sku']) ? $varimo_variation['sku'] : '';

    $varimo_all_variation_price_sku_tooltip[$varimo_variation_id] = [
            'price' => wp_kses_post($varimo_price_html), // Use wp_kses_post for HTML content
            'sku'   => esc_html($varimo_variation_sku),
    ];
}

// New Meta Show
foreach ($variations as $varimo_variation) {
    $varimo_variation_id = $varimo_variation['variation_id'];

    foreach ($varimoNewMetaDataForVariations as $varimo_newMetaDataForVariation){

        $varimo_keyValue =  get_post_meta($varimo_variation_id, $varimo_newMetaDataForVariation["key"], true);
        $varimo_label    =  $varimo_newMetaDataForVariation["value"];

        $varimoNewMetaShow[$varimo_variation_id][] =[
                'keyValue' => $varimo_keyValue,
                'label' => $varimo_label
        ];
    }
}
$varimo_is_block_theme = wp_is_block_theme();
$varimo_ignore_attr = $varimo_is_block_theme ? 'data-wp-ignore' : '';
?>

<div <?php echo esc_attr($varimo_ignore_attr); ?> <?php if ($varimoVariableHoverClick == "" ){ ?> style="display: none" <?php } ?> class="quick-variable-tooltip tooltiptext quick-hidden popup-template-four-modal"
                                            data-all-variation-gallery-tooltip='<?php echo esc_attr(json_encode($varimo_all_variation_gallery_tooltip)); ?>'
                                            data-all-variation-new-meta-show='<?php echo esc_attr(json_encode($varimoNewMetaShow)); ?>'
                                            data-all-variation-price-sku-tooltip='<?php echo esc_attr(json_encode($varimo_all_variation_price_sku_tooltip)); ?>'>

    <p><span onclick="varimoTemplateCloseButton()" class='closebtn quick-variable-tooltip-closebtn-template-four'>&times;</span></p>

    <div class="content-popup-template-four" >
        <?php if (!empty($varimoVariableDetailsImage) && !empty($varimoVariableSettings)) {
            ?>
            <div class="gallery-image-show-into-popup">
                <!-- Image Gallery Container -->
                <div class="quick-variable-gallery">
                    <!-- Navigation Buttons -->
                    <button style="outline: none" class="quick-gallery-prev" disabled>&#10094;</button>
                    <button style="outline: none" class="quick-gallery-next">&#10095;</button>

                    <!-- Active Image -->
                    <div class="quick-variable-active-image">
                        <?php // phpcs:ignore ?>
                        <img src="" alt="" >
                    </div>

                </div>
            </div>
            <?php
        } ?>

        <div id="quick-product-details" style="width: 100%; justify-content: end; align-items: stretch; padding: 0;">
            <div id="quick-product-content" class="quick-product-content-template-three">

                <?php if (!empty($varimoVariableDetailsTitle) && !empty($varimoVariableSettings)) {

                    if ($varimoNameImageRedirect === "true"){
                        ?>
                        <a href="#" class="dynamic-variation-url" target="_blank">
                            <h4 style="font-weight: 400; font-size: xx-large;text-align: left" class="<?php if (empty($varimoVariableDetailsTitle) && !empty($varimoVariableSettings)) { echo "quick-hidden"; } ?>"></h4>
                        </a>
                        <?php
                    }else{
                        ?>
                        <h4 style="font-weight: 400; font-size: xx-large;text-align: left" class="<?php if (empty($varimoVariableDetailsTitle) && !empty($varimoVariableSettings)) { echo "quick-hidden"; } ?>"></h4>
                        <?php
                    }
                } ?>

                <?php if (!empty($varimoVariableDetailsExcerpt) && !empty($varimoVariableSettings)) { ?>

                    <p style="font-size: x-large;text-align: left; margin-top:10px;" class="variable-short-desc <?php if (empty($varimoVariableDetailsExcerpt) && !empty($varimoVariableSettings)) { echo esc_attr("quick-hidden"); } ?>"></p>

                <?php } ?>

                <?php if (!empty($varimoVariableSKU) && !empty($varimoVariableSettings)) { ?>

                    <div style="display: flex; gap: 4px; font-size: large;text-align: left">
                        <strong><?php  echo esc_html("SKU:", 'variation-monster') ?> </strong>
                        <p class="variable-sku <?php if (empty($varimoVariableSKU) && !empty($varimoVariableSettings)) { echo esc_attr("quick-hidden"); } ?>"></p>
                    </div>

                <?php } ?>

                <p style="font-size:large;text-align: left"><strong><?php echo esc_html("Price:", 'variation-monster'); ?> </strong><span id="variable-product-price"></span></p>
                <div style="font-size:large;text-align: left; display: flex;flex-direction: column" id="new-meta-data-show-for-variation"></div>
                <div style="font-size: large;text-align: left; display: none" id="variable-product-variations"></div>

                <?php
                global $product;

                if ((is_product() || is_shop() || is_product_category()) ) {
                    $varimo_term_order = $this->get_product_term_order($product);
                    wp_localize_script('varimo-frontend-js', 'productTermOrder', $varimo_term_order);
                }

                if (!function_exists('varimo_variation_monster_carousel_template_four_attribute')) {
                    function varimo_variation_monster_carousel_template_four_attribute( $html, $args ) {
                        global $post;
                        global $product;
                        $variableSetting                 = get_option('variable_all_checked', array());
                        $globallyTooltipOnOff            = isset($variableSetting['globallyTooltipOnOff']) ? $variableSetting['globallyTooltipOnOff'] : '';
                        $imageShowIntoTooltip            = isset($variableSetting['imageShowIntoTooltip']) ? $variableSetting['imageShowIntoTooltip'] : '';
                        $selectVariationTooltipBgColor   = isset($variableSetting['selectVariationTooltipBgColor']) ? $variableSetting['selectVariationTooltipBgColor'] : '#000000';
                        $selectVariationTooltipTextColor = isset($variableSetting['selectVariationTooltipTextColor']) ? $variableSetting['selectVariationTooltipTextColor'] : '#FFFFFF';
                        $selectVariationButtonBgColor    = isset($variableSetting['selectVariationButtonBgColor']) ? $variableSetting['selectVariationButtonBgColor'] : '#0071a1';
                        $selectVariationButtonTextColor  = isset($variableSetting['selectVariationButtonTextColor']) ? $variableSetting['selectVariationButtonTextColor'] : '#FFFFFF';
                        $imageColorWidth                 = isset($variableSetting['imageColorWidth']) ? $variableSetting['imageColorWidth'] : '40';
                        $imageColorHeight                = isset($variableSetting['imageColorHeight']) ? $variableSetting['imageColorHeight'] : '40';
                        $imageColorBorderRadius          = isset($variableSetting['imageColorBorderRadius']) ? $variableSetting['imageColorBorderRadius'] : '50';
                        $tooltip                         = '';
                        $tooltip_image                   = '';
                        $varimo_term_order = [];
                        global $product;
                        $attributes = $product->get_attributes();

                        foreach ($attributes as $attribute_name => $attribute) {
                            if ($attribute->is_taxonomy()) {
                                // For taxonomy-based attributes
                                $terms = wc_get_product_terms($product->get_id(), $attribute_name, ['fields' => 'all']);
                                foreach ($terms as $index => $term) {
                                    $varimo_term_order[$attribute_name][$term->slug] = $index + 1;
                                }
                            } else {
                                // For custom attributes (non-taxonomy)
                                $attribute_values = $attribute->get_options(); // Get the values of the custom attribute
                                foreach ($attribute_values as $index => $value) {
                                    $varimo_term_order[$attribute_name][$value] = $index + 1; // Assign an index to each custom attribute value
                                }
                            }
                        }

                        /** @var array $args */
                        $args = wp_parse_args(apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args), [ // phpcs:ignore
                                'options'          => false,
                                'attribute'        => false,
                                'product'          => false,
                                'selected'         => false,
                                'name'             => '',
                                'id'               => '',
                                'class'            => '',
                                'show_option_none' => __('Choose an option', 'variation-monster'),
                        ]);

                        /** @var WC_Product_Variable $product */
                        $options          = $args['options'];
                        $product          = $args['product']; // phpcs:ignore
                        $attribute        = $args['attribute'];
                        $name             = $args['name'] ?: 'attribute_'.sanitize_title($attribute);
                        $id               = $args['id'] ?: sanitize_title($attribute);
                        $class            = $args['class'];
                        $show_option_none = (bool)$args['show_option_none'];



                        // Inside vb_custom_variation_buttons method
                        if (!empty($attribute)) {
                            if ($product && taxonomy_exists($attribute)) {
                                $attribute_id = null;
                                $attribute_slug = null;
                                // Debugging attribute data
                                if ($product instanceof WC_Product_Variable) {
                                    $attributes = $product->get_attributes();

                                    if (isset($attributes[$attribute])) {
                                        $attribute_data = $attributes[$attribute];

                                        if ($attribute_data->is_taxonomy()) {
                                            $attribute_id = $attribute_data->get_id();
                                            $attribute_slug = sanitize_title($attribute_data->get_name());
                                        }
                                    }
                                }

                                $meta_display_type = get_post_meta($post->ID, 'variation_meta_attribute_display_type_' . $attribute_slug, true);

                                if (empty($meta_display_type)){
                                    $display_type          = get_option( 'wc_attribute_display_type_' . $attribute_id );
                                }else{
                                    $display_type = $meta_display_type;
                                }
                                $show_option_none_text = $args['show_option_none'] ?: __('Choose an option', 'variation-monster');

                                // Get selected value.
//                        if ($attribute && $product instanceof WC_Product && $args['selected'] === false) {
//                            $selected_key     = 'attribute_'.sanitize_title($attribute);
//                            $args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key]))
//                                : $product->get_variation_default_attribute($attribute);
//                        }

                                if (empty($options) && ! empty($product) && ! empty($attribute)) {
                                    $attributes = $product->get_variation_attributes();
                                    $options    = $attributes[$attribute];
                                }
                                if ($display_type === 'radio') {

                                    $radios = '<div class="custom-wc-variations" style="margin-top: 10px">';

                                    // Add the attribute label
                                    $label = wc_attribute_label($attribute, $product);
                                    $radios .= '<div class="attribute-label-varaition-monster">' . esc_html($label) . ' : </div>';

                                    if ( ! empty($options)) {
                                        if ($product && taxonomy_exists($attribute)) {
                                            $terms              = wc_get_product_terms($product->get_id(), $attribute, ['fields' => 'all']);
                                            $variations_by_term = varimo_available_variations_by_term($product, $attribute);
                                            $variations         = $product->get_available_variations();

                                            foreach ($terms as $term) {

                                                $any_size_variations = array_filter($variations, function ($variation) use ($attribute) {
                                                    foreach ($variation['attributes'] as $key => $value) {
                                                        if (
                                                            strpos($key, 'attribute_pa_') !== false &&
                                                            (empty($value) || strpos($value, 'any') === 0)
                                                        ) {
                                                            return true;
                                                        }
                                                    }
                                                    return false;
                                                });

                                                $term_variations      = isset($variations_by_term[$term->slug]) ? $variations_by_term[$term->slug] : [];
                                                $available_variations = array_merge($term_variations, $any_size_variations);
                                                $variations_json      = htmlspecialchars(wp_json_encode($available_variations), ENT_QUOTES, 'UTF-8');

                                                if (in_array($term->slug, $options, true)) {

                                                    $radios .= '<input type="radio" name="custom_'.esc_attr($name).'" 
                                    data-available-variations="' . esc_attr($variations_json) . '" 
                                    data-value="'.esc_attr($term->slug).'" id="'
                                                            .esc_attr($name).'_'.esc_attr($term->slug).'" data-variation-name="'.esc_attr($name).'" '
                                                            .checked(sanitize_title($args['selected']), $term->slug, false).'>';
                                                    $radios .= '<label for="'.esc_attr($name).'_'.esc_attr($term->slug).'">';
                                                    $radios .= esc_html(apply_filters('woocommerce_variation_option_name', $term->name)); // phpcs:ignore
                                                    $radios .= '</label>';

                                                }
                                            }
                                        } else {
                                            foreach ($options as $option) {
                                                $checked = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'],
                                                        sanitize_title($option), false) : checked($args['selected'], $option, false);
                                                $radios  .= '<input type="radio" name="custom_'.esc_attr($name).'"
                                data-value="'.esc_attr($option).'" id="'
                                                        .esc_attr($name).'_'.esc_attr($option).'" data-variation-name="'.esc_attr($name).'" '.$checked.'>';
                                                $radios  .= '<label for="'.esc_attr($name).'_'.esc_attr($option).'">';
                                                $radios  .= esc_html(apply_filters('woocommerce_variation_option_name', $option)); // phpcs:ignore
                                                $radios  .= '</label>';
                                            }
                                        }
                                    }

                                    $radios .= '</div>';

                                    return $html.$radios;
                                }elseif ($display_type === 'button' || $display_type === "select" || empty($display_type)) {

                                    $buttons    = '<div class="custom-wc-buttons" style="margin-top: 10px; flex-wrap: wrap">';

                                    // Add the attribute label
                                    $label = wc_attribute_label($attribute, $product);
                                    $buttons .= '<div class="attribute-label-varaition-monster">' . esc_html($label) . ' : </div>';

                                    $product_id = $product->get_id();

                                    if (!empty($options)) {
                                        if ($product && taxonomy_exists($attribute)) {
                                            $terms              = wc_get_product_terms($product->get_id(), $attribute, ['fields' => 'all']);
                                            $variations_by_term = varimo_available_variations_by_term($product, $attribute);
                                            $variations         = $product->get_available_variations();

                                            foreach ($terms as $term) {
                                                if (in_array($term->slug, $options, true)) {
                                                    $selected            = sanitize_title($args['selected']) === $term->slug ? 'selected' : '';
                                                    $term_id             = $term->term_id;
                                                    $check_meta_tooltip  = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $term_id . '_' . $attribute_id, true);
                                                    $any_size_variations = array_filter($variations, function ($variation) use ($attribute) {
                                                        foreach ($variation['attributes'] as $key => $value) {
                                                            if (
                                                                strpos($key, 'attribute_pa_') !== false &&
                                                                (empty($value) || strpos($value, 'any') === 0)
                                                            ) {
                                                                return true;
                                                            }
                                                        }
                                                        return false;
                                                    });

                                                    $term_variations      = isset($variations_by_term[$term->slug]) ? $variations_by_term[$term->slug] : [];
                                                    $available_variations = array_merge($term_variations, $any_size_variations);
                                                    $variations_json      = htmlspecialchars(wp_json_encode($variations), ENT_QUOTES, 'UTF-8');

                                                    if (!empty($check_meta_tooltip) && $globallyTooltipOnOff === 'true') {
                                                        $tooltip = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $term_id . '_' . $attribute_id, true);
                                                    }else{
                                                        if ($globallyTooltipOnOff === 'true'){
                                                            $tooltip = get_term_meta($term_id, 'term_tooltip', true);
                                                        }
                                                    }
                                                    if (empty($tooltip) && $globallyTooltipOnOff === 'true'){
                                                        $tooltip = $term->name;
                                                    }

                                                    if ($globallyTooltipOnOff === 'true' && $imageShowIntoTooltip === 'true'){
                                                        $tooltip_image  = get_post_meta($post->ID, 'tooltip_meta_term_image_' . $term_id . '_' . $attribute_id, true);
                                                    }

                                                    $buttons .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-button ' . esc_attr($selected) . '" 
                                                            data-value="' . esc_attr($term->slug) . '" 
                                                            data-product_id="' . esc_attr($product_id) . '" 
                                                            data-variation-name="' . esc_attr($name) . '" 
                                                            data-tooltip="' . esc_attr($tooltip) . '" 
                                                            data-tooltip-image="' . esc_attr($tooltip_image) . '"
                                                            data-term-order=\'' . esc_attr(wp_json_encode($varimo_term_order)) . '\'
                                                            data-available_variations="' . esc_attr($variations_json) . '" 
                                                            data-tooltip-bg-color="' . esc_attr($selectVariationTooltipBgColor) . '" 
                                                            data-tooltip-text-color="' . esc_attr($selectVariationTooltipTextColor) . '"
                                                            style=" background-color: ' . esc_attr($selectVariationButtonBgColor) . '; 
                                                            color: ' . esc_attr($selectVariationButtonTextColor) . ';">';
                                                    $buttons .= esc_html(apply_filters('woocommerce_variation_option_name', $term->name)); // phpcs:ignore
                                                    $buttons .= '</button>';
                                                }
                                            }
                                        } else {
                                            foreach ($options as $option) {
                                                $selected = sanitize_title($args['selected']) === $option ? 'selected' : '';
                                                $buttons .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-button ' . esc_attr($selected) . '" 
                                data-value="' . esc_attr($option) . '" 
                                data-variation-name="' . esc_attr($name) . '">';
                                                $buttons .= esc_html(apply_filters('woocommerce_variation_option_name', $option)); // phpcs:ignore
                                                $buttons .= '</button>';
                                            }
                                        }
                                    }

                                    $buttons .= '</div>';

                                    return $html . $buttons;
                                }elseif ($display_type === 'image') {
                                    $product_id = $product->get_id();
                                    $images = '<div class="custom-wc-images" style="margin-top: 10px; flex-wrap: wrap">';

                                    // Add the attribute label
                                    $label = wc_attribute_label($attribute, $product);
                                    $images .= '<div class="attribute-label-varaition-monster">' . esc_html($label) . ' : </div>';

                                    if (!empty($options)) {
                                        if ($product && taxonomy_exists($attribute)) {
                                            $terms              = wc_get_product_terms($product->get_id(), $attribute, ['fields' => 'all']);
                                            $variations_by_term = varimo_available_variations_by_term($product, $attribute);
                                            $variations         = $product->get_available_variations();

                                            foreach ($terms as $term) {
                                                if (in_array($term->slug, $options, true)) {
                                                    $selected            = sanitize_title($args['selected']) === $term->slug ? 'selected' : '';
                                                    $term_id             = $term->term_id;
                                                    $check_meta_tooltip  = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $term_id . '_' . $attribute_id, true);
                                                    $check_meta_image    = get_post_meta($post->ID, 'variation_meta_attribute_image_' . $term_id . '_' . $attribute_id, true);
                                                    $any_size_variations = array_filter($variations, function ($variation) use ($attribute) {
                                                        foreach ($variation['attributes'] as $key => $value) {
                                                            if (
                                                                strpos($key, 'attribute_pa_') !== false &&
                                                                (empty($value) || strpos($value, 'any') === 0)
                                                            ) {
                                                                return true;
                                                            }
                                                        }
                                                        return false;
                                                    });

                                                    $term_variations      = isset($variations_by_term[$term->slug]) ? $variations_by_term[$term->slug] : [];
                                                    $available_variations = array_merge($term_variations, $any_size_variations);
                                                    $variations_json      = htmlspecialchars(wp_json_encode($variations), ENT_QUOTES, 'UTF-8');


                                                    if (!empty($check_meta_tooltip) && $globallyTooltipOnOff === 'true') {
                                                        $tooltip = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $term_id . '_' . $attribute_id, true);
                                                    }else{
                                                        if ($globallyTooltipOnOff === 'true'){
                                                            $tooltip = get_term_meta($term_id, 'term_tooltip', true);
                                                        }
                                                    }
                                                    if (empty($tooltip) && $globallyTooltipOnOff === 'true'){
                                                        $tooltip = $term->name;
                                                    }

                                                    if ($globallyTooltipOnOff === 'true' && $imageShowIntoTooltip === 'true'){
                                                        $tooltip_image  = get_post_meta($post->ID, 'tooltip_meta_term_image_' . $term_id . '_' . $attribute_id, true);
                                                    }

                                                    if (!empty($check_meta_image)) {
                                                        $image = get_post_meta($post->ID, 'variation_meta_attribute_image_' . $term_id . '_' . $attribute_id, true);
                                                    }else{
                                                        $image   = get_term_meta($term_id, 'term_image', true);
                                                    }

                                                    $image_url = $image ? (is_numeric($image) ? wp_get_attachment_url($image) : esc_url($image)) : '';

                                                    $images .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-image-button ' . esc_attr($selected) . '" 
                                                        data-value="' . esc_attr($term->slug) . '" 
                                                        data-product_id="' . esc_attr($product_id) . '" 
                                                        data-variation-name="' . esc_attr($name) . '" 
                                                        data-tooltip="' . esc_attr($tooltip) . '" 
                                                        data-tooltip-image="' . esc_attr($tooltip_image) . '"
                                                        data-term-order=\'' . esc_attr(wp_json_encode($varimo_term_order)) . '\'
                                                        data-available_variations="' . esc_attr($variations_json) . '"
                                                        data-tooltip-bg-color="' . esc_attr($selectVariationTooltipBgColor) . '" 
                                                        data-tooltip-text-color="' . esc_attr($selectVariationTooltipTextColor) . '"
                                                        style=" height: ' . esc_attr($imageColorHeight) . 'px; 
                                                        width: ' . esc_attr($imageColorWidth) . 'px; 
                                                        border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;">';

                                                    if ($image_url) {
                                                        $image_id = attachment_url_to_postid($image_url);
                                                        if ($image_id) {
                                                            $images .= wp_get_attachment_image($image_id, 'full', false, [
                                                                    'alt'   => esc_attr($term->name),
                                                                    'style' => 'height: ' . esc_attr($imageColorHeight) . 'px; 
                                                                    width: ' . esc_attr($imageColorWidth) . 'px; 
                                                                    border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;',
                                                            ]);
                                                        }

                                                    } else {
                                                        $images .= '<span class="term-name">' . esc_html($term->name) . '</span>';
                                                    }

                                                    $images .= '</button>';
                                                }
                                            }
                                        }
                                    }

                                    $images .= '</div>';

                                    return $html . $images;
                                }elseif ($display_type === "color") {
                                    $product_id = $product->get_id();
                                    $colors = '<div class="custom-wc-colors" style="margin-top: 10px; flex-wrap: wrap">';

                                    // Add the attribute label
                                    $label = wc_attribute_label($attribute, $product);
                                    $colors .= '<div class="attribute-label-varaition-monster">' . esc_html($label) . ' : </div>';

                                    if (!empty($options)) {
                                        if ($product && taxonomy_exists($attribute)) {
                                            $terms              = wc_get_product_terms($product->get_id(), $attribute, ['fields' => 'all']);
                                            $variations_by_term = varimo_available_variations_by_term($product, $attribute);
                                            $variations         = $product->get_available_variations();


                                            foreach ($terms as $term) {
                                                if (in_array($term->slug, $options, true)) {

                                                    $selected           = sanitize_title($args['selected']) === $term->slug ? 'selected' : '';
                                                    $term_id            = $term->term_id;
                                                    $check_meta_tooltip = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $term_id . '_' . $attribute_id, true);
                                                    $check_meta_color   = get_post_meta($post->ID, 'variation_meta_attribute_color_' . $term_id . '_' . $attribute_id, true);
                                                    $check_meta_secondary_color   = get_post_meta($post->ID, 'variation_meta_attribute_secondary_color_' . $term_id . '_' . $attribute_id, true);
                                                    $any_size_variations = array_filter($variations, function ($variation) use ($attribute) {
                                                        foreach ($variation['attributes'] as $key => $value) {
                                                            if (
                                                                strpos($key, 'attribute_pa_') !== false &&
                                                                (empty($value) || strpos($value, 'any') === 0)
                                                            ) {
                                                                return true;
                                                            }
                                                        }
                                                        return false;
                                                    });

                                                    $term_variations      = isset($variations_by_term[$term->slug]) ? $variations_by_term[$term->slug] : [];
                                                    $available_variations = array_merge($term_variations, $any_size_variations);
                                                    $variations_json      = htmlspecialchars(wp_json_encode($variations), ENT_QUOTES, 'UTF-8');


                                                    if (!empty($check_meta_tooltip) && $globallyTooltipOnOff === 'true') {
                                                        $tooltip = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $term_id . '_' . $attribute_id, true);
                                                    }else{
                                                        if ($globallyTooltipOnOff === 'true'){
                                                            $tooltip = get_term_meta($term_id, 'term_tooltip', true);
                                                        }
                                                    }

                                                    if (empty($tooltip) && $globallyTooltipOnOff === 'true'){
                                                        $tooltip = $term->name;
                                                    }

                                                    if ($globallyTooltipOnOff === 'true' && $imageShowIntoTooltip === 'true'){
                                                        $tooltip_image  = get_post_meta($post->ID, 'tooltip_meta_term_image_' . $term_id . '_' . $attribute_id, true);
                                                    }

                                                    if (!empty($check_meta_color)) {
                                                        $color = get_post_meta($post->ID, 'variation_meta_attribute_color_' . $term_id . '_' . $attribute_id, true);
                                                    }else{
                                                        $color   = get_term_meta($term_id, 'term_color', true);
                                                    }

                                                    if (!empty($check_meta_secondary_color)) {
                                                        $secondary_color = get_post_meta($post->ID, 'variation_meta_attribute_secondary_color_' . $term_id . '_' . $attribute_id, true);
                                                    }else{
                                                        $secondary_color   = get_term_meta($term_id, 'term_secondary_color', true);
                                                    }

                                                    if (!empty($color)) {

                                                        if ($secondary_color){
                                                            $colors .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-color-button ' . esc_attr($selected) . '" 
                                                               data-value="' . esc_attr($term->slug) . '" 
                                                               data-product_id="' . esc_attr($product_id) . '" 
                                                               data-variation-name="' . esc_attr($name) . '" 
                                                               data-tooltip="' . esc_attr($tooltip) . '" 
                                                               data-tooltip-image="' . esc_attr($tooltip_image) . '"
                                                               data-term-order=\'' . esc_attr(wp_json_encode($varimo_term_order)) . '\'
                                                               data-available_variations="' . esc_attr($variations_json) . '" 
                                                               data-tooltip-bg-color="' . esc_attr($selectVariationTooltipBgColor) . '" 
                                                               data-tooltip-text-color="' . esc_attr($selectVariationTooltipTextColor) . '" 
                                                               style="background: linear-gradient(to right, ' . esc_attr($color) . ' 50%, ' . esc_attr($secondary_color) . ' 50%); 
                                                               height: ' . esc_attr($imageColorHeight) . 'px; 
                                                               width: ' . esc_attr($imageColorWidth) . 'px; 
                                                               border-radius: ' . esc_attr($imageColorBorderRadius) . 'px; 
                                                               display: flex; 
                                                               justify-content: center; 
                                                               align-items: center;">';

                                                            $colors .= '<span class="color-label">' . esc_html($term->name) . '</span>';
                                                        }else{
                                                            $colors .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-color-button ' . esc_attr($selected) . '" 
                                                                   data-value="' . esc_attr($term->slug) . '" 
                                                                   data-product_id="' . esc_attr($product_id) . '" 
                                                                   data-variation-name="' . esc_attr($name) . '" 
                                                                   data-tooltip="' . esc_attr($tooltip) . '" 
                                                                   data-tooltip-image="' . esc_attr($tooltip_image) . '"
                                                                   data-term-order=\'' . esc_attr(wp_json_encode($varimo_term_order)) . '\'
                                                                   data-available_variations="' . esc_attr($variations_json) . '" 
                                                                   data-tooltip-bg-color="' . esc_attr($selectVariationTooltipBgColor) . '" 
                                                                   data-tooltip-text-color="' . esc_attr($selectVariationTooltipTextColor) . '" 
                                                                   style=" background-color: ' . esc_attr($color) . '; 
                                                                   height: ' . esc_attr($imageColorHeight) . 'px; 
                                                                   width: ' . esc_attr($imageColorWidth) . 'px; 
                                                                   border-radius: ' . esc_attr($imageColorBorderRadius) . 'px; 
                                                                   display: flex; 
                                                                   justify-content: center; 
                                                                   align-items: center;">';

                                                            $colors .= '<span class="color-label">' . esc_html($term->name) . '</span>';
                                                        }
                                                    } else {

                                                        $colors .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-color-button ' . esc_attr($selected) . '" 
                                                           data-value="' . esc_attr($term->slug) . '" 
                                                           data-product_id="' . esc_attr($product_id) . '" 
                                                           data-variation-name="' . esc_attr($name) . '" 
                                                           data-tooltip="' . esc_attr($tooltip) . '"  
                                                           data-tooltip-image="' . esc_attr($tooltip_image) . '"
                                                           data-term-order=\'' . esc_attr(wp_json_encode($varimo_term_order)) . '\'
                                                           data-available_variations="' . esc_attr($variations_json) . '" 
                                                           data-tooltip-bg-color="' . esc_attr($selectVariationTooltipBgColor) . '" 
                                                           data-tooltip-text-color="' . esc_attr($selectVariationTooltipTextColor) . '" 
                                                           style=" background-color: ' . esc_attr($color) . '; 
                                                           height: ' . esc_attr($imageColorHeight) . 'px; 
                                                           width: ' . esc_attr($imageColorWidth) . 'px; 
                                                           border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;  
                                                           justify-content: center; align-items: center;">';

                                                        $colors .= '<span class="term-name">' . esc_html($term->name) . '</span>';
                                                    }
                                                    $colors .= '</button>';

                                                    $colors .= '</button>';
                                                }
                                            }
                                        }
                                    }

                                    $colors .= '</div>';

                                    return $html . $colors;
                                }
                            } else {
                                $attribute_id = wc_attribute_taxonomy_id_by_name($attribute);
                                $attribute_slug = null;
                                if ($attribute_id) {
                                    $attribute_obj = wc_get_attribute($attribute_id);
                                    if ($attribute_obj) {
                                        $attribute_slug = sanitize_title($attribute_obj->name);
                                    }
                                } else {
                                    $attribute_slug = sanitize_title($attribute);
                                }
                                $display_type = get_post_meta($post->ID, 'variation_meta_attribute_display_type_' . $attribute_slug, true);

                                if ($display_type === "button" || $display_type === "select" || empty($display_type)) {

                                    $buttons = '<div class="custom-wc-buttons" style="margin-top: 10px; flex-wrap: wrap;">';

                                    // Add the attribute label
                                    $label = wc_attribute_label($attribute, $product);
                                    $buttons .= '<div class="attribute-label-varaition-monster">' . esc_html($label) . ' : </div>';

                                    $tooltip = '';
                                    $product_id = $product->get_id();
                                    $variations         = $product->get_available_variations();
                                    $variations_json      = htmlspecialchars(wp_json_encode($variations), ENT_QUOTES, 'UTF-8');

                                    if (!empty($options)) {
                                        foreach ($options as $option) {

                                            $selected          = sanitize_title($args['selected']) === $option ? 'selected' : '';
                                            $custom_value_slug = sanitize_title($option);

                                            if ($globallyTooltipOnOff === 'true'){
                                                if ($imageShowIntoTooltip === 'true'){
                                                    $tooltip_image     = get_post_meta($post->ID, 'tooltip_meta_term_image_' . $custom_value_slug . '_' . $attribute_id, true);
                                                }
                                                $tooltip           = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $custom_value_slug . '_' . $attribute_id, true);
                                            }

                                            if (empty($tooltip) && $globallyTooltipOnOff === 'true'){
                                                if (is_object($option)) {
                                                    $tooltip = $option->name;
                                                } else {
                                                    $tooltip = $option;
                                                }

                                            }

                                            $buttons .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-button ' . esc_attr($selected) . '" 
                                                data-value="' . esc_attr($option) . '" 
                                                data-variation-name="' . esc_attr($name) . '"
                                                data-tooltip="' . esc_attr($tooltip) . '" 
                                                data-tooltip-image="' . esc_attr($tooltip_image) . '"
                                                data-product_id="' . esc_attr($product_id) . '" 
                                                data-available_variations="' . esc_attr($variations_json) . '" 
                                                data-term-order=\'' . esc_attr(wp_json_encode($varimo_term_order)) . '\'
                                                data-tooltip-bg-color="' . esc_attr($selectVariationTooltipBgColor) . '" 
                                                data-tooltip-text-color="' . esc_attr($selectVariationTooltipTextColor) . '"
                                                style=" background-color: ' . esc_attr($selectVariationButtonBgColor) . '; 
                                                color: ' . esc_attr($selectVariationButtonTextColor) . ';">';
                                            $buttons .= esc_html(apply_filters('woocommerce_variation_option_name', $option)); // phpcs:ignore
                                            $buttons .= '</button>';
                                        }
                                    }

                                    $buttons .= '</div>';

                                    return $html . $buttons;
                                }elseif ($display_type === 'radio') {

                                    $radios = '<div class="custom-wc-variations" style="margin-top: 10px;">';

                                    // Add the attribute label
                                    $label = wc_attribute_label($attribute, $product);
                                    $radios .= '<div class="attribute-label-varaition-monster">' . esc_html($label) . ' : </div>';

                                    if ( ! empty($options)) {
                                        foreach ($options as $option) {
                                            $checked = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'],
                                                    sanitize_title($option), false) : checked($args['selected'], $option, false);
                                            $radios  .= '<input type="radio" name="custom_'.esc_attr($name).'" data-value="'.esc_attr($option).'" id="'
                                                    .esc_attr($name).'_'.esc_attr($option).'" data-variation-name="'.esc_attr($name).'" '.$checked.'>';
                                            $radios  .= '<label for="'.esc_attr($name).'_'.esc_attr($option).'">';
                                            $radios  .= esc_html(apply_filters('woocommerce_variation_option_name', $option)); // phpcs:ignore
                                            $radios  .= '</label>';
                                        }
                                    }

                                    $radios .= '</div>';

                                    return $html.$radios;
                                }elseif ($display_type === 'image') {

                                    $images = '<div class="custom-wc-images" style="margin-top: 10px; flex-wrap: wrap;">';

                                    // Add the attribute label
                                    $label = wc_attribute_label($attribute, $product);
                                    $images .= '<div class="attribute-label-varaition-monster">' . esc_html($label) . ' : </div>';

                                    $tooltip = '';

                                    if (!empty($options)) {
                                        foreach ($options as $option) {

                                            $product_id        = $product->get_id();
                                            $variations        = $product->get_available_variations();
                                            $variations_json   = htmlspecialchars(wp_json_encode($variations), ENT_QUOTES, 'UTF-8');
                                            $custom_value_slug = sanitize_title($option);
                                            $selected          = sanitize_title($args['selected']) === $option ? 'selected' : '';
                                            $image             = get_post_meta($post->ID, 'variation_meta_attribute_image_' . $custom_value_slug . '_' . $attribute_id, true);
                                            $image_url         = $image ? (is_numeric($image) ? wp_get_attachment_url($image) : esc_url($image)) : '';

                                            if ($globallyTooltipOnOff === 'true'){
                                                if ($imageShowIntoTooltip === 'true'){
                                                    $tooltip_image     = get_post_meta($post->ID, 'tooltip_meta_term_image_' . $custom_value_slug . '_' . $attribute_id, true);
                                                }
                                                $tooltip           = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $custom_value_slug . '_' . $attribute_id, true);
                                            }

                                            if (empty($tooltip) && $globallyTooltipOnOff === 'true'){
                                                if (is_object($option)) {
                                                    $tooltip = $option->name;
                                                } else {
                                                    $tooltip = $option;
                                                }

                                            }

                                            $images .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-image-button ' . esc_attr($selected) . '" 
                                                data-value="' . esc_attr($option) . '" 
                                                data-variation-name="' . esc_attr($name) . '" 
                                                data-tooltip="' . esc_attr($tooltip) . '" 
                                                data-tooltip-image="' . esc_attr($tooltip_image) . '"
                                                 data-product_id="' . esc_attr($product_id) . '" 
                                                data-available_variations="' . esc_attr($variations_json) . '" 
                                                data-term-order=\'' . esc_attr(wp_json_encode($varimo_term_order)) . '\'
                                                data-tooltip-bg-color="' . esc_attr($selectVariationTooltipBgColor) . '" 
                                                data-tooltip-text-color="' . esc_attr($selectVariationTooltipTextColor) . '"
                                                style=" height: ' . esc_attr($imageColorHeight) . 'px; 
                                                width: ' . esc_attr($imageColorWidth) . 'px; 
                                                border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;">';

                                            if ($image_url) {
                                                $image_id = attachment_url_to_postid($image_url);
                                                if ($image_id) {
                                                    $images .= wp_get_attachment_image($image_id, 'full', false, [
                                                        'alt'   => esc_attr($option),
                                                        'style' => 'height: ' . esc_attr($imageColorHeight) . 'px; 
                                                 width: ' . esc_attr($imageColorWidth) . 'px; 
                                                 border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;',
                                                    ]);
                                                }
                                            } else {

                                                $images .= '<span class="term-name">' . esc_html($option) . '</span>';
                                            }

                                            $images .= '</button>';
                                        }
                                    }

                                    $images .= '</div>';

                                    return $html . $images;
                                }elseif ($display_type === "color") {

                                    $colors = '<div class="custom-wc-colors" style="margin-top: 10px; flex-wrap: wrap;">';

                                    // Add the attribute label
                                    $label   = wc_attribute_label($attribute, $product);
                                    $colors .= '<div class="attribute-label-varaition-monster">' . esc_html($label) . ' : </div>';

                                    $tooltip = '';

                                    if (!empty($options)) {
                                        foreach ($options as $option) {

                                            $product_id        = $product->get_id();
                                            $variations        = $product->get_available_variations();
                                            $variations_json   = htmlspecialchars(wp_json_encode($variations), ENT_QUOTES, 'UTF-8');
                                            $custom_value_slug = sanitize_title($option);
                                            // Sanitize and match the selected value
                                            $option_value = is_object($option) ? sanitize_title($option->name) : sanitize_title($option);
                                            $selected = $option_value === sanitize_title($args['selected']) ? 'selected' : '';

                                            $color             = get_post_meta($post->ID, 'variation_meta_attribute_color_' . $custom_value_slug . '_' . $attribute_id, true);
                                            $secondary_color   = get_post_meta($post->ID, 'variation_meta_attribute_secondary_color_' . $custom_value_slug . '_' . $attribute_id, true);

                                            if ($globallyTooltipOnOff === 'true'){
                                                if ($imageShowIntoTooltip === 'true'){
                                                    $tooltip_image     = get_post_meta($post->ID, 'tooltip_meta_term_image_' . $custom_value_slug . '_' . $attribute_id, true);
                                                }
                                                $tooltip           = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $custom_value_slug . '_' . $attribute_id, true);
                                            }

                                            if (empty($tooltip) && $globallyTooltipOnOff === 'true'){
                                                if (is_object($option)) {
                                                    $tooltip = $option->name;
                                                } else {
                                                    $tooltip = $option;
                                                }
                                            }

                                            if (!empty($color)) {

                                                if ($secondary_color){

                                                    $colors .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-color-button ' . esc_attr($selected) . '" 
                                                       data-value="' . esc_attr($option) . '" 
                                                       data-variation-name="' . esc_attr($name) . '" 
                                                       data-tooltip="' . esc_attr($tooltip) . '" 
                                                       data-tooltip-image="' . esc_attr($tooltip_image) . '"
                                                       data-product_id="' . esc_attr($product_id) . '" 
                                                       data-available_variations="' . esc_attr($variations_json) . '"
                                                       data-term-order=\'' . esc_attr(wp_json_encode($varimo_term_order)) . '\'
                                                       data-label-name="' . esc_attr($option) . '" 
                                                       data-tooltip-bg-color="' . esc_attr($selectVariationTooltipBgColor) . '" 
                                                       data-tooltip-text-color="' . esc_attr($selectVariationTooltipTextColor) . '" 
                                                       style="background: linear-gradient(to right, ' . esc_attr($color) . ' 50%, ' . esc_attr($secondary_color) . ' 50%); 
                                                       height: ' . esc_attr($imageColorHeight) . 'px; 
                                                       width: ' . esc_attr($imageColorWidth) . 'px; 
                                                       border-radius: ' . esc_attr($imageColorBorderRadius) . 'px; 
                                                       display: flex; 
                                                       justify-content: center; 
                                                       align-items: center;">';
                                                }else{

                                                    $colors .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-color-button ' . esc_attr($selected) . '" 
                                                   data-value="' . esc_attr($option) . '" 
                                                   data-variation-name="' . esc_attr($name) . '" 
                                                   data-tooltip="' . esc_attr($tooltip) . '"
                                                   data-tooltip-image="' . esc_attr($tooltip_image) . '"
                                                   data-product_id="' . esc_attr($product_id) . '" 
                                                   data-available_variations="' . esc_attr($variations_json) . '" 
                                                   data-term-order=\'' . esc_attr(wp_json_encode($varimo_term_order)) . '\'
                                                   data-label-name="' . esc_attr($option) . '" 
                                                   data-tooltip-bg-color="' . esc_attr($selectVariationTooltipBgColor) . '" 
                                                   data-tooltip-text-color="' . esc_attr($selectVariationTooltipTextColor) . '" 
                                                   style="background-color: ' . esc_attr($color) . '; 
                                                   height: ' . esc_attr($imageColorHeight) . 'px; 
                                                   width: ' . esc_attr($imageColorWidth) . 'px; 
                                                   border-radius: ' . esc_attr($imageColorBorderRadius) . 'px; 
                                                   display: flex; 
                                                   justify-content: center; 
                                                   align-items: center;">';

                                                }

                                                $colors .= '<span class="color-label">' . esc_html($option) . '</span>';
                                            } else {

                                                $colors .= '<button onclick="varimoElementSelectedUnselected(this)" type="button" class="custom-color-button ' . esc_attr($selected) . '" 
                                               data-value="' . esc_attr($option) . '" 
                                               data-variation-name="' . esc_attr($name) . '" 
                                               data-tooltip="' . esc_attr($tooltip) . '" 
                                               data-tooltip-image="' . esc_attr($tooltip_image) . '"
                                               data-product_id="' . esc_attr($product_id) . '" 
                                               data-available_variations="' . esc_attr($variations_json) . '"
                                               data-term-order=\'' . esc_attr(wp_json_encode($varimo_term_order)) . '\'
                                               data-label-name="' . esc_attr($option) . '" 
                                               data-tooltip-bg-color="' . esc_attr($selectVariationTooltipBgColor) . '" 
                                               data-tooltip-text-color="' . esc_attr($selectVariationTooltipTextColor) . '" 
                                               style="background-color: ' . esc_attr($color) . '; 
                                               height: ' . esc_attr($imageColorHeight) . 'px; 
                                               width: ' . esc_attr($imageColorWidth) . 'px; 
                                               border-radius: ' . esc_attr($imageColorBorderRadius) . 'px; 
                                               display: flex; 
                                               justify-content: center; 
                                               align-items: center;">';

                                                $colors .= '<span class="term-name">' . esc_html($option) . '</span>';
                                            }
                                            $colors .= '</button>';

                                            $colors .= '</button>';
                                        }
                                    }

                                    $colors .= '</div>';

                                    return $html . $colors;
                                }
                            }
                        }
                    }
                }


                global $product;

                if ($product->is_type('variable')) {
                    $varimo_attributes = $product->get_variation_attributes();
                    $varimo_attribute_keys = array_keys($varimo_attributes);

                    echo '<div class="variations-display">';

                    foreach ($varimo_attribute_keys as $varimo_attribute_key) {
                        $varimo_args = [
                                'options'          => $varimo_attributes[$varimo_attribute_key],
                                'attribute'        => $varimo_attribute_key,
                                'product'          => $product,
                                'selected'         => false,
                                'name'             => 'attribute_' . sanitize_title($varimo_attribute_key),
                                'id'               => sanitize_title($varimo_attribute_key),
                                'class'            => '',
                                'show_option_none' => __('Choose an option', 'variation-monster'),
                        ];

                        // Call custom function to render the color, image, or button options.
                        echo (varimo_variation_monster_carousel_template_four_attribute('', $varimo_args)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }

                    echo '</div>';
                }
                ?>

            </div>

            <!-- Quantity and Add-to-Cart Button -->
            <div class="quick-quantity-container" style="flex-direction:column;">
                <div class="quick-quantity-template-three" style="display: flex !important;gap: 5px;">
                    <button onclick="varimoShopPageQuantityDecrease(this)" class="quick-quantity-decrease" id="decrease"><?php echo esc_html("-", 'variation-monster'); ?></button>
                    <input type="text" autocomplete="off" id="quantity" class="quick-quantity-input" value="1" data-max="">
                    <button onclick="varimoShopPageQuantityIncrese(this)" class="quick-quantity-increase" id="increase"><?php echo esc_html("+", 'variation-monster'); ?></button>
                </div>

                <div class="notice-container-template-four">
                    <div class="quick-cart-notification quick-hidden" id="notification"></div>
                    <!--                    <div class="shop-page-show-success-message"></div>-->
                    <div class="shop-page-show-failed-message"></div>
                </div>
                <div class="add-to-cart-more-info-button" style="display: flex; justify-content: center; width: 50%">

                    <button id="quick-add-to-cart-shop-page"
                            class="quick-add-to-cart-shop-page-template-four variation-monster-template-four-cart"
                            data-productId="<?php echo esc_attr($product->get_id()); ?>"
                            data-variationId=""
                            data-action="variable-product-btn"
                            disabled
                            style="outline: none; min-width: 100%; padding: 0; border-radius: 0; opacity: 0.5;">
                        <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                            <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>" style="height: 20px; width: 20px;"></span>

                        <?php else: ?>
                            <i class="<?php echo esc_attr($varimoQuickCartIcon); ?> cart-icon-remove" aria-hidden="true"></i>
                        <?php endif; ?>
                        <span><?php echo esc_html($varimoCartButtonText); ?></span>

                    </button>

                    <button style="outline: none; min-width: 100%; padding: 0; border-radius: 0;" onclick="window.location.href=document.querySelector('.dynamic-variation-url').href">
                        <a href="#" class="dynamic-variation-url" style="color: black; outline: none">
                            <?php echo esc_html($varimoMoreInfoTextChange, "variation-monster"); ?>
                        </a>
                    </button>


                </div>

                <?php wp_nonce_field('quick_variable_nonce_action', 'quick_variable_nonce'); ?>
            </div>
            <?php wp_nonce_field('quick_variable_nonce_action', 'quick_variable_nonce'); ?>
        </div>
    </div>

</div>

<style>


    .quick-gallery-prev,
    .quick-gallery-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 5px;
        height: 30px;
        font-size: 18px;
        cursor: pointer;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quick-gallery-prev {
        left: 10px;
    }

    .quick-gallery-next {
        right: 10px;
    }

    .quick-gallery-prev:disabled,
    .quick-gallery-next:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }







    .quick-product-content-template-three , .quick-quantity-template-three{
        margin-right: auto;
        padding-left: 34px;
    }

    .popup-template-four-modal{
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 99999;
        padding: 0;

    }

    .quick-add-to-cart-shop-page.loading .fa-cart-plus,
    .quick-add-to-cart-shop-page.loading span {
        display: none; /* Hide the default icon and text when loading */
    }


    .quick-variable-gallery {
        position: relative;
        width: 100%;
    }

    .quick-variable-active-image img {
        max-width: 100%;
        height: auto;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        display: block;
        margin: 0 auto;
    }

    .quick-variable-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 10px;
    }

    .quick-variable-dot {
        width: 10px;
        height: 10px;
        background: #ccc;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .quick-variable-dot.active {
        background: #000;
    }

</style>

<script>
    jQuery(document).ready(function ($) {
        jQuery('.image-shop-page').each(function () {
            var div = jQuery(this);

            // Get the attributes from the div
            var src = div.attr('src');
            var alt = div.attr('alt') || ''; // Fallback to empty string if alt is missing
            var style = div.attr('style') || ''; // Fallback to empty string if style is missing
            var className = div.attr('class') || ''; // Fallback to empty string if class is missing

            // Log errors if src is missing (required for <img>)
            if (!src) {
                console.error('Missing "src" attribute for .image-shop-page element:', div);
                return; // Skip this element if src is missing
            }

            // Create an <img> element with the same attributes
            var img = jQuery('<img>', {
                src: src,
                alt: alt,
                style: style,
                class: className.replace('image-shop-page', '').trim() // Remove "image-shop-page" class if not needed
            });

            // Replace the <div> with the <img>
            div.replaceWith(img);
        });
    });

</script>

<style>

    .popup-template-four-modal {
        align-items: center;
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* Image Section */
    .quick-variable-image-container {
        flex: 1;
        max-width: 50%;
    }

    .quick-variable-image-container img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 10px 0 0 10px;
    }


    .cart-icon-remove {
        font-size: 16px;
    }


    .gallery-image-show-into-popup{
        height: 100%;
        width: max-content;
    }

    .gallery-image-show-into-popup img{
        margin: 0 !important;
    }

    .quick-add-to-cart-shop-page{
        margin-top: 10px;
    }

    .quick-variable-tooltip-closebtn-template-four{
        top: 6px;
    }

    .content-popup-template-four{
        display: flex;
        flex-direction: row;
    }

    .notice-container-template-four{
        margin-top: 50px;
    }
    @media only screen and (max-width: 600px) {

        .quick-variable-active-image img{
            border-radius: 5px;
        }

        .quick-variable-gallery{
            padding: 5px;
        }

        .content-popup-template-four{
            display: flex;
            flex-direction: column;
        }
        .quick-product-content-template-three{
            padding-left: 5px !important;
            margin-top: 5px !important;
        }
        .quick-product-content-template-three, .quick-quantity-template-three{
            padding-left: 5px !important;
        }

        .quick-variable-tooltip-closebtn-template-four {
            position: absolute !important;
            top: 10px !important;
            right: 10px !important;
            font-size: 24px !important;
            z-index: 1001; /* Above the modal */
            color: #000 !important;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .popup-template-four-modal {
            max-width: 90% !important;
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 99999; /* Ensure it stays above other content */
            margin: 0 !important; /* Remove any default margins */
            width: 100%;
        }

        .gallery-image-show-into-popup{
            width: 100% !important;
        }
        .notice-container-template-four{
            margin-top: 0 !important;
        }
    }

</style>