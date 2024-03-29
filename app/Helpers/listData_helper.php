<?php


function listClinic($filter = NULL)
{
    $clinicModel = new \App\Models\ClinicModel();
    if ($filter == NULL) {
        $clinic = $clinicModel->findAll();
    } else {
        $clinic = $clinicModel->find($filter);
    }
    return $clinic;
}

function listDoctor($filter = NULL)
{
    $doctorModel = new \App\Models\DoctorModel;
    if ($filter == NULL) {
        $doctor = $doctorModel->findAll();
    } else {
        $doctor = $doctorModel->find($filter);
    }
    return $doctor;
}

function countAge($birthdate)
{
    $birthdate = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $today->diff($birthdate);
    return $age->y;
}
