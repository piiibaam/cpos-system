<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'CPOS') ?> | CPOS</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f5fc;
            color: #28213b;
        }

        .app { display: flex; min-height: 100vh; }

        .sidebar {
            width: 245px;
            flex-shrink: 0;
            background: #241642;
            color: white;
            padding: 28px 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 28px;
            border-bottom: 1px solid #49365f;
        }

        .brand-icon {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #8b5cf6;
            font-size: 23px;
        }

        .brand h2 { margin: 0 0 4px; }
        .brand small { color: #c9bce6; }

        .nav { margin-top: 25px; }

        .nav a {
            display: block;
            padding: 13px 14px;
            margin-bottom: 7px;
            border-radius: 9px;
            color: #e6def5;
            text-decoration: none;
        }

        .nav a:hover, .nav a.active {
            background: #7045d6;
            color: white;
        }

        .main { flex: 1; min-width: 0; }

        .topbar {
            min-height: 82px;
            padding: 20px 32px;
            background: white;
            border-bottom: 1px solid #ece7f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .topbar h3 { margin: 0; }

        .staff-name {
            color: #7045d6;
            font-weight: bold;
        }

        .content { padding: 32px; }

        .page-heading { margin-top: 0; }

        .logout-form { margin-top: 30px; }

        .logout {
            width: 100%;
            padding: 12px;
            background: transparent;
            color: #e6def5;
            border: 1px solid #65517c;
            border-radius: 9px;
            cursor: pointer;
        }

        .logout:hover { background: #49365f; }

        @media (max-width: 700px) {
            .app { flex-direction: column; }
            .sidebar { width: 100%; padding: 18px; }
            .brand { padding-bottom: 16px; }
            .nav {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
                margin-top: 14px;
            }
            .nav a { margin: 0; padding: 10px; }
            .logout-form { margin-top: 12px; }
            .logout { width: auto; }
            .topbar, .content { padding: 20px; }
        }
    </style>
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">🛍</div>
            <div>
                <h2>CPOS</h2>
                <small>Point of Sale System</small>
            </div>
        </div>

    <nav class="nav">
        <a href="<?= site_url('dashboard') ?>">&nbsp; <b>Dashboard</b></a>
        <a href="<?= site_url('products') ?>">&nbsp; <b>Products</b></a>
        <a href="<?= site_url('customers') ?>">&nbsp; <b>Customers</b></a>
        <a href="<?= site_url('staff') ?>">&nbsp; <b>Staff</b></a>
        <a href="<?= site_url('sales/create') ?>">&nbsp; <b>Record Sale</b></a>
        <a href="<?= site_url('sales/history') ?>">&nbsp; <b>Sales History</b></a> </nav>
        
    <form class="logout-form"
              action="<?= site_url('logout') ?>" method="post">
            <?= csrf_field() ?>
            <button class="logout" type="submit">↪ Sign Out</button>
        </form>
    </aside>

    <div class="main">
        <header class="topbar">
            <h3><?= esc($title ?? 'CPOS') ?></h3>
            <span class="staff-name">
                <?= esc(session()->get('full_name') ?? 'Staff') ?>
            </span>
        </header>

        <main class="content">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>
</body>
</html>