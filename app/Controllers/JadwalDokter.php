<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JadwalDokterModel;
use App\Models\DoctorModel;

class JadwalDokter extends BaseController
{
    public function __construct()
    {
        $this->doctorModel = new DoctorModel();
        $this->jadwalDokterModel = new JadwalDokterModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Jadwal Dokter',
            'result' => $this->jadwalDokterModel->getJadwal(),
        ];
        return view('jadwal_dokter/index', $data);
    }

    public function add()
    {
        $data = [
            'dokter' => $this->doctorModel->getDoctors(),
        ];
        return view('jadwal_dokter/add', $data);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'id_dokter' => $this->request->getVar('f_id_dokter'),
                'jam_mulai' => $this->request->getVar('f_jam_mulai'),
                'jam_selesai' => $this->request->getVar('f_jam_selesai'),
                'hari' => $this->request->getVar('f_hari'),
            ];

            $validation->setRules([
                'id_dokter' => [
                    'label' => 'Dokter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'jam_mulai' => [
                    'label' => 'Jam Mulai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'jam_selesai' => [
                    'label' => 'Jam Selesai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'hari' => [
                    'label' => 'hari',
                    'rules' => 'required|in_list[Senin,Selasa,Rabu,Kamis,Jumat]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'in_list' => '{field} harus diisi dengan Senin, Selasa, Rabu, Kamis, Jumat',
                    ],
                ],
            ]);

            if ($validation->run($data)) {
                $insert = $this->jadwalDokterModel->save($data);
                if ($insert) {
                    session()->setFlashdata('message', 'Data berhasil disimpan');
                    $result['error'] = false;
                    $result['message'] = 'Data berhasil disimpan';
                } else {
                    $result['error'] = true;
                    $result['message'] = 'Data gagal disimpan';
                }
                return $this->response->setJSON($result);
            } else {
                $result['error'] = true;
                $result['message'] = $validation->getErrors();
                return $this->response->setJSON($result);
            }
        }
    }

    public function edit()
    {
        $id = $this->request->getVar('id');
        $data = [
            'result' => $this->jadwalDokterModel->getJadwal($id),
            'dokter' => $this->doctorModel->getDoctors(),
        ];
        return view('jadwal_dokter/edit', $data);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $data = [
                'id_dokter' => $this->request->getVar('f_id_dokter'),
                'jam_mulai' => $this->request->getVar('f_jam_mulai'),
                'jam_selesai' => $this->request->getVar('f_jam_selesai'),
                'hari' => $this->request->getVar('f_hari'),
            ];
            $validation->setRules([
                'id_dokter' => [
                    'label' => 'Dokter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'jam_mulai' => [
                    'label' => 'Jam Mulai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'jam_selesai' => [
                    'label' => 'Jam Selesai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'hari' => [
                    'label' => 'hari',
                    'rules' => 'required|in_list[Senin,Selasa,Rabu,Kamis,Jumat]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'in_list' => '{field} harus diisi dengan Senin, Selasa, Rabu, Kamis, Jumat',
                    ],
                ],
            ]);
            if ($validation->run($data)) {
                $update = $this->jadwalDokterModel->update($this->request->getVar('f_id_jadwal_dokter'), $data);
                if ($update) {
                    session()->setFlashdata('message', 'Data berhasil diupdate');
                    $result['error'] = false;
                    $result['message'] = 'Data berhasil diupdate';
                } else {
                    $result['error'] = true;
                    $result['message'] = 'Data gagal diupdate';
                }
            } else {
                $result['error'] = true;
                $result['message'] = $validation->getErrors();
            }
            return $this->response->setJSON($result);
        }
    }

    public function delete($id)
    {
        $delete = $this->jadwalDokterModel->delete($id);
        if ($delete) {
            session()->setFlashdata('message', 'Data berhasil dihapus');
            return redirect()->to(base_url('doctor/jadwal'));
        } else {
            session()->setFlashdata('message', 'Data gagal dihapus');
            return redirect()->to(base_url('doctor/jadwal'));
        }
    }

    public function ajaxJadwalDokter($idDokter)
    {
        if ($this->request->isAJAX()) {
            $data = $this->jadwalDokterModel->where('id_dokter', $idDokter)->findAll();

            return $this->response->setJSON($data);
        }
    }

    public function ajaxHariDokter($idJadwalDokter)
    {
        if ($this->request->isAJAX()) {
            $data = $this->jadwalDokterModel->where('id_jadwal_dokter', $idJadwalDokter)->first()['hari'];

            return $this->response->setJSON($data);
        }
    }
}
