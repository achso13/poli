<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClinicModel;

class Clinic extends BaseController
{
    public function __construct()
    {
        $this->clinicModel = new ClinicModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Clinic',
            'result' => $this->clinicModel->findAll(),
        ];

        return view('clinic/index', $data);
    }

    public function add()
    {
        return view('clinic/add');
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'nama_klinik' => $this->request->getPost('f_nama_klinik'),
            ];

            $validation->setRules([
                'nama_klinik' => [
                    'label' => 'Nama Klinik',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'error' => [
                        'required' => 'Nama Klinik tidak boleh kosong',
                        'min_length' => 'Nama Klinik minimal 3 karakter',
                        'max_length' => 'Nama Klinik maksimal 100 karakter',
                    ],
                ]
            ]);

            if ($validation->run($data)) {
                $insert = $this->clinicModel->save($data);
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
        $id = $this->request->getPost('id');
        $data = [
            'result' => $this->clinicModel->find($id)
        ];
        return view('clinic/edit', $data);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'nama_klinik' => $this->request->getPost('f_nama_klinik'),
            ];

            $validation->setRules([
                'nama_klinik' => [
                    'label' => 'Nama Klinik',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'error' => [
                        'required' => 'Nama Klinik tidak boleh kosong',
                        'min_length' => 'Nama Klinik minimal 3 karakter',
                        'max_length' => 'Nama Klinik maksimal 100 karakter',
                    ],
                ]
            ]);

            if ($validation->run($data)) {
                $update = $this->clinicModel->update($this->request->getPost('f_id'), $data);
                if ($update) {
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

    public function delete($id)
    {
        $delete = $this->clinicModel->delete($id);
        if ($delete) {
            session()->setFlashdata('message', 'Hapus data berhasil');
            return redirect()->to(base_url('clinic'));
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException;
        }
    }
}
