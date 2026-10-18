<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$errors = $errors ?? [];
$products = $products ?? [];
$customers = $customers ?? [];
?>

<style>
.sale-page {
    max-width: 1000px;
    margin: 0 auto;
    color: #29213d;
}
.sale-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}
.sale-heading-icon {
    width: 50px;
    height: 50px;
    border-radius: 15px;
    background: #eee7ff;
    color: #7040c4;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
}
.sale-card {
    background: #fff;
    border: 1px solid #ece7f4;
    border-radius: 18px;
    padding: 28px;
    box-shadow: 0 8px 25px rgba(49, 25, 84, .05);
}
.sale-field {
    margin-bottom: 21px;
}
.sale-field label {
    display: block;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
}
.sale-field input,
.sale-field select {
    width: 100%;
    min-height: 46px;
    padding: 11px 13px;
    border: 1px solid #dcd5e8;
    border-radius: 10px;
    background: #fff;
    color: #29213d;
    font-size: 14px;
}
.sale-field input:focus,
.sale-field select:focus {
    outline: none;
    border-color: #8251d4;
    box-shadow: 0 0 0 3px rgba(130, 81, 212, .12);
}
.sale-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0 20px;
}
.sale-total {
    background: #f5f0ff;
    border: 1px solid #e7dcff;
    border-radius: 14px;
    padding: 19px 20px;
    margin: 5px 0 23px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.sale-total-label {
    color: #65567f;
    font-size: 14px;
}
.sale-total-value {
    font-size: 27px;
    font-weight: 750;
    color: #7040c4;
}
.sale-btn {
    border: 0;
    border-radius: 10px;
    padding: 13px 20px;
    background: #7545c7;
    color: white;
    font-weight: 650;
    cursor: pointer;
}
.sale-btn:hover {
    background: #6033ad;
}
.sale-secondary {
    display: inline-block;
    border-radius: 10px;
    padding: 12px 17px;
    background: #f0ebf8;
    color: #5f438c;
    text-decoration: none;
    font-weight: 600;
}
.sale-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.sale-alert {
    border-radius: 10px;
    padding: 13px 16px;
    margin-bottom: 20px;
    font-size: 14px;
}
.sale-alert-success {
    background: #eaf8ef;
    border: 1px solid #c7ead2;
    color: #206a3b;
}
.sale-alert-error {
    background: #fff0f0;
    border: 1px solid #ffd0d0;
    color: #a52e37;
}
.sale-hint {
    color: #81758f;
    font-size: 12px;
    margin-top: 7px;
}
@media (max-width: 650px) {
    .sale-card { padding: 19px; }
    .sale-grid { grid-template-columns: 1fr; }
    .sale-total-value { font-size: 22px; }
}
</style>

<div class="sale-page">
    <div class="sale-heading">
        <div class="sale-heading-icon">🛒</div>
        <div>
            <h2 style="margin:0 0 5px;font-size:25px;font-weight:750;">
                Record Sale
            </h2>
            <p style="margin:0;color:#81758f;font-size:14px;">
                Create a transaction and update product inventory.
            </p>
        </div>
    </div>

    <?php if (! empty($success)): ?>
        <div class="sale-alert sale-alert-success">
            ✓ <?= esc($success) ?>
        </div>
    <?php endif; ?>

    <?php if (! empty($errors)): ?>
        <div class="sale-alert sale-alert-error">
            <strong>Please check the following:</strong>
            <ul style="margin:8px 0 0;padding-left:20px;">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="sale-card">
        <form action="<?= site_url('sales/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="sale-grid">
                <div class="sale-field">
                    <label for="product_id">Product *</label>
                    <select name="product_id" id="product_id" required>
                        <option value="">Select a product</option>

                        <?php foreach ($products as $product): ?>
                            <option
                                value="<?= esc($product['id']) ?>"
                                data-price="<?= esc($product['price']) ?>"
                                data-stock="<?= esc($product['stock_quantity']) ?>"
                                <?= (string) old('product_id') === (string) $product['id'] ? 'selected' : '' ?>
                            >
                                <?= esc($product['name']) ?>
                                — ₱<?= number_format((float) $product['price'], 2) ?>
                                (Stock: <?= (int) $product['stock_quantity'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="stockHint" class="sale-hint">
                        Choose a product to see its available stock.
                    </div>
                </div>

                <div class="sale-field">
                    <label for="customer_id">Customer (optional)</label>
                    <select name="customer_id" id="customer_id">
                        <option value="">Walk-in customer / No customer</option>

                        <?php foreach ($customers as $customer): ?>
                            <option
                                value="<?= esc($customer['id']) ?>"
                                <?= (string) old('customer_id') === (string) $customer['id'] ? 'selected' : '' ?>
                            >
                                <?= esc($customer['full_name']) ?>
                                — <?= esc($customer['email']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="sale-hint">
                        You can record a sale without selecting a customer.
                    </div>
                </div>

                <div class="sale-field">
                    <label for="quantity">Quantity *</label>
                    <input
                        type="number"
                        name="quantity"
                        id="quantity"
                        min="1"
                        step="1"
                        value="<?= esc(old('quantity') ?? '1') ?>"
                        required
                    >
                    <div id="quantityHint" class="sale-hint">
                        Enter the number of items sold.
                    </div>
                </div>

                <div class="sale-field">
                    <label for="unitPrice">Unit Price</label>
                    <input
                        type="text"
                        id="unitPrice"
                        value="₱0.00"
                        readonly
                        style="background:#f8f6fb;"
                    >
                    <div class="sale-hint">
                        Automatically taken from the product record.
                    </div>
                </div>
            </div>

            <div class="sale-total">
                <div>
                    <div class="sale-total-label">Total sale amount</div>
                    <div class="sale-hint" style="margin-top:4px;">
                        Unit price × quantity
                    </div>
                </div>
                <div class="sale-total-value" id="totalPrice">₱0.00</div>
            </div>

            <div class="sale-actions">
                <button type="submit" class="sale-btn">
                    ✓ Confirm Sale
                </button>
                <a href="<?= site_url('sales/history') ?>" class="sale-secondary">
                    View Sales History
                </a>
            </div>
        </form>
    </div>
</div>

<script>
(() => {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unitPrice');
    const totalPrice = document.getElementById('totalPrice');
    const stockHint = document.getElementById('stockHint');
    const quantityHint = document.getElementById('quantityHint');

    let price = 0;
    let stock = 0;

    const money = amount => '₱' + Number(amount).toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    function updateSale() {
        const selected = productSelect.options[productSelect.selectedIndex];

        if (!selected || !selected.value) {
            price = 0;
            stock = 0;
            unitPriceInput.value = money(0);
            totalPrice.textContent = money(0);
            stockHint.textContent = 'Choose a product to see its available stock.';
            quantityInput.removeAttribute('max');
            quantityHint.textContent = 'Enter the number of items sold.';
            return;
        }

        price = Number(selected.dataset.price || 0);
        stock = Number(selected.dataset.stock || 0);

        unitPriceInput.value = money(price);
        totalPrice.textContent = money(price * Math.max(0, Number(quantityInput.value || 0)));
        stockHint.textContent = 'Available stock: ' + stock;
        quantityInput.max = stock;

        const quantity = Number(quantityInput.value || 0);

        if (stock < 1) {
            quantityHint.textContent = 'This product is out of stock.';
        } else if (quantity > stock) {
            quantityHint.textContent = 'Only ' + stock + ' item(s) are available.';
        } else {
            quantityHint.textContent = 'Maximum available: ' + stock + ' item(s).';
        }
    }

    productSelect.addEventListener('change', updateSale);
    quantityInput.addEventListener('input', updateSale);

    updateSale();
})();
</script>

<?= $this->endSection() ?>