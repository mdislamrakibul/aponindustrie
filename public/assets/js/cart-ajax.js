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

    function updateHeaderCart(cartCount, subtotal) {
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
                updateHeaderCart(res.cartCount, res.subtotal);
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
                    updateHeaderCart(res.cartCount, res.subtotal);
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
                updateHeaderCart(res.cartCount, res.subtotal);
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
})(jQuery);
