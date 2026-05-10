<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RegimeSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('sexes')->insertBatch([
            ['label' => 'Homme', 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Femme', 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Autre', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('objectifs')->insertBatch([
            ['code' => 'gain', 'label' => 'Augmenter le poids', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'loss', 'label' => 'Reduire le poids', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ideal', 'label' => 'Atteindre IMC ideal', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('parametres')->insertBatch([
            ['cle' => 'imc_underweight_max', 'valeur' => '18.5', 'created_at' => $now, 'updated_at' => $now],
            ['cle' => 'imc_normal_max', 'valeur' => '24.9', 'created_at' => $now, 'updated_at' => $now],
            ['cle' => 'imc_overweight_max', 'valeur' => '29.9', 'created_at' => $now, 'updated_at' => $now],
            ['cle' => 'gold_price', 'valeur' => '50', 'created_at' => $now, 'updated_at' => $now],
            ['cle' => 'gold_discount_percent', 'valeur' => '15', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $sexes = $this->mapByLabel('sexes');
        $objectifs = $this->mapByCode('objectifs');

        $this->insertUser([
            'nom' => 'Admin',
            'email' => 'admin@regime.test',
            'age' => 30,
            'sexe_id' => $sexes['Autre'] ?? null,
            'role' => 'admin',
            'premium' => 1,
            'password' => 'admin123',
            'taille_cm' => 175,
            'poids_kg' => 75,
            'objectif_id' => $objectifs['ideal'] ?? null,
            'solde' => 500,
        ]);

        $users = [
            ['nom' => 'Aina', 'email' => 'user1@regime.test', 'age' => 24, 'sexe' => 'Femme', 'password' => 'user123', 'taille_cm' => 162, 'poids_kg' => 68, 'objectif' => 'loss', 'solde' => 120],
            ['nom' => 'Hery', 'email' => 'user2@regime.test', 'age' => 28, 'sexe' => 'Homme', 'password' => 'user123', 'taille_cm' => 178, 'poids_kg' => 82, 'objectif' => 'ideal', 'solde' => 80],
            ['nom' => 'Lala', 'email' => 'user3@regime.test', 'age' => 22, 'sexe' => 'Femme', 'password' => 'user123', 'taille_cm' => 158, 'poids_kg' => 52, 'objectif' => 'gain', 'solde' => 60],
            ['nom' => 'Mika', 'email' => 'user4@regime.test', 'age' => 31, 'sexe' => 'Homme', 'password' => 'user123', 'taille_cm' => 172, 'poids_kg' => 74, 'objectif' => 'ideal', 'solde' => 90],
            ['nom' => 'Tina', 'email' => 'user5@regime.test', 'age' => 26, 'sexe' => 'Femme', 'password' => 'user123', 'taille_cm' => 166, 'poids_kg' => 70, 'objectif' => 'loss', 'solde' => 110],
        ];

        foreach ($users as $user) {
            $this->insertUser([
                'nom' => $user['nom'],
                'email' => $user['email'],
                'age' => $user['age'],
                'sexe_id' => $sexes[$user['sexe']] ?? null,
                'role' => 'user',
                'premium' => 0,
                'password' => $user['password'],
                'taille_cm' => $user['taille_cm'],
                'poids_kg' => $user['poids_kg'],
                'objectif_id' => $objectifs[$user['objectif']] ?? null,
                'solde' => $user['solde'],
            ]);
        }

        $this->db->table('regimes')->insertBatch([
            [
                'nom' => 'Regime Equilibre',
                'description' => 'Approche stable avec repartition simple.',
                'duree_jours' => 30,
                'prix' => 120,
                'variation_poids' => -2.5,
                'pourcentage_viande' => 30,
                'pourcentage_poisson' => 30,
                'pourcentage_volaille' => 20,
                'objectif_id' => $objectifs['loss'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nom' => 'Regime Gain Doux',
                'description' => 'Programme progressif pour prise de poids.',
                'duree_jours' => 45,
                'prix' => 150,
                'variation_poids' => 3.0,
                'pourcentage_viande' => 35,
                'pourcentage_poisson' => 25,
                'pourcentage_volaille' => 20,
                'objectif_id' => $objectifs['gain'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nom' => 'Regime IMC Ideal',
                'description' => 'Maintien et stabilite sur 21 jours.',
                'duree_jours' => 21,
                'prix' => 90,
                'variation_poids' => 0,
                'pourcentage_viande' => 25,
                'pourcentage_poisson' => 30,
                'pourcentage_volaille' => 25,
                'objectif_id' => $objectifs['ideal'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nom' => 'Regime Express',
                'description' => 'Programme court avec suivi intensif.',
                'duree_jours' => 14,
                'prix' => 70,
                'variation_poids' => -1.2,
                'pourcentage_viande' => 20,
                'pourcentage_poisson' => 35,
                'pourcentage_volaille' => 25,
                'objectif_id' => $objectifs['loss'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nom' => 'Regime Proteine',
                'description' => 'Plan riche en proteines pour stabiliser.',
                'duree_jours' => 28,
                'prix' => 110,
                'variation_poids' => 0.5,
                'pourcentage_viande' => 40,
                'pourcentage_poisson' => 20,
                'pourcentage_volaille' => 20,
                'objectif_id' => $objectifs['ideal'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $this->db->table('activites_sportives')->insertBatch([
            ['nom' => 'Marche rapide', 'description' => '30 minutes par jour.', 'objectif_id' => $objectifs['loss'] ?? null, 'intensite' => 'modere', 'created_at' => $now, 'updated_at' => $now],
            ['nom' => 'Renforcement doux', 'description' => 'Circuit complet sans charge.', 'objectif_id' => $objectifs['gain'] ?? null, 'intensite' => 'leger', 'created_at' => $now, 'updated_at' => $now],
            ['nom' => 'Cardio fractionne', 'description' => 'Alternance effort/repos.', 'objectif_id' => $objectifs['loss'] ?? null, 'intensite' => 'intense', 'created_at' => $now, 'updated_at' => $now],
            ['nom' => 'Pilates', 'description' => 'Stabilite et posture.', 'objectif_id' => $objectifs['ideal'] ?? null, 'intensite' => 'modere', 'created_at' => $now, 'updated_at' => $now],
            ['nom' => 'Yoga dynamique', 'description' => 'Souplesse et respiration.', 'objectif_id' => $objectifs['ideal'] ?? null, 'intensite' => 'leger', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $codes = [];
        $expiration = date('Y-m-d H:i:s', strtotime('+30 days'));
        for ($i = 1; $i <= 15; $i++) {
            $codes[] = [
                'code' => sprintf('CODE-%04d', $i),
                'valeur' => 10 + ($i % 5) * 5,
                'date_expiration' => $expiration,
                'actif' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        $this->db->table('codes_rechargement')->insertBatch($codes);
    }

    private function mapByLabel(string $table): array
    {
        $map = [];
        foreach ($this->db->table($table)->get()->getResultArray() as $row) {
            $map[$row['label']] = (int) $row['id'];
        }

        return $map;
    }

    private function mapByCode(string $table): array
    {
        $map = [];
        foreach ($this->db->table($table)->get()->getResultArray() as $row) {
            $map[$row['code']] = (int) $row['id'];
        }

        return $map;
    }

    private function insertUser(array $data): void
    {
        $now = date('Y-m-d H:i:s');
        $this->db->table('utilisateurs')->insert([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'age' => $data['age'] ?? null,
            'sexe_id' => $data['sexe_id'] ?? null,
            'role' => $data['role'] ?? 'user',
            'premium' => $data['premium'] ?? 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $userId = (int) $this->db->insertID();

        $taille = (float) $data['taille_cm'];
        $poids = (float) $data['poids_kg'];
        $imc = $taille > 0 ? $poids / pow($taille / 100, 2) : null;

        $this->db->table('profil_sante')->insert([
            'user_id' => $userId,
            'taille_cm' => $taille,
            'poids_kg' => $poids,
            'objectif_id' => $data['objectif_id'] ?? null,
            'imc' => $imc !== null ? round($imc, 2) : null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->db->table('portefeuilles')->insert([
            'user_id' => $userId,
            'solde' => $data['solde'] ?? 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
