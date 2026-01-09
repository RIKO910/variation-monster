// custom-attribute.js
jQuery(document).ready(function ($) {
    jQuery('.vb-variation-buttons .vb-button').on('click', function() {
        var $this = jQuery(this),
            value = $this.data('value'),
            attribute_name = $this.data('attribute_name');

        $this.addClass('selected').siblings().removeClass('selected');

        var $select = jQuery('select[name="' + attribute_name + '"]');
        $select.val(value).change();
    });
});

