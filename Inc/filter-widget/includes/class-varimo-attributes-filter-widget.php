<?php
if (!defined('ABSPATH')) exit;

/**
 * Filter Widget.
 *
 * @return void
 * @since 1.0.2
 */
class VARIMO_WC_Attributes_Filter_Widget extends WP_Widget {

    /**
     * Construct initialize.
     * @since 1.0.2
     */
    public function __construct() {
        parent::__construct(
            'VARIMO_WC_Attributes_Filter_Widget',
            __('WooCommerce Attributes Filter', 'variation-monster-pro'),
            array(
                'description' => __('Filter products by all available attributes.', 'variation-monster-pro'),
                'customize_selective_refresh' => true
            )
        );
    }

    /**
     * Widget initialize.
     *
     * @since 1.0.2
     * @return void
     */
    public function widget($args, $instance) {
        if (!is_shop()) {
            return;
        }

        $title           = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
        $query_type      = isset($instance['query_type']) ? $instance['query_type'] : 'and';
        $all_attributes  = VARIMO_WC_Attributes_Filter_Helper::get_all_filterable_attributes();
        $current_filters = VARIMO_WC_Attributes_Filter_Helper::get_current_filters();

        if (empty($all_attributes)) {
            return;
        }

        echo wp_kses_post($args['before_widget']);

        if ($title) {
            echo wp_kses_post($args['before_title']) . esc_html($title) . wp_kses_post($args['after_title']);
        }

        echo '<div class="varimo-filter-filters-container">';

        foreach ($all_attributes as $attribute_name => $attribute_data) {
            $this->render_attribute_filter(
                $attribute_name,
                $attribute_data['label'],
                $attribute_data['terms'],
                $current_filters,
                $query_type
            );
        }

        echo '</div>';
        echo wp_kses_post($args['after_widget']);
    }

