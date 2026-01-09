<?php
if (!defined('ABSPATH')) exit;

/**
 * Class VARIMO_Dokan_Integration.
 *
 * @since 1.0.0
 */
class VARIMO_Dokan_Integration {

    /**
     * Define Constant.
     *
     * @return void
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'dokan_product_edit_after_inventory_variants', array($this, 'dokan_product_add_edit'), 25 );
        add_action('dokan_process_product_meta', array($this, 'save_variation_data_panel'), 10, 2);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_dokan_integration_assets'));
    }

    /**
     * Variation Monster individual product settings show into
     * add product and edit product dashboard for every dokan vendor.
     *
     * @return void
     * @since 1.0.0
     */
    function dokan_product_add_edit() {

        global $post;
        $product                                      = wc_get_product($post->ID);
        $attributes                                   = $product->get_attributes();
        $variableSetting                              = get_option('variable_all_checked', array());

        $quickCarouselOnOff                           = isset($variableSetting['quickCarouselOnOff']) ? $variableSetting['quickCarouselOnOff'] : '';
        $quickCarouselMeta                            = get_post_meta($post->ID, '_quick_cart_carousel_meta', true);
        $defaultValueQuickCarouselMeta                = !empty($quickCarouselMeta) ? $quickCarouselMeta : $quickCarouselOnOff;

        $selectVariationTemplateOnOff                 = isset($variableSetting['selectVariationTemplateOnOff']) ? $variableSetting['selectVariationTemplateOnOff'] : '';
        $variationListMeta                            = get_post_meta($post->ID, '_variation_list_meta', true);
        $defaultValueVariationListMeta                = !empty($variationListMeta) ? $variationListMeta : $selectVariationTemplateOnOff;

        $variationSelectOnOff                         = isset($variableSetting['variationSelectOnOff']) ? $variableSetting['variationSelectOnOff'] : '';
        $variationSwatchesMeta                        = get_post_meta($post->ID, '_variation_swatches_meta', true);
        $defaultValueVariationSwatchesMeta            = !empty($variationSwatchesMeta) ? $variationSwatchesMeta : $variationSelectOnOff;

        $quickTableOnOff                              = isset($variableSetting['quickTableOnOff']) ? $variableSetting['quickTableOnOff'] : '';
        $variationTableMeta                           = get_post_meta($post->ID, '_variation_table_meta', true);
        $defaultValueVariationTableMeta               = !empty($variationTableMeta) ? $variationTableMeta : $quickTableOnOff;

        $beforeCartQuickTableOnOff                    = isset($variableSetting['beforeCartQuickTableOnOff']) ? $variableSetting['beforeCartQuickTableOnOff'] : '';
        $beforeCartVariationTableMeta                 = get_post_meta($post->ID, '_before_cart_variation_table_meta', true);
        $defaultBeforeCartValueVariationTableMeta     = !empty($beforeCartVariationTableMeta) ? $beforeCartVariationTableMeta : $beforeCartQuickTableOnOff;

        $showAttributeSwatchesArchive                 = isset($variableSetting['showAttributeSwatchesArchive'][0]) ? $variableSetting['showAttributeSwatchesArchive'][0] : '';
        $showAttributeSwatchesArchiveMeta             = get_post_meta($post->ID, '_variation_swatches_archive_page_meta', true);
        $defaultValueShowAttributeSwatchesArchiveMeta = !empty($showAttributeSwatchesArchiveMeta) ? $showAttributeSwatchesArchiveMeta : $showAttributeSwatchesArchive;

        $attributeGalleryOnOff                        = isset($variableSetting['attributeGalleryOnOff']) ? $variableSetting['attributeGalleryOnOff'] : '';

        wp_nonce_field('product_variation_table_data_meta_box_nonce', 'product_variation_meta_box_nonce');
        ?>

        <div class="dokan-attribute-variation-options dokan-edit-row dokan-clearfix hide_if_external">
            <div class="dokan-section-heading" data-togglehandler="dokan_attribute_variation_options">
                <h2><i class="fas fa-cubes" aria-hidden="true"></i> <span class="show_if_variable show_if_variable-subscription"><?php esc_html_e( 'Variation Monster', 'variation-monster' ); ?></span></h2>
                <p class="show_if_variable show_if_variable-subscription"><?php esc_html_e( 'Manage variation monster meta data settings for this variable product.', 'variation-monster' ); ?></p>

                <a href="#" class="dokan-section-toggle">
                    <i class="fas fa-sort-down fa-flip-vertical" aria-hidden="true"></i>
                </a>

                <div class="dokan-clearfix"></div>
            </div>
            <div class="dokan-section-content">
                <div id="product_variation_product_data" class="panel woocommerce_options_panel">

                    <div style="">
                        <div class="options_group" style="margin-top: 20px;">
                            <!-- Quick Cart Carousel Section -->
                            <?php if ($quickCarouselOnOff === 'true') : ?>
                                <p class="dokan-varimo-form-field _quick_cart_carousel_meta_field">
                                    <label  for="_quick_cart_carousel_meta">Quick Cart Carousel</label>
                                    <select id="_quick_cart_carousel_meta" name="_quick_cart_carousel_meta" class="select short" data-placeholder="">
                                        <option value="true" <?php selected($defaultValueQuickCarouselMeta, 'true'); ?>>On</option>
                                        <option value="false" <?php selected($defaultValueQuickCarouselMeta, 'false'); ?>>Off</option>
                                    </select>
                                    <span class="varimo-help-tip" data-tip="Variation quick cart carousel enable disable for this product">?</span>
                                </p>
                            <?php endif; ?>

                            <!-- Variation List Section -->
                            <?php if ($selectVariationTemplateOnOff === 'true') : ?>
                                <p class="dokan-varimo-form-field _variation_list_meta_field">
                                    <label for="_variation_list_meta">Variation List</label>
                                    <select id="_variation_list_meta" name="_variation_list_meta" class="select short" data-placeholder="">
                                        <option value="true" <?php selected($defaultValueVariationListMeta, 'true'); ?>>On</option>
                                        <option value="false" <?php selected($defaultValueVariationListMeta, 'false'); ?>>Off</option>
                                    </select>
                                    <span class="varimo-help-tip" data-tip="Variation List enable disable for this product">?</span>
                                </p>
                            <?php endif; ?>

                            <!-- Variation Swatches Section -->
                            <?php if ($variationSelectOnOff === 'true') : ?>
                                <p class="dokan-varimo-form-field _variation_swatches_meta_field">
                                    <label for="_variation_swatches_meta">Variation Swatches</label>
                                    <select id="_variation_swatches_meta" name="_variation_swatches_meta" class="select short" data-placeholder="">
                                        <option value="true" <?php selected($defaultValueVariationSwatchesMeta, 'true'); ?>>On</option>
                                        <option value="false" <?php selected($defaultValueVariationSwatchesMeta, 'false'); ?>>Off</option>
                                    </select>
                                    <span class="varimo-help-tip" data-tip="Variation swatches enable disable for this product">?</span>
                                </p>
                            <?php endif; ?>

                            <!-- Variation Table Section -->
                            <?php if ($quickTableOnOff === 'true') : ?>
                                <p class="dokan-varimo-form-field _variation_table_meta_field">
                                    <label for="_variation_table_meta">Variation Table</label>
                                    <select id="_variation_table_meta" name="_variation_table_meta" class="select short" data-placeholder="">
                                        <option value="true" <?php selected($defaultValueVariationTableMeta, 'true'); ?>>On</option>
                                        <option value="false" <?php selected($defaultValueVariationTableMeta, 'false'); ?>>Off</option>
                                    </select>
                                    <span class="varimo-help-tip" data-tip="Variation table enable disable for this product">?</span>
                                </p>
                            <?php endif; ?>

                            <!-- Before Cart Variation Table Section -->
                            <?php if ($beforeCartQuickTableOnOff === 'true') : ?>
                                <p class="dokan-varimo-form-field _before_cart_variation_table_meta_field">
                                    <label for="_before_cart_variation_table_meta">Before Cart Variation Table</label>
                                    <select id="_before_cart_variation_table_meta" name="_before_cart_variation_table_meta" class="select short" data-placeholder="">
                                        <option value="true" <?php selected($defaultBeforeCartValueVariationTableMeta, 'true'); ?>>On</option>
                                        <option value="false" <?php selected($defaultBeforeCartValueVariationTableMeta, 'false'); ?>>Off</option>
                                    </select>
                                    <span class="varimo-help-tip" data-tip="Before Cart variation table enable disable for this product">?</span>
                                </p>
                            <?php endif; ?>

                            <!-- Variation Swatches on Archive Page Section -->
                            <?php if ($showAttributeSwatchesArchive !== 'none') : ?>
                                <p class="dokan-varimo-form-field _variation_swatches_archive_page_meta_field">
                                    <label for="_variation_swatches_archive_page_meta">Variation Swatches on Archive Page</label>
                                    <select id="_variation_swatches_archive_page_meta" name="_variation_swatches_archive_page_meta" class="select short" data-placeholder="">
                                        <option value="not-select" <?php selected($defaultValueShowAttributeSwatchesArchiveMeta, 'not-select'); ?>>Select</option>
                                        <option value="attribute-archive" <?php selected($defaultValueShowAttributeSwatchesArchiveMeta, 'attribute-archive'); ?>>Redirect Single Product Page</option>
                                        <option value="attribute-swatches" <?php selected($defaultValueShowAttributeSwatchesArchiveMeta, 'attribute-swatches'); ?>>Quick Cart</option>
                                        <option value="none" <?php selected($defaultValueShowAttributeSwatchesArchiveMeta, 'none'); ?>>None</option>
                                    </select>
                                    <span class="varimo-help-tip" data-tip="Enable single product variation swatches archive page settings">?</span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h2 style="font-weight: bold"><?php esc_html_e('Extend Attribute Settings', 'variation-monster'); ?></h2>
                    <table class="wp-list-table widefat fixed striped" id="attribute-table" style="cursor: pointer; display: contents;">
                        <tbody>
                        <?php
                        if (!empty($attributes)) {
                            foreach ($attributes as $attribute) {
                                $attribute_name   = wc_attribute_label($attribute->get_name());
                                $attribute_slug   = sanitize_title($attribute->get_name());
                                $attribute_values = $attribute->is_taxonomy()
                                    ? wc_get_product_terms($post->ID, $attribute->get_name(), ['fields' => 'names'])
                                    : $attribute->get_options();

                                // Ensure $attribute_values is an array
                                $attribute_values = is_array($attribute_values) ? $attribute_values : [$attribute_values];

                                $attribute_id                   = $attribute->get_id();
                                $display_type_attribute_section = get_option( 'wc_attribute_display_type_' . $attribute_id );
                                $display_type                   = get_post_meta($post->ID, 'variation_meta_attribute_display_type_' . $attribute_slug, true);
                                $display_type                   = ($display_type === '') ? $display_type_attribute_section : $display_type;
                                $show_archive                   = get_post_meta($post->ID, 'show_attribute_archive_page_' . $attribute_slug, true);
                                ?>
                                <tr style="background-color: white; display: flex; align-items: baseline; gap: 140px;" class="attribute-row" data-row-id="<?php echo esc_attr($attribute_id); ?>">
                                    <td>
                                        <h4 style="font-weight: bold;"><?php echo esc_html($attribute_name); ?></h4>
                                    </td>
                                    <td style="display: flex; gap:20px;" class="show-in-archive-page-attribute-select-option">
                                        <label style="min-width: fit-content"><?php esc_html_e('Show in Archive Page:', 'variation-monster'); ?></label>
                                        <select name="show_attribute_archive_page[<?php echo esc_attr($attribute_slug); ?>]" id="show_attribute_archive_page_[<?php echo esc_attr($attribute_slug); ?>]">
                                            <option value="yes" <?php selected($show_archive, 'yes'); ?>><?php esc_html_e('Yes', 'variation-monster'); ?></option>
                                            <option value="" <?php selected($show_archive, ''); ?>><?php esc_html_e('No', 'variation-monster'); ?></option>
                                        </select>
                                    </td>
                                    <td class="varimo-dokan-display-type-attribute" style="display: flex; gap:20px;">
                                        <label style="min-width: fit-content"><?php esc_html_e('Display Type:', 'variation-monster'); ?></label>
                                        <select data-rowSlug-displayType="<?php echo esc_attr($attribute_slug); ?>" name="attribute_display_type[<?php echo esc_attr($attribute_slug); ?>]" id="attribute_display_type_<?php echo esc_attr($attribute_slug); ?>">
                                            <option value="button" <?php selected($display_type, 'button'); ?>><?php esc_html_e('Button', 'variation-monster'); ?></option>
                                            <option value="color" <?php selected($display_type, 'color'); ?>><?php esc_html_e('Color', 'variation-monster'); ?></option>
                                            <option value="image" <?php selected($display_type, 'image'); ?>><?php esc_html_e('Image', 'variation-monster'); ?></option>
                                            <option value="radio" <?php selected($display_type, 'radio'); ?>><?php esc_html_e('Radio', 'variation-monster'); ?></option>
                                        </select>
                                        <p class="attribute-toggle-btn" data-row-id="<?php echo esc_attr($attribute_slug); ?>" style="cursor: pointer; display: inline-flex; align-items: center; margin-left: 80px">
                                            <span class="dashicons dashicons-arrow-down toggle-icon"></span>
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" style="border-top: 1px solid #000; margin: 20px 0"></td>
                                </tr>

                                <tr id="attribute-settings-<?php echo esc_attr($attribute_slug); ?>" class="attribute-settings" style="display: none;">
                                    <td colspan="3">
                                        <table>
                                            <tbody>
                                            <?php
                                            $term_ids = wc_get_product_terms($post->ID, $attribute->get_name(), ['fields' => 'ids']); // Retrieve term IDs
                                            $custom_attribute_values = [];

                                            if (!$attribute->is_taxonomy()) {
                                                $custom_attribute_values = $attribute->get_options();
                                            }

                                            if (!empty($term_ids)) {
                                                foreach ($term_ids as $term_id) {
                                                    $color_attribute             = get_term_meta($term_id, 'term_color', true);
                                                    $color_meta                  = get_post_meta($post->ID, 'variation_meta_attribute_color_' . $term_id . '_' . $attribute_id, true);
                                                    $secondary_color_attribute   = get_term_meta($term_id, 'term_secondary_color', true);
                                                    $secondary_color_meta        = get_post_meta($post->ID, 'variation_meta_attribute_secondary_color_' . $term_id . '_' . $attribute_id, true);
                                                    $image_attribute             = get_term_meta($term_id, 'term_image', true);
                                                    $image_meta                  = get_post_meta($post->ID, 'variation_meta_attribute_image_' . $term_id . '_' . $attribute_id, true);
                                                    $image_url                   = !empty($image_meta) ? $image_meta : $image_attribute;
                                                    $tooltip_meta_image_url      = get_post_meta($post->ID, 'tooltip_meta_term_image_' . $term_id . '_' . $attribute_id, true);
                                                    $tooltip_meta                = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $term_id . '_' . $attribute_id, true);
                                                    $save_tooltip_meta           = '';
                                                    if (empty($tooltip_meta)){
                                                        $save_tooltip_meta = get_term_meta($term_id, 'term_tooltip', true);
                                                    }
                                                    if (empty($save_tooltip_meta)){
                                                        $save_tooltip_meta  = get_term($term_id)->name;
                                                    }

                                                    ?>
                                                    <tr style="display: flex; gap: 200px; align-items: center; justify-content: center">
                                                        <td style="min-width: 100px; font-weight:bold;"><?php echo esc_html(get_term($term_id)->name); ?></td>
                                                        <td>
                                                            <div class="color-meta display-typeShow-color-<?php echo esc_attr($attribute_slug); ?>" id="display-select-option-color-<?php echo esc_attr($term_id); ?>-<?php echo esc_attr($attribute_id); ?>" style="display: none; display: flex; gap: 78px; margin-top: 10px">
                                                                <label style="font-weight:bold;"><?php esc_html_e('Color:', 'variation-monster'); ?></label>
                                                                <input type="text"
                                                                       name="variation_meta_color[<?php echo esc_attr($term_id); ?>][<?php echo esc_attr($attribute_id); ?>]"
                                                                       id="variation_meta_color_<?php echo esc_attr($term_id); ?>_<?php echo esc_attr($attribute_id); ?>"
                                                                       value="<?php echo esc_attr(!empty($color_meta)? $color_meta : $color_attribute); ?>"
                                                                       class="spectrum-color-picker" data-default-color="<?php echo esc_attr($color_attribute ?: '#ffffff'); ?>">
                                                            </div>

                                                            <div class="color-meta display-typeShow-color-<?php echo esc_attr($attribute_slug); ?>" id="display-select-option-secondary-color-<?php echo esc_attr($term_id); ?>-<?php echo esc_attr($attribute_id); ?>" style="display: none; display: flex; gap: 50px; margin-top: 10px">
                                                                <label style="font-weight:bold;"><?php esc_html_e('Secondary Color:', 'variation-monster'); ?></label>
                                                                <input type="text"
                                                                       name="variation_meta_secondary_color[<?php echo esc_attr($term_id); ?>][<?php echo esc_attr($attribute_id); ?>]"
                                                                       id="variation_meta_secondary_color_<?php echo esc_attr($term_id); ?>_<?php echo esc_attr($attribute_id); ?>"
                                                                       value="<?php echo esc_attr(!empty($secondary_color_meta) ? $secondary_color_meta : $secondary_color_attribute); ?>"
                                                                       class="spectrum-color-picker" data-default-color="<?php echo esc_attr($secondary_color_attribute ?: '#ffffff');?>">
                                                            </div>

                                                            <div class="image-meta display-typeShow-image-<?php echo esc_attr($attribute_slug); ?>" id="display-select-option-image-<?php echo esc_attr($term_id); ?>-<?php echo esc_attr($attribute_id); ?>" style="display: none; display: flex; gap: 50px; margin-top: 10px">
                                                                <label style="font-weight:bold;"><?php esc_html_e('Image:', 'variation-monster'); ?></label>
                                                                <div>
                                                                    <img id="meta_term_image_preview_<?php echo esc_attr($term_id); ?>"
                                                                         class="meta_term_image_preview"
                                                                         src="<?php echo esc_url($image_url); ?>"
                                                                         alt="Selected Image"
                                                                         style="max-width: 70px; height: auto;">
                                                                    <input type="hidden"
                                                                           name="variation_meta_image[<?php echo esc_attr($term_id); ?>][<?php echo esc_attr($attribute_id); ?>]"
                                                                           id="meta_term_image_<?php echo esc_attr($term_id); ?>"
                                                                           class="meta_term_image"
                                                                           value="<?php echo esc_attr($image_url); ?>">
                                                                    <div style="display: flex; gap: 10px;">
                                                                        <button type="button" class="button meta_upload_image_button"><?php esc_html_e('Upload Image', 'variation-monster'); ?></button>
                                                                        <button type="button" class="button meta_image_button_remove" style="background-color: firebrick; color: white;"><?php esc_html_e('Remove Image', 'variation-monster'); ?></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tooltip-meta" style="margin-top: 10px; display: flex; gap: 50px;">
                                                                <label style="font-weight:bold;"><?php esc_html_e('Tooltip:', 'variation-monster'); ?></label>
                                                                <input type="text" placeholder=""
                                                                       name="variation_meta_tooltip[<?php echo esc_attr($term_id); ?>][<?php echo esc_attr($attribute_id); ?>]"
                                                                       id="variation_meta_tooltip_<?php echo esc_attr($term_id); ?>"
                                                                       value="<?php echo esc_attr(!empty($tooltip_meta)? $tooltip_meta : $save_tooltip_meta); ?>">
                                                            </div>

                                                            <div class="tooltip-image-meta" id="" style="margin-top: 44px; display: flex; gap: 50px;">
                                                                <label style="font-weight:bold;"><?php esc_html_e('Tooltip Image:', 'variation-monster'); ?></label>
                                                                <div>
                                                                    <img id="tooltip_meta_term_image_preview_<?php echo esc_attr($term_id); ?>"
                                                                         class="tooltip_meta_term_image_preview"
                                                                         src="<?php echo esc_url($tooltip_meta_image_url); ?>"
                                                                         alt="Selected Image"
                                                                         style="max-width: 70px; height: auto;">
                                                                    <input type="hidden"
                                                                           name="tooltip_meta_term_image[<?php echo esc_attr($term_id); ?>][<?php echo esc_attr($attribute_id); ?>]"
                                                                           id="tooltip_meta_term_image_<?php echo esc_attr($term_id); ?>"
                                                                           class="tooltip_meta_term_image"
                                                                           value="<?php echo esc_attr($tooltip_meta_image_url); ?>">
                                                                    <div style="display: flex; gap: 10px;">
                                                                        <button type="button" class="button tooltip_meta_upload_image_button"><?php esc_html_e('Upload Image', 'variation-monster'); ?></button>
                                                                        <button type="button" class="button tooltip_meta_image_button_remove" style="background-color: firebrick; color: white;"><?php esc_html_e('Remove Image', 'variation-monster'); ?></button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php

                                                            if ($attributeGalleryOnOff === 'true'){
                                                                ?>
                                                                <div class="term-gallery" style="margin-top: 10px; margin-bottom: 10px;">
                                                                    <?php

                                                                    $term_gallery_images = get_post_meta($post->ID, '_term_gallery_images_' . $term_id . '_' . $attribute_id, true);
                                                                    $term_image_ids = $term_gallery_images ? explode(',', $term_gallery_images) : [];

                                                                    ?>
                                                                    <div class="form-row form-row-full" >
                                                                        <label style="font-weight:bold;"><?php esc_html_e('Gallery Image:', 'variation-monster'); ?></label>
                                                                        <ul id="gallery-container-<?php echo esc_attr($term_id); ?>" class="variation-gallery-container" style="margin-top: 5px;">
                                                                            <?php foreach ($term_image_ids as $image_id): ?>
                                                                                <li class="variation-gallery-item" data-image-id="<?php echo esc_attr($image_id); ?>">
                                                                                    <?php echo wp_get_attachment_image(
                                                                                        $image_id,
                                                                                        '',
                                                                                        false,
                                                                                        [
                                                                                            'alt'   => '',
                                                                                            'width' => '60',
                                                                                            'height' => '60',
                                                                                            'class' => 'variation-gallery-thumbnail'
                                                                                        ]
                                                                                    ); ?>
                                                                                    <button type="button" class="variation-gallery-remove" data-image-id="<?php echo esc_attr($image_id); ?>">
                                                                                        <span class="variation-gallery-remove-btn">&times;</span>
                                                                                    </button>
                                                                                </li>
                                                                            <?php endforeach; ?>
                                                                        </ul>
                                                                        <input type="hidden" name="term_gallery_image[<?php echo esc_attr($term_id); ?>][<?php echo esc_attr($attribute_id); ?>]" id="variation-gallery-input-<?php echo esc_attr($term_id); ?>" value="<?php echo esc_attr($term_gallery_images); ?>" />
                                                                        <button type="button" class="button upload-variation-gallery-image" data-variation-id="<?php echo esc_attr($term_id); ?>"><?php esc_html_e('Upload Images', 'variation-monster'); ?></button>
                                                                    </div>

                                                                </div>
                                                                <?php
                                                            }?>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-top: 1px solid #000; margin: 20px 0; min-width: 100px"></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }

                                            // Display custom attributes
                                            if (!empty($custom_attribute_values)) {
                                                foreach ($custom_attribute_values as  $index => $custom_value) {

                                                    $custom_value_slug   = sanitize_title($custom_value);
                                                    $custom_value_id     = $index;
                                                    $tooltip_meta_custom = get_post_meta($post->ID, 'variation_meta_attribute_tooltip_' . $custom_value_slug . '_' . $attribute_id, true)

                                                    ?>
                                                    <tr style="display: flex; gap: 200px; align-items: center; justify-content: center">
                                                        <td style="min-width: 100px; font-weight: bold;"><?php echo esc_html($custom_value); ?></td>
                                                        <td>
                                                            <div class="color-meta display-typeShow-color-<?php echo esc_attr($attribute_slug); ?>" id="display-select-option-custom-color-<?php echo esc_attr($custom_value_id); ?>-<?php echo esc_attr($attribute_id); ?>" style="display: none; display: flex; gap:78px; margin-top: 10px">
                                                                <label style="font-weight:bold;"><?php esc_html_e('Color:', 'variation-monster'); ?></label>
                                                                <input type="text"
                                                                       name="variation_meta_color[<?php echo esc_attr($custom_value_slug); ?>][<?php echo esc_attr($attribute_id); ?>]"
                                                                       id="variation_meta_color_<?php echo esc_attr($custom_value_slug); ?>_<?php echo esc_attr($attribute_id); ?>"
                                                                       value="<?php echo esc_attr(get_post_meta($post->ID, 'variation_meta_attribute_color_' . $custom_value_slug . '_' . $attribute_id, true)); ?>"
                                                                       class="spectrum-color-picker" data-default-color="#ffffff">
                                                            </div>

                                                            <div class="color-meta display-typeShow-color-<?php echo esc_attr($attribute_slug); ?>" id="display-select-option-custom-secondary-color-<?php echo esc_attr($custom_value_id); ?>-<?php echo esc_attr($attribute_id); ?>" style="display: none; display: flex; gap:50px; margin-top: 10px">
                                                                <label style="font-weight:bold;"><?php esc_html_e('Secondary Color:', 'variation-monster'); ?></label>
                                                                <input type="text"
                                                                       name="variation_meta_secondary_color[<?php echo esc_attr($custom_value_slug); ?>][<?php echo esc_attr($attribute_id); ?>]"
                                                                       id="variation_meta_secondary_color_<?php echo esc_attr($custom_value_slug); ?>_<?php echo esc_attr($attribute_id); ?>"
                                                                       value="<?php echo esc_attr(get_post_meta($post->ID, 'variation_meta_attribute_secondary_color_' . $custom_value_slug . '_' . $attribute_id, true)); ?>"
                                                                       class="spectrum-color-picker" data-default-color="#ffffff">
                                                            </div>

                                                            <div class="image-meta display-typeShow-image-<?php echo esc_attr($attribute_slug); ?>" id="display-select-option-custom-image-<?php echo esc_attr($custom_value_id); ?>-<?php echo esc_attr($attribute_id); ?>" style="display: none; display: flex; gap: 50px; margin-top: 10px">
                                                                <label style="font-weight:bold;"><?php esc_html_e('Image:', 'variation-monster'); ?></label>
                                                                <div>
                                                                    <img id="meta_term_image_preview_<?php echo esc_attr($custom_value_slug); ?>"
                                                                         class="meta_term_image_preview"
                                                                         src="<?php echo esc_url(get_post_meta($post->ID, 'variation_meta_attribute_image_' . $custom_value_slug . '_' . $attribute_id, true)); ?>"
                                                                         alt="Selected Image"
                                                                         style="max-width: 70px; height: auto;">
                                                                    <input type="hidden"
                                                                           name="variation_meta_image[<?php echo esc_attr($custom_value_slug); ?>][<?php echo esc_attr($attribute_id); ?>]"
                                                                           id="meta_term_image_<?php echo esc_attr($custom_value_slug); ?>"
                                                                           class="meta_term_image"
                                                                           value="<?php echo esc_attr(get_post_meta($post->ID, 'variation_meta_attribute_image_' . $custom_value_slug . '_' . $attribute_id, true)); ?>">
                                                                    <div style="display: flex; gap: 10px;">
                                                                        <button type="button" class="button meta_upload_image_button">Upload Image</button>
                                                                        <button type="button" class="button meta_image_button_remove" style="background-color: firebrick; color: white;">Remove Image</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tooltip-meta" style="margin-top: 10px; display: flex; gap: 50px;">
                                                                <label style="font-weight:bold;"><?php esc_html_e('Tooltip:', 'variation-monster'); ?></label>
                                                                <input type="text" placeholder="Tooltip"
                                                                       name="variation_meta_tooltip[<?php echo esc_attr($custom_value_slug); ?>][<?php echo esc_attr($attribute_id); ?>]"
                                                                       id="variation_meta_tooltip_<?php echo esc_attr($custom_value_slug); ?>"
                                                                       value="<?php echo esc_attr(!empty($tooltip_meta_custom) ? $tooltip_meta_custom : $custom_value); ?>">
                                                            </div>

                                                            <div class="tooltip-image-meta" id="" style="margin-top: 44px; display: flex; gap: 50px">
                                                                <label style="font-weight:bold;"><?php esc_html_e('Tooltip Image:', 'variation-monster'); ?></label>
                                                                <div>
                                                                    <img id="tooltip_meta_term_image_preview_<?php echo esc_attr($custom_value_slug); ?>"
                                                                         class="tooltip_meta_term_image_preview"
                                                                         src="<?php echo esc_url(get_post_meta($post->ID, 'tooltip_meta_term_image_' . $custom_value_slug . '_' . $attribute_id, true)); ?>"
                                                                         alt="Selected Image"
                                                                         style="max-width: 70px; height: auto;">
                                                                    <input type="hidden"
                                                                           name="tooltip_meta_term_image[<?php echo esc_attr($custom_value_slug); ?>][<?php echo esc_attr($attribute_id); ?>]"
                                                                           id="tooltip_meta_term_image_<?php echo esc_attr($custom_value_slug); ?>"
                                                                           class="tooltip_meta_term_image"
                                                                           value="<?php echo esc_attr(get_post_meta($post->ID, 'tooltip_meta_term_image_' . $custom_value_slug . '_' . $attribute_id, true)); ?>">
                                                                    <div style="display: flex; gap: 10px;">
                                                                        <button type="button" class="button tooltip_meta_upload_image_button">Upload Image</button>
                                                                        <button type="button" class="button tooltip_meta_image_button_remove" style="background-color: firebrick; color: white;">Remove Image</button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php

                                                            if ($attributeGalleryOnOff === 'true'){
                                                                ?>
                                                                <div class="term-gallery" style="margin-top: 10px; margin-bottom: 10px;">
                                                                    <?php
                                                                    $term_gallery_images = get_post_meta($post->ID, '_term_gallery_images_' . $custom_value_slug . '_' . $attribute_id, true);
                                                                    $term_image_ids = $term_gallery_images ? explode(',', $term_gallery_images) : [];

                                                                    ?>
                                                                    <div class="form-row form-row-full" >
                                                                        <label style="font-weight:bold;"><?php esc_html_e('Gallery Image:', 'variation-monster'); ?></label>
                                                                        <ul id="gallery-container-<?php echo esc_attr($custom_value_slug); ?>" class="variation-gallery-container" style="margin-top: 5px;">
                                                                            <?php foreach ($term_image_ids as $image_id): ?>
                                                                                <li class="variation-gallery-item" data-image-id="<?php echo esc_attr($image_id); ?>">
                                                                                    <?php echo wp_get_attachment_image(
                                                                                        $image_id,
                                                                                        '',
                                                                                        false,
                                                                                        [
                                                                                            'alt'   => '',
                                                                                            'width' => '60',
                                                                                            'height' => '60',
                                                                                            'class' => 'variation-gallery-thumbnail'
                                                                                        ]
                                                                                    ); ?>
                                                                                    <button type="button" class="variation-gallery-remove" data-image-id="<?php echo esc_attr($image_id); ?>">
                                                                                        <span class="variation-gallery-remove-btn">&times;</span>
                                                                                    </button>
                                                                                </li>
                                                                            <?php endforeach; ?>
                                                                        </ul>
                                                                        <input type="hidden" name="term_gallery_image[<?php echo esc_attr($custom_value_slug); ?>][<?php echo esc_attr($attribute_id); ?>]" id="variation-gallery-input-<?php echo esc_attr($custom_value_slug); ?>" value="<?php echo esc_attr($term_gallery_images); ?>" />
                                                                        <button type="button" class="button upload-variation-gallery-image" data-variation-id="<?php echo esc_attr($custom_value_slug); ?>"><?php esc_html_e('Upload Images', 'variation-monster'); ?></button>
                                                                    </div>

                                                                </div>
                                                                <?php
                                                            } ?>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-top: 1px solid #000; margin: 20px 0; min-width: 100px"></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }

                                            if (empty($term_ids) && empty($custom_attribute_values)) {
                                                echo '<tr><td colspan="2">' . esc_html__('No attributes found for this product.', 'variation-monster') . '</td></tr>';
                                            }
                                            ?>


                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="2">' . esc_html__('No attributes found.', 'variation-monster') . '</td></tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php
    }


    /**
     * Save all data include variation gallery
     * for variation monster individual product data settings.
     *
     * @return void
     * @since 1.0.0
     */
    function save_variation_data_panel($post_id) {

        // Verify nonce
        if (!isset($_POST['product_variation_meta_box_nonce']) ||
                !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['product_variation_meta_box_nonce'])), 'product_variation_table_data_meta_box_nonce')) {
            return;
        }

        // Check if user can edit this product
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $quick_cart_carousel_meta          = isset( $_POST['_quick_cart_carousel_meta'] ) ? sanitize_text_field( wp_unslash( $_POST['_quick_cart_carousel_meta'] ) ) : '';
        $variation_list_meta               = isset( $_POST['_variation_list_meta'] ) ? sanitize_text_field( wp_unslash( $_POST['_variation_list_meta'] ) ) : '';
        $variation_swatches_meta           = isset( $_POST['_variation_swatches_meta'] ) ? sanitize_text_field( wp_unslash( $_POST['_variation_swatches_meta'] ) ) : '';
        $variation_table_meta              = isset( $_POST['_variation_table_meta'] ) ? sanitize_text_field( wp_unslash( $_POST['_variation_table_meta'] ) ) : '';
        $before_cart_variation_table_meta  = isset( $_POST['_before_cart_variation_table_meta'] ) ? sanitize_text_field( wp_unslash( $_POST['_before_cart_variation_table_meta'] ) ) : '';
        $swatches_archive_page_meta        = isset( $_POST['_variation_swatches_archive_page_meta'] ) ? sanitize_text_field( wp_unslash( $_POST['_variation_swatches_archive_page_meta'] ) ) : '';
        $attribute_display_type            = isset( $_POST['attribute_display_type'] ) ? array_map('sanitize_text_field', wp_unslash($_POST['attribute_display_type'])) : '';
        $show_attribute_archive_page       = isset( $_POST['show_attribute_archive_page'] ) ? array_map('sanitize_text_field', wp_unslash($_POST['show_attribute_archive_page'])) : '';
        $variation_meta_color              = isset( $_POST['variation_meta_color']) ? map_deep(wp_unslash($_POST['variation_meta_color']), 'sanitize_text_field') : [];
        $variation_meta_secondary_color    = isset( $_POST['variation_meta_secondary_color']) ? map_deep(wp_unslash($_POST['variation_meta_secondary_color']), 'sanitize_text_field') : [];
        $variation_meta_image              = isset( $_POST['variation_meta_image']) ? map_deep(wp_unslash($_POST['variation_meta_image']), 'sanitize_text_field') : [];
        $tooltip_meta_term_image           = isset( $_POST['tooltip_meta_term_image']) ? map_deep(wp_unslash($_POST['tooltip_meta_term_image']), 'sanitize_text_field') : [];
        $variation_meta_tooltip            = isset( $_POST['variation_meta_tooltip']) ? map_deep(wp_unslash($_POST['variation_meta_tooltip']), 'sanitize_text_field') : [];
        $term_gallery_image                = isset( $_POST['term_gallery_image']) ? map_deep(wp_unslash($_POST['term_gallery_image']), 'sanitize_text_field') : [];

        update_post_meta( $post_id, '_quick_cart_carousel_meta', $quick_cart_carousel_meta );
        update_post_meta( $post_id, '_variation_list_meta', $variation_list_meta );
        update_post_meta( $post_id, '_variation_swatches_meta', $variation_swatches_meta );
        update_post_meta( $post_id, '_variation_table_meta', $variation_table_meta );
        update_post_meta( $post_id, '_before_cart_variation_table_meta', $before_cart_variation_table_meta );
        update_post_meta( $post_id, '_variation_swatches_archive_page_meta', $swatches_archive_page_meta );


        // Save display type
        foreach ($attribute_display_type as $attribute_slug => $display_type) {
            update_post_meta($post_id, 'variation_meta_attribute_display_type_' . $attribute_slug, sanitize_text_field($display_type));
        }


        // Save show attribute into archive page
        foreach ($show_attribute_archive_page as $attribute_slug => $archive_page) {
            update_post_meta($post_id, 'show_attribute_archive_page_' . $attribute_slug, sanitize_text_field($archive_page));
        }

        // Save color meta
        foreach ($variation_meta_color as $term_id => $colors) {
            foreach ($colors as $attribute_id => $color) {
                // Skip saving if the input was disabled (i.e., value is empty)
                if (!empty($color)) {
                    update_post_meta(
                        $post_id,
                        'variation_meta_attribute_color_' . $term_id . '_' . $attribute_id,
                        sanitize_text_field($color)
                    );
                } else {
                    delete_post_meta(
                        $post_id,
                        'variation_meta_attribute_color_' . $term_id . '_' . $attribute_id
                    );
                }
            }
        }

        // Save secondary color meta
        foreach ($variation_meta_secondary_color as $term_id => $colors) {
            foreach ($colors as $attribute_id => $color) {
                update_post_meta(
                    $post_id,
                    'variation_meta_attribute_secondary_color_' . $term_id . '_' . $attribute_id,
                    sanitize_text_field($color)
                );
            }
        }


        // Save term image meta
        foreach ($variation_meta_image as $term_id => $images) {
            foreach ($images as $attribute_id => $image) {
                update_post_meta(
                    $post_id,
                    'variation_meta_attribute_image_' . $term_id . '_' . $attribute_id,
                    esc_url_raw($image)
                );
            }
        }

        // Save tooltip meta
        foreach ($variation_meta_tooltip as $term_id => $tooltips) {
            foreach ($tooltips as $attribute_id => $tooltip) {
                update_post_meta(
                    $post_id,
                    'variation_meta_attribute_tooltip_' . $term_id . '_' . $attribute_id,
                    sanitize_text_field($tooltip)
                );
            }
        }

        // Save tooltip term image meta
        foreach ($tooltip_meta_term_image as $term_id => $images) {
            foreach ($images as $attribute_id => $image) {
                update_post_meta(
                    $post_id,
                    'tooltip_meta_term_image_' . $term_id . '_' . $attribute_id,
                    esc_url_raw($image)
                );
            }
        }

        // Save term gallery images
        foreach ($term_gallery_image as $term_id => $image_ids) {
            foreach ($image_ids as $attribute_id => $image_string) {
                $image_ids_array = array_filter(explode(',', $image_string), 'is_numeric');
                $sanitized_image_ids = implode(',', $image_ids_array);
                update_post_meta($post_id, '_term_gallery_images_' . $term_id . '_' . $attribute_id, $sanitized_image_ids);
            }
        }


        // Save variation gallery images
        if (isset($_POST['variation_gallery_image'])) {

            $variation_gallery_images = array_map('sanitize_text_field', wp_unslash($_POST['variation_gallery_image']));
            $variation_gallery_nonce  = isset($_POST['variation_gallery_nonce'])
                    ? array_map('sanitize_text_field', wp_unslash($_POST['variation_gallery_nonce']))
                    : [];

            foreach ($variation_gallery_images as $variation_id => $image_ids) {

                if (!isset($variation_gallery_nonce[$variation_id]) ||
                        !wp_verify_nonce($variation_gallery_nonce[$variation_id], 'save_variation_gallery_' . $variation_id)) {
                    continue;
                }

                // Add capability check for the variation
                $variation_post = get_post($variation_id);
                if (!$variation_post) {
                    continue;
                }

                // Check if user can edit the parent product of this variation
                $parent_product_id = $variation_post->post_parent;
                if (!current_user_can('edit_post', $parent_product_id)) {
                    continue;
                }

                $image_ids_array     = array_filter(explode(',', $image_ids), 'is_numeric');
                $sanitized_image_ids = implode(',', $image_ids_array);

                update_post_meta($variation_id, '_variation_gallery_images', $sanitized_image_ids);
            }
        }
    }


    /**
     * Enqueue dokan plugin vendors styles and scripts.
     *
     * @param string $hook Page hook.
     *
     * @since 1.0.0
     * @return void
     */
    public function enqueue_dokan_integration_assets($hook) {
        wp_enqueue_media();
        wp_enqueue_script('jquery');

        wp_enqueue_style(
            'varimo-dokan-spectrum-colorpicker2',
            plugin_dir_url(dirname(__FILE__)) . 'dokan-integration/assets/varimo-dokan-spectrum.min.css',
            [],
            '2.0.0'
        );

        wp_enqueue_script(
            'varimo-dokan-spectrum-colorpicker2',
            plugin_dir_url(dirname(__FILE__)) . 'dokan-integration/assets/varimo-dokan-spectrum.min.js',
            ['jquery'],
            '2.0.0',
            true
        );

        wp_enqueue_script(
            'varimo-dokan-integration-script',
            plugin_dir_url(dirname(__FILE__)) . 'dokan-integration/assets/script.js',
            ['jquery',],
            '1.0.0',
            true
        );

        wp_enqueue_style('varimo-dokan-integration-style',
            plugin_dir_url(dirname(__FILE__)) . 'dokan-integration/assets/style.css',
            array(),
            '1.0.0'
        );

        // Initialize
        wp_add_inline_script('varimo-dokan-spectrum-colorpicker2', '
            jQuery(document).ready(function($) {
                jQuery(".spectrum-color-picker").spectrum({
                    preferredFormat: "hex",
                    showInput: true,
                    showInitial: true,
                    allowEmpty: true,
                    showAlpha: false,
                    showPalette: true,
                    palette: [
                        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
                        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
                        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
                        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
                        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
                        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
                        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
                        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
                    ],
                    change: function(color) {
                        jQuery(this).val(color ? color.toHexString() : "");
                    }
                });
            });
        ');
    }
}