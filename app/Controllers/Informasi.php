<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Informasi extends BaseController
{
    public function index()
    {
        $doctorModel = new \App\Models\DoctorModel();
        $dokter = $doctorModel->getDoctors();
        $data = [
            'title' => 'Informasi',
            'dokter' => $dokter,
        ];
        return view('informasi/index', $data);
    }

    public function view()
    {
        $id = $this->request->getVar('id');
        $doctorModel = new \App\Models\DoctorModel();
        $jadwalDokterModel = new \App\Models\JadwalDokterModel();

        $dokter = $doctorModel->getDoctors($id);
        $jadwal = $jadwalDokterModel
            ->where('id_dokter', $id)
            ->findAll();

        $data = [
            'title' => 'Informasi',
            'dokter' => $dokter,
            'jadwal' => $jadwal,
        ];

        return view('informasi/view', $data);
    }
}
