<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .welcome {
        margin-bottom: 25px;
    }

    .welcome h1 {
        margin: 0 0 8px;
        color: #30204f;
        font-size: 27px;
    }

    .welcome p {
        margin: 0;
        color: #817792;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .stat-card, .panel {
        background: white;
        border: 1px solid #ece7f5;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 5px 18px #30205b08;
    }

    .stat-label {
        color: #817792;
        font-size: 14px;
        margin-bottom: 12px;
    }

    .stat-number {
        color: #30204f;
        font-size: 29px;
        font-weight: bold;
        overflow-wrap: anywhere;
    }

    .stat-icon {
        font-size: 23px;
        margin-bottom: 12px;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }

    .panel {
        min-width: 0;
        margin-bottom: 20px;
    }

    .panel h2 {
        font-size: 18px;
        margin: 0 0 18px;
        color: #30204f;
    }

    .actions {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .action {
        display: block;
        text-decoration: none;
        text-align: center;
        padding: 13px 10px;
        background: #f3efff;
        color: #7045d6;
        font-weight: bold;
        border-radius: 9px;
    }

    .action:hover {
        background: #e7ddff;
    }

    .table-wrap {
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .dashboard-table th {
        text-align: left;
        color: #817792;
        font-weight: 600;
        background: #faf9fd;
    }

    .dashboard-table th,
    .dashboard-table td {
        padding: 12px 10px;
        border-bottom: 1px solid #eeeaf5;
        white-space: nowrap;
    }

    .dashboard-table td {
        color: #4b4260;
    }

    .stock-badge {
        display: inline-block;
        padding: 5px 8px;
        border-radius: 6px;
        background: #fff0d9;
        color: #945b00;
        font-weight: bold;
    }

    .empty {
        color: #817792;
        font-size: 14px;
        padding: 12px 0;
    }

    .view-all {
        display: inline-block;
        margin-top: 15px;
        color: #7045d6;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
    }

    @media (max-width: 1050px) {
        .stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .stats {
            grid-template-columns: 1fr;
        }

        .stat-card, .panel {
            padding: 16px;
        }
    }
</style>

<div class="welcome">
    <h1>Welcome back, <?= esc(session()->get('full_name') ?? 'Staff') ?>!</h1>
    <p>Here's what's happening in your store today.</p>
</div>

<div class="stats">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-label">Total Products</div>
        <div class="stat-number"><?= number_format($productCount) ?></div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-label">Total Customers</div>
        <div class="stat-number"><?= number_format($customerCount) ?></div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🧑‍💼</div>
        <div class="stat-label">Total Staff</div>
        <div class="stat-number"><?= number_format($staffCount) ?></div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🧾</div>
        <div class="stat-label">Recorded Sales</div>
        <div class="stat-number"><?= number_format($salesCount) ?></div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-label">Total Sales Revenue</div>
        <div class="stat-number">₱<?= number_format((float) $salesRevenue, 2) ?></div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="panel">
        <h2>Recent Sales</h2>

        <?php if (! empty($recentSales)): ?>
            <div class="table-wrap">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentSales as $sale): ?>
                            <tr>
                                <td><?= esc($sale['product_name']) ?></td>
                                <td><?= number_format((int) $sale['quantity']) ?></td>
                                <td>₱<?= number_format((float) $sale['total_price'], 2) ?></td>
                                <td><?= esc(date('M d, Y', strtotime($sale['created_at']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="empty">No sales recorded yet. Your transactions will appear here.</p>
        <?php endif; ?>

        <a class="view-all" href="<?= site_url('sales/history') ?>">View all sales →</a>
    </div>

    <div>
        <div class="panel">
            <h2>Quick Actions</h2>
            <div class="actions">
                <a class="action" href="<?= site_url('sales/create') ?>">＋ Record Sale</a>
                <a class="action" href="<?= site_url('products') ?>">📦 Products</a>
                <a class="action" href="<?= site_url('customers') ?>">👥 Customers</a>
                <a class="action" href="<?= site_url('staff') ?>">🧑‍💼 Staff</a>
            </div>
        </div>

        <div class="panel">
            <h2>⚠️ Low Stock Alerts</h2>

            <?php if (! empty($lowStock)): ?>
                <div class="table-wrap">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Remaining</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lowStock as $product): ?>
                                <tr>
                                    <td><?= esc($product['name']) ?></td>
                                    <td>
                                        <span class="stock-badge">
                                            <?= number_format((int) $product['stock_quantity']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="empty">No low-stock products. Looking good!</p>
            <?php endif; ?>

            <a class="view-all" href="<?= site_url('products') ?>">Manage products →</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>