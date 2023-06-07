<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MejaCustomerController extends BaseController
{
    public function index()
    {
        return view('Customer/Meja/table');
    }
}
