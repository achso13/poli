<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function index()
    {
        return redirect()->to('/users/role/admin');
    }

    public function role($role = "ADMIN")
    {
        $data = [
            'title' => 'Users',
            'role' => strtoupper($role),
            'result' => $this->userModel->getUsers($role)
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
                'role' => $this->request->getPost('f_role'),
                'id_klinik' => $this->request->getPost('f_id_klinik') ? $this->request->getPost('f_id_klinik') : null,
                'nama' => $this->request->getPost('f_nama'),
                'username' => $this->request->getPost('f_username'),
                'email' => $this->request->getPost('f_email'),
                'password' => $this->request->getPost('f_password'),
                'photo' => $photoName,
            ];

            if ($photo->getError() === 4) {
                unset($data['photo']);
            }

            $validation->setRules([
                'role' => [
                    'label' => "Role",
                    "rules" => 'required',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong"
                    ]
                ],
                'id_klinik' => [
                    'label' => "Klinik",
                    "rules" => $data['role'] == "KLINIK" ? 'required' : 'permit_empty',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong"
                    ]
                ],
                'nama' => [
                    'label' => "Nama",
                    "rules" => 'required|min_length[3]|max_length[100]',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong",
                        "min_length" => "{field} minimal 3 karakter",
                        "max_length" => "{field} maksimal 100 karakter"
                    ]
                ],
                'username' => [
                    'label' => "Username",
                    "rules" => 'required|min_length[3]|max_length[100]|is_unique[tb_user.username]',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong",
                        "min_length" => "{field} minimal 3 karakter",
                        "max_length" => "{field} maksimal 100 karakter",
                        "is_unique" => "{field} sudah digunakan"
                    ]
                ],
                'email' => [
                    'label' => "Email",
                    "rules" => 'required|valid_email',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong",
                        "valid_email" => "{field} tidak valid",
                        "is_unique" => "{field} sudah digunakan"
                    ]
                ],
                'password' => [
                    'label' => "Password",
                    "rules" => 'required|min_length[3]|max_length[100]',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong",
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
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo/', $photoName);
                }
                $data['password'] = password_hash($this->request->getPost('f_password'), PASSWORD_BCRYPT);
                $insert = $this->userModel->save($data);
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
            $oldUsername = $this->request->getPost('f_old_username');
            $data = [
                'role' => $this->request->getPost('f_role'),
                'id_klinik' => $this->request->getPost('f_id_klinik') ? $this->request->getPost('f_id_klinik') : null,
                'nama' => $this->request->getPost('f_nama'),
                'username' => $this->request->getPost('f_username'),
                'email' => $this->request->getPost('f_email'),
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
                'role' => [
                    'label' => "Role",
                    "rules" => 'required',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong"
                    ]
                ],
                'id_klinik' => [
                    'label' => "Klinik",
                    "rules" => $data['role'] == "KLINIK" ? 'required' : 'permit_empty',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong"
                    ]
                ],
                'nama' => [
                    'label' => "Nama",
                    "rules" => 'required|min_length[3]|max_length[100]',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong",
                        "min_length" => "{field} minimal 3 karakter",
                        "max_length" => "{field} maksimal 100 karakter"
                    ]
                ],
                'username' => [
                    'label' => "Username",
                    "rules" => "required|min_length[3]|max_length[100]|is_unique[tb_user.username,username,$oldUsername]",
                    "errors" => [
                        "required" => "{field} tidak boleh kosong",
                        "min_length" => "{field} minimal 3 karakter",
                        "max_length" => "{field} maksimal 100 karakter",
                        "is_unique" => "{field} sudah digunakan"
                    ]
                ],
                'email' => [
                    'label' => "Email",
                    "rules" => 'required|valid_email',
                    "errors" => [
                        "required" => "{field} tidak boleh kosong",
                        "valid_email" => "{field} tidak valid",
                        "is_unique" => "{field} sudah digunakan"
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
                $data['password'] = password_hash($this->request->getPost('f_password'), PASSWORD_BCRYPT);
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo/', $photoName);
                    if ($oldPhoto !== NULL) {
                        unlink(ROOTPATH . 'public/uploads/photo/' .  $oldPhoto);
                    }
                }
                $update = $this->userModel->update($this->request->getPost('f_id'), $data);
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
        $data = $this->userModel->find($id);
        $delete = $this->userModel->delete($id);
        if ($delete) {
            if ($data['photo'] != "") {
                unlink(ROOTPATH . 'public/uploads/photo/' .  $data['photo']);
            }
            session()->setFlashdata('message', 'Hapus data berhasil');
            return redirect()->to(base_url('/users/role/' . $data['role']));
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException;
        }
    }
}
