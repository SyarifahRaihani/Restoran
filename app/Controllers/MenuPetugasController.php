<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class MenuPetugasController extends BaseController
{
    public function index()
    {
        return view('Petugas/Menu/table', [
            'kategori' => (new KategoriModel())->findAll()
        ]);
    }
}
