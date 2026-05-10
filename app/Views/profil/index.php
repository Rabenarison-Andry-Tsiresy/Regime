<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <h1>Mon profil</h1>
    <p class="subtle">Mettez a jour vos informations pour un programme adapte.</p>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="grid">
        <div class="card card-soft">
            <h3>Apercu</h3>
            <p><strong>Nom:</strong> <?= esc($user['nom'] ?? '-') ?></p>
            <p><strong>Email:</strong> <?= esc($user['email'] ?? '-') ?></p>
            <p><strong>Gold:</strong> <?= ! empty($currentUser['premium']) ? 'Actif' : 'Inactif' ?></p>
            <p><strong>IMC:</strong> <?= esc($profil['imc'] ?? '-') ?></p>
        </div>
        <div class="card">
            <h3>Modifier</h3>
            <form method="post" action="<?= site_url('/profil') ?>">
                <?= csrf_field() ?>
                <div class="field">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?= esc(old('nom', $user['nom'] ?? '')) ?>" required>
                    <?php if (! empty($errors['nom'])): ?>
                        <div class="error"><?= esc($errors['nom']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="<?= esc(old('age', $user['age'] ?? '')) ?>">
                    <?php if (! empty($errors['age'])): ?>
                        <div class="error"><?= esc($errors['age']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="sexe_id">Genre</label>
                    <select id="sexe_id" name="sexe_id">
                        <option value="">Choisir</option>
                        <?php foreach ($sexes as $sexe): ?>
                            <option value="<?= esc($sexe['id']) ?>" <?= old('sexe_id', $user['sexe_id'] ?? '') == $sexe['id'] ? 'selected' : '' ?>>
                                <?= esc($sexe['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (! empty($errors['sexe_id'])): ?>
                        <div class="error"><?= esc($errors['sexe_id']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="taille_cm">Taille (cm)</label>
                    <input type="number" step="0.01" id="taille_cm" name="taille_cm" value="<?= esc(old('taille_cm', $profil['taille_cm'] ?? '')) ?>" required>
                    <?php if (! empty($errors['taille_cm'])): ?>
                        <div class="error"><?= esc($errors['taille_cm']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="poids_kg">Poids (kg)</label>
                    <input type="number" step="0.01" id="poids_kg" name="poids_kg" value="<?= esc(old('poids_kg', $profil['poids_kg'] ?? '')) ?>" required>
                    <?php if (! empty($errors['poids_kg'])): ?>
                        <div class="error"><?= esc($errors['poids_kg']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="objectif_id">Objectif</label>
                    <select id="objectif_id" name="objectif_id" required>
                        <option value="">Choisir</option>
                        <?php foreach ($objectifs as $objectif): ?>
                            <option value="<?= esc($objectif['id']) ?>" <?= old('objectif_id', $profil['objectif_id'] ?? '') == $objectif['id'] ? 'selected' : '' ?>>
                                <?= esc($objectif['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (! empty($errors['objectif_id'])): ?>
                        <div class="error"><?= esc($errors['objectif_id']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="actions">
                    <button class="btn btn-primary" type="submit">Sauvegarder</button>
                    <a class="btn btn-ghost" href="<?= site_url('/imc') ?>">Voir IMC</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
