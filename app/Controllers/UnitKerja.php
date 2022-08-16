<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnitKerjaModel;
use App\Models\BiroModel;

class UnitKerja extends BaseController
{
    public function __construct()
    {
        $this->unitKerjaModel = new UnitKerjaModel();
        $this->biroModel = new BiroModel();
    }

    public function index()
    {
        return redirect()->to(base_url('/unitkerja/bagian'));
    }

    public function bagian()
    {
        $data = [
            'title' => 'Bagian',
            'result' => $this->unitKerjaModel->getUnitKerja(),
        ];
        return view('bagian/index', $data);
    }

    public function add()
    {
        $data = [
            'biro' => $this->biroModel->findAll(),
        ];
        return view('bagian/add', $data);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'id_biro' => $this->request->getVar('f_id_biro'),
                'nama_bagian' => $this->request->getVar('f_nama_bagian'),
            ];

            $validation->setRules([
                'id_biro' => [
                    'label' => 'Biro',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'nama_bagian' => [
                    'label' => 'Nama Bagian',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => 'Nama Bagian tidak boleh kosong',
                        'min_length' => 'Nama Bagian minimal 3 karakter',
                        'max_length' => 'Nama Bagian maksimal 100 karakter',
                    ],
                ]
            ]);
            if ($validation->run($data)) {
                $insert = $this->unitKerjaModel->save($data);
                if ($insert) {
                    session()->setFlashdata('message', 'Data berhasil disimpan');
                    $result['error'] = false;
                    $result['message'] = 'Data berhasil disimpan';
                } else {
                    $result['error'] = true;
                    $result['message'] = 'Data gagal disimpan';
                }
            } else {
                $result['error'] = true;
                $result['message'] = $validation->getErrors();
            }
        }
        return $this->response->setJSON($result);
    }

    public function edit()
    {
        $id = $this->request->getVar('id');
        $data = [
            'biro' => $this->biroModel->findAll(),
            'result' => $this->unitKerjaModel->find($id),
        ];
        return view('bagian/edit', $data);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'id_biro' => $this->request->getVar('f_id_biro'),
                'nama_bagian' => $this->request->getVar('f_nama_bagian'),
            ];
            $validation->setRules([
                'id_biro' => [
                    'label' => 'Biro',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'nama_bagian' => [
                    'label' => 'Nama Bagian',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => 'Nama Bagian tidak boleh kosong',
                        'min_length' => 'Nama Bagian minimal 3 karakter',
                        'max_length' => 'Nama Bagian maksimal 100 karakter',
                    ],
                ]
            ]);
            if ($validation->run($data)) {
                $update = $this->unitKerjaModel->update($this->request->getVar('f_id_unitkerja'), $data);
                if ($update) {
                    session()->setFlashdata('message', 'Data berhasil diperbarui');
                    $result['error'] = false;
                    $result['message'] = 'Data berhasil diperbarui';
                } else {
                    $result['error'] = true;
                    $result['message'] = 'Data gagal diperbarui';
                }
            } else {
                $result['error'] = true;
                $result['message'] = $validation->getErrors();
            }
        }
        return $this->response->setJSON($result);
    }

    public function delete($id)
    {
        $delete = $this->unitKerjaModel->delete($id);
        if ($delete) {
            session()->setFlashdata('message', 'Hapus data berhasil');
            return redirect()->to(base_url('unitkerja/bagian'));
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException;
        }
    }

    public function ajaxBagian($idBiro)
    {
        $data = $this->unitKerjaModel
            ->where('id_biro', $idBiro)
            ->findAll();
        return json_encode($data);
    }
}
