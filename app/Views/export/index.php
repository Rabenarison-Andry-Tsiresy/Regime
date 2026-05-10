<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$formatPrice = static fn ($value) => number_format((float) $value, 2, '.', ' ');
?>
<div class="card">
    <h1>Export programme</h1>
    <p class="subtle">Date: <?= esc(date('Y-m-d')) ?></p>

    <div class="grid">
        <div class="card card-soft">
            <div class="stat-title">Utilisateur</div>
            <div class="stat-value"><?= esc($user['nom'] ?? '-') ?></div>
            <p class="subtle"><?= esc($user['email'] ?? '-') ?></p>
        </div>
        <div class="card">
            <div class="stat-title">Objectif</div>
            <div class="stat-value"><?= esc($objectif['label'] ?? '-') ?></div>
            <p class="subtle">IMC: <?= esc($profil['imc'] ?? '-') ?></p>
        </div>
    </div>
</div>

<div class="card">
    <h2>Regime</h2>
    <?php if (! empty($regime) && ! empty($activeRegime)): ?>
        <p><strong><?= esc($regime['nom']) ?></strong> (<?= esc($activeRegime['date_debut']) ?> - <?= esc($activeRegime['date_fin']) ?>)</p>
        <p class="subtle">Prix applique: <?= esc($formatPrice($activeRegime['prix_applique'])) ?></p>
        <p><?= esc($regime['description'] ?? '') ?></p>
    <?php else: ?>
        <p class="subtle">Aucun regime actif.</p>
    <?php endif; ?>
</div>

<div class="card">
    <h2>Activites recommandees</h2>
    <?php if (empty($activites)): ?>
        <p class="subtle">Aucune activite associee.</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($activites as $activite): ?>
                <div class="card card-soft">
                    <h3><?= esc($activite['nom']) ?></h3>
                    <p class="subtle"><?= esc($activite['description'] ?? '') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="actions no-print">
    <button class="btn btn-primary" type="button" onclick="window.print()">Imprimer / PDF</button>
</div>
<?= $this->endSection() ?>
