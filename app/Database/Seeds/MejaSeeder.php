<?php

namespace App\Database\Seeds;

use App\Models\MejaModel;
use CodeIgniter\Database\Seeder;

class MejaSeeder extends Seeder
{
    public function run()
    {
        $id = (new MejaModel())->insert([
            'meja'         =>'Meja Krusi',
            'kapasitas'         =>'4',
            'status'            =>1,
        ]);
        echo "hasil id = $id";
    }
}
