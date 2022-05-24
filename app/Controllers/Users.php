<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return redirect()->to('/users/role/1');
    }

    public function role($id = 1)
    {
        $data = [
            'title' => 'Users',
            'role' => $id,
            'result' => $this->userModel->getUsers($id)
        ];

        return view('users/index', $data);
    }

    public function add()
    {
        return view('users/add');
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
                'id_role' => $this->request->getPost('f_id_role'),
                'id_departement' => $this->request->getPost('f_id_departement') ? $this->request->getPost('f_id_departement') : null,
                'fullname' => $this->request->getPost('f_fullname'),
                'username' => $this->request->getPost('f_username'),
                'email' => $this->request->getPost('f_email'),
                'password' => password_hash($this->request->getPost('f_password'), PASSWORD_BCRYPT),
                'photo' => $photoName,
                'is_active' => 1,
            ];

            $validation->setRules([
                'id_role' => 'required',
                'id_departement' => $data['id_role'] == 4 ? 'required' : 'permit_empty',
                'fullname' => 'required|min_length[3]|max_length[255]',
                'username' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|min_length[3]|max_length[255]',
                'password' => 'required|min_length[6]',
                'photo' => 'permit_empty|is_image[f_photo]|mime_in[f_photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[f_photo,foto,2048]',
                'is_active' => 'required|is_natural',
            ]);

            if ($validation->run($data)) {
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo', $photoName);
                }
                $insert = $this->userModel->save($data);
                if ($insert) {
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
            'result' => $this->userModel->find($id)
        ];
        return view('users/edit', $data);
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
                'id_role' => $this->request->getPost('f_id_role'),
                'id_departement' => $this->request->getPost('f_id_departement') ? $this->request->getPost('f_id_departement') : null,
                'fullname' => $this->request->getPost('f_fullname'),
                'username' => $this->request->getPost('f_username'),
                'email' => $this->request->getPost('f_email'),
                'password' => password_hash($this->request->getPost('f_password'), PASSWORD_BCRYPT),
                'photo' => $photoName,
                'is_active' => 1,
            ];

            if ($this->request->getPost('f_password') == "") {
                unset($data['password']);
            }

            if ($photo->getError() !== 4) {
                unset($data['photo']);
            }

            $validation->setRules([
                'id_role' => 'required',
                'id_departement' => $data['id_role'] == 4 ? 'required' : 'permit_empty',
                'fullname' => 'required|min_length[3]|max_length[255]',
                'username' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|min_length[3]|max_length[255]',
                'password' => 'permit_empty|min_length[6]',
                'photo' => 'permit_empty|is_image[f_photo]|mime_in[f_photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[f_photo,foto,2048]',
                'is_active' => 'required|is_natural',
            ]);

            if ($validation->run($data)) {
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo', $photoName);
                    unlink(ROOTPATH . 'public/uploads/photo' .  $oldPhoto);
                }
                $update = $this->userModel->update($this->request->getPost('f_id'), $data);
                if ($update) {
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
        $data = $this->userModel->find($id);
        $delete = $this->userModel->delete($id);
        if ($delete) {
            if ($data['photo'] != "") {
                unlink(ROOTPATH . 'public/uploads/photo' .  $data['photo']);
            }
            session()->setFlashdata('message', 'Hapus data berhasil');
            return redirect()->to(base_url('/users/role/' . $data['id_role']));
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException;
        }
    }
}
