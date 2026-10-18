<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
.staff-form-page { max-width:850px; margin:0 auto; color:#291747; }
.staff-form-heading { margin-bottom:22px; }
.staff-form-heading h1 { margin:0 0 7px; font-size:28px; }
.staff-form-muted { color:#81758f; font-size:14px; }
.staff-form-card { background:#fff; border:1px solid #eee7f5; border-radius:16px; padding:28px; box-shadow:0 5px 20px #29174708; }
.staff-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.staff-form-group { margin-bottom:20px; }
.staff-form-group.full { grid-column:1/-1; }
.staff-form-group label { display:block; margin-bottom:8px; font-size:13px; font-weight:700; }
.staff-form-group input { display:block; width:100%; box-sizing:border-box; padding:12px 14px; border:1px solid #e2d9ed; border-radius:10px; background:#fff; color:#291747; font:inherit; font-size:14px; outline:none; }
.staff-form-group input:focus { border-color:#8b5cf6; box-shadow:0 0 0 3px #8b5cf61a; }
.staff-form-hint { margin-top:7px; color:#897b99; font-size:12px; }
.staff-form-error { color:#c93649; font-size:12px; margin-top:7px; }
.staff-form-alert { padding:12px 15px; margin-bottom:18px; border-radius:10px; background:#fff0f0; color:#b42332; font-size:13px; }
.staff-form-actions { display:flex; justify-content:flex-end; gap:10px; border-top:1px solid #f0ebf5; padding-top:20px; margin-top:4px; }
.staff-form-btn { display:inline-flex; justify-content:center; align-items:center; padding:11px 18px; border:1px solid #e4d9f2; border-radius:10px; background:white; color:#5b2b9a; font-weight:600; font-size:13px; text-decoration:none; cursor:pointer; }
.staff-form-btn.primary { background:#7138c8; border-color:#7138c8; color:#fff; }
@media(max-width:600px) { .staff-form-grid { grid-template-columns:1fr; gap:0; } .staff-form-group.full { grid-column:auto; } .staff-form-card { padding:20px; } }
</style>

<div class="staff-form-page">
    <div class="staff-form-heading">
        <h1>Add Staff</h1>
        <div class="staff-form-muted">Create a new staff account for your POS system.</div>
    </div>

    <?php if (! empty($errors)): ?>
        <div class="staff-form-alert">
            Please correct the following:
            <ul>
                <?php foreach ($errors as $message): ?>
                    <li><?= esc($message) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <div class="staff-form-card">
        <form action="<?= site_url('staff/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="staff-form-grid">
                <div class="staff-form-group">
                    <label for="full_name">Full Name</label>
                    <input id="full_name" name="full_name" type="text" maxlength="100"
                           value="<?= esc(old('full_name')) ?>" placeholder="Enter full name" required>
                </div>

                <div class="staff-form-group">
                    <label for="username">Username</label>
                    <input id="username" name="username" type="text" minlength="3" maxlength="50"
                           value="<?= esc(old('username')) ?>" placeholder="Choose a username" required>
                </div>

                <div class="staff-form-group full">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" minlength="8"
                           placeholder="Create a password" required>
                    <div class="staff-form-hint">Use at least 8 characters. Passwords are stored as secure hashes.</div>
                </div>

                <div class="staff-form-group full">
                    <label for="avatar">Profile Picture (Optional)</label>
                    <input id="avatar" name="avatar" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                    <div class="staff-form-hint">JPG, JPEG, PNG, or WebP. Maximum size: 2 MB.</div>
                </div>
            </div>

            <div class="staff-form-actions">
                <a class="staff-form-btn" href="<?= site_url('staff') ?>">Cancel</a>
                <button class="staff-form-btn primary" type="submit">Create Staff Account</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>