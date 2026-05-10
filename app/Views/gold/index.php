<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$formatPrice = static fn ($value) => number_format((float) $value, 2, '.', ' ');
?>
<div class="card">
    <h1>Option Gold</h1>
    <p class="subtle">Remise automatique sur les regimes et statut premium.</p>

    <div class="grid">
        <div class="card card-soft">
            <div class="stat-title">Prix Gold</div>
            <div class="stat-value"><?= esc($formatPrice($goldPrice)) ?></div>
        </div>
        <div class="card">
            <div class="stat-title">Remise</div>
            <div class="stat-value"><?= esc($discountPercent) ?>%</div>
        </div>
    </div>
</div>

<div class="card">
    <?php if ($isGold): ?>
        <h3>Gold actif</h3>
        <p class="subtle">Votre compte beneficie de la remise Gold.</p>
        <?php if (! empty($abonnement)): ?>
            <p>Du <?= esc($abonnement['date_debut']) ?> au <?= esc($abonnement['date_fin'] ?? '-') ?></p>
        <?php endif; ?>
    <?php else: ?>
        <h3>Activer Gold</h3>
        <p class="subtle">Debitez votre portefeuille pour activer Gold.</p>
        <form method="post" action="<?= site_url('/gold/subscribe') ?>">
            <?= csrf_field() ?>
            <button class="btn btn-primary" type="submit">Activer Gold</button>
        </form>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
