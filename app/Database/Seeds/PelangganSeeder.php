<?php

namespace App\Database\Seeds;

use App\Models\PelangganModel;
use CodeIgniter\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        $id = (new PelangganModel())->insert([
            'nama'      => 'Pelanggan',
            'gender'    => 'P',
            'alamat'    => 'jl Tanjung Raya 2',
            'email'     =>'dfusionxx@gmail.com',
            'sandi'     => password_hash('123456', PASSWORD_BCRYPT),
            'nohp'     => '085849999627',
        ]);
        echo "hasil id = $id";
    }
}
