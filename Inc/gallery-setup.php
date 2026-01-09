<?php
if (!defined('ABSPATH')) exit;
class VARIMO_Gallery_Setup {

    /**
     * Define Constant.
     *
     * @return void
     * @since 1.0.3
     *
     */
    public function __construct() {
        $variableSetting         = get_option('variable_all_checked', array());
        $variationGalleryOnOff   = isset($variableSetting['variationGalleryOnOff']) ? $variableSetting['variationGalleryOnOff'] : '';
        $variationSelectOnOff    = isset($variableSetting['variationSelectOnOff']) ? $variableSetting['variationSelectOnOff'] : '';
        if ($variationSelectOnOff === 'true'){
            add_action('wp_enqueue_scripts', array($this, 'dequeue_woocommerce_add_to_cart_variation_script'), 100);
        }
        if($variationGalleryOnOff === 'true'){
            add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_variation_gallery_script'));
        }
    }

    function dequeue_woocommerce_add_to_cart_variation_script() {
        global $post;
        $variationSwatchesMeta   = '';
        if (is_object($post) && isset($post->ID)) {
            $variationSwatchesMeta   = get_post_meta($post->ID, '_variation_swatches_meta', true);
        }
        if ($variationSwatchesMeta !== 'false'){
            wp_dequeue_script('wc-add-to-cart-variation');
            wp_deregister_script('wc-add-to-cart-variation');
            wp_register_script('wc-add-to-cart-variation', plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/variation-swatches.js',array(), VMONSTER_VERION, true );
            wp_enqueue_script('wc-add-to-cart-variation');
            wc_get_template( 'single-product/add-to-cart/variation.php', array(), '', WC()->plugin_path() . '/templates/' );
        }
    }

    public function enqueue_custom_variation_gallery_script() {
        $variableSetting           = get_option('variable_all_checked', array());
        $galleryStyleTemplate      = isset($variableSetting['galleryStyleTemplate']) ? $variableSetting['galleryStyleTemplate'] : 'template_1';
        $attributeGalleryImageShow = isset($variableSetting['attributeGalleryImageShow']) ? $variableSetting['attributeGalleryImageShow'] : 'large';
        $attributeGalleryOnOff     = isset($variableSetting['attributeGalleryOnOff']) ? $variableSetting['attributeGalleryOnOff'] : '';
        $galleryImageShow          = isset($variableSetting['galleryImageShow']) ? $variableSetting['galleryImageShow'] : 'large';
        $variationGalleryOnOff     = isset($variableSetting['variationGalleryOnOff']) ? $variableSetting['variationGalleryOnOff'] : '';

        if (is_product()) {
            // Ensure jQuery is loaded
            wp_enqueue_script('jquery');

            // Enqueue Slick Slider CSS and JS
            // phpcs:ignore
//            wp_enqueue_style('slick-slider-css','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css',[],'1.8.1');
            // phpcs:ignore
//            wp_enqueue_script('slick-slider-js','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js',['jquery'],'1.8.1',true);

            wp_enqueue_script('varimo-custom-slick-slider-js', plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/custom-slick-slider.min.js',array(), VMONSTER_VERION, true );


            if ($galleryStyleTemplate === 'template_1') {
                wp_enqueue_script(
                    'varimo-variation-gallery',
                    plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/varimo-variation-gallery/template1.js',
                    ['jquery', 'varimo-custom-slick-slider-js'],
                    VMONSTER_VERION,
                    true
                );

                wp_enqueue_style(
                    'varimo-variation-gallery',
                    plugin_dir_url(dirname(__FILE__)) . 'Assets/CSS/varimo-variation-gallery/template1.css',
                    [],
                    VMONSTER_VERION
                );
            }elseif ($galleryStyleTemplate === 'template_2') {
                wp_enqueue_script(
                    'varimo-variation-gallery',
                    plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/varimo-variation-gallery/template2.js',
                    ['jquery', 'varimo-custom-slick-slider-js'],
                    VMONSTER_VERION,
                    true
                );

                wp_enqueue_style(
                    'varimo-variation-gallery',
                    plugin_dir_url(dirname(__FILE__)) . 'Assets/CSS/varimo-variation-gallery/template2.css',
                    [],
                    VMONSTER_VERION
                );
            }elseif ($galleryStyleTemplate === 'template_3') {
                wp_enqueue_script(
                    'varimo-variation-gallery',
                    plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/varimo-variation-gallery/template3.js',
                    ['jquery', 'varimo-custom-slick-slider-js'],
                    VMONSTER_VERION,
                    true
                );

                wp_enqueue_style(
                    'varimo-variation-gallery',
                    plugin_dir_url(dirname(__FILE__)) . 'Assets/CSS/varimo-variation-gallery/template3.css',
                    [],
                    VMONSTER_VERION
                );
            }elseif ($galleryStyleTemplate === 'template_4') {
                wp_enqueue_script(
                    'varimo-variation-gallery',
                    plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/varimo-variation-gallery/template4.js',
                    ['jquery', 'varimo-custom-slick-slider-js'],
                    VMONSTER_VERION,
                    true
                );

                wp_enqueue_style(
                    'varimo-variation-gallery',
                    plugin_dir_url(dirname(__FILE__)) . 'Assets/CSS/varimo-variation-gallery/template4.css',
                    [],
                    VMONSTER_VERION
                );
            }elseif ($galleryStyleTemplate === 'template_5') {
                wp_enqueue_script(
                    'varimo-variation-gallery',
                    plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/varimo-variation-gallery/template5.js',
                    ['jquery', 'varimo-custom-slick-slider-js'],
                    VMONSTER_VERION,
                    true
                );

                wp_enqueue_style(
                    'varimo-variation-gallery',
                    plugin_dir_url(dirname(__FILE__)) . 'Assets/CSS/varimo-variation-gallery/template5.css',
                    [],
                    VMONSTER_VERION
                );
            }

            global $product;

            $varimo_product = null;

            if (!is_a($product, 'WC_Product')) {
                $varimo_product = wc_get_product(get_the_ID());
            }else{
                $varimo_product = $product;
            }

            if ($varimo_product) {

                $product_id        = $varimo_product->get_id();
                $attachment_ids    = $varimo_product->get_gallery_image_ids();
                $featured_image_id = get_post_thumbnail_id($product_id);
                $attributes        = $varimo_product->get_attributes();
                $term_gallery_data = [];
                $variation_gallery_data = [];

                // Variation Gallery Start.

                $variation_ids = [];
                if ($varimo_product->is_type('variable')) {
                    $variation_ids = $varimo_product->get_children();
                }

                foreach ($variation_ids as $variation_id) {
                    $variation_image_ids         = [];
                    $variation_image_id_featured = [];
                    $Variation_gallery_images    = get_post_meta($variation_id, '_variation_gallery_images', true);
                    $variation_featured_image_id = get_post_thumbnail_id($variation_id);

                    if ($variationGalleryOnOff === 'true'){

                        if ($variation_featured_image_id) {
                            $variation_image_id_featured[] = $variation_featured_image_id;
                        }

                        if ($Variation_gallery_images){
                            $variation_image_ids = explode(',', $Variation_gallery_images);
                            $variation_image_ids = array_merge($variation_image_id_featured, $variation_image_ids);
                        }

                        if (empty($variation_image_ids)) {
                            if ($variation_featured_image_id) {
                                $variation_image_ids[] = $variation_featured_image_id;
                            }
                        }
                    }

                    /*
                    if (!$variation_image_ids || is_wp_error($variation_image_ids)) {
                        if ($featured_image_id) {
                            array_unshift($attachment_ids, $featured_image_id);
                        }
                        $variation_image_ids = $attachment_ids;
                     }
                    */

                    if (!empty($variation_image_ids)) {
                        foreach ($variation_image_ids as $variation_image_id) {
                            $image_url = wp_get_attachment_image_src($variation_image_id, $galleryImageShow)[0];
                            $thumb_url = wp_get_attachment_image_src($variation_image_id, 'thumbnail')[0];

                            if (!isset($variation_gallery_data[$variation_id])) {
                                $variation_gallery_data[$variation_id] = [];
                            }

                            $variation_gallery_data[$variation_id][] = [
                                'src' => esc_url($image_url),
                                'thumb' => esc_url($thumb_url),
                            ];
                        }
                    }

                }

                // Variation Gallery End.

                // Term Gallery Start.
                foreach ($attributes as $attribute_name => $attribute) {
                    if ($attribute->is_taxonomy()) {
                        $taxonomy = $attribute->get_name();
                        $terms    = wp_get_post_terms($product_id, $taxonomy);

                        foreach ($terms as $term) {
                            $term_image_ids = [];
                            $attribute_id = $attribute->get_id();
                            $term_gallery_images = get_post_meta($product_id, '_term_gallery_images_' . $term->term_id . '_' . $attribute_id, true);

                            if ($attributeGalleryOnOff === 'true') {
                                $term_image_ids = $term_gallery_images ? explode(',', $term_gallery_images) : [];
                            }

                            /*
                            if (!$term_image_ids || is_wp_error($term_image_ids)) {
                                $term_image_ids = $attachment_ids;
                                if ($featured_image_id && !in_array($featured_image_id, $term_image_ids)) {
                                    array_unshift($term_image_ids, $featured_image_id);
                                }
                            }
                            */

                            if (!empty($term_image_ids)) {
                                foreach ($term_image_ids as $term_image_id) {
                                    $image_url = wp_get_attachment_image_src($term_image_id, $attributeGalleryImageShow)[0];
                                    $thumb_url = wp_get_attachment_image_src($term_image_id, 'thumbnail')[0];

                                    if (!isset($term_gallery_data[$term->slug])) {
                                        $term_gallery_data[$term->slug] = [];
                                    }

                                    $term_gallery_data[$term->slug][] = [
                                        'src'   => esc_url($image_url),
                                        'thumb' => esc_url($thumb_url),
                                    ];
                                }
                            }
                        }
                    } else {
                        $options = $attribute->get_options();

                        foreach ($options as $option) {
                            $term_image_ids = [];
                            $term_slug = sanitize_title($option);
                            $attribute_id = 0;
                            $term_gallery_images = get_post_meta($product_id, '_term_gallery_images_' . $term_slug . '_' . $attribute_id, true);

                            if ($attributeGalleryOnOff === 'true') {
                                $term_image_ids = $term_gallery_images ? explode(',', $term_gallery_images) : [];
                            }

                            /*
                            if (!$term_image_ids || is_wp_error($term_image_ids)) {
                                $term_image_ids = $attachment_ids;
                                if ($featured_image_id && !in_array($featured_image_id, $term_image_ids)) {
                                    array_unshift($term_image_ids, $featured_image_id);
                                }
                            }
                            */

                            if (!empty($term_image_ids)) {
                                foreach ($term_image_ids as $term_image_id) {
                                    $image_url = wp_get_attachment_image_src($term_image_id, $attributeGalleryImageShow)[0];
                                    $thumb_url = wp_get_attachment_image_src($term_image_id, 'thumbnail')[0];

                                    if (!isset($term_gallery_data[$term_slug])) {
                                        $term_gallery_data[$term_slug] = [];
                                    }

                                    $term_gallery_data[$term_slug][] = [
                                        'src'   => esc_url($image_url),
                                        'thumb' => esc_url($thumb_url),
                                    ];
                                }
                            }
                        }
                    }
                }
                // Term Gallery End

                // Default Gallery Start
                $default_attachment_ids    = $varimo_product->get_gallery_image_ids();
                $default_featured_image_id = get_post_thumbnail_id($product_id);

                if ($default_featured_image_id) {
                    array_unshift($default_attachment_ids, $default_featured_image_id);
                }

                $default_gallery_data = [];

                if (!empty($default_attachment_ids)) {
                    foreach ($default_attachment_ids as $default_image_id) {
                        $image_url = wp_get_attachment_image_src($default_image_id, $attributeGalleryImageShow)[0];
                        $thumb_url = wp_get_attachment_image_src($default_image_id, 'thumbnail')[0];

                        $default_gallery_data[] = [
                            'src'   => esc_url($image_url),
                            'thumb' => esc_url($thumb_url),
                        ];
                    }
                }
                // Default Gallery End

                // Localize the script
                wp_localize_script('varimo-variation-gallery', 'variation_table_ajax_localization', [
                    'ajax_url'               => admin_url('admin-ajax.php'),
                    'default_gallery_data'   => $default_gallery_data,
                    'term_gallery_data'      => json_encode($term_gallery_data),
                    'variation_gallery_data' => json_encode($variation_gallery_data),
                ]);
            }
        }
    }
}
