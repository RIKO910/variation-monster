jQuery(document).ready(function () {

  
      // Handle the click event on the "Clear" link
      jQuery(document).on('click', '.reset_variations', function (e) {
        e.preventDefault();  // Prevent default WooCommerce behavior

        // Clear the selected state of custom buttons, radios, and images
        jQuery('.custom-button, .custom-image-button, .custom-color-button, input[type="radio"]').removeClass('selected');
        jQuery('.custom-button, .custom-image-button, .custom-color-button, input[type="radio"]').prop('checked', false);

        // Enable all buttons and radios after reset
        jQuery('.custom-button, .custom-image-button, .custom-color-button, input[type="radio"]')
            .prop('disabled', false)
            .css('opacity', '1')
            .removeClass('disabled-option');

        // Reset WooCommerce variation form
        jQuery('form.variations_form')[0].reset();

        // Reset the label text to "Choose an option"
        jQuery('.label').each(function () {
          let labelText = jQuery(this).text().split(varimo_variation_swatches.variationLabelSeparator)[0];  // Extract the attribute name
          jQuery(this).text(labelText + ' ');  // Reset the label
        });

        // Trigger WooCommerce events to ensure proper reset
        jQuery('form.variations_form')
            .trigger('reset_data')
            .trigger('woocommerce_variation_has_reset');
      });




  /**
   * Attribute display limit for variation swatches into single product page.
   *
   * @since 1.0.2
   * @return void
   */
  jQuery(document).ready(function($) {

    if (varimo_variation_swatches.attributeDisplayLimitEnable === 'true'){
      jQuery('.variations tr').each(function() {
        var $row = jQuery(this);
        var $swatchContainer = $row.find('.custom-wc-buttons, .custom-wc-images, .custom-wc-colors');

        if ($swatchContainer.length && !$swatchContainer.hasClass('varimo-swatches-processed')) {
          $swatchContainer.addClass('varimo-swatches-processed');
          var $swatches = $swatchContainer.find('.custom-button, .custom-image-button, .custom-color-button');

          $swatches.slice(varimo_variation_swatches.attributeDisplayLimit).hide();

          if ($swatches.length > varimo_variation_swatches.attributeDisplayLimit) {
            $swatchContainer.append(
                '<a class="varimo-load-more-swatches-attribute" style="margin-top:10px;">' +
                'Load More +' +
                '</a>'
            );

            $swatchContainer.on('click', '.varimo-load-more-swatches-attribute', function() {
              $swatches.show();
              jQuery(this).hide();
            });
          }
        }
      });
    }

  });


  /**
   * Generate URL when click attribute into single product page.
   *
   * @since 1.0.2
   * @return void
   */
 
    jQuery(document).ready(function () {
      if (varimo_variation_swatches.generateVariationURL === 'true') {
        function updateVariationURL() {
          const form = jQuery('form.variations_form');
          const attributes = {};

          form.find('.variations select, .variations input[type="radio"]:checked').each(function () {
            const name = jQuery(this).attr('name');
            const value = jQuery(this).val();
            if (name && value) {
              attributes[name] = value;
            }
          });

          const baseUrl = window.location.origin + window.location.pathname;
          const queryParams = jQuery.param(attributes);
          const newUrl = queryParams ? `${baseUrl}?${queryParams}` : baseUrl;

          window.history.replaceState({}, '', newUrl);
        }

        jQuery(document).on('click', '.custom-button, .custom-image-button, .custom-color-button, input[type="radio"]', function () {
          updateVariationURL();
        });

        jQuery(document).on('click', '.reset_variations', function () {
          const baseUrl = window.location.origin + window.location.pathname;
          window.history.replaceState({}, '', baseUrl);
        });
      }
    });
  



  /**
   * Label show dynamically into single product page.
   */

    jQuery(document).ready(function () {
      if (varimo_variation_swatches.showSelectedAttribute === 'true'){
        jQuery(document).on('click', '.custom-button, .custom-image-button, .custom-color-button', function () {
          const button        = jQuery(this);
          const container     = button.closest('tr');
          const variationName = button.data('variation-name');
          const value         = button.data('value');
          const labelName     = button.data('label-name');
          const label         = container.find('.label');

          if(varimo_variation_swatches.displayFlexLabelValue !== 'true'){
            if (button.hasClass('selected')) {
              if (label.length) {
                const attributeName = label.text().split(varimo_variation_swatches.variationLabelSeparator)[0].trim();
                label.text(attributeName + ' ' + varimo_variation_swatches.variationLabelSeparator + ' ' + labelName);
              }

              const selectBox = jQuery('select[name="' + variationName + '"]');
              if (selectBox.length) {
                selectBox.val(value).trigger('change');
              }
            }else{
              if (label.length) {
                const attributeName = label.text().split(varimo_variation_swatches.variationLabelSeparator)[0].trim();
                label.text(attributeName + ' ' );
              }
            }
          }

          jQuery('form.variations_form')
              .trigger('woocommerce_variation_select_change')
              .trigger('check_variations');
        });
      }
    });
 



  /**
   * Show tooltip for every attribute term with image and term name.
   */
  
    jQuery(document).ready(function () {
      // Create tooltip element
      let tooltip;
      const preloadedImages = {}; // Object to store preloaded images

      if (varimo_variation_swatches.varimoTooltipPositionSwatches === 'bottom') {
        tooltip = jQuery(`
            <div class="custom-tooltip">
                <div class="tooltip-text"></div>
                <div class="tooltip-image"></div>
            </div>
        `).appendTo('body');
      } else {
        tooltip = jQuery(`
            <div class="custom-tooltip">
                <div class="tooltip-image"></div>
                <div class="tooltip-text"></div>
            </div>
        `).appendTo('body');
      }

      // Preload all tooltip images
      function preloadTooltipImages() {
        jQuery('.custom-button, .custom-image-button, .custom-color-button').each(function() {
          const tooltipImage = jQuery(this).data('tooltip-image');
          if (tooltipImage && !preloadedImages[tooltipImage]) {
            const img = new Image();
            img.src = tooltipImage;
            preloadedImages[tooltipImage] = img;
          }
        });
      }

      // Call preload function immediately
      preloadTooltipImages();

      // Also preload images when any modal opens (in case elements are loaded dynamically)
      jQuery(document).on('show.bs.modal shown.bs.modal', function() {
        setTimeout(preloadTooltipImages, 100); // Small delay to ensure modal content is rendered
      });

      // Show tooltip on hover
      jQuery(document).on('mouseenter', '.custom-button, .custom-image-button, .custom-color-button', function () {
        const $this = jQuery(this);
        const tooltipText = $this.data('tooltip');
        const tooltipImage = $this.data('tooltip-image');
        const tooltipLabel = $this.data('tooltip-label');
        const tooltipBackGroundColor = $this.data('tooltip-bg-color') || '#000';
        const tooltipTextColor = $this.data('tooltip-text-color') || '#fff';

        // Clear and update content
        tooltip.find('.tooltip-image').empty();
        tooltip.find('.tooltip-text').empty();
        tooltip.removeClass('has-image');

        // Add image if available (use preloaded image if possible)
        if (tooltipImage) {
          tooltip.addClass('has-image');
          if (preloadedImages[tooltipImage]) {
            tooltip.find('.tooltip-image').html(`<img src="${tooltipImage}" >`);
          } else {
            tooltip.find('.tooltip-image').html(`<img src="${tooltipImage}" >`);
            // Cache the image for future use
            const img = new Image();
            img.src = tooltipImage;
            preloadedImages[tooltipImage] = img;
          }
        }

        // Add text if available
        if (tooltipText) {
          const finalTooltipText = tooltipLabel ? `${tooltipLabel}: ${tooltipText}` : tooltipText;
          tooltip.find('.tooltip-text').text(finalTooltipText);
        }

        // Position the tooltip
        const elementRect = this.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

        if(tooltipText){
          if (varimo_variation_swatches.varimoTooltipPositionSwatches === 'top'){
            tooltip.css({
              'background-color': tooltipBackGroundColor,
              'color': tooltipTextColor,
              'left': elementRect.left + (elementRect.width / 2) - (tooltip.outerWidth() / 2),
              'top': elementRect.top + scrollTop, // CSS transform handles vertical positioning
              'display': 'block'
            });
          }else if (varimo_variation_swatches.varimoTooltipPositionSwatches === 'bottom'){
            tooltip.css({
              'background-color': tooltipBackGroundColor,
              'color': tooltipTextColor,
              'left': elementRect.left + (elementRect.width / 2),
              'top': elementRect.bottom + scrollTop + 10, // Position below with a 10px gap
              'display': 'block',
              'transform': 'translateX(-50%)', // Center horizontally
              'margin-top': '0' // Remove top margin
            });
          }else if (varimo_variation_swatches.varimoTooltipPositionSwatches === 'left'){
            tooltip.css('display', 'block');
            const tooltipWidth = tooltip.outerWidth();

            tooltip.css({
              'background-color': tooltipBackGroundColor,
              'color': tooltipTextColor,
              'left': elementRect.left + scrollLeft - tooltipWidth - 10, // Position to the left with a 10px gap
              'top': elementRect.top + scrollTop + (elementRect.height / 2), // Center vertically
              'transform': 'translateY(-50%)', // Center vertically
              'margin-top': '0', // Remove top margin
              'margin-left': '0' // Remove left margin
            });
          }else if(varimo_variation_swatches.varimoTooltipPositionSwatches === 'right'){
            tooltip.css({
              'background-color': tooltipBackGroundColor,
              'color': tooltipTextColor,
              'left': elementRect.right + scrollLeft + 10, // Position to the right with a 10px gap
              'top': elementRect.top + scrollTop + (elementRect.height / 2), // Center vertically
              'display': 'block',
              'transform': 'translateY(-50%)', // Center vertically
              'margin-top': '0', // Remove top margin
              'margin-left': '0' // Remove left margin
            });
          }
        }
      })
          .on('mouseleave', '.custom-button, .custom-image-button, .custom-color-button', function () {
            tooltip.hide();
          });

      // For dynamic content, rerun preload when AJAX completes
      jQuery(document).ajaxComplete(function() {
        setTimeout(preloadTooltipImages, 100);
      });
    });
 

  /**
   * Shop page product main image change when click any attribute term.
   */

  // jQuery(document).ready(function($) {
  //   jQuery(document).on('mouseenter', '.custom-button, .custom-image-button, .custom-color-button', function(e) {
  //
  //     if (jQuery(this).closest('.vmonster-quick-view-modal').length) {
  //       return;
  //     }
  //     if (jQuery(this).closest('.popup-template-four-modal').length) {
  //       return;
  //     }
  //
  //     e.preventDefault();
  //     e.stopPropagation();
  //
  //     var tooltipImage = jQuery(this).data('tooltip-image');
  //
  //     if (tooltipImage) {
  //
  //       var productItem = jQuery(this).closest('.product, .product-item, li.product');
  //
  //       // Try different selectors for the main image
  //       var productImage = productItem.find('img.attachment-woocommerce_thumbnail');
  //
  //       if (productImage.length) {
  //         // Add cache-busting parameter
  //         var newImageSrc = tooltipImage + '?' + new Date().getTime();
  //
  //         // Change the image
  //         productImage.attr('src', newImageSrc);
  //
  //         // For galleries
  //         productImage.each(function() {
  //           var $img = jQuery(this);
  //           var $parent = $img.parent();
  //
  //           if ($parent.hasClass('woocommerce-product-gallery__image')) {
  //             $parent.attr('data-thumb', newImageSrc);
  //           }
  //
  //           // Some themes use data-src or other attributes
  //           $img.attr('data-src', newImageSrc);
  //           $img.attr('srcset', newImageSrc + ' 1x');
  //         });
  //
  //         // Force redraw (sometimes needed for WebKit browsers)
  //         productImage.hide().show(0);
  //       } else {
  //         console.log("No product image found - check your selectors");
  //       }
  //     }
  //   });
  // });

  jQuery(document).ready(function($) {
    const preloadedImagesMain = {};
    const productImageCache = {}; // Cache for product main images

    // Enhanced preload function
    function preloadTooltipImages() {
      jQuery('.custom-button, .custom-image-button, .custom-color-button').each(function() {
        const tooltipImage = jQuery(this).data('tooltip-image');
        if (tooltipImage && !preloadedImagesMain[tooltipImage]) {
          const img = new Image();
          img.src = tooltipImage;
          preloadedImagesMain[tooltipImage] = img;

          // Also preload the hover version immediately
          new Image().src = tooltipImage;
        }

        // Cache the product image reference for this attribute
        const productItem = jQuery(this).closest('.product, .product-item, li.product');
        if (productItem.length && !productImageCache[this]) {
          const productImage = productItem.find('img.attachment-woocommerce_thumbnail').first();
          if (productImage.length) {
            productImageCache[this] = {
              element: productImage,
              originalSrc: productImage.attr('src')
            };
          }
        }
      });
    }

    // Initial preload
    preloadTooltipImages();

    // Handle dynamic content
    jQuery(document)
        .on('show.bs.modal shown.bs.modal', preloadTooltipImages)
        .on('ajaxComplete', preloadTooltipImages);

    // Faster hover handler
    jQuery(document).on('mouseenter', '.custom-button, .custom-image-button, .custom-color-button', function(e) {
      if (jQuery(this).closest('.vmonster-quick-view-modal, .popup-template-four-modal').length) {
        return;
      }

      const tooltipImage = jQuery(this).data('tooltip-image');
      if (!tooltipImage) return;

      const cached = productImageCache[this];
      if (!cached || !cached.element) return;

      // Use the preloaded image if available
      const swapImage = preloadedImagesMain[tooltipImage] ? tooltipImage : tooltipImage;

      // Immediate swap without cache-busting (remove if you actually need it)
      cached.element
          .attr('src', swapImage)
          .attr('data-src', swapImage)
          .attr('srcset', swapImage + ' 1x');

      // Update parent if it's a gallery image
      const parent = cached.element.parent();
      if (parent.hasClass('woocommerce-product-gallery__image')) {
        parent.attr('data-thumb', swapImage);
      }
    });

    // Restore original image on mouseleave
    // jQuery(document).on('mouseleave', '.custom-button, .custom-image-button, .custom-color-button', function() {
    //   const cached = productImageCache[this];
    //   if (cached && cached.element && cached.originalSrc) {
    //     cached.element
    //         .attr('src', cached.originalSrc)
    //         .attr('data-src', cached.originalSrc)
    //         .attr('srcset', cached.originalSrc + ' 1x');
    //
    //     const parent = cached.element.parent();
    //     if (parent.hasClass('woocommerce-product-gallery__image')) {
    //       parent.attr('data-thumb', cached.originalSrc);
    //     }
    //   }
    // });
  });


  // Radio


    jQuery(document).ready(function () {
      let selectedAttributes = {};

      const customVariations = document.getElementsByClassName('custom-wc-variations');
      if (customVariations.length > 0) {
        Array.from(customVariations).forEach(function (variation) {
          const radios = variation.querySelectorAll('input[type=radio]');

          radios.forEach(function (radio) {
            radio.addEventListener('click', function (e) {
              e.preventDefault()
              const variationName = radio.getAttribute('data-variation-name');
              const selectBox = document.querySelector('select[name=' + variationName + ']');
              const selectedValue = radio.getAttribute('data-value');

              // Toggle logic for deselection
              if (radio.classList.contains('selected')) {
                radio.classList.remove('selected');
                selectBox.value = '';
                delete selectedAttributes[variationName];  // Remove attribute
              } else {
                // Deselect all other radios and select the clicked one
                radios.forEach(el => el.classList.remove('selected'));
                radio.classList.add('selected');
                selectBox.value = selectedValue;
                selectedAttributes[variationName] = selectedValue;
              }

              // Trigger WooCommerce events
              jQuery(selectBox).trigger('change');
              jQuery('form.variations_form').trigger('woocommerce_variation_select_change');
              jQuery('form.variations_form').trigger('check_variations');
            });
          });
        });
      }
    });
  


  // Color , Images and Button

/*
    jQuery(document).ready(function () {
      const selectors = ['.custom-wc-buttons', '.custom-wc-images', '.custom-wc-colors'];

        if ((!jQuery('.vmonster-quick-view-modal-content').length) && (!jQuery('.content-popup-template-four').length) && (!jQuery('.variation-monster-swatches-archive-cart').length) ){
          selectors.forEach(selector => {
              const containers = document.querySelectorAll(selector);
              containers.forEach(container => {
                  const elements = container.querySelectorAll('button');
                  elements.forEach(element => {
                      element.addEventListener('click', function () {

                          const variationName = element.getAttribute('data-variation-name');
                          const value = element.getAttribute('data-value');
                          const selectBox = document.querySelector('select[name="' + variationName + '"]');

                          if (jQuery(this).hasClass('selected')){
                              elements.forEach(el => el.classList.remove('selected'));
                              selectBox.value = '';
                              jQuery(selectBox).trigger('change');
                          }else {
                              elements.forEach(el => el.classList.remove('selected'));
                              element.classList.add('selected');
                              if (selectBox) {
                                  selectBox.value = value;
                                  jQuery(selectBox).trigger('change');
                              }
                          }

                          // Trigger WooCommerce events
                          jQuery('form.variations_form').trigger('woocommerce_variation_select_change');
                          jQuery('form.variations_form').trigger('check_variations');
                      });
                  });
              });
          });
      }
    });
*/

  // Variation Swatches End


  // Variable slide/slick script
  var $tooltip = jQuery(".quick-variable-tooltip");
  var maxQuantity;
  var variationData;


  // Variable Tooltip script
  // Tooltip Hide
  // jQuery(window).on("click", function (e) {
  //   if (
  //       !jQuery(e.target).closest($tooltip).length &&
  //       !jQuery(e.target).closest(".quick-slide-variable").length
  //   ) {
  //     clearTooltipContent();
  //   }
  // });

  //Variable Carousel

    /*

  //  Quantity decrease.

  jQuery("body").on("click",".quick-quantity-decrease", function () {
      if ((!jQuery('.vmonster-quick-view-modal-content').length) && (!jQuery('.quick-variable-tooltip').length)){
          let currentValue = parseInt(
              jQuery(this).siblings(".quick-quantity-input").val(),
              10
          );

          if (currentValue > 1) {
              // Prevent going below 1
              jQuery(this)
                  .siblings(".quick-quantity-input")
                  .val(currentValue - 1);
              jQuery(".quick-cart-notification").text("");
          }
      }
  });


  // Quantity increase.

  jQuery("body").on("click", ".quick-quantity-increase", function () {
      if ((!jQuery('.vmonster-quick-view-modal-content').length) && (!jQuery('.quick-variable-tooltip').length)){
          maxQuantity = jQuery(this)
              .siblings(".quick-quantity-input")
              .attr("data-max");
          let currentValue = parseInt(
              jQuery(this).siblings(".quick-quantity-input").val(),
              10
          );

          // For quick view need max quantity.
          if (maxQuantity === ""){
              maxQuantity = 99;
          }

          if (currentValue < maxQuantity) {
              // Prevent exceeding max limit
              jQuery(this)
                  .siblings(".quick-quantity-input")
                  .val(currentValue + 1);
              jQuery(".quick-cart-notification").text("");
          }
      }
  });

  */


  // Quantity input.

  jQuery(".quick-quantity-input").on("input", function () {
    maxQuantity = jQuery(this).attr("data-max");
    let inputValue = parseInt(jQuery(this).val());
    let quantityNotification = jQuery(this)
        .closest(".quick-quantity-container")
        .siblings(".quick-cart-notification");
    if (isNaN(inputValue) || inputValue < 1) {
      jQuery(this).val(1);
      quantityNotification.text("Quantity cannot be less than 1.");
      quantityNotification.removeClass("quick-hidden");
    } else if (inputValue > maxQuantity) {
      jQuery(this).val(maxQuantity);
      quantityNotification.text(`Quantity cannot exceed ${maxQuantity}.`);
      quantityNotification.removeClass("quick-hidden");
    } else {
      quantityNotification.addClass("quick-hidden");
    }
  });


  // Add to cart option. All add to cart here for table data.

  jQuery(document).ready(function($) {
    jQuery('body').on('click','.quick-add-to-cart', function() {
      // e.preventDefault();

      function isMobile() {
        return /Mobi|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i.test(navigator.userAgent);
      }

      var $button = jQuery(this);
      var productId = $button.data('productid');
      var variationId = $button.data('variationid');
      var quantity;

      $button.prop('disabled', true);
      $button.find('i, span').hide();

      if (!$button.hasClass('loading')) {
        $button.append('<i class="fa fa-spinner fa-spin spin-icon-remove"></i>');
      }


      if (isMobile() && ($button.closest('.mobile-variation-card').length !== 0)) {
        quantity = $button.closest('.mobile-variation-card').find('.quick-quantity-input').val();
      } else {
        quantity = $button.closest('tr').find(".quick-quantity-input").val();
      }

      var selectedAttributes = {};
      var $container = isMobile() && ($button.closest('.mobile-variation-card').length !== 0)
          ? $button.closest('.mobile-variation-card')
          : $button.closest('tr');

      $container.find('.quick-attribute-select, .quick-attribute-text').each(function () {
        var attributeKey = jQuery(this).attr('name');
        var attributeValue;

        if (jQuery(this).is('select')) {
          attributeValue = jQuery(this).val();
        } else {
          attributeValue = jQuery(this).text().trim();
        }

        if (attributeValue && attributeKey) {
          selectedAttributes[attributeKey] = attributeValue;
        }
      });



      const data = {
        'action': 'woocommerce_ajax_add_to_cart',
        'product_id': productId,
        'quantity': quantity,
        'variation_id': variationId,
        'variation': selectedAttributes,
        "_wpnonce": quick_front_ajax_obj.nonce, // Add the nonce here

      };

      $button.prop('disabled', true);
      $button.find('span').hide();

      // Perform the AJAX request
      $.post(quick_front_ajax_obj.ajax_url, data, function(response) {

        if (response.success) {
          $button.find('.spin-icon-remove').remove();
          $button.append('<span class="updated-check-add-to-cart"><i class="fa fa-check"></i></span>');

          // Show success message and reset button after 3 seconds
          setTimeout(function() {
            $button.find('.updated-check-add-to-cart').remove();
            $button.prop('disabled', false);
            $button.find('i, span').show(); // Show icon and text
          }, 2000);

          // Update cart totals and item count
          jQuery( document.body).trigger('wc_fragment_refresh');

        } else {
          $button.find('.spin-icon-remove').remove();
          console.error('Failed to add product: ', response);
          $button.prop('disabled', false);
          $button.find('i, span').show(); // Show icon and text
        }
      });
    });
  });


  // Add to cart option. All add to cart here for shop page.




  // Bulk Add to Cart in Single Product Page

 
  jQuery("body").on("click", ".bulk-add-to-cart", function (e) {
    e.preventDefault();

    let button = jQuery(this);
    let cartIcon = button.data("carticon");

    // Avoid adding another spinner if one is already present
    if (!button.hasClass('loading')) {
      // Replace the cart-plus icon with a spinner
      button.find("i.fa").remove();
      button.prepend('<i class="fa fa-spinner fa-spin"></i>');

    }

    let selectedProductID = [];
    let selectedVariationID = [];
    let selectedQuantity = [];
    let selectedAttributes = [];


    // Loop through checked checkboxes and gather their details
    jQuery("input[name='bulk_cart[]']:checked").each(function () {
      let $row = jQuery(this).closest("tr");
      let variation_id = jQuery(this).val();
      let product_id = jQuery(".bulk-add-to-cart").data("productid");

      let quantity = $row.find(".quick-quantity-input").val();
      let attributes = {};

      $row.find(".quick-attribute-select, .quick-attribute-text").each(function () {
        let attr_name = jQuery(this).attr("name");
        let attr_value = jQuery(this).is("select") ? jQuery(this).val() : jQuery(this).text().trim();
        if (attr_name && attr_value) {
          attributes[attr_name] = attr_value;
        }
      });

      selectedProductID.push({
        product_id: product_id,
      });
      selectedVariationID.push({
        variation_id: variation_id,
      });
      selectedQuantity.push({
        quantity: quantity,
      });
      selectedAttributes.push({
        attributes: attributes,
      });

    });



    // Disable button and show loading state
    button.prop('disabled', true);

    if (selectedProductID.length > 0) {
      jQuery.ajax({
        url: bulk_add_to_cart_params.ajax_url,
        type: "POST",
        data: {
          action: "bulk_add_to_cart",
          // variations: selectedVariations,
          product_id: selectedProductID,
          variation_id: selectedVariationID,
          quantity: selectedQuantity,
          arrayLength: selectedProductID.length,
          attributes: selectedAttributes,
          nonce: bulk_add_to_cart_params.nonce, // Add the nonce here
        },
        success: function (response) {
          if (response.success) {
            // Replace spinner with a check icon
            button.find("i.fa-spinner").remove();
            button.prepend('<i class="fa fa-check"></i>');

            // Restore the original cart-plus icon after a delay
            setTimeout(function () {
              button.find("i.fa-check").remove();
              button.prepend('<i class="' + cartIcon + '"></i>');
              button.prop('disabled', false);
              button.removeClass('loading');
            }, 3000);

            // Update cart totals and item count
            jQuery(document.body).trigger('wc_fragment_refresh');
          } else {
            alert(response.message || "Failed to add products to cart.");
            button.find("i.fa-spinner").remove();
            button.prepend('<i class="' + cartIcon + '"></i>');
            button.prop('disabled', false);
            button.removeClass('loading');
          }
        },
        error: function () {
          alert("An error occurred. Please try again.");
          button.find("i.fa-spinner").remove();
          button.prepend('<i class="' + cartIcon + '"></i>');
          button.prop('disabled', false);
          button.removeClass('loading');
        }
      });
    } else {
      alert("Please select at least one product.");
      button.find("i.fa-spinner").remove();
      button.prepend('<i class="' + cartIcon + '"></i>');
      button.prop('disabled', false);
      button.removeClass('loading');
    }
  });



  // Bulk Add to Cart Before Add to cart for table

  
  jQuery("body").on("click", ".bulk-add-to-cart-before-cart", function (e) {
    e.preventDefault();

    let button = jQuery(this);
    let cartIcon = button.data("carticon");

    // Avoid adding another spinner if one is already present
    if (!button.hasClass('loading')) {
      // Replace the cart-plus icon with a spinner
      button.find("i.fa").remove();
      button.prepend('<i class="fa fa-spinner fa-spin"></i>');

    }

    let selectedProductID = [];
    let selectedVariationID = [];
    let selectedQuantity = [];
    let selectedAttributes = [];


    // Loop through checked checkboxes and gather their details
    jQuery("input[name='bulk_cart_before_add_to_cart[]']:checked").each(function () {
      let $row = jQuery(this).closest("tr");
      let variation_id = jQuery(this).val();
      let product_id = jQuery(".bulk-add-to-cart-before-cart").data("productid");

      let quantity = $row.find(".quick-quantity-input").val();
      let attributes = {};

      $row.find(".quick-attribute-select, .quick-attribute-text").each(function () {
        let attr_name = jQuery(this).attr("name");
        let attr_value = jQuery(this).is("select") ? jQuery(this).val() : jQuery(this).text().trim();
        if (attr_name && attr_value) {
          attributes[attr_name] = attr_value;
        }
      });

      selectedProductID.push({
        product_id: product_id,
      });
      selectedVariationID.push({
        variation_id: variation_id,
      });
      selectedQuantity.push({
        quantity: quantity,
      });
      selectedAttributes.push({
        attributes: attributes,
      });

    });



    // Disable button and show loading state
    button.prop('disabled', true);

    if (selectedProductID.length > 0) {
      jQuery.ajax({
        url: bulk_add_to_cart_params.ajax_url,
        type: "POST",
        data: {
          action: "bulk_add_to_cart",
          // variations: selectedVariations,
          product_id: selectedProductID,
          variation_id: selectedVariationID,
          quantity: selectedQuantity,
          arrayLength: selectedProductID.length,
          attributes: selectedAttributes,
          nonce: bulk_add_to_cart_params.nonce, // Add the nonce here
        },
        success: function (response) {
          if (response.success) {
            // Replace spinner with a check icon
            button.find("i.fa-spinner").remove();
            button.prepend('<i class="fa fa-check"></i>');

            // Restore the original cart-plus icon after a delay
            setTimeout(function () {
              button.find("i.fa-check").remove();
              button.prepend('<i class="' + cartIcon + '"></i>');
              button.prop('disabled', false);
              button.removeClass('loading');
            }, 3000);

            // Update cart totals and item count
            jQuery(document.body).trigger('wc_fragment_refresh');
          } else {
            alert(response.message || "Failed to add products to cart.");
            button.find("i.fa-spinner").remove();
            button.prepend('<i class="' + cartIcon + '"></i>');
            button.prop('disabled', false);
            button.removeClass('loading');
          }
        },
        error: function () {
          alert("An error occurred. Please try again.");
          button.find("i.fa-spinner").remove();
          button.prepend('<i class="' + cartIcon + '"></i>');
          button.prop('disabled', false);
          button.removeClass('loading');
        }
      });
    } else {
      alert("Please select at least one product.");
      button.find("i.fa-spinner").remove();
      button.prepend('<i class="' + cartIcon + '"></i>');
      button.prop('disabled', false);
      button.removeClass('loading');
    }
  });


  jQuery(document).ready(function ($) {
    function replaceAddToCartIcons() {
      jQuery('.add-to-cart-icon-image-render-from-js').each(function () {
        const imageUrl = jQuery(this).data('add-to-cart-icon-image');
        if (imageUrl) {
          const imgElement = jQuery('<img>', {
            src: imageUrl,
            alt: 'Cart Icon',
            css: {
              height: '20px',
              width: '20px',
              margin: '0',
            }
          });
          jQuery(this).replaceWith(imgElement);
        }
      });
    }

    // Run on page load
    replaceAddToCartIcons();

    // Run after AJAX calls
    jQuery(document).on('ajaxComplete', function () {
      replaceAddToCartIcons();
    });
  });

  varimoVariationSwatchesTemplateFour();
  varimoSwatchesArchivePageCart();
    if ((jQuery('.vmonster-quick-view-modal-content').length) && (jQuery('.content-popup-template-four').length) && (jQuery('.variation-monster-swatches-archive-cart').length) ){
        varimoQuickViewButtonSelected();
    }
    varimoslickSliderShopPage();
});

