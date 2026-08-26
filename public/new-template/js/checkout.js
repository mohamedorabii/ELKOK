document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('checkout-form');
    if (!form) return;

    const currency = form.dataset.currency;
    const isArabic = form.dataset.locale === 'ar';
    const subtotal = parseFloat(form.dataset.subtotal);
    const shippingOptions = JSON.parse(form.dataset.shippingOptions || '{}');

    const shippingValueEl = document.getElementById('checkout-shipping-value');
    const totalValueEl = document.getElementById('checkout-total-value');

    const formatPrice = (value) => {
        const formatted = Number(value).toFixed(2);
        return isArabic ? `${formatted} ${currency}` : `${currency} ${formatted}`;
    };

    const updateTotals = (selected) => {
        if (!selected || !(selected in shippingOptions)) {
            shippingValueEl.textContent = formatPrice(0);
            totalValueEl.textContent = formatPrice(subtotal);
            return;
        }

        const shipping = parseFloat(shippingOptions[selected]);
        shippingValueEl.textContent = formatPrice(shipping);
        totalValueEl.textContent = formatPrice(subtotal + shipping);
    };

    // Native change (works if no widget library intercepts the select)
    const governorateSelect = document.getElementById('governorate-select');
    governorateSelect.addEventListener('change', () => updateTotals(governorateSelect.value));

    // jQuery-based change (catches nice-select's $(select).trigger('change'))
    if (window.jQuery) {
        window.jQuery(document).on('change', '#governorate-select', function () {
            updateTotals(this.value);
        });
    }
});