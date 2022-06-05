<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PatientModel;

class Patient extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel;
        $this->patientModel = new PatientModel;
    }

    public function index()
    {
        $data = [
            'title' => 'Pasien',
            'result' => $this->patientModel->getPatients(),
        ];
        return view('patient/index', $data);
    }

    public function add()
    {
        return view('patient/add');
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            // Ambil variabel foto
            $photo = $this->request->getFile('f_photo');
            // Ambil nama foto
            $photoName = $photo->getError() === 4 ? "" : $photo->getRandomName();

            $data = [
                'id_patient' => generateId($this->patientModel, 'id_patient', 'PSN', 10),
                'nip' => $this->request->getPost('f_nip'),
                'fullname' => $this->request->getPost('f_fullname'),
                'address' => $this->request->getPost('f_address'),
                'phone' => $this->request->getPost('f_phone'),
                'blood_type' => $this->request->getPost('f_blood_type'),
                'birth_date' => $this->request->getPost('f_birth_date'),
                'admission_date' => $this->request->getPost('f_admission_date'),
                'username' => $this->request->getPost('f_username'),
                'password' => $this->request->getPost('f_password'),
                'email' => $this->request->getPost('f_email'),
            ];

            $validation->setRules([
                "nip" => "required|min_length[16]|max_length[16]",
                "fullname" => "required|min_length[3]|max_length[255]",
                "address" => "required|min_length[3]|max_length[255]",
                "phone" => "required|min_length[3]|max_length[255]|numeric",
                "blood_type" => "required|in_list[A+, A-, B+, B-, O+, O-, AB+, AB-]",
                "birth_date" => "required|valid_date",
                "admission_date" => "required|valid_date",
                "username" => "required|min_length[3]|max_length[255]|is_unique[tbl_users.username]",
                "password" => "required|min_length[3]|max_length[255]",
                "email" => "required|valid_email|min_length[3]|max_length[255]",
                "photo" => "permit_empty|is_image[f_photo]|mime_in[f_photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[f_photo,foto,2048]",
            ]);

            if ($validation->run($data)) {
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo/', $photoName);
                }

                // Insert data ke tabel user
                $dataUser = [
                    'id_role' => 3,
                    'id_clinic' => null,
                    'fullname' => $this->request->getPost('f_fullname'),
                    'username' => $this->request->getPost('f_username'),
                    'email' => $this->request->getPost('f_email'),
                    'password' => password_hash($this->request->getPost('f_password'), PASSWORD_BCRYPT),
                    'photo' => $photoName,
                ];

                if ($photo->getError() === 4) {
                    unset($dataUser['photo']);
                }

                $this->userModel->save($dataUser);
                $idUser = $this->userModel->insertID();

                // Insert data ke tabel patient
                $dataPatient = [
                    'id_patient' => $data['id_patient'],
                    'id_user' => $idUser,
                    'nip' => $data['nip'],
                    'fullname' => $data['fullname'],
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'blood_type' => $data['blood_type'],
                    'birth_date' => $data['birth_date'],
                    'admission_date' => $data['admission_date'],
                ];

                $insert = $this->patientModel->save($dataPatient);
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
            'result' => $this->patientModel->getPatients($id),
        ];
        return view('patient/edit', $data);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            // Ambil variabel foto
            $photo = $this->request->getFile('f_photo');
            // Ambil nama foto
            $photoName = $photo->getError() === 4 ? "" : $photo->getRandomName();
            $oldPhoto = $this->request->getPost('f_old_photo');
            $oldUsername = $this->request->getPost('f_old_username');

            $data = [
                'id_patient' => generateId($this->patientModel, 'id_patient', 'PSN', 10),
                'nip' => $this->request->getPost('f_nip'),
                'fullname' => $this->request->getPost('f_fullname'),
                'address' => $this->request->getPost('f_address'),
                'phone' => $this->request->getPost('f_phone'),
                'blood_type' => $this->request->getPost('f_blood_type'),
                'birth_date' => $this->request->getPost('f_birth_date'),
                'admission_date' => $this->request->getPost('f_admission_date'),
                'username' => $this->request->getPost('f_username'),
                'password' => $this->request->getPost('f_password'),
                'email' => $this->request->getPost('f_email'),
            ];

            $validation->setRules([
                "nip" => "required|min_length[16]|max_length[16]",
                "fullname" => "required|min_length[3]|max_length[255]",
                "address" => "required|min_length[3]|max_length[255]",
                "phone" => "required|min_length[3]|max_length[255]|numeric",
                "blood_type" => "required|in_list[A+, A-, B+, B-, O+, O-, AB+, AB-]",
                "birth_date" => "required|valid_date",
                "admission_date" => "required|valid_date",
                "username" => "required|min_length[3]|max_length[255]|is_unique[tbl_users.username,username,$oldUsername]",
                "password" => "permit_empty|min_length[3]|max_length[255]",
                "email" => "required|valid_email|min_length[3]|max_length[255]",
                "photo" => "permit_empty|is_image[f_photo]|mime_in[f_photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[f_photo,foto,2048]",
            ]);


            if ($validation->run($data)) {
                $data['password'] = password_hash($this->request->getPost('f_password'), PASSWORD_BCRYPT);
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo/', $photoName);
                    if ($oldPhoto !== NULL) {
                        unlink(ROOTPATH . 'public/uploads/photo/' .  $oldPhoto);
                    }
                }

                // Update data ke tabel user
                $dataUser = [
                    'fullname' => $this->request->getPost('f_fullname'),
                    'username' => $this->request->getPost('f_username'),
                    'email' => $this->request->getPost('f_email'),
                    'password' => password_hash($this->request->getPost('f_password'), PASSWORD_BCRYPT),
                    'photo' => $photoName,
                ];

                if ($dataUser['password'] == "") {
                    unset($dataUser['password']);
                }

                if ($photo->getError() === 4) {
                    unset($dataUser['photo']);
                }

                $this->userModel->update($this->request->getPost('f_id_user'), $dataUser);

                // Update data ke tabel patient
                $dataPatient = [
                    'nip' => $data['nip'],
                    'fullname' => $data['fullname'],
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'blood_type' => $data['blood_type'],
                    'birth_date' => $data['birth_date'],
                    'admission_date' => $data['admission_date'],
                ];

                $update = $this->patientModel->update($this->request->getPost('f_id_patient'), $dataPatient);

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
        $data = $this->patientModel->find($id);
        $user = $this->userModel->find($data['id_user']);
        $delete = $this->patientModel->delete($id);
        if ($delete) {
            if ($user['photo'] != "") {
                unlink(ROOTPATH . 'public/uploads/photo/' .  $user['photo']);
            }
            session()->setFlashdata('message', 'Hapus data berhasil');
            return redirect()->to(base_url('/patient'));
        }
    }
}
