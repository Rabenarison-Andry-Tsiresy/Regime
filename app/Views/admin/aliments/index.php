<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= view('admin/_menu') ?>

<div class="card">
    <h1>Aliments</h1>
    <div class="actions">
        <a class="btn btn-primary" href="<?= site_url('/admin/aliments/create') ?>">Ajouter un aliment</a>
    </div>
</div>

<div class="card">
    <?php if (empty($aliments)): ?>
        <p class="subtle">Aucun aliment en base.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Categorie</th>
                    <th>Objectif</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aliments as $aliment): ?>
                    <tr>
                        <td><?= esc($aliment['nom']) ?></td>
                        <td><?= esc($aliment['categorie'] ?? '-') ?></td>
                        <td><?= esc($objectifMap[$aliment['objectif_id']] ?? 'Tous') ?></td>
                        <td><?= ! empty($aliment['actif']) ? 'Actif' : 'Inactif' ?></td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-ghost" href="<?= site_url('/admin/aliments/edit/' . $aliment['id']) ?>">Modifier</a>
                                <form class="inline-form" method="post" action="<?= site_url('/admin/aliments/delete/' . $aliment['id']) ?>">
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
