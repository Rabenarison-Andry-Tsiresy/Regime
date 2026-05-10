<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <h1>Connexion</h1>
    <p class="subtle">Acces rapide a votre programme nutritionnel.</p>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('/login') ?>">
        <?= csrf_field() ?>
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
        <div class="actions">
            <button class="btn btn-primary" type="submit">Se connecter</button>
            <a class="btn btn-ghost" href="<?= site_url('/register') ?>">Creer un compte</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
