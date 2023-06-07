<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\PesananModel;
use App\Models\UserModel;

class PesananPetugasController extends BaseController
{
    public function index()
    {
        return view('Petugas/Pesanan/table', [
            'user' => (new UserModel())->findAll(),
            'menu' => (new MenuModel())->findAll()            
        ]);
    }
}