function xxxvarimoQuickViewButtonSelected() {
    const selectors = ['.custom-wc-buttons', '.custom-wc-images', '.custom-wc-colors'];

    selectors.forEach(selector => {
        const containers = document.querySelectorAll(selector);
        containers.forEach(container => {
            const elements = container.querySelectorAll('button');
            elements.forEach(element => {
                element.addEventListener('click', function () {

                    const variationName = element.getAttribute('data-variation-name');
                    const value = element.getAttribute('data-value');
                    const selectBox = document.querySelector('select[name="' + variationName + '"]');

                    if (jQuery(this).hasClass('selected')) {
                        elements.forEach(el => el.classList.remove('selected'));
                        selectBox.value = '';
                        jQuery(selectBox).trigger('change');
                    } else {
                        elements.forEach(el => el.classList.remove('selected'));
                        element.classList.add('selected');
                        if (selectBox) {
                            selectBox.value = value;
                            jQuery(selectBox).trigger('change');
                        }
                    }

                    // Trigger WooCommerce events
                    jQuery('form.variations_form').trigger('woocommerce_variation_select_change');
                    jQuery('form.variations_form').trigger('check_variations');
                });
            });
        });
    });
}

function varimoElementSelectedUnselected(element){
  const container = jQuery(element).closest('.custom-wc-buttons, .custom-wc-images, .custom-wc-colors');
  const elements = container.find('button');

  const variationName = jQuery(element).data('variation-name');
  const value = jQuery(element).data('value');

  if (jQuery(element).hasClass('selected')) {
      elements.removeClass('selected');
  } else {
      elements.removeClass('selected');
      jQuery(element).addClass('selected');
  }
}

