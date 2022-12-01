<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use App\Models\RekamMedisModel;
use App\Models\TreatmentModel;
use App\Models\PatientModel;
use App\Models\ResepModel;

class RekamMedis extends BaseController
{
    public function __construct()
    {
        $this->patientModel = new PatientModel();
        $this->rekamMedisModel = new RekamMedisModel();
        $this->treatmentModel = new TreatmentModel();
        $this->resepModel = new ResepModel();
    }

    public function index($id)
    {
        $data = [
            'pasien' => $this->patientModel->getPatients($id),
            'result' => $this->rekamMedisModel->getRekamMedisByPatient($id)
        ];

        if ($data['pasien'] != null) {
            return view('rekam_medis/index', $data);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan', 404);
        }
    }

    public function rekamMedisPasien()
    {
        $id = $this->patientModel->where('id_user', session()->get('log_id'))->first()['id_pasien'];
        $data = [
            'pasien' => $this->patientModel->getPatients($id),
            'result' => $this->rekamMedisModel->getRekamMedisByPatient($id)
        ];
        return view('rekam_medis/index', $data);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $data = [
                'id_pasien' => $this->request->getPost('f_id_pasien'),
                'id_dokter' => $this->request->getPost('f_id_dokter'),
                'id_treatment' => $this->request->getPost('f_id_treatment'),
                'id_kunjungan' => $this->request->getPost('f_id_kunjungan'),
                'diagnosa' => $this->request->getPost('f_diagnosa'),
                'anamnesa' => $this->request->getPost('f_anamnesa'),
                'tindakan' => $this->request->getPost('f_tindakan'),
                'resep_dokter' => $this->request->getPost('f_resep_dokter'),
                'jadwal_treatment' => $this->request->getPost('f_jadwal_treatment'),
                'tinggi_badan' => $this->request->getPost('f_tinggi_badan'),
                'berat_badan' => $this->request->getPost('f_berat_badan'),
                'alergi_obat' => $this->request->getPost('f_alergi_obat'),
            ];
            $validation->setRules([
                'id_pasien' => [
                    'label' => 'Pasien',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'id_dokter' => [
                    'label' => 'Dokter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'id_kunjungan' => [
                    'label' => 'Kunjungan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'id_treatment' => [
                    'label' => 'Treatment',
                    'rules' => 'permit_empty',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'diagnosa' => [
                    'label' => 'Diagnosa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'anamnesa' => [
                    'label' => 'Anamnesa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'resep_dokter' => [
                    'label' => 'Resep',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'jadwal_treatment' => [
                    'label' => 'Jadwal Treatment',
                    'rules' => empty($data['id_treatment']) ?  'permit_empty' : 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'tinggi_badan' => [
                    'label' => 'Tinggi Badan',
                    'rules' => 'permit_empty|numeric|greater_than[0]|max_length[7]',
                    'errors' => [
                        'numeric' => '{field} harus berupa angka',
                        'greater_than' => '{field} harus lebih besar dari 0',
                        'max_length' => '{field} maksimal 7 karakter',
                    ],
                ],
                'berat_badan' => [
                    'label' => 'Berat Badan',
                    'rules' => 'permit_empty|numeric|greater_than[0]|max_length[7]',
                    'errors' => [
                        'numeric' => '{field} harus berupa angka',
                        'greater_than' => '{field} harus lebih besar dari 0',
                        'max_length' => '{field} maksimal 7 karakter',
                    ],
                ],
                'alergi_obat' => [
                    'label' => 'Alergi Obat',
                    'rules' => 'permit_empty',
                ],
            ]);
            if ($validation->run($data)) {
                $dataRekamMedis = [
                    'id_pasien' => $data['id_pasien'],
                    'id_dokter' => $data['id_dokter'],
                    'id_treatment' => $data['id_treatment'],
                    'id_kunjungan' => $data['id_kunjungan'],
                    'diagnosa' => $data['diagnosa'],
                    'anamnesa' => $data['anamnesa'],
                    'jadwal_treatment' => $data['jadwal_treatment'],
                    'tinggi_badan' => $data['tinggi_badan'],
                    'berat_badan' => $data['berat_badan'],
                    'alergi_obat' => $data['alergi_obat'],
                ];

                if ($dataRekamMedis['id_treatment'] == NULL) {
                    unset($dataRekamMedis['id_treatment']);
                }

                $insertRekamMedis = $this->rekamMedisModel->save($dataRekamMedis);

                $idRekamMedis = $this->rekamMedisModel->insertID();
                $dataResep = [
                    'id_rekam_medis' => $idRekamMedis,
                    'resep_dokter' => $data['resep_dokter'],
                    'status' => 'Belum Selesai'
                ];

                $insertResep = $this->resepModel->save($dataResep);

                $appointmentModel = new AppointmentModel();
                $appointmentModel->update($data['id_kunjungan'], ['status' => 'Selesai']);

                if ($insertRekamMedis && $insertResep) {
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

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $data = [
                'id_pasien' => $this->request->getPost('f_id_pasien'),
                'id_dokter' => $this->request->getPost('f_id_dokter'),
                'id_treatment' => $this->request->getPost('f_id_treatment'),
                'id_kunjungan' => $this->request->getPost('f_id_kunjungan'),
                'diagnosa' => $this->request->getPost('f_diagnosa'),
                'anamnesa' => $this->request->getPost('f_anamnesa'),
                'tindakan' => $this->request->getPost('f_tindakan'),
                'resep_dokter' => $this->request->getPost('f_resep_dokter'),
                'jadwal_treatment' => $this->request->getPost('f_jadwal_treatment'),
                'tinggi_badan' => $this->request->getPost('f_tinggi_badan'),
                'berat_badan' => $this->request->getPost('f_berat_badan'),
                'alergi_obat' => $this->request->getPost('f_alergi_obat'),
            ];

            $validation->setRules([
                'id_pasien' => [
                    'label' => 'Pasien',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'id_dokter' => [
                    'label' => 'Dokter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'id_kunjungan' => [
                    'label' => 'Kunjungan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'id_treatment' => [
                    'label' => 'Treatment',
                    'rules' => 'permit_empty',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'diagnosa' => [
                    'label' => 'Diagnosa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'anamnesa' => [
                    'label' => 'Anamnesa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'resep_dokter' => [
                    'label' => 'Resep',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'jadwal_treatment' => [
                    'label' => 'Jadwal Treatment',
                    'rules' => empty($data['id_treatment']) ?  'permit_empty' : 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
                'tinggi_badan' => [
                    'label' => 'Tinggi Badan',
                    'rules' => 'permit_empty|numeric|greater_than[0]|max_length[7]',
                    'errors' => [
                        'numeric' => '{field} harus berupa angka',
                        'greater_than' => '{field} harus lebih besar dari 0',
                        'max_length' => '{field} maksimal 7 karakter',
                    ],
                ],
                'berat_badan' => [
                    'label' => 'Berat Badan',
                    'rules' => 'permit_empty|numeric|greater_than[0]|max_length[7]',
                    'errors' => [
                        'numeric' => '{field} harus berupa angka',
                        'greater_than' => '{field} harus lebih besar dari 0',
                        'max_length' => '{field} maksimal 7 karakter',
                    ],
                ],
                'alergi_obat' => [
                    'label' => 'Alergi Obat',
                    'rules' => 'permit_empty',
                ],

            ]);
            if ($validation->run($data)) {
                $idRekamMedis = $this->request->getPost('f_id_rekam_medis');

                $dataRekamMedis = [
                    'id_pasien' => $data['id_pasien'],
                    'id_dokter' => $data['id_dokter'],
                    'id_treatment' => $data['id_treatment'],
                    'id_kunjungan' => $data['id_kunjungan'],
                    'diagnosa' => $data['diagnosa'],
                    'anamnesa' => $data['anamnesa'],
                    'jadwal_treatment' => $data['jadwal_treatment'],
                    'tinggi_badan' => $data['tinggi_badan'],
                    'berat_badan' => $data['berat_badan'],
                    'alergi_obat' => $data['alergi_obat'],
                ];
                var_dump($dataRekamMedis);

                $updateRekamMedis = $this->rekamMedisModel->update($idRekamMedis, $dataRekamMedis);

                $dataResep = [
                    'resep_dokter' => $data['resep_dokter'],
                ];

                $updateResep = $this->resepModel
                    ->where('id_rekam_medis', $idRekamMedis)
                    ->set($dataResep)
                    ->update();

                $appointmentModel = new AppointmentModel();
                $appointmentModel->update($data['id_kunjungan'], ['status' => 'Selesai']);

                if ($updateRekamMedis && $updateResep) {
                    session()->setFlashdata('message', 'Data berhasil diperbarui');
                    $result['error'] = false;
                    $result['message'] = 'Data berhasil diperbarui';
                } else {
                    $result['error'] = true;
                    $result['message'] = 'Data gagal diperbarui';
                }
                return $this->response->setJSON($result);
            } else {
                $result['error'] = true;
                $result['message'] = $validation->getErrors();
                return $this->response->setJSON($result);
            }
        }
    }

    public function treatmentSchedule()
    {
        $data = [
            'result' => $this->rekamMedisModel->getTreatmentSchedule(),
        ];

        return view('treatment_schedule/index', $data);
    }

    public function viewTreatmentSchedule($id)
    {
        $data = [
            'result' => $this->rekamMedisModel->getTreatmentSchedule($id),
        ];

        if ($data['result']) {
            return view('treatment_schedule/view', $data);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan', 404);
        }

        return view('treatment_schedule/view', $data);
    }

    public function storeTreatmentSchedule()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $data = [
                'id_rekam_medis' => $this->request->getPost('f_id_rekam_medis'),
                'hasil_treatment' => $this->request->getPost('f_hasil_treatment'),
            ];
            $validation->setRules([
                'hasil_treatment' => [
                    'label' => 'Catatan Klinik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                    ],
                ],
            ]);

            if ($validation->run($data)) {
                $insert = $this->rekamMedisModel->update($data['id_rekam_medis'], $data);
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
}
