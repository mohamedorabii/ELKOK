document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const cartRoot = document.getElementById('cart-root');

    if (!cartRoot) return;

    const currency = cartRoot.dataset.currency;
    const isArabic = cartRoot.dataset.locale === 'ar';

    const formatPrice = (value) => {
        const formatted = Number(value).toFixed(2);
        return isArabic ? `${formatted} ${currency}` : `${currency} ${formatted}`;
    };

    document.querySelectorAll('.cart-qty-stepper').forEach((stepper) => {
        const cartId = stepper.dataset.cartId;
        const updateUrl = stepper.dataset.updateUrl;
        const unitPrice = parseFloat(stepper.dataset.unitPrice);
        const maxStock = parseInt(stepper.dataset.maxStock, 10);

        const valueEl = stepper.querySelector('.cart-qty-value');
        const minusBtn = stepper.querySelector('.cart-qty-minus');
        const plusBtn = stepper.querySelector('.cart-qty-plus');
        const errorEl = stepper.parentElement.querySelector('.cart-qty-error');
        const lineTotalEl = document.querySelector(`.cart-line-total[data-cart-id="${cartId}"]`);

        let quantity = parseInt(valueEl.textContent, 10);
        let isSyncing = false;
        let debounceTimer = null;

        const renderButtonsState = () => {
            minusBtn.disabled = quantity <= 1 || isSyncing;
            plusBtn.disabled = quantity >= maxStock || isSyncing;
        };

        const renderLocalValue = () => {
            valueEl.textContent = quantity;
            if (lineTotalEl) {
                lineTotalEl.textContent = formatPrice(unitPrice * quantity);
            }
            renderButtonsState();
        };

        const showError = (message) => {
            errorEl.textContent = message;
            errorEl.classList.remove('d-none');
        };

        const clearError = () => {
            errorEl.classList.add('d-none');
            errorEl.textContent = '';
        };

       const syncTotals = (totals) => {
    const totalEl = document.getElementById('cart-total-value');
    if (totalEl) totalEl.textContent = formatPrice(totals.total);
};

        const sendUpdate = (newQuantity, previousQuantity) => {
            isSyncing = true;
            renderButtonsState();

            fetch(updateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ quantity: newQuantity }),
            })
                .then(async (response) => {
                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Update failed');
                    }

                    clearError();
                    quantity = data.item.quantity;
                    valueEl.textContent = quantity;
                    if (lineTotalEl) {
                        lineTotalEl.textContent = formatPrice(data.item.line_total);
                    }
                    syncTotals(data.totals);
                })
                .catch((error) => {
                    quantity = previousQuantity;
                    renderLocalValue();
                    showError(error.message || 'Could not update quantity.');
                })
                .finally(() => {
                    isSyncing = false;
                    renderButtonsState();
                });
        };

        const scheduleUpdate = (previousQuantity) => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                sendUpdate(quantity, previousQuantity);
            }, 350);
        };

        plusBtn.addEventListener('click', () => {
            if (quantity >= maxStock || isSyncing) return;
            const previousQuantity = quantity;
            quantity += 1;
            renderLocalValue();
            scheduleUpdate(previousQuantity);
        });

        minusBtn.addEventListener('click', () => {
            if (quantity <= 1 || isSyncing) return;
            const previousQuantity = quantity;
            quantity -= 1;
            renderLocalValue();
            scheduleUpdate(previousQuantity);
        });

        renderButtonsState();
    });
});