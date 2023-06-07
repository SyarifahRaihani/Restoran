<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class MenuCustomerController extends BaseController
{
    public function index()
    {
        return view('Customer/Menu/table', [
            'kategori' => (new KategoriModel())->findAll()
        ]);
    }
}
