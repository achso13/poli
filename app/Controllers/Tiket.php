<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\PatientModel;
use App\Models\PesanModel;

class Tiket extends BaseController
{
    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->doctorModel = new DoctorModel();
        $this->patientModel = new PatientModel();
        $this->pesanModel = new PesanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kunjungan',
            'result' => $this->appointmentModel->getAppointments(NULL, "Online"),
        ];

        return view('tiket/index', $data);
    }

    public function form()
    {
        $data = [
            'title' => 'Tiket',
            'dokter' => $this->doctorModel->getDoctors(),
        ];

        if (session()->get('log_role') === 'PASIEN') {
            $data['pasien'] = $this->patientModel->where('id_user', session()->get('log_id'))->first();
        } else {
            $data['pasien'] = $this->patientModel->findAll();
        }

        return view('tiket/form', $data);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $data = [
                'id_dokter' => $this->request->getPost('f_id_dokter'),
                'id_pasien' => $this->request->getPost('f_id_pasien'),
                'tanggal_kunjungan' => date('Y-m-d'),
                'keluhan' => $this->request->getPost('f_keluhan'),
                'tipe_kunjungan' => 'Online',
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
                'keluhan' => [
                    'label' => 'Keluhan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
            ]);


            if ($validation->run($data)) {
                $data['id_kunjungan'] = generateAppointmentId($this->appointmentModel, 'id_kunjungan', 'K', 14, $data['tanggal_kunjungan'], "Online");
                $insert = $this->appointmentModel->save($data);

                // Get id user doctor
                $doctor = $this->doctorModel->getDoctors($data['id_dokter']);

                if ($insert) {
                    session()->setFlashdata('message', 'Data berhasil disimpan');
                    $result['error'] = false;
                    $result['message'] = 'Data berhasil disimpan';

                    // INSERT NOTIFICATION TABLE
                    $notificationModel = new \App\Models\NotificationModel();
                    $notificationModel->insert([
                        'id_user' => $doctor['id_user'],
                        'judul' => 'Konsultasi Online',
                        'pesan' => 'Ada konsultasi online baru dengan id <b>#' . $data['id_kunjungan'] . '</b> dari pasien <b>#' . $data['id_pasien'] . '</b>',
                        'link' => '/tiket/view/' . $data['id_kunjungan'],
                        'is_read' => 0,
                    ]);
                    // END INSERT NOTIFICATION TABLE

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
            'result' => $this->appointmentModel->getAppointments($id, "Online"),
            'pesan' => $this->pesanModel->getPesan($id),
        ];

        if ($data['result'] == NULL) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan', 404);
        }

        $data['pasien'] = $this->patientModel->getPatients($data['result']['id_pasien']);


        return view('tiket/view', $data);
    }

    public function status($status, $id)
    {
        $data = [
            'status' => ucfirst($status),
        ];

        if ($status !== 'aktif' && $status !== 'selesai') {
            session()->setFlashdata('message', 'Status tidak valid');
            return redirect()->to(base_url('tiket'));
        }

        $update = $this->appointmentModel->update($id, $data);
        if ($update) {
            session()->setFlashdata('message', 'Status berhasil diubah');
            return redirect()->to(base_url('tiket'));
        } else {
            session()->setFlashdata('message', 'Status gagal diubah');
            return redirect()->to(base_url('tiket'));
        }
    }

    public function form_comment()
    {
        $data = [
            'title' => 'Komentar',
            'result' => $this->appointmentModel->getAppointments($this->request->getPost('js_id'), "Online"),
        ];
        return view('tiket/form_comment', $data);
    }

    public function store_comment()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $data = [
                'id_user' => session()->get('log_id'),
                'id_kunjungan' => $this->request->getPost('f_id_kunjungan'),
                'pesan' => $this->request->getPost('f_pesan'),
            ];
            $validation->setRules([
                'pesan' => [
                    'label' => 'Pesan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ],
                ],
            ]);
            if ($validation->run($data)) {
                $insert = $this->pesanModel->save($data);


                if ($insert) {
                    session()->setFlashdata('message', 'Pesan berhasil ditambahkan');
                    $result['error'] = false;
                    $result['message'] = 'Pesan berhasil ditambahkan';
                } else {
                    $result['error'] = true;
                    $result['message'] = 'Pesan gagal ditambahkan';
                }
            } else {
                $result['error'] = true;
                $result['message'] = $validation->getErrors();
            }
            return $this->response->setJSON($result);
        }
    }

    public function load_comment()
    {
        return view('tiket/load_comment');
    }
}
