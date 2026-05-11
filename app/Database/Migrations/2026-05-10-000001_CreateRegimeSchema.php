<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class CreateRegimeSchema extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('label');
        $this->forge->createTable('sexes', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->createTable('objectifs', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 190,
            ],
            'password_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'age' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
            ],
            'sexe_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'user',
            ],
            'premium' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addKey('sexe_id');
        $this->forge->addForeignKey('sexe_id', 'sexes', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('utilisateurs', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'taille_cm' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'poids_kg' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'objectif_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'imc' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('user_id');
        $this->forge->addKey('objectif_id');
        $this->forge->addForeignKey('user_id', 'utilisateurs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('objectif_id', 'objectifs', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('profil_sante', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'duree_jours' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'prix' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'calories_cible' => [
                'type'       => 'INT',
                'constraint' => 6,
            ],
            'variation_poids' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'pourcentage_viande' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
            ],
            'pourcentage_poisson' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
            ],
            'pourcentage_volaille' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
            ],
            'pourcentage_legumes_verts' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
            ],
            'pourcentage_fruits' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
            ],
            'pourcentage_feculents' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
            ],
            'objectif_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('objectif_id');
        $this->forge->addForeignKey('objectif_id', 'objectifs', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('regimes', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'objectif_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'intensite' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('objectif_id');
        $this->forge->addForeignKey('objectif_id', 'objectifs', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('activites_sportives', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'categorie' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'recommandation' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'objectif_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'actif' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('objectif_id');
        $this->forge->addForeignKey('objectif_id', 'objectifs', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('aliments', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'solde' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('user_id');
        $this->forge->addForeignKey('user_id', 'utilisateurs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('portefeuilles', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'valeur' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'date_expiration' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'actif' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'used_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'used_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->addKey('used_by');
        $this->forge->addForeignKey('used_by', 'utilisateurs', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('codes_rechargement', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'actif' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'used_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'used_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->addKey('used_by');
        $this->forge->addForeignKey('used_by', 'utilisateurs', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('codes_gold', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'date_debut' => [
                'type' => 'DATE',
            ],
            'date_fin' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'prix' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'actif' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'utilisateurs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('abonnements_gold', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'regime_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'date_debut' => [
                'type' => 'DATE',
            ],
            'date_fin' => [
                'type' => 'DATE',
            ],
            'prix_applique' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'remise_appliquee' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('regime_id');
        $this->forge->addForeignKey('user_id', 'utilisateurs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('regime_id', 'regimes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('historique_regimes', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'montant' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'reference' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'utilisateurs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('paiements', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cle' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'valeur' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('cle');
        $this->forge->createTable('parametres', true);

        $this->resetAndSeed();
    }

    public function down()
    {
        $this->forge->dropTable('parametres', true);
        $this->forge->dropTable('paiements', true);
        $this->forge->dropTable('historique_regimes', true);
        $this->forge->dropTable('abonnements_gold', true);
        $this->forge->dropTable('codes_gold', true);
        $this->forge->dropTable('codes_rechargement', true);
        $this->forge->dropTable('portefeuilles', true);
        $this->forge->dropTable('activites_sportives', true);
        $this->forge->dropTable('aliments', true);
        $this->forge->dropTable('regimes', true);
        $this->forge->dropTable('profil_sante', true);
        $this->forge->dropTable('utilisateurs', true);
        $this->forge->dropTable('objectifs', true);
        $this->forge->dropTable('sexes', true);
    }

    private function resetAndSeed(): void
    {
        // Destructif: reinitialise les donnees a chaque migration.
        $this->db->disableForeignKeyChecks();

        $tables = [
            'paiements',
            'historique_regimes',
            'abonnements_gold',
            'codes_gold',
            'codes_rechargement',
            'portefeuilles',
            'profil_sante',
            'utilisateurs',
            'activites_sportives',
            'aliments',
            'regimes',
            'objectifs',
            'sexes',
            'parametres',
        ];

        foreach ($tables as $table) {
            if ($this->db->tableExists($table)) {
                $this->db->table($table)->truncate();
            }
        }

        $this->db->enableForeignKeyChecks();

        $seeder = Database::seeder();
        $seeder->call('RegimeSeeder');
    }
}
