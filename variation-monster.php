<?php
/**
 * Plugin Name:       Variation Monster — Variation Tables, Swatches & Quick View for WooCommerce
 * Plugin URI:        http://webcartisan.com/variation-monster/
 * Description:       Boost WooCommerce variable products with advanced variation tables, quick cart, swatches & galleries for higher conversions.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            WebCartisan
 * Author URI:        http://webcartisan.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       variation-monster
 * Requires Plugins:  woocommerce
 */

if (!defined('ABSPATH')) exit;

/**
 * Declares compatibility with WooCommerce High-Performance Order Storage (HPOS).
 *
 * This function hooks into 'before_woocommerce_init' to declare that the plugin
 * is compatible with WooCommerce's custom order tables feature (HPOS).
 *
 * @since    1.0.0
 * @hook     before_woocommerce_init
 * @package  Variation Monster Pro
 *
 * @return   void
 */
add_action('before_woocommerce_init', function() {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

/**
 * Function to check for conflicting plugins and deactivate if necessary.
 *
 * @return void
 * @since 1.0.0
 */
function varimo_variation_monster_check_conflicts() {
    $conflicting_plugins = [
        'product-variation-table-with-quick-cart/product-variation-table-with-quick-cart.php',
        'product-variation-table-with-quick-cart-pro/product-variation-table-with-quick-cart-pro.php',
        'variation-monster-pro/variation-monster-pro.php',
    ];

    if (!function_exists('is_plugin_active')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    foreach ($conflicting_plugins as $plugin) {
        if (is_plugin_active($plugin)) {
            // Extract only the directory name
            $plugin_name = dirname($plugin);

            // Deactivate Variation Monster to prevent issues
            deactivate_plugins(plugin_basename(__FILE__));

            // Add an admin notice about the conflict
            add_action('admin_notices', function() use ($plugin_name) {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>
                        <strong><?php echo esc_html__('Variation Monster:', 'variation-monster'); ?></strong>
                        <?php echo esc_html__(' This plugin cannot be activated because', 'variation-monster'); ?>
                        <strong><?php echo esc_html($plugin_name); ?></strong>
                        <?php echo esc_html__(' is already active.', 'variation-monster'); ?>
                        <br><br>
                        <?php echo esc_html__('Please deactivate it first and then try again.', 'variation-monster'); ?>
                    </p>
                </div>
                <?php
            });
            return true;
        }
    }
}


// Check for conflicts before doing anything else
if (varimo_variation_monster_check_conflicts() === true){
    return;
}else{

    define("VMONSTER_VERION", '1.0.0');
    define("VMONSTER_DIR_URL", plugin_dir_url(__FILE__) );
    define("VMONSTER_DIR_PATH", plugin_dir_path(__FILE__) );

    // Include Files.
    require_once VMONSTER_DIR_PATH . "/Inc/Assets.php";
    require_once VMONSTER_DIR_PATH . "/Admin/Admin.php";
    require_once VMONSTER_DIR_PATH . "/Admin/Admin-ajax.php";
    require_once VMONSTER_DIR_PATH . "/Inc/Variable.php";
    require_once VMONSTER_DIR_PATH . "/Inc/Frontend-ajax.php";
    require_once VMONSTER_DIR_PATH . "/Inc/Dynamic-style/Dynamic-css.php";
    require_once VMONSTER_DIR_PATH . "/Inc/gallery-setup.php";
    require_once VMONSTER_DIR_PATH . "/Inc/dokan-integration/dokan-integration.php";
    /**
     * The main class for the Quick Cart & Product Variations Table (Pro).
     *
     * @since 1.0.0
     */
    final class VARIMO_Main_Class{
        /**
         * Construct the plugin instance and initialize it.
         *
         * @since 1.0.0
         */
        public function __construct(){
            $this->init();
            add_action('admin_init', array($this,'varimo_plugin_redirect'));
            add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'variation_table_quick_cart_settings_link') );
            add_filter('plugin_row_meta', array($this, 'varimo_plugin_support_link'), 10, 2);
            add_action("wp_head",[$this,"custom_css_for_oceanwp"]);
        }

        /**
         * Initializes the plugin's functionalities.
         *
         * @since 1.0.0
         */
        private function init(){
            new VARIMO_Assets();

            if (is_admin()) {
                new VARIMO_Admin();
            }

            if (!is_admin()) {
                new VARIMO_Variables();
                new VARIMO_Dynamic_Style();
                new VARIMO_Gallery_Setup();
                new VARIMO_Dokan_Integration();
            }
        }

        /**
         * Redirect to settings page on activation.
         *
         * @return void
         * @since 1.0.0
         */
        public function varimo_plugin_redirect(){
            if (get_transient('varimo_plugin_activation_redirect')) {
                delete_transient('varimo_plugin_activation_redirect');
                wp_safe_redirect(admin_url('admin.php?page=wc-settings&tab=variation-monster-setting'));
                exit;
            }
            $install_date            = get_option( 'varimo_activation_date' );
            $install_date_plus_7days = strtotime("+7 days", $install_date);
            $review_dismissed        = get_option( 'varimo_review_dismissed' );
            $now                     = strtotime( "now" );

            if ( $install_date_plus_7days <= $now && !$review_dismissed ) {
                add_action( 'admin_notices', array($this, 'varimo_display_admin_notice') );
            }
        }

        /**
         * Settings button into plugin directory.
         *
         * @return array
         * @since 1.0.0
         */
        public function variation_table_quick_cart_settings_link( $links ) {
            $action_links = array(
                'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=variation-monster-setting' ) . '" aria-label="' . esc_attr__( 'View Variation Table with Quick Cart Settings', 'variation-monster' ) . '">' . esc_html__( 'Settings', 'variation-monster' ) . '</a>',
            );

            return array_merge( $action_links, $links );
        }

        /**
         * Add a support link to the plugin details.
         *
         * @param $links, $file
         * @since 1.0.0
         */
        function varimo_plugin_support_link($links, $file) {
            if ($file === plugin_basename(__FILE__)) {
                $support_link = '<a href="https://wa.me/01926167151" target="_blank" style="color: #0073aa;">' . __('Support', 'variation-monster') . '</a>';
                $dock_link    = '<a href="http://webcartisan.com/docs/variation-monster-for-woocommerce/" target="_blank" style="color: #0073aa;">' . __('Docs', 'variation-monster') . '</a>';
                $links[] = $support_link;
                $links[] = $dock_link;
            }
            return $links;
        }

        /**
         * Notice show.
         *
         * @return void
         * @since 1.0.0
         */
        public function varimo_display_admin_notice() {
            ?>
            <div id="qvt-review-notice" class="updated qvt_review_notices">
                <span class="logo"></span>
                <ul class="right_contes">
                    <li><?php echo esc_html__('Hello! Seems like you have used Variation Monster Plugin for this website — Thanks a lot!', 'variation-monster'); ?></li>
                    <li class="button_wrap">
                        <a href="<?php echo esc_url('https://wordpress.org/plugins/variation-monster/'); ?>" type="button" class="qvt-dismiss-btn" target="_blank">
                            <i class="fas fa-check-circle"></i> <?php esc_html_e('Ok, you deserved it', 'variation-monster'); ?>
                        </a>
                        <button type="button" class="qvt-dismiss-btn">
                            <i class="fas fa-thumbs-down"></i> <?php esc_html_e('No thanks', 'variation-monster'); ?>
                        </button>
                    </li>
                </ul>
            </div>
            <?php
        }

        /*Compatible With themes*/

        public function custom_css_for_oceanwp(){
            if( wp_get_theme()->get('Name') === 'OceanWP' || wp_get_theme()->get('Name') === 'Kadence' ) {
                $custom_css = "
            body.archive.woocommerce ul.products .product {
                overflow: unset;
            }";

                wp_add_inline_style('woocommerce-general', $custom_css);
            }
        }

        /*Compatible With themes end*/
    }

    /**
     * Function to execute on activation.
     *
     * @return void
     * @since 1.0.0
     */
    function varimo_quick_variable_plugin_activate(){
        set_transient('varimo_plugin_activation_redirect', true, 30);
        $varimo_now = strtotime( "now" );
        add_option( 'quick_variable_activation_date', $varimo_now );
    }

    /**
     * Register activation hook.
     *
     * @return void
     * @since 1.0.0
     */
    register_activation_hook(__FILE__, 'varimo_quick_variable_plugin_activate');

    new VARIMO_Main_Class();

}

