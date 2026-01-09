<?php
if (!defined('ABSPATH')) exit;

global $product;
global $post;
$varimoVariableSetting          = get_option('variable_all_checked', array());
$varimoQuickCarouselAutoplay    = isset($varimoVariableSetting['quickCarouselAutoplay']) ? $varimoVariableSetting['quickCarouselAutoplay'] : 'true';
$varimoQuickCarouselOnOff       = isset($varimoVariableSetting['quickCarouselOnOff']) ? $varimoVariableSetting['quickCarouselOnOff'] : '';
$varimoShowDoublePrice          = isset($varimoVariableSetting['showDoublePrice']) ? $varimoVariableSetting['showDoublePrice'] : 'true';
$varimoCarouselImageSize        = isset($varimoVariableSetting['carouselImageSize']) ? $varimoVariableSetting['carouselImageSize'] : '';
$varimoCarouselGalleryImageSize = isset($varimoVariableSetting['carouselGalleryImageSize']) ? $varimoVariableSetting['carouselGalleryImageSize'] : 'large';
$varimoNewMetaDataForVariations = isset($varimoVariableSetting['newMetaDataForVariations']) ? $varimoVariableSetting['newMetaDataForVariations'] : array();
$varimoMetaVariableListTemplate = get_post_meta($post->ID, '_quick_cart_carousel_meta', true);

