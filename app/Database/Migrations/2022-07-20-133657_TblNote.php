<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblNote extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'content' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type'       => 'TIMESTAMP',
                'null' => true
            ],
            'deleted_at' => [
                'type'       => 'TIMESTAMP',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('tbl_note');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_note');
    }
}