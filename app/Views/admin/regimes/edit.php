<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= view('admin/_menu') ?>

<div class="card">
    <h1>Modifier un regime</h1>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('/admin/regimes/update/' . $regime['id']) ?>">
        <?= csrf_field() ?>
        <div class="field">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?= esc(old('nom', $regime['nom'])) ?>" required>
        </div>
        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"><?= esc(old('description', $regime['description'] ?? '')) ?></textarea>
        </div>
        <div class="field">
            <label for="duree_jours">Duree (jours)</label>
            <input type="number" id="duree_jours" name="duree_jours" value="<?= esc(old('duree_jours', $regime['duree_jours'])) ?>" required>
        </div>
        <div class="field">
            <label for="prix">Prix</label>
            <input type="number" step="0.01" id="prix" name="prix" value="<?= esc(old('prix', $regime['prix'])) ?>" required>
        </div>
        <div class="field">
            <label for="calories_cible">Calories cible (kcal/jour)</label>
            <input type="number" id="calories_cible" name="calories_cible" value="<?= esc(old('calories_cible', $regime['calories_cible'] ?? '')) ?>" required>
        </div>
        <div class="field">
            <label for="variation_poids">Variation poids</label>
            <input type="number" step="0.01" id="variation_poids" name="variation_poids" value="<?= esc(old('variation_poids', $regime['variation_poids'] ?? '')) ?>">
        </div>
        <div class="field">
            <label for="pourcentage_viande">% Viande</label>
            <input type="number" id="pourcentage_viande" name="pourcentage_viande" value="<?= esc(old('pourcentage_viande', $regime['pourcentage_viande'])) ?>" required>
        </div>
        <div class="field">
            <label for="pourcentage_poisson">% Poisson</label>
            <input type="number" id="pourcentage_poisson" name="pourcentage_poisson" value="<?= esc(old('pourcentage_poisson', $regime['pourcentage_poisson'])) ?>" required>
        </div>
        <div class="field">
            <label for="pourcentage_volaille">% Volaille</label>
            <input type="number" id="pourcentage_volaille" name="pourcentage_volaille" value="<?= esc(old('pourcentage_volaille', $regime['pourcentage_volaille'])) ?>" required>
        </div>
        <div class="field">
            <label for="pourcentage_legumes_verts">% Legumes verts</label>
            <input type="number" id="pourcentage_legumes_verts" name="pourcentage_legumes_verts" value="<?= esc(old('pourcentage_legumes_verts', $regime['pourcentage_legumes_verts'] ?? '')) ?>" required>
        </div>
        <div class="field">
            <label for="pourcentage_fruits">% Fruits</label>
            <input type="number" id="pourcentage_fruits" name="pourcentage_fruits" value="<?= esc(old('pourcentage_fruits', $regime['pourcentage_fruits'] ?? '')) ?>" required>
        </div>
        <div class="field">
            <label for="pourcentage_feculents">% Feculents</label>
            <input type="number" id="pourcentage_feculents" name="pourcentage_feculents" value="<?= esc(old('pourcentage_feculents', $regime['pourcentage_feculents'] ?? '')) ?>" required>
        </div>
        <div class="field">
            <label for="objectif_id">Objectif</label>
            <select id="objectif_id" name="objectif_id">
                <option value="">Tous</option>
                <?php foreach ($objectifs as $objectif): ?>
                    <option value="<?= esc($objectif['id']) ?>" <?= old('objectif_id', $regime['objectif_id'] ?? '') == $objectif['id'] ? 'selected' : '' ?>>
                        <?= esc($objectif['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Mettre a jour</button>
            <a class="btn btn-ghost" href="<?= site_url('/admin/regimes') ?>">Annuler</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
