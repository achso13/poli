<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pengumuman extends BaseController
{
    public function __construct()
    {
        $this->pengumumanModel = new \App\Models\PengumumanModel();
    }

    public function index()
    {
        //
        $data = [
            'title' => 'Pengumuman',
            'result' => $this->pengumumanModel->getPengumuman(),
        ];
        return view('pengumuman/index', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Pengumuman',
        ];
        return view('pengumuman/add', $data);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'judul' => $this->request->getPost('f_judul'),
                'isi' => $this->request->getPost('f_isi'),
                'id_user' => session()->get('log_id'),
            ];

            $validation->setRules([
                'judul' => [
                    'label' => 'Judul',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => 'Judul tidak boleh kosong',
                        'min_length' => 'Judul minimal 3 karakter',
                        'max_length' => 'Judul maksimal 100 karakter',
                    ],
                ],
                'isi' => [
                    'label' => 'Isi',
                    'rules' => 'required|min_length[3]|max_length[255]',
                    'errors' => [
                        'required' => 'Isi tidak boleh kosong',
                        'min_length' => 'Isi minimal 3 karakter',
                    ],
                ],
            ]);

            if ($validation->run($data)) {
                $insert = $this->pengumumanModel->save($data);
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
            'title' => 'Edit Pengumuman',
            'result' => $this->pengumumanModel->getPengumuman($id),
        ];
        return view('pengumuman/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('f_id');
        $data = [
            'judul' => $this->request->getPost('f_judul'),
            'isi' => $this->request->getPost('f_isi'),
            'id_user' => session()->get('log_id'),
        ];

        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => [
                'label' => 'Judul',
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Judul tidak boleh kosong',
                    'min_length' => 'Judul minimal 3 karakter',
                    'max_length' => 'Judul maksimal 100 karakter',
                ],
            ],
            'isi' => [
                'label' => 'Isi',
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Isi tidak boleh kosong',
                    'min_length' => 'Isi minimal 3 karakter',
                ],
            ],
        ]);
        if ($validation->run($data)) {
            $insert = $this->pengumumanModel->update($id, $data);
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

    public function view($id)
    {
        $data = [
            'title' => 'Detail Pengumuman',
            'result' => $this->pengumumanModel->getPengumuman($id),
        ];
        return view('pengumuman/view', $data);
    }

    public function delete($id)
    {
        $delete = $this->pengumumanModel->delete($id);
        if ($delete) {
            session()->setFlashdata('message', 'Data berhasil dihapus');
            $result['error'] = false;
            $result['message'] = 'Data berhasil dihapus';
        } else {
            $result['error'] = true;
            $result['message'] = 'Data gagal dihapus';
        }
        return redirect()->to(base_url('pengumuman'));
    }
}
