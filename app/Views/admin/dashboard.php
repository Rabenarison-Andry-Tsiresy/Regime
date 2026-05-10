<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= view('admin/_menu') ?>

<div class="card">
    <h1>Dashboard</h1>
    <p class="subtle">Vue rapide des activites et donnees.</p>
</div>

<div class="grid">
    <div class="card card-soft">
        <div class="stat-title">Utilisateurs</div>
        <div class="stat-value"><?= esc($userCount) ?></div>
    </div>
    <div class="card">
        <div class="stat-title">Admins</div>
        <div class="stat-value"><?= esc($adminCount) ?></div>
    </div>
    <div class="card">
        <div class="stat-title">Regimes</div>
        <div class="stat-value"><?= esc($regimeCount) ?></div>
    </div>
    <div class="card">
        <div class="stat-title">Activites</div>
        <div class="stat-value"><?= esc($activiteCount) ?></div>
    </div>
    <div class="card">
        <div class="stat-title">Paiements</div>
        <div class="stat-value"><?= esc($paiementCount) ?></div>
    </div>
</div>
<?= $this->endSection() ?>