function varimoQuickViewButtonSelected() {
    return false
    const selectors = ['.custom-wc-buttons button', '.custom-wc-images button', '.custom-wc-colors button'];

    jQuery(selectors.join(',')).off('click.vm').on('click.vm', function () {

        const element = this;
        const container = jQuery(this).closest('.custom-wc-buttons, .custom-wc-images, .custom-wc-colors');
        const elements = container.find('button');

        const variationName = jQuery(this).data('variation-name');
        const value = jQuery(this).data('value');
        //const selectBox = jQuery(`select[name="${variationName}"]`);

        if (jQuery(this).hasClass('selected')) {
            elements.removeClass('selected');
            //selectBox.val('').trigger('change');
        } else {
            elements.removeClass('selected');
            jQuery(this).addClass('selected');
            //selectBox.val(value).trigger('change');
        }

        //jQuery('form.variations_form').trigger('woocommerce_variation_select_change');
        //jQuery('form.variations_form').trigger('check_variations');
    });
}


function varimoTemplateCloseButton(){
    clearTooltipContent();
}

function clearTooltipContent() {
    var $tooltip = jQuery(".quick-variable-tooltip");
    $tooltip.find(".quick-variable-active-image img").attr("src", "");
    $tooltip.find(".quick-variable-dots").empty();
    $tooltip.find(".quick-quantity-input").val("1");
    $tooltip.find("#variable-product-variations").html("");
    $tooltip.find(".quick-cart-notification").text("").addClass("quick-hidden");
    $tooltip.find("h4, .variable-sku, .variation_id, .variable-short-desc").text("");
    $tooltip.find("span#variable-product-price").html("");
    $tooltip.addClass("quick-hidden");
}

