<?php
if (!defined('ABSPATH')) exit;

class VARIMO_Dynamic_Style{

    public function __construct(){
        add_action('wp_enqueue_scripts', [$this,'quick_dynamic_styles']);
    }

    function quick_dynamic_styles() {
        global $post;
        $variableSetting                    = get_option('variable_all_checked', array());
        $variableAddToCartIcon              = isset($variableSetting['variableAddToCartIcon']) ? $variableSetting['variableAddToCartIcon'] : 'inline-block';
        $cartButtonBg                       = isset($variableSetting['cartButtonBg']) ? $variableSetting['cartButtonBg'] : '#007cba';
        $cartButtonTextColor                = isset($variableSetting['cartButtonTextColor']) ? $variableSetting['cartButtonTextColor'] : '#fff';
        $tooltipBgColor                     = isset($variableSetting['tooltipBg']) ? $variableSetting['tooltipBg'] : '#000';
        $tooltipTextColor                   = isset($variableSetting['tooltipTextColor']) ? $variableSetting['tooltipTextColor'] : '#fff';
        $quantityBg                         = isset($variableSetting['quantityBg']) ? $variableSetting['quantityBg'] : '#007bff';
        $quantityBorderColor                = isset($variableSetting['quantityBorderColor']) ? $variableSetting['quantityBorderColor'] : '#ccc';
        $quantityTextColor                  = isset($variableSetting['quantityTextColor']) ? $variableSetting['quantityTextColor'] : '#fff';
        $carouselButtonBgColor              = isset($variableSetting['CarouselButtonBg']) ? $variableSetting['CarouselButtonBg'] : '#000';
        $carouselButtonIconColor            = isset($variableSetting['CarouselButtonIconColor']) ? $variableSetting['CarouselButtonIconColor'] : '#fff';
        $tableHeadBgColor                   = isset($variableSetting['tableHeadBgColor']) ? $variableSetting['tableHeadBgColor'] : '#007cba';
        $tableHeadTextColor                 = isset($variableSetting['tableHeadTextColor']) ? $variableSetting['tableHeadTextColor'] : '#fff';
        $tableVariableTitleColor            = isset($variableSetting['tableVariableTitleColor']) ? $variableSetting['tableVariableTitleColor'] : '#000';
        $quickTableBorder                   = isset($variableSetting['quickTableBorder']) ? $variableSetting['quickTableBorder'] : '0';
        $tableBorderColor                   = isset($variableSetting['tableBorderColor']) ? $variableSetting['tableBorderColor'] : '#e1e8ed';
        $tableBgColorOdd                    = isset($variableSetting['tableBgColorOdd']) ? $variableSetting['tableBgColorOdd'] : 'transparent';
        $tableBgColorEven                   = isset($variableSetting['tableBgColorEven']) ? $variableSetting['tableBgColorEven'] : '#f2f2f2';
        $tableBgColorHover                  = isset($variableSetting['tableBgColorHover']) ? $variableSetting['tableBgColorHover'] : '#ddd';
        $cartButtonBgHover                  = isset($variableSetting['cartButtonBgHover']) ? $variableSetting['cartButtonBgHover'] : '#045cb4';
        $quantityBgColorHover               = isset($variableSetting['quantityBgColorHover']) ? $variableSetting['quantityBgColorHover'] : '#0056b3';
        $swatchesButtonBorderColor          = isset($variableSetting['swatchesButtonBorderColor']) ? $variableSetting['swatchesButtonBorderColor'] : '#000000';
        $selectedVariationButtonBorderColor = isset($variableSetting['selectedVariationButtonBorderColor']) ? $variableSetting['selectedVariationButtonBorderColor'] : '#17AF31';
        $buttonWidth                        = isset($variableSetting['buttonWidth']) ? $variableSetting['buttonWidth'] : ' ';
        $buttonHeight                       = isset($variableSetting['buttonHeight']) ? $variableSetting['buttonHeight'] : ' ';
        $buttonBorderRadius                 = isset($variableSetting['buttonBorderRadius']) ? $variableSetting['buttonBorderRadius'] : '5';
        $variationSelectOnOff               = isset($variableSetting['variationSelectOnOff']) ? $variableSetting['variationSelectOnOff'] : '';
        $listBadgeBgColor                   = isset($variableSetting['listBadgeBgColor']) ? $variableSetting['listBadgeBgColor'] : '#FF5733';
        $listBadgeTextColor                 = isset($variableSetting['listBadgeTextColor']) ? $variableSetting['listBadgeTextColor'] : '#ffffff';
        $listBadgeHeight                    = isset($variableSetting['listBadgeHeight']) ? $variableSetting['listBadgeHeight'] : ' ';
        $listBadgeWidth                     = isset($variableSetting['listBadgeWidth']) ? $variableSetting['listBadgeWidth'] : ' ';
        $listBadgeShowRight                 = isset($variableSetting['listBadgeShowRight']) ? $variableSetting['listBadgeShowRight'] : '';
        $selectVariationTemplateOnOff       = isset($variableSetting['selectVariationTemplateOnOff']) ? $variableSetting['selectVariationTemplateOnOff'] : '';
        $bulkAddCartBgColor                 = isset($variableSetting['bulkAddCartBgColor']) ? $variableSetting['bulkAddCartBgColor'] : '#007cba';
        $bulkAddCartTextColor               = isset($variableSetting['bulkAddCartTextColor']) ? $variableSetting['bulkAddCartTextColor'] : '#FFFFFF';
        $bulkAddCartHoverBgColor            = isset($variableSetting['bulkAddCartHoverBgColor']) ? $variableSetting['bulkAddCartHoverBgColor'] : '#007cba';
        $bulkAddCartHoverTextColor          = isset($variableSetting['bulkAddCartHoverTextColor']) ? $variableSetting['bulkAddCartHoverTextColor'] : '#000000';
        $template2TableBgColor              = isset($variableSetting['template2TableBgColor']) ? $variableSetting['template2TableBgColor'] : '#000000';
        $template2DetailsSectionBgColor     = isset($variableSetting['template2DetailsSectionBgColor']) ? $variableSetting['template2DetailsSectionBgColor'] : '#FFFFFF';
        $template2CartSectionBgColor        = isset($variableSetting['template2CartSectionBgColor']) ? $variableSetting['template2CartSectionBgColor'] : '#FBFBFB';
        $showAttributeSwatchesArchive       = isset($variableSetting['showAttributeSwatchesArchive'][0]) ? $variableSetting['showAttributeSwatchesArchive'][0] : '';
        $quantityTextHoverColor             = isset($variableSetting['quantityTextHoverColor']) ? $variableSetting['quantityTextHoverColor'] : '#000000';
        $cartButtonTextHoverColor           = isset($variableSetting['cartButtonTextHoverColor']) ? $variableSetting['cartButtonTextHoverColor'] : '#000000';
        $fontSizeVarimoSwatches             = isset($variableSetting['fontSizeVarimoSwatches']) ? $variableSetting['fontSizeVarimoSwatches'] : '14';
        $galleryNavigationButtonIconColor      = isset($variableSetting['galleryNavigationButtonIconColor']) ? $variableSetting['galleryNavigationButtonIconColor'] : '#fff';
        $galleryNavigationButtonIconHoverColor = isset($variableSetting['galleryNavigationButtonIconHoverColor']) ? $variableSetting['galleryNavigationButtonIconHoverColor'] : '#D0D0D0';
        $galleryNavigationButtonBgColor        = isset($variableSetting['galleryNavigationButtonBgColor']) ? $variableSetting['galleryNavigationButtonBgColor'] : '#808080';
        $galleryNavigationButtonBgHoverColor   = isset($variableSetting['galleryNavigationButtonBgHoverColor']) ? $variableSetting['galleryNavigationButtonBgHoverColor'] : '##2F3031';
        $paginationButtonBgColor               = isset($variableSetting['paginationButtonBgColor']) ? $variableSetting['paginationButtonBgColor'] : '#007cba';
        $paginationButtonHoverBgColor          = isset($variableSetting['paginationButtonHoverBgColor']) ? $variableSetting['paginationButtonHoverBgColor'] : '#045CB4';
        $paginationButtonTextColor             = isset($variableSetting['paginationButtonTextColor']) ? $variableSetting['paginationButtonTextColor'] : '#ffffff';
        $paginationButtonTextHoverColor        = isset($variableSetting['paginationButtonTextHoverColor']) ? $variableSetting['paginationButtonTextHoverColor'] : '#000000';
        $listPaginationPerLineMobile           = isset($variableSetting['listPaginationPerLineMobile']) ? $variableSetting['listPaginationPerLineMobile'] : '2';
        $quickCartIconImageLink                = isset($variableSetting['quickCartIconImageLink']) ? $variableSetting['quickCartIconImageLink'] : '';
        $selectVariationTooltipBgColor         = isset($variableSetting['selectVariationTooltipBgColor']) ? $variableSetting['selectVariationTooltipBgColor'] : '#000000';
        $globallyTooltipOnOff                  = isset($variableSetting['globallyTooltipOnOff']) ? $variableSetting['globallyTooltipOnOff'] : '';
        $variationSwatchesDisableSettings      = isset($variableSetting['variationSwatchesDisableSettings'][0]) ? $variableSetting['variationSwatchesDisableSettings'][0] : 'not-disable';
        $selectedIconTemplate                  = isset($variableSetting['selectedIconTemplate']) ? $variableSetting['selectedIconTemplate'] : 'template_one';
        $disableAttributeStyle                 = isset($variableSetting['disableAttributeStyle']) ? $variableSetting['disableAttributeStyle'] : 'blur_with_cross';
        $selectedIconColor                     = isset($variableSetting['selectedIconColor']) ? $variableSetting['selectedIconColor'] : '#249224';
        $disabledIconColor                     = isset($variableSetting['disabledIconColor']) ? $variableSetting['disabledIconColor'] : '#FF7F7F';
        $selectedIconShow                      = isset($variableSetting['selectedIconShow']) ? $variableSetting['selectedIconShow'] : '';
        $selectedDisabledIconWidth             = isset($variableSetting['selectedDisabledIconWidth']) ? $variableSetting['selectedDisabledIconWidth'] : '1';
        $displayFlexLabelValue                 = isset($variableSetting['displayFlexLabelValue']) ? $variableSetting['displayFlexLabelValue'] : '';
        $variationStockInfo                    = isset($variableSetting['variationStockInfo']) ? $variableSetting['variationStockInfo'] : '';
        $varimoSwatchesAlignArchive            = isset($variableSetting['varimoSwatchesAlignArchive']) ? $variableSetting['varimoSwatchesAlignArchive'] : 'left';
        $varimoTooltipPositionSwatches         = isset($variableSetting['varimoTooltipPositionSwatches']) ? $variableSetting['varimoTooltipPositionSwatches'] : 'top';
        $metaVariationSwatches                 = '';
        if (is_object($post) && isset($post->ID)) {
            $metaVariationSwatches = get_post_meta($post->ID, '_variation_swatches_meta', true);
        }
        $displayNoneImportant                  = '';

        if (($variationSelectOnOff === "true" && $selectVariationTemplateOnOff === "false") || (($metaVariationSwatches === 'true' || $metaVariationSwatches === '')&& $variationSelectOnOff === "true")){
           if ($metaVariationSwatches === 'true' || $metaVariationSwatches === ''){
           $displayNoneImportant = "none !important";
        }
        }
        if ($listBadgeShowRight === "true"){
            $displayRightBadge = "right";
        }else{
            $displayRightBadge = "left";
        }

        // Start OceanWP theme compatible
        $custom_margin_OceanWP = '';
        $quick_product_details_OceanWP_pl = '';
        $quick_product_details_OceanWP_pr = '';
        $quick_variable_tooltip_top_OceanWP = '';
        $quick_variable_tooltip_closebtn_OceanWP = '';
        $theme_select_display_OceanWP = '';
        if( wp_get_theme()->get('Name') === 'OceanWP' ) {
            $custom_margin_OceanWP = '15';
            $quick_product_details_OceanWP_pl = '10';
            $quick_product_details_OceanWP_pr = '10';
            $quick_variable_tooltip_top_OceanWP = '0';
            $quick_variable_tooltip_closebtn_OceanWP = '25';
            $theme_select_display_OceanWP = 'none !important';
        }

        // End OceanWP theme compatible

        $displayFlex = '';
        $alignItems = '';
        $justifyContent = '';
        if ($quickCartIconImageLink){
            $displayFlex = "flex";
            $alignItems = "center";
            $justifyContent= "center";
        }

        // Prepare dynamic CSS
        ob_start();
        ?>

        <?php
        if ($variationStockInfo === 'true'){
            ?>
            .reset_variations{
                margin-top: 15px;
                }
            <?php
        }

        if ($varimoSwatchesAlignArchive === 'center'){
            ?>
            li.product{
            display: flex;
            flex-direction: column;
            align-items: center;
            }
            <?php
        }

        if ($displayFlexLabelValue === 'true'){
            ?>
            .variations tr{
            display:flex;
            gap:20px;
            }
            <?php
        }

        if (wp_get_theme()->get('Name') === 'Astra'){
            ?>
            li.product {
            position: relative;
            max-width: 250px;
            }
            <?php
        }

        if (wp_get_theme()->get('Name') === 'Twenty Twenty-Five' || wp_get_theme()->get('Name') === 'Twenty Twenty-Two'){
            ?>
            .quick-variable-tooltip {
            position: absolute;
            top: 80px;
            width: 100%;
            }

            .wc-block-product-template li {
            position: relative;
            }
            <?php
        }
        if (wp_get_theme()->get('Name') === 'Twenty Twenty-Five'){
            ?>
            .lightbox-container .lightbox-button{
            top: 141px;
            }
            <?php
        }

        if ($variationSwatchesDisableSettings === "clickable-disable"){
            if ($disableAttributeStyle === "single_line_cross"){
                ?>
                .custom-button.disabled-option::before,
                .custom-color-button.disabled-option::before,
                .custom-image-button.disabled-option::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(
                to top left,
                transparent 0%,
                transparent calc(50% - <?php echo esc_attr($selectedDisabledIconWidth)?>px),
                <?php echo esc_attr($disabledIconColor)?> calc(50% - 1px),
                <?php echo esc_attr($disabledIconColor)?> calc(50% + 1px),
                transparent calc(50% + 1px),
                transparent 100%
                );
                pointer-events: none;
                z-index: 10;
                border-radius: inherit;
                transform: rotate(0.03deg);
                }
                <?php
            }elseif ($disableAttributeStyle === 'blur_with_cross'){
                ?>
                .custom-button.disabled-option::before,
                .custom-color-button.disabled-option::before,
                .custom-image-button.disabled-option::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100%;
                height: 100%;
                background:
                linear-gradient(
                to top right,
                transparent 0%,
                transparent calc(50% - <?php echo esc_attr($selectedDisabledIconWidth)?>px),
                <?php echo esc_attr($disabledIconColor)?> calc(50% - 1px),
                <?php echo esc_attr($disabledIconColor)?> calc(50% + 1px),
                transparent calc(50% + 1px),
                transparent 100%
                ),
                linear-gradient(
                to bottom right,
                transparent 0%,
                transparent calc(50% - <?php echo esc_attr($selectedDisabledIconWidth)?>px),
                <?php echo esc_attr($disabledIconColor)?> calc(50% - 1px),
                <?php echo esc_attr($disabledIconColor)?> calc(50% + 1px),
                transparent calc(50% + 1px),
                transparent 100%
                );
                pointer-events: none;
                z-index: 10;
                border-radius: inherit;
                transform: rotate(0.03deg);
                }
                <?php
            }elseif ($disableAttributeStyle === 'blur'){
                ?>
                .custom-button.disabled-option::before,
                .custom-color-button.disabled-option::before,
                .custom-image-button.disabled-option::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100%;
                height: 100%;
                opacity: 0.3;
                pointer-events: none;
                z-index: 10;
                border-radius: inherit;
                transform: rotate(0.03deg);
                }
                <?php
            }elseif ($disableAttributeStyle === 'hide'){
                ?>
                .disabled-option {
                display:none;
                }
                <?php
            }
            ?>

            .custom-button.disabled-option,
            .custom-color-button.disabled-option,
            .custom-image-button.disabled-option {
            position: relative;
            }

            .disabled-option {
            opacity: 0.5;
            }
            <?php
        }else{
            if ($disableAttributeStyle === "single_line_cross"){
                ?>
                .custom-button.disabled-option::before,
                .custom-color-button.disabled-option::before,
                .custom-image-button.disabled-option::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(
                to top left,
                transparent 0%,
                transparent calc(50% - <?php echo esc_attr($selectedDisabledIconWidth)?>px),
                <?php echo esc_attr($disabledIconColor)?> calc(50% - 1px),
                <?php echo esc_attr($disabledIconColor)?> calc(50% + 1px),
                transparent calc(50% + 1px),
                transparent 100%
                );
                pointer-events: none;
                z-index: 10;
                border-radius: inherit;
                transform: rotate(0.03deg);
                }
                <?php
            }elseif ($disableAttributeStyle === 'blur_with_cross'){
                ?>
                .custom-button.disabled-option::before,
                .custom-color-button.disabled-option::before,
                .custom-image-button.disabled-option::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 100%;
                    height: 100%;
                    background:
                    linear-gradient(
                    to top right,
                    transparent 0%,
                    transparent calc(50% - <?php echo esc_attr($selectedDisabledIconWidth)?>px),
                    <?php echo esc_attr($disabledIconColor)?> calc(50% - 1px),
                    <?php echo esc_attr($disabledIconColor)?> calc(50% + 1px),
                    transparent calc(50% + 1px),
                    transparent 100%
                    ),
                    linear-gradient(
                    to bottom right,
                    transparent 0%,
                    transparent calc(50% - <?php echo esc_attr($selectedDisabledIconWidth)?>px),
                    <?php echo esc_attr($disabledIconColor)?> calc(50% - 1px),
                    <?php echo esc_attr($disabledIconColor)?> calc(50% + 1px),
                    transparent calc(50% + 1px),
                    transparent 100%
                    );
                    pointer-events: none;
                    z-index: 10;
                    border-radius: inherit;
                    transform: rotate(0.03deg);
                }
                <?php
            }elseif ($disableAttributeStyle === 'blur'){
                ?>
                .custom-button.disabled-option::before,
                .custom-color-button.disabled-option::before,
                .custom-image-button.disabled-option::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100%;
                height: 100%;
                opacity: 0.3;
                pointer-events: none;
                z-index: 10;
                border-radius: inherit;
                transform: rotate(0.03deg);
                }
                <?php
            }elseif ($disableAttributeStyle === 'hide'){
                ?>
                .disabled-option {
                display:none;
                }
                <?php
            }
            ?>

            .custom-button.disabled-option,
            .custom-color-button.disabled-option,
            .custom-image-button.disabled-option {
            position: relative;
            cursor: not-allowed;
            }

            .disabled-option {
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.5;
            }
            <?php
        }
        if ($selectedIconShow === 'true'){
            if ($selectedIconTemplate === 'template_one'){
                ?>
                .custom-button.selected {
                border-color: <?php echo esc_attr($selectedVariationButtonBorderColor); ?>;
                background-image: url('data:image/svg+xml;utf8,<?php echo rawurlencode('<svg fill="green" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M16 7l-9 9-4-4" stroke="' . $selectedIconColor . '" stroke-width="'.$selectedDisabledIconWidth.'" fill="none" stroke-linecap="round"/></svg>'); ?>');
                background-repeat: no-repeat;
                background-position: center center;
                background-size: 90% 100%;
                }

                .custom-image-button.selected::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: url('data:image/svg+xml;utf8,<?php echo rawurlencode('<svg fill="green" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M16 7l-9 9-4-4" stroke="' . $selectedIconColor . '" stroke-width="'.$selectedDisabledIconWidth.'" fill="none" stroke-linecap="round"/></svg>'); ?>');
                border-radius: inherit;
                background-repeat: no-repeat;
                background-position: center center;
                background-size: 90% 100%;
                z-index: 1;
                }

                .custom-color-button.selected::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: url('data:image/svg+xml;utf8,<?php echo rawurlencode('<svg fill="green" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M16 7l-9 9-4-4" stroke="' . $selectedIconColor . '" stroke-width=" '.$selectedDisabledIconWidth.' " fill="none" stroke-linecap="round"/></svg>'); ?>');
                border-radius: inherit;
                background-repeat: no-repeat;
                background-position: center center;
                background-size: 90% 100%;
                z-index: 1;
                }
                <?php
            }else{
                ?>
                .custom-button.selected::before {
                content: '';
                position: absolute;
                top: -5px;
                right: -5px;
                width: 20px;
                height: 20px;
                background: <?php echo esc_attr($selectedIconColor) ?>;
                border-radius: 50%;
                border: 1px solid white;
                background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="white" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>');
                background-repeat: no-repeat;
                background-position: center;
                background-size: 60%;
                z-index: 10;
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                }

                .custom-image-button.selected::before {
                content: '';
                position: absolute;
                top: -5px;
                right: -5px;
                width: 20px;
                height: 20px;
                background: <?php echo esc_attr($selectedIconColor) ?>;
                border-radius: 50%;
                border: 1px solid white;
                background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="white" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>');
                background-repeat: no-repeat;
                background-position: center;
                background-size: 60%;
                z-index: 10;
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                }

                .custom-color-button.selected::before {
                content: '';
                position: absolute;
                top: -5px;
                right: -5px;
                width: 20px;
                height: 20px;
                background: <?php echo esc_attr($selectedIconColor) ?>;
                border-radius: 50%;
                border: 1px solid white;
                background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="white" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>');
                background-repeat: no-repeat;
                background-position: center;
                background-size: 60%;
                z-index: 10;
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                }
                <?php
            }
        }


        if($varimoTooltipPositionSwatches === 'top'){
            ?>
            .custom-tooltip {
            position: absolute;
            display: none;
            width: auto;
            min-width: 120px;
            max-width: 200px;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            z-index: 999999;
            pointer-events: none;
            transform: translateY(-100%);
            margin-top: -5px;
            }

            .custom-tooltip::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: <?php echo esc_attr($selectVariationTooltipBgColor)?> transparent transparent transparent;
            }

            .custom-tooltip.has-image {
            padding: 0;
            width: auto;
            max-width: 200px;
            transform: translateY(calc(-100% - 5px));
            }

            .custom-tooltip.has-image .tooltip-image {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 6px 6px 0 0;
            max-height: 150px;
            }

            .custom-tooltip.has-image .tooltip-image img {
            width: 100%;
            max-height: 150px;
            display: block;
            }

            .custom-tooltip.has-image .tooltip-text {
            padding: 8px 10px;
            border-radius: 0 0 6px 6px;
            }
            <?php
        }elseif ($varimoTooltipPositionSwatches === 'bottom'){
            ?>
            .custom-tooltip {
            position: absolute;
            display: none;
            width: auto;
            min-width: 120px;
            max-width: 200px;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            z-index: 999999;
            pointer-events: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }

            .custom-tooltip::before {
            content: "";
            position: absolute;
            bottom: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent transparent <?php echo esc_attr($selectVariationTooltipBgColor)?> transparent;
            }

            /* Improved image tooltip styling */
            .custom-tooltip.has-image {
            padding: 0;
            width: auto;
            max-width: 200px;
            }

            .custom-tooltip.has-image .tooltip-image {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 6px 6px 0 0;
            max-height: 150px;
            }

            .custom-tooltip.has-image .tooltip-image img {
            width: 100%;
            max-height: 150px;
            display: block;
            }

            .custom-tooltip.has-image .tooltip-text {
            padding: 8px 10px;
            border-radius: 0 0 6px 6px;
            }
            <?php
        }elseif ($varimoTooltipPositionSwatches === 'left'){
            ?>
            .custom-tooltip {
            position: absolute;
            display: none;
            width: auto;
            min-width: 120px;
            max-width: 200px;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            z-index: 999999;
            pointer-events: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }

            .custom-tooltip::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 100%;
            margin-top: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent transparent transparent <?php echo esc_attr($selectVariationTooltipBgColor)?>;
            }

            .custom-tooltip.has-image {
            padding: 0;
            width: auto;
            max-width: 200px;
            }

            .custom-tooltip.has-image .tooltip-image {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 6px 0 0 6px;
            max-height: 150px;
            }

            .custom-tooltip.has-image .tooltip-image img {
            width: 100%;
            max-height: 150px;
            display: block;
            }

            .custom-tooltip.has-image .tooltip-text {
            padding: 8px 10px;
            border-radius: 0 6px 6px 0;
            }
            <?php
        }elseif ($varimoTooltipPositionSwatches === 'right'){
            ?>
            .custom-tooltip {
            position: absolute;
            display: none;
            width: auto;
            min-width: 120px;
            max-width: 200px;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            z-index: 999999;
            pointer-events: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }

            .custom-tooltip::before {
            content: "";
            position: absolute;
            top: 50%;
            right: 100%;
            margin-top: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent <?php echo esc_attr($selectVariationTooltipBgColor)?> transparent transparent;
            }

            .custom-tooltip.has-image {
            padding: 0;
            width: auto;
            max-width: 200px;
            }

            .custom-tooltip.has-image .tooltip-image {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 6px 6px 0 0;
            max-height: 150px;
            }

            .custom-tooltip.has-image .tooltip-image img {
            width: 100%;
            max-height: 150px;
            display: block;
            }

            .custom-tooltip.has-image .tooltip-text {
            padding: 8px 10px;
            border-radius: 0 0 6px 6px;
            }
            <?php
        }
        ?>

        .quick-add-to-cart-shop-page, .quick-add-to-cart-shop-page-template-four, .bulk-add-to-cart{
        display: <?php echo esc_attr($displayFlex)?>;
        align-items: <?php echo esc_attr($alignItems)?>;
        justify-content: <?php echo esc_attr($justifyContent)?>;
        }

        @media (max-width: 767px) {
            .variation-list {
            grid-template-columns: repeat(<?php echo esc_attr($listPaginationPerLineMobile)?>, 1fr) !important;
            }
        }

        #prevPage , #nextPage , #prev-page, #next-page, #prev-btn, #next-btn, #prevPage-before-cart, #nextPage-before-cart{
        background-color: <?php echo esc_attr($paginationButtonBgColor)?>;
        color: <?php echo esc_attr($paginationButtonTextColor)?>;
        }

        #prevPage:hover,
        #prevPage-before-cart:hover,
        #nextPage-before-cart:hover,
        #nextPage:hover,
        #prev-page:hover,
        #next-page:hover,
        #prev-btn:hover,
        #next-btn:hover{
        background-color: <?php echo esc_attr($paginationButtonHoverBgColor); ?>;
        color: <?php echo esc_attr($paginationButtonTextHoverColor); ?>;
        }

        .theme-select{
        display: <?php echo esc_attr($theme_select_display_OceanWP)?>;
        }

        .quick-variable-slide{
        margin-left:<?php echo esc_attr($custom_margin_OceanWP)?>px;
        margin-right:<?php echo esc_attr($custom_margin_OceanWP)?>px;
        }

        .quick-variable-tooltip .closebtn{
        right: <?php echo esc_attr($quick_variable_tooltip_closebtn_OceanWP)?>px;
        }

        .quick-variable-tooltip .variableThumb{
        padding-left:<?php echo esc_attr($custom_margin_OceanWP)?>px;
        padding-right:<?php echo esc_attr($custom_margin_OceanWP)?>px;
        }

        .quick-variable-tooltip{
        top: <?php echo esc_attr($quick_variable_tooltip_top_OceanWP)?>px;
        }

        .quick-variable-tooltip #quick-product-details{
        padding-left: <?php echo esc_attr($quick_product_details_OceanWP_pl)?>px;
        padding-right: <?php echo esc_attr($quick_product_details_OceanWP_pr)?>px;
        }


        .variation-gallery-slider-single-product-page button i{
        color: <?php echo esc_attr($galleryNavigationButtonIconColor)?>
        }

        .variation-gallery-slider-single-product-page button i:hover{
        color: <?php echo esc_attr($galleryNavigationButtonIconHoverColor)?>
        }

        .variation-gallery-slider-single-product-page button{
        background-color: <?php echo esc_attr($galleryNavigationButtonBgColor)?>
        }

        .variation-gallery-slider-single-product-page button:hover{
        background-color: <?php echo esc_attr($galleryNavigationButtonBgHoverColor)?>
        }

        .table-template2-details-section{
        background-color: <?php echo esc_attr($template2DetailsSectionBgColor); ?> !important;
        }

        .table-template2-cart-section{
        background-color: <?php echo esc_attr($template2CartSectionBgColor); ?> !important;
        }
        .table-template2{
        background-color: <?php echo esc_attr($template2TableBgColor); ?> !important;
        }

        .bulk-add-to-cart, .bulk-add-to-cart-before-cart{
        background-color: <?php echo esc_attr($bulkAddCartBgColor); ?>;
        color: <?php echo esc_attr($bulkAddCartTextColor); ?>;
        }
        button.bulk-add-to-cart:hover , button.bulk-add-to-cart-before-cart:hover{
        background-color: <?php echo esc_attr($bulkAddCartHoverBgColor); ?>;
        color: <?php echo esc_attr($bulkAddCartHoverTextColor); ?>;
        }

        .badge-container{
        height: <?php echo esc_attr($listBadgeHeight); ?>px;
        width: <?php echo esc_attr($listBadgeWidth); ?>px;
        <?php echo esc_attr($displayRightBadge); ?>: 5px;
        }

        .sale-badge-template-two .price-sale-badge{
        <?php
        if ($listBadgeShowRight === "true"){
            ?>
            position: absolute;
            display: block;
            width: 129px;
            padding: 0 0;
            font-weight: bold;
            text-align: center;
            font-size: 13px;
            transform: rotate(45deg);
            top: 19px;
            right: -35px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
            <?php
        }else{
            ?>
            position: absolute;
            display: block;
            width: 146px;
            padding: 0 0;
            font-weight: bold;
            text-align: center;
            font-size: 13px;
            transform: rotate(-44deg);
            top: 19px;
            left: -43px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
            <?php
        }
        ?>
        }

        .sale-badge-template-two{
        <?php
        if ($listBadgeShowRight === "true"){
            ?>
            right: 0;
            <?php
        }else{
            ?>
            left: 0;
            <?php
        }
        ?>
        }

        .sale-badge-template-two .price-sale-badge, .sale-badge{
        background-color: <?php echo esc_attr($listBadgeBgColor); ?>;
        color: <?php echo esc_attr($listBadgeTextColor); ?>;
        }

        .variations select {
        display: <?php echo esc_attr($displayNoneImportant); ?>;
        }
        .custom-image-button{
            border-color: <?php echo esc_attr($swatchesButtonBorderColor); ?>;
            font-size: <?php echo esc_attr($fontSizeVarimoSwatches); ?>px;
        }
        .custom-button {
            border-color: <?php echo esc_attr($swatchesButtonBorderColor); ?>;
            font-size: <?php echo esc_attr($fontSizeVarimoSwatches); ?>px;
        }
        .custom-button.selected{
        border-color: <?php echo esc_attr($selectedVariationButtonBorderColor); ?>;
        position: relative;
        }
        .custom-color-button {
            border-color: <?php echo esc_attr($swatchesButtonBorderColor); ?>;
            font-size: <?php echo esc_attr($fontSizeVarimoSwatches); ?>px;
        }
        .custom-image-button.selected{
            border-color: <?php echo esc_attr($selectedVariationButtonBorderColor); ?>;
            position: relative;
        }

        .custom-color-button.selected {
        border-color: <?php echo esc_attr($selectedVariationButtonBorderColor); ?>;
        }

        .custom-wc-variations input[type=radio].selected {
        border-color: <?php echo esc_attr($selectedVariationButtonBorderColor); ?>;
        }

        .custom-button {
        border-radius: <?php echo esc_attr($buttonBorderRadius); ?>px;
        height: <?php echo esc_attr($buttonHeight); ?>px;
        width: <?php echo esc_attr($buttonWidth); ?>px;
        }

        .quick-variable-tooltip, .vmonster-quick-view-modal-content{
        background-color: <?php echo esc_attr($tooltipBgColor); ?>
        }
        .quick-variable-tooltip #quick-product-content,
        .quick-variable-tooltip #quick-product-content h4{
        color:<?php echo esc_attr($tooltipTextColor); ?>;
        }

        .quick-quantity-container .quick-quantity-decrease,
        .quick-quantity-container .quick-quantity-increase{
            background-color:<?php echo esc_attr($quantityBg); ?>;
            color:<?php echo esc_attr($quantityTextColor); ?>;
        }

        .quick-quantity-container .quick-quantity-increase:hover,
        .quick-quantity-container .quick-quantity-decrease:hover {
            background-color: <?php echo esc_attr($quantityBgColorHover); ?>;
            color:<?php echo esc_attr($quantityTextHoverColor); ?>;
        }

        .quick-quantity-container input.quick-quantity-input {
            border: 1px solid <?php echo esc_attr($quantityBorderColor); ?> !important;
        }
        button.quick-add-to-cart{
            background-color:<?php echo esc_attr($cartButtonBg); ?>;
            color:<?php echo esc_attr($cartButtonTextColor); ?>;
        }
        button.quick-add-to-cart-shop-page{
        background-color:<?php echo esc_attr($cartButtonBg); ?>;
        color:<?php echo esc_attr($cartButtonTextColor); ?>;
        }
        button.quick-add-to-cart-shop-page-template-four{
        background-color:<?php echo esc_attr($cartButtonBg); ?>;
        color:<?php echo esc_attr($cartButtonTextColor); ?>;
        }
        button.quick-add-to-cart:hover{
            background-color:<?php echo esc_attr($cartButtonBgHover); ?>;
            color:<?php echo esc_attr($cartButtonTextHoverColor); ?>;
        }
        button.quick-add-to-cart-shop-page:hover{
            background-color:<?php echo esc_attr($cartButtonBgHover); ?>;
            color:<?php echo esc_attr($cartButtonTextHoverColor); ?>;
        }
        button.quick-add-to-cart-shop-page-template-four:hover{
            background-color:<?php echo esc_attr($cartButtonBgHover); ?>;
            color:<?php echo esc_attr($cartButtonTextHoverColor); ?>;
        }
        button.quick-add-to-cart-shop-page i.fa{
            display:<?php echo esc_attr($variableAddToCartIcon); ?>
        }
        button.quick-add-to-cart-shop-page-template-four i.fa{
            display:<?php echo esc_attr($variableAddToCartIcon); ?>
        }
        #quick-variable-table th {
            background-color:<?php echo esc_attr( $tableHeadBgColor); ?>;
            color:<?php echo esc_attr($tableHeadTextColor); ?>;
        }
        #quick-variable-table td.quick-variable-title{
            color:<?php echo esc_attr($tableVariableTitleColor); ?>;
        }
        .quick-variable-slide button.slick-custom-arrow.slick-next.slick-arrow,
        .quick-variable-slide button.slick-custom-arrow.slick-prev.slick-arrow {
            background-color:<?php echo esc_attr( $carouselButtonBgColor ); ?>;
            color:<?php echo esc_attr( $carouselButtonIconColor ); ?>;
        }
        #quick-variable-table,
        #quick-variable-table td,
        #quick-variable-table th {
            border: <?php echo esc_attr(($quickTableBorder == "true") ? '1' : '0'); ?>px solid <?php echo esc_attr( $tableBorderColor ); ?>;
        }
        #quick-variable-table tr:nth-child(odd) {
            background-color: <?php echo esc_attr($tableBgColorOdd); ?>;
        }
        #quick-variable-table tr:nth-child(odd) td{
        background-color: <?php echo esc_attr($tableBgColorOdd); ?>;
        }
        #quick-variable-table tr:nth-child(even) {
            background-color: <?php echo esc_attr($tableBgColorEven); ?>;
        }
        #quick-variable-table tr:nth-child(even) td{
        background-color: <?php echo esc_attr($tableBgColorEven); ?>;
        }
        #quick-variable-table tr:hover td{
            background-color: <?php echo esc_attr($tableBgColorHover); ?>;
        }
<!--        #quick-variable-table{-->
<!--            display: --><?php //echo esc_attr(($quickTableOnOff == "false") ? 'none' : ''); ?>
<!--        }-->
<!--        .quick-variable-slide.slick-initialized.slick-slider{-->
<!--            display: --><?php //echo esc_attr(($quickCarouselOnOff == "false") ? 'none' : ''); ?>
<!--        }-->

        <?php
        $dynamic_css = ob_get_clean();
        wp_add_inline_style('varimo-main-css', $dynamic_css);
    }

}