/**
 * Show variation gallery settings panel into
 * dokan vendor add product page and edit product page.
 *
 * @return void
 * @since 1.0.0
 */
add_action('dokan_product_after_variation_pricing', function ($loop, $variation_data, $variation){
    $gallery_images = get_post_meta($variation->ID, '_variation_gallery_images', true);
    $image_ids      = $gallery_images ? explode(',', $gallery_images) : [];
    ?>
    <div class="form-row form-row-full" style="margin-top: 10px; margin-bottom: 10px; border: 1px solid lightgrey; padding: 5px; border-radius: 5px;">
        <label style="font-weight:bold;"><?php esc_html_e('Gallery Images', 'variation-monster'); ?></label>
        <ul id="gallery-container-<?php echo esc_attr($variation->ID); ?>" class="variation-gallery-container" style="margin-top: 5px;">
            <?php foreach ($image_ids as $image_id): ?>
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
        <input type="hidden" name="variation_gallery_nonce[<?php echo esc_attr($variation->ID); ?>]" value="<?php echo esc_attr(wp_create_nonce('save_variation_gallery_' . $variation->ID)); ?>" />
        <input type="hidden" name="variation_gallery_image[<?php echo esc_attr($variation->ID); ?>]" id="variation-gallery-input-<?php echo esc_attr($variation->ID); ?>" value="<?php echo esc_attr($gallery_images); ?>" />
        <button type="button" style="margin-top:10px;" class="button upload-variation-gallery-image" data-variation-id="<?php echo esc_attr($variation->ID); ?>"><?php esc_html_e('Upload Images', 'variation-monster'); ?></button>
    </div>
    <?php
}, 10, 3);