<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$discountRate = $isGold ? ((float) $discountPercent / 100) : 0.0;
$formatPrice = static fn ($value) => number_format((float) $value, 2, '.', ' ');
$formatCalories = static fn ($value) => number_format((float) $value, 0, '.', ' ');
$prix = (float) $regime['prix'];
$prixFinal = $isGold ? $prix - ($prix * $discountRate) : $prix;
$compositionLabels = [
    'pourcentage_viande' => 'Viande',
    'pourcentage_poisson' => 'Poisson',
    'pourcentage_volaille' => 'Volaille',
    'pourcentage_legumes_verts' => 'Legumes verts',
    'pourcentage_fruits' => 'Fruits',
    'pourcentage_feculents' => 'Feculents',
];
$caloriesCible = isset($regime['calories_cible']) ? (int) $regime['calories_cible'] : 0;
$compositionLines = [];
foreach ($compositionLabels as $field => $label) {
    $percent = (int) ($regime[$field] ?? 0);
    $line = $label . ' ' . $percent . '%';
    if ($caloriesCible > 0) {
        $calories = (int) round($caloriesCible * ($percent / 100));
        $line .= ' (' . $formatCalories($calories) . ' kcal)';
    }
    $compositionLines[] = $line;
}
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
            <div class="stat-title">Calories cible</div>
            <div class="stat-value"><?= $caloriesCible > 0 ? esc($formatCalories($caloriesCible)) . ' kcal' : '-' ?></div>
        </div>
        <div class="card">
            <div class="stat-title">Composition</div>
            <div class="stat-value">
                <?php foreach ($compositionLines as $line): ?>
                    <div><?= esc($line) ?></div>
                <?php endforeach; ?>
            </div>
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
