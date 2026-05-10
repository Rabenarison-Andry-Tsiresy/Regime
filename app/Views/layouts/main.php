<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Regime Alimentaire') ?></title>
    <style>
        :root {
            --bg: #f5f2ee;
            --bg-alt: #eff4f0;
            --ink: #1e2a33;
            --ink-soft: #5a6a76;
            --line: #e2d7cc;
            --card: #ffffff;
            --field-bg: #f5f1ec;
            --field-border: #cbbfb2;
            --field-placeholder: #7d8a93;
            --accent: #d27745;
            --accent-2: #2f6f70;
            --accent-3: #8b6f47;
            --success: #2f7d5a;
            --danger: #a35454;
            --warning: #b8823c;
            --shadow: 0 20px 40px rgba(31, 42, 51, 0.12);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: var(--ink);
            font-family: "Avenir Next", "Gill Sans", "Trebuchet MS", sans-serif;
            background: linear-gradient(120deg, var(--bg) 0%, var(--bg-alt) 45%, #f4f7fb 100%);
            min-height: 100vh;
            position: relative;
        }
        body::before,
        body::after {
            content: "";
            position: fixed;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            z-index: 0;
            opacity: 0.18;
            filter: blur(0);
            pointer-events: none;
        }
        body::before {
            background: radial-gradient(circle, #f0c9a8 0%, transparent 65%);
            top: -140px;
            right: -120px;
        }
        body::after {
            background: radial-gradient(circle, #a8d7d2 0%, transparent 70%);
            bottom: -160px;
            left: -130px;
        }
        .container { max-width: 1120px; margin: 0 auto; padding: 28px 20px 40px; position: relative; z-index: 1; }
        .nav {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid var(--line);
            color: var(--ink);
            padding: 14px 20px;
            backdrop-filter: blur(10px);
        }
        .nav-inner {
            max-width: 1120px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
        }
        .brand a {
            text-decoration: none;
            color: var(--ink);
            font-size: 1.05rem;
            letter-spacing: 0.4px;
        }
        .brand-tag {
            font-size: 0.72rem;
            text-transform: uppercase;
            background: #f2d6bf;
            color: #7b4f34;
            padding: 3px 8px;
            border-radius: 999px;
            font-weight: 700;
        }
        .nav-links,
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .nav a {
            color: var(--ink);
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 999px;
            font-weight: 700;
            transition: background-color 0.15s ease, color 0.15s ease;
        }
        .nav a:hover { background: #f1e7dc; }
        .nav-user { font-weight: 700; color: var(--ink-soft); }
        .card {
            background: var(--card);
            border-radius: 18px;
            padding: 22px;
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            margin-bottom: 18px;
            animation: floatIn 0.6s ease;
        }
        .card-soft {
            background: #fff7f1;
            border-color: #ead5c4;
        }
        h1, h2, h3 { margin: 0 0 12px; letter-spacing: 0.2px; }
        p { margin: 0 0 12px; }
        .subtle { color: var(--ink-soft); margin-top: 0; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }
        .alert { padding: 13px 15px; border-radius: 14px; margin-bottom: 16px; font-weight: 700; }
        .alert-success { background: #e3f2ea; color: #2d6a4f; border: 1px solid #c4e3d3; }
        .alert-error { background: #f6e3e3; color: #7b3e3e; border: 1px solid #e6c3c3; }
        .btn {
            border: none;
            border-radius: 999px;
            padding: 10px 16px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 700;
            transition: transform 0.12s ease, box-shadow 0.12s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 8px 16px rgba(31, 42, 51, 0.12); }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-secondary { background: var(--accent-2); color: #fff; }
        .btn-ghost { background: #f2e7dc; color: #6b4c3a; }
        .btn-danger { background: #b05e5e; color: #fff; }
        .btn-warning { background: #c08a3f; color: #fff; }
        .btn-success { background: #3f7e61; color: #fff; }
        .tag {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
            background: #eef4f7;
            color: #37566b;
        }
        .field { margin-bottom: 14px; }
        .field label { display: block; margin-bottom: 6px; font-weight: 700; }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        input[type="search"],
        input[type="datetime-local"],
        select,
        textarea {
            width: 100%;
            max-width: 100%;
            padding: 10px;
            border: 1px solid var(--field-border);
            border-radius: 12px;
            background: var(--field-bg);
            color: var(--ink);
        }
        input[type="text"]::placeholder,
        input[type="email"]::placeholder,
        input[type="number"]::placeholder,
        input[type="password"]::placeholder,
        input[type="search"]::placeholder,
        .inline-form input::placeholder,
        textarea::placeholder {
            color: var(--field-placeholder);
        }
        select option {
            background: #fff;
            color: var(--ink);
        }
        input:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid rgba(210, 119, 69, 0.35);
            border-color: #d39b7c;
        }
        .actions input,
        .actions select,
        .inline-form input { width: auto; min-width: 180px; }
        .error { color: #a35454; font-size: 0.88rem; margin-top: 4px; font-weight: 700; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 12px 10px; vertical-align: top; }
        th { background: #f7f1ea; font-size: 0.95rem; color: #6b5a49; }
        th, td { border-bottom: 1px solid #e7dcd1; }
        tbody tr:hover td { background: #faf4ef; }
        .inline-form { display: inline-flex; gap: 8px; align-items: center; margin: 0; }
        .inline-form input { width: 170px; }
        .actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .stat { background: #f6efe8; padding: 12px; border-radius: 14px; border: 1px solid #ead5c4; }
        .stat-title { font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6b5a49; margin-bottom: 6px; }
        .stat-value { font-size: 1.3rem; font-weight: 800; }
        a { color: #2f6f70; }
        a:hover { color: #214f4f; }
        @media (max-width: 900px) {
            .nav-inner { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 768px) {
            .container { padding: 18px; }
            .actions { flex-direction: column; align-items: stretch; }
            .inline-form { flex-direction: column; align-items: stretch; width: 100%; }
            .inline-form input { width: 100%; }
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            tr { margin-bottom: 12px; background: #fff; border: 1px solid #eaded1; border-radius: 12px; padding: 8px; }
            td { border: none; padding: 6px 8px; }
        }
        @media print {
            body { background: #fff; }
            .nav, .no-print { display: none !important; }
            .card { box-shadow: none; }
        }
        @keyframes floatIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<nav class="nav">
    <div class="nav-inner">
        <div class="brand">
            <a href="<?= site_url('/') ?>">Regime S4</a>
            <span class="brand-tag">Nutrition</span>
        </div>
        <div class="nav-links">
            <a href="<?= site_url('/regimes') ?>">Regimes</a>
            <a href="<?= site_url('/activites') ?>">Activites</a>
            <a href="<?= site_url('/imc') ?>">IMC</a>
            <a href="<?= site_url('/portefeuille') ?>">Portefeuille</a>
            <a href="<?= site_url('/gold') ?>">Gold</a>
            <a href="<?= site_url('/export') ?>">Export</a>
        </div>
        <div class="nav-actions">
            <?php if (! empty($isAdmin)): ?>
                <a class="btn btn-ghost" href="<?= site_url('/admin') ?>">Admin</a>
            <?php endif; ?>
            <?php if (! empty($currentUser)): ?>
                <span class="nav-user">Salut <?= esc($currentUser['nom'] ?? '') ?></span>
                <a class="btn btn-ghost" href="<?= site_url('/logout') ?>">Logout</a>
            <?php else: ?>
                <a class="btn btn-ghost" href="<?= site_url('/login') ?>">Login</a>
                <a class="btn btn-primary" href="<?= site_url('/register') ?>">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="container">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</main>
</body>
</html>
