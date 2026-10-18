<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$staffList = $staff ?? $members ?? [];
$searchTerm = $search ?? '';
?>

<style>
.staff-page {
    color: #291747;
    max-width: 1400px;
    margin: 0 auto;
}

.staff-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.staff-page-header h1 {
    font-size: 28px;
    margin: 0 0 6px;
}

.staff-subtitle {
    color: #81758f;
    font-size: 14px;
}

.staff-add-btn,
.staff-search-btn,
.staff-edit-btn,
.staff-delete-btn,
.staff-modal-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    box-sizing: border-box;
    border-radius: 10px;
    padding: 10px 16px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 600;
    line-height: 18px;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
    transition: background .15s ease, transform .15s ease;
}

.staff-add-btn,
.staff-search-btn {
    color: white;
    background: #7138c8;
    border: 1px solid #7138c8;
}

.staff-add-btn:hover,
.staff-search-btn:hover {
    background: #5c28a8;
}

.staff-card {
    overflow: hidden;
    background: #fff;
    border: 1px solid #eee7f5;
    border-radius: 16px;
    box-shadow: 0 5px 20px #29174708;
}

.staff-card-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    padding: 18px 20px;
    border-bottom: 1px solid #eee7f5;
}

.staff-card-title {
    font-weight: 700;
    font-size: 14px;
}

.staff-search-form {
    display: flex;
    align-items: center;
    gap: 8px;
}

.staff-search-input {
    width: 225px;
    max-width: 100%;
    box-sizing: border-box;
    padding: 10px 13px;
    border: 1px solid #e2d9ed;
    border-radius: 10px;
    font-family: inherit;
    font-size: 13px;
    outline: none;
}

.staff-search-input:focus {
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px #8b5cf61a;
}

.staff-table-wrap {
    width: 100%;
    overflow-x: auto;
}

.staff-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.staff-table thead {
    background: #faf8fd;
}

.staff-table th {
    padding: 14px 16px;
    color: #81758f;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    white-space: nowrap;
}

.staff-table td {
    padding: 15px 16px;
    border-top: 1px solid #f0ebf5;
    font-size: 12px;
    vertical-align: middle;
}

.staff-table tbody tr:hover {
    background: #fdfbff;
}

.staff-id {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 9px;
    border-radius: 7px;
    background: #f0e7ff;
    color: #7138c8;
    font-size: 11px;
    font-weight: 700;
}

.staff-person {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 190px;
}

.staff-avatar {
    width: 40px;
    height: 40px;
    min-width: 40px;
    border-radius: 50%;
    object-fit: cover;
    background: #f0e7ff;
}

.staff-avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #7138c8;
    font-weight: 700;
    font-size: 14px;
}

.staff-person-name {
    font-weight: 600;
    color: #291747;
}

.staff-username {
    color: #5b2b9a;
    font-weight: 500;
}

.staff-date {
    color: #81758f;
    white-space: nowrap;
}

.staff-action-group {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;
    flex-wrap: wrap;
    min-height: 38px;
}

.staff-edit-btn {
    background: #fff;
    color: #7138c8;
    border: 1px solid #e5d7f7;
    min-width: 58px;
}

.staff-edit-btn:hover {
    background: #f6f0ff;
}

.staff-delete-btn {
    background: #fff;
    color: #c93649;
    border: 1px solid #f2cbd0;
}

.staff-delete-btn:hover {
    background: #fff1f2;
}

.staff-signed-in {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 10px;
    border-radius: 8px;
    background: #f0fbf4;
    color: #21834b;
    font-size: 12px;
    font-weight: 600;
    line-height: 18px;
    white-space: nowrap;
}

.staff-status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #29a65a;
    flex-shrink: 0;
}

.staff-card-footer {
    padding: 15px 20px;
    border-top: 1px solid #f0ebf5;
    color: #81758f;
    font-size: 12px;
}

.staff-empty {
    text-align: center;
    padding: 45px 20px !important;
    color: #81758f;
}

