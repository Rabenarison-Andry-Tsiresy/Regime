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
        <div style="margin-top: 1rem;">
            <h3>Activer Gold par code</h3>
            <p class="subtle">Entrez votre code VIP pour activer Gold.</p>
            <form method="post" action="<?= site_url('/gold/redeem') ?>">
                <?= csrf_field() ?>
                <div class="field">
                    <label for="code">Code Gold</label>
                    <input type="text" id="code" name="code" value="<?= esc(old('code')) ?>" placeholder="EX: gyu26f4tjer4" required>
                    <?php if (! empty($errors['code'])): ?>
                        <div class="error"><?= esc($errors['code']) ?></div>
                    <?php endif; ?>
                </div>
                <button class="btn btn-secondary" type="submit">Valider le code</button>
            </form>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
