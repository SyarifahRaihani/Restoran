<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pesanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'no_pesan'      => [ 'type'=>'varchar', 'constraint'=>255, 'null'=>false],
            'pelanggan_id'  => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],
            'tgl_pesan'     => [ 'tyoe'=> 'date', 'null'=>true ],
            'alamat'    => [ 'type'=>'varchar', 'constraint'=>255, 'null'=>false],
            'created_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'    => [ 'type' => 'datetime', 'null'=>true ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('pelanggan_id', 'pelanggan', 'id', 'cascade');
        $this->forge->createTable('pesanan');
    }

    public function down()
    {
        $this->forge->dropTable('pesanan');
    }
}
