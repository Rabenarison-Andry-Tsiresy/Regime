<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= view('admin/_menu') ?>

<div class="card">
    <h1>Ajouter un aliment</h1>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('/admin/aliments/store') ?>">
        <?= csrf_field() ?>
        <div class="field">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?= esc(old('nom')) ?>" required>
        </div>
        <div class="field">
            <label for="categorie">Categorie</label>
            <input type="text" id="categorie" name="categorie" value="<?= esc(old('categorie')) ?>">
        </div>
        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"><?= esc(old('description')) ?></textarea>
        </div>
        <div class="field">
            <label for="recommandation">Recommandation</label>
            <textarea id="recommandation" name="recommandation" rows="3"><?= esc(old('recommandation')) ?></textarea>
        </div>
        <div class="field">
            <label for="objectif_id">Objectif</label>
            <select id="objectif_id" name="objectif_id">
                <option value="">Tous</option>
                <?php foreach ($objectifs as $objectif): ?>
                    <option value="<?= esc($objectif['id']) ?>" <?= old('objectif_id') == $objectif['id'] ? 'selected' : '' ?>>
                        <?= esc($objectif['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="field">
            <label for="actif">Actif</label>
            <select id="actif" name="actif">
                <option value="1" <?= old('actif', '1') == '1' ? 'selected' : '' ?>>Oui</option>
                <option value="0" <?= old('actif') == '0' ? 'selected' : '' ?>>Non</option>
            </select>
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Enregistrer</button>
            <a class="btn btn-ghost" href="<?= site_url('/admin/aliments') ?>">Annuler</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
