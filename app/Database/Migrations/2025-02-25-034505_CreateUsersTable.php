<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_name'        => ['type' => 'VARCHAR', 'constraint' => '100'],
            'user_password'    => ['type' => 'VARCHAR', 'constraint' => '255'],
            'user_role'        => ['type' => 'ENUM', 'constraint' => ['admin', 'staff'], 'default' => 'staff'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('user_id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
