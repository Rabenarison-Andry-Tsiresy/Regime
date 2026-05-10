<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= view('admin/_menu') ?>

<div class="card">
    <h1>Parametres systeme</h1>
    <p class="subtle">Seuils IMC et configuration Gold.</p>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('/admin/parametres/update') ?>">
        <?= csrf_field() ?>
        <div class="grid">
            <div class="field">
                <label for="imc_underweight_max">IMC insuffisant max</label>
                <input type="number" step="0.01" id="imc_underweight_max" name="imc_underweight_max" value="<?= esc(old('imc_underweight_max', $params['imc_underweight_max'])) ?>" required>
            </div>
            <div class="field">
                <label for="imc_normal_max">IMC normal max</label>
                <input type="number" step="0.01" id="imc_normal_max" name="imc_normal_max" value="<?= esc(old('imc_normal_max', $params['imc_normal_max'])) ?>" required>
            </div>
            <div class="field">
                <label for="imc_overweight_max">IMC surpoids max</label>
                <input type="number" step="0.01" id="imc_overweight_max" name="imc_overweight_max" value="<?= esc(old('imc_overweight_max', $params['imc_overweight_max'])) ?>" required>
            </div>
            <div class="field">
                <label for="gold_price">Prix Gold</label>
                <input type="number" step="0.01" id="gold_price" name="gold_price" value="<?= esc(old('gold_price', $params['gold_price'])) ?>" required>
            </div>
            <div class="field">
                <label for="gold_discount_percent">Remise Gold (%)</label>
                <input type="number" step="0.01" id="gold_discount_percent" name="gold_discount_percent" value="<?= esc(old('gold_discount_percent', $params['gold_discount_percent'])) ?>" required>
            </div>
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Mettre a jour</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
