<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
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
            'nom' => [
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
        $this->forge->addUniqueKey('nom');
        $this->forge->createTable('categories', true);

        $now = date('Y-m-d H:i:s');
        $defaultCategories = [
            'Roman',
            'Science',
            'Informatique',
            'Histoire',
            'Jeunesse',
            'Art',
            'Autre',
        ];

        foreach ($defaultCategories as $nom) {
            $exists = $this->db->table('categories')->where('nom', $nom)->countAllResults() > 0;
            if (! $exists) {
                $this->db->table('categories')->insert([
                    'nom'        => $nom,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down()
    {
        $this->forge->dropTable('categories', true);
    }
}
