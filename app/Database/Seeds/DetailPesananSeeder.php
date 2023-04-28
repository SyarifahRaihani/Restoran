<?php

namespace App\Database\Seeds;

use App\Models\DetailPesananModel;
use CodeIgniter\Database\Seeder;

class DetailPesananSeeder extends Seeder
{
    public function run()
    {
        $id = (new DetailPesananModel())->insert([
            'produk_id'          => 1,
            'harga_jual'         =>'20000',
            'jumlah'             =>'2',
        ]);
        echo "hasil id = $id";
    }
}
