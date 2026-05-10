<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= view('admin/_menu') ?>

<div class="card">
    <h1>Codes de rechargement</h1>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('/admin/codes/store') ?>">
        <?= csrf_field() ?>
        <div class="grid">
            <div class="field">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" value="<?= esc(old('code')) ?>" required>
            </div>
            <div class="field">
                <label for="valeur">Valeur</label>
                <input type="number" step="0.01" id="valeur" name="valeur" value="<?= esc(old('valeur')) ?>" required>
            </div>
            <div class="field">
                <label for="date_expiration">Expiration</label>
                <input type="datetime-local" id="date_expiration" name="date_expiration" value="<?= esc(old('date_expiration')) ?>">
            </div>
            <div class="field">
                <label for="actif">Actif</label>
                <select id="actif" name="actif">
                    <option value="1" <?= old('actif', '1') == '1' ? 'selected' : '' ?>>Oui</option>
                    <option value="0" <?= old('actif') == '0' ? 'selected' : '' ?>>Non</option>
                </select>
            </div>
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Ajouter le code</button>
        </div>
    </form>
</div>

<div class="card">
    <?php if (empty($codes)): ?>
        <p class="subtle">Aucun code disponible.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Valeur</th>
                    <th>Expiration</th>
                    <th>Statut</th>
                    <th>Utilise par</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($codes as $code): ?>
                    <tr>
                        <td><?= esc($code['code']) ?></td>
                        <td><?= esc($code['valeur']) ?></td>
                        <td><?= esc($code['date_expiration'] ?? '-') ?></td>
                        <td><?= $code['actif'] ? 'Actif' : 'Inactif' ?></td>
                        <td><?= esc($code['used_by'] ?? '-') ?></td>
                        <td>
                            <div class="actions">
                                <?php if ($code['actif']): ?>
                                    <form class="inline-form" method="post" action="<?= site_url('/admin/codes/disable/' . $code['id']) ?>">
                                        <?= csrf_field() ?>
                                        <button class="btn btn-warning" type="submit">Desactiver</button>
                                    </form>
                                <?php else: ?>
                                    <form class="inline-form" method="post" action="<?= site_url('/admin/codes/enable/' . $code['id']) ?>">
                                        <?= csrf_field() ?>
                                        <button class="btn btn-success" type="submit">Activer</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
