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
                'clinic_name' => $this->request->getPost('f_clinic_name'),
                'description' => $this->request->getPost('f_description'),
            ];

            $validation->setRules([
                'clinic_name' => 'required|min_length[3]|max_length[100]',
                'description' => 'required|max_length[225]',
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
                'clinic_name' => $this->request->getPost('f_clinic_name'),
                'description' => $this->request->getPost('f_description'),
            ];

            $validation->setRules([
                'clinic_name' => 'required|min_length[3]|max_length[100]',
                'description' => 'required|max_length[225]',
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
