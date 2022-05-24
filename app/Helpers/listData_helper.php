<?php


function listDepartement($filter = NULL)
{
    $departementModel = new \App\Models\DepartementModel();
    if ($filter == NULL) {
        $departement = $departementModel->findAll();
    } else {
        $departement = $departementModel->find($filter);
    }
    return $departement;
}

function listDoctor($filter = NULL)
{
    $doctorModel = new \App\Models\DokterModel();
    if ($filter == NULL) {
        $doctor = $doctorModel->findAll();
    } else {
        $doctor = $doctorModel->find($filter);
    }
    return $doctor;
}
