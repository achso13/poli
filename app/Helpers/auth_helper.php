<?php
function getLoggedInUser()
{
    $userModel = new \App\Models\UserModel;
    $user = $userModel->find(session()->get('log_id'));

    session()->set(
        [
            'log_role' => $user['id_role'],
            'log_fullname' => $user['fullname'],
            'log_departement' => $user['id_clinic'],
            'log_photo' => $user['photo'],
        ]
    );
}
