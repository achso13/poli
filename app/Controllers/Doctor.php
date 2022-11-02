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
                'id_dokter' => generateId($this->doctorModel, 'id_dokter', 'DR', 10),
                'nip' => $this->request->getPost('f_nip'),
                'nama' => $this->request->getPost('f_nama'),
                'tipe_dokter' => $this->request->getPost('f_tipe_dokter'),
                'tempat_lahir' => $this->request->getPost('f_tempat_lahir'),
                'tanggal_lahir' => $this->request->getPost('f_tanggal_lahir'),
                'jenis_kelamin' => $this->request->getPost('f_jenis_kelamin'),
                'telepon' => $this->request->getPost('f_telepon'),
                'username' => $this->request->getPost('f_username'),
                'email' => $this->request->getPost('f_email'),
                'password' => $this->request->getPost('f_password'),
                'photo' => $photoName,
                'pengalaman_praktik' => $this->request->getPost('f_pengalaman_praktik'),
            ];

            $validation->setRules([
                'nip' => [
                    'label' => 'NIP',
                    'rules' => 'required|numeric|min_length[16]|max_length[16]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} hanya boleh berisi angka',
                        'min_length' => '{field} minimal 16 karakter',
                        'max_length' => '{field} maksimal 16 karakter',
                    ],
                ],
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
                'tipe_dokter' => [
                    'label' => 'Tipe Dokter',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
                'tempat_lahir' => [
                    'label' => 'Tempat Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'tanggal_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_date' => '{field} tidak valid',
                    ],
                ],
                'jenis_kelamin' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required|in_list[Laki-laki,Perempuan]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'in_list' => '{field} tidak valid',
                    ],
                ],
                'telepon' => [
                    'label' => 'Telepon',
                    'rules' => 'required|numeric|min_length[10]|max_length[20]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} hanya boleh berisi angka',
                        'min_length' => '{field} minimal 10 karakter',
                        'max_length' => '{field} maksimal 20 karakter',
                    ],
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[tb_user.username]|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_email' => '{field} tidak valid',
                    ],
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[3]|max_length[20]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 20 karakter',
                    ],
                ],
                'photo' => [
                    'label' => 'Photo',
                    'rules' => 'permit_empty|max_size[f_photo,2048]|mime_in[f_photo,image/jpg,image/jpeg,image/png]|is_image[f_photo]',
                    'errors' => [
                        'max_size' => '{field} tidak boleh lebih dari 1MB',
                        'mime_in' => '{field} harus berupa file gambar',
                        'is_image' => '{field} harus berupa file gambar',
                    ],
                ],
                'pengalaman_praktik' => [
                    'label' => 'Pengalaman Praktik',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
            ]);

            if ($validation->run($data)) {
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo/', $photoName);
                }

                // Insert data ke tabel user
                $dataUser = [
                    'role' => "DOKTER",
                    'id_klinik' => null,
                    'nama' => $this->request->getPost('f_nama'),
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
                    'id_dokter' => $data['id_dokter'],
                    'id_user' => $idUser,
                    'nip' => $this->request->getPost('f_nip'),
                    'nama' => $this->request->getPost('f_nama'),
                    'tipe_dokter' => $this->request->getPost('f_tipe_dokter'),
                    'tempat_lahir' => $this->request->getPost('f_tempat_lahir'),
                    'tanggal_lahir' => $this->request->getPost('f_tanggal_lahir'),
                    'jenis_kelamin' => $this->request->getPost('f_jenis_kelamin'),
                    'telepon' => $this->request->getPost('f_telepon'),
                    'pengalaman_praktik' => $this->request->getPost('f_pengalaman_praktik'),
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
                'id_dokter' => generateId($this->doctorModel, 'id_dokter', 'DR', 10),
                'nip' => $this->request->getPost('f_nip'),
                'nama' => $this->request->getPost('f_nama'),
                'tipe_dokter' => $this->request->getPost('f_tipe_dokter'),
                'tempat_lahir' => $this->request->getPost('f_tempat_lahir'),
                'tanggal_lahir' => $this->request->getPost('f_tanggal_lahir'),
                'jenis_kelamin' => $this->request->getPost('f_jenis_kelamin'),
                'telepon' => $this->request->getPost('f_telepon'),
                'username' => $this->request->getPost('f_username'),
                'email' => $this->request->getPost('f_email'),
                'password' => $this->request->getPost('f_password'),
                'photo' => $photoName,
                'pengalaman_praktik' => $this->request->getPost('f_pengalaman_praktik'),
            ];

            $validation->setRules([
                'nip' => [
                    'label' => 'NIP',
                    'rules' => 'required|numeric|min_length[16]|max_length[16]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} hanya boleh berisi angka',
                        'min_length' => '{field} minimal 16 karakter',
                        'max_length' => '{field} maksimal 16 karakter',
                    ],
                ],
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
                'tipe_dokter' => [
                    'label' => 'Tipe Dokter',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
                'tempat_lahir' => [
                    'label' => 'Tempat Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'tanggal_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_date' => '{field} tidak valid',
                    ],
                ],
                'jenis_kelamin' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required|in_list[Laki-laki,Perempuan]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'in_list' => '{field} tidak valid',
                    ],
                ],
                'telepon' => [
                    'label' => 'Telepon',
                    'rules' => 'required|numeric|min_length[10]|max_length[20]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} hanya boleh berisi angka',
                        'min_length' => '{field} minimal 10 karakter',
                        'max_length' => '{field} maksimal 20 karakter',
                    ],
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => "required|min_length[3]|max_length[100]|is_unique[tb_user.username,username,$oldUsername]",
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                        'is_unique' => '{field} sudah terdaftar',
                    ],
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_email' => '{field} tidak valid',
                    ],
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'permit_empty|min_length[3]|max_length[20]',
                    'errors' => [
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 20 karakter',
                    ],
                ],
                'photo' => [
                    'label' => 'Photo',
                    'rules' => 'permit_empty|max_size[f_photo,2048]|mime_in[f_photo,image/jpg,image/jpeg,image/png]|is_image[f_photo]',
                    'errors' => [
                        'max_size' => '{field} tidak boleh lebih dari 1MB',
                        'mime_in' => '{field} harus berupa file gambar',
                        'is_image' => '{field} harus berupa file gambar',
                    ],
                ],
                'pengalaman_praktik' => [
                    'label' => 'Pengalaman Praktik',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 3 karakter',
                        'max_length' => '{field} maksimal 100 karakter',
                    ],
                ],
            ]);

            if ($validation->run($data)) {
                if (isset($data['password']) && $data['password'] != "") {
                    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                }
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo/', $photoName);
                    if (!isset($oldPhoto) || $oldPhoto != '') {
                        unlink(ROOTPATH . 'public/uploads/photo/' .  $oldPhoto);
                    }
                }

                // Update data ke tabel user
                $dataUser = [
                    'nama' => $this->request->getPost('f_nama'),
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
                    'nip' => $this->request->getPost('f_nip'),
                    'nama' => $this->request->getPost('f_nama'),
                    'tipe_dokter' => $this->request->getPost('f_tipe_dokter'),
                    'tempat_lahir' => $this->request->getPost('f_tempat_lahir'),
                    'tanggal_lahir' => $this->request->getPost('f_tanggal_lahir'),
                    'jenis_kelamin' => $this->request->getPost('f_jenis_kelamin'),
                    'telepon' => $this->request->getPost('f_telepon'),
                    'pengalaman_praktik' => $this->request->getPost('f_pengalaman_praktik'),
                ];

                $update = $this->doctorModel->update($this->request->getPost('f_id_dokter'), $dataDoctor);

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
