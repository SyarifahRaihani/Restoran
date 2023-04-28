<?php

namespace App\Database\Seeds;

use App\Models\MejaModel;
use CodeIgniter\Database\Seeder;

class MejaSeeder extends Seeder
{
    public function run()
    {
        $id = (new MejaModel())->insert([
            'nama_meja'         =>'makanan Kuah',
            'no_meja'           =>'01',
            'kapasitas'         =>'4',
            'status'            =>'T',
            'ruangan_id'        =>1,
        ]);
        echo "hasil id = $id";
    }
}
