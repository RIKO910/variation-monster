<?php
if (!defined('ABSPATH')) exit;

/**
 * Widget filter help
 *
 * @since 1.0.2
 */
class VARIMO_WC_Attributes_Filter_Helper {

    /**
     * Get all filterable attributes with their terms
     *
     * @since 1.0.2
     * @return array
     */
    public static function get_all_filterable_attributes() {
        $attributes = array();
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if (empty($attribute_taxonomies)) {
            // Fallback: Get attributes directly from database
            global $wpdb;
            // phpcs:ignore
            $attribute_taxonomies = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}woocommerce_attribute_taxonomies"));
        }

        foreach ((array)$attribute_taxonomies as $tax) {
            $tax = (object)$tax;
            $attribute_name = isset($tax->attribute_name) ? $tax->attribute_name : '';

            if ($attribute_name) {
                $attribute_label = isset($tax->attribute_label) ? $tax->attribute_label : $attribute_name;
                $terms = self::get_attribute_values($attribute_name);

                if (!empty($terms)) {
                    $attributes[$attribute_name] = array(
                        'label' => $attribute_label,
                        'terms' => $terms
                    );
                }
            }
        }

        return $attributes;
    }

    /**
     * Get terms for a specific attribute.
     *
     * @return array
     * @since 1.0.2
     */
    public static function get_attribute_values($attribute_name) {
        $terms = get_terms(array(
            'taxonomy' => 'pa_' . $attribute_name,
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC'
        ));

        $values = array();

        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms as $term) {
                $values[$term->slug] = $term->name;
            }
        }

        return $values;
    }

    /**
     * Get currently active filters from URL.
     *
     * @return array
     * @since 1.0.2
     */
    public static function get_current_filters() {
        $filters = array();

        // phpcs:ignore
        foreach ($_GET as $key => $value) {
            if (strpos($key, 'filter_') === 0) {
                $attribute = str_replace('filter_', '', $key);
                $filters[$attribute] = array_filter(explode(',', $value)); // nosemgrep
            }
        }

        return $filters;
    }

    /**
     * Apply filters to product query
     *
     * @since 1.0.2
     * @return mixed
     */
    public static function filter_products_query($query_args, $filters) {
        if (empty($filters)) {
            return $query_args;
        }

        $tax_query = isset($query_args['tax_query']) ? $query_args['tax_query'] : array();

        foreach ($filters as $attribute => $values) {
            if (!empty($values)) {
                $tax_query[] = array(
                    'taxonomy' => 'pa_' . $attribute,
                    'field'    => 'slug',
                    'terms'    => $values,
                    'operator' => 'IN',
                    'include_children' => false
                );
            }
        }

        if (!empty($tax_query)) {
            $tax_query['relation'] = 'AND';
            // phpcs:ignore
            $query_args['tax_query'] = $tax_query;
        }

        // CRITICAL: Ensure we only get main products, not variations
        $query_args['post_parent'] = 0;

        // Add meta query to exclude variations more explicitly
        $meta_query = isset($query_args['meta_query']) ? $query_args['meta_query'] : array();
        $meta_query[] = array(
            'key' => '_visibility',
            'value' => array('catalog', 'visible'),
            'compare' => 'IN'
        );
        // phpcs:ignore
        $query_args['meta_query'] = $meta_query;

        return $query_args;
    }


    /**
     * Generate filter URL with multiple attributes
     *
     * @since 1.0.2
     * @return false | mixed | string
     */
    public static function build_filter_url($base_url, $filters) {
        foreach ($filters as $attribute => $values) {
            $filter_name = 'filter_' . $attribute;
            if (!empty($values)) {
                $base_url = add_query_arg($filter_name, implode(',', $values), $base_url);
            } else {
                $base_url = remove_query_arg($filter_name, $base_url);
            }
        }
        return $base_url;
    }
}