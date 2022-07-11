<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ApiKey extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'app_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'key' => [
                'type'          => 'VARCHAR',
                'constraint'    => '100',
            ],
            'created_at' => [
                'type'          => 'datetime'
            ],
            'updated_at' => [
                'type'          => 'datetime'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('apikeys');
    }

    public function down()
    {
        $this->forge->dropTable('apikeys');
    }
}
