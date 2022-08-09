<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;

class Appointment extends BaseController
{
    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel;
    }

    public function index()
    {
    }

    public function add()
    {
        return view('appointment/add');
    }

    public function store()
    {
    }

    public function edit()
    {
        return view('appointment/edit');
    }

    public function update()
    {
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
