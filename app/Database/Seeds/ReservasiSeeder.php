<?php

namespace App\Database\Seeds;

use App\Models\ReservasiModel;
use CodeIgniter\Database\Seeder;

class ReservasiSeeder extends Seeder
{
    public function run()
    {
        $id = (new ReservasiModel())->insert([
            'user_id'              =>1,
            'tgl_booking'          =>'2023-04-25',
            'waktu_booking'        =>'12:00 AM',
            'status'            =>1,

        ]);
        echo "hasil id = $id";
    }
}