/* Centered delete modal */
.staff-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
    background: rgba(35, 19, 54, .55);
    backdrop-filter: blur(3px);
}

.staff-modal-overlay.is-open {
    display: flex;
}

.staff-modal {
    width: 100%;
    max-width: 400px;
    box-sizing: border-box;
    padding: 28px;
    border-radius: 18px;
    background: #fff;
    color: #291747;
    box-shadow: 0 20px 70px #160a2533;
    text-align: center;
    animation: staffModalIn .18s ease-out;
}

@keyframes staffModalIn {
    from { opacity: 0; transform: translateY(8px) scale(.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.staff-modal-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    margin: 0 auto 16px;
    border-radius: 14px;
    background: #fff0f0;
    color: #c93649;
    font-size: 25px;
    font-weight: 800;
}

.staff-modal h2 {
    margin: 0 0 10px;
    font-size: 20px;
}

.staff-modal p {
    margin: 0;
    color: #81758f;
    font-size: 13px;
    line-height: 1.7;
    overflow-wrap: anywhere;
}

.staff-modal-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 24px;
}

.staff-modal-btn {
    min-width: 100px;
    min-height: 40px;
}

.staff-modal-cancel {
    border: 1px solid #e2d9ed;
    background: #fff;
    color: #5b4b6e;
}

.staff-modal-confirm {
    border: 1px solid #cf3445;
    background: #cf3445;
    color: #fff;
}

.staff-modal-confirm:hover {
    background: #b92335;
}

.staff-alert {
    padding: 13px 16px;
    margin-bottom: 18px;
    border-radius: 10px;
    font-size: 13px;
}

.staff-alert-success {
    background: #f0fbf4;
    color: #21834b;
}

.staff-alert-error {
    background: #fff0f0;
    color: #b42332;
}

@media (max-width: 700px) {
    .staff-page-header h1 {
        font-size: 24px;
    }

    .staff-card-toolbar {
        align-items: stretch;
        flex-direction: column;
    }

    .staff-search-form {
        width: 100%;
    }

    .staff-search-input {
        flex: 1;
        width: auto;
        min-width: 0;
    }

    .staff-table th,
    .staff-table td {
        padding: 12px;
    }

    .staff-modal {
        padding: 24px 20px;
    }
}
</style>

<div class="staff-page">
    <div class="staff-page-header">
        <div>
            <h1>Staff Management</h1>
            <div class="staff-subtitle">Manage staff accounts and profile photos.</div>
        </div>

        <a class="staff-add-btn" href="<?= site_url('staff/create') ?>">
            + Add Staff
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="staff-alert staff-alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="staff-alert staff-alert-error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif ?>

    <div class="staff-card">
        <div class="staff-card-toolbar">
            <div class="staff-card-title">Staff Directory</div>

            <form class="staff-search-form" action="<?= site_url('staff') ?>" method="get">
                <input
                    class="staff-search-input"
                    type="search"
                    name="search"
                    placeholder="Search name or username..."
                    value="<?= esc($searchTerm) ?>"
                >
                <button class="staff-search-btn" type="submit">Search</button>
            </form>
        </div>

        <div class="staff-table-wrap">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Staff Member</th>
                        <th>Username</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (! empty($staffList)): ?>
                    <?php foreach ($staffList as $member): ?>
                        <?php
                            $memberId = (int) ($member['id'] ?? 0);
                            $isCurrentUser = $memberId === (int) session()->get('user_id');
                            $avatar = $member['avatar'] ?? '';
                            $fullName = $member['full_name'] ?? 'Unnamed Staff';
                            $username = $member['username'] ?? '';
                        ?>

                        <tr>
                            <td>
                                <span class="staff-id">#<?= $memberId ?></span>
                            </td>

                            <td>
                                <div class="staff-person">
                                    <?php if ($avatar !== '' && is_file(FCPATH . 'uploads/staff/' . $avatar)): ?>
                                        <img
                                            class="staff-avatar"
                                            src="<?= base_url('uploads/staff/' . rawurlencode($avatar)) ?>"
                                            alt="Staff avatar"
                                        >
                                    <?php else: ?>
                                        <div class="staff-avatar staff-avatar-fallback">
                                            <?= esc(strtoupper(substr($fullName, 0, 1))) ?>
                                        </div>
                                    <?php endif ?>

                                    <span class="staff-person-name">
                                        <?= esc($fullName) ?>
                                    </span>
                                </div>
                            </td>

                            <td>
                                <span class="staff-username"><?= esc($username) ?></span>
                            </td>

                            <td>
                                <span class="staff-date">
                                    <?= esc($member['created_at'] ?? '—') ?>
                                </span>
                            </td>

                            <td>
                                <div class="staff-action-group">
                                    <a
                                        class="staff-edit-btn"
                                        href="<?= site_url('staff/edit/' . $memberId) ?>"
                                    >Edit</a>

                                    <?php if ($isCurrentUser): ?>
                                        <span class="staff-signed-in">
                                            <span class="staff-status-dot"></span>
                                            Signed in
                                        </span>
                                    <?php else: ?>
                                        <button
                                            class="staff-delete-btn"
                                            type="button"
                                            data-delete-id="<?= $memberId ?>"
                                            data-delete-name="<?= esc($fullName, 'attr') ?>"
                                        >Delete</button>

                                        <form
                                            id="staff-delete-form-<?= $memberId ?>"
                                            action="<?= site_url('staff/delete/' . $memberId) ?>"
                                            method="post"
                                            style="display:none"
                                        >
                                            <?= csrf_field() ?>
                                        </form>
                                    <?php endif ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td class="staff-empty" colspan="5">
                            No staff accounts found.
                        </td>
                    </tr>
                <?php endif ?>
                </tbody>
            </table>
        </div>

        <div class="staff-card-footer">
            Showing <?= count($staffList) ?> staff account(s).
        </div>
    </div>
</div>

<div class="staff-modal-overlay" id="staffDeleteModal" aria-hidden="true">
    <div
        class="staff-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="staffDeleteTitle"
        aria-describedby="staffDeleteDescription"
    >
        <div class="staff-modal-icon">!</div>
        <h2 id="staffDeleteTitle">Delete staff account?</h2>
        <p id="staffDeleteDescription">
            Are you sure you want to delete this staff account?
        </p>

        <div class="staff-modal-actions">
            <button class="staff-modal-btn staff-modal-cancel" id="staffCancelDelete" type="button">
                Cancel
            </button>
            <button class="staff-modal-btn staff-modal-confirm" id="staffConfirmDelete" type="button">
                Yes, Delete
            </button>
        </div>
    </div>
</div>

<script>
(() => {
    const modal = document.getElementById('staffDeleteModal');
    const description = document.getElementById('staffDeleteDescription');
    const cancelButton = document.getElementById('staffCancelDelete');
    const confirmButton = document.getElementById('staffConfirmDelete');

    if (!modal || !description || !cancelButton || !confirmButton) {
        return;
    }

    let selectedFormId = null;

    document.querySelectorAll('[data-delete-id]').forEach((button) => {
        button.addEventListener('click', () => {
            const id = button.dataset.deleteId;
            const name = button.dataset.deleteName || 'this staff member';

            selectedFormId = 'staff-delete-form-' + id;
            description.textContent =
                'Are you sure you want to delete ' + name +
                '? This action cannot be undone.';

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            cancelButton.focus();
        });
    });

    const closeModal = () => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        selectedFormId = null;
    };

    cancelButton.addEventListener('click', closeModal);

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    confirmButton.addEventListener('click', () => {
        if (!selectedFormId) {
            return;
        }

        const form = document.getElementById(selectedFormId);

        if (form) {
            confirmButton.disabled = true;
            confirmButton.textContent = 'Deleting...';
            form.submit();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
            closeModal();
        }
    });
})();
</script>

<?= $this->endSection() ?>