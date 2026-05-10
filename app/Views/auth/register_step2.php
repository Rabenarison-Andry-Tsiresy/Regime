<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <h1>Inscription - Etape 2</h1>
    <p class="subtle">Donnees de sante</p>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('/register/health') ?>">
        <?= csrf_field() ?>
        <div class="field">
            <label for="taille_cm">Taille (cm)</label>
            <input type="number" step="0.01" id="taille_cm" name="taille_cm" value="<?= esc(old('taille_cm')) ?>" required>
            <?php if (! empty($errors['taille_cm'])): ?>
                <div class="error"><?= esc($errors['taille_cm']) ?></div>
            <?php endif; ?>
        </div>
        <div class="field">
            <label for="poids_kg">Poids (kg)</label>
            <input type="number" step="0.01" id="poids_kg" name="poids_kg" value="<?= esc(old('poids_kg')) ?>" required>
            <?php if (! empty($errors['poids_kg'])): ?>
                <div class="error"><?= esc($errors['poids_kg']) ?></div>
            <?php endif; ?>
        </div>
        <div class="field">
            <label for="objectif_id">Objectif</label>
            <select id="objectif_id" name="objectif_id" required>
                <option value="">Choisir</option>
                <?php foreach ($objectifs as $objectif): ?>
                    <option value="<?= esc($objectif['id']) ?>" <?= old('objectif_id') == $objectif['id'] ? 'selected' : '' ?>>
                        <?= esc($objectif['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (! empty($errors['objectif_id'])): ?>
                <div class="error"><?= esc($errors['objectif_id']) ?></div>
            <?php endif; ?>
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Creer le compte</button>
            <a class="btn btn-ghost" href="<?= site_url('/register') ?>">Retour</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