if (isset($product) && $product->is_type("variable")) {

    //Collect Variable Product details
    $this->quickVariablePopup();
    if($varimoQuickCarouselOnOff === 'true') {
        if ($varimoMetaVariableListTemplate === 'true' || $varimoMetaVariableListTemplate === '') {
    ?>
    <div class="quick-variable-slide" data-autoplay="<?php echo esc_attr($varimoQuickCarouselAutoplay); ?>" ><?php
        $varimo_variations                     = $product->get_available_variations();
        $varimo_enable_global_stock_management = $product->get_manage_stock();
        $varimo_global_stock_quantity          = $product->get_stock_quantity();
        $varimo_attributes_name                 = $product->get_attributes();
        $varimo_variation_data                  = array();

        foreach ($varimo_variations as $varimo_var) {

            $varimo_variation_id         = $varimo_var['variation_id'];
            $varimo_gallery_images_id    = get_post_meta($varimo_variation_id, '_variation_gallery_images', true);
            $varimo_variation            = wc_get_product($varimo_variation_id);
            $varimo_variation_main_image = wp_get_attachment_image_url($varimo_variation->get_image_id(), $varimoCarouselGalleryImageSize);
            $varimo_gallery_images_url   = [];

            if($varimo_variation_main_image) {
                $varimo_gallery_images_url[] = $varimo_variation_main_image;
            }

            if (is_string($varimo_gallery_images_id)) {
                $varimo_gallery_images_id = explode(',', $varimo_gallery_images_id);
            }

            foreach ($varimo_gallery_images_id as $varimo_image_id) {
                $varimo_image_url = wp_get_attachment_image_url($varimo_image_id, $varimoCarouselGalleryImageSize);

                if ($varimo_image_url) {
                    $varimo_gallery_images_url[] = $varimo_image_url;
                }
            }

            $varimoParentProductID            = $varimo_variation->get_parent_id();
            $varimoParentProduct              = wc_get_product($varimoParentProductID);
            $varimoBaseURL                    = get_permalink($varimoParentProductID);
            $varimoAttributes                 = $varimo_variation->get_variation_attributes();
            $varimoVariationURL               = add_query_arg($varimoAttributes, $varimoBaseURL);
            $varimo_variation                  = new WC_Product_Variation($varimo_variation_id);
            $varimo_variation_stock_quantity   = $varimo_variation->get_stock_quantity();
            $varimo_variation_stock_status     = $varimo_variation->get_stock_status();
            $varimo_variation_stock_management = $varimo_variation->get_manage_stock();
            $varimo_sku                        = $varimo_variation->get_sku();
            $varimoAttributes                 = $varimo_variation->get_attributes();
            $varimoVariationsList             = [];
            $varimoNewMetaShow                = [];

            foreach ($varimo_attributes_name as $varimo_key => $varimo_attribute) {
                if ($varimo_attribute->is_taxonomy()) {
                    $varimo_options    = wc_get_product_terms($product->get_id(), $varimo_key, ['fields' => 'names']);
                    $varimo_label_name = wc_attribute_label($varimo_key);
                } else {
                    $varimo_options = $varimo_attribute->get_options();
                    $varimo_label_name = wc_attribute_label($varimo_key);
                }
                $varimoVariationsList[$varimo_key] = [
                        'options' => $varimo_options,
                        'label' => $varimo_label_name
                ];
            }

            foreach ($varimoNewMetaDataForVariations as $varimo_key => $varimo_newMetaDataForVariation){

               $varimo_keyValue =  get_post_meta($varimo_variation_id, $varimo_newMetaDataForVariation["key"], true);
               $varimo_label    =  $varimo_newMetaDataForVariation["value"];

                $varimoNewMetaShow[$varimo_key] =[
                      'keyValue' => $varimo_keyValue,
                      'label' => $varimo_label
                ];
            }

            // Get variation price.
            if ($varimoShowDoublePrice === 'true'){
                $varimo_price_html = $varimo_variation->get_price_html();
            }else{
                $varimo_sale_price = $varimo_variation->get_sale_price();
                if($varimo_sale_price) {
                    $varimo_price_html = wc_price($varimo_sale_price);
                } else {
                    $varimo_price_html = wc_price($varimo_variation->get_regular_price());
                }
            }

            $varimo_thumbnail_id       = $varimo_variation->get_image_id();
            $varimo_thumbnail_html     = wp_get_attachment_image($varimo_thumbnail_id, esc_attr($varimoCarouselImageSize), false, [
                'alt' => esc_attr($varimo_variation->get_name()),
                'height' => '100px',
                'width' => '100px'
            ]);

            $varimoVariableSetting    = get_option("variable_all_checked", []);
            $varimo_variable_hover_click = isset($varimoVariableSetting["hoverClickValue"][0]) ? $varimoVariableSetting["hoverClickValue"][0] : "";

            $varimo_variation_data      = [
                   "name"                    => $product->get_name(),
                   "sku"                     => $varimo_sku,
                   "product_id"              => $product->get_id() ,
                   "excerpt"                 => $product->get_short_description(),
                   "variableClickHover"      => $varimo_variable_hover_click,
                   "variationPrice"          => $varimo_price_html,
                   "variationId"             => $varimo_variation_id,
                   "galleryImages"           => $varimo_gallery_images_url,
                   "VariationMainImage"      => $varimo_variation_main_image,
                   'variationURL'            => $varimoVariationURL,
                   "variationQuantity"       => $varimo_variation_stock_quantity ,
                   "variationStockStatus"    => $varimo_variation_stock_status ,
                   "variationStockManage"    => $varimo_variation_stock_management ,
                   "globalStockManagement"   => $varimo_enable_global_stock_management,
                   "globalStockQuantity"     => $varimo_global_stock_quantity,
                   "variation_set_attribute" => $varimoAttributes
            ];
            ?>

            <div class="quick-slide-variable" onclick="varimoQuickSlideVariable(this)"
                 data-variation="<?php echo esc_attr(wp_json_encode($varimo_variation_data, true)); ?>"
                 data-newMetaShow="<?php echo esc_attr(wp_json_encode($varimoNewMetaShow, true)); ?>"
                 data-variationsList="<?php echo esc_attr(wp_json_encode($varimoVariationsList)); ?>">
                <?php echo wp_kses_post($varimo_thumbnail_html); ?>
            </div>

            <?php


        } ?>
    </div>
    <?php
        }
    }
}

