<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\PatientModel;
use App\Models\RekamMedisModel;
use App\Models\TreatmentModel;

class Appointment extends BaseController
{
    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel;
        $this->doctorModel = new DoctorModel();
        $this->patientModel = new PatientModel();
        $this->rekamMedisModel = new RekamMedisModel();
        $this->treatmentModel = new TreatmentModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kunjungan',
            'result' => $this->appointmentModel->getAppointments(),
        ];
        return view('appointment/index', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Appointment',
            'dokter' => $this->doctorModel->getDoctors(),
        ];

        if (session()->get('log_role') === 'PASIEN') {
            $data['pasien'] = $this->patientModel->where('id_user', session()->get('log_id'))->first();
        } else {
            $data['pasien'] = $this->patientModel->findAll();
        }
        return view('appointment/form', $data);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $data = [
                'id_dokter' => $this->request->getPost('f_id_dokter'),
                'id_pasien' => $this->request->getPost('f_id_pasien'),
                'id_jadwal_dokter' => $this->request->getPost('f_id_jadwal_dokter'),
                'tanggal_kunjungan' => $this->request->getPost('f_tanggal_kunjungan'),
                'keluhan' => $this->request->getPost('f_keluhan'),
            ];

            $validation->setRules([
                'id_dokter' => [
                    'label' => 'Dokter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'id_pasien' => [
                    'label' => 'Pasien',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'tanggal_kunjungan' => [
                    'label' => 'Tanggal Kunjungan',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'valid_date' => '{field} harus berupa tanggal yang valid',
                    ],
                ],
                'id_jadwal_dokter' => [
                    'label' => 'Jadwal Dokter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
                'keluhan' => [
                    'label' => 'Keluhan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
            ]);


            if ($validation->run($data)) {
                $data['id_kunjungan'] = generateAppointmentId($this->appointmentModel, 'id_kunjungan', 'K', 12, $data['tanggal_kunjungan']);
                $insert = $this->appointmentModel->save($data);
                if ($insert) {
                    session()->setFlashdata('message', 'Data berhasil disimpan');
                    $result['error'] = false;
                    $result['message'] = 'Data berhasil disimpan';
                } else {
                    $result['error'] = true;
                    $result['message'] = 'Data gagal disimpan';
                }
            } else {
                $result['error'] = true;
                $result['message'] = $validation->getErrors();
            }
            return $this->response->setJSON($result);
        }
    }

    public function view($id)
    {
        $data = [
            'title' => 'Appointment',
            'result' => $this->appointmentModel->getAppointments($id),
            'rekamMedis' => $this->rekamMedisModel->getRekamMedisByKunjungan($id),
            'treatment' => $this->treatmentModel->getTreatments(),
        ];
        if (session()->get('log_role') === "PASIEN") {
            $idPasien = $this->patientModel->where('id_user', session()->get('log_id'))->first()['id_pasien'];

            if ($data['result']['id_pasien'] != $idPasien) {
                session()->setFlashdata('message', 'Anda tidak diperkenankan mengakses data ini');
                return redirect()->to(base_url('appointment'));
            }
        }

        return view('appointment/view', $data);
    }

    public function status($status, $id)
    {
        $data = [
            'status' => ucfirst($status),
        ];

        if ($status !== 'open' && $status !== 'close') {
            session()->setFlashdata('message', 'Status tidak valid');
            return redirect()->to(base_url('appointment'));
        }

        $update = $this->appointmentModel->update($id, $data);
        if ($update) {
            session()->setFlashdata('message', 'Status berhasil diubah');
            return redirect()->to(base_url('appointment'));
        } else {
            session()->setFlashdata('message', 'Status gagal diubah');
            return redirect()->to(base_url('appointment'));
        }
    }

    public function delete($id)
    {
        $delete = $this->treatmentModel->delete($id);
        if ($delete) {
            session()->setFlashdata('message', 'Hapus data berhasil');
            return redirect()->to(base_url('appointment'));
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException;
        }
    }
}
