<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PatientModel;
use App\Models\BiroModel;
use App\Models\UnitKerjaModel;

class Patient extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel;
        $this->patientModel = new PatientModel;
        $this->biroModel = new BiroModel;
        $this->unitKerjaModel = new UnitKerjaModel;
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

        $data = [
            'biro' => $this->biroModel->findAll(),
        ];
        return view('patient/add', $data);
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
                'id_pasien' => generateId($this->patientModel, 'id_pasien', 'PSN', 10),
                'id_biro' => $this->request->getPost('f_id_biro'),
                'id_unitkerja' => $this->request->getPost('f_id_unitkerja'),
                'nip' => $this->request->getPost('f_nip'),
                'nama' => $this->request->getPost('f_nama'),
                'alamat_rumah' => $this->request->getPost('f_alamat_rumah'),
                'telepon' => $this->request->getPost('f_telepon'),
                'jenis_kelamin' => $this->request->getPost('f_jenis_kelamin'),
                'tempat_lahir' => $this->request->getPost('f_tempat_lahir'),
                'tanggal_lahir' => $this->request->getPost('f_tanggal_lahir'),
                'username' => $this->request->getPost('f_nip'),
                'password' => $this->request->getPost('f_password'),
                'email' => $this->request->getPost('f_email'),
            ];

            $validation->setRules([
                'id_biro' => ['label' => 'Biro', 'rules' => 'required'],
                'id_unitkerja' => ['label' => 'Bagian', 'rules' => 'required'],
                "nip" => ['label' => 'NIP', 'rules' => "required|min_length[16]|max_length[16]|is_unique[tb_user.username]"],
                "nama" => ['label' => 'Nama', 'rules' => "required|min_length[3]|max_length[255]"],
                "alamat_rumah" => ['label' => 'Alamat Rumah', 'rules' => "required|min_length[3]|max_length[255]"],
                "telepon" => ['label' => 'Telepon', 'rules' => "required|numeric|min_length[10]|max_length[20]"],
                "jenis_kelamin" => ['label' => 'Jenis Kelamin', 'rules' => "required|in_list[Laki-laki,Perempuan]"],
                "tempat_lahir" => ['label' => 'Tempat Lahir', 'rules' => "required|min_length[3]|max_length[255]"],
                "tanggal_lahir" => ['label' => 'Tanggal Lahir', 'rules' => "required|valid_date"],
                // "username" => ['label' => 'Username', 'rules' => "required|min_length[3]|max_length[255]|is_unique[tb_user.username]"],
                "password" => ['label' => 'Password', 'rules' => "required|min_length[3]|max_length[255]"],
                "email" => ['label' => 'Email', 'rules' => "required|valid_email|min_length[3]|max_length[255]"],
                "photo" => ['label' => 'Photo', 'rules' => "permit_empty|is_image[f_photo]|mime_in[f_photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[f_photo,foto,2048]"],
            ]);

            if ($validation->run($data)) {
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo/', $photoName);
                }

                // Insert data ke tabel user
                $dataUser = [
                    'id_klinik' => null,
                    'nama' => $this->request->getPost('f_nama'),
                    'username' => $this->request->getPost('f_nip'),
                    'email' => $this->request->getPost('f_email'),
                    'password' => password_hash($this->request->getPost('f_password'), PASSWORD_BCRYPT),
                    'photo' => $photoName,
                    'role' => "PASIEN"
                ];

                if ($photo->getError() === 4) {
                    unset($dataUser['photo']);
                }

                $this->userModel->save($dataUser);
                $idUser = $this->userModel->insertID();

                // Insert data ke tabel patient
                $dataPatient = [
                    'id_pasien' => $data['id_pasien'],
                    'id_unitkerja' => $data['id_unitkerja'],
                    'id_user' => $idUser,
                    'nip' => $data['nip'],
                    'nama' => $data['nama'],
                    'alamat_rumah' => $data['alamat_rumah'],
                    'telepon' => $data['telepon'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tempat_lahir' => $data['tempat_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
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
            'biro' => $this->biroModel->findAll(),
        ];

        $idBiro = $data['result']['id_biro'];

        $data['unitkerja'] = $this
            ->unitKerjaModel
            ->where(
                'id_biro',
                $idBiro
            )->findAll();

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
            // dd($oldPhoto);

            $data = [
                'id_biro' => $this->request->getPost('f_id_biro'),
                'id_unitkerja' => $this->request->getPost('f_id_unitkerja'),
                'nip' => $this->request->getPost('f_nip'),
                'nama' => $this->request->getPost('f_nama'),
                'alamat_rumah' => $this->request->getPost('f_alamat_rumah'),
                'telepon' => $this->request->getPost('f_telepon'),
                'jenis_kelamin' => $this->request->getPost('f_jenis_kelamin'),
                'tempat_lahir' => $this->request->getPost('f_tempat_lahir'),
                'tanggal_lahir' => $this->request->getPost('f_tanggal_lahir'),
                'username' => $this->request->getPost('f_nip'),
                'password' => $this->request->getPost('f_password'),
                'email' => $this->request->getPost('f_email'),
            ];

            $validation->setRules([
                "id_biro" => ['label' => 'Biro', 'rules' => "required"],
                "id_unitkerja" => ['label' => 'Bagian', 'rules' => "required"],
                "nip" => ['label' => 'NIP', 'rules' => "required|min_length[16]|max_length[16]|is_unique[tb_pasien.nip,nip,$oldUsername]"],
                "nama" => ['label' => 'Nama', 'rules' => "required|min_length[3]|max_length[255]"],
                "alamat_rumah" => ['label' => 'Alamat Rumah', 'rules' => "required|min_length[3]|max_length[255]"],
                "telepon" => ['label' => 'Telepon', 'rules' => "required|min_length[3]|max_length[255]|numeric"],
                "jenis_kelamin" => ['label' => 'Jenis Kelamin', 'rules' => "required|in_list[Laki-laki,Perempuan]"],
                "tempat_lahir" => ['label' => 'Tempat Lahir', 'rules' => "required|min_length[3]|max_length[255]"],
                "tanggal_lahir" => ['label' => 'Tanggal Lahir', 'rules' => "required|valid_date"],
                // "username" => ['label' => 'Username', 'rules' => "required|min_length[3]|max_length[255]"],
                "password" => ['label' => 'Password', 'rules' => "permit_empty|min_length[3]|max_length[255]"],
                "email" => ['label' => 'Email', 'rules' => "required|valid_email|min_length[3]|max_length[255]"],
                "photo" => ['label' => 'Photo', 'rules' => "permit_empty|is_image[f_photo]|mime_in[f_photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[f_photo,foto,2048]"],
            ]);


            if ($validation->run($data)) {
                $data['password'] = password_hash($this->request->getPost('f_password'), PASSWORD_BCRYPT);
                if ($photo->getError() !== 4) {
                    $photo->move(ROOTPATH . 'public/uploads/photo/', $photoName);
                    if (!isset($oldPhoto) && $oldPhoto != "") {
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

                // Update data ke tabel patient
                $dataPatient = [
                    'id_unitkerja' => $data['id_unitkerja'],
                    'nip' => $data['nip'],
                    'nama' => $data['nama'],
                    'alamat_rumah' => $data['alamat_rumah'],
                    'telepon' => $data['telepon'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tempat_lahir' => $data['tempat_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                ];

                $update = $this->patientModel->update($this->request->getPost('f_id_pasien'), $dataPatient);

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
