<?php

namespace App\Database\Seeds;

use App\Models\PesananModel;
use CodeIgniter\Database\Seeder;

class PesananSeeder extends Seeder
{
    public function run()
    {
        $id = (new PesananModel())->insert([
            'user_id'               =>1,
            'tgl_pesan'                =>'2023-04-25',
            'menu_id'                  =>1,
            'total'                     =>'',
            'bayar'                     =>'',
            'kembali'                   =>'',
            'status'            =>1,
        ]);
        echo "hasil id = $id";
    }
}
