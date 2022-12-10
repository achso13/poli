<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MedicineModel;

class Medicine extends BaseController
{
    public function __construct()
    {
        $this->medicineModel = new MedicineModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Medicine',
            'result' => $this->medicineModel->findAll(),
        ];

        return view('medicine/index', $data);
    }

    public function add()
    {
        return view('medicine/add');
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'id_obat' => generateId($this->medicineModel, 'id_obat', 'OBT', 10),
                'nama_obat' => $this->request->getPost('f_nama_obat'),
                'stok' => $this->request->getPost('f_stok'),
                'satuan' => $this->request->getPost('f_satuan'),
                'masa_kadaluarsa' => $this->request->getPost('f_masa_kadaluarsa'),
            ];

            $validation->setRules([
                'nama_obat' => [
                    'label' => 'Nama Obat',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
                'stok' => [
                    'label' => 'Stok',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ],
                ],
                'satuan' => [
                    'label' => 'Satuan',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
                'masa_kadaluarsa' => [
                    'label' => 'Masa Kadaluarsa',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_date' => '{field} tidak valid',
                    ],
                ],
            ]);

            if ($validation->run($data)) {
                $insert = $this->medicineModel->save($data);
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
            'result' => $this->medicineModel->find($id)
        ];
        return view('medicine/edit', $data);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'nama_obat' => $this->request->getPost('f_nama_obat'),
                'description' => $this->request->getPost('f_description'),
                'stok' => $this->request->getPost('f_stok'),
                'satuan' => $this->request->getPost('f_satuan'),
                'masa_kadaluarsa' => $this->request->getPost('f_masa_kadaluarsa'),
            ];


            $validation->setRules([
                'nama_obat' => [
                    'label' => 'Nama Obat',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
                'stok' => [
                    'label' => 'Stok',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ],
                ],
                'satuan' => [
                    'label' => 'Satuan',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
                'masa_kadaluarsa' => [
                    'label' => 'Masa Kadaluarsa',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_date' => '{field} tidak valid',
                    ],
                ],
            ]);

            if ($validation->run($data)) {
                $update = $this->medicineModel->update($this->request->getPost('f_id'), $data);
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
        $delete = $this->medicineModel->delete($id);
        if ($delete) {
            session()->setFlashdata('message', 'Hapus data berhasil');
            return redirect()->to(base_url('medicine'));
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException;
        }
    }
}
