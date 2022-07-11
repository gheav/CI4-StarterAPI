<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Application extends Migration
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
            'app_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'app_description' => [
                'type'          => 'TEXT',
                'null'          => true,
            ],
            'app_code' => [
                'type'          => 'VARCHAR',
                'constraint'    => '100',
            ],
            'app_key' => [
                'type'          => 'VARCHAR',
                'constraint'    => '100',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('application');
    }

    public function down()
    {
        $this->forge->dropTable('application');
    }
}
