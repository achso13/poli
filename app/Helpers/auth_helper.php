<?php
function getLoggedInUser()
{
    $userModel = new \App\Models\UserModel;
    $user = $userModel->find(session()->get('log_id'));

    session()->set(
        [
            'log_role' => $user['role'],
            'log_nama' => $user['nama'],
            'log_departement' => $user['id_klinik'],
            'log_photo' => $user['photo'],
        ]
    );
}
