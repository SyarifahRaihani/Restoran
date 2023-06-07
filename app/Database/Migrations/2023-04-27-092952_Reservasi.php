<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Reservasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'user_id'        => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],            'tgl_booking'   => [ 'type'=>'date', 'null'=>true ],
            'waktu_booking' => [ 'type'=>'time', 'null'=>true],
            'meja_id'       => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],
            'status'        => [ 'type' => 'int', 'constraint'=>2, 'null'=>true ],
            'created_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'    => [ 'type' => 'datetime', 'null'=>true ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'user', 'id', 'cascade');
        $this->forge->addForeignKey('meja_id', 'meja', 'id', 'cascade');

        $this->forge->createTable('reservasi');
    }

    public function down()
    {
        $this->forge->dropTable('reservasi');
    }
}
