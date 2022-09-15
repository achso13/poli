<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        $this->patientModel = new \App\Models\PatientModel();
        $this->appointmentModel = new \App\Models\AppointmentModel();
        $this->resepModel = new \App\Models\ResepModel();
        $this->rekamMedisModel = new \App\Models\RekamMedisModel();
    }
    public function index()
    {
        $role = session()->get('log_role');

        switch ($role) {
            case "ADMIN":
                $data = [
                    'title' => 'Dashboard Admin',
                    'menu' => 'dashboard_admin',
                    'count_pasien' => $this->patientModel->countAllResults(),
                    'count_kunjungan' => $this->appointmentModel->where("tipe_kunjungan", "Offline")->countAllResults(),
                    'count_tiket' => $this->appointmentModel->where("tipe_kunjungan", "Online")->countAllResults(),
                ];
                break;
            case "DOKTER":
                $data = [
                    'title' => 'Dashboard Dokter',
                    'menu' => 'dashboard_dokter',
                    'count_kunjungan' => $this->appointmentModel->getAppointmentCount("Offline"),
                    'count_tiket' => $this->appointmentModel->getAppointmentCount("Online"),
                ];
                break;
            case "PASIEN":
                $patientModel = new \App\Models\PatientModel();
                $idPasien = $patientModel->where('id_user', session()->get('log_id'))->first()['id_pasien'];
                $data = [
                    'title' => 'Dashboard Pasien',
                    'menu' => 'dashboard_pasien',
                    'count_kunjungan' => $this->appointmentModel->getAppointmentCount("Offline"),
                    'count_tiket' => $this->appointmentModel->getAppointmentCount("Online"),
                    'count_resep' => count($this->resepModel->getResepByPasien($idPasien)),
                    'count_treatment' => count($this->rekamMedisModel->getTreatmentSchedule())
                ];
                break;
            case "KLINIK":
                $data = [
                    'title' => 'Dashboard Klinik',
                    'menu' => 'dashboard_klinik',
                    'count_treatment' => count($this->rekamMedisModel->getTreatmentSchedule())
                ];
                break;
            case "APOTEKER":
                $data = [
                    'title' => 'Dashboard Apoteker',
                    'menu' => 'dashboard_apoteker',
                    'count_resep' => $this->resepModel->countAllResults()
                ];
                break;
        }
        // dd($data);
        return view('home/index', $data);
    }
}
