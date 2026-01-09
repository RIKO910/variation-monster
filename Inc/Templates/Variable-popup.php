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
$varimoNameImageRedirect       = isset($varimoVariableSettings['nameImageRedirect']) ? $varimoVariableSettings['nameImageRedirect'] : 'true';
$varimoAddToCartSuccessColor   = isset($varimoVariableSettings['addToCartSuccessColor']) ? $varimoVariableSettings['addToCartSuccessColor'] : '#fff';
$varimoQuickCartIcon           = isset($varimoVariableSettings['quickCartIcon']) ? $varimoVariableSettings['quickCartIcon'] : 'fa fa-shopping-cart';
$varimoQuickCartIconImageLink  = isset($varimoVariableSettings['quickCartIconImageLink']) ? $varimoVariableSettings['quickCartIconImageLink'] : '';
$varimo_is_block_theme = wp_is_block_theme();
$varimo_ignore_attr = $varimo_is_block_theme ? 'data-wp-ignore' : '';
?>

<div <?php echo esc_attr($varimo_ignore_attr); ?> <?php if ($varimoVariableHoverClick == "" ){ ?> style="display: none" <?php } ?> class="quick-variable-tooltip tooltiptext quick-hidden <?php if ($varimoTooltipPosition != "quick-tooltip-position-center") { echo esc_attr($varimoTooltipPosition); } ?>">
    <p><span onclick="varimoTemplateCloseButton()" class='closebtn'>&times;</span></p>

    <?php if (!empty($varimoVariableDetailsImage) && !empty($varimoVariableSettings)) {
        if ($varimoNameImageRedirect === "true"){
            ?>
            <a href="#" class="dynamic-variation-url" target="_blank">
                <div src="<?php echo esc_url($varimoVariableDetailsImage); ?>"
                     alt="<?php echo esc_attr($product->get_name()); ?>"
                     style="<?php if (empty($varimoVariableDetailsImage)) { echo 'display:none;'; } ?>"
                     class="variableThumb image-shop-page" ></div>
            </a>
            <?php
        }else{
            ?>
            <div src="<?php echo esc_url($varimoVariableDetailsImage); ?>"
                 alt="<?php echo esc_attr($product->get_name()); ?>"
                 style="<?php if (empty($varimoVariableDetailsImage)) { echo 'display:none;'; } ?>"
                 class="variableThumb image-shop-page" > </div>
            <?php
        }
    } ?>

    <div id="quick-product-details">
        <div id="quick-product-content">
            <?php if (!empty($varimoVariableDetailsTitle) && !empty($varimoVariableSettings)) {

                if ($varimoNameImageRedirect === "true"){
                    ?>
                    <a href="#" class="dynamic-variation-url" target="_blank">
                        <h4 class="<?php if (empty($varimoVariableDetailsTitle) && !empty($varimoVariableSettings)) { echo "quick-hidden"; } ?>"></h4>
                    </a>
                    <?php
                }else{
                    ?>
                    <h4 class="<?php if (empty($varimoVariableDetailsTitle) && !empty($varimoVariableSettings)) { echo "quick-hidden"; } ?>"></h4>
                    <?php
                }
            } ?>

            <?php if (!empty($varimoVariableDetailsExcerpt) && !empty($varimoVariableSettings)) { ?>

                <p class="variable-short-desc <?php if (empty($varimoVariableDetailsExcerpt) && !empty($varimoVariableSettings)) { echo esc_attr("quick-hidden"); } ?>"></p>

            <?php } ?>

            <?php if (!empty($varimoVariableSKU) && !empty($varimoVariableSettings)) { ?>

                <div style="display: flex; gap: 4px; justify-content: center">
                    <strong><?php  echo esc_html("SKU:", 'variation-monster') ?> </strong>
                    <p class="variable-sku <?php if (empty($varimoVariableSKU) && !empty($varimoVariableSettings)) { echo esc_attr("quick-hidden"); } ?>"></p>
                </div>

            <?php } ?>

            <p><strong><?php echo esc_html("Price:", 'variation-monster'); ?> </strong><span id="variable-product-price"></span></p>
            <div id="new-meta-data-show-for-variation" style="display: flex;flex-direction: column; align-items: center;"></div>
            <div id="variable-product-variations"></div>
        </div>

        <!-- Quantity and Add-to-Cart Button -->
        <div class="quick-quantity-container">
            <button onclick="varimoShopPageQuantityDecrease(this)" class="quick-quantity-decrease" id="decrease"><?php echo esc_html("-", 'variation-monster'); ?></button>
            <input type="text" autocomplete="off" id="quantity" class="quick-quantity-input" value="1" data-max="">
            <button onclick="varimoShopPageQuantityIncrese(this)" class="quick-quantity-increase" id="increase"><?php echo esc_html("+", 'variation-monster'); ?></button>

            <button id="quick-add-to-cart-shop-page" onclick="varimoAddToCartShopPageQuick(this)"
                    class="quick-add-to-cart-shop-page"
                    data-productId="<?php echo esc_attr($product->get_id()); ?>"
                    data-variationId=""
                    data-action="variable-product-btn"
                    style="outline: none">
                <?php if (!empty($varimoQuickCartIconImageLink)): ?>
                    <span class="add-to-cart-icon-image-render-from-js" data-add-to-cart-icon-image="<?php echo esc_url($varimoQuickCartIconImageLink); ?>" style="height: 20px; width: 20px;"></span>

                <?php else: ?>
                    <i class="<?php echo esc_attr($varimoQuickCartIcon); ?> cart-icon-remove" aria-hidden="true"></i>
                <?php endif; ?>
                <span><?php echo esc_html($varimoCartButtonText); ?></span>

            </button>

            <?php wp_nonce_field('quick_variable_nonce_action', 'quick_variable_nonce'); ?>
        </div>
        <div class="quick-cart-notification quick-hidden" id="notification"></div>
        <div class="shop-page-show-success-message"></div>
        <div class="shop-page-show-failed-message"></div>
    </div>
</div>

<style>

    .quick-add-to-cart-shop-page.loading .fa-cart-plus,
    .quick-add-to-cart-shop-page.loading span {
        display: none; /* Hide the default icon and text when loading */
    }

</style>

<script>
    jQuery(document).ready(function ($) {
        jQuery('.image-shop-page').each(function () {
            var div = jQuery(this);

            // Get the attributes from the div
            var src = div.attr('src');
            var alt = div.attr('alt');
            var style = div.attr('style');
            var className = div.attr('class');

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