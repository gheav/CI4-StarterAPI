<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'fullname'       => [
                'type'          => 'VARCHAR',
                'constraint'    => '255',
            ],
            'username' => [
                'type'          => 'VARCHAR',
                'constraint'    => '255',
            ],
            'password' => [
                'type'          => 'VARCHAR',
                'constraint'    => '255',
            ],
            'session' => [
                'type'          => 'TEXT',
            ],
            'created_at' => [
                'type'          => 'datetime'
            ],
            'updated_at' => [
                'type'          => 'datetime'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
