<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Reservasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'no_reservasi'  => ['type'=>'varchar', 'constraint'=>255, 'null'=>false ],
            'pelanggan_id'  => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],
            'tgl_booking'   => [ 'type'=>'date', 'null'=>true ],
            'waktu_booking' => [ 'type'=>'time', 'null'=>true],
            'created_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'    => [ 'type' => 'datetime', 'null'=>true ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('pelanggan_id', 'pelanggan', 'id', 'cascade');
        $this->forge->createTable('reservasi');
    }

    public function down()
    {
        $this->forge->dropTable('reservasi');
    }
}
