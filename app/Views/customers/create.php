<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .customer-form-page { max-width:850px; margin:0 auto; padding-bottom:40px; }
    .page-heading { margin-bottom:24px; }
    .page-heading h1 { margin:0 0 8px; color:#281747; font-size:30px; font-weight:750; }
    .page-heading p { margin:0; color:#777087; font-size:14px; line-height:1.6; }
    .form-card { padding:30px; border:1px solid #eee8f6; border-radius:18px; background:#fff; box-shadow:0 8px 28px rgba(40,23,71,.06); }
    .section-title { margin:0 0 22px; color:#281747; font-size:17px; font-weight:700; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:22px; }
    .form-group { display:flex; flex-direction:column; gap:8px; min-width:0; }
    .form-group.full-width { grid-column:1/-1; }
    .form-group label { color:#35264b; font-size:13px; font-weight:650; }
    .form-group input { box-sizing:border-box; width:100%; min-height:46px; padding:11px 13px; border:1px solid #ded6e9; border-radius:9px; background:#fff; color:#281747; font-size:14px; outline:none; }
    .form-group input:focus { border-color:#8957e5; box-shadow:0 0 0 3px rgba(137,87,229,.12); }
    .form-hint { margin:0; color:#898197; font-size:12px; line-height:1.5; }
    .form-actions { display:flex; justify-content:flex-end; gap:12px; margin-top:30px; padding-top:24px; border-top:1px solid #eee8f6; }
    .btn { display:inline-flex; justify-content:center; align-items:center; box-sizing:border-box; min-height:43px; padding:0 20px; border-radius:9px; font-size:13px; font-weight:700; text-decoration:none; cursor:pointer; }
    .btn-primary { border:1px solid #8150df; background:#8150df; color:#fff; }
    .btn-primary:hover { background:#6d3dc8; }
    .btn-secondary { border:1px solid #ded6e9; background:#fff; color:#514663; }
    .btn-secondary:hover { background:#f7f3fc; }
    .alert-error { margin-bottom:20px; padding:13px 16px; border:1px solid #f3cccc; border-radius:10px; background:#fff0f0; color:#a12c2c; font-size:13px; }
    .validation-errors { margin:4px 0 0; padding-left:18px; color:#b42323; font-size:12px; }
    @media(max-width:650px) {
        .form-card { padding:20px; }
        .form-grid { grid-template-columns:1fr; gap:18px; }
        .form-group.full-width { grid-column:auto; }
        .page-heading h1 { font-size:25px; }
        .form-actions { flex-direction:column-reverse; }
        .btn { width:100%; }
    }
</style>

<div class="customer-form-page">
    <div class="page-heading">
        <h1>Add Customer</h1>
        <p>Enter the customer's details to add them to your directory.</p>
    </div>

    <?php $errors = session()->getFlashdata('errors') ?? []; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert-error">
            <strong>Please check the following:</strong>
            <ul class="validation-errors">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form action="<?= site_url('customers/store') ?>" method="post">
            <?= csrf_field() ?>

            <h2 class="section-title">Customer Information</h2>

            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="full_name">Full Name</label>
                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        value="<?= esc(old('full_name', '')) ?>"
                        maxlength="100"
                        placeholder="Enter customer's full name"
                        autocomplete="name"
                        required
                    >
                    <?php if (isset($errors['full_name'])): ?>
                        <ul class="validation-errors"><li><?= esc($errors['full_name']) ?></li></ul>
                    <?php endif; ?>
                </div>

                <div class="form-group full-width">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= esc(old('email', '')) ?>"
                        maxlength="100"
                        placeholder="customer@example.com"
                        autocomplete="email"
                        required
                    >
                    <?php if (isset($errors['email'])): ?>
                        <ul class="validation-errors"><li><?= esc($errors['email']) ?></li></ul>
                    <?php endif; ?>
                </div>

                <div class="form-group full-width">
                    <label for="phone">Phone Number <span style="font-weight:400;color:#898197;">(optional)</span></label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="<?= esc(old('phone', '')) ?>"
                        maxlength="20"
                        placeholder="Enter phone number"
                        autocomplete="tel"
                    >
                    <p class="form-hint">You may leave this blank if the customer has no phone number to provide.</p>
                    <?php if (isset($errors['phone'])): ?>
                        <ul class="validation-errors"><li><?= esc($errors['phone']) ?></li></ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= site_url('customers') ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Customer</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>