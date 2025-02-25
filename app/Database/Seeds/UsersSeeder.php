<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_name'     => 'admin',
                'user_password' => password_hash('admin', PASSWORD_DEFAULT),
                'user_role'     => 'admin',
                'created_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_name'     => 'reza',
                'user_password' => password_hash('rezatoko', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'created_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
