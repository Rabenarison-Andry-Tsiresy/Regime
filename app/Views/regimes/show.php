<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$discountRate = $isGold ? ((float) $discountPercent / 100) : 0.0;
$formatPrice = static fn ($value) => number_format((float) $value, 2, '.', ' ');
$prix = (float) $regime['prix'];
$prixFinal = $isGold ? $prix - ($prix * $discountRate) : $prix;
?>
<div class="card">
    <h1><?= esc($regime['nom']) ?></h1>
    <p class="subtle">Duree: <?= esc($regime['duree_jours']) ?> jours</p>
    <p><?= esc($regime['description'] ?? '') ?></p>

    <div class="grid">
        <div class="card card-soft">
            <div class="stat-title">Prix</div>
            <div class="stat-value"><?= esc($formatPrice($prixFinal)) ?></div>
        </div>
        <div class="card">
            <div class="stat-title">Variation poids</div>
            <div class="stat-value"><?= esc($regime['variation_poids'] ?? '-') ?></div>
        </div>
        <div class="card">
            <div class="stat-title">Composition</div>
            <div class="stat-value">Viande <?= esc($regime['pourcentage_viande']) ?>% / Poisson <?= esc($regime['pourcentage_poisson']) ?>% / Volaille <?= esc($regime['pourcentage_volaille']) ?>%</div>
        </div>
    </div>

    <div class="actions">
        <form method="post" action="<?= site_url('/regimes/apply/' . $regime['id']) ?>">
            <?= csrf_field() ?>
            <button class="btn btn-primary" type="submit">Activer ce regime</button>
        </form>
        <a class="btn btn-ghost" href="<?= site_url('/regimes') ?>">Retour</a>
    </div>
</div>
<?= $this->endSection() ?>
