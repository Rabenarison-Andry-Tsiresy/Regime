<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <h1>Activites sportives</h1>
    <p class="subtle">Selection d'activites selon votre objectif.</p>
</div>

<?php if (empty($activites)): ?>
    <div class="card">
        <p class="subtle">Aucune activite disponible pour le moment.</p>
    </div>
<?php else: ?>
    <div class="grid">
        <?php foreach ($activites as $activite): ?>
            <div class="card">
                <h3><?= esc($activite['nom']) ?></h3>
                <p class="subtle"><?= esc($activite['description'] ?? '') ?></p>
                <p><span class="tag"><?= esc($objectifMap[$activite['objectif_id']] ?? 'Tous') ?></span></p>
                <?php if (! empty($activite['intensite'])): ?>
                    <p><strong>Intensite:</strong> <?= esc($activite['intensite']) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
