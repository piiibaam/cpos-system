<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .form-card {
        max-width: 760px;
        padding: 30px;
        background: white;
        border: 1px solid #ece7f5;
        border-radius: 16px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
    }

    .field { margin-bottom: 20px; }

    .field label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        font-size: 14px;
    }

    .field input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ded8eb;
        border-radius: 9px;
        font-size: 15px;
    }

    .field input:focus {
        outline: 2px solid #d7c7ff;
        border-color: #7045d6;
    }

    .muted { color: #817990; font-size: 13px; }

    .primary-btn, .secondary-btn {
        display: inline-block;
        padding: 12px 18px;
        border-radius: 9px;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
    }

    .primary-btn {
        background: #7045d6;
        color: white;
        border: 0;
    }

    .secondary-btn {
        background: white;
        color: #5e536f;
        border: 1px solid #ded8eb;
    }

    .error-list {
        padding: 14px 18px;
        margin-bottom: 20px;
        border-radius: 9px;
        background: #fff0f0;
        color: #b42318;
    }

    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; gap: 0; }
        .form-card { padding: 20px; }
    }
</style>

<div style="margin-bottom:24px;">
    <a href="<?= site_url('products') ?>"
       style="color:#7045d6;text-decoration:none;">← Back to Products</a>
    <h2>Add New Product</h2>
    <p class="muted">Enter the product details and inventory quantity.</p>
</div>

<div class="form-card">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="error-list">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php $errors = session()->getFlashdata('errors') ?? []; ?>
    <?php if ($errors): ?>
        <div class="error-list">
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('products/store') ?>"
          method="post" enctype="multipart/form-data">

        <?= csrf_field() ?>

        <div class="field">
            <label for="name">Product Name *</label>
            <input id="name" name="name" type="text"
                   maxlength="100"
                   value="<?= esc(old('name') ?? '') ?>" required>
        </div>

        <div class="form-grid">
            <div class="field">
                <label for="price">Price (₱) *</label>
                <input id="price" name="price" type="number"
                       min="0" step="0.01"
                       value="<?= esc(old('price') ?? '') ?>" required>
            </div>

            <div class="field">
                <label for="stock_quantity">Stock Quantity *</label>
                <input id="stock_quantity" name="stock_quantity"
                       type="number" min="0" step="1"
                       value="<?= esc(old('stock_quantity') ?? '0') ?>"
                       required>
            </div>
        </div>

        <div class="field">
            <label for="image">Product Image</label>
            <input id="image" name="image" type="file"
                   accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
            <p class="muted">Optional. JPG, PNG, or WebP. Maximum 2 MB.</p>
        </div>

        <button class="primary-btn" type="submit">Save Product</button>
        <a class="secondary-btn" href="<?= site_url('products') ?>">Cancel</a>
    </form>
</div>

<?= $this->endSection() ?>