<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\PesananModel;
use App\Models\UserModel;

class PesananCustomerController extends BaseController
{
    public function index()
    {
        return view('Customer/Pesanan/table', [
            'user' => (new UserModel())->findAll(),
            'menu' => (new MenuModel())->findAll()            
        ]);
    }
}
