<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Bibliotheque') ?></title>
    <style>
        :root {
            --bg: #141a22;
            --ink: #e6edf7;
            --ink-soft: #a5b1c3;
            --line: #2d3949;
            --card: #1d2633;
            --field-bg: #2a3545;
            --field-border: #5b6d84;
            --field-placeholder: #bcc8d8;
            --success: #4eb283;
            --danger: #d97b7b;
            --warning: #c99a59;
            --primary: #3f6ea5;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: var(--ink);
            font-family: "Trebuchet MS", "Verdana", sans-serif;
            background: var(--bg);
            min-height: 100vh;
        }
        .container { max-width: 1120px; margin: 0 auto; padding: 24px; }
        .nav {
            position: sticky;
            top: 0;
            z-index: 20;
            background: #1b2430;
            border-bottom: 1px solid var(--line);
            color: #fff;
            padding: 14px 20px;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }
        .nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 12px;
            padding: 8px 14px;
            border-radius: 999px;
            font-weight: 700;
            opacity: .92;
            transition: background-color .15s ease;
        }
        .nav a:hover {
            background: #2b3747;
        }
        .card {
            background: var(--card);
            border-radius: 14px;
            padding: 20px;
            border: 1px solid var(--line);
            margin-bottom: 18px;
        }
        h1, h2 { margin: 0 0 12px; letter-spacing: .2px; }
        .subtle { color: var(--ink-soft); margin-top: 0; }
        .alert { padding: 13px 15px; border-radius: 14px; margin-bottom: 16px; font-weight: 600; }
        .alert-success { background: #1f3229; color: #b9e6ce; border: 1px solid #325742; }
        .alert-error { background: #3a2427; color: #ffd0d0; border: 1px solid #744248; }
        .btn {
            border: none;
            border-radius: 999px;
            padding: 10px 15px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 700;
            transition: opacity .15s ease;
        }
        .btn:hover { opacity: .9; }
        .btn-primary { background: var(--primary); color: #f3f8ff; }
        .btn-danger { background: #8f4b4b; color: #fff; }
        .btn-warning { background: #8c6c42; color: #fff; }
        .btn-success { background: #3e7f5f; color: #fff; }
        .status {
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: .86rem;
        }
        .status-dispo { color: #bcead0; background: #1f3229; border: 1px solid #325742; }
        .status-prete { color: #ffd0d0; background: #3a2427; border: 1px solid #744248; }
        .field { margin-bottom: 14px; }
        .field label { display: block; margin-bottom: 6px; font-weight: 700; }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        input[type="search"],
        select,
        textarea {
            width: 100%;
            max-width: 100%;
            padding: 10px;
            border: 1px solid var(--field-border);
            border-radius: 10px;
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
            background: var(--field-bg);
            color: var(--ink);
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="password"]:focus,
        input[type="search"]:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid rgba(123, 161, 205, .45);
            border-color: #7ba1cd;
        }
        .actions input,
        .actions select,
        .inline-form input {
            width: auto;
            min-width: 180px;
        }
        .error { color: #ffabab; font-size: .9rem; margin-top: 4px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 11px 10px; vertical-align: top; }
        th { background: #202b3a; font-size: .95rem; color: #c0d0e5; }
        th, td { border-bottom: 1px solid #314055; }
        tbody tr:hover td { background: #202b39; }
        .inline-form { display: inline-flex; gap: 8px; align-items: center; margin: 0; }
        .inline-form input { width: 170px; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .pagination { margin-top: 16px; }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 7px 11px;
            margin-right: 6px;
            border-radius: 8px;
            border: 1px solid #41556f;
            text-decoration: none;
            color: #d8e6f9;
            background: #1e2836;
        }
        .pagination a:hover { background: #2a374a; }
        .book-cover { max-width: 240px; border-radius: 12px; border: 1px solid #41556f; }
        .book-meta { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 8px 16px; }
        a { color: #9cc2e3; }
        a:hover { color: #bed8ee; }
        @media (max-width: 768px) {
            .container { padding: 14px; }
            .actions { flex-direction: column; align-items: flex-start; }
            .inline-form { flex-direction: column; align-items: stretch; width: 100%; }
            .inline-form input { width: 100%; }
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            tr { margin-bottom: 12px; background: #1a2533; border: 1px solid #35465f; border-radius: 10px; padding: 8px; }
            td { border: none; padding: 6px 8px; }
        }
    </style>
</head>
<body>
<nav class="nav">
    <a href="<?= site_url('/') ?>">Catalogue</a>
    <a href="<?= site_url('/livres/create') ?>">Ajouter un livre</a>
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
