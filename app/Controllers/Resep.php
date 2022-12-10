<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MedicineModel;
use App\Models\NotificationModel;
use App\Models\PatientModel;
use App\Models\ResepDetailModel;
use App\Models\ResepModel;
use PDO;

class Resep extends BaseController
{

    public function __construct()
    {
        $this->patientModel = new PatientModel();
        $this->resepModel = new ResepModel();
        $this->resepDetailModel = new ResepDetailModel();
        $this->medicineModel = new MedicineModel();
        $this->rekamMedisModel = new \App\Models\RekamMedisModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Resep',
            'result' => $this->resepModel->getResep(),
        ];

        if (session()->get('log_role') === "PASIEN") {
            $idPasien = $this->patientModel->where('id_user', session()->get('log_id'))->first()['id_pasien'];
            $data['result'] = $this->resepModel->getResepByPasien($idPasien);
        }
        return view('resep/index', $data);
    }

    public function view($id)
    {
        $data = [
            'title' => 'Resep',
            'result' => $this->resepModel->getResep($id),
            'obat' => $this->resepDetailModel->getResepDetail($id),
        ];

        if ($data['result'] != Null) {
            return view('resep/view', $data);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan', 404);
        }
    }

    public function add()
    {
        $data = [
            'title' => 'Resep',
            'id' => $this->request->getVar('id'),
            'obat' => $this->medicineModel->findAll(),
        ];

        return view('resep/add', $data);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $data = [
                'id_obat' => $this->request->getPost('f_id_obat'),
                'id_resep' => $this->request->getPost('f_id_resep'),
                'jumlah' => $this->request->getPost('f_jumlah'),
                'keterangan' => $this->request->getPost('f_keterangan'),
            ];

            if ($data['id_obat'] != null) {
                $stok = $this->medicineModel->find($data['id_obat'])['stok'];
            }

            $validation->setRules([
                'id_obat' => [
                    'label' => 'Obat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'id_resep' => [
                    'label' => 'Resep',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'jumlah' => [
                    'label' => 'Jumlah',
                    'rules' => !empty($data['id_obat']) ? 'required|less_than_equal_to[' . $stok . ']' : 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'less_than_equal_to' => '{field} melebihi stok',
                    ],
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if ($validation->run($data)) {
                $insert = $this->resepDetailModel->save($data);
                $updateStock = $this->medicineModel->removeStock($data['id_obat'], $data['jumlah']);
                if ($insert && $updateStock) {
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
        $idResep = $this->resepDetailModel->find($id)['id_resep'];
        $idObat = $this->resepDetailModel->find($id)['id_obat'];
        $jumlah = $this->resepDetailModel->find($id)['jumlah'];
        $delete = $this->resepDetailModel->delete($id);
        $updateStock = $this->medicineModel->addStock($idObat, $jumlah);
        if ($delete && $updateStock) {
            session()->setFlashdata('message', 'Data berhasil dihapus');
            return redirect()->to(base_url("resep/view/$idResep"));
        } else {
            session()->setFlashdata('message', 'Data gagal dihapus');
            return redirect()->to(base_url("resep/view/$idResep"));
        }
    }

    public function statusForm()
    {
        $id = $this->request->getVar('id');
        $data = [
            'title' => 'Resep',
            'result' => $this->resepModel->getResep($id),
        ];
        return view('resep/status_form', $data);
    }

    public function statusStore()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $data = [
                'id_resep' => $this->request->getPost('f_id_resep'),
                'status' => $this->request->getPost('f_status'),
            ];
            $validation->setRules([
                'id_resep' => [
                    'label' => 'Resep',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'status' => [
                    'label' => 'Status',
                    'rules' => 'required|in_list[Belum Selesai,Sedang Disiapkan,Sudah Selesai,Telah Diambil]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'in_list' => '{field} tidak valid',
                    ],
                ],
            ]);
            if ($validation->run($data)) {
                $insert = $this->resepModel->update($data['id_resep'], $data);
                $resep = $this->resepModel->getResep($data['id_resep']);
                if ($insert) {
                    // INSERT NOTIFICATION
                    $idRekamMedis = $this->resepModel->find($data['id_resep'])['id_rekam_medis'];
                    $idPasien = $this->rekamMedisModel->where('id_rekam_medis', $idRekamMedis)->first()['id_pasien'];

                    $patientModel = new PatientModel();
                    $idUser = $patientModel->where('id_pasien', $idPasien)->first()['id_user'];

                    $notificationModel = new NotificationModel();
                    $notificationModel->save(
                        [
                            'id_user' => $idUser,
                            'judul' => 'Resep',
                            'pesan' => 'Resep anda pada tanggal <b>' . $resep['tanggal_kunjungan'] . " " . strtolower($data['status'] . "</b>"),
                            'link' => '/resep',
                        ]
                    );
                    // END INSERT NOTIFICATION
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

    public function ajaxObat()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = $this->medicineModel->find($id);
            return json_encode($data);
        }
    }
}
