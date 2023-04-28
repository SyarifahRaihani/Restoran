<?php

namespace App\Database\Seeds;

use App\Models\ReservasiModel;
use CodeIgniter\Database\Seeder;

class ReservasiSeeder extends Seeder
{
    public function run()
    {
        $id = (new ReservasiModel())->insert([
            'no_reservasi'         => '001',
            'pelanggan_id'         =>1,
            'tgl_booking'          =>'2023-04-25',
            'waktu_booking'        =>'16:00',
        ]);
        echo "hasil id = $id";
    }
}
