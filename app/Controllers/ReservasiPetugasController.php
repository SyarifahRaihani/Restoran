<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MejaModel;

class ReservasiPetugasController extends BaseController
{
    public function index()
    {
        return view('Petugas/Reservasi/table', [
            'user' => (new UserModel())->findAll(),
            'meja' => (new MejaModel())->findAll()
        ]);
    }
}
