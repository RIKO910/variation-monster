<?php
if (!defined('ABSPATH')) exit;

$varimoVariableSetting                        = get_option('variable_all_checked', array());
$varimoNewMetaDataForVariations               = isset($varimoVariableSetting['newMetaDataForVariations']) ? $varimoVariableSetting['newMetaDataForVariations'] : array();
$varimoNewMetaDataForVariationsTable          = isset($varimoVariableSetting['newMetaDataForVariationsTable']) ? $varimoVariableSetting['newMetaDataForVariationsTable'] : array();
$varimoNewMetaDataForVariationsTableOverwrite = isset($varimoVariableSetting['newMetaDataForVariationsTableOverwrite']) ? $varimoVariableSetting['newMetaDataForVariationsTableOverwrite'] : array();
$varimoNewMetaDataForVariationsList           = isset($varimoVariableSetting['newMetaDataForVariationsList']) ? $varimoVariableSetting['newMetaDataForVariationsList'] : array();
$varimoVariableHoverClick                    = isset($varimoVariableSetting['hoverClickValue'][0]) ? $varimoVariableSetting['hoverClickValue'][0] : 'variable-click';
$varimoShowAttributeSwatchesArchive          = isset($varimoVariableSetting['showAttributeSwatchesArchive'][0]) ? $varimoVariableSetting['showAttributeSwatchesArchive'][0] : 'none';
$varimoVariationSwatchesDisableSettings      = isset($varimoVariableSetting['variationSwatchesDisableSettings'][0]) ? $varimoVariableSetting['variationSwatchesDisableSettings'][0] : 'not-disable';
$varimoVariableTooltipPosition               = isset($varimoVariableSetting['boxPositionValue'][0]) ? $varimoVariableSetting['boxPositionValue'][0] : '';
$varimoVariableDetailsTitle                  = isset($varimoVariableSetting['variableDetailsTitle'][0]) ? $varimoVariableSetting['variableDetailsTitle'][0] : '';
$varimoVariableDetailsImage                  = isset($varimoVariableSetting['variableDetailsImage'][0]) ? $varimoVariableSetting['variableDetailsImage'][0] : '';
$varimoVariableDetailsExcerpt                = isset($varimoVariableSetting['variableDetailsExcerpt'][0]) ? $varimoVariableSetting['variableDetailsExcerpt'][0] : '';
$varimoVariableDetailsSKU                    = isset($varimoVariableSetting['variableDetailsSKU'][0]) ? $varimoVariableSetting['variableDetailsSKU'][0] : '';
$varimoVariableDetailsPrice                  = isset($varimoVariableSetting['variableDetailsPrice'][0]) ? $varimoVariableSetting['variableDetailsPrice'][0] : '';
$varimoVariableDetailsAttribute              = isset($varimoVariableSetting['variableDetailsAttribute'][0]) ? $varimoVariableSetting['variableDetailsAttribute'][0] : '';
$varimoQuickCartIcon                         = isset($varimoVariableSetting['quickCartIcon']) ? $varimoVariableSetting['quickCartIcon'] : 'fa fa-shopping-cart';
$varimoQuickCartIconImageLink                = isset($varimoVariableSetting['quickCartIconImageLink']) ? $varimoVariableSetting['quickCartIconImageLink'] : '';
$varimoCartButtonText                        = isset($varimoVariableSetting['cartButtonText']) ? $varimoVariableSetting['cartButtonText'] : 'Add-to-cart';
$varimoCartButtonBg                          = isset($varimoVariableSetting['cartButtonBg']) ? $varimoVariableSetting['cartButtonBg'] : '#007cba';
$varimoCartButtonTextColor                   = isset($varimoVariableSetting['cartButtonTextColor']) ? $varimoVariableSetting['cartButtonTextColor'] : '#fff';
$varimoCartButtonTextHoverColor              = isset($varimoVariableSetting['cartButtonTextHoverColor']) ? $varimoVariableSetting['cartButtonTextHoverColor'] : '#000000';
$varimoTooltipBgColor                        = isset($varimoVariableSetting['tooltipBg']) ? $varimoVariableSetting['tooltipBg'] : '#CECECE';
$varimoTooltipTextColor                      = isset($varimoVariableSetting['tooltipTextColor']) ? $varimoVariableSetting['tooltipTextColor'] : '#fff';
$varimoAddToCartSuccessColor                 = isset($varimoVariableSetting['addToCartSuccessColor']) ? $varimoVariableSetting['addToCartSuccessColor'] : '#fff';
$varimoAddToCartErrorColor                   = isset($varimoVariableSetting['addToCartErrorColor']) ? $varimoVariableSetting['addToCartErrorColor'] : '#FF0000';
$varimoQuantityBg                            = isset($varimoVariableSetting['quantityBg']) ? $varimoVariableSetting['quantityBg'] : '#007bff';
$varimoQuantityBorderColor                   = isset($varimoVariableSetting['quantityBorderColor']) ? $varimoVariableSetting['quantityBorderColor'] : '#ccc';
$varimoQuantityTextColor                     = isset($varimoVariableSetting['quantityTextColor']) ? $varimoVariableSetting['quantityTextColor'] : '#fff';
$varimoQuantityTextHoverColor                = isset($varimoVariableSetting['quantityTextHoverColor']) ? $varimoVariableSetting['quantityTextHoverColor'] : '#000000';
$varimoQuickCarouselAutoplay                 = isset($varimoVariableSetting['quickCarouselAutoplay']) ? $varimoVariableSetting['quickCarouselAutoplay'] : 'true';
$varimoShowDoublePrice                       = isset($varimoVariableSetting['showDoublePrice']) ? $varimoVariableSetting['showDoublePrice'] : 'true';
$varimoNameImageRedirect                     = isset($varimoVariableSetting['nameImageRedirect']) ? $varimoVariableSetting['nameImageRedirect'] : 'true';
$varimoCarouselButtonBgColor                 = isset($varimoVariableSetting['CarouselButtonBg']) ? $varimoVariableSetting['CarouselButtonBg'] : '#000';
$varimoCarouselButtonIconColor               = isset($varimoVariableSetting['CarouselButtonIconColor']) ? $varimoVariableSetting['CarouselButtonIconColor'] : '#fff';
$varimoGalleryNavigationButtonIconColor      = isset($varimoVariableSetting['galleryNavigationButtonIconColor']) ? $varimoVariableSetting['galleryNavigationButtonIconColor'] : '#fff';
$varimoGalleryNavigationButtonIconHoverColor = isset($varimoVariableSetting['galleryNavigationButtonIconHoverColor']) ? $varimoVariableSetting['galleryNavigationButtonIconHoverColor'] : '#D0D0D0';
$varimoGalleryNavigationButtonBgColor        = isset($varimoVariableSetting['galleryNavigationButtonBgColor']) ? $varimoVariableSetting['galleryNavigationButtonBgColor'] : '#808080';
$varimoGalleryNavigationButtonBgHoverColor   = isset($varimoVariableSetting['galleryNavigationButtonBgHoverColor']) ? $varimoVariableSetting['galleryNavigationButtonBgHoverColor'] : '##2F3031';
$varimoTableHeadBgColor                   = isset($varimoVariableSetting['tableHeadBgColor']) ? $varimoVariableSetting['tableHeadBgColor'] : '#007cba';
$varimoTemplate2TableBgColor              = isset($varimoVariableSetting['template2TableBgColor']) ? $varimoVariableSetting['template2TableBgColor'] : '#000000';
$varimoTemplate2DetailsSectionBgColor     = isset($varimoVariableSetting['template2DetailsSectionBgColor']) ? $varimoVariableSetting['template2DetailsSectionBgColor'] : '#FFFFFF';
$varimoTemplate2CartSectionBgColor        = isset($varimoVariableSetting['template2CartSectionBgColor']) ? $varimoVariableSetting['template2CartSectionBgColor'] : '#FBFBFB';
$varimoBulkAddCartBgColor                 = isset($varimoVariableSetting['bulkAddCartBgColor']) ? $varimoVariableSetting['bulkAddCartBgColor'] : '#007cba';
$varimoBulkAddCartTextColor               = isset($varimoVariableSetting['bulkAddCartTextColor']) ? $varimoVariableSetting['bulkAddCartTextColor'] : '#FFFFFF';
$varimoBulkAddCartHoverBgColor            = isset($varimoVariableSetting['bulkAddCartHoverBgColor']) ? $varimoVariableSetting['bulkAddCartHoverBgColor'] : '#007cba';
$varimoBulkAddCartHoverTextColor          = isset($varimoVariableSetting['bulkAddCartHoverTextColor']) ? $varimoVariableSetting['bulkAddCartHoverTextColor'] : '#000000';
$varimoPaginationButtonBgColor            = isset($varimoVariableSetting['paginationButtonBgColor']) ? $varimoVariableSetting['paginationButtonBgColor'] : '#007cba';
$varimoPaginationButtonHoverBgColor       = isset($varimoVariableSetting['paginationButtonHoverBgColor']) ? $varimoVariableSetting['paginationButtonHoverBgColor'] : '#045CB4';
$varimoPaginationButtonTextColor          = isset($varimoVariableSetting['paginationButtonTextColor']) ? $varimoVariableSetting['paginationButtonTextColor'] : '#ffffff';
$varimoPaginationButtonTextHoverColor     = isset($varimoVariableSetting['paginationButtonTextHoverColor']) ? $varimoVariableSetting['paginationButtonTextHoverColor'] : '#000000';
$varimoTableHeadTextColor                 = isset($varimoVariableSetting['tableHeadTextColor']) ? $varimoVariableSetting['tableHeadTextColor'] : '#fff';
$varimoTableVariableTitleColor            = isset($varimoVariableSetting['tableVariableTitleColor']) ? $varimoVariableSetting['tableVariableTitleColor'] : '#111111';
$varimoQuickTableBorder                   = isset($varimoVariableSetting['quickTableBorder']) ? $varimoVariableSetting['quickTableBorder'] : '0';
$varimoShowPopUpImage                     = isset($varimoVariableSetting['showPopUpImage']) ? $varimoVariableSetting['showPopUpImage'] : 'true';
$varimoShowGalleyImageIntoPopup           = isset($varimoVariableSetting['showGalleyImageIntoPopup']) ? $varimoVariableSetting['showGalleyImageIntoPopup'] : 'true';
$varimoTableBorderColor                   = isset($varimoVariableSetting['tableBorderColor']) ? $varimoVariableSetting['tableBorderColor'] : '#e1e8ed';
$varimoTableBgColorOdd                    = isset($varimoVariableSetting['tableBgColorOdd']) ? $varimoVariableSetting['tableBgColorOdd'] : 'transparent';
$varimoTableBgColorEven                   = isset($varimoVariableSetting['tableBgColorEven']) ? $varimoVariableSetting['tableBgColorEven'] : '#f2f2f2';
$varimoTableBgColorHover                  = isset($varimoVariableSetting['tableBgColorHover']) ? $varimoVariableSetting['tableBgColorHover'] : '#ddd';
$varimoOnSaleNameChange                   = isset($varimoVariableSetting['onSaleNameChange']) ? $varimoVariableSetting['onSaleNameChange'] : 'On Sale';
$varimoSelectAllNameChange                = isset($varimoVariableSetting['selectAllNameChange']) ? $varimoVariableSetting['selectAllNameChange'] : 'Select All';
$varimoTableRowPagination                 = isset($varimoVariableSetting['tableRowPagination']) ? $varimoVariableSetting['tableRowPagination'] : '5';
$varimoListPagination                     = isset($varimoVariableSetting['listPagination']) ? $varimoVariableSetting['listPagination'] : '3';
$varimoListPaginationPerLineMobile        = isset($varimoVariableSetting['listPaginationPerLineMobile']) ? $varimoVariableSetting['listPaginationPerLineMobile'] : '2';
$varimoSearchOptionTextChange             = isset($varimoVariableSetting['searchOptionTextChange']) ? $varimoVariableSetting['searchOptionTextChange'] : 'Search...';
$varimoAddToCartSuccessMessage            = isset($varimoVariableSetting['addToCartSuccessMessage']) ? $varimoVariableSetting['addToCartSuccessMessage'] : 'Successfully added to cart.';
$varimoQuickViewTextChange                = isset($varimoVariableSetting['quickViewTextChnage']) ? $varimoVariableSetting['quickViewTextChnage'] : 'Quick View';
$varimoMoreInfoTextChange                 = isset($varimoVariableSetting['moreInfoTextChange']) ? $varimoVariableSetting['moreInfoTextChange'] : 'More Information';
$varimoCartButtonBgHover                  = isset($varimoVariableSetting['cartButtonBgHover']) ? $varimoVariableSetting['cartButtonBgHover'] : '#045cb4';
$varimoPlusMinusBgColorHover              = isset($varimoVariableSetting['quantityBgColorHover']) ? $varimoVariableSetting['quantityBgColorHover'] : '#0056b3';
$varimoQuickCarouselOnOff                 = isset($varimoVariableSetting['quickCarouselOnOff']) ? $varimoVariableSetting['quickCarouselOnOff'] : '';
$varimoQuickViewOnOff                     = isset($varimoVariableSetting['quickViewOnOff']) ? $varimoVariableSetting['quickViewOnOff'] : '';
$varimoDefaultSelectionToSelect2          = isset($varimoVariableSetting['defaultSelectionToSelect2']) ? $varimoVariableSetting['defaultSelectionToSelect2'] : '';
$varimoQuickTableOnOff                    = isset($varimoVariableSetting['quickTableOnOff']) ? $varimoVariableSetting['quickTableOnOff'] : '';
$varimoBeforeCartQuickTableOnOff          = isset($varimoVariableSetting['beforeCartQuickTableOnOff']) ? $varimoVariableSetting['beforeCartQuickTableOnOff'] : '';
$varimoBulkSelectionHideShow              = isset($varimoVariableSetting['bulkSelectionHideShow']) ? $varimoVariableSetting['bulkSelectionHideShow'] : 'true';
$varimoImageHideShow                      = isset($varimoVariableSetting['imageHideShow']) ? $varimoVariableSetting['imageHideShow'] : 'true';
$varimoSkuHideShow                        = isset($varimoVariableSetting['skuHideShow']) ? $varimoVariableSetting['skuHideShow'] : 'true';
$varimoTitleHideShow                      = isset($varimoVariableSetting['titleHideShow']) ? $varimoVariableSetting['titleHideShow'] : 'true';
$varimoDescriptionHideShow                = isset($varimoVariableSetting['descriptionHideShow']) ? $varimoVariableSetting['descriptionHideShow'] : 'true';
$varimoWeightDimensionsHideShow           = isset($varimoVariableSetting['weightDimensionsHideShow']) ? $varimoVariableSetting['weightDimensionsHideShow'] : 'true';
$varimoAllAttributeHideShow               = isset($varimoVariableSetting['allAttributeHideShow']) ? $varimoVariableSetting['allAttributeHideShow'] : 'true';
$varimoPriceHideShow                      = isset($varimoVariableSetting['priceHideShow']) ? $varimoVariableSetting['priceHideShow'] : 'true';
$varimoQuantityHideShow                   = isset($varimoVariableSetting['quantityHideShow']) ? $varimoVariableSetting['quantityHideShow'] : 'true';
$varimoStockStatusHideShow                = isset($varimoVariableSetting['stockStatusHideShow']) ? $varimoVariableSetting['stockStatusHideShow'] : 'true';
$varimoActionHideShow                     = isset($varimoVariableSetting['actionHideShow']) ? $varimoVariableSetting['actionHideShow'] : 'true';
$varimoOnSaleHideShow                     = isset($varimoVariableSetting['onSaleHideShow']) ? $varimoVariableSetting['onSaleHideShow'] : 'true';
$varimoSearchOptionHideShow               = isset($varimoVariableSetting['searchOptionHideShow']) ? $varimoVariableSetting['searchOptionHideShow'] : 'true';
$varimoBulkAddToCartPosition              = isset($varimoVariableSetting['bulkAddToCartPosition']) ? $varimoVariableSetting['bulkAddToCartPosition'] : 'after';
$varimoVariationGalleryOnOff              = isset($varimoVariableSetting['variationGalleryOnOff']) ? $varimoVariableSetting['variationGalleryOnOff'] : '';
$varimoAttributeGalleryOnOff              = isset($varimoVariableSetting['attributeGalleryOnOff']) ? $varimoVariableSetting['attributeGalleryOnOff'] : '';
$varimoDesignSingleProductPageMobile      = isset($varimoVariableSetting['designSingleProductPageMobile']) ? $varimoVariableSetting['designSingleProductPageMobile'] : 'template_1';
$varimoVariationTableTemplate             = isset($varimoVariableSetting['variationTableTemplate']) ? $varimoVariableSetting['variationTableTemplate'] : 'template_1';
$varimoOverwriteDefaultCartTableTemplate  = isset($varimoVariableSetting['overwriteDefaultCartTableTemplate']) ? $varimoVariableSetting['overwriteDefaultCartTableTemplate'] : 'template_1';
$varimoQuickCartCarouselTemplate          = isset($varimoVariableSetting['quickCartCarouselTemplate']) ? $varimoVariableSetting['quickCartCarouselTemplate'] : 'template_1';
$varimoDesignAddCartTableTemplate2        = isset($varimoVariableSetting['designAddCartTableTemplate2']) ? $varimoVariableSetting['designAddCartTableTemplate2'] : 'template_1';
$varimoQuickCarouselPosition              = isset($varimoVariableSetting['quickCarouselPosition']) ? $varimoVariableSetting['quickCarouselPosition'] : 'woocommerce_after_shop_loop_item';
$varimoDisplayPositionSwatchesArchivePage = isset($varimoVariableSetting['displayPositionSwatchesArchivePage']) ? $varimoVariableSetting['displayPositionSwatchesArchivePage'] : 'woocommerce_after_shop_loop_item';
$varimoQuickTablePosition                 = isset($varimoVariableSetting['quickTablePosition']) ? $varimoVariableSetting['quickTablePosition'] : 'woocommerce_after_single_product_summary';
$varimoPopUPImageShow                     = isset($varimoVariableSetting['popUPImageShow']) ? $varimoVariableSetting['popUPImageShow'] : 'thumbnail';
$varimoGalleryImageShow                   = isset($varimoVariableSetting['galleryImageShow']) ? $varimoVariableSetting['galleryImageShow'] : 'large';
$varimoGalleryStyleTemplate               = isset($varimoVariableSetting['galleryStyleTemplate']) ? $varimoVariableSetting['galleryStyleTemplate'] : 'template_1';
$varimoAttributeGalleryImageShow          = isset($varimoVariableSetting['attributeGalleryImageShow']) ? $varimoVariableSetting['attributeGalleryImageShow'] : 'large';
$varimoCarouselImageSize                  = isset($varimoVariableSetting['carouselImageSize']) ? $varimoVariableSetting['carouselImageSize'] : 'thumbnail';
$varimoCarouselGalleryImageSize           = isset($varimoVariableSetting['carouselGalleryImageSize']) ? $varimoVariableSetting['carouselGalleryImageSize'] : 'large';
$varimoListImageShow                      = isset($varimoVariableSetting['listImageShow']) ? $varimoVariableSetting['listImageShow'] : 'thumbnail';
$varimoAttributeImageShow                 = isset($varimoVariableSetting['attributeImageShow']) ? $varimoVariableSetting['attributeImageShow'] : 'thumbnail';
$varimoGloballyTooltipOnOff               = isset($varimoVariableSetting['globallyTooltipOnOff']) ? $varimoVariableSetting['globallyTooltipOnOff'] : '';
$varimoSelectedIconShow                   = isset($varimoVariableSetting['selectedIconShow']) ? $varimoVariableSetting['selectedIconShow'] : '';
$varimoImageShowIntoTooltip               = isset($varimoVariableSetting['imageShowIntoTooltip']) ? $varimoVariableSetting['imageShowIntoTooltip'] : '';
$varimoVariationSelectOnOff               = isset($varimoVariableSetting['variationSelectOnOff']) ? $varimoVariableSetting['variationSelectOnOff'] : '';
$varimoShowSelectedAttribute              = isset($varimoVariableSetting['showSelectedAttribute']) ? $varimoVariableSetting['showSelectedAttribute'] : '';
$varimoVariationLabelSeparator            = isset($varimoVariableSetting['variationLabelSeparator']) ? $varimoVariableSetting['variationLabelSeparator'] : '=';
$varimoAttributeDisplayLimit              = isset($varimoVariableSetting['attributeDisplayLimit']) ? $varimoVariableSetting['attributeDisplayLimit'] : '5';
$varimoFilterAttributeDisplayLimit        = isset($varimoVariableSetting['filterAttributeDisplayLimit']) ? $varimoVariableSetting['filterAttributeDisplayLimit'] : '5';
$varimoGenerateVariationURL               = isset($varimoVariableSetting['generateVariationURL']) ? $varimoVariableSetting['generateVariationURL'] : '';
$varimoVariationStockInfo                 = isset($varimoVariableSetting['variationStockInfo']) ? $varimoVariableSetting['variationStockInfo'] : '';
$varimoAttributeDisplayLimitEnable        = isset($varimoVariableSetting['attributeDisplayLimitEnable']) ? $varimoVariableSetting['attributeDisplayLimitEnable'] : '';
$varimoShowOnFilterWidget                 = isset($varimoVariableSetting['showOnFilterWidget']) ? $varimoVariableSetting['showOnFilterWidget'] : '';
$varimoDisplayFlexLabelValue              = isset($varimoVariableSetting['displayFlexLabelValue']) ? $varimoVariableSetting['displayFlexLabelValue'] : '';
$varimoSelectVariationTooltipBgColor      = isset($varimoVariableSetting['selectVariationTooltipBgColor']) ? $varimoVariableSetting['selectVariationTooltipBgColor'] : '#000000';
$varimoSelectedIconColor                  = isset($varimoVariableSetting['selectedIconColor']) ? $varimoVariableSetting['selectedIconColor'] : '#249224';
$varimoDisabledIconColor                  = isset($varimoVariableSetting['disabledIconColor']) ? $varimoVariableSetting['disabledIconColor'] : '#FF7F7F';
$varimoSelectVariationTooltipTextColor    = isset($varimoVariableSetting['selectVariationTooltipTextColor']) ? $varimoVariableSetting['selectVariationTooltipTextColor'] : '#FFFFFF';
$varimoSelectVariationButtonBgColor       = isset($varimoVariableSetting['selectVariationButtonBgColor']) ? $varimoVariableSetting['selectVariationButtonBgColor'] : '#FFFFFF';
$varimoSelectVariationButtonTextColor     = isset($varimoVariableSetting['selectVariationButtonTextColor']) ? $varimoVariableSetting['selectVariationButtonTextColor'] : '#000000';
$varimoImageColorWidth                    = isset($varimoVariableSetting['imageColorWidth']) ? $varimoVariableSetting['imageColorWidth'] : '40';
$varimoImageColorHeight                   = isset($varimoVariableSetting['imageColorHeight']) ? $varimoVariableSetting['imageColorHeight'] : '40';
$varimoFontSizeVarimoSwatches             = isset($varimoVariableSetting['fontSizeVarimoSwatches']) ? $varimoVariableSetting['fontSizeVarimoSwatches'] : '14';
$varimoSelectedDisabledIconWidth          = isset($varimoVariableSetting['selectedDisabledIconWidth']) ? $varimoVariableSetting['selectedDisabledIconWidth'] : '1';
$varimoImageColorBorderRadius             = isset($varimoVariableSetting['imageColorBorderRadius']) ? $varimoVariableSetting['imageColorBorderRadius'] : '50';
$varimoSwatchesButtonBorderColor          = isset($varimoVariableSetting['swatchesButtonBorderColor']) ? $varimoVariableSetting['swatchesButtonBorderColor'] : '#000000';
$varimoSelectedVariationButtonBorderColor = isset($varimoVariableSetting['selectedVariationButtonBorderColor']) ? $varimoVariableSetting['selectedVariationButtonBorderColor'] : '#17AF31';
$varimoButtonWidth                        = isset($varimoVariableSetting['buttonWidth']) ? $varimoVariableSetting['buttonWidth'] : ' ';
$varimoButtonHeight                       = isset($varimoVariableSetting['buttonHeight']) ? $varimoVariableSetting['buttonHeight'] : ' ';
$varimoButtonBorderRadius                 = isset($varimoVariableSetting['buttonBorderRadius']) ? $varimoVariableSetting['buttonBorderRadius'] : '5';
$varimoSelectVariationTemplateOnOff       = isset($varimoVariableSetting['selectVariationTemplateOnOff']) ? $varimoVariableSetting['selectVariationTemplateOnOff'] : '';
$varimoListLabelOnOff                     = isset($varimoVariableSetting['listLabelOnOff']) ? $varimoVariableSetting['listLabelOnOff'] : '';
$varimoListSkuOnOff                       = isset($varimoVariableSetting['listSkuOnOff']) ? $varimoVariableSetting['listSkuOnOff'] : '';
$varimoListPriceOnOff                     = isset($varimoVariableSetting['listPriceOnOff']) ? $varimoVariableSetting['listPriceOnOff'] : '';
$varimoListQuantityOnOff                  = isset($varimoVariableSetting['listQuantityOnOff']) ? $varimoVariableSetting['listQuantityOnOff'] : '';
$varimoListAttributeShow                  = isset($varimoVariableSetting['listAttributeShow']) ? $varimoVariableSetting['listAttributeShow'] : '';
$varimoListTitleShow                      = isset($varimoVariableSetting['listTitleShow']) ? $varimoVariableSetting['listTitleShow'] : '';
$varimoListBadgeShowOnOff                 = isset($varimoVariableSetting['listBadgeShowOnOff']) ? $varimoVariableSetting['listBadgeShowOnOff'] : '';
$varimoListBadgeShowRight                 = isset($varimoVariableSetting['listBadgeShowRight']) ? $varimoVariableSetting['listBadgeShowRight'] : '';
$varimoListBadgeDiscountFlatPrice         = isset($varimoVariableSetting['listBadgeDiscountFlatPrice']) ? $varimoVariableSetting['listBadgeDiscountFlatPrice'] : '';
$varimoListBadgeBgColor                   = isset($varimoVariableSetting['listBadgeBgColor']) ? $varimoVariableSetting['listBadgeBgColor'] : '#FF5733';
$varimoListBadgeTextColor                 = isset($varimoVariableSetting['listBadgeTextColor']) ? $varimoVariableSetting['listBadgeTextColor'] : '#ffffff';
$varimoListBadgeHeight                    = isset($varimoVariableSetting['listBadgeHeight']) ? $varimoVariableSetting['listBadgeHeight'] : ' ';
$varimoListBadgeWidth                     = isset($varimoVariableSetting['listBadgeWidth']) ? $varimoVariableSetting['listBadgeWidth'] : ' ';
$varimoListForPercent                     = isset($varimoVariableSetting['listForPercent']) ? $varimoVariableSetting['listForPercent'] : '% OFF';
$varimoListForFlat                        = isset($varimoVariableSetting['listForFlat']) ? $varimoVariableSetting['listForFlat'] : 'OFF';
$varimoVariationListTemplate              = isset($varimoVariableSetting['variationListTemplate']) ? $varimoVariableSetting['variationListTemplate'] : 'template_1';
$varimoDisableAttributeStyle              = isset($varimoVariableSetting['disableAttributeStyle']) ? $varimoVariableSetting['disableAttributeStyle'] : 'blur_with_cross';
$varimoSwatchesAlignArchive         = isset($varimoVariableSetting['varimoSwatchesAlignArchive']) ? $varimoVariableSetting['varimoSwatchesAlignArchive'] : 'left';
$varimoTooltipPositionSwatches      = isset($varimoVariableSetting['varimoTooltipPositionSwatches']) ? $varimoVariableSetting['varimoTooltipPositionSwatches'] : 'top';
$varimoSelectedIconTemplate               = isset($varimoVariableSetting['selectedIconTemplate']) ? $varimoVariableSetting['selectedIconTemplate'] : 'template_one';
$varimoLicense_key                        = get_option('quick_license_key') ? get_option('quick_license_key') : "Enter Licence Key";
$varimoExDateInt                          = get_option('quick_license_expiry_date') ? get_option('quick_license_expiry_date') : "0";
$varimoExDate                             = gmdate("Y-m-d H:i:s", $varimoExDateInt) ;
$varimoLicense_active                     = get_option('quick_license_key');

