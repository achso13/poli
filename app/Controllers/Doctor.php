<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DoctorModel;
use App\Models\UserModel;

class Doctor extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel;
        $this->doctorModel = new DoctorModel;
    }

    public function index()
    {
        $data = [
            'title' => 'Doctor',
            'result' => $this->doctorModel->getDoctors(),
        ];
        return view('doctor/index', $data);
    }

    public function add()
    {
        return view('doctor/add');
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
                'id_doctor' => generateId($this->doctorModel, 'id_doctor', 'DR', 10),
                'fullname' => $this->request->getPost('f_fullname'),
                'doctor_type' => $this->request->getPost('f_doctor_type'),
                'username' => $this->request->getPost('f_username'),
                'education' => $this->request->getPost('f_education'),
                'email' => $this->request->getPost('f_email'),
                'password' => $this->request->getPost('f_password'),
                'photo' => $photoName,
            ];

            $validation->setRules([
                'fullname' => 'required|min_length[3]|max_length[255]',
                'doctor_type' => 'required|in_list[Umum,Gigi]',
                "username" => "required|min_length[3]|max_length[255]|is_unique[tbl_users.username]",
                'education' => 'permit_empty|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|min_length[3]|max_length[255]',
                'password' => 'required|min_length[3]|max_length[255]',
                'photo' => 'permit_empty|is_image[f_photo]|mime_in[f_photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[f_photo,foto,2048]',
            ]);

            if ($validation->run($data)) {
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo/', $photoName);
                }

                // Insert data ke tabel user
                $dataUser = [
                    'id_role' => 2,
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

                // Insert data ke tabel doctor
                $dataDoctor = [
                    'id_doctor' => $data['id_doctor'],
                    'id_user' => $idUser,
                    'fullname' => $this->request->getPost('f_fullname'),
                    'doctor_type' => $this->request->getPost('f_doctor_type'),
                    'education' => $this->request->getPost('f_education'),
                ];
                $insert = $this->doctorModel->save($dataDoctor);
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
            'result' => $this->doctorModel->getDoctors($id),
        ];
        return view('doctor/edit', $data);
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
                'id_doctor' => generateId($this->doctorModel, 'id_doctor', 'DR', 10),
                'fullname' => $this->request->getPost('f_fullname'),
                'doctor_type' => $this->request->getPost('f_doctor_type'),
                'username' => $this->request->getPost('f_username'),
                'education' => $this->request->getPost('f_education'),
                'email' => $this->request->getPost('f_email'),
                'password' => $this->request->getPost('f_password'),
                'photo' => $photoName,
            ];

            $validation->setRules([
                'fullname' => 'required|min_length[3]|max_length[255]',
                'doctor_type' => 'required|in_list[Umum,Gigi]',
                "username" => "required|min_length[3]|max_length[255]|is_unique[tbl_users.username,username,$oldUsername]",
                'education' => 'permit_empty|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|min_length[3]|max_length[255]',
                'password' => 'permit_empty|min_length[3]|max_length[255]',
                'photo' => 'permit_empty|is_image[f_photo]|mime_in[f_photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[f_photo,foto,2048]',
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

                // Update data ke tabel doctor
                $dataDoctor = [
                    'fullname' => $this->request->getPost('f_fullname'),
                    'doctor_type' => $this->request->getPost('f_doctor_type'),
                    'education' => $this->request->getPost('f_education'),
                ];

                $update = $this->doctorModel->update($this->request->getPost('f_id_doctor'), $dataDoctor);

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
        $data = $this->doctorModel->find($id);
        $user = $this->userModel->find($data['id_user']);
        $delete = $this->doctorModel->delete($id);
        if ($delete) {
            $this->userModel->delete($data['id_user']);
            if ($user['photo'] != "") {
                unlink(ROOTPATH . 'public/uploads/photo/' .  $user['photo']);
            }
            session()->setFlashdata('message', 'Hapus data berhasil');
            return redirect()->to(base_url('/doctor'));
        }
    }
}
