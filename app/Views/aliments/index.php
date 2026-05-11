<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <h1>Catalogue aliments</h1>
    <p class="subtle">Recommandations alimentaires selon votre objectif.</p>
</div>

<?php if (empty($aliments)): ?>
    <div class="card">
        <p class="subtle">Aucun aliment disponible pour le moment.</p>
    </div>
<?php else: ?>
    <div class="grid">
        <?php foreach ($aliments as $aliment): ?>
            <div class="card">
                <h3><?= esc($aliment['nom']) ?></h3>
                <?php if (! empty($aliment['categorie'])): ?>
                    <p class="subtle">Categorie: <?= esc($aliment['categorie']) ?></p>
                <?php endif; ?>
                <?php if (! empty($aliment['description'])): ?>
                    <p><?= esc($aliment['description']) ?></p>
                <?php endif; ?>
                <?php if (! empty($aliment['recommandation'])): ?>
                    <p><strong>Recommandation:</strong> <?= esc($aliment['recommandation']) ?></p>
                <?php endif; ?>
                <p><span class="tag"><?= esc($objectifMap[$aliment['objectif_id']] ?? 'Tous') ?></span></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
