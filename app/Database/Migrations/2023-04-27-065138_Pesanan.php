<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pesanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'user_id'       => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],
            'menu_id'       => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],
            'menu_id'       => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],
            'tgl_pesan'     => [ 'type'=> 'date', 'null'=>true ],
            'total'         => ['type'=>'double','null'=>true],
            'bayar'         =>['type'=>'double','null'=>true],
            'kembali'       =>['type'=>'double','null'=>true],
            'alamat'        => [ 'type'=>'varchar', 'constraint'=>255, 'null'=>false],
            'status'        => [ 'type' => 'int', 'constraint'=>2, 'null'=>true ],
            'created_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'    => [ 'type' => 'datetime', 'null'=>true ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'user', 'id', 'cascade');
        $this->forge->addForeignKey('menu_id', 'menu', 'id', 'cascade');
        $this->forge->createTable('pesanan');
    }

    public function down()
    {
        $this->forge->dropTable('pesanan');
    }
}