// Call this when the page loads

let varimotemplateallImagesPreloaded = false;
const preloadedImages = {};
jQuery(document).ready(function() {
    const $variationElements = jQuery(".quick-variable-slide [data-variation]");
    let totalImages = 0;
    let loadedImages = 0;

    $variationElements.each(function() {
        const variationData = JSON.parse(jQuery(this).attr("data-variation"));
        const galleryImages = variationData.galleryImages || [];

        galleryImages.forEach(imgSrc => {
            totalImages++;
            if (!preloadedImages[imgSrc]) {
                const img = new Image();
                img.onload = function() {
                    loadedImages++;
                    preloadedImages[imgSrc] = true;
                    if (loadedImages === totalImages) {
                        varimotemplateallImagesPreloaded = true;
                    }
                };
                img.onerror = function() {
                    loadedImages++;
                    if (loadedImages === totalImages) {
                        varimotemplateallImagesPreloaded = true;
                    }
                };
                img.src = imgSrc;
            }
        });
    });
});


function varimoQuickSlideVariable(element){
    var $this = jQuery(element);
    variationData = JSON.parse($this.attr("data-variation"));
    let hoverClick = variationData.variableClickHover;

    quickVariableDetails($this);
    varimoVariationSwatchesTemplateFour();

}

function quickVariableDetails($element) {
    const variationData = JSON.parse($element.attr("data-variation"));
    const variationId   = variationData.variationId;
    const galleryImages = variationData.galleryImages;
    const $tooltip      = $element.closest(".quick-variable-slide").siblings(".quick-variable-tooltip");
    const $cartButton   = $element.closest(".quick-variable-slide").siblings(".quick-variable-tooltip").find(".quick-add-to-cart-shop-page");
    $cartButton.attr("data-variationId", variationId);
    const quickVariableImage = variationData.VariationMainImage;


    // Hide tooltip immediately
    $tooltip.addClass("quick-hidden");

    if (varimotemplateallImagesPreloaded) {
        // If all images are preloaded, show immediately
        initializeGallery();
        $tooltip.removeClass("quick-hidden");
    } else {
        // Fallback to original loading behavior
        $tooltip.addClass('quick-loading');
        let loadedImages = 0;

        function imageLoaded() {
            loadedImages++;
            if (loadedImages === galleryImages.length) {
                $tooltip.removeClass('quick-loading');
                initializeGallery();
                $tooltip.removeClass("quick-hidden");
            }
        }

        galleryImages.forEach(imgSrc => {
            if (preloadedImages[imgSrc]) {
                imageLoaded();
            } else {
                const img = new Image();
                img.onload = imageLoaded;
                img.onerror = imageLoaded;
                img.src = imgSrc;
            }
        });
    }


    function initializeGallery() {
        // Update the gallery images, dots, and navigation buttons
        const $activeImageContainer = $tooltip.find(".quick-variable-active-image img");
        const $dotsContainer = $tooltip.find(".quick-variable-dots");
        const $prevBtn = $tooltip.find(".quick-gallery-prev");
        const $nextBtn = $tooltip.find(".quick-gallery-next");

        // Clear existing dots
        $dotsContainer.empty();

        // Reset currentIndex to 0 when switching galleries
        let currentIndex = 0;

        if (galleryImages && galleryImages.length > 0) {
            // Hide buttons if only one image
            if (galleryImages.length === 1) {
                $prevBtn.hide();
                $nextBtn.hide();
            } else {
                $prevBtn.show().prop("disabled", true); // Disable prev initially
                $nextBtn.show().prop("disabled", false); // Ensure next is enabled
            }

            // Set the first image as active
            $activeImageContainer.attr("src", galleryImages[0]);
            $activeImageContainer.attr("alt", variationData.name);

            // Create dots for each image
            galleryImages.forEach((image, index) => {
                const dot = `<div class="quick-variable-dot" data-index="${index}" style="width: 10px; height: 10px; background: ${index === 0 ? '#000' : '#ccc'}; border-radius: 50%; cursor: pointer;"></div>`;
                $dotsContainer.append(dot);
            });

            // Click event for dots
            $tooltip.find(".quick-variable-dot").on("click", function () {
                const index = jQuery(this).data("index");
                currentIndex = index;
                updateGallery(index);
            });

            // Click event for next button (mobile-friendly)
            $nextBtn.on("click touchstart", function (e) {
                e.preventDefault(); // Prevent default touch behavior (scrolling)
                if (currentIndex < galleryImages.length - 1) {
                    currentIndex++;
                    updateGallery(currentIndex);
                }
            });

            // Click event for prev button (mobile-friendly)
            $prevBtn.on("click touchstart", function (e) {
                e.preventDefault(); // Prevent default touch behavior (scrolling)
                if (currentIndex > 0) {
                    currentIndex--;
                    updateGallery(currentIndex);
                }
            });

            // Function to update gallery state
            function updateGallery(index) {
                currentIndex = index;
                $activeImageContainer.attr("src", galleryImages[index]);

                // Update dot styles
                $dotsContainer.find(".quick-variable-dot").css("background", "#ccc");
                $dotsContainer.find(`.quick-variable-dot[data-index="${index}"]`).css("background", "#000");

                // Update button states
                $prevBtn.prop("disabled", index === 0);
                $nextBtn.prop("disabled", index === galleryImages.length - 1);
            }
        }
    }



    // Add to cart start
    variationMaxQuantity = variationData.variationQuantity;
    globalMaxQuantity    = variationData.globalStockQuantity;

    maxQuantity = 99;
    if (variationMaxQuantity) {
        maxQuantity = variationMaxQuantity;
    } else if (globalMaxQuantity) {
        maxQuantity = globalMaxQuantity;
    }
    // maxQuantity = null;
    StockManage                 = variationData.variationStockManage;
    maxQuantityforCart          = 1
    globalQuantityforOutofStock = 1
    globalStockManage           = variationData.globalStockManagement;
    if (true === StockManage){
        maxQuantityforCart = variationData.variationQuantity;
    }
    if (true === globalStockManage){
        globalQuantityforOutofStock = variationData.globalStockQuantity;
    }
    out_of_stock_show = maxQuantityforCart ? maxQuantityforCart : globalQuantityforOutofStock;
    // Add to cart end
    let cartButton        = jQuery(".quick-variable-tooltip .quick-add-to-cart-shop-page");
    let stockNotification = jQuery(".quick-variable-tooltip .quick-cart-notification");
    let toolTip           = jQuery(".quick-variable-tooltip");

    if ( 0 === out_of_stock_show) {
        cartButton.addClass("quick-hidden");
        stockNotification.removeClass("quick-hidden");
        stockNotification.text("Out Of Stock");
    } else {
        cartButton.removeClass("quick-hidden");
        stockNotification.addClass("quick-hidden");
        stockNotification.text(" ");
    }

    const variations = JSON.parse($element.attr("data-variationsList"));
    let variationsOutput = "";

    Object.entries(variations).forEach(([key, data]) => {
        const options = data.options;
        const label   = data.label;

        const attributeValue = variationData.variation_set_attribute && variationData.variation_set_attribute.hasOwnProperty(key)
            ? variationData.variation_set_attribute[key]
            : "";

        if (!attributeValue) {
            variationsOutput += `<p><strong>${label}:</strong> <select class='quick-attribute-select' name='attribute_${key}' data-attribute-name='attribute_${key}'>`;
            options.forEach(option => {
                variationsOutput += `<option value="${option}">${option}</option>`;
            });
            variationsOutput += `</select></p>`;
        } else {
            variationsOutput += `<p><strong>${label}:</strong> <span class='quick-variable-title quick-attribute-text' name='attribute_${key}'>${attributeValue}</span></p>`;


            // Find all possible button types for this attribute
            const buttonSelectors = [
                `.custom-wc-buttons[data-attribute="${key}"] button.custom-button`,
                `.custom-wc-colors[data-attribute="${key}"] button.custom-color-button`,
                `.custom-wc-images[data-attribute="${key}"] button.custom-image-button`
            ].join(',');

            let buttons = toolTip.find(buttonSelectors);

            // Fallback to data-variation-name if no buttons found
            if (!buttons.length) {
                buttons = toolTip.find(`
                button.custom-button[data-variation-name="attribute_${key}"],
                button.custom-color-button[data-variation-name="attribute_${key}"],
                button.custom-image-button[data-variation-name="attribute_${key}"]
            `);
            }

            // Remove selected class from all buttons in this attribute group
            buttons.removeClass('selected');

            // Find and select the matching button
            const matchingButton = buttons.filter(function() {
                return jQuery(this).data('value') === attributeValue;
            });

            if (matchingButton.length) {
                matchingButton.addClass('selected');

                // Also update the corresponding select element if it exists
                const select = toolTip.find(`select[name="attribute_${key}"]`);
                if (select.length) {
                    select.val(attributeValue).trigger('change');
                }
            }

        }
    });

    document.querySelector("#variable-product-variations").innerHTML = variationsOutput;

    const newMetaShow   = JSON.parse($element.attr("data-newMetaShow"));
    let newMetaShowHTML = "";

    Object.entries(newMetaShow).forEach(([key, data]) => {
        const keyValue = data.keyValue;
        const label    = data.label;
        newMetaShowHTML += `<div style="display: inline-flex; align-items: center; gap: 5px"><strong class="new-meta-add-label">${label}:</strong> <p class="new-meta-add-key-value"> ${keyValue} </p> </div>`;
    });

    document.querySelector("#new-meta-data-show-for-variation").innerHTML = newMetaShowHTML;




    jQuery(document).ready(function ($) {
        // Assuming `variationURL` is dynamically available from your logic
        jQuery('.dynamic-variation-url').attr('href', variationData.variationURL || '#');
    });


    toolTip.attr("data-productId", variationData.product_id);
    toolTip.attr("data-variationId", variationData.variationId);
    toolTip.find("input.quick-quantity-input").attr("data-max", maxQuantity);
    toolTip.find("h4").text(variationData.name);
    toolTip.find("p.variable-sku").text(variationData.sku);
    toolTip.find("p.variation_id").text(variationData.variationId);
    toolTip.find("p.variable-short-desc").text(variationData.excerpt);
    toolTip.find("img.variableThumb").attr("src", quickVariableImage);
    toolTip.find("span#variable-product-price").html(variationData.variationPrice);
    toolTip.find("div#variable-product-variations").html(variationsOutput);
    toolTip.find("div#new-meta-data-show-for-variation").html(newMetaShowHTML);

    jQuery(".quick-variable-tooltip ").addClass("quick-hidden");

    $element.closest(".quick-variable-slide").siblings($tooltip).removeClass("quick-hidden");
}

