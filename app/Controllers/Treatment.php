<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TreatmentModel;
use App\Models\UserModel;

class Treatment extends BaseController
{
    public function __construct()
    {
        $this->treatmentModel = new TreatmentModel();
        $this->userModel = new UserModel();
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
                'id_klinik' => $this->request->getPost('f_id_klinik'),
                'nama_treatment' => $this->request->getPost('f_nama_treatment'),
                'deskripsi' => $this->request->getPost('f_deskripsi'),
                'jam_buka' => $this->request->getPost('f_jam_buka'),
                'jam_tutup' => $this->request->getPost('f_jam_tutup'),
            ];

            if (session()->get('log_role') === 'KLINIK') {
                $data['id_klinik'] = $this->userModel->where('id_user', session()->get('log_id'))->first()['id_klinik'];
            }

            $validation->setRules([
                'id_klinik' => [
                    'label' => 'Klinik',
                    'rules' => 'required',
                    'errors' => ['required' => 'Klinik harus diisi']
                ],
                'nama_treatment' => [
                    'label' => 'Nama Treatment',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter'
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'permit_empty|max_length[225]',
                    'errors' => ['max_length' => '{field} maksimal 225 karakter']
                ],
                'jam_buka' => [
                    'label' => 'Jam Buka',
                    'rules' => 'required|min_length[3]|max_length[20]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 20 karakter'
                    ]
                ],
                'jam_tutup' => [
                    'label' => 'Jam Tutup',
                    'rules' => 'required|min_length[3]|max_length[20]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 20 karakter'
                    ]
                ],
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
                'id_klinik' => $this->request->getPost('f_id_klinik'),
                'nama_treatment' => $this->request->getPost('f_nama_treatment'),
                'deskripsi' => $this->request->getPost('f_deskripsi'),
                'jam_buka' => $this->request->getPost('f_jam_buka'),
                'jam_tutup' => $this->request->getPost('f_jam_tutup'),
            ];

            if (session()->get('log_role') === 'KLINIK') {
                $data['id_klinik'] = $this->userModel->where('id_user', session()->get('log_id'))->first()['id_klinik'];
            }

            $validation->setRules([
                'id_klinik' => [
                    'label' => 'Klinik',
                    'rules' => 'required',
                    'errors' => ['required' => 'Klinik harus diisi']
                ],
                'nama_treatment' => [
                    'label' => 'Nama Treatment',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter'
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'permit_empty|max_length[225]',
                    'errors' => ['max_length' => '{field} maksimal 225 karakter']
                ],
                'jam_buka' => [
                    'label' => 'Jam Buka',
                    'rules' => 'required|min_length[3]|max_length[20]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 20 karakter'
                    ]
                ],
                'jam_tutup' => [
                    'label' => 'Jam Tutup',
                    'rules' => 'required|min_length[3]|max_length[20]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 20 karakter'
                    ]
                ],
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
