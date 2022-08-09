<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnitKerjaModel;
use App\Models\BiroModel;

class UnitKerja extends BaseController
{
    public function __construct()
    {
        $this->unitKerjaModel = new UnitKerjaModel();
        $this->biroModel = new BiroModel();
    }

    public function ajaxBagian($idBiro)
    {
        $data = $this->unitKerjaModel
            ->where('id_biro', $idBiro)
            ->findAll();
        return json_encode($data);
    }

    public function ajaxBiro()
    {
        $data = $this->biroModel->findAll();

        return json_encode($data);
    }
}
