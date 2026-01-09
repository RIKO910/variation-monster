;(function($) {
    jQuery(document).ready(function() {

        jQuery(document).ready(function() {

            // Store all preloaded images
            const preloadedImages = {};
            let allImagesPreloaded = false;
            let currentSliderInstance = null; // Track current slider instance

            /**
             * Preload all variation and term images
             */
            function preloadAllGalleryImages() {
                const default_gallery_data = variation_table_ajax_localization.default_gallery_data;
                const variation_gallery_data = JSON.parse(variation_table_ajax_localization.variation_gallery_data);
                const term_gallery_data = JSON.parse(variation_table_ajax_localization.term_gallery_data);

                let totalImages = 0;
                let loadedImages = 0;

                // Function to preload a single image
                function preloadImage(src) {
                    return new Promise((resolve) => {
                        if (preloadedImages[src]) {
                            resolve();
                            return;
                        }

                        const img = new Image();
                        img.onload = function() {
                            preloadedImages[src] = true;
                            loadedImages++;
                            resolve();
                        };
                        img.onerror = function() {
                            loadedImages++;
                            resolve();
                        };
                        img.src = src;
                    });
                }

                // Preload default gallery images
                default_gallery_data.forEach(image => {
                    totalImages++;
                    preloadImage(image.src);
                });

                // Preload variation gallery images
                Object.values(variation_gallery_data).forEach(gallery => {
                    gallery.forEach(image => {
                        totalImages++;
                        preloadImage(image.src);
                    });
                });

                // Preload term gallery images
                Object.values(term_gallery_data).forEach(gallery => {
                    gallery.forEach(image => {
                        totalImages++;
                        preloadImage(image.src);
                    });
                });

                // Track when all images are loaded
                const checkLoading = setInterval(() => {
                    if (loadedImages >= totalImages) {
                        allImagesPreloaded = true;
                        clearInterval(checkLoading);
                        console.log('All gallery images preloaded');
                    }
                }, 100);
            }

            /**
             * Call preloading on document ready
             */
            preloadAllGalleryImages();

            /**
             * Initialize gallery
             */
            function initializeGallery() {
                const default_gallery_data = variation_table_ajax_localization.default_gallery_data;
                ajaxCallGallery(default_gallery_data);
            }

            /**
             * Smooth update gallery without rebuilding
             */
            function updateGalleryImages(allImages) {

                const $mainSlider      = jQuery('.variation-gallery-slider-main');
                const $thumbnailSlider = jQuery('.variation-gallery-slider-thumbnails');
                const galleryContainer = jQuery('.woocommerce-product-gallery');

                // Store current height
                const currentHeight = galleryContainer.height();
                galleryContainer.css('min-height', currentHeight + 'px');

                // Get current slide index
                const currentSlide = $mainSlider.slick('slickCurrentSlide');

                // Remove all slides
                $mainSlider.slick('unslick');
                $thumbnailSlider.slick('unslick');

                // Clear existing slides
                $mainSlider.empty();
                $thumbnailSlider.empty();

                // Add new slides
                allImages.forEach(function(image, index) {
                    const mainSlideHtml = `<div class="gallery-slide">
                                <div class="image-container">
                                    <img src="${image.src}" alt="Product Image">
                                </div>
                            </div>`;

                    const thumbnailSlideHtml = `<div class="gallery-thumbnail">
                                    <img src="${image.src}" alt="Thumbnail ${index + 1}">
                                </div>`;

                    $mainSlider.append(mainSlideHtml);
                    $thumbnailSlider.append(thumbnailSlideHtml);
                });

                // Reinitialize sliders
                initializeSlickSliders();

                // Go to first slide
                $mainSlider.slick('slickGoTo', 0, true);

                // In your updateGalleryImages function:
                const placeholderHtml = createImagePlaceholder(600, 600); // Adjust dimensions as needed
                $mainSlider.slick('slickAdd', `<div class="gallery-slide">${placeholderHtml}</div>`);

                // Fade back in
                setTimeout(() => {
                    galleryContainer.css('min-height', '');
                }, 300);

                // Reinitialize zoom and lightbox
                setTimeout(() => {
                    initializeZoomEffect();
                    reinitializeWooCommerceLightbox(allImages.map(img => ({
                        src: img.src,
                        w: 1200,
                        h: 1200
                    })));
                }, 500);
            }

            function createImagePlaceholder(width, height) {
                return `
                    <div class="image-placeholder" style="
                        width: ${width}px;
                        height: ${height}px;
                        background: #f5f5f5;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>
                `;
            }

            /**
             * Variation gallery, term gallery - Enhanced with smooth transitions
             */
            function ajaxCallGallery(allImages, useSmootTransition = false) {

                // Store current height before making any changes
                const galleryContainer = jQuery('.woocommerce-product-gallery');
                const currentHeight = galleryContainer.height();
                galleryContainer.css('min-height', currentHeight + 'px');

                // If smooth transition is requested and sliders exist, use update method
                if (useSmootTransition && jQuery('.variation-gallery-slider-main').hasClass('slick-initialized')) {
                    updateGalleryImages(allImages);
                    return;
                }

                setTimeout(function() {
                    var afterAllImages = [];

                    allImages.forEach(function(image) {
                        afterAllImages.push({
                            src: image.src,
                            thumb: image.thumb,
                            w: 1200,
                            h: 1200
                        });
                    });

                    galleryContainer.css('min-height', '');

                    // Main Slider HTML
                    var mainSliderHtml = '<div class="variation-gallery-slider-main">';
                    // Thumbnail Slider HTML
                    var thumbnailSliderHtml = '<div class="variation-gallery-slider-thumbnails">';
                    var lightBoxHtml = '<div class="lightbox-container">';

                    afterAllImages.forEach(function (image, index) {
                        mainSliderHtml += `<div class="gallery-slide">
                                                <div class="image-container">
                                                     <img src="${image.src}" alt="Product Image">
                                                </div>
                                            </div>`;

                        thumbnailSliderHtml += `<div class="gallery-thumbnail">
                                                    <img src="${image.src}" alt="Thumbnail ${index + 1}">
                                                </div>`;
                        // lightBoxHtml container
                        lightBoxHtml += `<button role="button" class="lightbox-button" aria-haspopup="dialog" aria-label="View full-screen image gallery">
                                           <i class="fas fa-search-plus lightbox-icon"></i>
                                        </button>`;
                    });

                    mainSliderHtml += '</div>';
                    thumbnailSliderHtml += '</div>';
                    lightBoxHtml += '</div>';

                    var flexContainer = '<div class="gallery-flex-container">' + lightBoxHtml + thumbnailSliderHtml + mainSliderHtml + '</div>';

                    // Destroy existing slick instances before rebuilding
                    if (jQuery('.variation-gallery-slider-main').hasClass('slick-initialized')) {
                        jQuery('.variation-gallery-slider-main').slick('destroy');
                    }
                    if (jQuery('.variation-gallery-slider-thumbnails').hasClass('slick-initialized')) {
                        jQuery('.variation-gallery-slider-thumbnails').slick('destroy');
                    }

                    // Insert the flex container into the gallery container
                    galleryContainer.html(flexContainer);

                    // Wait for DOM to be ready before initializing sliders
                    setTimeout(() => {
                        initializeSlickSliders();

                        // Force visibility of main images after slider initialization
                        jQuery('.variation-gallery-slider-main .slick-slide').css('opacity', '1');
                        jQuery('.variation-gallery-slider-main').css('opacity', '1');

                        initializeZoomEffect();
                        jQuery('.variation-gallery-slider-main').on('afterChange', function(event, slick, currentSlide) {
                            initializeZoomEffect();
                        });

                        reinitializeWooCommerceLightbox(afterAllImages);

                        // Remove min-height constraint
                        galleryContainer.css('min-height', '');

                        // Hide spinner immediately if images are preloaded
                        if (allImagesPreloaded) {
                            if (document.querySelector('.spinner-container')) {
                                document.querySelector('.spinner-container').style.display = 'none';
                            }
                            jQuery(".woocommerce-product-gallery").css("opacity", "1");
                        }

                        // Special handling for single image
                        if (allImages.length === 1) {
                            jQuery('.variation-gallery-slider-main .slick-track').css({
                                'width': '375px',
                                'min-width': '375px'
                            });
                            jQuery('.variation-gallery-slider-main .slick-slide').css({
                                'width': '375px !important',
                                'min-width': '375px !important',
                                'opacity': '1 !important'
                            });
                            jQuery('.variation-gallery-slider-main .gallery-slide').css({
                                'width': '375px !important',
                                'min-width': '375px !important'
                            });
                        }
                    }, 50);

                }, 0);
            }

            /**
             * Slick Slider Initialize
             */
            function initializeSlickSliders() {
                var thumbnailSliderHeight = jQuery('.variation-gallery-slider-thumbnails').height();
                var thumbnailHeight = jQuery('.variation-gallery-slider-thumbnails .gallery-thumbnail').outerHeight(true);
                var slidesToShow = Math.floor(thumbnailSliderHeight / thumbnailHeight);

                // Initialize Main Slider
                jQuery('.variation-gallery-slider-main').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    fade: false,
                    asNavFor: '.variation-gallery-slider-thumbnails',
                    prevArrow: '',
                    nextArrow: '',
                    infinite: true,
                    speed: 400,
                    cssEase: 'ease-in-out',
                    adaptiveHeight: true,
                });

                // Ensure first slide is visible after initialization
                setTimeout(() => {
                    jQuery('.variation-gallery-slider-main .slick-slide').css('opacity', '1');
                    jQuery('.variation-gallery-slider-main .slick-active').css('opacity', '1');
                }, 100);

                // Initialize Thumbnail Slider (horizontal)
                jQuery('.variation-gallery-slider-thumbnails').slick({
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    asNavFor: '.variation-gallery-slider-main',
                    dots: false,
                    arrows: false,
                    focusOnSelect: true,
                    vertical: false, // Remove vertical mode
                    verticalSwiping: false, // Remove vertical swiping
                    centerMode: false,
                    variableWidth: false,
                    speed: 300,
                    cssEase: 'ease-in-out',
                });

                jQuery('.variation-gallery-slider-thumbnails').on('afterChange', function(event, slick, currentSlide) {
                    // Remove the `slick-current` class from all thumbnails
                    jQuery('.variation-gallery-slider-thumbnails .gallery-thumbnail').removeClass('slick-current');

                    // Find the original slide (not the cloned one) and add the `slick-current` class
                    jQuery('.variation-gallery-slider-thumbnails .gallery-thumbnail').each(function() {
                        var slideIndex = jQuery(this).data('slick-index');
                        if (slideIndex === currentSlide) {
                            jQuery(this).addClass('slick-current');
                        }
                    });
                });

                // Store current slider instance
                currentSliderInstance = jQuery('.variation-gallery-slider-main').slick('getSlick');

            }

            /**
             * Initialize Zoom Effect
             */
            function initializeZoomEffect() {
                // Remove any existing zoom instance
                jQuery('.variation-gallery-slider-main img').each(function () {
                    jQuery(this).removeData('elevateZoom');
                    jQuery('.zoomContainer').remove();
                });

                // Apply zoom to the currently active slide
                jQuery('.variation-gallery-slider-main .slick-current img').each(function () {
                    var zoomImageUrl = jQuery(this).attr('src');

                    jQuery(this).elevateZoom({
                        zoomType: "inner",
                        scrollZoom: true,
                        zoomWindowFadeIn: 500,
                        zoomWindowFadeOut: 500,
                        cursor: "crosshair"
                    });
                });
            }

            /**
             * Woocommerce default lightbox.
             */
            function reinitializeWooCommerceLightbox(allImages) {
                // Ensure WooCommerce's built-in gallery is refreshed
                if (typeof wc_product_gallery !== 'undefined') {
                    jQuery('.woocommerce-product-gallery').each(function () {
                        jQuery(this).wc_product_gallery();
                    });
                }

                // Remove previous event handlers to prevent duplicate binding
                jQuery('.lightbox-button').off('click');

                // Fetch image dimensions
                Promise.all(allImages.map(function(image) {
                    return getImageDimensions(image.src).then(function(dimensions) {
                        return {
                            src: image.src,
                            w: dimensions.w,
                            h: dimensions.h
                        };
                    });
                })).then(function(pswpItems) {
                    // Attach PhotoSwipe event handler
                    jQuery('.lightbox-button').on('click', function(event) {
                        event.preventDefault();

                        var currentSlide = jQuery('.variation-gallery-slider-main').slick('slickCurrentSlide');

                        // Initialize PhotoSwipe
                        var pswpElement = document.querySelectorAll('.pswp')[0];
                        var options = {
                            index: currentSlide,
                            bgOpacity: 0.7,
                            showHideOpacity: true,
                            closeOnScroll: false,
                            getThumbBoundsFn: function(index) {
                                var thumbnail = document.querySelectorAll('.variation-gallery-slider-main img')[index];
                                var pageYScroll = window.pageYOffset || document.documentElement.scrollTop;
                                var rect = thumbnail.getBoundingClientRect();
                                return { x: rect.left, y: rect.top + pageYScroll, w: rect.width };
                            }
                        };

                        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, pswpItems, options);
                        gallery.init();

                        // Cleanup on close
                        gallery.listen('close', function() {
                            document.querySelector('.pswp--open').style.display = 'none !important';

                            pswpElement.style.display = 'none';
                            setTimeout(() => {
                                pswpElement.style.display = '';
                            }, 10);

                            pswpElement.className = 'pswp';

                            const observer = new MutationObserver(mutations => {
                                mutations.forEach(mutation => {
                                    console.log('Class changed:', mutation.target.classList);
                                });
                            });

                            observer.observe(pswpElement, { attributes: true, attributeFilter: ['class'] });

                        });
                    });
                }).catch(function(error) {
                    console.error('Failed to load image dimensions:', error);
                });
            }

            /**
             * Image dimension for lightbox.
             */
            function getImageDimensions(url) {
                return new Promise(function(resolve, reject) {
                    var img = new Image();
                    img.onload = function() {
                        resolve({
                            w: this.width,
                            h: this.height
                        });
                    };
                    img.onerror = function() {
                        reject(new Error('Failed to load image: ' + url));
                    };
                    img.src = url;
                });
            }

            /**
             * Term title sanitization.
             */
            function sanitizeTitle(text) {
                return text
                    .toString()
                    .trim()
                    .toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^a-z0-9\-]/g, '')
                    .replace(/-+/g, '-');
            }

            /**
             * Spinner load for gallery images load time
             */
            function spinnerLoad(){
                const spinnerContainer = document.createElement('div');
                spinnerContainer.className = 'spinner-container';
                spinnerContainer.innerHTML = '<i class="fa fa-spinner fa-spin spin-icon-remove"></i>';
                document.querySelector('.woocommerce-product-gallery').appendChild(spinnerContainer);
                jQuery(".woocommerce-product-gallery").css("opacity", "0.7");
                document.querySelector('.spinner-container').style.display = 'block';
            }

            /**
             * Gallery changes in the variation list template one
             */
            jQuery(document).on('change', '.variation-list-template-one', function () {
                var variation_id = jQuery('form.variations_form').find('input.variation_id').val();
                const variation_gallery_data = JSON.parse(variation_table_ajax_localization.variation_gallery_data);

                if (variation_id in variation_gallery_data) {
                    let variationImages = variation_gallery_data[variation_id];
                    if (!allImagesPreloaded) spinnerLoad();
                    ajaxCallGallery(variationImages, true);
                } else {
                    console.warn("No gallery data found for", variation_id, "this variation id's");
                }
            });

            /**
             * Gallery changes in the variation list template two
             */
            jQuery(document).on('click', '.variation-list-template-two', function () {
                var variation_id = jQuery('form.variations_form').find('input.variation_id').val();
                const variation_gallery_data = JSON.parse(variation_table_ajax_localization.variation_gallery_data);

                if (variation_id in variation_gallery_data) {
                    let variationImages = variation_gallery_data[variation_id];
                    if (!allImagesPreloaded) spinnerLoad();
                    ajaxCallGallery(variationImages, true);
                } else {
                    console.warn("No gallery data found for", variation_id, "this variation id's");
                }
            });

            /**
             * Gallery changes in the variation select fields
             */
            jQuery('form.variations_form').on('change', 'select', function() {
                var form = jQuery(this).closest('form.variations_form');
                var variation_id = form.find('input.variation_id').val();

                // If variation more and more that time issue create for time. start
                // form.on('found_variation', function(event, variation) {
                //     var variation_id = variation.variation_id;
                //     const variation_gallery_data = JSON.parse(variation_table_ajax_localization.variation_gallery_data);
                //     if (variation_id in variation_gallery_data) {
                //         let variationImages = variation_gallery_data[variation_id];
                //         ajaxCallGallery(variationImages);
                //     } else {
                //         console.warn("No gallery data found for", variation_id, "this variation id's");
                //     }
                // })
                // If variation more and more that time issue create for time. End


                // Check if any attribute is selected
                var allAttributesDeselected = true;
                var selectedAttributes = {};

                form.find('select').each(function() {
                    var attributeName = jQuery(this).attr('name');
                    var selectedTermName = jQuery(this).val();
                    if (selectedTermName) {
                        allAttributesDeselected = false;
                        selectedAttributes[attributeName] = selectedTermName;
                    }
                });

                if (allAttributesDeselected) {
                    const default_gallery_data = variation_table_ajax_localization.default_gallery_data;
                    if (!allImagesPreloaded) spinnerLoad();
                    ajaxCallGallery(default_gallery_data, true);

                } else {
                    if (variation_id && (variation_id !== '0')) {
                        const variation_gallery_data = JSON.parse(variation_table_ajax_localization.variation_gallery_data);

                        if (variation_id in variation_gallery_data) {
                            let variationImages = variation_gallery_data[variation_id];
                            if (variationImages){
                                if (!allImagesPreloaded) spinnerLoad();
                                ajaxCallGallery(variationImages, true);
                            }
                        } else {
                            console.warn("No gallery data found for", variation_id, "this variation id's");
                        }
                    } else {

                        var selectedTermName    = jQuery(this).val();
                        const term_gallery_data = JSON.parse(variation_table_ajax_localization.term_gallery_data);
                        let termSlug            = sanitizeTitle(selectedTermName);

                        if (termSlug in term_gallery_data) {
                            let images = term_gallery_data[termSlug];
                            if (images){
                                if (!allImagesPreloaded) spinnerLoad();
                                ajaxCallGallery(images, true);
                            }
                        } else {
                            console.warn("No gallery data found for", termSlug);
                        }
                    }
                }
            });

            initializeGallery();
        });

    });
})(jQuery);