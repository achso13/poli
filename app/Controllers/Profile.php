<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Profile',
            'user' => $this->userModel->find(session()->get("log_id"))
        ];
        return view('profile/index', $data);
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
            $data = [
                'nama' => $this->request->getPost('f_nama'),
                'password' => $this->request->getPost('f_password'),
                'photo' => $photoName,
            ];


            if ($data['password'] == "") {
                unset($data['password']);
            }

            if ($photo->getError() === 4) {
                unset($data['photo']);
            }

            $validation->setRules([
                'nama' => [
                    'label' => "Nama",
                    "rules" => 'required|min_length[3]|max_length[100]',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong",
                        "min_length" => "{field} minimal 3 karakter",
                        "max_length" => "{field} maksimal 100 karakter"
                    ]
                ],
                'password' => [
                    'label' => "Password",
                    "rules" => 'permit_empty|min_length[3]|max_length[100]',
                    "errors" => [
                        "min_length" => "{field} minimal 3 karakter",
                        "max_length" => "{field} maksimal 100 karakter"
                    ]
                ],
                'photo' => [
                    'label' => 'Foto',
                    'rules' => 'permit_empty|is_image[f_photo]|mime_in[f_photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[f_photo,foto,2048]',
                    'errors' => [
                        'permit_empty' => '{field} tidak boleh kosong',
                        'is_image' => '{field} harus berupa gambar',
                        'mime_in' => '{field} harus berupa gambar',
                        'max_size' => '{field} maksimal 2MB'
                    ]
                ],
            ]);


            if ($validation->run($data)) {
                if (isset($data['password']) && $data['password'] != "") {
                    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                }

                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo/', $photoName);
                    if ($oldPhoto != NULL) {
                        unlink(ROOTPATH . 'public/uploads/photo/' .  $oldPhoto);
                    }
                }
                $userId = session()->get("log_id");
                $update = $this->userModel->update($userId, $data);
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
}
