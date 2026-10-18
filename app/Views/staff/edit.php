<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$member = $member ?? [];
$errors = $errors ?? [];
$memberId = $member['id'] ?? null;
?>

<style>
.staff-edit-page {
    max-width: 850px;
    margin: 0 auto;
    padding-bottom: 40px;
    color: #291747;
}
.staff-edit-heading { margin-bottom: 24px; }
.staff-edit-heading h1 { margin: 0 0 8px; font-size: 28px; }
.staff-edit-muted { color: #81758f; font-size: 14px; line-height: 1.6; }
.staff-edit-card {
    background: #fff;
    border: 1px solid #eee7f5;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 5px 20px rgba(41,23,71,.05);
}
.staff-edit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.staff-edit-group { min-width: 0; }
.staff-edit-group.full { grid-column: 1 / -1; }
.staff-edit-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 13px;
    font-weight: 700;
}
.staff-edit-group input {
    width: 100%;
    box-sizing: border-box;
    min-height: 45px;
    padding: 11px 13px;
    border: 1px solid #e2d9ed;
    border-radius: 9px;
    background: #fff;
    color: #291747;
    font: inherit;
    font-size: 14px;
}
.staff-edit-group input:focus {
    outline: 2px solid rgba(137,87,229,.2);
    border-color: #8957e5;
}
.staff-edit-hint {
    margin-top: 7px;
    color: #897b99;
    font-size: 12px;
    line-height: 1.5;
}
.staff-edit-avatar {
    width: 96px;
    height: 96px;
    margin-bottom: 14px;
    border-radius: 16px;
    object-fit: cover;
    background: #f0e7ff;
}
.staff-edit-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #7138c8;
    font-size: 32px;
    font-weight: 700;
}
.staff-edit-alert {
    margin-bottom: 18px;
    padding: 14px 18px;
    border: 1px solid #f1caca;
    border-radius: 10px;
    background: #fff0f0;
    color: #a52232;
    font-size: 13px;
}
.staff-edit-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    margin-top: 28px;
    padding-top: 22px;
    border-top: 1px solid #f0ebf5;
}
.staff-edit-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 43px;
    box-sizing: border-box;
    padding: 0 20px;
    border: 1px solid #e4d9f2;
    border-radius: 9px;
    background: #fff;
    color: #5b2b9a;
    font-family: inherit;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
}
.staff-edit-btn.primary {
    border-color: #7138c8;
    background: #7138c8;
    color: #fff;
}
.staff-edit-btn:hover { filter: brightness(.96); }

@media (max-width: 600px) {
    .staff-edit-card { padding: 20px; }
    .staff-edit-grid { grid-template-columns: 1fr; }
    .staff-edit-group.full { grid-column: auto; }
    .staff-edit-actions { flex-direction: column-reverse; }
    .staff-edit-btn { width: 100%; }
}
</style>

<div class="staff-edit-page">
    <div class="staff-edit-heading">
        <h1>Edit Staff</h1>
        <p class="staff-edit-muted">
            Update this staff member's account information.
        </p>
    </div>

    <?php if ($memberId === null): ?>
        <div class="staff-edit-alert">
            Staff information was not provided to this page.
            Please return to Staff Management and try again.
            <div style="margin-top:12px">
                <a href="<?= site_url('staff') ?>">Return to Staff Management</a>
            </div>
        </div>
    <?php else: ?>

        <?php if (! empty($errors)): ?>
            <div class="staff-edit-alert">
                <strong>Please correct the following:</strong>
                <ul>
                    <?php foreach ($errors as $message): ?>
                        <li><?= esc(is_array($message) ? implode(', ', $message) : $message) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="staff-edit-card">
            <form
                action="<?= site_url('staff/update/' . $memberId) ?>"
                method="post"
                enctype="multipart/form-data"
            >
                <?= csrf_field() ?>

                <div class="staff-edit-grid">
                    <div class="staff-edit-group">
                        <label for="full_name">Full Name</label>
                        <input
                            id="full_name"
                            name="full_name"
                            type="text"
                            maxlength="100"
                            value="<?= esc(old('full_name', $member['full_name'] ?? '')) ?>"
                            autocomplete="name"
                            required
                        >
                    </div>

                    <div class="staff-edit-group">
                        <label for="username">Username</label>
                        <input
                            id="username"
                            name="username"
                            type="text"
                            minlength="3"
                            maxlength="50"
                            value="<?= esc(old('username', $member['username'] ?? '')) ?>"
                            autocomplete="username"
                            required
                        >
                    </div>

                    <div class="staff-edit-group full">
                        <label for="password">New Password (Optional)</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Leave blank to keep the current password"
                        >
                        <p class="staff-edit-hint">
                            Leave this blank to keep the existing password.
                            A new password must contain at least 8 characters.
                        </p>
                    </div>

                    <div class="staff-edit-group full">
                        <label>Current Profile Picture</label>

                        <?php
                        $avatar = $member['avatar'] ?? null;
                        $avatarPath = FCPATH . 'uploads/staff/' . ($avatar ?? '');
                        ?>

                        <?php if (! empty($avatar) && is_file($avatarPath)): ?>
                            <img
                                class="staff-edit-avatar"
                                src="<?= base_url('uploads/staff/' . rawurlencode($avatar)) ?>"
                                alt="Current staff profile picture"
                            >
                        <?php else: ?>
                            <div class="staff-edit-avatar staff-edit-fallback">
                                <?= esc(strtoupper(substr($member['full_name'] ?? '?', 0, 1))) ?>
                            </div>
                        <?php endif; ?>

                        <label for="avatar">Replace Profile Picture (Optional)</label>
                        <input
                            id="avatar"
                            name="avatar"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        >
                        <p class="staff-edit-hint">
                            JPG, JPEG, PNG, or WebP. Maximum size: 2 MB.
                        </p>
                    </div>
                </div>

                <div class="staff-edit-actions">
                    <a class="staff-edit-btn" href="<?= site_url('staff') ?>">Cancel</a>
                    <button class="staff-edit-btn primary" type="submit">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>