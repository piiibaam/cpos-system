<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$sales = $sales ?? [];
$search = $search ?? '';
$totalSales = $totalSales ?? 0;
?>

<style>
.history-page {
    max-width: 1250px;
    margin: 0 auto;
    color: #29213d;
}
.history-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}
.history-title {
    margin: 0 0 5px;
    font-size: 25px;
    font-weight: 750;
}
.history-subtitle {
    margin: 0;
    font-size: 14px;
    color: #81758f;
}
.history-primary {
    display: inline-block;
    text-decoration: none;
    background: #7545c7;
    color: white;
    padding: 12px 17px;
    border-radius: 10px;
    font-weight: 650;
}
.history-primary:hover {
    background: #6033ad;
    color: white;
}
.history-summary {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}
.history-stat {
    border: 1px solid #ece7f4;
    border-radius: 16px;
    padding: 22px;
    background: white;
    box-shadow: 0 6px 20px rgba(49, 25, 84, .04);
}
.history-stat-label {
    color: #81758f;
    font-size: 13px;
    margin-bottom: 8px;
}
.history-stat-value {
    font-size: 25px;
    font-weight: 750;
    color: #7040c4;
}
.history-card {
    background: white;
    border: 1px solid #ece7f4;
    border-radius: 16px;
    padding: 22px;
    box-shadow: 0 6px 20px rgba(49, 25, 84, .04);
}
.history-search {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}
.history-search input {
    flex: 1;
    min-width: 200px;
    padding: 11px 13px;
    border: 1px solid #dcd5e8;
    border-radius: 10px;
    font-size: 14px;
}
.history-search button,
.history-reset {
    border: 0;
    border-radius: 10px;
    padding: 11px 17px;
    background: #7545c7;
    color: white;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
}
.history-reset {
    background: #f0ebf8;
    color: #5f438c;
    display: inline-flex;
    align-items: center;
}
.history-table-wrap {
    width: 100%;
    overflow-x: auto;
}
.history-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    white-space: nowrap;
}
.history-table th {
    text-align: left;
    background: #f7f3fc;
    color: #685781;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .35px;
    padding: 14px 13px;
}
.history-table td {
    padding: 15px 13px;
    border-bottom: 1px solid #f0ecf5;
}
.history-table tbody tr:hover {
    background: #fcfaff;
}
.history-id {
    color: #7040c4;
    font-weight: 700;
}
.history-amount {
    font-weight: 700;
    color: #4c3478;
}
.history-empty {
    padding: 40px 15px;
    text-align: center;
    color: #81758f;
}
@media (max-width: 650px) {
    .history-summary { grid-template-columns: 1fr; }
    .history-card { padding: 14px; }
    .history-stat { padding: 18px; }
}
</style>

<div class="history-page">
    <div class="history-header">
        <div>
            <h2 class="history-title">Sales History</h2>
            <p class="history-subtitle">
                Review recorded transactions and sales totals.
            </p>
        </div>
        <a class="history-primary" href="<?= site_url('sales/create') ?>">
            + Record New Sale
        </a>
    </div>

    <div class="history-summary">
        <div class="history-stat">
            <div class="history-stat-label">Matching Transactions</div>
            <div class="history-stat-value">
                <?= number_format(count($sales)) ?>
            </div>
        </div>

        <div class="history-stat">
            <div class="history-stat-label">Total of Matching Sales</div>
            <div class="history-stat-value">
                ₱<?= number_format((float) $totalSales, 2) ?>
            </div>
        </div>
    </div>

    <div class="history-card">
        <form action="<?= site_url('sales/history') ?>" method="get" class="history-search">
            <input
                type="search"
                name="q"
                value="<?= esc($search) ?>"
                placeholder="Search product, customer, staff, or date..."
                aria-label="Search sales history"
            >
            <button type="submit">Search</button>

            <?php if ($search !== ''): ?>
                <a class="history-reset" href="<?= site_url('sales/history') ?>">
                    Clear
                </a>
            <?php endif; ?>
        </form>

        <div class="history-table-wrap">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Date &amp; Time</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Staff</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($sales)): ?>
                        <tr>
                            <td colspan="7" class="history-empty">
                                <div style="font-size:30px;margin-bottom:8px;">🧾</div>
                                <strong>No sales found</strong>
                                <div style="margin-top:6px;">
                                    Record your first sale or try another search.
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td class="history-id">
                                    #<?= esc($sale['id']) ?>
                                </td>
                                <td>
                                    <?= esc(date('M d, Y h:i A', strtotime($sale['created_at']))) ?>
                                </td>
                                <td>
                                    <?= esc($sale['product_name'] ?? 'Product unavailable') ?>
                                </td>
                                <td>
                                    <?= esc($sale['customer_name'] ?? 'Walk-in / No customer') ?>
                                </td>
                                <td>
                                    <?= esc($sale['staff_name'] ?? 'Staff unavailable') ?>
                                </td>
                                <td>
                                    <?= number_format((int) $sale['quantity']) ?>
                                </td>
                                <td class="history-amount">
                                    ₱<?= number_format((float) $sale['total_price'], 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>