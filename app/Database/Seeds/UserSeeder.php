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
            'email'     =>'syfraihanihinduan@gmail.com',
            'sandi'     => password_hash('123456', PASSWORD_BCRYPT),
            'nohp'      => '085849999627',
            'level'     => 'admin',
        ]);
        echo "hasil id = $id";
    }
}
