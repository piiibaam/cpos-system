<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .products-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .products-toolbar h2 {
        margin: 0 0 6px;
        font-size: 25px;
    }

    .muted { color: #817990; }

    .primary-btn {
        display: inline-block;
        padding: 12px 18px;
        border: 0;
        border-radius: 9px;
        background: #7045d6;
        color: white;
        text-decoration: none;
        font-weight: bold;
        cursor: pointer;
    }

    .table-card {
        overflow-x: auto;
        background: white;
        border: 1px solid #ece7f5;
        border-radius: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        min-width: 800px;
    }

    th, td {
        padding: 17px 20px;
        border-bottom: 1px solid #f0edf6;
    }

    th {
        background: #faf9fd;
        color: #766d88;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    tbody tr:last-child td { border-bottom: 0; }

    .product-image, .no-image {
        width: 48px;
        height: 48px;
        border-radius: 9px;
        background: #f0edf6;
    }

    .product-image { object-fit: cover; }

    .no-image {
        display: grid;
        place-items: center;
        font-size: 22px;
    }

    .stock {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        background: #eee8ff;
        color: #7045d6;
        font-size: 12px;
        font-weight: bold;
    }

    .empty-state {
        padding: 50px 20px;
        text-align: center;
    }

    .alert {
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 18px;
    }

    .alert-success {
        background: #e8f8ee;
        color: #187443;
        border: 1px solid #c7ecd5;
    }

    .alert-error {
        background: #fff0f0;
        color: #b42318;
        border: 1px solid #f5cccc;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .edit-btn, .delete-btn {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        font-size: 13px;
        cursor: pointer;
    }

    .edit-btn {
        background: #eee8ff;
        color: #7045d6;
        border: 1px solid #e0d5ff;
    }

    .delete-btn {
        background: #fff0f0;
        color: #c62828;
        border: 1px solid #f5cccc;
    }

    .delete-form { margin: 0; }

    /* Custom confirmation modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(30, 18, 52, 0.58);
        backdrop-filter: blur(4px);
    }

    .modal-overlay.show { display: flex; }

    .modal-box {
        width: 100%;
        max-width: 420px;
        padding: 30px;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 20px 70px rgba(25, 12, 48, 0.25);
        text-align: center;
        animation: modalAppear .18s ease-out;
    }

    .modal-icon {
        display: grid;
        place-items: center;
        width: 66px;
        height: 66px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: #fff0f0;
        color: #d93636;
        font-size: 30px;
    }

    .modal-box h3 {
        margin: 0 0 10px;
        color: #281846;
        font-size: 23px;
    }

    .modal-box p {
        margin: 0 0 25px;
        color: #817990;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .modal-product-name {
        color: #7045d6;
        font-weight: bold;
    }

    .modal-actions {
        display: flex;
        gap: 12px;
    }

    .modal-actions button {
        flex: 1;
        padding: 12px 14px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
    }

    .cancel-btn {
        background: #f5f2fa;
        color: #514664;
        border: 1px solid #e8e1f1;
    }

    .confirm-delete-btn {
        background: #d93636;
        color: white;
        border: 1px solid #d93636;
    }

    .cancel-btn:hover { background: #ebe5f5; }
    .confirm-delete-btn:hover { background: #b92525; }

    @keyframes modalAppear {
        from { opacity: 0; transform: translateY(8px) scale(.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @media (max-width: 480px) {
        .modal-box { padding: 24px 20px; }
        .modal-actions { flex-direction: column-reverse; }
    }
</style>

<div class="products-toolbar">
    <div>
        <h2>Product Inventory</h2>
        <p class="muted">Manage your products, prices, and stock.</p>
    </div>

    <a href="<?= site_url('products/create') ?>" class="primary-btn">
        + Add Product
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<div class="table-card">
    <?php if (empty($products)): ?>
        <div class="empty-state">
            <div style="font-size:42px;">📦</div>
            <h3>No products yet</h3>
            <p class="muted">
                Add your first product to start building your inventory.
            </p>
            <a href="<?= site_url('products/create') ?>" class="primary-btn">
                Add Your First Product
            </a>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Added</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <?php if (! empty($product['image'])): ?>
                                <img
                                    class="product-image"
                                    src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                    alt="<?= esc($product['name']) ?>"
                                >
                            <?php else: ?>
                                <div class="no-image">📦</div>
                            <?php endif; ?>
                        </td>

                        <td><strong><?= esc($product['name']) ?></strong></td>

                        <td>₱<?= number_format((float) $product['price'], 2) ?></td>

                        <td>
                            <span class="stock">
                                <?= esc($product['stock_quantity']) ?> units
                            </span>
                        </td>

                        <td><?= esc($product['created_at']) ?></td>

                        <td>
                            <div class="action-buttons">
                                <a
                                    href="<?= site_url('products/edit/' . $product['id']) ?>"
                                    class="edit-btn"
                                >Edit</a>

                                <form
                                    action="<?= site_url('products/delete/' . $product['id']) ?>"
                                    method="post"
                                    class="delete-form"
                                    data-product-name="<?= esc($product['name']) ?>"
                                >
                                    <?= csrf_field() ?>

                                    <button type="button" class="delete-btn open-delete-modal">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Custom Delete Confirmation Modal -->
<div
    class="modal-overlay"
    id="deleteModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="deleteModalTitle"
    aria-describedby="deleteModalDescription"
>
    <div class="modal-box">
        <div class="modal-icon">!</div>

        <h3 id="deleteModalTitle">Delete Product?</h3>

        <p id="deleteModalDescription">
            Are you sure you want to delete
            <span class="modal-product-name" id="deleteProductName"></span>?
            This action cannot be undone.
        </p>

        <div class="modal-actions">
            <button type="button" class="cancel-btn" id="cancelDelete">
                No, Keep It
            </button>

            <button type="button" class="confirm-delete-btn" id="confirmDelete">
                Yes, Delete
            </button>
        </div>
    </div>
</div>

<script>
    (() => {
        const modal = document.getElementById('deleteModal');
        const productName = document.getElementById('deleteProductName');
        const cancelButton = document.getElementById('cancelDelete');
        const confirmButton = document.getElementById('confirmDelete');

        let selectedForm = null;
        let previousFocus = null;

        function closeModal() {
            modal.classList.remove('show');
            selectedForm = null;

            if (previousFocus) {
                previousFocus.focus();
            }
        }

        document.querySelectorAll('.open-delete-modal').forEach((button) => {
            button.addEventListener('click', () => {
                selectedForm = button.closest('.delete-form');
                previousFocus = button;

                productName.textContent =
                    selectedForm.dataset.productName || 'this product';

                modal.classList.add('show');
                cancelButton.focus();
            });
        });

        cancelButton.addEventListener('click', closeModal);

        confirmButton.addEventListener('click', () => {
            if (selectedForm) {
                selectedForm.submit();
            }
        });

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modal.classList.contains('show')) {
                closeModal();
            }
        });
    })();
</script>

<?= $this->endSection() ?>