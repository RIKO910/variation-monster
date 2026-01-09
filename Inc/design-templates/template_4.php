<?php
if (!defined('ABSPATH')) exit;

global $product;
$varimo_all_attributes                 = $product->get_attributes();
$varimo_enable_global_stock_management = $product->get_manage_stock();
$varimo_global_stock_quantity          = $varimo_enable_global_stock_management ? $product->get_stock_quantity() : null;
$varimoVariableSetting                = get_option('variable_all_checked', array());
$varimoImageHideShow                  = isset($varimoVariableSetting['imageHideShow']) ? $varimoVariableSetting['imageHideShow'] : '';
$varimoSkuHideShow                    = isset($varimoVariableSetting['skuHideShow']) ? $varimoVariableSetting['skuHideShow'] : '';
$varimoAllAttributeHideShow           = isset($varimoVariableSetting['allAttributeHideShow']) ? $varimoVariableSetting['allAttributeHideShow'] : '';
$varimoPriceHideShow                  = isset($varimoVariableSetting['priceHideShow']) ? $varimoVariableSetting['priceHideShow'] : '';
$varimoQuantityHideShow               = isset($varimoVariableSetting['quantityHideShow']) ? $varimoVariableSetting['quantityHideShow'] : '';
$varimoActionHideShow                 = isset($varimoVariableSetting['actionHideShow']) ? $varimoVariableSetting['actionHideShow'] : '';
$varimoCartButtonText                 = isset($varimoVariableSetting['cartButtonText']) ? $varimoVariableSetting['cartButtonText'] : 'Add-to-cart';
$varimoShowDoublePrice                = isset($varimoVariableSetting['showDoublePrice']) ? $varimoVariableSetting['showDoublePrice'] : 'true';
$varimoPopUPImageShow                 = isset($varimoVariableSetting['popUPImageShow']) ? $varimoVariableSetting['popUPImageShow'] : 'thumbnail';

?>

<div id="mobile-quick-variable-table">
    <?php
    $varimo_variations = $product->get_available_variations();
    foreach ($varimo_variations as $varimo_var) {
        $varimo_variation_id             = $varimo_var['variation_id'];
        $varimo_variation                = new WC_Product_Variation($varimo_variation_id);
        $varimo_variation_stock_quantity = $varimo_variation->get_manage_stock() ? $varimo_variation->get_stock_quantity() : null;
        $varimo_thumbnail_id             = $varimo_variation->get_image_id();
        $varimo_thumbnail_html           = wp_get_attachment_image($varimo_thumbnail_id, esc_attr($varimoPopUPImageShow), false, [
            'alt' => esc_attr($varimo_variation->get_name()),
            'height' => '100px',
        ]);
        ?>
        <div class="mobile-variation-card mobile-variation-card-row-template-4">
            <div style="display:flex; width: 100%; gap: 10px" >
                <?php if ($varimoImageHideShow === "true"){
                    ?>
                    <div class="" style="width: 50%">
                        <?php echo wp_kses_post($varimo_thumbnail_html); ?>
                    </div>
                <?php
                }?>

                <!-- Attributes Section -->
                <div class="">
                    <?php if ($varimoSkuHideShow === "true"){
                        ?>
                        <span style="text-overflow: ellipsis; overflow: hidden;"><?php echo esc_html($varimo_variation->get_sku()); ?></span>
                        <?php
                    }?>

                    <?php if ($varimoAllAttributeHideShow === "true"){
                        ?>
                        <div class="mobile-attributes-list">
                            <?php foreach ($varimo_all_attributes as $varimo_attribute_name => $varimo_attribute) {
                                $varimo_attribute_value = $varimo_variation->get_attribute($varimo_attribute_name);

                                // Check if the attribute is a taxonomy
                                $taxonomy = taxonomy_exists($varimo_attribute_name) ? get_taxonomy($varimo_attribute_name) : null;

                                // Determine the label for the attribute
                                $varimo_label = $taxonomy ? str_replace("Product ", "", $taxonomy->label) : ucfirst($varimo_attribute_name);

                                if (empty($varimo_attribute_value)) {
                                    // Display a dropdown if the attribute value is empty
                                    echo "<div><label>" . esc_html($varimo_label) . ":</label> ";
                                    echo "<select class='quick-attribute-select' name='attribute_" . esc_attr($varimo_attribute_name) . "' data-attribute-name='" . esc_attr($varimo_attribute_name) . "'>";

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
                                    // Display the static attribute value
                                    echo "<div><label>" . esc_html($varimo_label) . ":</label> ";
                                    echo "<span class='quick-attribute-text' name='attribute_" . esc_attr($varimo_attribute_name) . "'>" . esc_html($varimo_attribute_value) . "</span></div>";
                                }
                            } ?>
                        </div>
                        <?php
                    }?>


                    <?php if ($varimoPriceHideShow === "true"){
                        ?>
                        <div class="">
                            <span><?php
                                if ($varimoShowDoublePrice === 'true'){
                                    echo wp_kses_post($varimo_variation->get_price_html());
                                }else{
                                    $varimo_sale_price = $varimo_variation->get_sale_price();
                                    if($varimo_sale_price) {
                                        echo wp_kses_post(wc_price($varimo_sale_price));
                                    } else {
                                        echo wp_kses_post(wc_price($varimo_variation->get_regular_price()));
                                    }
                                }
                                ?></span>
                        </div>
                        <?php
                    }?>

                </div>
            </div>

            <div style="display: flex; gap: 30px; justify-content: center">
                <?php if ($varimoQuantityHideShow === "true"){
                    ?>
                    <div class="quick-quantity-container" style="margin-bottom: 10px">
                        <button onclick="varimoShopPageQuantityDecrease(this)" class="quick-quantity-decrease" id="decrease">-</button>
                        <input type="text" id="quantity" autocomplete="off" class="quick-quantity-input" value="1" data-max="<?php echo esc_attr($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity ?: 99); ?>">
                        <button onclick="varimoShopPageQuantityIncrese(this)" class="quick-quantity-increase" id="increase">+</button>
                    </div>
                    <?php
                }?>

                <div style="margin-top: 10px">
                    <div class="quick-cart-notification quick-hidden"></div>
                    <?php if ($varimoActionHideShow === "true"){
                        ?>
                        <div class=" stock-notification" style="justify-items: center">
                            <?php if (0 === ($varimo_variation_stock_quantity ?: $varimo_global_stock_quantity)) : ?>
                                <p><?php esc_html_e('Out Of Stock', 'variation-monster-pro'); ?></p>
                            <?php else : ?>
                                <button style="width: 100% ; text-align: center; padding:2px;" class="quick-add-to-cart" data-productId="<?php echo esc_attr($product->get_id()); ?>" data-variationId="<?php echo esc_attr($varimo_variation_id); ?>">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                    <span><?php echo esc_html($varimoCartButtonText); ?></span>
                                </button>
                            <?php endif; ?>
                        </div>
                        <?php
                    }?>

                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
