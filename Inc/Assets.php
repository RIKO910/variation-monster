<?php
if (!defined('ABSPATH')) exit;
class VARIMO_Assets{

    /**
     * Define construct for enqueue all frontend script.
     *
     * @return void
     * @since 1.0.0
     */
    function __construct(){
        add_action('wp_enqueue_scripts', array($this,'varimo_enqueue_frontend_scripts'));
        // Fix for @wordpress/interactivity import map error
        add_action('init', array($this, 'varimo_fix_interactivity_import_map'), 1);
    }

    /**
     * Fix WordPress interactivity import map loading order.
     * Ensures import map is loaded before other scripts.
     *
     * @return void
     * @since 1.0.0.7
     */
    function varimo_fix_interactivity_import_map() {
        // Only apply fix if wp_script_modules function exists (WordPress 6.5+)
        if (!function_exists('wp_script_modules')) {
            return;
        }

        $script_modules = wp_script_modules();
        if (!$script_modules) {
            return;
        }

        // Remove default hooks that add import map
        remove_action('wp_head', array($script_modules, 'print_import_map'), 0);
        remove_action('wp_footer', array($script_modules, 'print_enqueued_script_modules'), 0);
        remove_action('wp_footer', array($script_modules, 'print_script_module_preloads'), 0);

        // Add custom hook to print import map early in wp_head (priority 8 ensures it loads before most scripts)
        add_action('wp_head', array($this, 'varimo_print_import_map_early'), 8);
    }

    /**
     * Print import map early in wp_head before other scripts.
     *
     * @return void
     * @since 1.0.0.7
     */
    function varimo_print_import_map_early() {
        if (!function_exists('wp_script_modules')) {
            return;
        }

        $script_modules = wp_script_modules();
        if (!$script_modules) {
            return;
        }

        $script_modules->print_import_map();
        $script_modules->print_enqueued_script_modules();
        $script_modules->print_script_module_preloads();
        echo "\r\n";
    }

