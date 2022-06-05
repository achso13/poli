<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TreatmentModel;

class Treatment extends BaseController
{
    public function __construct()
    {
        $this->treatmentModel = new TreatmentModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Treatment',
            'result' => $this->treatmentModel->getTreatments(),
        ];

        return view('treatment/index', $data);
    }

    public function add()
    {
        return view('treatment/add');
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'id_treatment' => generateId($this->treatmentModel, 'id_treatment', 'TRT', 10),
                'id_clinic' => $this->request->getPost('f_id_clinic'),
                'treatment_name' => $this->request->getPost('f_treatment_name'),
                'description' => $this->request->getPost('f_description'),
                'open_time' => $this->request->getPost('f_open_time'),
                'close_time' => $this->request->getPost('f_close_time'),
            ];

            $validation->setRules([
                'id_clinic' => 'required',
                'treatment_name' => 'required|min_length[3]|max_length[100]',
                'description' => 'permit_empty|min_length[3]|max_length[225]',
                'open_time' => 'required|min_length[3]|max_length[20]',
                'close_time' => 'required|min_length[3]|max_length[20]',
            ]);

            if ($validation->run($data)) {
                $insert = $this->treatmentModel->save($data);
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
            'result' => $this->treatmentModel->getTreatments($id)
        ];
        return view('treatment/edit', $data);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'id_treatment' => generateId($this->treatmentModel, 'id_treatment', 'TRT', 10),
                'id_clinic' => $this->request->getPost('f_id_clinic'),
                'treatment_name' => $this->request->getPost('f_treatment_name'),
                'description' => $this->request->getPost('f_description'),
                'open_time' => $this->request->getPost('f_open_time'),
                'close_time' => $this->request->getPost('f_close_time'),
            ];

            $validation->setRules([
                'id_clinic' => 'required',
                'treatment_name' => 'required|min_length[3]|max_length[100]',
                'description' => 'permit_empty|min_length[3]|max_length[225]',
                'open_time' => 'required',
                'close_time' => 'required',
            ]);

            if ($validation->run($data)) {
                $update = $this->treatmentModel->update($this->request->getPost('f_id'), $data);
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
        $delete = $this->treatmentModel->delete($id);
        if ($delete) {
            session()->setFlashdata('message', 'Hapus data berhasil');
            return redirect()->to(base_url('treatment'));
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException;
        }
    }
}