    /**
     * Filter show in shop page.
     *
     * @since 1.0.2
     * @return void
     */
    protected function render_attribute_filter($attribute_name, $attribute_label, $terms, $current_filters, $query_type) {
        $taxonomy_name               = 'pa_' . $attribute_name;
        $variableSetting             = get_option('variable_all_checked', array());
        $imageColorWidth             = isset($variableSetting['imageColorWidth']) ? $variableSetting['imageColorWidth'] : '40';
        $imageColorHeight            = isset($variableSetting['imageColorHeight']) ? $variableSetting['imageColorHeight'] : '40';
        $imageColorBorderRadius      = isset($variableSetting['imageColorBorderRadius']) ? $variableSetting['imageColorBorderRadius'] : '50';
        $filterAttributeDisplayLimit = isset($variableSetting['filterAttributeDisplayLimit']) ? $variableSetting['filterAttributeDisplayLimit'] : '5';
        $current_values              = isset($current_filters[$attribute_name]) ? $current_filters[$attribute_name] : array();
        $attribute_id                = wc_attribute_taxonomy_id_by_name($attribute_name);
        $attribute_display_type      = get_option('wc_attribute_display_type_' . $attribute_id);
        $initial_terms_count         = $filterAttributeDisplayLimit;
        $total_terms                 = count($terms);
        $show_load_more              = $total_terms > $initial_terms_count;

        echo '<div class="varimo-filter-attribute-filter">';
        echo '<h4 class="varimo-filter-attribute-title">' . esc_html($attribute_label) . '</h4>';

        echo '<div class="varimo-filter-terms-container" data-attribute="' . esc_attr($attribute_name) . '">';

        $term_counter = 0;

        foreach ($terms as $slug => $name) {
            $term_counter++;
            $term_class = $term_counter > $initial_terms_count ? 'varimo-filter-term-hidden' : '';
            $term       = get_term_by('slug', $slug, $taxonomy_name);
            $term_id    = $term ? $term->term_id : 0;
            $checked    = in_array($slug, $current_values) ? 'checked' : '';

            echo '<div class="varimo-filter-term ' . esc_attr($term_class) . '">';

            if ('color' === $attribute_display_type) {
                $color           = $term_id ? get_term_meta($term_id, 'term_color', true) : '';
                $secondary_color = $term_id ? get_term_meta($term_id, 'term_secondary_color', true) : '';

                echo '<label class="varimo-filter-color-swatch ' . esc_attr($checked) . '">';
                echo '<input type="' . ($query_type === 'and' ? 'checkbox' : 'radio') . '" 
                      class="varimo-filter-checkbox" 
                      data-attribute="' . esc_attr($attribute_name) . '" 
                      value="' . esc_attr($slug) . '" ' . esc_attr($checked) . ' style="display:none;">';

                if ($color) {
                    if ($secondary_color) {
                        echo '<span class="varimo-filter-color-box" style="background: linear-gradient(to right, ' . esc_attr($color) . ' 50%, ' . esc_attr($secondary_color) . ' 50%); 
                              width: ' . esc_attr($imageColorWidth) . 'px; 
                              height: ' . esc_attr($imageColorHeight) . 'px;
                              border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;"></span>';
                    } else {
                        echo '<span class="varimo-filter-color-box" style="background-color: ' . esc_attr($color) . '; 
                              width: ' . esc_attr($imageColorWidth) . 'px; 
                              height: ' . esc_attr($imageColorHeight) . 'px; 
                              border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;"></span>';
                    }
                } else {
                    echo '<span class="varimo-filter-color-box" style="width: ' . esc_attr($imageColorWidth) . 'px; background: #f5f5f5;
                          height: ' . esc_attr($imageColorHeight) . 'px; display: flex; justify-content: center; align-items: center; font-size: 10px; 
                          border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;">' . esc_html($name) . '</span>';
                }
                echo '<span class="varimo-filter-color-name">' . esc_html($name) . '</span>';
                echo '</label>';

            } elseif ('image' === $attribute_display_type) {
                $image_url = $term_id ? get_term_meta($term_id, 'term_image', true) : '';

                echo '<label class="varimo-filter-image-swatch ' . esc_attr($checked) . '">';
                echo '<input type="' . ($query_type === 'and' ? 'checkbox' : 'radio') . '" 
                      class="varimo-filter-checkbox" 
                      data-attribute="' . esc_attr($attribute_name) . '" 
                      value="' . esc_attr($slug) . '" ' . esc_attr($checked) . ' style="display:none;">';

                if ($image_url) {
                    echo '<span class="varimo-filter-image-box" style="width: ' . esc_attr($imageColorWidth) . 'px; 
                          height: ' . esc_attr($imageColorHeight) . 'px; border-radius: ' . esc_attr($imageColorBorderRadius) . 'px; 
                          background-size: cover; background-position: center; 
                          background-image: url(' . esc_url($image_url) . ');"></span>';
                } else {
                    echo '<span class="varimo-filter-image-placeholder" style="width: ' . esc_attr($imageColorWidth) . 'px; 
                          height: ' . esc_attr($imageColorHeight) . 'px; border-radius: ' . esc_attr($imageColorBorderRadius) . 'px; 
                          background: #f5f5f5; display: flex; align-items: center; justify-content: center; 
                          font-size: 10px; text-align: center; overflow: hidden;">' . esc_html($name) . '</span>';
                }
                echo '<span class="varimo-filter-image-name">' . esc_html($name) . '</span>';
                echo '</label>';

            } elseif ('button' === $attribute_display_type) {
                echo '<label class="varimo-filter-button-swatch ' . esc_attr($checked) . '">';
                echo '<input type="' . ($query_type === 'and' ? 'checkbox' : 'radio') . '" 
                  class="varimo-filter-checkbox" 
                  data-attribute="' . esc_attr($attribute_name) . '" 
                  value="' . esc_attr($slug) . '" ' . esc_attr($checked) . ' style="display:none;">';

                echo '<span class="varimo-filter-button-box" style="width: ' . esc_attr($imageColorWidth) . 'px; background: #f5f5f5;
                      height: ' . esc_attr($imageColorHeight) . 'px; display: flex; justify-content: center; align-items: center; font-size: 10px; 
                      overflow: hidden; text-align: center;
                      border-radius: ' . esc_attr($imageColorBorderRadius) . 'px;">' . esc_html($name) . '</span>';
                echo '<span class="varimo-filter-image-name">' . esc_html($name) . '</span>';

                echo '</label>';

            } else {
                echo '<label class="varimo-filter-list-item ' . esc_attr($checked) . '">';
                echo '<input type="' . ($query_type === 'and' ? 'checkbox' : 'radio') . '" 
                  class="varimo-filter-checkbox" 
                  data-attribute="' . esc_attr($attribute_name) . '" 
                  value="' . esc_attr($slug) . '" ' . esc_attr($checked) . '>';
                echo '<span class="varimo-filter-term-name">' . esc_html($name) . '</span>';
                echo '</label>';
            }

            echo '</div>';
        }

        echo '</div>';

        if ($show_load_more) {
            echo '<button class="varimo-filter-load-more" data-attribute="' . esc_attr($attribute_name) . '">' . esc_html('Load More +') . '</button>';
            echo '<button class="varimo-filter-show-less" data-attribute="' . esc_attr($attribute_name) . '" style="display:none;">' . esc_html('Show Less -') . '</button>';
        }

        echo '</div>';
    }

    /**
     * Widget form.
     *
     * @since 1.0.2
     * @return void
     */
    public function form($instance) {
        $title      = isset($instance['title']) ? $instance['title'] : __('Filter Products', 'variation-monster-pro');
        $query_type = isset($instance['query_type']) ? $instance['query_type'] : 'and';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'variation-monster-pro'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('query_type')); ?>"><?php esc_html_e('Query Type:', 'variation-monster-pro'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('query_type')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('query_type')); ?>">
                <option value="and" <?php selected($query_type, 'and'); ?>><?php esc_html_e('AND - Products must match all selected filters', 'variation-monster-pro'); ?></option>
                <option value="or" <?php selected($query_type, 'or'); ?>><?php esc_html_e('OR - Products can match any selected filter', 'variation-monster-pro'); ?></option>
            </select>
        </p>
        <?php
    }

    /**
     * Update widget form.
     *
     * @since 1.0.2
     * @return array
     */
    public function update($new_instance, $old_instance) {
        $instance               = array();
        $instance['title']      = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['query_type'] = !empty($new_instance['query_type']) ? sanitize_text_field($new_instance['query_type']) : 'and';
        return $instance;
    }
}