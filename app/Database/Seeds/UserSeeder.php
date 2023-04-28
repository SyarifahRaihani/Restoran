<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $id = (new UserModel())->insert([
            'nama'      => 'Administrator',
            'gender'    => 'P',
            'email'     =>'syfraihanihinduan@gmail.com',
            'sandi'     => password_hash('123456', PASSWORD_BCRYPT),
            'level'     => 'A',
        ]);
        echo "hasil id = $id";
    }
}
