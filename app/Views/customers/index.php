<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .customers-page {
        max-width: 1200px;
        margin: 0 auto;
        padding-bottom: 40px;
    }

    .page-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .page-heading h1 {
        margin: 0 0 7px;
        color: #281747;
        font-size: 30px;
        font-weight: 750;
    }

    .page-heading p {
        margin: 0;
        color: #777087;
        font-size: 14px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 40px;
        padding: 0 16px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        box-sizing: border-box;
        transition: background .2s;
    }

    .btn-primary {
        color: #fff;
        background: #8150df;
        border: 1px solid #8150df;
    }

    .btn-primary:hover {
        background: #6d3dc8;
    }

    .btn-secondary {
        color: #514663;
        background: #fff;
        border: 1px solid #ded6e9;
    }

    .btn-secondary:hover {
        background: #f7f3fc;
    }

    .btn-edit {
        min-height: 34px;
        padding: 0 12px;
        color: #7040c5;
        background: #f3edff;
        border: 1px solid #e5d8ff;
    }

    .btn-delete {
        min-height: 34px;
        padding: 0 12px;
        color: #b42332;
        background: #fff0f0;
        border: 1px solid #f4d0d4;
    }

    .panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #eee8f6;
        border-radius: 16px;
        box-shadow: 0 8px 28px rgba(40, 23, 71, .05);
    }

    .panel-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        padding: 20px 22px;
        border-bottom: 1px solid #eee8f6;
    }

    .panel-toolbar h2 {
        margin: 0;
        color: #281747;
        font-size: 16px;
    }

    .search-form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .search-form input {
        width: 260px;
        max-width: 100%;
        height: 40px;
        box-sizing: border-box;
        padding: 0 12px;
        border: 1px solid #ded6e9;
        border-radius: 9px;
        outline: none;
        color: #281747;
    }

    .search-form input:focus {
        border-color: #8957e5;
        box-shadow: 0 0 0 3px rgba(137, 87, 229, .12);
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .customers-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .customers-table th {
        padding: 15px 20px;
        background: #faf8fd;
        color: #81788e;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .6px;
        white-space: nowrap;
    }

    .customers-table td {
        padding: 17px 20px;
        border-top: 1px solid #f0ebf6;
        color: #514663;
        font-size: 13px;
    }

    .customers-table tbody tr:hover {
        background: #fdfbff;
    }

    .customer-name {
        color: #281747;
        font-weight: 700;
    }

    .customer-id {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 7px;
        background: #f3edff;
        color: #7040c5;
        font-size: 12px;
        font-weight: 700;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .inline-form {
        display: inline;
        margin: 0;
    }

    .alert {
        margin-bottom: 18px;
        padding: 13px 16px;
        border-radius: 10px;
        font-size: 13px;
    }

    .alert-success {
        background: #edf9f0;
        border: 1px solid #c7ebd0;
        color: #236b38;
    }

    .alert-error {
        background: #fff0f0;
        border: 1px solid #f3cccc;
        color: #a12c2c;
    }

    .empty-state {
        padding: 55px 20px;
        text-align: center;
    }

    .empty-state h3 {
        margin: 0 0 8px;
        color: #281747;
        font-size: 18px;
    }

    .empty-state p {
        margin: 0 0 20px;
        color: #81788e;
        font-size: 13px;
    }

    .results-note {
        padding: 14px 22px;
        border-top: 1px solid #f0ebf6;
        color: #81788e;
        font-size: 12px;
    }

    /* DELETE MODAL BACKDROP */
    .modal-backdrop {
        position: fixed !important;
        inset: 0 !important;
        z-index: 999999 !important;
        display: none;
        align-items: center !important;
        justify-content: center !important;
        width: 100%;
        height: 100%;
        height: 100dvh;
        padding: 20px;
        box-sizing: border-box;
        background: rgba(28, 17, 46, .58);
        overflow-y: auto;
    }

    .modal-backdrop.show {
        display: flex !important;
    }

    /* MODAL BOX AND ALL CONTENT */
    .confirm-modal {
        position: relative;
        flex: 0 1 420px;
        width: 100%;
        max-width: 420px;
        margin: auto !important;
        padding: 28px;
        box-sizing: border-box;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 24px 70px rgba(0, 0, 0, .22);

        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;

        animation: modalAppear .18s ease-out;
    }

    @keyframes modalAppear {
        from {
            opacity: 0;
            transform: translateY(8px) scale(.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        margin: 0 auto 16px;
        border-radius: 14px;
        background: #fff0f0;
        color: #c93745;
        font-size: 24px;
        font-weight: 800;
    }

    .confirm-modal h3 {
        width: 100%;
        margin: 0 0 10px;
        color: #281747;
        font-size: 21px;
        line-height: 1.4;
        text-align: center;
    }

    .confirm-modal p {
        width: 100%;
        margin: 0;
        color: #777087;
        font-size: 13px;
        line-height: 1.7;
        text-align: center;
        overflow-wrap: anywhere;
    }

    /* BOTH BUTTONS CENTERED, SAME SIZE, SIDE BY SIDE */
    .modal-actions {
        display: flex !important;
        flex-direction: row !important;
        justify-content: center !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        gap: 12px;
        width: 100%;
        margin: 25px 0 0;
    }

    .modal-actions .btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex: 0 0 120px !important;
        width: 120px !important;
        min-width: 120px !important;
        max-width: 120px !important;
        height: 44px !important;
        min-height: 44px !important;
        margin: 0 !important;
        padding: 0 8px !important;
        box-sizing: border-box !important;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;
        text-align: center;
    }

    .modal-actions .btn-secondary {
        color: #514663;
        background: #fff;
        border: 1px solid #ded6e9;
    }

    .modal-actions .btn-secondary:hover {
        background: #f7f3fc;
    }

    .modal-actions .btn-danger {
        color: #fff;
        background: #c93745;
        border: 1px solid #c93745;
    }

    .modal-actions .btn-danger:hover {
        background: #a92533;
    }

    @media (max-width: 480px) {
        .page-heading h1 {
            font-size: 25px;
        }

        .panel-toolbar {
            align-items: stretch;
        }

        .search-form {
            width: 100%;
        }

        .search-form input {
            flex: 1;
            width: auto;
        }

        .confirm-modal {
            padding: 24px 16px;
        }

        .modal-actions {
            gap: 8px;
        }

        .modal-actions .btn {
            flex-basis: 115px !important;
            width: 115px !important;
            min-width: 115px !important;
            max-width: 115px !important;
        }
    }
</style>

<div class="customers-page">
    <div class="page-heading">
        <div>
            <h1>Customers</h1>
            <p>Manage your customer information in one place.</p>
        </div>

        <a class="btn btn-primary" href="<?= site_url('customers/create') ?>">
            + Add Customer
        </a>
    </div>

    <?php if ($message = session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc($message) ?></div>
    <?php endif; ?>

    <?php if ($message = session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= esc($message) ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-toolbar">
            <h2>Customer Directory</h2>

            <form class="search-form" action="<?= site_url('customers') ?>" method="get">
                <input
                    type="search"
                    name="q"
                    value="<?= esc($search) ?>"
                    placeholder="Search name, email, or phone..."
                    aria-label="Search customers"
                >

                <button class="btn btn-primary" type="submit">Search</button>

                <?php if ($search !== ''): ?>
                    <a class="btn btn-secondary" href="<?= site_url('customers') ?>">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (empty($customers)): ?>
            <div class="empty-state">
                <h3>
                    <?= $search !== '' ? 'No matching customers' : 'No customers yet' ?>
                </h3>

                <p>
                    <?= $search !== ''
                        ? 'Try another name, email address, or phone number.'
                        : 'Add your first customer to get started.' ?>
                </p>

                <?php if ($search === ''): ?>
                    <a class="btn btn-primary" href="<?= site_url('customers/create') ?>">
                        + Add First Customer
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="customers-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td>
                                    <span class="customer-id">
                                        #<?= esc($customer['id']) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="customer-name">
                                        <?= esc($customer['full_name']) ?>
                                    </span>
                                </td>

                                <td><?= esc($customer['email']) ?></td>

                                <td><?= esc($customer['phone'] ?: '—') ?></td>

                                <td><?= esc($customer['created_at'] ?? '—') ?></td>

                                <td>
                                    <div class="actions">
                                        <a
                                            class="btn btn-edit"
                                            href="<?= site_url('customers/edit/' . $customer['id']) ?>"
                                        >Edit</a>

                                        <form
                                            class="inline-form delete-customer-form"
                                            action="<?= site_url('customers/delete/' . $customer['id']) ?>"
                                            method="post"
                                            data-customer-name="<?= esc($customer['full_name'], 'attr') ?>"
                                        >
                                            <?= csrf_field() ?>

                                            <button
                                                type="button"
                                                class="btn btn-delete delete-trigger"
                                            >Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="results-note">
                Showing <?= count($customers) ?> customer(s)
                <?php if ($search !== ''): ?>
                    matching “<?= esc($search) ?>”
                <?php endif; ?>.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal-backdrop" id="deleteModal" aria-hidden="true">
    <div
        class="confirm-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deleteTitle"
    >
        <div class="modal-icon">!</div>

        <h3 id="deleteTitle">Delete customer?</h3>

        <p id="deleteMessage">
            Are you sure you want to delete this customer?
            Existing sales records will be protected.
        </p>

        <div class="modal-actions">
            <button
                type="button"
                class="btn btn-secondary"
                id="cancelDelete"
            >Cancel</button>

            <button
                type="button"
                class="btn btn-danger"
                id="confirmDelete"
            >Yes, Delete</button>
        </div>
    </div>
</div>

<script>
(() => {
    const modal = document.getElementById('deleteModal');
    const message = document.getElementById('deleteMessage');
    const cancelButton = document.getElementById('cancelDelete');
    const confirmButton = document.getElementById('confirmDelete');

    let selectedForm = null;

    /*
     * Put the modal directly inside body.
     * This prevents parent layout containers from affecting positioning.
     */
    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    document.querySelectorAll('.delete-trigger').forEach((button) => {
        button.addEventListener('click', () => {
            selectedForm = button.closest('.delete-customer-form');

            if (!selectedForm) {
                return;
            }

            const customerName =
                selectedForm.dataset.customerName || 'this customer';

            message.textContent =
                `Are you sure you want to delete ${customerName}? Existing sales records will be protected.`;

            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            cancelButton.focus();
        });
    });

    function closeModal() {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        selectedForm = null;
    }

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
        if (
            event.key === 'Escape' &&
            modal.classList.contains('show')
        ) {
            closeModal();
        }
    });
})();
</script>

<?= $this->endSection() ?>