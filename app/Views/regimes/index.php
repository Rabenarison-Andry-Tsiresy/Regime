<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$discountRate = $isGold ? ((float) $discountPercent / 100) : 0.0;
$formatPrice = static fn ($value) => number_format((float) $value, 2, '.', ' ');
?>
<div class="card">
    <h1>Regimes</h1>
    <p class="subtle">Choisissez un regime selon votre objectif. Remise Gold appliquee automatiquement.</p>

    <div class="grid">
        <div class="card card-soft">
            <div class="stat-title">Statut Gold</div>
            <div class="stat-value"><?= $isGold ? 'Actif' : 'Inactif' ?></div>
        </div>
        <div class="card">
            <div class="stat-title">Remise</div>
            <div class="stat-value"><?= esc($discountPercent) ?>%</div>
        </div>
    </div>
</div>

<?php if (! empty($activeRegimeDetails) && ! empty($activeRegime)): ?>
    <div class="card card-soft">
        <h3>Regime actif</h3>
        <p><strong><?= esc($activeRegimeDetails['nom']) ?></strong> du <?= esc($activeRegime['date_debut']) ?> au <?= esc($activeRegime['date_fin']) ?></p>
        <p class="subtle">Prix applique: <?= esc($formatPrice($activeRegime['prix_applique'])) ?> | Remise: <?= esc($formatPrice($activeRegime['remise_appliquee'])) ?></p>
    </div>
<?php endif; ?>

<?php if (! empty($suggestion)): ?>
    <div class="card">
        <h3>Suggestion rapide</h3>
        <p><strong><?= esc($suggestion['nom']) ?></strong> (<?= esc($suggestion['duree_jours']) ?> jours)</p>
        <div class="actions">
            <a class="btn btn-secondary" href="<?= site_url('/regimes/' . $suggestion['id']) ?>">Voir le detail</a>
        </div>
    </div>
<?php endif; ?>

<div class="card">
    <h2>Catalogue</h2>
    <?php if (empty($regimes)): ?>
        <p class="subtle">Aucun regime disponible pour le moment.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Duree</th>
                    <th>Prix</th>
                    <th>Objectif</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($regimes as $regime): ?>
                    <?php
                    $prix = (float) $regime['prix'];
                    $prixFinal = $isGold ? $prix - ($prix * $discountRate) : $prix;
                    ?>
                    <tr>
                        <td><?= esc($regime['nom']) ?></td>
                        <td><?= esc($regime['duree_jours']) ?> jours</td>
                        <td><?= esc($formatPrice($prixFinal)) ?></td>
                        <td><?= esc($objectifMap[$regime['objectif_id']] ?? 'Tous') ?></td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-ghost" href="<?= site_url('/regimes/' . $regime['id']) ?>">Detail</a>
                                <form class="inline-form" method="post" action="<?= site_url('/regimes/apply/' . $regime['id']) ?>">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-primary" type="submit">Activer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
