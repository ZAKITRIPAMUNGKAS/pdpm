<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateUserStatusSeeder extends Seeder
{
    public function run()
    {
        // Update status untuk user yang sudah ada
        $this->db->table('users')
                 ->whereIn('email', ['admin@pdpmkaranganyar.org', 'anggota@pdpmkaranganyar.org'])
                 ->update(['status' => 'Aktif']);

        echo "✅ User status updated to 'Aktif' for admin and member accounts\n";
    }
}
