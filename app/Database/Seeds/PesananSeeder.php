<?php

namespace App\Database\Seeds;

use App\Models\PesananModel;
use CodeIgniter\Database\Seeder;

class PesananSeeder extends Seeder
{
    public function run()
    {
        $id = (new PesananModel())->insert([
            'no_pesan'              => '001',
            'pelanggan_id'          =>1,
            'alamat'                =>'tanjung raya 2',
        ]);
        echo "hasil id = $id";
    }
}
