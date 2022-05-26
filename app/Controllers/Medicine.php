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
                'medicine_name' => $this->request->getPost('f_medicine_name'),
                'description' => $this->request->getPost('f_description'),
                'stock' => $this->request->getPost('f_stock'),
                'unit' => $this->request->getPost('f_unit'),
            ];

            $validation->setRules([
                'medicine_name' => 'required|min_length[3]|max_length[100]',
                'description' => 'required|min_length[3]|max_length[225]',
                'stock' => 'required|numeric',
                'unit' => 'required|min_length[3]|max_length[20]',
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
                'medicine_name' => $this->request->getPost('f_medicine_name'),
                'description' => $this->request->getPost('f_description'),
                'stock' => $this->request->getPost('f_stock'),
                'unit' => $this->request->getPost('f_unit'),
            ];

            $validation->setRules([
                'medicine_name' => 'required|min_length[3]|max_length[100]',
                'description' => 'required|min_length[3]|max_length[225]',
                'stock' => 'required|numeric',
                'unit' => 'required|min_length[3]|max_length[20]',
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
