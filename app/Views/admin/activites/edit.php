<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= view('admin/_menu') ?>

<div class="card">
    <h1>Modifier une activite</h1>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('/admin/activites/update/' . $activite['id']) ?>">
        <?= csrf_field() ?>
        <div class="field">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?= esc(old('nom', $activite['nom'])) ?>" required>
        </div>
        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"><?= esc(old('description', $activite['description'] ?? '')) ?></textarea>
        </div>
        <div class="field">
            <label for="intensite">Intensite</label>
            <input type="text" id="intensite" name="intensite" value="<?= esc(old('intensite', $activite['intensite'] ?? '')) ?>">
        </div>
        <div class="field">
            <label for="objectif_id">Objectif</label>
            <select id="objectif_id" name="objectif_id">
                <option value="">Tous</option>
                <?php foreach ($objectifs as $objectif): ?>
                    <option value="<?= esc($objectif['id']) ?>" <?= old('objectif_id', $activite['objectif_id'] ?? '') == $objectif['id'] ? 'selected' : '' ?>>
                        <?= esc($objectif['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Mettre a jour</button>
            <a class="btn btn-ghost" href="<?= site_url('/admin/activites') ?>">Annuler</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
