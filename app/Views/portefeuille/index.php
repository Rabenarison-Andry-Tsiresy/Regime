<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$formatPrice = static fn ($value) => number_format((float) $value, 2, '.', ' ');
$typeLabels = [
    'recharge' => 'Recharge',
    'regime' => 'Regime',
    'gold' => 'Gold',
];
?>
<div class="card">
    <h1>Portefeuille</h1>
    <p class="subtle">Solde disponible et recharges par code.</p>

    <div class="grid">
        <div class="card card-soft">
            <div class="stat-title">Solde</div>
            <div class="stat-value"><?= esc($formatPrice($portefeuille['solde'] ?? 0)) ?></div>
        </div>
        <div class="card">
            <div class="stat-title">Recharge rapide</div>
            <form method="post" action="<?= site_url('/portefeuille/recharge') ?>">
                <?= csrf_field() ?>
                <div class="field">
                    <label for="code">Code</label>
                    <input type="text" id="code" name="code" value="<?= esc(old('code')) ?>" placeholder="EX: GOLD2026" required>
                    <?php if (! empty($errors['code'])): ?>
                        <div class="error"><?= esc($errors['code']) ?></div>
                    <?php endif; ?>
                </div>
                <button class="btn btn-primary" type="submit">Recharger</button>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <h2>Historique</h2>
    <?php if (empty($paiements)): ?>
        <p class="subtle">Aucun paiement pour le moment.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Reference</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paiements as $paiement): ?>
                    <tr>
                        <td><?= esc($typeLabels[$paiement['type']] ?? $paiement['type']) ?></td>
                        <td><?= esc($formatPrice($paiement['montant'])) ?></td>
                        <td><?= esc($paiement['reference'] ?? '-') ?></td>
                        <td><?= esc($paiement['created_at'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
