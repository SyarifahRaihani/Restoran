<?php

namespace App\Database\Seeds;

use App\Models\RuanganModel;
use CodeIgniter\Database\Seeder;

class RuanganSeeder extends Seeder
{
    public function run()
    {
        $id = (new RuanganModel())->insert([
            'nama_ruangan'       => 'VIP',
            'deskripsi'         =>'Ruangan VIP',
        ]);
        echo "hasil id = $id";
    }
}