function varimoAddToCartShopPageQuick(element){

    var $button = jQuery(element);
    var productId = $button.data('productid');
    var variationId = $button.attr('data-variationid');
    var quantity = $button.closest('.quick-quantity-container').find(".quick-quantity-input").val();
    var selectedAttributes = {};

    if (!variationId || variationId === "") {
        alert("Please select a product variation.");
        return;
    }

    $button.prop('disabled', true);
    $button.find('i, span').hide();

    if (!$button.hasClass('loading')) {
        $button.append('<i class="fa fa-spinner fa-spin spin-icon-remove"></i>');
    }

    // Collect selected attributes, including dropdowns and static text spans
    $button.closest('.quick-variable-tooltip').find('.quick-attribute-select, .quick-attribute-text').each(function() {
        var attributeKey = jQuery(this).attr('name'); // Get attribute name

        // If it's a dropdown, get the selected value; otherwise, get the text from the span
        var attributeValue = jQuery(this).is('select') ? jQuery(this).val() : jQuery(this).text().trim();

        if (attributeValue && attributeKey) {
            selectedAttributes[attributeKey] = attributeValue;
        }
    });

    // Verify all required attributes are selected
    var allAttributesSelected = true;
    jQuery.each(selectedAttributes, function(key, value) {
        if (value === "") {
            allAttributesSelected = false;
            alert(`Please select a value for ${key}`);
        }
    });
    if (!allAttributesSelected) return;

    // Data for AJAX request
    const data = {
        action: 'woocommerce_ajax_add_to_cart',
        product_id: productId,
        quantity: quantity,
        variation_id: variationId,  // Pass correct variation ID
        variation: selectedAttributes,
        _wpnonce: quick_front_ajax_obj.nonce, // Add the nonce here

    };

    // Disable button and show loading state
    $button.prop('disabled', true);
    $button.find('span').hide();

    // Perform AJAX request
    jQuery.post(quick_front_ajax_obj.ajax_url, data, function(response) {
        if (response.success) {
            $button.find('.spin-icon-remove').remove();
            $button.append('<span class="updated-check-add-to-cart"><i class="fa fa-check"></i></span>');
            jQuery('.shop-page-show-success-message').html(`
                <div class="success-message" style="color: ${response.color}">
                    <p>${response.message}</p>
                </div>
            `).fadeIn();

            // Hide the message after 3 seconds
            setTimeout(function () {
                $button.find('.updated-check-add-to-cart').remove();
                jQuery('.shop-page-show-success-message').fadeOut();
                $button.prop('disabled', false);
                $button.find('i, span').show(); // Show icon and text
            }, 1000);

            // Update cart totals and item count
            jQuery( document.body).trigger('wc_fragment_refresh');
        } else {
            $button.find('.spin-icon-remove').remove();
            jQuery('.shop-page-show-failed-message').html(`
                <div class="failed-message" style="color: ${response.color}">
                    <p>${response.message}</p>
                </div>
            `).fadeIn();

            // Hide the message after 3 seconds
            setTimeout(function () {
                jQuery('.shop-page-show-failed-message').fadeOut();
                $button.prop('disabled', false);
                $button.find('i, span').show();
            }, 1000);
        }
    });
}