    /**
     * Frontend enqueue script.
     *
     * @return void
     * @since 1.0.0
     */
    function varimo_enqueue_frontend_scripts(){

        wp_enqueue_script('jquery');

        wp_enqueue_style('varimo-variation-swatches-quick-view-css', plugin_dir_url(dirname(__FILE__)) . 'Assets/CSS/variation-swatches-quick-view.css', array(), VMONSTER_VERSION);
        wp_enqueue_style('varimo-main-css', plugin_dir_url(dirname(__FILE__)) . 'Assets/CSS/style.css', array(), VMONSTER_VERSION);
        wp_enqueue_script('varimo-custom-slick-js', plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/custom-slick.min.js',array(), VMONSTER_VERSION, true );
        wp_enqueue_script('varimo-custom-elevatezoom-js', plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/custom-elevatezoom.min.js',array(), VMONSTER_VERSION, true );
        wp_enqueue_style('varimo-all-min-font-awesome', plugin_dir_url(dirname(__FILE__)) . 'Assets/CSS/all.min.css', array(), '5.15.4');
        wp_enqueue_style('varimo-main-font-awesome-css', plugin_dir_url(dirname(__FILE__)) . 'Assets/CSS/fontawesome.min.css', array(), '5.15.4');
        wp_enqueue_script('varimo-accounting-js', plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/accounting.js',array(), VMONSTER_VERSION, true );
        wp_enqueue_script('varimo-frontend-js', plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/frontend-script.js',array(), VMONSTER_VERSION, true );
        wp_enqueue_script('varimo-variation-swatches-for-archive-page', plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/variation-swatches-for-archive-page.js',array(), VMONSTER_VERSION, true );
        wp_enqueue_script('varimo-variation-swatches-quick-view', plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/variation-swatches-quick-view.js',array(), VMONSTER_VERSION, true );
        wp_enqueue_script('varimo-variation-swatches-popup-template-four', plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/variation-swatches-popup-template-four.js',array(), VMONSTER_VERSION, true );

        $varimoVariableSetting                  = get_option('variable_all_checked', array());
        $varimoVariationSwatchesDisableSettings = isset($varimoVariableSetting['variationSwatchesDisableSettings'][0]) ? $varimoVariableSetting['variationSwatchesDisableSettings'][0] : 'not-disable';
        $varimoDisplayFlexLabelValue            = isset($varimoVariableSetting['displayFlexLabelValue']) ? $varimoVariableSetting['displayFlexLabelValue'] : '';
        $varimoTooltipPositionSwatches          = isset($varimoVariableSetting['varimoTooltipPositionSwatches']) ? $varimoVariableSetting['varimoTooltipPositionSwatches'] : 'top';
        $varimoDefaultSelectionToSelect2        = isset($varimoVariableSetting['defaultSelectionToSelect2']) ? $varimoVariableSetting['defaultSelectionToSelect2'] : '';
        $varimoShowSelectedAttribute            = isset($varimoVariableSetting['showSelectedAttribute']) ? $varimoVariableSetting['showSelectedAttribute'] : '';
        $varimoVariationLabelSeparator          = isset($varimoVariableSetting['variationLabelSeparator']) ? $varimoVariableSetting['variationLabelSeparator'] : '=';
        $varimoGenerateVariationURL             = isset($varimoVariableSetting['generateVariationURL']) ? $varimoVariableSetting['generateVariationURL'] : '';
        $varimoVariationStockInfo               = isset($varimoVariableSetting['variationStockInfo']) ? $varimoVariableSetting['variationStockInfo'] : '';
        $varimoAttributeDisplayLimitEnable      = isset($varimoVariableSetting['attributeDisplayLimitEnable']) ? $varimoVariableSetting['attributeDisplayLimitEnable'] : '';
        $varimoAttributeDisplayLimit            = isset($varimoVariableSetting['attributeDisplayLimit']) ? $varimoVariableSetting['attributeDisplayLimit'] : '5';
        $varimoFilterAttributeDisplayLimit      = isset($varimoVariableSetting['filterAttributeDisplayLimit']) ? $varimoVariableSetting['filterAttributeDisplayLimit'] : '5';

        // WooCommerce default selection to select2 attach.
        if (is_product() && $varimoDefaultSelectionToSelect2 === 'true') {

            wp_enqueue_style('varimo-select2-frontend',
                plugin_dir_url(dirname(__FILE__)) . 'Assets/CSS/varimo-select2-frontend.min.css',
                array(),
                VMONSTER_VERSION,
            );

            wp_enqueue_script('varimo-select2-frontend',
                plugin_dir_url(dirname(__FILE__)) . 'Assets/JS/varimo-select2-frontend.min.js',
                array('jquery'),
                VMONSTER_VERSION,
                true
            );

            // Load your custom script
            wp_add_inline_script('varimo-select2-frontend', '
                jQuery(document).ready(function($) {
                  if (jQuery(".variation-list-template-two").length || jQuery(".variation-list-template-one").length) {
                        return true;
                    }
                    
                    // Apply Select2 to WooCommerce variation selects
                    jQuery(".variations_form select").select2({
                        placeholder: "Select an option",
                        allowClear: true,
                        minimumResultsForSearch: 0, // always show search
                        width: "200"
                    });
                });
            ');

            wp_add_inline_style('varimo-select2-frontend', '
                .select2-container .select2-selection--single {
                    height: 42px;
                    padding: 8px 12px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    background-color: #fff;
                    font-size: 15px;
                    color: #333;
                    transition: border-color 0.3s ease;
                }
                
                
                .select2-selection__arrow {
                    display: none !important;
                }
            
            
                .select2-container--default .select2-selection--single:focus,
                .select2-container--default .select2-selection--single:hover {
                    border-color: #0071a1;
                }
            
                .select2-container--default .select2-selection--single .select2-selection__arrow {
                    height: 42px;
                    right: 8px;
                }
            
                .select2-container--default .select2-selection--single .select2-selection__rendered {
                    line-height: 26px;
                    color: #666;
                }
            
                .select2-container .select2-dropdown {
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                    font-size: 14px;
                }
            
                .select2-container .select2-search--dropdown .select2-search__field {
                    padding: 8px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    outline: none;
                }
            
                .select2-results__option--highlighted {
                    background-color: #0071a1;
                    color: #fff;
                }
            ');
        }

        wp_localize_script('varimo-frontend-js', 'quick_front_ajax_obj', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'siteUrl'  => get_site_url(),
            'nonce'    => wp_create_nonce('woocommerce_ajax_add_to_cart'),
        ));

        wp_localize_script('varimo-frontend-js', 'varimo_variation_swatches', array(
            'variationSwatchesDisableSettings' => $varimoVariationSwatchesDisableSettings,
            'displayFlexLabelValue'            => $varimoDisplayFlexLabelValue,
            'varimoTooltipPositionSwatches'    => $varimoTooltipPositionSwatches,
            'showSelectedAttribute'            => $varimoShowSelectedAttribute,
            'variationLabelSeparator'          => $varimoVariationLabelSeparator,
            'generateVariationURL'             => $varimoGenerateVariationURL,
            'variationStockInfo'               => $varimoVariationStockInfo,
            'attributeDisplayLimitEnable'      => $varimoAttributeDisplayLimitEnable,
            'attributeDisplayLimit'            => $varimoAttributeDisplayLimit,
            'filterAttributeDisplayLimit'      => $varimoFilterAttributeDisplayLimit,
        ));


        wp_enqueue_style(
            'varimo-filter-frontend',
            plugin_dir_url(dirname(__FILE__)) . 'Inc/filter-widget/assets/css/filter-frontend.css',
            array(),
            VMONSTER_VERSION
        );

        wp_enqueue_script(
            'varimo-filter-frontend',
            plugin_dir_url(dirname(__FILE__)) . 'Inc/filter-widget/assets/js/filter-frontend.js',
            array('jquery', 'wp-util'),
            VMONSTER_VERSION,
            true
        );

        wp_localize_script('varimo-filter-frontend', 'wcaf_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wcaf_nonce')
        ));

        wp_localize_script('varimo-frontend-js', 'bulk_add_to_cart_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'siteUrl'  => get_site_url(),
            'nonce'    => wp_create_nonce('varimo_bulk_add_to_cart_nonce'),
        ));

    }
}
