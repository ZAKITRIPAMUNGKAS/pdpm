<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgendaModel;
use App\Models\CabangModel;

class AgendaController extends BaseController
{
    protected $agendaModel;
    protected $cabangModel;

    public function __construct()
    {
        $this->agendaModel = new AgendaModel();
        $this->cabangModel = new CabangModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'      => 'Manajemen Agenda',
            'page_title' => 'Daftar Agenda Kegiatan',
            'agenda'     => $this->agendaModel->getAgendaWithPenulis()
        ];
        return view('agenda/index', $data);
    }

    public function create()
    {
        $userRole = session()->get('id_role');
        $cabangList = $userRole == 1 ? $this->cabangModel->findAll() : [];

        $data = [
            'title'       => 'Tambah Agenda Baru',
            'page_title'  => 'Form Tambah Agenda',
            'cabang_list' => $cabangList,
            'user_role'   => $userRole
        ];
        return view('agenda/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_kegiatan' => 'required|min_length[5]',
            'tanggal_mulai' => 'required',
            'deskripsi'     => 'required',
            'lokasi'        => 'required|min_length[5]',
            'latitude'      => 'required|decimal',
            'longitude'     => 'required|decimal',
            'radius_meter'  => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Parsing datetime
        $tanggalMulaiInput   = $this->request->getPost('tanggal_mulai');
        $tanggalSelesaiInput = $this->request->getPost('tanggal_selesai');

        $tanggalMulai   = date('Y-m-d H:i:s', strtotime($tanggalMulaiInput));
        $tanggalSelesai = !empty($tanggalSelesaiInput) ? date('Y-m-d H:i:s', strtotime($tanggalSelesaiInput)) : null;

        $jamMulai   = date('H:i:s', strtotime($tanggalMulaiInput));
        $jamSelesai = !empty($tanggalSelesaiInput) ? date('H:i:s', strtotime($tanggalSelesaiInput)) : null;

        $latitude  = (float) $this->request->getPost('latitude');
        $longitude = (float) $this->request->getPost('longitude');

        // Validasi koordinat (hapus kalau helper belum ada)
        if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
            return redirect()->back()->withInput()->with('error', 'Koordinat GPS tidak valid.');
        }

        // Tentukan role
        $userRole       = session()->get('id_role');
        $tingkatAgenda  = 'daerah';
        $idCabangKhusus = null;

        if ($userRole == 1) {
            $tingkatAgenda  = $this->request->getPost('tingkat_agenda') ?: 'daerah';
            $idCabangKhusus = $this->request->getPost('id_cabang_khusus');
        } elseif ($userRole == 2) {
            $tingkatAgenda  = 'cabang';
            $idCabangKhusus = session()->get('id_cabang');
        }

        $this->agendaModel->save([
            'nama_kegiatan'    => $this->request->getPost('nama_kegiatan'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'lokasi'           => $this->request->getPost('lokasi'),
            'latitude'         => $latitude,
            'longitude'        => $longitude,
            'radius_meter'     => (int) $this->request->getPost('radius_meter'),
            'tanggal_mulai'    => $tanggalMulai,
            'tanggal_selesai'  => $tanggalSelesai,
            'jam_mulai'        => $jamMulai,
            'jam_selesai'      => $jamSelesai,
            'id_penulis'       => session()->get('user_id'),
            'tingkat_agenda'   => $tingkatAgenda,
            'id_cabang_khusus' => $idCabangKhusus,
        ]);

        return redirect()->to(base_url('admin-agenda'))->with('success', 'Agenda baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $agenda = $this->agendaModel->find($id);
        if (!$agenda) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Agenda tidak ditemukan.');
        }

        $userRole   = session()->get('id_role');
        $cabangList = $userRole == 1 ? $this->cabangModel->findAll() : [];

        $data = [
            'title'       => 'Edit Agenda',
            'page_title'  => 'Form Edit Agenda',
            'agenda'      => $agenda,
            'cabang_list' => $cabangList,
            'user_role'   => $userRole
        ];
        return view('agenda/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_kegiatan' => 'required|min_length[5]',
            'tanggal_mulai' => 'required',
            'deskripsi'     => 'required',
            'lokasi'        => 'required|min_length[5]',
            'latitude'      => 'required|decimal',
            'longitude'     => 'required|decimal',
            'radius_meter'  => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tanggalMulaiInput   = $this->request->getPost('tanggal_mulai');
        $tanggalSelesaiInput = $this->request->getPost('tanggal_selesai');

        $updateData = [
            'nama_kegiatan'   => $this->request->getPost('nama_kegiatan'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'lokasi'          => $this->request->getPost('lokasi'),
            'latitude'        => (float) $this->request->getPost('latitude'),
            'longitude'       => (float) $this->request->getPost('longitude'),
            'radius_meter'    => (int) $this->request->getPost('radius_meter'),
            'tanggal_mulai'   => date('Y-m-d H:i:s', strtotime($tanggalMulaiInput)),
            'jam_mulai'       => date('H:i:s', strtotime($tanggalMulaiInput)),
            'tanggal_selesai' => !empty($tanggalSelesaiInput) ? date('Y-m-d H:i:s', strtotime($tanggalSelesaiInput)) : null,
            'jam_selesai'     => !empty($tanggalSelesaiInput) ? date('H:i:s', strtotime($tanggalSelesaiInput)) : null,
        ];

        if (session()->get('id_role') == 1) {
            $tingkatAgenda              = $this->request->getPost('tingkat_agenda') ?: 'daerah';
            $updateData['tingkat_agenda']   = $tingkatAgenda;
            $updateData['id_cabang_khusus'] = $tingkatAgenda == 'cabang' ? $this->request->getPost('id_cabang_khusus') : null;
        }

        $this->agendaModel->update($id, $updateData);
        return redirect()->to(base_url('admin-agenda'))->with('success', 'Agenda berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->agendaModel->delete($id);
        return redirect()->to(base_url('admin-agenda'))->with('success', 'Agenda berhasil dihapus.');
    }
}
