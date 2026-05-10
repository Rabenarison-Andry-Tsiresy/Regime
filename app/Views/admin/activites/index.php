<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= view('admin/_menu') ?>

<div class="card">
    <h1>Activites sportives</h1>
    <div class="actions">
        <a class="btn btn-primary" href="<?= site_url('/admin/activites/create') ?>">Ajouter une activite</a>
    </div>
</div>

<div class="card">
    <?php if (empty($activites)): ?>
        <p class="subtle">Aucune activite en base.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Intensite</th>
                    <th>Objectif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activites as $activite): ?>
                    <tr>
                        <td><?= esc($activite['nom']) ?></td>
                        <td><?= esc($activite['intensite'] ?? '-') ?></td>
                        <td><?= esc($objectifMap[$activite['objectif_id']] ?? 'Tous') ?></td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-ghost" href="<?= site_url('/admin/activites/edit/' . $activite['id']) ?>">Modifier</a>
                                <form class="inline-form" method="post" action="<?= site_url('/admin/activites/delete/' . $activite['id']) ?>">
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
