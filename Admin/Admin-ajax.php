<?php
if (!defined('ABSPATH')) exit;

add_action('wp_ajax_varimo_admin_dashboard_ajax', 'varimo_admin_dashboard_ajax');

function varimo_admin_dashboard_ajax() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized', 403);
    }
    // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
    if (!isset($_POST['nonce'])) {
        wp_send_json_error('Nonce is missing', 403);
        wp_die();
    }

    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'quick_admin_nonce_action')) {
        wp_send_json_error('Invalid nonce', 403);
        wp_die();
    }

    // Check if the data is being sent

    if (isset($_POST['identifier'])) {

        $identifier = sanitize_text_field(wp_unslash($_POST['identifier']));
    }


    if (isset($identifier) && ($identifier) == "adminSetting") {
        if (isset($_POST['variable_data']) && !empty($_POST['variable_data'])) {
            $jsonData = sanitize_text_field(wp_unslash($_POST['variable_data']));

            // Decode the JSON data
            $dataArray = json_decode($jsonData, true);

            // Check for JSON errors
            if (json_last_error() === JSON_ERROR_NONE) {
                $storeVariableFields = update_option('variable_all_checked', $dataArray);
                if ($storeVariableFields) {
                    echo "true";
                } else {
                    echo "false";
                }
            } else {
                echo "false"; 
            }
        } else {
            echo "false"; 
        }
    }
    wp_die(); 
}