?>

<div class="quick-variable-dashboard">
    <div class="alert adminAlert quick-hidden">
    </div>

    <div class="tab">
        <a style="padding:8px;" class="tablinks" onclick="event.preventDefault(); varimoDashboardClick(event, 'general')" id="defaultOpen">
            <i class="fas fa-cog"></i> <?php echo wp_kses(' General Setting','variation-monster'); ?>
        </a>
        <div class="vertical-divider"></div>
        <a style="padding:8px" class="tablinks" onclick="event.preventDefault(); varimoDashboardClick(event, 'carousel')">
            <i class="fas fa-sliders-h"></i> <?php echo wp_kses(' Carousel Settings','variation-monster'); ?>
        </a>
        <div class="vertical-divider"></div>
        <a style="padding:8px" class="tablinks" onclick="event.preventDefault(); varimoDashboardClick(event, 'table')">
            <i class="fas fa-table"></i> <?php echo wp_kses(' Table Setting','variation-monster'); ?>
        </a>
        <div class="vertical-divider"></div>
        <a style="padding:8px" class="tablinks" onclick="event.preventDefault(); varimoDashboardClick(event, 'select-variation')">
            <i class="fas fa-layer-group"></i> <?php echo wp_kses(' Variation Swatches','variation-monster'); ?>
        </a>
        <div class="vertical-divider"></div>
        <a style="padding:8px" class="tablinks" onclick="event.preventDefault(); varimoDashboardClick(event, 'select-variation-ul-li')">
            <i class="fas fa-list"></i> <?php echo wp_kses(' Variation List','variation-monster'); ?>
        </a>
        <div class="vertical-divider"></div>
        <a style="padding:8px" class="tablinks" onclick="event.preventDefault(); varimoDashboardClick(event, 'variation-gallery')">
            <i class="fas fa-images"></i> <?php echo wp_kses(' Variation Gallery','variation-monster'); ?>
        </a>
        <div class="vertical-divider"></div>
        <a style="padding:8px" class="tablinks" onclick="event.preventDefault(); varimoDashboardClick(event, 'attribute-gallery')">
            <i class="fas fa-shapes"></i> <?php echo wp_kses(' Attribute Gallery','variation-monster'); ?>
        </a>
    </div>

    <div id="general" class="tabcontent" >
        <div id="quickSwitchesWrapper">
            <h2><?php echo esc_html('Carousel and Table General Setting','variation-monster'); ?></h2>

            <div class="quick-selections" style="display: flex; align-items: center;">
                <h4><?php echo wp_kses('Show Sell Price If Available: ','variation-monster');



                    ?></h4>
                <div class="quick-selectors-wrapper">
                    <div class="show-double-price">
                        <label class="switch">
                            <input type="checkbox" name="show-double-price" <?php if( $varimoShowDoublePrice == "true" ): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center;">
                <h4><?php echo wp_kses('Add to Cart Icon (Font Awesome 5): ','variation-monster');?></h4>
                <div class="quick-selectors-wrapper">
                    <div class="icon-design" style="display: flex; gap: 10px; align-items: center;">

                        <?php
                        $varimo_variation_quick_cart_icon = [
                                'fa fa-shopping-cart',
                                'fa fa-cart-arrow-down',
                                'fa fa-cart-plus',
                                'fa none'
                        ];

                        $varimo_variation_quick_cart_icon_final = apply_filters('varimo_quick_cart_icon', $varimo_variation_quick_cart_icon);

                        foreach ($varimo_variation_quick_cart_icon_final as $varimo_quick_cart_icon_final) {



                            ?>
                            <label style="display: flex; align-items: center; gap: 5px;">
                                <input type="radio" class="quick-cart-icon" name="quick_cart_icon" value="<?php echo esc_attr($varimo_quick_cart_icon_final); ?>"
                                        <?php echo ($varimoQuickCartIcon === $varimo_quick_cart_icon_final) ? 'checked' : ''; ?> />
                                <?php if ($varimo_quick_cart_icon_final === 'fa none') { ?>
                                    <span style="font-size: 16px; color: black">None</span>
                                <?php } else { ?>
                                    <i class="<?php echo esc_attr($varimo_quick_cart_icon_final); ?>" style="font-size: 20px;"></i>
                                <?php } ?>
                            </label>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
            <h4 style="margin-top: 20px">OR</h4>
            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="quick-cart-icon-image-link"><strong><?php echo esc_html('Add to Cart Icon Image Link:','variation-monster'); ?></strong></label>
                    <input id="quick-cart-icon-image-link" type="text" class="quick-cart-icon-image-link" value="<?php echo  esc_attr($varimoQuickCartIconImageLink); ?>">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="quick-add-to-cart-text"><strong><?php echo esc_html('Add to Cart Button Text:','variation-monster'); ?></strong></label>
                    <input id="quick-add-to-cart-text" type="text" class="quick-add-to-cart-text" value="<?php echo  esc_attr($varimoCartButtonText); ?>">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="add-to-cart-bg"><strong><?php echo esc_html('Add to Cart Button Background Color:','variation-monster'); ?></strong></label>
                    <input id="add-to-cart-bg" name="add-to-cart-bg" value="<?php echo esc_attr($varimoCartButtonBg); ?>" data-jscolor="{}">
                </div>
            </div>


            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="add-to-cart-bg-hover"><strong><?php echo wp_kses('Add to Cart Button Background Hover Color: ','variation-monster');?></strong></label>
                    <input id="add-to-cart-bg-hover" name="add-to-cart-bg-hover" value="<?php echo esc_attr($varimoCartButtonBgHover); ?>" data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="add-to-cart-text"><strong><?php echo wp_kses('Add to Cart Button Text Color: ','variation-monster');?></strong></label>
                    <input id="add-to-cart-text" name="add-to-cart-text" value="<?php echo esc_attr($varimoCartButtonTextColor); ?>" data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="add-to-cart-text-hover-color"><strong><?php echo wp_kses('Add to Cart Button Text Hover Color: ','variation-monster');?></strong></label>
                    <input id="add-to-cart-text-hover-color" name="add-to-cart-text-hover-color" value="<?php echo esc_attr($varimoCartButtonTextHoverColor); ?>" data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="quantity-bg-color"><strong><?php echo esc_html('Quantity Plus Minus Button Background Color:','variation-monster'); ?></strong></label>
                    <input id="quantity-bg-color" name="quantity-bg-color" value="<?php echo esc_attr($varimoQuantityBg); ?>" data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="quantity-bg-color-hover"><strong><?php echo wp_kses('Quantity Plus Minus Button Background Hover Color: ','variation-monster');?></strong></label>
                    <input id="quantity-bg-color-hover" name="quantity-bg-color-hover" value="<?php echo esc_attr($varimoPlusMinusBgColorHover); ?>" data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="quantity-text-color"><strong> <?php echo wp_kses('Quantity Plus Minus Button Text Color: ','variation-monster');?></strong></label>
                    <input id="quantity-text-color" name="quantity-text-color" value="<?php echo esc_attr($varimoQuantityTextColor); ?>"  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="quantity-text-hover-color"><strong> <?php echo wp_kses('Quantity Plus Minus Button Text Hover Color: ','variation-monster');?></strong></label>
                    <input id="quantity-text-hover-color" name="quantity-text-hover-color" value="<?php echo esc_attr($varimoQuantityTextHoverColor); ?>"  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="quantity-border-color"><strong> <?php echo wp_kses('Quantity Border Color:','variation-monster'); ?></strong></label>
                    <input id="quantity-border-color" name="quantity-border-color" value="<?php echo esc_attr( $varimoQuantityBorderColor ); ?>"  data-jscolor="{}">
                </div>
            </div>

        </div>

    </div>

    <div id="carousel" class="tabcontent">
        <div id="quickSwitchesWrapper">
            <h2><?php echo esc_html('Variation Quick Cart Carousel Setting','variation-monster'); ?></h2>

            <div class="quick-selections" style="display: flex; align-items: center;">
                <h4><?php echo wp_kses('Variation Quick Cart Carousel On:', 'variation-monster'); ?></h4>
                <div class="quick-selectors-wrapper">
                    <div class="quick-carousel-on-off">
                        <label class="switch">
                            <input type="checkbox" value="quick-carousel-on-off" <?php if($varimoQuickCarouselOnOff == "true"): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center;">
                <h4><?php echo wp_kses('Quick view On:', 'variation-monster'); ?> <span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="quick-view-on-off">
                        <label class="switch">
                            <input type="checkbox" value="quick-view-on-off" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections quick-selections-style" style="display: flex; gap: 50%">
                <div>
                    <h4><?php echo wp_kses('Quick Cart Carousel Template: ','variation-monster');?> <span class="dashicons dashicons-lock"></span></h4>

                    <div>
                        <select disabled id="quick-cart-carousel-template" class="quick-cart-carousel-template" style="outline: none">
                            <option value="template_1" ><?php echo wp_kses('Template 1','variation-monster');?></option>
                            <option value="template_2" ><?php echo wp_kses('Template 2','variation-monster');?></option>
                            <option value="template_3" ><?php echo wp_kses('Template 3','variation-monster');?></option>
                            <option value="template_4" ><?php echo wp_kses('Template 4','variation-monster');?></option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Variable Carousel Position Select -->
            <div class="quick-selections quick-selections-style" >
                <h4 ><?php echo wp_kses('Variation Quick Cart Carousel Position: ','variation-monster');

                    ?></h4>
                <div style="display: flex; gap: 10%;">
                    <select class="quick-carousel-position">

                        <?php
                        $varimo_variable_quick_cart_hook = [
                                'woocommerce_before_shop_loop_item',
                                'woocommerce_after_shop_loop_item',
                                'woocommerce_before_shop_loop_item_title',
                                'woocommerce_after_shop_loop_item_title'
                        ];

                        $varimo_variable_quick_cart_hook_final = apply_filters('varimo_quick_cart_carousel_position', $varimo_variable_quick_cart_hook);

                        foreach ($varimo_variable_quick_cart_hook_final as $varimo_quick_cart_hook_final) {

                            $varimo_formatted_hook_name = ucwords(str_replace('_', ' ', str_replace('woocommerce_', '', $varimo_quick_cart_hook_final)));

                            ?>
                            <option value="<?php echo esc_attr($varimo_quick_cart_hook_final); ?>" <?php selected($varimoQuickCarouselPosition, $varimo_quick_cart_hook_final); ?>>
                                <?php echo esc_html($varimo_formatted_hook_name); ?>
                            </option>
                            <?php
                        }
                        ?>

                    </select>

                    <!-- Help Start -->
                    <button class="help-button variation-cart-carousel-setting-help">?</button>

                    <!-- Popup Structure -->
                    <div id="varimo-quick-cart-admin-popup-container" style="display: none;">


                        <div class="varimo-quick-cart-admin-popup-content">
                            <span class="close">&times;</span>
                            <div class="help-image"></div>
                        </div>
                    </div>
                    <!-- Help End -->
                </div>
            </div>


            <!-- Carousel Image Size -->
            <div class="quick-selections quick-selections-style">
                <h4><?php echo wp_kses('Carousel Image Size : ','variation-monster');?> <span class="dashicons dashicons-lock"></span></h4>
                <div style="display: flex; gap: 80px;">
                    <select id="carousel-image-size" class="carousel-image-size" disabled>


                        <?php
                        $varimo_carousel_image_size_hook = [
                                'thumbnail',
                                'medium',
                                'medium_large',
                                'large',
                                'woocommerce_thumbnail',
                                'woocommerce_single',
                                'woocommerce_gallery_thumbnail'
                        ];

                        $varimo_carousel_image_size_final_hook = apply_filters('varimo_quick_cart_carousel_size_hook', $varimo_carousel_image_size_hook);

                        foreach ($varimo_carousel_image_size_final_hook as $varimo_carousel_image_final_hook) {

                            $varimo_formatted_image_size_hook_name = ucwords(str_replace('_', ' ', $varimo_carousel_image_final_hook));

                            ?>
                            <option value="<?php echo esc_attr($varimo_carousel_image_final_hook); ?>" <?php selected($varimoCarouselImageSize, $varimo_carousel_image_final_hook); ?>>
                                <?php echo esc_html($varimo_formatted_image_size_hook_name); ?>
                            </option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
            </div>


            <div class="quick-selections" style="display: flex; align-items: center;">
                <h4><?php echo wp_kses('Carousel Autoplay On: ','variation-monster');?> <span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="quick-carousel-autoplay">
                        <label class="switch">
                            <input type="checkbox" name="quick-carousel-autoplay" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center;">
                <h4><?php echo wp_kses('Redirect to Single Product Page: ','variation-monster');?>
                    <span class="dashicons dashicons-lock"></span>
                    <span class="redirect-single-page-help" data-tooltip="When click on image or title in popup">?</span>
                </h4>
                <div class="quick-selectors-wrapper">
                    <div class="name-image-redirect">
                        <label class="switch">
                            <input type="checkbox" name="name-image-redirect" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper" >
                    <label for="quick-carousel-button-bg-color"><strong> <?php echo esc_html('Carousel Nav Background Color:','variation-monster'); ?></strong></label>
                    <input id="quick-carousel-button-bg-color" name="quick-carousel-button-bg-color" value="<?php echo esc_attr( $varimoCarouselButtonBgColor ); ?>"  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="quick-carousel-button-icon-color"><strong> <?php echo wp_kses('Carousel Navigation Button Icon Color: ','variation-monster');?></strong></label>
                    <input id="quick-carousel-button-icon-color" name="quick-carousel-button-icon-color" value="<?php echo esc_attr( $varimoCarouselButtonIconColor ); ?>"  data-jscolor="{}">
                </div>
            </div>
            <!-- Variable Details Box Show Checkboxes -->
            <div class="quick-selections quick-selections-style">
                <h4><?php echo esc_html('Popup Show:','variation-monster'); ?></h4>
                <div class="quick-selectors-wrapper">
                    <div class="quick-hover-click">
                        <label class="switch">
                            <input type="checkbox" value="variable-hover" <?php if($varimoVariableHoverClick == "variable-hover"): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('On Hover','variation-monster'); ?></span>
                    </div>
                    <div class="quick-hover-click">
                        <label class="switch">
                            <input type="checkbox" value="variable-click" <?php if($varimoVariableHoverClick== "variable-click"): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('On Click ','variation-monster'); ?></span>
                    </div>
                </div>
            </div>
            <!-- Variable Details Box Position Checkboxes -->
            <div class="quick-selections quick-selections-style">
                <h4><?php echo esc_html('Popup Position:','variation-monster'); ?></h4>
                <div class="quick-selectors-wrapper">
                    <div class="quick-box-position-click">
                        <label class="switch">
                            <input type="checkbox" value="quick-tooltip-position-center" <?php if($varimoVariableTooltipPosition == "quick-tooltip-position-center" || $varimoVariableTooltipPosition == "" || empty($varimoVariableSetting)): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('Center','variation-monster'); ?></span>
                    </div>

                    <div class="quick-box-position-click">
                        <label class="switch">
                            <input type="checkbox" value="quick-tooltip-position-left" <?php if($varimoVariableTooltipPosition == "quick-tooltip-position-left"): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('Left ','variation-monster');?></span>
                    </div>

                    <div class="quick-box-position-click">
                        <label class="switch">
                            <input type="checkbox" value="quick-tooltip-position-right"  <?php if($varimoVariableTooltipPosition == "quick-tooltip-position-right"): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('Right ','variation-monster');?></span>
                    </div>
                </div>
            </div>
            <div class="quick-selections quick-selections-style">
                <h4><?php echo esc_html('Popup Contents:','variation-monster'); ?></h4>
                <div class="quick-selectors-wrapper">

                    <div class="quick-box-content-click">
                        <label class="switch">
                            <input type="checkbox" value="variable-title-in-box" <?php if( !empty($varimoVariableDetailsTitle) || empty($varimoVariableSetting) ): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('Title','variation-monster'); ?></span>
                    </div>

                    <div class="quick-box-content-click">
                        <label class="switch">
                            <input type="checkbox" value="variable-image-in-box" <?php if( !empty($varimoVariableDetailsImage) || empty($varimoVariableSetting) ): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('Image','variation-monster'); ?></span>
                    </div>

                    <div class="quick-box-content-click">
                        <label class="switch">
                            <input type="checkbox" value="variable-excerpt-in-box" <?php if( !empty($varimoVariableDetailsExcerpt) ): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('Excerpt ','variation-monster');?></span> <span class="quickPro">(Pro)</span>
                    </div>


                    <div class="quick-box-content-click">
                        <label class="switch">
                            <input type="checkbox" value="variable-sku-in-box" <?php if( !empty($varimoVariableDetailsSKU) ): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('SKU','variation-monster'); ?></span>
                    </div>

                    <!--
        <div class="quick-box-content-click">
            <label class="switch">
                <input type="checkbox" value="variable-price-in-box" <?php if( !empty($varimoVariableDetailsPrice) ): echo esc_attr("checked"); endif; ?>>
                <span class="slider round"></span>
            </label>
            <span><?php echo esc_html('Price  (Pro)','variation-monster'); ?></span> <span class="quickPro">(Pro)</span>
        </div>

        <div class="quick-box-content-click">
            <label class="switch">
                <input type="checkbox" value="variable-attribute-in-box" <?php if( !empty($varimoVariableDetailsAttribute) ): echo esc_attr("checked"); endif; ?>>
                <span class="slider round"></span>
            </label>
            <span><?php echo esc_html('Attribute  (Pro)','variation-monster'); ?></span> <span class="quickPro">(Pro)</span>
        </div>
         -->

                </div>
            </div>

            <div class="quick-selections">
                <?php
                global $wpdb;

                // phpcs:ignore
                $meta_keys = $wpdb->get_col("
                            SELECT DISTINCT pm.meta_key
                            FROM {$wpdb->postmeta} pm
                            JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                            WHERE p.post_type = 'product_variation'
                            ORDER BY pm.meta_key
                        ");

                $varimo_selected_keys            = [];
                $varimo_newMetaDataForVariations = [];

                ?>

                <div class="quick-selectors-wrapper m-top">
                    <p> <strong>Show Meta Data: <span class="dashicons dashicons-lock"></span></strong></p>
                    <div class="search-new-meta-data-add-by-selector-two">
                        <select id="meta-key-selector" multiple disabled class="wc-enhanced-select" style="width: 100%;">
                            <?php foreach ($meta_keys as $varimo_key): ?>
                                <option value="<?php echo esc_attr($varimo_key); ?>"
                                        <?php selected(in_array($varimo_key, $varimo_selected_keys)); ?>>
                                    <?php echo esc_html($varimo_key); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="meta-fields-container">
                        <?php
                        // Display existing meta data fields
                        foreach ($varimo_newMetaDataForVariations as $varimo_index => $varimo_meta):
                            if (empty($varimo_meta['key']) || empty($varimo_meta['value'])) continue;
                            ?>
                            <div class="new-meta-data-add-for-every-variation" data-key="<?php echo esc_attr($varimo_meta['key']); ?>">
                                <div class="meta-add-drag-handle" title="Drag to reorder">≡</div>
                                <div class="new-meta-data-label">
                                    <input type="text" class="new-meta-data-label"
                                           name="newMetaDataForVariations[<?php echo esc_attr($varimo_index); ?>][key]"
                                           value="<?php echo esc_attr($varimo_meta['key']); ?>" readonly>
                                </div>
                                <div class="new-meta-data-value">
                                    <input type="text" class="new-meta-data-value"
                                           name="newMetaDataForVariations[<?php echo esc_attr($varimo_index); ?>][value]"
                                           value="<?php echo esc_attr($varimo_meta['value']); ?>">
                                </div>
                                <div class="cross-icon-for-new-meta-data">×</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>



            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="tooltip-bg"><strong><?php echo esc_html('Popup Background Color:','variation-monster'); ?></strong></label>
                    <input id="tooltip-bg" name="tooltip-bg" value="<?php echo esc_attr($varimoTooltipBgColor); ?>" data-jscolor="{}">
                </div>
            </div>
            <!-- Quantity Button -->
            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="tooltip-text"><strong><?php echo wp_kses('Popup Text Color: ','variation-monster');?></strong></label>
                    <input id="tooltip-text" name="tooltip-text" value="<?php echo esc_attr($varimoTooltipTextColor); ?>" data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper">
                    <label for="add-to-cart-success-message"><strong> <?php echo wp_kses('Add to Cart Success Message: ','variation-monster');?></strong></label>
                    <input id="add-to-cart-success-message" class="add-to-cart-success-message" type="text" name="add-to-cart-success-message" value="<?php echo esc_attr( $varimoAddToCartSuccessMessage ); ?>"  >
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="add-to-cart-success-color"><strong><?php echo wp_kses('Add to Cart Success Text Color: ','variation-monster');?></strong></label>
                    <input id="add-to-cart-success-color" name="add-to-cart-success-color" value="<?php echo esc_attr($varimoAddToCartSuccessColor); ?>" data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="add-to-cart-error-color"><strong><?php echo wp_kses('Add to Cart Failed Text Color: ','variation-monster');?></strong></label>
                    <input id="add-to-cart-error-color" name="add-to-cart-error-color" value="<?php echo esc_attr($varimoAddToCartErrorColor); ?>" data-jscolor="{}">
                </div>
            </div>

        </div>
    </div>

    <div id="table" class="tabcontent" style="">

        <div id="quickAuthenticateWrapper">
            <h2><?php echo esc_html('Variation Table Setting','variation-monster'); ?></h2>

            <div style="display: flex; gap: 30%">
                <div>
                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Variation Table On: ','variation-monster');?></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="quick-table-on-off">
                                <label class="switch">
                                    <input type="checkbox" name="quick-table-on-off" <?php if( $varimoQuickTableOnOff == "true" ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Overwrite Default Add to Cart by Table: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="before-cart-quick-table-on-off">
                                <label class="switch">
                                    <input type="checkbox" name="before-cart-quick-table-on-off" disabled>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections quick-selections-style" style="display: flex; gap: 50%">
                        <div>
                            <h4><?php echo wp_kses('Overwrite Default Cart Table Template: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>

                            <div>
                                <select disabled id="overwrite-default-cart-table-template" class="overwrite-default-cart-table-template" style="outline: none">
                                    <option value="template_1" ><?php echo wp_kses('Template 1','variation-monster');?></option>
                                    <option value="template_2" ><?php echo wp_kses('Template 2','variation-monster');?></option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="quick-selections">
                        <?php
                        global $wpdb;

                        // phpcs:ignore
                        $meta_keys_table_overwrite = $wpdb->get_col("
                            SELECT DISTINCT pm.meta_key
                            FROM {$wpdb->postmeta} pm
                            JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                            WHERE p.post_type = 'product_variation'
                            ORDER BY pm.meta_key
                        ");

                        $varimo_selected_keys_table_overwrite          = [];
                        $varimo_newMetaDataForVariationsTableOverwrite = [];

                        ?>

                        <div class="quick-selectors-wrapper m-top">
                            <p> <strong>Show Meta Data for Overwrite Default Cart Table Template:<span class="dashicons dashicons-lock"></span></strong></p>
                            <div class="search-new-meta-data-add-by-selector-two-table-overwrite">
                                <select disabled id="meta-key-selector-table-overwrite" multiple class="wc-enhanced-select" style="width: 100%;">
                                    <?php foreach ($meta_keys_table_overwrite as $varimo_key): ?>
                                        <option value="<?php echo esc_attr($varimo_key); ?>"
                                                <?php selected(in_array($varimo_key, $varimo_selected_keys_table_overwrite)); ?>>
                                            <?php echo esc_html($varimo_key); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div id="meta-fields-container-table-overwrite">
                                <?php
                                // Display existing meta data fields
                                foreach ($varimo_newMetaDataForVariationsTableOverwrite as $varimo_index => $varimo_meta):
                                    if (empty($varimo_meta['key']) || empty($varimo_meta['value'])) continue;
                                    ?>
                                    <div class="new-meta-data-add-for-every-variation-table-overwrite" data-key="<?php echo esc_attr($varimo_meta['key']); ?>">
                                        <div class="meta-add-drag-handle-table-overwrite" title="Drag to reorder">≡</div>
                                        <div class="new-meta-data-label-table-overwrite">
                                            <input type="text" class="new-meta-data-label-table-overwrite"
                                                   name="newMetaDataForVariationsTableOverwrite[<?php echo esc_attr($varimo_index); ?>][key]"
                                                   value="<?php echo esc_attr($varimo_meta['key']); ?>" readonly>
                                        </div>
                                        <div class="new-meta-data-value-table-overwrite">
                                            <input type="text" class="new-meta-data-value-table-overwrite"
                                                   name="newMetaDataForVariationsTableOverwrite[<?php echo esc_attr($varimo_index); ?>][value]"
                                                   value="<?php echo esc_attr($varimo_meta['value']); ?>">
                                        </div>
                                        <div class="cross-icon-for-new-meta-data-table-overwrite" >×</div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Variation Table Images -->
                    <div class="quick-selections quick-selections-style">
                        <h4><?php echo wp_kses('Table Image Size: ','variation-monster');?></h4>

                        <div style="display: flex; gap: 80px;">
                            <select id="pop-up-image-show" class="pop-up-image-show">


                                <?php
                                $varimo_table_popup_image_size_hook = [
                                        'thumbnail',
                                        'medium',
                                        'medium_large',
                                        'large',
                                        'woocommerce_thumbnail',
                                        'woocommerce_single',
                                        'woocommerce_gallery_thumbnail'
                                ];

                                $varimo_table_popup_image_size_final_hook = apply_filters('varimo_quick_cart_carousel_size_hook', $varimo_table_popup_image_size_hook);

                                foreach ($varimo_table_popup_image_size_final_hook as $varimo_table_popup_image_final_hook) {

                                    $varimo_formatted_table_popup_image_size_hook_name = ucwords(str_replace('_', ' ', $varimo_table_popup_image_final_hook));

                                    ?>
                                    <option value="<?php echo esc_attr($varimo_table_popup_image_final_hook); ?>" <?php selected($varimoPopUPImageShow, $varimo_table_popup_image_final_hook); ?>>
                                        <?php echo esc_html($varimo_formatted_table_popup_image_size_hook_name); ?>
                                    </option>
                                    <?php
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="quick-selections quick-selections-style" style="display: flex; gap: 50%">
                        <div>
                            <h4><?php echo wp_kses('Variation Table Template: ','variation-monster');?> <span class="dashicons dashicons-lock"></span></h4>

                            <div>
                                <select id="select-design-variation-table-template" class="variation-table-template" style="outline: none" disabled>
                                    <option value="template_1" <?php selected($varimoVariationTableTemplate, 'template_1'); ?>><?php echo wp_kses('Template 1','variation-monster');?></option>
                                    <option value="template_2" <?php selected($varimoVariationTableTemplate, 'template_2'); ?>><?php echo wp_kses('Template 2','variation-monster');?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!--Variation Table Template 2 All Option-->
                    <div id="variation-table-template2-options" style="display: none;">
                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper">
                                <label for="template2-table-bg-color"><strong> <?php echo wp_kses('Template 2 Table Bg Color: ','variation-monster');?></strong></label>
                                <input id="template2-table-bg-color" name="template2-table-bg-color" value="<?php echo esc_attr( $varimoTemplate2TableBgColor ); ?>"  data-jscolor="{}">
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper">
                                <label for="template2-details-section-bg-color"><strong> <?php echo wp_kses('Template 2 Details Section Bg Color: ','variation-monster');?></strong></label>
                                <input id="template2-details-section-bg-color" name="template2-details-section-bg-color" value="<?php echo esc_attr( $varimoTemplate2DetailsSectionBgColor ); ?>"  data-jscolor="{}">
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper">
                                <label for="template2-cart-section-bg-color"><strong> <?php echo wp_kses('Template 2 Cart Section Bg Color: ','variation-monster');?></strong></label>
                                <input id="template2-cart-section-bg-color" name="template2-cart-section-bg-color" value="<?php echo esc_attr( $varimoTemplate2CartSectionBgColor ); ?>"  data-jscolor="{}">
                            </div>
                        </div>

                        <div class="quick-selections quick-selections-style" style="display: flex; gap: 50%">
                            <div>
                                <h4><?php echo wp_kses('Style Add to Cart for Template 2: ','variation-monster');?></h4>
                                <div>
                                    <select id="select-design-add-cart-table-template2" class="design-add-cart-table-template2" style="outline: none">
                                        <option value="template_1" <?php selected($varimoDesignAddCartTableTemplate2, 'template_1'); ?>><?php echo wp_kses('Template 1','variation-monster');?></option>
                                        <option value="template_2" <?php selected($varimoDesignAddCartTableTemplate2, 'template_2'); ?>><?php echo wp_kses('Template 2','variation-monster');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper m-top">
                                <label for="select-all-name-change"><strong> <?php echo wp_kses('Custom Bulk Selection Text: ','variation-monster');?></strong></label>
                                <input id="select-all-name-change" class="select-all-name-change" type="text" name="select-all-name-change" value="<?php echo esc_attr( $varimoSelectAllNameChange ); ?>"  >
                            </div>
                        </div>
                    </div>
                    <!--Variation Table Template 1 All options-->
                    <div id="variation-table-template1-options" >
                        <div class="quick-selections" style="display: flex; align-items: center">
                            <h4><?php echo wp_kses('Variation Table Border Show: ','variation-monster');

                                ?></h4>
                            <div class="quick-selectors-wrapper">
                                <div class="quick-table-border">
                                    <label class="switch">
                                        <input type="checkbox" name="quick-table-border" <?php if( $varimoQuickTableBorder == "true" ): echo esc_attr("checked"); endif; ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper">
                                <label for="quick-table-head-bg-color"><strong> <?php echo wp_kses('Table Head Background Color: ','variation-monster');?></strong></label>
                                <input id="quick-table-head-bg-color" name="quick-table-head-bg-color" value="<?php echo esc_attr( $varimoTableHeadBgColor ); ?>"  data-jscolor="{}">
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper m-top" >
                                <label for="quick-table-head-text-color"><strong> <?php echo wp_kses('Table Head Text Color: ','variation-monster');?></strong></label>
                                <input id="quick-table-head-text-color" name="quick-table-head-text-color" value="<?php echo esc_attr( $varimoTableHeadTextColor ); ?>"  data-jscolor="{}">
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper m-top">
                                <label for="quick-table-border-color"><strong> <?php echo wp_kses('Table Border Color: ','variation-monster');?></strong></label>
                                <input id="quick-table-border-color" name="quick-table-border-color" value="<?php echo esc_attr( $varimoTableBorderColor ); ?>"  data-jscolor="{}">
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper m-top">
                                <label for="quick-table-variable-title-color"><strong> <?php echo wp_kses('Variation Table Title Color: ','variation-monster');?></strong></label>
                                <input id="quick-table-variable-title-color" name="quick-table-variable-title-color" value="<?php echo esc_attr( $varimoTableVariableTitleColor ); ?>"  data-jscolor="{}">
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper m-top">
                                <label for="quick-table-variable-bg-color-odd"><strong> <?php echo wp_kses('Variation Table Background Color(Odd): ','variation-monster');?></strong></label>
                                <input id="quick-table-variable-bg-color-odd" name="quick-table-variable-bg-color-odd" value="<?php echo esc_attr( $varimoTableBgColorOdd ); ?>"  data-jscolor="{}">
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper m-top">
                                <label for="quick-table-variable-bg-color-even"><strong> <?php echo wp_kses('Variation Table Background Color(Even): ','variation-monster');?></strong></label>
                                <input id="quick-table-variable-bg-color-even" name="quick-table-variable-bg-color-even" value="<?php echo esc_attr( $varimoTableBgColorEven ); ?>"  data-jscolor="{}">
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper m-top">
                                <label for="quick-table-variable-hover-color"><strong> <?php echo wp_kses('Variation Table Background Color Hover: ','variation-monster');?></strong></label>
                                <input style="outline: none !important;" id="quick-table-variable-hover-color" name="quick-table-variable-hover-color" value="<?php echo esc_attr( $varimoTableBgColorHover ); ?>"  data-jscolor="{}">
                            </div>
                        </div>
                    </div>

                    <!-- Table Row Pagination -->
                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper m-top">
                            <label for="table-row-pagination"><strong> <?php echo wp_kses('Table Row Pagination: ','variation-monster');?><span class="dashicons dashicons-lock"></span> </strong></label>
                            <input id="table-row-pagination" class="table-row-pagination" type="number" min="5" name="table-row-pagination" value="<?php echo esc_attr( $varimoTableRowPagination ); ?>"  disabled>
                        </div>
                    </div>

                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper">
                            <label for="pagination-button-bg-color"><strong> <?php echo wp_kses('Pagination Button Background Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                            <input disabled id="pagination-button-bg-color" name="pagination-button-bg-color" value="<?php echo esc_attr( $varimoPaginationButtonBgColor ); ?>"  data-jscolor="{}">
                        </div>
                    </div>

                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper">
                            <label for="pagination-button-hover-bg-color"><strong> <?php echo wp_kses('Pagination Button Hover Background Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                            <input disabled id="pagination-button-hover-bg-color" name="pagination-button-hover-bg-color" value="<?php echo esc_attr( $varimoPaginationButtonHoverBgColor ); ?>"  data-jscolor="{}">
                        </div>
                    </div>

                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper">
                            <label for="pagination-button-text-color"><strong> <?php echo wp_kses('Pagination Button Text Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                            <input disabled id="pagination-button-text-color" name="pagination-button-text-color" value="<?php echo esc_attr( $varimoPaginationButtonTextColor ); ?>"  data-jscolor="{}">
                        </div>
                    </div>

                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper">
                            <label for="pagination-button-text-hover-color"><strong> <?php echo wp_kses('Pagination Button Text Hover Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                            <input disabled id="pagination-button-text-hover-color" name="pagination-button-text-hover-color" value="<?php echo esc_attr( $varimoPaginationButtonTextHoverColor ); ?>"  data-jscolor="{}">
                        </div>
                    </div>

                    <!-- Variation Table Position Select -->
                    <div class="quick-selections quick-selections-style">
                        <h4><?php echo wp_kses('Variation Table Position: ','variation-monster');?></h4>

                        <div style="display: flex; gap: 30px;">
                            <select id="table-position" class="quick-table-position">

                                <?php
                                $varimo_variation_table_position = [
                                        'woocommerce_before_single_product_summary',
                                        'woocommerce_after_single_product_summary',
                                        'woocommerce_after_single_product',
                                ];

                                $varimo_variation_table_position_hook_final = apply_filters('varimo_table_position', $varimo_variation_table_position);

                                foreach ($varimo_variation_table_position_hook_final as $varimo_table_position_hook_final) {

                                    $varimo_formatted_table_hook_name = ucwords(str_replace('_', ' ', str_replace('woocommerce_', '', $varimo_table_position_hook_final)));

                                    ?>
                                    <option value="<?php echo esc_attr($varimo_table_position_hook_final); ?>" <?php selected($varimoQuickTablePosition, $varimo_table_position_hook_final); ?>>
                                        <?php echo esc_html($varimo_formatted_table_hook_name); ?>
                                    </option>
                                    <?php
                                }
                                ?>

                            </select>

                            <!-- Help Start -->
                            <a href="http://webcartisan.com/woocommerce-single-product-page-all-hook/"
                               class="help-button variation-cart-carousel-setting-help"
                               target="_blank"
                               rel="noopener noreferrer"
                               style="text-decoration: none; color: white;"
                               onmouseover="this.style.color='wheat';"
                               onmouseout="this.style.color='white';">
                                ?
                            </a>

                        </div>
                    </div>

                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper">
                            <label for="bulk-add-cart-bg-color"><strong> <?php echo wp_kses('Bulk Add to Cart Background Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                            <input disabled id="bulk-add-cart-bg-color" name="bulk-add-cart-bg-color" value="<?php echo esc_attr( $varimoBulkAddCartBgColor ); ?>"  data-jscolor="{}">
                        </div>
                    </div>

                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper">
                            <label for="bulk-add-cart-text-color"><strong> <?php echo wp_kses('Bulk Add to Cart Text Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                            <input disabled id="bulk-add-cart-text-color" name="bulk-add-cart-text-color" value="<?php echo esc_attr( $varimoBulkAddCartTextColor ); ?>"  data-jscolor="{}">
                        </div>
                    </div>

                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper">
                            <label for="bulk-add-cart-hover-bg-color"><strong> <?php echo wp_kses('Bulk Add to Cart Hover Background Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                            <input disabled id="bulk-add-cart-hover-bg-color" name="bulk-add-cart-hover-bg-color" value="<?php echo esc_attr( $varimoBulkAddCartHoverBgColor ); ?>"  data-jscolor="{}">
                        </div>
                    </div>

                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper">
                            <label for="bulk-add-cart-hover-text-color"><strong> <?php echo wp_kses('Bulk Add to Cart Hover Text Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                            <input disabled id="bulk-add-cart-hover-text-color" name="bulk-add-cart-hover-text-color" value="<?php echo esc_attr( $varimoBulkAddCartHoverTextColor ); ?>"  data-jscolor="{}">
                        </div>
                    </div>


                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper m-top">
                            <label for="on-sale-name-change"><strong> <?php echo wp_kses('On Sale Name Change: ','variation-monster');?></strong></label>
                            <input id="on-sale-name-change" class="on-sale-name-change" type="text" name="on-sale-name-change" value="<?php echo esc_attr( $varimoOnSaleNameChange ); ?>"  >
                        </div>
                    </div>

                    <div class="quick-selections">
                        <div class="quick-selectors-wrapper m-top">
                            <label for="search-option-text-change"><strong> <?php echo wp_kses('Search Option Text Change: ','variation-monster');?></strong></label>
                            <input id="search-option-text-change" class="search-option-text-change" type="text" name="search-option-text-change" value="<?php echo esc_attr( $varimoSearchOptionTextChange ); ?>"  >
                        </div>
                    </div>

                    <div class="quick-selections">
                        <?php
                        global $wpdb;

                        // phpcs:ignore
                        $meta_keys = $wpdb->get_col("
                            SELECT DISTINCT pm.meta_key
                            FROM {$wpdb->postmeta} pm
                            JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                            WHERE p.post_type = 'product_variation'
                            ORDER BY pm.meta_key
                        ");

                        $varimo_selected_keys            = [];
                        $varimo_newMetaDataForVariations = [];

                        ?>

                        <div class="quick-selectors-wrapper m-top">
                            <p> <strong>Show Meta Data for Table: <span class="dashicons dashicons-lock"></span></strong></p>
                            <div class="search-new-meta-data-add-by-selector-two">
                                <select id="meta-key-selector" multiple disabled class="wc-enhanced-select" style="width: 100%;">
                                    <?php foreach ($meta_keys as $varimo_key): ?>
                                        <option value="<?php echo esc_attr($varimo_key); ?>"
                                                <?php selected(in_array($varimo_key, $varimo_selected_keys)); ?>>
                                            <?php echo esc_html($varimo_key); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div id="meta-fields-container">
                                <?php
                                // Display existing meta data fields
                                foreach ($varimo_newMetaDataForVariations as $varimo_index => $varimo_meta):
                                    if (empty($varimo_meta['key']) || empty($varimo_meta['value'])) continue;
                                    ?>
                                    <div class="new-meta-data-add-for-every-variation" data-key="<?php echo esc_attr($varimo_meta['key']); ?>">
                                        <div class="meta-add-drag-handle" title="Drag to reorder">≡</div>
                                        <div class="new-meta-data-label">
                                            <input type="text" class="new-meta-data-label"
                                                   name="newMetaDataForVariations[<?php echo esc_attr($varimo_index); ?>][key]"
                                                   value="<?php echo esc_attr($varimo_meta['key']); ?>" readonly>
                                        </div>
                                        <div class="new-meta-data-value">
                                            <input type="text" class="new-meta-data-value"
                                                   name="newMetaDataForVariations[<?php echo esc_attr($varimo_index); ?>][value]"
                                                   value="<?php echo esc_attr($varimo_meta['value']); ?>">
                                        </div>
                                        <div class="cross-icon-for-new-meta-data">×</div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Popup Image: ','variation-monster');?></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="show-popup-image">
                                <label class="switch">
                                    <input type="checkbox" name="show-popup-image" <?php if( $varimoShowPopUpImage == "true" ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Gallery Image into Popup: ','variation-monster');?> <span class="dashicons dashicons-lock"></span></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="">
                                <label class="switch">
                                    <input type="checkbox" name="" disabled>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Bulk Selection: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="bulk-selection-hide-show">
                                <label class="switch">
                                    <input type="checkbox" name="bulk-selection-hide-show"  disabled>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Image: ','variation-monster');?></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="image-hide-show">
                                <label class="switch">
                                    <input type="checkbox" name="image-hide-show" <?php if( $varimoImageHideShow == "true" || empty($varimoImageHideShow)): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show SKU: ','variation-monster');?></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="sku-hide-show">
                                <label class="switch">
                                    <input type="checkbox" name="sku-hide-show" <?php if( $varimoSkuHideShow == "true" || empty($varimoSkuHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Title: ','variation-monster');?> <span class="dashicons dashicons-lock"></span></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="title-hide-show">
                                <label class="switch">
                                    <input disabled type="checkbox" name="title-hide-show" <?php if( $varimoTitleHideShow == "true" || empty($varimoTitleHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Description: ','variation-monster');?> <span class="dashicons dashicons-lock"></span></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="description-hide-show">
                                <label class="switch">
                                    <input disabled type="checkbox" name="description-hide-show" <?php if( $varimoDescriptionHideShow == "true" || empty($varimoDescriptionHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Weight & Dimensions: ','variation-monster');?> <span class="dashicons dashicons-lock"></span></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="weight-dimension-hide-show">
                                <label class="switch">
                                    <input disabled type="checkbox" name="weight-dimension-hide-show" <?php if( $varimoWeightDimensionsHideShow == "true" || empty($varimoWeightDimensionsHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Attribute: ','variation-monster');?></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="all-attribute-hide-show">
                                <label class="switch">
                                    <input type="checkbox" name="all-attribute-hide-show" <?php if( $varimoAllAttributeHideShow == "true" || empty($varimoAllAttributeHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Price: ','variation-monster');?></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="price-hide-show">
                                <label class="switch">
                                    <input type="checkbox" name="price-hide-show" <?php if( $varimoPriceHideShow == "true" || empty($varimoPriceHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Quantity: ','variation-monster');?></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="quantity-hide-show">
                                <label class="switch">
                                    <input type="checkbox" name="quantity-hide-show" <?php if( $varimoQuantityHideShow == "true" || empty($varimoQuantityHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Stock Status: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="stock-status-hide-show">
                                <label class="switch">
                                    <input disabled type="checkbox" name="stock-status-hide-show" <?php if( $varimoStockStatusHideShow == "true" || empty($varimoStockStatusHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Action: ','variation-monster');?></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="action-hide-show">
                                <label class="switch">
                                    <input type="checkbox" name="action-hide-show" <?php if( $varimoActionHideShow == "true" || empty($varimoActionHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show Search Option: ','variation-monster');?></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="search-option-hide-show">
                                <label class="switch">
                                    <input type="checkbox" name="search-option-hide-show" <?php if( $varimoSearchOptionHideShow == "true" || empty($varimoSearchOptionHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections" style="display: flex; align-items: center">
                        <h4><?php echo wp_kses('Show On Sale Option: ','variation-monster');?></h4>
                        <div class="quick-selectors-wrapper">
                            <div class="on-sale-hide-show">
                                <label class="switch">
                                    <input type="checkbox" name="on-sale-hide-show" <?php if( $varimoOnSaleHideShow == "true" || empty($varimoOnSaleHideShow) ): echo esc_attr("checked"); endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quick-selections quick-selections-style">
                        <h4><?php echo wp_kses('Bulk Add to Cart Position: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>

                        <div >
                            <select id="table-position" class="bulk-add-to-cart-position" disabled>
                                <option value="before" <?php selected($varimoBulkAddToCartPosition, 'before'); ?>>Before Table</option>
                                <option value="after" <?php selected($varimoBulkAddToCartPosition, 'after'); ?>>After Table</option>
                                <option value="both" <?php selected($varimoBulkAddToCartPosition, 'both'); ?>>Both</option>
                            </select>

                        </div>
                    </div>

                    <div class="quick-selections quick-selections-style" style="display: flex; gap: 50%">

                        <div>
                            <h4><?php echo wp_kses('Design for Mobile Single Product Page: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                            <div >
                                <select id="select-design" class="design-single-product-page-mobile" style="outline: none" disabled>
                                    <option value="template_1" <?php selected($varimoDesignSingleProductPageMobile, 'template_1'); ?>><?php echo wp_kses('Template 1','variation-monster');?></option>
                                    <option value="template_2" <?php selected($varimoDesignSingleProductPageMobile, 'template_2'); ?>><?php echo wp_kses('Template 2','variation-monster');?></option>
                                    <option value="template_3" <?php selected($varimoDesignSingleProductPageMobile, 'template_3'); ?>><?php echo wp_kses('Template 3','variation-monster');?></option>
                                    <option value="template_4" <?php selected($varimoDesignSingleProductPageMobile, 'template_4'); ?>><?php echo wp_kses('Template 4','variation-monster');?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div>

                    <div style="display: flex; align-items: end">
                        <div id="show-design-variation-table-template"></div>
                    </div>

                    <div id="variation-table-template2-cart-design" style="display: none;">
                        <div style="display: flex; align-items: end; margin-top: 20px">
                            <div id="show-design-add-cart-table-template2"></div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: end; position: absolute; bottom: 150px; left: 700px">
                        <div id="show-template-image"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="select-variation" class="tabcontent" style="">

        <div id="quickAuthenticateWrapper">
            <h2><?php echo esc_html('Variation Swatches for Single Product and Archive Page','variation-monster'); ?></h2>

            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Variation Swatches Enable: ','variation-monster');?></h4>
                <div class="quick-selectors-wrapper">
                    <div class="variation-select-on-off">
                        <label class="switch">
                            <input type="checkbox" name="variation-select-on-off" <?php if( $varimoVariationSelectOnOff == "true" ): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Show Selected Attribute: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="show-selected-attribute">
                        <label class="switch">
                            <input type="checkbox" name="show-selected-attribute" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Variation Label Separator: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <label for="variation-label-separator">
                        <input id="variation-label-separator" class="variation-label-separator" type="text" name="variation-label-separator" disabled  style="max-width:50px;">
                    </label>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Generate Variation URl: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="generate-variation-url">
                        <label class="switch">
                            <input type="checkbox" name="generate-variation-url" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Variation Stock Info: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="variation-stock-info">
                        <label class="switch">
                            <input type="checkbox" name="variation-stock-info" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>


            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Attribute Display Limit Enable: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="attribute-display-limit-enable">
                        <label class="switch">
                            <input type="checkbox" name="attribute-display-limit-enable" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Attribute Display Limit: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <label for="attribute-display-limit">
                        <input id="attribute-display-limit" class="attribute-display-limit" type="number" name="attribute-display-limit" disabled  style="max-width:50px;">
                    </label>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Show on Filter Widget: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="show-on-filter-widget">
                        <label class="switch">
                            <input type="checkbox" name="show-on-filter-widget" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Filter Attribute Display Limit: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <label for="filter-attribute-display-limit">
                        <input id="filter-attribute-display-limit" class="filter-attribute-display-limit" type="number" name="filter-attribute-display-limit" disabled  style="max-width:50px;">
                    </label>
                </div>
            </div>

            <div class="quick-selections quick-selections-style">
                <h4><?php echo wp_kses('Attribute Image Size: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>

                <div style="display: flex; gap: 80px;">
                    <select id="attribute-image-show" class="attribute-image-show" disabled>

                        <?php
                        $varimo_attribute_image_size_hook = [
                                'thumbnail',
                                'medium',
                                'medium_large',
                                'large',
                                'woocommerce_thumbnail',
                                'woocommerce_single',
                                'woocommerce_gallery_thumbnail'
                        ];

                        $varimo_attribute_image_size_final_hook = apply_filters('varimo_attribute_image_size_hook', $varimo_attribute_image_size_hook);

                        foreach ($varimo_attribute_image_size_final_hook as $varimo_attribute_image_final_hook) {

                            $varimo_formatted_attribute_image_size_hook_name = ucwords(str_replace('_', ' ', $varimo_attribute_image_final_hook));

                            ?>
                            <option value="<?php echo esc_attr($varimo_attribute_image_final_hook); ?>">
                                <?php echo esc_html($varimo_formatted_attribute_image_size_hook_name); ?>
                            </option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
            </div>

            <!-- Variation Swatches Archive Page Position Select -->
            <div class="quick-selections quick-selections-style" >
                <h4 ><?php echo wp_kses('Display Position on Archive Page: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>
                <div style="display: flex; gap: 10%;">
                    <select class="display-position-swatches-archive-page" disabled>

                        <?php
                        $varimo_display_position_archive_page_swatches_hook = [
                                'woocommerce_shop_loop_item_title',
                                'woocommerce_after_shop_loop_item',
                        ];

                        $varimo_archive_page_swatches_hook_finals = apply_filters('varimo_swatches_display_position', $varimo_display_position_archive_page_swatches_hook);

                        foreach ($varimo_archive_page_swatches_hook_finals as $varimo_archive_page_swatches_hook_final) {

                            $varimo_archive_page_swatches_formatted_hook_name = ucwords(str_replace('_', ' ', str_replace('woocommerce_', '', $varimo_archive_page_swatches_hook_final)));

                            ?>
                            <option value="<?php echo esc_attr($varimo_archive_page_swatches_hook_final); ?>">
                                <?php echo esc_html($varimo_archive_page_swatches_formatted_hook_name); ?>
                            </option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
            </div>

            <div class="quick-selections quick-selections-style" >
                <div style="display:flex">
                    <h4><?php echo wp_kses('Swatches Align in Archive: ','variation-monster-pro');?> <span class="dashicons dashicons-lock"></span></h4>
                    <div>
                        <select id="varimo-swatches-align-archive" class="varimo-swatches-align-archive" style="outline: none" disabled>
                            <option value="left" ><?php echo wp_kses('Left','variation-monster-pro');?></option>
                            <option value="center" ><?php echo wp_kses('Center','variation-monster-pro');?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="quick-selections quick-selections-style">
                <h4><?php echo esc_html('Archive Page:','variation-monster'); ?></h4>
                <div class="quick-selectors-wrapper">
                    <div class="show-attribute-swatches-archive">
                        <label class="switch">
                            <input type="checkbox" value="attribute-archive" <?php if($varimoShowAttributeSwatchesArchive == "attribute-archive"): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php esc_html_e('Show Attribute into Archive (Redirect)','variation-monster');?></span>
                    </div>
                    <div class="">
                        <label class="switch">
                            <input type="checkbox"  disabled>
                            <span class="slider round"></span>
                        </label>
                        <span><?php  esc_html_e('Show Swatches Quick Cart into Archive','variation-monster');?> <span class="dashicons dashicons-lock"></span></span>
                    </div>
                    <div class="show-attribute-swatches-archive">
                        <label class="switch">
                            <input type="checkbox" value="none" <?php if($varimoShowAttributeSwatchesArchive== "none"): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                        <span><?php esc_html_e('None','variation-monster');?></span>
                    </div>
                </div>
            </div>


            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Display Flex Label And Value: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="display-flex-label-value">
                        <label class="switch">
                            <input type="checkbox" name="display-flex-label-value" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections quick-selections-style">
                <h4><?php echo esc_html('Disabled Button Settings:','variation-monster'); ?><span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="variation-swatches-disable-settings">
                        <label class="switch">
                            <input type="checkbox" value="not-disable" disabled>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('Default','variation-monster');?></span>
                    </div>
                    <div class="variation-swatches-disable-settings">
                        <label class="switch">
                            <input type="checkbox" value="clickable-disable" disabled>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('Out of Stock Clickable','variation-monster');?></span>
                    </div>
                    <div class="variation-swatches-disable-settings">
                        <label class="switch">
                            <input type="checkbox" value="disable-not-clickable" disabled>
                            <span class="slider round"></span>
                        </label>
                        <span><?php echo esc_html('Disable out of Stock','variation-monster');?></span>
                    </div>
                </div>
            </div>

            <div class="quick-selections quick-selections-style" style="display: flex; gap: 50%">
                <div>
                    <h4><?php echo wp_kses('Disable Attribute Style: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                    <div>
                        <select id="select-design-list" class="disable-attribute-style" disabled style="outline: none">
                            <option value="blur_with_cross" ><?php echo wp_kses('Blur with Cross','variation-monster');?></option>
                            <option value="blur" ><?php echo wp_kses('Blur','variation-monster');?></option>
                            <option value="hide" ><?php echo wp_kses('Hide','variation-monster');?></option>
                            <option value="single_line_cross" ><?php echo wp_kses('Blur with Single Line Cross','variation-monster');?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="quick-selections" style="display: flex;  align-items: center">
                <h4><?php echo wp_kses('Selected Icon Show: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="selected-icon-show">
                        <label class="switch">
                            <input type="checkbox" name="selected-icon-show" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections quick-selections-style" style="display: flex; gap: 50%">
                <div>
                    <h4><?php echo wp_kses('Selected Icon Template: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                    <div>
                        <select id="selected-icon-template" class="selected-icon-template" disabled style="outline: none">
                            <option value="template_one" ><?php echo wp_kses('Check Mark Show in Center','variation-monster');?></option>
                            <option value="template_two" ><?php echo wp_kses('Check Mark Show in Top Right Side','variation-monster');?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper">
                    <label for="selected-icon-color"><strong> <?php echo wp_kses('Selected Icon Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                    <input disabled id="selected-icon-color" name="selected-icon-color" value=""  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper">
                    <label for="disabled-icon-color"><strong> <?php echo wp_kses('Disabled Icon Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                    <input disabled id="disabled-icon-color" name="disabled-icon-color" value=""  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="selected-disabled-icon-width"><strong> <?php echo wp_kses('Selected Disabled Icon Width (px): ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                    <input disabled id="selected-disabled-icon-width" class="selected-disabled-icon-width" type="number" name="selected-disabled-icon-width" value=""  >
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center;">
                <h4><?php echo wp_kses('Overwrite default woocommerce selection to select2:', 'variation-monster'); ?><span class="dashicons dashicons-lock"></span></h4>
                <div class="quick-selectors-wrapper">
                    <div class="default-selection-to-select2">
                        <label class="switch">
                            <input type="checkbox" value="default-selection-to-select2" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections" style="display: flex; align-items: center">
                <h4><?php echo wp_kses('Tooltip On: ','variation-monster');?></h4>
                <div class="quick-selectors-wrapper">
                    <div class="globally-tooltip-on-off">
                        <label class="switch">
                            <input type="checkbox" name="globally-tooltip-on-off" <?php if( $varimoGloballyTooltipOnOff == "true" ): echo esc_attr("checked"); endif; ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper">
                    <label for="select-variation-tooltip-bg-color"><strong> <?php echo wp_kses('Tooltip Background Color: ','variation-monster');?></strong></label>
                    <input id="select-variation-tooltip-bg-color" name="select-variation-tooltip-bg-color" value="<?php echo esc_attr( $varimoSelectVariationTooltipBgColor ); ?>"  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper">
                    <label for="select-variation-tooltip-text-color"><strong> <?php echo wp_kses('Tooltip Text Color: ','variation-monster');?></strong></label>
                    <input id="select-variation-tooltip-text-color" name="select-variation-tooltip-text-color" value="<?php echo esc_attr( $varimoSelectVariationTooltipTextColor ); ?>"  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper">
                    <label for="select-variation-button-bg-color"><strong> <?php echo wp_kses('Button Background Color: ','variation-monster');?></strong></label>
                    <input id="select-variation-button-bg-color" name="select-variation-button-bg-color" value="<?php echo esc_attr( $varimoSelectVariationButtonBgColor ); ?>"  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper">
                    <label for="select-variation-button-text-color"><strong> <?php echo wp_kses('Button Text Color: ','variation-monster');?></strong></label>
                    <input id="select-variation-button-text-color" name="select-variation-button-text-color" value="<?php echo esc_attr( $varimoSelectVariationButtonTextColor ); ?>"  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="image-color-height"><strong> <?php echo wp_kses('Image & Color Height (px): ','variation-monster');?></strong></label>
                    <input id="image-color-height" class="image-color-height" type="text" name="image-color-height" value="<?php echo esc_attr( $varimoImageColorHeight ); ?>"  >
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="image-color-width"><strong> <?php echo wp_kses('Image & Color Width (px): ','variation-monster');?></strong></label>
                    <input id="image-color-width" class="image-color-width" type="text" name="image-color-width" value="<?php echo esc_attr( $varimoImageColorWidth ); ?>"  >
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="image-color-border-radius"><strong> <?php echo wp_kses('Image & Color Border Radius (px): ','variation-monster');?></strong></label>
                    <input id="image-color-border-radius" class="image-color-border-radius" type="text" name="image-color-border-radius" value="<?php echo esc_attr( $varimoImageColorBorderRadius ); ?>"  >
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper">
                    <label for="swatches-button-border-color"><strong> <?php echo wp_kses('Button Border Color: ','variation-monster');?></strong></label>
                    <input id="swatches-button-border-color" name="swatches-button-border-color" value="<?php echo esc_attr( $varimoSwatchesButtonBorderColor ); ?>"  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper">
                    <label for="selected-variation-button-border-color"><strong> <?php echo wp_kses(' Selected Button Border Color: ','variation-monster');?></strong></label>
                    <input id="selected-variation-button-border-color" name="selected-variation-button-border-color" value="<?php echo esc_attr( $varimoSelectedVariationButtonBorderColor ); ?>"  data-jscolor="{}">
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="button-height"><strong> <?php echo wp_kses('Button Height (px): ','variation-monster');?></strong></label>
                    <input id="button-height" class="button-height" type="text" name="button-height" value="<?php echo esc_attr( $varimoButtonHeight ); ?>"  >
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="button-width"><strong> <?php echo wp_kses('Button Width (px): ','variation-monster');?></strong></label>
                    <input id="button-width" class="button-width" type="text" name="button-width" value="<?php echo esc_attr( $varimoButtonWidth ); ?>"  >
                </div>
            </div>

            <div class="quick-selections">
                <div class="quick-selectors-wrapper m-top">
                    <label for="button-border-radius"><strong> <?php echo wp_kses('Button Border Radius (px): ','variation-monster');?></strong></label>
                    <input id="button-border-radius" class="button-border-radius" type="text" name="button-border-radius" value="<?php echo esc_attr( $varimoButtonBorderRadius ); ?>"  >
                </div>
            </div>

        </div>
    </div>

    <div id="select-variation-ul-li" class="tabcontent">
        <h2><?php echo esc_html('Select Variation List','variation-monster'); ?></h2>
        <div style="display: flex; gap: 30%">
            <div>
                <div id="quickAuthenticateWrapper">
                    <div>
                        <div class="quick-selections" style="display: flex; align-items: center">
                            <h4><?php echo wp_kses('Variation List Enable: ','variation-monster');?></h4>
                            <div class="quick-selectors-wrapper">
                                <div class="select-variation-template-on-off">
                                    <label class="switch">
                                        <input type="checkbox" name="select-variation-template-on-off" <?php if( $varimoSelectVariationTemplateOnOff == "true" ): echo esc_attr("checked"); endif; ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- List Image Size -->
                        <div class="quick-selections quick-selections-style">
                            <h4><?php echo wp_kses('List Image Size: ','variation-monster');?></h4>

                            <div style="display: flex; gap: 80px;">
                                <select id="list-image-show" class="list-image-show">


                                    <?php
                                    $varimo_list_image_size_hook = [
                                            'thumbnail',
                                            'medium',
                                            'medium_large',
                                            'large',
                                            'woocommerce_thumbnail',
                                            'woocommerce_single',
                                            'woocommerce_gallery_thumbnail'
                                    ];

                                    $varimo_list_image_size_final_hook = apply_filters('varimo_quick_cart_list_size_hook', $varimo_list_image_size_hook);

                                    foreach ($varimo_list_image_size_final_hook as $varimo_list_image_final_hook) {

                                        $varimo_formatted_list_image_size_hook_name = ucwords(str_replace('_', ' ', $varimo_list_image_final_hook));

                                        ?>
                                        <option value="<?php echo esc_attr($varimo_list_image_final_hook); ?>" <?php selected($varimoListImageShow, $varimo_list_image_final_hook); ?>>
                                            <?php echo esc_html($varimo_formatted_list_image_size_hook_name); ?>
                                        </option>
                                        <?php
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>



                        <h3 style="color: red; margin-top: 20px;"><?php echo wp_kses('Variation list is enable, variation swatches ','variation-monster'); ?>
                            <br><?php echo wp_kses('will not work in single product page ','variation-monster'); ?></br>
                        </h3>

                        <div class="quick-selections quick-selections-style" style="display: flex; gap: 50%">
                            <div>
                                <h4><?php echo wp_kses('Variation List Template: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                                <div >
                                    <select id="select-design-list-template" class="variation-list-template" style="outline: none" disabled>
                                        <option value="template_1" <?php selected($varimoVariationListTemplate, 'template_1'); ?>><?php echo wp_kses('Template 1','variation-monster');?></option>
                                        <option value="template_2" <?php selected($varimoVariationListTemplate, 'template_2'); ?>><?php echo wp_kses('Template 2','variation-monster');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper m-top">
                                <label for="list-pagination"><strong> <?php echo wp_kses('Items Per Pages: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                                <input id="list-pagination" class="list-pagination" type="number" min="1" name="list-pagination" value="<?php echo esc_attr( $varimoListPagination ); ?>"  disabled>
                            </div>
                        </div>

                        <div class="quick-selections">
                            <?php
                            global $wpdb;

                            // phpcs:ignore
                            $meta_keys = $wpdb->get_col("
                            SELECT DISTINCT pm.meta_key
                            FROM {$wpdb->postmeta} pm
                            JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                            WHERE p.post_type = 'product_variation'
                            ORDER BY pm.meta_key
                        ");

                            $varimo_selected_keys            = [];
                            $varimo_newMetaDataForVariations = [];

                            ?>

                            <div class="quick-selectors-wrapper m-top">
                                <p> <strong>Show Meta Data: <span class="dashicons dashicons-lock"></span></strong></p>
                                <div class="search-new-meta-data-add-by-selector-two">
                                    <select id="meta-key-selector" multiple disabled class="wc-enhanced-select" style="width: 100%;">
                                        <?php foreach ($meta_keys as $varimo_key): ?>
                                            <option value="<?php echo esc_attr($varimo_key); ?>"
                                                    <?php selected(in_array($varimo_key, $varimo_selected_keys)); ?>>
                                                <?php echo esc_html($varimo_key); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div id="meta-fields-container">
                                    <?php
                                    // Display existing meta data fields
                                    foreach ($varimo_newMetaDataForVariations as $varimo_index => $varimo_meta):
                                        if (empty($varimo_meta['key']) || empty($varimo_meta['value'])) continue;
                                        ?>
                                        <div class="new-meta-data-add-for-every-variation" data-key="<?php echo esc_attr($varimo_meta['key']); ?>">
                                            <div class="meta-add-drag-handle" title="Drag to reorder">≡</div>
                                            <div class="new-meta-data-label">
                                                <input type="text" class="new-meta-data-label"
                                                       name="newMetaDataForVariations[<?php echo esc_attr($varimo_index); ?>][key]"
                                                       value="<?php echo esc_attr($varimo_meta['key']); ?>" readonly>
                                            </div>
                                            <div class="new-meta-data-value">
                                                <input type="text" class="new-meta-data-value"
                                                       name="newMetaDataForVariations[<?php echo esc_attr($varimo_index); ?>][value]"
                                                       value="<?php echo esc_attr($varimo_meta['value']); ?>">
                                            </div>
                                            <div class="cross-icon-for-new-meta-data">×</div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="quick-selections">
                            <div class="quick-selectors-wrapper m-top">
                                <label for="list-pagination-per-line-mobile"><strong> <?php echo wp_kses('Items Per Line for Mobile Version: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                                <input id="list-pagination-per-line-mobile" class="list-pagination-per-line-mobile" type="number" min="1" name="list-pagination" value="<?php echo esc_attr( $varimoListPaginationPerLineMobile ); ?>"  disabled>
                            </div>
                        </div>

                        <div class="quick-selections" style="display: flex; align-items: center">
                            <h4><?php echo wp_kses('Show Label: ','variation-monster');?></h4>
                            <div class="quick-selectors-wrapper">
                                <div class="list-label-show-on-off">
                                    <label class="switch">
                                        <input type="checkbox" name="list-label-show-on-off" <?php if( $varimoListLabelOnOff == "true" ): echo esc_attr("checked"); endif; ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="quick-selections" style="display: flex; align-items: center">
                            <h4><?php echo wp_kses('Show SKU: ','variation-monster');?></h4>
                            <div class="quick-selectors-wrapper">
                                <div class="list-sku-show-on-off">
                                    <label class="switch">
                                        <input type="checkbox" name="list-sku-show-on-off" <?php if( $varimoListSkuOnOff == "true" ): echo esc_attr("checked"); endif; ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="quick-selections" style="display: flex; align-items: center">
                            <h4><?php echo wp_kses('Show Price: ','variation-monster');?></h4>
                            <div class="quick-selectors-wrapper">
                                <div class="list-price-show-on-off">
                                    <label class="switch">
                                        <input type="checkbox" name="list-price-show-on-off" <?php if( $varimoListPriceOnOff == "true" ): echo esc_attr("checked"); endif; ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="quick-selections" style="display: flex; align-items: center">
                            <h4><?php echo wp_kses('Show Quantity: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                            <div class="quick-selectors-wrapper">
                                <div class="list-quantity-show-on-off">
                                    <label class="switch">
                                        <input disabled type="checkbox" name="list-quantity-show-on-off" <?php if( $varimoListQuantityOnOff == "true" ): echo esc_attr("checked"); endif; ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="quick-selections" style="display: flex; align-items: center">
                            <h4><?php echo wp_kses('Show Attribute: ','variation-monster');?></h4>
                            <div class="quick-selectors-wrapper">
                                <div class="list-attribute-show">
                                    <label class="switch">
                                        <input type="checkbox" name="list-attribute-show" <?php if( $varimoListAttributeShow == "true" ): echo esc_attr("checked"); endif; ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="quick-selections" style="display: flex; align-items: center">
                            <h4><?php echo wp_kses('Show Title: ','variation-monster');?></h4>
                            <div class="quick-selectors-wrapper">
                                <div class="list-title-show">
                                    <label class="switch">
                                        <input type="checkbox" name="list-title-show" <?php if( $varimoListTitleShow == "true" ): echo esc_attr("checked"); endif; ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="quick-selections" style="display: flex; align-items: center">
                            <h4><?php echo wp_kses('Show Discount Badge: ','variation-monster');?>
                                <span class="discount-badge" data-tooltip="If discount available">?</span>
                            </h4>

                            <div class="quick-selectors-wrapper">
                                <div class="list-badge-show-on-off">
                                    <label class="switch">
                                        <input type="checkbox" id="discount-badge" name="list-badge-show-on-off" <?php if( $varimoListBadgeShowOnOff == "true" ): echo esc_attr("checked"); endif; ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="badge-all-settings" style="">
                            <div class="quick-selections" style="display: flex; align-items: center">
                                <h4><?php echo wp_kses('Show Badge at Right Side: ','variation-monster');?></h4>
                                <div class="quick-selectors-wrapper">
                                    <div class="list-badge-show-right">
                                        <label class="switch">
                                            <input type="checkbox" name="list-badge-show-right" <?php if( $varimoListBadgeShowRight == "true" ): echo esc_attr("checked"); endif; ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="quick-selections" style="display: flex; align-items: center">
                                <h4><?php echo wp_kses('Show Discount Price as Flat: ','variation-monster');?></h4>
                                <div class="quick-selectors-wrapper">
                                    <div class="list-badge-discount-flat-price">
                                        <label class="switch">
                                            <input type="checkbox" name="list-badge-discount-flat-price" <?php if( $varimoListBadgeDiscountFlatPrice == "true" ): echo esc_attr("checked"); endif; ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="quick-selections">
                                <div class="quick-selectors-wrapper m-top">
                                    <label for="list-for-percent"><strong> <?php echo wp_kses('For Percent Label: ','variation-monster');?></strong></label>
                                    <input id="list-for-percent" class="list-for-percent" type="text" name="list-for-percent" value="<?php echo esc_attr( $varimoListForPercent ); ?>"  >
                                </div>
                            </div>

                            <div class="quick-selections">
                                <div class="quick-selectors-wrapper m-top">
                                    <label for="list-for-flat"><strong> <?php echo wp_kses('For Flat Label: ','variation-monster');?></strong></label>
                                    <input id="list-for-flat" class="list-for-flat" type="text" name="list-for-flat" value="<?php echo esc_attr( $varimoListForFlat ); ?>"  >
                                </div>
                            </div>

                            <div class="quick-selections">
                                <div class="quick-selectors-wrapper">
                                    <label for="list-badge-bg-color"><strong> <?php echo wp_kses('Badge Background Color: ','variation-monster');?></strong></label>
                                    <input id="list-badge-bg-color" name="list-badge-bg-color" value="<?php echo esc_attr( $varimoListBadgeBgColor ); ?>"  data-jscolor="{}">
                                </div>
                            </div>

                            <div class="quick-selections">
                                <div class="quick-selectors-wrapper">
                                    <label for="list-badge-text-color"><strong> <?php echo wp_kses('Badge Text Color: ','variation-monster');?></strong></label>
                                    <input id="list-badge-text-color" name="list-badge-text-color" value="<?php echo esc_attr( $varimoListBadgeTextColor ); ?>"  data-jscolor="{}">
                                </div>
                            </div>

                            <!--                            <div class="quick-selections">-->
                            <!--                                <div class="quick-selectors-wrapper m-top">-->
                            <!--                                    <label for="list-badge-height"><strong> --><?php //echo wp_kses('Badge Height (px): ','variation-monster');?><!--</strong></label>-->
                            <!--                                    <input id="list-badge-height" class="list-badge-height" type="text" name="list-badge-height" value="--><?php //echo esc_attr( $varimoListBadgeHeight ); ?><!--"  >-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <!---->
                            <!--                            <div class="quick-selections">-->
                            <!--                                <div class="quick-selectors-wrapper m-top">-->
                            <!--                                    <label for="list-badge-width"><strong> --><?php //echo wp_kses('Badge Width (px): ','variation-monster');?><!--</strong></label>-->
                            <!--                                    <input id="list-badge-width" class="list-badge-width" type="text" name="list-badge-width" value="--><?php //echo esc_attr( $varimoListBadgeWidth ); ?><!--"  >-->
                            <!--                                </div>-->
                            <!--                            </div>-->

                        </div>

                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: end; position: absolute; left: 689px">
                <div id="show-template-image-list"></div>
            </div>
        </div>
    </div>

    <div id="variation-gallery" class="tabcontent" style="">
        <h2><?php echo esc_html('Variation Gallery Setting','variation-monster'); ?></h2>

        <div style="display: flex; gap: 30%">
            <div id="quickAuthenticateWrapper">
                <div class="quick-selections" style="display: flex; align-items: center">
                    <h4><?php echo wp_kses('Variation Gallery On: ','variation-monster');?></h4>
                    <div class="quick-selectors-wrapper">
                        <div class="variation-gallery-on-off">
                            <label class="switch">
                                <input type="checkbox" id="variation-gallery-on-off" name="variation-gallery-on-off" <?php if( $varimoVariationGalleryOnOff == "true" ): echo esc_attr("checked"); endif; ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="quick-selections quick-selections-style" style="display: flex; gap: 50%">

                    <div>
                        <h4><?php echo wp_kses('Gallery Style Template: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>

                        <div >
                            <select id="gallery-style-template" class="gallery-style-template" style="outline: none" disabled>
                                <option value="template_1" <?php selected($varimoGalleryStyleTemplate, 'template_1'); ?>><?php echo wp_kses('Template 1','variation-monster');?></option>
                                <option value="template_2" <?php selected($varimoGalleryStyleTemplate, 'template_2'); ?>><?php echo wp_kses('Template 2','variation-monster');?></option>
                                <option value="template_3" <?php selected($varimoGalleryStyleTemplate, 'template_3'); ?>><?php echo wp_kses('Template 3','variation-monster');?></option>
                                <option value="template_4" <?php selected($varimoGalleryStyleTemplate, 'template_4'); ?>><?php echo wp_kses('Template 4','variation-monster');?></option>
                                <option value="template_5" <?php selected($varimoGalleryStyleTemplate, 'template_5'); ?>><?php echo wp_kses('Template 5','variation-monster');?></option>
                            </select>
                        </div>
                    </div>
                </div>


                <!-- Gallery Image Size -->
                <div class="quick-selections quick-selections-style">
                    <h4><?php echo wp_kses('Gallery Image Size: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>

                    <div style="display: flex; gap: 80px;">
                        <select id="gallery-image-show" class="gallery-image-show" disabled>

                            <?php
                            $varimo_gallery_image_size_hook = [
                                    'thumbnail',
                                    'medium',
                                    'medium_large',
                                    'large',
                                    'woocommerce_thumbnail',
                                    'woocommerce_single',
                                    'woocommerce_gallery_thumbnail'
                            ];

                            $varimo_gallery_image_size_final_hook = apply_filters('varimo_quick_cart_carousel_size_hook', $varimo_gallery_image_size_hook);

                            foreach ($varimo_gallery_image_size_final_hook as $varimo_gallery_image_final_hook) {

                                $varimo_formatted_gallery_image_size_hook_name = ucwords(str_replace('_', ' ', $varimo_gallery_image_final_hook));

                                ?>
                                <option value="<?php echo esc_attr($varimo_gallery_image_final_hook); ?>" <?php selected($varimoGalleryImageShow, $varimo_gallery_image_final_hook); ?>>
                                    <?php echo esc_html($varimo_formatted_gallery_image_size_hook_name); ?>
                                </option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>

                <div class="quick-selections">
                    <div class="quick-selectors-wrapper m-top">
                        <label for="gallery-navigation-button-icon-color"><strong> <?php echo wp_kses('Gallery Navigation Button Icon Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                        <input disabled id="gallery-navigation-button-icon-color" name="gallery-navigation-button-icon-color" value="<?php echo esc_attr( $varimoGalleryNavigationButtonIconColor ); ?>"  data-jscolor="{}">
                    </div>
                </div>

                <div class="quick-selections">
                    <div class="quick-selectors-wrapper m-top">
                        <label for="gallery-navigation-button-icon-hover-color"><strong> <?php echo wp_kses('Gallery Navigation Button Icon Hover Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                        <input disabled id="gallery-navigation-button-icon-hover-color" name="gallery-navigation-button-icon-hover-color" value="<?php echo esc_attr( $varimoGalleryNavigationButtonIconHoverColor ); ?>"  data-jscolor="{}">
                    </div>
                </div>

                <div class="quick-selections">
                    <div class="quick-selectors-wrapper m-top">
                        <label for="gallery-navigation-button-background-color"><strong> <?php echo wp_kses('Gallery Navigation Button Background Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                        <input disabled id="gallery-navigation-button-background-color" name="gallery-navigation-button-background-color" value="<?php echo esc_attr( $varimoGalleryNavigationButtonBgColor ); ?>"  data-jscolor="{}">
                    </div>
                </div>

                <div class="quick-selections">
                    <div class="quick-selectors-wrapper m-top">
                        <label for="gallery-navigation-button-background-hover-color"><strong> <?php echo wp_kses('Gallery Navigation Button Background Hover Color: ','variation-monster');?><span class="dashicons dashicons-lock"></span></strong></label>
                        <input disabled id="gallery-navigation-button-background-hover-color" name="gallery-navigation-button-background-hover-color" value="<?php echo esc_attr( $varimoGalleryNavigationButtonBgHoverColor ); ?>"  data-jscolor="{}">
                    </div>
                </div>
            </div>
            <div style="display: flex; align-items: end; position: absolute; left: 689px">
                <div id="show-template-image-gallery"></div>
            </div>
        </div>

    </div>

    <div id="attribute-gallery" class="tabcontent" style="">

        <div id="quickAuthenticateWrapper">
            <h2><?php echo esc_html('Attribute Gallery Setting','variation-monster'); ?></h2>
            <div>
                <div class="quick-selections" style="display: flex; align-items: center">
                    <h4><?php echo wp_kses('Attribute Gallery On: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>
                    <div class="quick-selectors-wrapper">
                        <div class="attribute-gallery-on-off">
                            <label class="switch">
                                <input type="checkbox" id="attribute-gallery-on-off" name="attribute-gallery-on-off" disabled>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Gallery Image Size -->
                <div class="quick-selections quick-selections-style">
                    <h4><?php echo wp_kses('Attribute Gallery Image Size: ','variation-monster');?><span class="dashicons dashicons-lock"></span></h4>

                    <div style="display: flex; gap: 80px;">
                        <select id="attribute-gallery-image-show" class="attribute-gallery-image-show" disabled>


                            <?php
                            $varimo_attribute_gallery_image_size_hook = [
                                    'thumbnail',
                                    'medium',
                                    'medium_large',
                                    'large',
                                    'woocommerce_thumbnail',
                                    'woocommerce_single',
                                    'woocommerce_gallery_thumbnail'
                            ];

                            $varimo_attribute_gallery_image_size_final_hook = apply_filters('varimo_attribute_gallery_image_size_hook', $varimo_attribute_gallery_image_size_hook);

                            foreach ($varimo_attribute_gallery_image_size_final_hook as $varimo_attribute_gallery_image_final_hook) {

                                $varimo_formatted_attribute_gallery_image_size_hook_name = ucwords(str_replace('_', ' ', $varimo_attribute_gallery_image_final_hook));

                                ?>
                                <option value="<?php echo esc_attr($varimo_attribute_gallery_image_final_hook); ?>" <?php selected($varimoAttributeGalleryImageShow, $varimo_attribute_gallery_image_final_hook); ?>>
                                    <?php echo esc_html($varimo_formatted_attribute_gallery_image_size_hook_name); ?>
                                </option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>




<?php wp_nonce_field( 'quick_admin_nonce_action', 'quick_admin_nonce' ); ?>
  <!-- save Button -->
    <button type="button" style="z-index:9999; position: fixed; bottom: 20px; right: 20px; display: flex; justify-content: center; align-items: center; padding: 10px 20px; background-color: #6033E7; color: white; border: none; border-radius: 5px; cursor: pointer; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);" class="buttonload">
        <?php echo esc_html('Save', 'variation-monster'); ?>
    </button>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var helpButton                       = document.querySelector('.help-button');
        var helpImageContainer               = document.querySelector('.help-image');
        var popup                            = document.getElementById('popup-container');
        var helpButtonOverwriteTable         = document.querySelector('.help-button-overwrite-default-cart-table');
        var helpImageContainerOverwriteTable = document.querySelector('.help-image-overwrite-default-cart-table');
        var popupOverwriteTable              = document.getElementById('popup-container-overwrite-default-cart-table');

        var buffer = 6;

        helpButton.addEventListener('mouseenter', function (e) {
            e.preventDefault();
            helpImageContainer.innerHTML = '';

            var img = document.createElement('img');
            img.src = "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/help-quick-cart.png'); ?>";
            img.alt = "Quick Cart Help Image";

            helpImageContainer.appendChild(img);
            popup.style.display = 'flex';

            document.addEventListener('mousemove', trackMouseOutside);
        });

        function trackMouseOutside(e) {
            var rect = helpButton.getBoundingClientRect();

            var outside =
                e.clientX < rect.left - buffer ||
                e.clientX > rect.right + buffer ||
                e.clientY < rect.top - buffer ||
                e.clientY > rect.bottom + buffer;

            if (outside) {
                popup.style.display = 'none';
                document.removeEventListener('mousemove', trackMouseOutside);
            }
        }

        helpButtonOverwriteTable.addEventListener('mouseenter', function(e) {
            e.preventDefault();
            helpImageContainerOverwriteTable.innerHTML = '';

            var img = document.createElement('img');
            img.src = "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/overwrite-cart-to-table.png'); ?>";
            img.alt = "Quick Cart Help Image";

            helpImageContainerOverwriteTable.appendChild(img);
            popupOverwriteTable.style.display = 'flex';

            document.addEventListener('mousemove', trackMouseOutsideOverwriteTable);
        });

        function trackMouseOutsideOverwriteTable(e) {
            var rect = helpButtonOverwriteTable.getBoundingClientRect();

            var outside =
                e.clientX < rect.left - buffer ||
                e.clientX > rect.right + buffer ||
                e.clientY < rect.top - buffer ||
                e.clientY > rect.bottom + buffer;

            if (outside) {
                popupOverwriteTable.style.display = 'none';
                document.removeEventListener('mousemove', trackMouseOutsideOverwriteTable);
            }
        }

        window.addEventListener('click', function(event) {
            if (event.target === popup) {
                popup.style.display = 'none';
            }
        });

        window.addEventListener('click', function(event) {
            if (event.target === popupOverwriteTable) {
                popupOverwriteTable.style.display = 'none';
            }
        });
    });

</script>

<script>
    function varimoDashboardClick(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();

</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectElement = document.getElementById('select-design');
        const designTemplateContainer = document.getElementById('show-template-image');

        // Template image paths
        const templateImages = {
            template_1: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/template_1.png'); ?>",
            template_2: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/template_2.png'); ?>",
            template_3: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/template_3.png'); ?>",
            template_4: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/template_4.png'); ?>"
        };

        // Function to dynamically create and display the selected template image
        function updateImageDisplay() {

            const selectedValue = selectElement.value;

            // Clear any existing image inside the design template container
            designTemplateContainer.innerHTML = `
            <div class="design-template">
            </div>
        `;

            // Create the image element dynamically
            if (templateImages[selectedValue]) {
                const img = document.createElement('img');
                img.src = templateImages[selectedValue];
                img.alt = `${selectedValue} image`;
                img.style.display = 'block';

                // Customize styles for specific templates (if needed)
                if (selectedValue === 'template_3') {
                    img.style.height = '200px';
                    img.style.width = '400px';
                }

                // Append the image to the design template container
                const designTemplate = designTemplateContainer.querySelector('.design-template');
                designTemplate.appendChild(img);
            }
        }

        updateImageDisplay();

        // Listen for changes in the select dropdown
        selectElement.addEventListener('change', updateImageDisplay);
    });


    document.addEventListener("DOMContentLoaded", function () {
        const selectElement                  = document.getElementById('variation-list-template');
        const selectElementGallery           = document.getElementById('gallery-style-template');
        const designTemplateContainer        = document.getElementById('show-template-image-list');
        const designTemplateContainerGallery = document.getElementById('show-template-image-gallery');

        const templateImages = {
            template_1: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/list_template_1.png'); ?>",
            template_2: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/list_template_2.png'); ?>",
        };

        const templateImagesGallery = {
            template_1: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/gallery-template-one.png'); ?>",
            template_2: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/gallery-template-two.png'); ?>",
            template_3: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/gallery-template-three.png'); ?>",
            template_4: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/gallery-template-four.png'); ?>",
            template_5: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/gallery-template-five.png'); ?>",
        };

        function updateImageDisplay() {

            const selectedValue = selectElement.value;

            designTemplateContainer.innerHTML = `
                <div class="design-template">
                </div>
            `;

            if (templateImages[selectedValue]) {
                const img = document.createElement('img');
                img.src = templateImages[selectedValue];
                img.alt = `${selectedValue} image`;
                img.style.display = 'block';

                if (selectedValue === 'template_1' || selectedValue === 'template_2') {
                    img.style.height = '200px';
                    img.style.width = '400px';
                }

                const designTemplate = designTemplateContainer.querySelector('.design-template');
                designTemplate.appendChild(img);
            }
        }

        function updateImageDisplayGallery() {

            const selectedValue = selectElementGallery.value;

            designTemplateContainerGallery.innerHTML = `
                <div class="design-template-gallery">
                </div>
            `;

            if (templateImagesGallery[selectedValue]) {
                const img = document.createElement('img');
                img.src = templateImagesGallery[selectedValue];
                img.alt = `${selectedValue} image`;
                img.style.display = 'block';

                if (selectedValue === 'template_1' || selectedValue === 'template_2' || selectedValue === 'template_4' || selectedValue === 'template_3' || selectedValue === 'template_5') {
                    img.style.height = '267px';
                    img.style.width = '400px';
                }

                const designTemplate = designTemplateContainerGallery.querySelector('.design-template-gallery');
                designTemplate.appendChild(img);
            }
        }

        updateImageDisplay();
        updateImageDisplayGallery();

        selectElement.addEventListener('change', updateImageDisplay);
        selectElementGallery.addEventListener('change', updateImageDisplayGallery);
    });


    document.addEventListener("DOMContentLoaded", function () {
        const selectElement = document.getElementById('select-design-add-cart-table-template2');
        const designTemplateContainer = document.getElementById('show-design-add-cart-table-template2');

        // Template image paths
        const templateImages = {
            template_1: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/table_template2_add_cart_template1.png'); ?>",
            template_2: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/table_template2_add_cart_template2.png'); ?>",
        };

        // Function to dynamically create and display the selected template image
        function updateImageDisplay() {

            const selectedValue = selectElement.value;

            // Clear any existing image inside the design template container
            designTemplateContainer.innerHTML = `
            <div class="design-template">
            </div>
        `;

            // Create the image element dynamically
            if (templateImages[selectedValue]) {
                const img = document.createElement('img');
                img.src = templateImages[selectedValue];
                img.alt = `${selectedValue} image`;
                img.style.display = 'block';

                // Customize styles for specific templates (if needed)
                if (selectedValue === 'template_3') {
                    img.style.height = '200px';
                    img.style.width = '400px';
                }

                // Append the image to the design template container
                const designTemplate = designTemplateContainer.querySelector('.design-template');
                designTemplate.appendChild(img);
            }
        }

        updateImageDisplay();

        selectElement.addEventListener('change', updateImageDisplay);
    });


    document.addEventListener("DOMContentLoaded", function () {
        const selectElement = document.getElementById('select-design-variation-table-template');
        const designTemplateContainer = document.getElementById('show-design-variation-table-template');
        const template2Options = document.getElementById('variation-table-template2-options');
        const template1Options = document.getElementById('variation-table-template1-options');
        const tableTemplate2CartDesign = document.getElementById('variation-table-template2-cart-design');
        const variationGalleryCheckbox = document.getElementById('variation-gallery-on-off');
        const showGalleryImageIntoPopup = document.getElementById('show-gallery-image-into-popup');
        const badgeAllSettings = document.getElementById('badge-all-settings');
        const discountBadge = document.getElementById('discount-badge');


        // Function to toggle the display
        function toggleDiscountBadge() {
            if (discountBadge.checked) {
                badgeAllSettings.style.display = '';
            } else {
                badgeAllSettings.style.display = 'none';
            }
        }

        // Initial state check
        toggleDiscountBadge();

        // Event listener for changes
        discountBadge.addEventListener('change', toggleDiscountBadge);


        // Function to toggle the display
        function toggleShowGalleryWrapper() {
            if (variationGalleryCheckbox.checked) {
                showGalleryImageIntoPopup.style.display = 'flex';
            } else {
                showGalleryImageIntoPopup.style.display = 'none';
            }
        }

        // Initial state check
        toggleShowGalleryWrapper();

        // Event listener for changes
        variationGalleryCheckbox.addEventListener('change', toggleShowGalleryWrapper);


        // Function to toggle display of Template 2 options
        function toggleTemplateOptions() {
            if (selectElement.value === 'template_2') {
                template2Options.style.display = 'block';
                tableTemplate2CartDesign.style.display = 'block';
            } else {
                template2Options.style.display = 'none';
                tableTemplate2CartDesign.style.display = 'none';
            }
            if (selectElement.value === 'template_1') {
                template1Options.style.display = 'block';
            } else {
                template1Options.style.display = 'none';
            }
        }

        // Initialize visibility on page load
        toggleTemplateOptions();

        // Add event listener to update visibility when selection changes
        selectElement.addEventListener('change', toggleTemplateOptions);

        // Template image paths
        const templateImages = {
            template_1: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/variation-table-template1.png'); ?>",
            template_2: "<?php echo esc_url(plugin_dir_url(__DIR__) . 'Assets/images/variation-table-template2.png'); ?>",
        };

        // Function to dynamically create and display the selected template image
        function updateImageDisplay() {

            const selectedValue = selectElement.value;

            // Clear any existing image inside the design template container
            designTemplateContainer.innerHTML = `
            <div class="design-template-variation-table-template">
            </div>
        `;

            // Create the image element dynamically
            if (templateImages[selectedValue]) {
                const img = document.createElement('img');
                img.src = templateImages[selectedValue];
                img.alt = `${selectedValue} image`;
                img.style.display = 'block';

                // Customize styles for specific templates (if needed)
                if (selectedValue === 'template_1' || selectedValue === 'template_2') {
                    img.style.height = '200px';
                    img.style.width = '400px';
                }

                // Append the image to the design template container
                const designTemplate = designTemplateContainer.querySelector('.design-template-variation-table-template');
                designTemplate.appendChild(img);
            }
        }

        selectElement.addEventListener('change', updateImageDisplay);

        updateImageDisplay();
    });

</script>

<style>
    .quick-selections input[type="radio"] {
        appearance: none; /* Remove default browser styling */
        -webkit-appearance: none; /* For Safari */
        min-width: 10px; /* Smaller size */
        min-height: 10px;
        border: 2px solid #ccc; /* Border for unselected state */
        border-radius: 50%; /* Keep it circular */
        outline: none; /* Remove outline on focus */
        margin: 0;
        cursor: pointer;
        transition: 0.3s; /* Smooth hover/focus effects */
    }

    .quick-selections input[type="radio"]:checked {
        border-color: #007bff; /* Border color when selected */
        background-color: #007bff; /* Background color for selected state */
    }

    .quick-selections input[type="radio"]:hover {
        border-color: #007bff; /* Hover effect */
    }

    .quick-selections .icon-design label {
        display: flex;
        align-items: center;
        gap: 6px; /* Adjust spacing between icon and radio button */
        font-size: 18px; /* Adjust font size */
        cursor: pointer;
    }


</style>

<style>
    /* Tooltip container styling */
    .redirect-single-page-help , .discount-badge {
        position: relative;
        cursor: pointer;
        display: inline-block;
        color: black !important;
        background-color: lightgrey;
        border-radius: 50%;
        height: 15px;
        width: 15px;
        text-align: center;
        line-height:12px;
    }

    /* Tooltip text */
    .redirect-single-page-help::after , .discount-badge::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 120%; /* Position the tooltip above the element */
        left: 50%;
        transform: translateX(-50%);
        background-color: #333;
        color: #fff;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
        z-index: 9999;
    }

    /* Show tooltip on hover */
    .redirect-single-page-help:hover::after , .discount-badge:hover::after{
        opacity: 1;
        visibility: visible;
    }
</style>
