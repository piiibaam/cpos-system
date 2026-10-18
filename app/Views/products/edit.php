<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
.product-edit-page {
    max-width: 850px;
    margin: 0 auto;
    padding-bottom: 40px;
}
.product-edit-heading {
    margin-bottom: 24px;
}
.product-edit-heading h1 {
    margin: 0 0 8px;
    color: #281747;
    font-size: 30px;
    font-weight: 750;
}
.product-edit-heading p {
    margin: 0;
    color: #777087;
    font-size: 14px;
    line-height: 1.6;
}
.product-edit-card {
    padding: 30px;
    border: 1px solid #eee8f6;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 8px 28px rgba(40,23,71,.06);
}
.product-edit-meta {
    display: inline-block;
    margin-bottom: 22px;
    padding: 7px 11px;
    border-radius: 8px;
    background: #f3edff;
    color: #7040c5;
    font-size: 12px;
    font-weight: 700;
}
.product-edit-section-title {
    margin: 0 0 22px;
    color: #281747;
    font-size: 17px;
    font-weight: 700;
}
.product-edit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
}
.product-edit-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    min-width: 0;
}
.product-edit-group.full-width {
    grid-column: 1 / -1;
}
.product-edit-group label {
    color: #35264b;
    font-size: 13px;
    font-weight: 650;
}
.product-edit-group input {
    box-sizing: border-box;
    width: 100%;
    min-height: 46px;
    padding: 11px 13px;
    border: 1px solid #ded6e9;
    border-radius: 9px;
    background: #fff;
    color: #281747;
    font-size: 14px;
    outline: none;
}
.product-edit-group input:focus {
    border-color: #8957e5;
    box-shadow: 0 0 0 3px rgba(137,87,229,.12);
}
.product-edit-hint {
    margin: 0;
    color: #898197;
    font-size: 12px;
    line-height: 1.5;
}
.product-image-preview {
    width: 150px;
    height: 150px;
    border: 1px solid #eee8f6;
    border-radius: 14px;
    object-fit: cover;
    background: #f7f3fc;
}
.product-image-placeholder {
    display: flex;
    width: 150px;
    height: 150px;
    align-items: center;
    justify-content: center;
    border: 1px dashed #cfc2e5;
    border-radius: 14px;
    background: #f7f3fc;
    color: #7040c5;
    font-size: 14px;
    text-align: center;
}
.product-edit-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 30px;
    padding-top: 24px;
    border-top: 1px solid #eee8f6;
}
.product-edit-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    box-sizing: border-box;
    min-height: 43px;
    padding: 0 20px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
}
.product-edit-btn-primary {
    border: 1px solid #8150df;
    background: #8150df;
    color: #fff;
}
.product-edit-btn-primary:hover {
    background: #6d3dc8;
}
.product-edit-btn-secondary {
    border: 1px solid #ded6e9;
    background: #fff;
    color: #514663;
}
.product-edit-btn-secondary:hover {
    background: #f7f3fc;
}
.product-edit-alert {
    margin-bottom: 20px;
    padding: 13px 16px;
    border: 1px solid #f3cccc;
    border-radius: 10px;
    background: #fff0f0;
    color: #a12c2c;
    font-size: 13px;
}
.product-edit-errors {
    margin: 5px 0 0;
    padding-left: 18px;
    color: #b42323;
    font-size: 12px;
}
@media (max-width: 650px) {
    .product-edit-card {
        padding: 20px;
    }
    .product-edit-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }
    .product-edit-group.full-width {
        grid-column: auto;
    }
    .product-edit-heading h1 {
        font-size: 25px;
    }
    .product-edit-actions {
        flex-direction: column-reverse;
    }
    .product-edit-btn {
        width: 100%;
    }
}
</style>

<?php
$errors = $errors ?? [];
$product = $product ?? [];
?>

<div class="product-edit-page">

    <div class="product-edit-heading">
        <h1>Edit Product</h1>
        <p>Update the product's information, price, stock, and image.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="product-edit-alert">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (! empty($errors)): ?>
        <div class="product-edit-alert">
            <strong>Please check the following:</strong>
            <ul class="product-edit-errors">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="product-edit-card">

        <div class="product-edit-meta">
            Product ID: #<?= esc($product['id'] ?? '') ?>
        </div>

        <h2 class="product-edit-section-title">Product Information</h2>

        <form
            action="<?= site_url('products/update/' . ($product['id'] ?? '')) ?>"
            method="post"
            enctype="multipart/form-data"
        >
            <?= csrf_field() ?>

            <div class="product-edit-grid">

                <div class="product-edit-group full-width">
                    <label for="name">Product Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?= esc(old('name', $product['name'] ?? '')) ?>"
                        minlength="2"
                        maxlength="100"
                        placeholder="Enter product name"
                        required
                    >
                    <?php if (isset($errors['name'])): ?>
                        <ul class="product-edit-errors">
                            <li><?= esc($errors['name']) ?></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="product-edit-group">
                    <label for="price">Price (₱)</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="<?= esc(old('price', $product['price'] ?? '')) ?>"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        required
                    >
                    <?php if (isset($errors['price'])): ?>
                        <ul class="product-edit-errors">
                            <li><?= esc($errors['price']) ?></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="product-edit-group">
                    <label for="stock_quantity">Stock Quantity</label>
                    <input
                        type="number"
                        id="stock_quantity"
                        name="stock_quantity"
                        value="<?= esc(old('stock_quantity', $product['stock_quantity'] ?? 0)) ?>"
                        min="0"
                        step="1"
                        placeholder="0"
                        required
                    >
                    <?php if (isset($errors['stock_quantity'])): ?>
                        <ul class="product-edit-errors">
                            <li><?= esc($errors['stock_quantity']) ?></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="product-edit-group full-width">
                    <label>Current Product Image</label>

                    <?php if (! empty($product['image'])): ?>
                        <img
                            class="product-image-preview"
                            src="<?= base_url('uploads/products/' . rawurlencode($product['image'])) ?>"
                            alt="<?= esc($product['name'] ?? 'Product') ?>"
                        >
                    <?php else: ?>
                        <div class="product-image-placeholder">
                            No product image uploaded
                        </div>
                    <?php endif; ?>
                </div>

                <div class="product-edit-group full-width">
                    <label for="image">Replace Product Image (optional)</label>
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpeg,image/png,image/webp"
                    >
                    <p class="product-edit-hint">
                        Accepted formats: JPG, JPEG, or WebP/PNG. Maximum size: 2 MB.
                        Leave empty to keep the current image.
                    </p>
                </div>

            </div>

            <div class="product-edit-actions">
                <a
                    href="<?= site_url('products') ?>"
                    class="product-edit-btn product-edit-btn-secondary"
                >Cancel</a>

                <button
                    type="submit"
                    class="product-edit-btn product-edit-btn-primary"
                >Save Changes</button>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection() ?>