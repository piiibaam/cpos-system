<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login | CPOS</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #6d5dfc;
            --primary-dark: #5545e8;
            --text: #202033;
            --muted: #77788c;
            --border: #e8e8f0;
        }

        body {
            min-height: 100vh;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: #f6f5ff;
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-layout {
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 80px rgba(52, 42, 120, 0.12);
        }

        .brand-panel {
            padding: 48px;
            color: #fff;
            background:
                radial-gradient(circle at 15% 15%, rgba(255,255,255,.2), transparent 32%),
                linear-gradient(145deg, #7768ff, #5141d8);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: rgba(255,255,255,.18);
            font-size: 23px;
        }

        .hero h2 {
            font-size: clamp(32px, 4vw, 46px);
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 18px;
        }

        .hero p {
            max-width: 340px;
            color: rgba(255,255,255,.82);
            line-height: 1.8;
            font-size: 15px;
        }

        .feature-list {
            display: grid;
            gap: 15px;
            margin-top: 32px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: rgba(255,255,255,.95);
        }

        .feature span {
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            border-radius: 9px;
            background: rgba(255,255,255,.17);
        }

        .brand-footer {
            color: rgba(255,255,255,.7);
            font-size: 12px;
        }

        .form-panel {
            padding: 60px 52px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .welcome-label {
            color: var(--primary);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            margin-bottom: 12px;
        }

        .form-panel h1 {
            font-size: 32px;
            letter-spacing: -1px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 34px;
        }

        .field {
            margin-bottom: 21px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            background: #fcfcff;
            color: var(--text);
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(109,93,252,.1);
        }

        input::placeholder {
            color: #aaaabb;
        }

        .login-button {
            width: 100%;
            padding: 15px;
            margin-top: 7px;
            border: none;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(109,93,252,.2);
            transition: background .2s, transform .2s;
        }

        .login-button:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .security-note {
            margin-top: 25px;
            text-align: center;
            font-size: 12px;
            color: var(--muted);
        }

        .security-note span {
            color: #28a879;
        }

        @media (max-width: 720px) {
            body {
                padding: 14px;
            }

            .login-layout {
                grid-template-columns: 1fr;
                max-width: 440px;
                min-height: auto;
                border-radius: 22px;
            }

            .brand-panel {
                padding: 28px;
                gap: 36px;
            }

            .hero h2 {
                font-size: 30px;
            }

            .hero p {
                font-size: 14px;
            }

            .feature-list,
            .brand-footer {
                display: none;
            }

            .form-panel {
                padding: 34px 28px 38px;
            }

            .form-panel h1 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <main class="login-layout">
        <section class="brand-panel">
            <div class="brand">
                <div class="brand-icon">▦</div>
                <span>CPOS<span style="color:#d8d3ff">.</span></span>
            </div>

            <div class="hero">
                <h2>Smarter sales.<br>Better business.</h2>
                <p>
                    Your everyday workspace for managing products,
                    tracking sales, and keeping your store running smoothly.
                </p>

                <div class="feature-list">
                    <div class="feature">
                        <span>✓</span> Simple sales management
                    </div>
                    <div class="feature">
                        <span>✓</span> Organized inventory
                    </div>
                    <div class="feature">
                        <span>✓</span> Clear sales records
                    </div>
                </div>
            </div>

            <div class="brand-footer">
                CPOS · Point of Sale Management
            </div>
        </section>

        <section class="form-panel">
            <p class="welcome-label">Staff Portal</p>
            <h1>Welcome back!</h1>
            <p class="subtitle">
                Sign in with your staff account to continue to your workspace.
            </p>

            <form action="<?= site_url('login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="field">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter your username"
                        autocomplete="username"
                        required
                    >
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button class="login-button" type="submit">
                    Sign In to CPOS →
                </button>
            </form>

            <div class="security-note">
                <span>●</span> Secure staff access
            </div>
        </section>
    </main>
</body>
</html>