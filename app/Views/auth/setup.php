<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create First Staff Account | CPOS</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: Arial, sans-serif;
            background: #f5f3ff;
            color: #241b3b;
        }
        .card {
            width: 100%;
            max-width: 440px;
            padding: 32px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 12px 40px #30205b18;
        }
        h1 { margin-top: 0; }
        p { color: #716b80; line-height: 1.5; }
        label { display: block; margin: 16px 0 7px; font-weight: bold; }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd6ef;
            border-radius: 9px;
            font-size: 15px;
        }
        button {
            width: 100%;
            margin-top: 24px;
            padding: 13px;
            border: 0;
            border-radius: 9px;
            background: #7045d6;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }
        .error { color: #b42318; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Set up CPOS</h1>
        <p>Create your first staff account. Choose a strong, unique password.</p>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="error">
                <?= esc(session()->getFlashdata('error')) ?>
            </p>
        <?php endif; ?>

        <?php foreach (session()->getFlashdata('errors') ?? [] as $error): ?>
            <p class="error"><?= esc($error) ?></p>
        <?php endforeach; ?>

        <form action="<?= site_url('setup') ?>" method="post">
            <?= csrf_field() ?>

            <label for="full_name">Full name</label>
            <input id="full_name" name="full_name"
                   value="<?= esc(old('full_name') ?? '') ?>"
                   maxlength="100" required>

            <label for="username">Username</label>
            <input id="username" name="username"
                   value="<?= esc(old('username') ?? '') ?>"
                   minlength="3" maxlength="50"
                   pattern="[A-Za-z0-9]+"
                   autocomplete="username" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password"
                   minlength="8" maxlength="72"
                   autocomplete="new-password" required>

            <label for="password_confirm">Confirm password</label>
            <input id="password_confirm" name="password_confirm"
                   type="password" minlength="8" maxlength="72"
                   autocomplete="new-password" required>

            <button type="submit">Create Staff Account</button>
        </form>
    </main>
</body>
</html>