jQuery(document).ajaxComplete(function() {
    varimoSwatchesArchivePageCart();
    if ((jQuery('.vmonster-quick-view-modal-content').length) && (jQuery('.content-popup-template-four').length) && (jQuery('.variation-monster-swatches-archive-cart').length) ){
        varimoQuickViewButtonSelected();
    }
    if ((jQuery('.quick-variable-slide').length)){
        varimoslickSliderShopPage();
    }
});


// Quantity increase.
function varimoShopPageQuantityIncrese(element){
    maxQuantity = jQuery(element)
        .siblings(".quick-quantity-input")
        .attr("data-max");
    let currentValue = parseInt(
        jQuery(element).siblings(".quick-quantity-input").val(),
        10
    );

    // For quick view need max quantity.
    if (maxQuantity === ""){
        maxQuantity = 99;
    }

    if (currentValue < maxQuantity) {
        // Prevent exceeding max limit
        jQuery(element)
            .siblings(".quick-quantity-input")
            .val(currentValue + 1);
        jQuery(".quick-cart-notification").text("");
    }
}

//  Quantity decrease.
function varimoShopPageQuantityDecrease(element){
    let currentValue = parseInt(
        jQuery(element).siblings(".quick-quantity-input").val(),
        10
    );

    if (currentValue > 1) {
        // Prevent going below 1
        jQuery(element)
            .siblings(".quick-quantity-input")
            .val(currentValue - 1);
        jQuery(".quick-cart-notification").text("");
    }
}

function varimoslickSliderShopPage() {
    let autoPlay = jQuery(".quick-variable-slide").data("autoplay");

    // Destroy existing slick instances first (if any)
    jQuery(".quick-variable-slide").each(function() {
        if (jQuery(this).hasClass('slick-initialized')) {
            jQuery(this).slick('unslick');
        }
    });

    // Now initialize slick
    jQuery(".quick-variable-slide").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: autoPlay,
        autoplaySpeed: 2000,
        arrows: true,
        prevArrow: '<button type="button" class="slick-custom-arrow slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
        nextArrow: '<button type="button" class="slick-custom-arrow slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
    });
}