<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); align-items: center;">
        <div>
            <h1>Regime Alimentaire</h1>
            <p class="subtle">Plan alimentaire, IMC, activites et suivi Gold en une seule interface.</p>
            <div class="actions">
                <a class="btn btn-primary" href="<?= site_url('/register') ?>">Commencer</a>
                <a class="btn btn-ghost" href="<?= site_url('/login') ?>">Login</a>
            </div>
        </div>
        <div class="card card-soft">
            <div class="stat">
                <div class="stat-title">Objectif</div>
                <div class="stat-value">Programme personnalise</div>
            </div>
            <p class="subtle">Inscription en deux etapes: infos perso puis sante.</p>
        </div>
    </div>
</div>

<div class="grid">
    <div class="card">
        <h3>IMC instantane</h3>
        <p class="subtle">Calcul automatique et recommandations claires.</p>
    </div>
    <div class="card">
        <h3>Regimes adaptes</h3>
        <p class="subtle">Selection selon votre objectif et reduction Gold.</p>
    </div>
    <div class="card">
        <h3>Portefeuille simple</h3>
        <p class="subtle">Recharge par code et historique des paiements.</p>
    </div>
</div>
<?= $this->endSection() ?>
