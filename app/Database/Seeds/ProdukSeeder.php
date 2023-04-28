<?php

namespace App\Database\Seeds;

use App\Models\ProdukModel;
use CodeIgniter\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $id = (new ProdukModel())->insert([
            'kode'       => 'stb01',
            'nama'       => 'Soto Betawi',
            'deskripsi'         =>'Soto betawi berasal dari jakarta',
            'kategori_id' =>1,
            'status'            => 'T',
            'harga_jual'        => '30000',
            'diskon'            => '3000',
            'harga_standar'     => '27000',
            'foto'              =>'',
            'terjual'           => '100'
        ]);
        echo "hasil id = $id";
    }
}
