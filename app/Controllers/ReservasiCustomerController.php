<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MejaModel;

class ReservasiCustomerController extends BaseController
{
    public function index()
    {
        return view('Customer/Reservasi/table', [
            'user' => (new UserModel())->findAll(),
            'meja' => (new MejaModel())->findAll()
        ]);
    }
}
