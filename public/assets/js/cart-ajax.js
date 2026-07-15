(function ($) {
    "use strict";

    if (typeof $ === 'undefined') return;

    var routes = window.__cartRoutes || {};
    var initialQuantities = window.__cartQuantities || {};
    var pending = {};

    function getProductIdFromHref(href) {
        try {
            var url = new URL(href, window.location.origin);
            return url.searchParams.get('product_id');
        } catch (e) {
            return null;
        }
    }

    function buildUpdateUrl(id, qty) {
        return (routes.updateTemplate || '')
            .replace('ID_PLACEHOLDER', id)
            .replace('QTY_PLACEHOLDER', qty);
    }

    function buildRemoveUrl(id) {
        return (routes.removeTemplate || '').replace('ID_PLACEHOLDER', id);
    }

    function ajaxHeaders() {
        return {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };
    }

    function toast(icon, message) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            icon: icon,
            title: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    }

    function updateHeaderCart(cartCount, subtotal, desktopHtml, mobileHtml, cartPageHtml) {
        if (typeof cartCount !== 'undefined') {
            $('#cart-count-desktop, #cart-count-mobile').text(cartCount);
        }
        if (typeof subtotal !== 'undefined') {
            var formatted = Number(subtotal).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            $('#cart-subtotal-desktop, #cart-subtotal-mobile').text(formatted);
        }
        // Full dropdown re-render (image/name/price/stepper per item) so
        // the "Cart" dropdown reflects the change immediately — previously
        // only the count/subtotal above updated live, leaving the dropdown
        // itself showing stale "No Items" until a full page reload.
        if (typeof desktopHtml === 'string') {
            $('#cartDropdownDesktop').html(desktopHtml);
        }
        if (typeof mobileHtml === 'string') {
            $('#cartDropdownMobile').html(mobileHtml);
        }
        // On the /product-cart page itself, also refresh its own items
        // table + Cart Totals box (e.g. after adding a "New Arrivals"
        // product from the bottom of that same page).
        if (typeof cartPageHtml === 'string' && $('#cartPageSummary').length) {
            $('#cartPageSummary').html(cartPageHtml);
        }
    }

    function stepperHtml(productId, qty) {
        return '<div class="apon-cart-stepper" data-product-id="' + productId + '">' +
            '<button type="button" class="apon-cart-stepper__btn apon-cart-stepper__btn--minus" aria-label="Decrease quantity">&minus;</button>' +
            '<span class="apon-cart-stepper__qty">' + qty + '</span>' +
            '<button type="button" class="apon-cart-stepper__btn apon-cart-stepper__btn--plus" aria-label="Increase quantity">+</button>' +
            '</div>';
    }

    function convertButtonToStepper($btn, qty) {
        var href = $btn.attr('href');
        var productId = getProductIdFromHref(href);
        if (!productId) return;

        var $stepper = $(stepperHtml(productId, qty));
        $stepper.data('originalHtml', $btn.prop('outerHTML'));
        $btn.replaceWith($stepper);
    }

    function revertStepperToButton($stepper) {
        var original = $stepper.data('originalHtml');
        if (original) {
            $stepper.replaceWith(original);
        } else {
            $stepper.remove();
        }
    }

    function syncProductAcrossPage(productId, qty) {
        $('.apon-cart-stepper[data-product-id="' + productId + '"]').each(function () {
            $(this).find('.apon-cart-stepper__qty').text(qty);
            $(this).find('.apon-cart-stepper__btn--plus').prop('disabled', false);
        });

        $('a.btn-add-to-cart-full').each(function () {
            var $btn = $(this);
            if (getProductIdFromHref($btn.attr('href')) === String(productId)) {
                convertButtonToStepper($btn, qty);
            }
        });
    }

    function removeProductAcrossPage(productId) {
        $('.apon-cart-stepper[data-product-id="' + productId + '"]').each(function () {
            revertStepperToButton($(this));
        });
    }

    function setLoading($stepper, loading) {
        $stepper.toggleClass('is-loading', loading);
        $stepper.find('.apon-cart-stepper__btn').prop('disabled', loading);
    }

    function bootstrapSteppers() {
        $('a.btn-add-to-cart-full').each(function () {
            var $btn = $(this);
            var productId = getProductIdFromHref($btn.attr('href'));
            if (productId && initialQuantities[productId]) {
                convertButtonToStepper($btn, initialQuantities[productId]);
            }
        });
    }

    // Add to cart (delegated: buttons are swapped in/out dynamically)
    $(document).on('click', 'a.btn-add-to-cart-full', function (e) {
        e.preventDefault();
        var $btn = $(this);
        if ($btn.hasClass('is-loading')) return;

        var href = $btn.attr('href');
        var productId = getProductIdFromHref(href);
        if (!productId || pending[productId]) return;
        pending[productId] = true;

        $btn.addClass('is-loading');

        $.ajax({
            url: href,
            type: 'GET',
            dataType: 'json',
            headers: ajaxHeaders()
        }).done(function (res) {
            if (res.status === 'success') {
                syncProductAcrossPage(productId, res.quantity);
                updateHeaderCart(res.cartCount, res.subtotal, res.desktopHtml, res.mobileHtml, res.cartPageHtml);
                toast('success', 'Added to cart!');
            } else {
                toast('error', res.message || 'Could not add to cart.');
            }
        }).fail(function (xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
            toast('error', msg);
        }).always(function () {
            $btn.removeClass('is-loading');
            delete pending[productId];
        });
    });

    // Quantity stepper +/- (delegated)
    $(document).on('click', '.apon-cart-stepper__btn', function (e) {
        e.preventDefault();
        var $btn = $(this);
        if ($btn.prop('disabled')) return;

        var $stepper = $btn.closest('.apon-cart-stepper');
        var productId = $stepper.data('product-id');
        if (!productId || pending[productId]) return;

        var $qtyEl = $stepper.find('.apon-cart-stepper__qty');
        var currentQty = parseInt($qtyEl.text(), 10) || 1;
        var isPlus = $btn.hasClass('apon-cart-stepper__btn--plus');

        pending[productId] = true;
        setLoading($stepper, true);

        if (!isPlus && currentQty <= 1) {
            $.ajax({
                url: buildRemoveUrl(productId),
                type: 'GET',
                dataType: 'json',
                headers: ajaxHeaders()
            }).done(function (res) {
                if (res.status === 'success') {
                    removeProductAcrossPage(productId);
                    updateHeaderCart(res.cartCount, res.subtotal, res.desktopHtml, res.mobileHtml, res.cartPageHtml);
                } else {
                    toast('error', res.message || 'Could not remove item.');
                    setLoading($stepper, false);
                }
            }).fail(function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
                toast('error', msg);
                setLoading($stepper, false);
            }).always(function () {
                delete pending[productId];
            });
            return;
        }

        var newQty = isPlus ? currentQty + 1 : currentQty - 1;

        $.ajax({
            url: buildUpdateUrl(productId, newQty),
            type: 'GET',
            dataType: 'json',
            headers: ajaxHeaders()
        }).done(function (res) {
            if (res.status === 'success') {
                syncProductAcrossPage(productId, res.quantity);
                updateHeaderCart(res.cartCount, res.subtotal, res.desktopHtml, res.mobileHtml, res.cartPageHtml);
            } else {
                toast('error', res.message || 'Could not update cart.');
                if (isPlus) {
                    $stepper.find('.apon-cart-stepper__btn--plus').prop('disabled', true);
                }
            }
        }).fail(function (xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
            toast('error', msg);
            if (xhr.status === 400 && isPlus) {
                $stepper.find('.apon-cart-stepper__btn--plus').prop('disabled', true);
            }
        }).always(function () {
            setLoading($stepper, false);
            delete pending[productId];
        });
    });

    $(function () {
        bootstrapSteppers();
    });

    // "New products" sidebar widget — icon-only Add To Cart button
    // (used on Product Details, Shop, Category, and other listing pages)
    $(document).on('click', '.sidebar-add-cart', function (e) {
        e.preventDefault();
        var $btn = $(this);
        if ($btn.hasClass('is-loading')) return;

        $btn.addClass('is-loading');

        $.ajax({
            url: $btn.attr('href'),
            type: 'GET',
            dataType: 'json',
            headers: ajaxHeaders()
        }).done(function (res) {
            if (res.status === 'success') {
                updateHeaderCart(res.cartCount, res.subtotal, res.desktopHtml, res.mobileHtml, res.cartPageHtml);
                toast('success', 'Added to cart!');
            } else {
                toast('error', res.message || 'Could not add to cart.');
            }
        }).fail(function (xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
            toast('error', msg);
        }).always(function () {
            $btn.removeClass('is-loading');
        });
    });

    // Header mini-cart dropdown — quantity stepper next to each item name
    // (desktop + mobile dropdowns both use the same markup/class)
    $(document).on('click', '.header-cart-stepper__btn', function (e) {
        e.preventDefault();

        var $btn = $(this);
        var $stepper = $btn.closest('.header-cart-stepper');
        if ($stepper.hasClass('is-loading')) return;

        var productId = $stepper.data('product-id');
        if (!productId || pending[productId]) return;

        var currentQty = parseInt($stepper.find('.header-cart-stepper__qty').text(), 10) || 1;
        var isPlus = $btn.hasClass('header-cart-stepper__btn--plus');

        pending[productId] = true;
        var $allMatching = $('.header-cart-stepper[data-product-id="' + productId + '"]');
        $allMatching.addClass('is-loading');

        if (!isPlus && currentQty <= 1) {
            $.ajax({
                url: buildRemoveUrl(productId),
                type: 'GET',
                dataType: 'json',
                headers: ajaxHeaders()
            }).done(function (res) {
                if (res.status === 'success') {
                    updateHeaderCart(res.cartCount, res.subtotal, res.desktopHtml, res.mobileHtml, res.cartPageHtml);
                    removeProductAcrossPage(productId);
                } else {
                    toast('error', res.message || 'Could not remove item.');
                }
            }).fail(function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
                toast('error', msg);
            }).always(function () {
                delete pending[productId];
                $allMatching.removeClass('is-loading');
            });
            return;
        }

        var newQty = isPlus ? currentQty + 1 : currentQty - 1;

        $.ajax({
            url: buildUpdateUrl(productId, newQty),
            type: 'GET',
            dataType: 'json',
            headers: ajaxHeaders()
        }).done(function (res) {
            if (res.status === 'success') {
                updateHeaderCart(res.cartCount, res.subtotal, res.desktopHtml, res.mobileHtml, res.cartPageHtml);
                syncProductAcrossPage(productId, res.quantity);
            } else {
                toast('error', res.message || 'Could not update cart.');
            }
        }).fail(function (xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
            toast('error', msg);
        }).always(function () {
            delete pending[productId];
            $allMatching.removeClass('is-loading');
        });
    });
})(jQuery);
