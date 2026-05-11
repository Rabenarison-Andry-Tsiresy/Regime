<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$discountRate = $isGold ? ((float) $discountPercent / 100) : 0.0;
$formatPrice = static fn ($value) => number_format((float) $value, 2, '.', ' ');
$formatCalories = static fn ($value) => number_format((float) $value, 0, '.', ' ');
$compositionLabels = [
    'pourcentage_viande' => 'Viande',
    'pourcentage_poisson' => 'Poisson',
    'pourcentage_volaille' => 'Volaille',
    'pourcentage_legumes_verts' => 'Legumes verts',
    'pourcentage_fruits' => 'Fruits',
    'pourcentage_feculents' => 'Feculents',
];
$buildComposition = static function (array $regime) use ($compositionLabels, $formatCalories): array {
    $caloriesCible = isset($regime['calories_cible']) ? (int) $regime['calories_cible'] : 0;
    $lines = [];
    foreach ($compositionLabels as $field => $label) {
        $percent = (int) ($regime[$field] ?? 0);
        $line = $label . ' ' . $percent . '%';
        if ($caloriesCible > 0) {
            $calories = (int) round($caloriesCible * ($percent / 100));
            $line .= ' (' . $formatCalories($calories) . ' kcal)';
        }
        $lines[] = $line;
    }

    return [$lines, $caloriesCible];
};
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
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
            <?php foreach ($regimes as $regime): ?>
                <?php
                $prix = (float) $regime['prix'];
                $prixFinal = $isGold ? $prix - ($prix * $discountRate) : $prix;
                [$compositionLines, $caloriesCible] = $buildComposition($regime);
                ?>
                <div class="card card-soft">
                    <h3><?= esc($regime['nom']) ?></h3>
                    <p class="subtle"><?= esc($regime['duree_jours']) ?> jours | <?= esc($objectifMap[$regime['objectif_id']] ?? 'Tous') ?></p>
                    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));">
                        <div>
                            <div class="stat-title">Prix</div>
                            <div class="stat-value"><?= esc($formatPrice($prixFinal)) ?></div>
                        </div>
                        <div>
                            <div class="stat-title">Calories cible</div>
                            <div class="stat-value"><?= $caloriesCible > 0 ? esc($formatCalories($caloriesCible)) . ' kcal' : '-' ?></div>
                        </div>
                    </div>
                    <div class="subtle" style="margin-top: 0.5rem;">
                        <?php foreach ($compositionLines as $line): ?>
                            <div><?= esc($line) ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="actions">
                        <a class="btn btn-ghost" href="<?= site_url('/regimes/' . $regime['id']) ?>">Detail</a>
                        <form class="inline-form" method="post" action="<?= site_url('/regimes/apply/' . $regime['id']) ?>">
                            <?= csrf_field() ?>
                            <button class="btn btn-primary" type="submit">Activer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
