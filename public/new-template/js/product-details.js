document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('product-variant-root');
    if (!root) return;

    const variants = JSON.parse(root.dataset.variants || '[]');
    const initialPrice = root.dataset.initialPrice;
    const currency = root.dataset.currency;
    const isArabic = root.dataset.locale === 'ar';
    const inStockText = root.dataset.inStockText;
    const chooseColorSizeText = root.dataset.chooseColorSizeText;
    const noSizesText = root.dataset.noSizesText;
    const noInstockSizesText = root.dataset.noInstockSizesText;
    const leftText = root.dataset.leftText;

    const colors = document.querySelectorAll('.variant-color-btn');
    const sizesContainer = document.getElementById('variant-sizes');
    const variantInput = document.getElementById('selected-variant-id');
    const addButton = document.getElementById('add-to-cart-button');
    const quantityInput = document.getElementById('product-quantity-input');
    const priceDisplay = document.getElementById('product-price-display');
    const stockBadge = document.getElementById('product-stock-badge');
    const summaryText = document.getElementById('selected-variant-text');
    const galleryThumbs = document.querySelectorAll('.gallery-thumb');
    const mainImage = document.getElementById('product-main-image');

    const formatPrice = (value) => {
        const formatted = Number(value).toFixed(2);
        return isArabic ? `${formatted} ${currency}` : `${currency} ${formatted}`;
    };

    const variantsByColor = variants.reduce((grouped, variant) => {
        if (!grouped[variant.color_id]) {
            grouped[variant.color_id] = [];
        }
        grouped[variant.color_id].push(variant);
        return grouped;
    }, {});

    const resetVariantSelection = () => {
        variantInput.value = '';
        addButton.disabled = true;
        quantityInput.disabled = true;
        quantityInput.value = 1;
        quantityInput.max = 1;
        priceDisplay.textContent = initialPrice;
        summaryText.textContent = chooseColorSizeText;
        stockBadge.className = 'badge badge-success';
        stockBadge.style.cssText = 'font-size:15px;padding:7px 14px;border-radius:20px;font-weight:600;';
        stockBadge.textContent = inStockText;
    };

    const clearActiveSizeButtons = () => {
        document.querySelectorAll('.variant-size-btn').forEach((button) => {
            button.classList.remove('btn-dark');
            button.classList.add('btn-outline-secondary');
        });
    };

    const renderSizes = (colorId) => {
        const colorVariants = variantsByColor[colorId] || [];
        const availableVariants = colorVariants.filter((variant) => Number(variant.stock) > 0);

        sizesContainer.innerHTML = '';

        if (!colorVariants.length) {
            sizesContainer.innerHTML = `<span class="text-muted">${noSizesText}</span>`;
            return;
        }

        colorVariants.forEach((variant) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-outline-secondary variant-size-btn';
            button.dataset.variantId = variant.id;
            button.textContent = variant.size_name;
            button.style.borderRadius = '999px';

            if (Number(variant.stock) <= 0) {
                button.disabled = true;
                button.classList.add('text-muted');
            }

            button.addEventListener('click', () => {
                clearActiveSizeButtons();
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-dark');

                variantInput.value = variant.id;
                addButton.disabled = false;
                quantityInput.disabled = false;
                quantityInput.max = variant.stock;
                quantityInput.value = 1;
                priceDisplay.textContent = formatPrice(variant.price);
                stockBadge.className = 'badge badge-success';
                stockBadge.textContent = inStockText;
                summaryText.textContent =
                    `${variant.color_name} / ${variant.size_name}${variant.sku ? ' · ' + variant.sku : ''} · ${variant.stock} ${leftText}`;
            });

            sizesContainer.appendChild(button);
        });

        if (!availableVariants.length) {
            addButton.disabled = true;
            quantityInput.disabled = true;
            summaryText.textContent = noInstockSizesText;
        }
    };

    colors.forEach((button) => {
        button.addEventListener('click', () => {
            colors.forEach((item) => {
                item.classList.remove('btn-dark');
                item.classList.add('btn-outline-dark');
            });

            button.classList.remove('btn-outline-dark');
            button.classList.add('btn-dark');

            resetVariantSelection();
            renderSizes(button.dataset.colorId);
        });
    });

    galleryThumbs.forEach((thumb) => {
        thumb.addEventListener('click', () => {
            mainImage.src = thumb.dataset.image;
        });
    });

    resetVariantSelection();
});