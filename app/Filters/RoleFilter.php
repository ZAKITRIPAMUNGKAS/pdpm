<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Ambil service session
        $session = session();

        // Jika user tidak login, redirect ke halaman login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Jika tidak ada argumen peran yang diberikan, blokir akses
        if (empty($arguments)) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        // Ambil id_role dari session
        $userRoleId = $session->get('id_role');
        
        // Cek apakah peran user ada di dalam daftar argumen yang diizinkan
        // Argumen bisa berupa 'Super Admin', 'Admin', dll.
        // Kita perlu mengubah nama peran menjadi ID.
        
        $db = \Config\Database::connect();
        $allowedRoles = $db->table('roles')->whereIn('nama_role', $arguments)->get()->getResultArray();
        $allowedRoleIds = array_column($allowedRoles, 'id');

        if (!in_array($userRoleId, $allowedRoleIds)) {
            // Jika peran tidak diizinkan, kembalikan ke dashboard dengan pesan error
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki hak akses untuk halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
