<?php
if (!defined('ABSPATH')) exit;

global $post;
$varimoVariableSetting               = get_option('variable_all_checked', array());
$varimoQuickCartCarouselTemplateMeta = get_post_meta($post->ID, '_quick_cart_carousel_template_meta', true);
$varimoQuickCartCarouselTemplate     = isset($varimoVariableSetting['quickCartCarouselTemplate']) ? $varimoVariableSetting['quickCartCarouselTemplate'] : 'template_1';

if ($varimoQuickCartCarouselTemplateMeta === 'template_1') {
    include plugin_dir_path(__FILE__) . '../popup-templates/template_1.php';
}elseif ($varimoQuickCartCarouselTemplateMeta === 'template_2') {
    include plugin_dir_path(__FILE__) . '../popup-templates/template_2.php';
}elseif ($varimoQuickCartCarouselTemplateMeta === 'template_3') {
    include plugin_dir_path(__FILE__) . '../popup-templates/template_3.php';
}elseif ($varimoQuickCartCarouselTemplateMeta === 'template_4') {
    include plugin_dir_path(__FILE__) . '../popup-templates/template_4.php';
}elseif ($varimoQuickCartCarouselTemplateMeta === '' || $varimoQuickCartCarouselTemplateMeta === 'none') {
    if ($varimoQuickCartCarouselTemplate == 'template_1') {
        include plugin_dir_path(__FILE__) . '../popup-templates/template_1.php';
    }elseif ($varimoQuickCartCarouselTemplate == 'template_2') {
        include plugin_dir_path(__FILE__) . '../popup-templates/template_2.php';
    }elseif ($varimoQuickCartCarouselTemplate == 'template_3') {
        include plugin_dir_path(__FILE__) . '../popup-templates/template_3.php';
    }elseif ($varimoQuickCartCarouselTemplate == 'template_4') {
        include plugin_dir_path(__FILE__) . '../popup-templates/template_4.php';
    }
}

