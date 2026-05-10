<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= view('admin/_menu') ?>

<div class="card">
    <h1>Regimes</h1>
    <div class="actions">
        <a class="btn btn-primary" href="<?= site_url('/admin/regimes/create') ?>">Ajouter un regime</a>
    </div>
</div>

<div class="card">
    <?php if (empty($regimes)): ?>
        <p class="subtle">Aucun regime en base.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Duree</th>
                    <th>Prix</th>
                    <th>Objectif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($regimes as $regime): ?>
                    <tr>
                        <td><?= esc($regime['nom']) ?></td>
                        <td><?= esc($regime['duree_jours']) ?> jours</td>
                        <td><?= esc($regime['prix']) ?></td>
                        <td><?= esc($objectifMap[$regime['objectif_id']] ?? 'Tous') ?></td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-ghost" href="<?= site_url('/admin/regimes/edit/' . $regime['id']) ?>">Modifier</a>
                                <form class="inline-form" method="post" action="<?= site_url('/admin/regimes/delete/' . $regime['id']) ?>">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-danger" type="submit">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
