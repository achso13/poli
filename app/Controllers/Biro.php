<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BiroModel;

class Biro extends BaseController
{
    public function __construct()
    {
        $this->biroModel = new BiroModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Biro',
            'result' => $this->biroModel->findAll(),
        ];

        return view('biro/index', $data);
    }

    public function add()
    {
        return view('biro/add');
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'nama_biro' => $this->request->getPost('f_nama_biro'),
            ];

            $validation->setRules([
                'nama_biro' => [
                    'label' => 'Nama Biro',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => 'Nama Biro tidak boleh kosong',
                        'min_length' => 'Nama Biro minimal 3 karakter',
                        'max_length' => 'Nama Biro maksimal 100 karakter',
                    ],
                ]
            ]);

            if ($validation->run($data)) {
                $insert = $this->biroModel->save($data);
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
            'result' => $this->biroModel->find($id)
        ];
        return view('biro/edit', $data);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'nama_biro' => $this->request->getPost('f_nama_biro'),
            ];

            $validation->setRules([
                'nama_biro' => [
                    'label' => 'Nama Biro',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => 'Nama Biro tidak boleh kosong',
                        'min_length' => 'Nama Biro minimal 3 karakter',
                        'max_length' => 'Nama Biro maksimal 100 karakter',
                    ],
                ]
            ]);

            if ($validation->run($data)) {
                $update = $this->biroModel->update($this->request->getPost('f_id'), $data);
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
        $delete = $this->biroModel->delete($id);
        if ($delete) {
            session()->setFlashdata('message', 'Hapus data berhasil');
            return redirect()->to(base_url('unitkerja/biro'));
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException;
        }
    }
}
