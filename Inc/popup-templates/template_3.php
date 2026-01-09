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
$varimoMoreInfoTextChange      = isset($varimoVariableSettings['moreInfoTextChange']) ? $varimoVariableSettings['moreInfoTextChange'] : 'More Information';
$varimo_is_block_theme = wp_is_block_theme();
$varimo_ignore_attr = $varimo_is_block_theme ? 'data-wp-ignore' : '';
?>

<div <?php echo esc_attr($varimo_ignore_attr); ?> <?php if ($varimoVariableHoverClick == "" ){ ?> style="display: none" <?php } ?> class="quick-variable-tooltip tooltiptext quick-hidden popup-template-three-modal">
    <p><span onclick="varimoTemplateCloseButton()" class='closebtn quick-variable-tooltip-closebtn-template-three'>&times;</span></p>

    <div class="content-popup-template-three">
        <?php if (!empty($varimoVariableDetailsImage) && !empty($varimoVariableSettings)) {
            ?>
            <div class="gallery-image-show-into-popup">
                <!-- Image Gallery Container -->
                <div class="quick-variable-gallery">
                    <!-- Navigation Buttons -->
                    <button style="outline: none"  class="quick-gallery-prev" disabled>&#10094;</button>
                    <button style="outline: none"  class="quick-gallery-next">&#10095;</button>

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
                <div style="font-size: large;text-align: left" id="variable-product-variations"></div>
            </div>

            <!-- Quantity and Add-to-Cart Button -->
            <div class="quick-quantity-container" style="flex-direction:column;">
                <div class="quick-quantity-template-three" style="display: flex !important;gap: 5px;">
                    <button onclick="varimoShopPageQuantityDecrease(this)" class="quick-quantity-decrease" id="decrease"><?php echo esc_html("-", 'variation-monster'); ?></button>
                    <input type="text" autocomplete="off" id="quantity" class="quick-quantity-input" value="1" data-max="">
                    <button onclick="varimoShopPageQuantityIncrese(this)" class="quick-quantity-increase" id="increase"><?php echo esc_html("+", 'variation-monster'); ?></button>
                </div>

                <div class="notice-container-template-three">
                    <div class="quick-cart-notification quick-hidden" id="notification"></div>
                    <!--                    <div class="shop-page-show-success-message"></div>-->
                    <div class="shop-page-show-failed-message"></div>
                </div>
                <div class="add-to-cart-more-info-button" style="display: flex; justify-content: center; width: 50%">

                    <button id="quick-add-to-cart-shop-page" onclick="varimoAddToCartShopPageQuick(this)"
                            class="quick-add-to-cart-shop-page"
                            data-productId="<?php echo esc_attr($product->get_id()); ?>"
                            data-variationId=""
                            data-action="variable-product-btn"
                            style="outline: none; min-width: 100%; padding: 0; border-radius: 0;">
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

    .popup-template-three-modal{
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

    .popup-template-three-modal {
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

    .quick-variable-tooltip-closebtn-template-three{
        top: 6px;
    }

    .content-popup-template-three{
        display: flex;
        flex-direction: row;
    }

    .notice-container-template-three{
        margin-top: 50px;
    }
    @media only screen and (max-width: 600px) {

        .quick-variable-gallery{
            padding: 5px;
        }

        .quick-variable-active-image img{
            border-radius: 5px;
        }

        .content-popup-template-three{
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

        .quick-variable-tooltip-closebtn-template-three {
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

        .popup-template-three-modal {
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
        .notice-container-template-three{
            margin-top: 0 !important;
        }
    }
</style>