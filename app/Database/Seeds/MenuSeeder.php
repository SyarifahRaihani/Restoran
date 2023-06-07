<?php

namespace App\Database\Seeds;

use App\Models\MenuModel;
use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $id = (new MenuModel())->insert([
            'nama'          => 'Soto Betawi',
            'kategori_id'   =>1,
            'status'        => 'T',
            'harga'    => '30000',
            'foto'          =>'',
            'terjual'       => '100'
        ]);
        echo "hasil id = $id";
    }
}
