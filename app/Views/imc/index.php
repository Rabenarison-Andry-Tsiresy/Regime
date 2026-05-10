<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <h1>IMC</h1>
    <p class="subtle">Synthese rapide de votre indice de masse corporelle.</p>

    <div class="grid">
        <div class="card card-soft">
            <div class="stat-title">Valeur IMC</div>
            <div class="stat-value"><?= esc($imc) ?></div>
        </div>
        <div class="card">
            <div class="stat-title">Categorie</div>
            <div class="stat-value"><?= esc($categorie) ?></div>
        </div>
        <div class="card">
            <div class="stat-title">Recommendation</div>
            <div class="stat-value"><?= esc($recommandation) ?></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
