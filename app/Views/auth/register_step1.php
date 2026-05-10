<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <h1>Inscription - Etape 1</h1>
    <p class="subtle">Informations personnelles</p>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('/register') ?>">
        <?= csrf_field() ?>
        <div class="field">
            <label for="nom">Nom complet</label>
            <input type="text" id="nom" name="nom" value="<?= esc(old('nom')) ?>" required>
            <?php if (! empty($errors['nom'])): ?>
                <div class="error"><?= esc($errors['nom']) ?></div>
            <?php endif; ?>
        </div>
        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" required>
            <?php if (! empty($errors['email'])): ?>
                <div class="error"><?= esc($errors['email']) ?></div>
            <?php endif; ?>
        </div>
        <div class="field">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
            <?php if (! empty($errors['password'])): ?>
                <div class="error"><?= esc($errors['password']) ?></div>
            <?php endif; ?>
        </div>
        <div class="field">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" min="0" value="<?= esc(old('age')) ?>">
            <?php if (! empty($errors['age'])): ?>
                <div class="error"><?= esc($errors['age']) ?></div>
            <?php endif; ?>
        </div>
        <div class="field">
            <label for="sexe_id">Genre</label>
            <select id="sexe_id" name="sexe_id" required>
                <option value="">Choisir</option>
                <?php foreach ($sexes as $sexe): ?>
                    <option value="<?= esc($sexe['id']) ?>" <?= old('sexe_id') == $sexe['id'] ? 'selected' : '' ?>>
                        <?= esc($sexe['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (! empty($errors['sexe_id'])): ?>
                <div class="error"><?= esc($errors['sexe_id']) ?></div>
            <?php endif; ?>
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Continuer</button>
            <a class="btn btn-ghost" href="<?= site_url('/login') ?>">Deja un compte</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
